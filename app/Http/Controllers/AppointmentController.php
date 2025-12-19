<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreAppointmentRequest;
use App\Services\AppointmentService;
use App\Services\DoctorService;
use App\Services\PatientService;
use Illuminate\Http\Request;

class AppointmentController extends Controller
{
    public function __construct(
        private AppointmentService $appointmentService,
        private DoctorService $doctorService,
        private PatientService $patientService
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
        
        $patients = collect([]);
        if (auth()->user()->isAdmin() || auth()->user()->isReceptionist()) {
            $patients = $this->patientService->getAllPatients(['per_page' => 100])->items();
        }

        return view('appointments.create', compact('doctors', 'patients'));
    }

    public function store(StoreAppointmentRequest $request)
    {
        try {
            // If patient is creating, use their patient_id
            if (auth()->user()->isPatient()) {
                $patient = auth()->user()->patient;
                if (!$patient) {
                    return back()->withErrors(['error' => 'Patient profile not found.'])->withInput();
                }
                $request->merge(['patient_id' => $patient->id]);
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
}

