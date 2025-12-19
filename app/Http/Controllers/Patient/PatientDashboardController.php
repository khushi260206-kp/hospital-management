<?php

namespace App\Http\Controllers\Patient;

use App\Http\Controllers\Controller;
use App\Services\AppointmentService;
use App\Services\MedicalRecordService;
use App\Services\BillService;
use Illuminate\Http\Request;

class PatientDashboardController extends Controller
{
    public function __construct(
        private AppointmentService $appointmentService,
        private MedicalRecordService $medicalRecordService,
        private BillService $billService
    ) {
        $this->middleware(['auth', 'role:patient']);
    }

    public function dashboard()
    {
        $patient = auth()->user()->patient;
        
        $stats = [
            'upcoming_appointments' => $this->appointmentService->getAppointmentsByPatient(
                $patient->id,
                ['status' => 'confirmed', 'per_page' => 1000]
            )->count(),
            'total_appointments' => $this->appointmentService->getAppointmentsByPatient(
                $patient->id,
                ['per_page' => 1000]
            )->count(),
            'pending_bills' => $this->billService->getBillsByPatient(
                $patient->id
            )->where('payment_status', 'pending')->count(),
        ];

        $upcomingAppointments = $this->appointmentService->getAppointmentsByPatient(
            $patient->id,
            ['status' => 'confirmed', 'per_page' => 5]
        );

        return view('patient.dashboard', compact('stats', 'upcomingAppointments'));
    }

    public function appointments(Request $request)
    {
        $patient = auth()->user()->patient;
        
        $filters = $request->only(['status', 'date', 'per_page']);
        $filters['patient_id'] = $patient->id;
        
        $appointments = $this->appointmentService->getAllAppointments($filters);
        
        return view('patient.appointments', compact('appointments'));
    }

    public function medicalRecords()
    {
        $patient = auth()->user()->patient;
        $records = $this->medicalRecordService->getMedicalRecordsByPatient($patient->id);
        
        return view('patient.medical-records', compact('records'));
    }

    public function bills()
    {
        $patient = auth()->user()->patient;
        $bills = $this->billService->getBillsByPatient($patient->id);
        
        return view('patient.bills', compact('bills'));
    }
}

