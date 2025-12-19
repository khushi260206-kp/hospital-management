<?php

namespace App\Services;

use App\Models\Doctor;
use App\Repositories\Interfaces\DoctorRepositoryInterface;
use App\Repositories\Interfaces\AppointmentRepositoryInterface;
use Illuminate\Support\Collection;

class DoctorRecommendationService
{
    public function __construct(
        private DoctorRepositoryInterface $doctorRepository,
        private AppointmentRepositoryInterface $appointmentRepository
    ) {}

    /**
     * Recommend the most suitable doctor based on department, availability, workload, and experience
     *
     * @param int $departmentId
     * @param string $date Date in Y-m-d format
     * @param string $time Time in H:i format
     * @return Doctor|null
     */
    public function recommendDoctor(int $departmentId, string $date, string $time): ?Doctor
    {
        // Step 1: Get all doctors in the department with availability checks
        $availableDoctors = $this->doctorRepository->getDoctorsByDepartmentWithAvailability(
            $departmentId,
            $date,
            $time
        );

        if ($availableDoctors->isEmpty()) {
            return null;
        }

        // Step 2: Check slot availability and get appointment counts
        $doctorsWithWorkload = $availableDoctors->map(function ($doctor) use ($date, $time) {
            // Check if the specific time slot is available
            $isSlotAvailable = $this->appointmentRepository->checkAvailability(
                $doctor->id,
                $date,
                $time
            );

            if (!$isSlotAvailable) {
                return null;
            }

            // Get appointment count for workload calculation
            $appointmentCount = $this->doctorRepository->getDoctorAppointmentCount($doctor->id, $date);

            return [
                'doctor' => $doctor,
                'appointment_count' => $appointmentCount,
                'experience_years' => $doctor->experience_years ?? 0,
            ];
        })->filter(); // Remove null entries (doctors with unavailable slots)

        if ($doctorsWithWorkload->isEmpty()) {
            return null;
        }

        // Step 3: Sort by workload (ASC) then experience (DESC)
        $sortedDoctors = $doctorsWithWorkload->sortBy([
            ['appointment_count', 'asc'],
            ['experience_years', 'desc'],
        ]);

        // Step 4: Return the top recommended doctor
        $topDoctor = $sortedDoctors->first();

        return $topDoctor ? $topDoctor['doctor'] : null;
    }
}

