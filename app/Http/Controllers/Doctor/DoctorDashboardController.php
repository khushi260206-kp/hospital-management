<?php

namespace App\Http\Controllers\Doctor;

use App\Http\Controllers\Controller;
use App\Services\AppointmentService;
use App\Services\MedicalRecordService;
use Illuminate\Http\Request;

class DoctorDashboardController extends Controller
{
    public function __construct(
        private AppointmentService $appointmentService,
        private MedicalRecordService $medicalRecordService
    ) {
        $this->middleware(['auth', 'role:doctor']);
    }

    public function dashboard()
    {
        $doctor = auth()->user()->doctor;
        
        $stats = [
            'today_appointments' => $this->appointmentService->getAppointmentsByDoctor(
                $doctor->id,
                ['date' => today()->toDateString(), 'per_page' => 1000]
            )->count(),
            'pending_appointments' => $this->appointmentService->getAppointmentsByDoctor(
                $doctor->id,
                ['status' => 'pending', 'per_page' => 1000]
            )->count(),
            'total_appointments' => $this->appointmentService->getAppointmentsByDoctor(
                $doctor->id,
                ['per_page' => 1000]
            )->count(),
        ];

        $todayAppointments = $this->appointmentService->getAppointmentsByDoctor(
            $doctor->id,
            ['date' => today()->toDateString(), 'per_page' => 50]
        );

        return view('doctor.dashboard', compact('stats', 'todayAppointments'));
    }

    public function appointments(Request $request)
    {
        $doctor = auth()->user()->doctor;
        
        $filters = $request->only(['status', 'date', 'per_page']);
        $filters['doctor_id'] = $doctor->id;
        
        $appointments = $this->appointmentService->getAllAppointments($filters);
        
        return view('doctor.appointments', compact('appointments'));
    }
}

