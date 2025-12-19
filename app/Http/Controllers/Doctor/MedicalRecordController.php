<?php

namespace App\Http\Controllers\Doctor;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreMedicalRecordRequest;
use App\Services\MedicalRecordService;
use App\Services\PatientService;
use App\Services\AppointmentService;
use Illuminate\Http\Request;

class MedicalRecordController extends Controller
{
    public function __construct(
        private MedicalRecordService $medicalRecordService,
        private PatientService $patientService,
        private AppointmentService $appointmentService
    ) {
        $this->middleware(['auth', 'role:doctor']);
    }

    public function index(Request $request)
    {
        $doctor = auth()->user()->doctor;
        $filters = array_merge($request->only(['patient_id', 'per_page']), ['doctor_id' => $doctor->id]);
        
        $records = $this->medicalRecordService->getAllMedicalRecords($filters);
        $patients = $this->patientService->getAllPatients(['per_page' => 100])->items();

        return view('doctor.medical-records.index', compact('records', 'patients'));
    }

    public function create(Request $request)
    {
        $patients = $this->patientService->getAllPatients(['per_page' => 100])->items();
        $appointmentId = $request->get('appointment_id');
        $appointment = $appointmentId ? $this->appointmentService->getAppointmentById($appointmentId) : null;

        return view('doctor.medical-records.create', compact('patients', 'appointment'));
    }

    public function store(StoreMedicalRecordRequest $request)
    {
        try {
            $doctor = auth()->user()->doctor;
            $data = array_merge($request->validated(), ['doctor_id' => $doctor->id]);
            
            $this->medicalRecordService->createMedicalRecord($data);
            return redirect()->route('doctor.medical-records.index')
                ->with('success', 'Medical record created successfully.');
        } catch (\Exception $e) {
            return back()->withErrors(['error' => $e->getMessage()])->withInput();
        }
    }

    public function show(int $id)
    {
        $record = $this->medicalRecordService->getMedicalRecordById($id);
        if (!$record) {
            abort(404);
        }

        // Verify doctor owns this record
        if ($record->doctor_id !== auth()->user()->doctor->id) {
            abort(403);
        }

        return view('doctor.medical-records.show', compact('record'));
    }
}

