<?php

namespace App\Services;

use App\Repositories\Interfaces\AppointmentRepositoryInterface;
use Illuminate\Pagination\LengthAwarePaginator;

class AppointmentService
{
    public function __construct(
        private AppointmentRepositoryInterface $appointmentRepository,
        private DoctorRecommendationService $doctorRecommendationService
    ) {}

    public function getAllAppointments(array $filters = []): LengthAwarePaginator
    {
        return $this->appointmentRepository->getAll($filters);
    }

    public function getAppointmentById(int $id)
    {
        return $this->appointmentRepository->findById($id);
    }

    public function createAppointment(array $data)
    {
        // If doctor_id is not provided but department_id is provided, use recommendation service
        if (!isset($data['doctor_id']) && isset($data['department_id'])) {
            $recommendedDoctor = $this->doctorRecommendationService->recommendDoctor(
                $data['department_id'],
                $data['appointment_date'],
                $data['appointment_time']
            );

            if (!$recommendedDoctor) {
                throw new \Exception('No doctors available for the selected department, date, and time.');
            }

            $data['doctor_id'] = $recommendedDoctor->id;
        }

        // Ensure doctor_id is set
        if (!isset($data['doctor_id'])) {
            throw new \Exception('Doctor ID is required.');
        }

        // Check availability
        $isAvailable = $this->appointmentRepository->checkAvailability(
            $data['doctor_id'],
            $data['appointment_date'],
            $data['appointment_time']
        );

        if (!$isAvailable) {
            throw new \Exception('Doctor is not available at this time slot.');
        }

        return $this->appointmentRepository->create($data);
    }

    public function updateAppointment(int $id, array $data): bool
    {
        // If date/time is being changed, check availability
        if (isset($data['doctor_id']) && isset($data['appointment_date']) && isset($data['appointment_time'])) {
            $appointment = $this->appointmentRepository->findById($id);
            if ($appointment) {
                $isAvailable = $this->appointmentRepository->checkAvailability(
                    $data['doctor_id'],
                    $data['appointment_date'],
                    $data['appointment_time']
                );

                if (!$isAvailable && 
                    ($appointment->doctor_id != $data['doctor_id'] || 
                     $appointment->appointment_date != $data['appointment_date'] ||
                     $appointment->appointment_time != $data['appointment_time'])) {
                    throw new \Exception('Doctor is not available at this time slot.');
                }
            }
        }

        return $this->appointmentRepository->update($id, $data);
    }

    public function deleteAppointment(int $id): bool
    {
        return $this->appointmentRepository->delete($id);
    }

    public function getAppointmentsByDoctor(int $doctorId, array $filters = []): LengthAwarePaginator
    {
        return $this->appointmentRepository->getByDoctor($doctorId, $filters);
    }

    public function getAppointmentsByPatient(int $patientId, array $filters = []): LengthAwarePaginator
    {
        return $this->appointmentRepository->getByPatient($patientId, $filters);
    }

    public function cancelAppointment(int $id): bool
    {
        return $this->appointmentRepository->update($id, ['status' => 'cancelled']);
    }

    public function completeAppointment(int $id): bool
    {
        return $this->appointmentRepository->update($id, ['status' => 'completed']);
    }
}

