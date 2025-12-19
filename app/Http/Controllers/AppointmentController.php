<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreAppointmentRequest;
use App\Services\AppointmentService;
use App\Services\DoctorService;
use App\Services\PatientService;
use App\Services\DepartmentService;
use App\Services\DoctorRecommendationService;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;

class AppointmentController extends Controller
{
    public function __construct(
        private AppointmentService $appointmentService,
        private DoctorService $doctorService,
        private PatientService $patientService,
        private DepartmentService $departmentService,
        private DoctorRecommendationService $doctorRecommendationService
    ) {
        $this->middleware('auth');
    }

    public function index(Request $request)
    {
        $filters = $request->only(['status', 'doctor_id', 'patient_id', 'date', 'per_page']);
        
        // Filter by role
        if (auth()->user()->isDoctor()) {
            $doctor = auth()->user()->doctor;
            if ($doctor) {
                $filters['doctor_id'] = $doctor->id;
            }
        } elseif (auth()->user()->isPatient()) {
            $patient = auth()->user()->patient;
            if ($patient) {
                $filters['patient_id'] = $patient->id;
            }
        }

        $appointments = $this->appointmentService->getAllAppointments($filters);
        
        // Get doctors for admin/receptionist
        $doctors = collect([]);
        if (auth()->user()->isAdmin() || auth()->user()->isReceptionist()) {
            $doctors = $this->doctorService->getAvailableDoctors();
        }

        return view('appointments.index', compact('appointments', 'doctors'));
    }

    public function create()
    {
        $doctors = $this->doctorService->getAvailableDoctors();
        $departments = $this->departmentService->getActiveDepartments();
        
        $patients = collect([]);
        if (auth()->user()->isAdmin() || auth()->user()->isReceptionist()) {
            $patients = $this->patientService->getAllPatients(['per_page' => 100])->items();
        }

        return view('appointments.create', compact('doctors', 'patients', 'departments'));
    }

    public function store(StoreAppointmentRequest $request)
    {
        try {
            // Patient ID is already set in StoreAppointmentRequest::prepareForValidation()
            // Just validate that patient exists if user is a patient
            if (auth()->user()->isPatient()) {
                $patient = auth()->user()->patient;
                if (!$patient) {
                    return back()->withErrors(['error' => 'Patient profile not found.'])->withInput();
                }
            }

            $this->appointmentService->createAppointment($request->validated());
            return redirect()->route('appointments.index')
                ->with('success', 'Appointment booked successfully.');
        } catch (\Exception $e) {
            return back()->withErrors(['error' => $e->getMessage()])->withInput();
        }
    }

    public function show(int $id)
    {
        $appointment = $this->appointmentService->getAppointmentById($id);
        if (!$appointment) {
            abort(404);
        }

        // Check authorization
        if (auth()->user()->isDoctor()) {
            $doctor = auth()->user()->doctor;
            if ($doctor && $appointment->doctor_id !== $doctor->id) {
                abort(403);
            }
        }
        if (auth()->user()->isPatient()) {
            $patient = auth()->user()->patient;
            if ($patient && $appointment->patient_id !== $patient->id) {
                abort(403);
            }
        }

        return view('appointments.show', compact('appointment'));
    }

    public function update(Request $request, int $id)
    {
        $request->validate([
            'appointment_date' => 'sometimes|date|after_or_equal:today',
            'appointment_time' => 'sometimes|date_format:H:i',
            'status' => 'sometimes|in:pending,confirmed,completed,cancelled',
            'reason' => 'nullable|string',
            'notes' => 'nullable|string',
        ]);

        try {
            $this->appointmentService->updateAppointment($id, $request->all());
            return redirect()->route('appointments.index')
                ->with('success', 'Appointment updated successfully.');
        } catch (\Exception $e) {
            return back()->withErrors(['error' => $e->getMessage()])->withInput();
        }
    }

    public function cancel(int $id)
    {
        try {
            $this->appointmentService->cancelAppointment($id);
            return redirect()->route('appointments.index')
                ->with('success', 'Appointment cancelled successfully.');
        } catch (\Exception $e) {
            return back()->withErrors(['error' => $e->getMessage()]);
        }
    }

    public function complete(int $id)
    {
        try {
            $this->appointmentService->completeAppointment($id);
            return redirect()->route('appointments.index')
                ->with('success', 'Appointment marked as completed.');
        } catch (\Exception $e) {
            return back()->withErrors(['error' => $e->getMessage()]);
        }
    }

    /**
     * Get recommended doctor via AJAX
     */
    public function getRecommendedDoctor(Request $request): JsonResponse
    {
        $request->validate([
            'department_id' => 'required|exists:departments,id',
            'appointment_date' => 'required|date|after_or_equal:today',
            'appointment_time' => 'required|date_format:H:i',
        ]);

        try {
            $recommendedDoctor = $this->doctorRecommendationService->recommendDoctor(
                $request->department_id,
                $request->appointment_date,
                $request->appointment_time
            );

            if ($recommendedDoctor) {
                return response()->json([
                    'success' => true,
                    'doctor' => [
                        'id' => $recommendedDoctor->id,
                        'name' => $recommendedDoctor->user ? $recommendedDoctor->user->name : 'Doctor #' . $recommendedDoctor->id,
                        'specialization' => $recommendedDoctor->specialization,
                        'experience_years' => $recommendedDoctor->experience_years,
                    ],
                    'message' => 'Doctor recommended successfully.',
                ]);
            } else {
                return response()->json([
                    'success' => false,
                    'message' => 'No doctors available for the selected criteria.',
                ]);
            }
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => $e->getMessage(),
            ], 500);
        }
    }
}

