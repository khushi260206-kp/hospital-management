<?php

namespace App\Repositories\Implementations;

use App\Models\Appointment;
use App\Repositories\Interfaces\AppointmentRepositoryInterface;
use Illuminate\Pagination\LengthAwarePaginator;

class AppointmentRepository implements AppointmentRepositoryInterface
{
    public function getAll(array $filters = []): LengthAwarePaginator
    {
        $query = Appointment::with(['patient.user', 'doctor.user', 'doctor.department']);

        if (isset($filters['status'])) {
            $query->where('status', $filters['status']);
        }

        if (isset($filters['doctor_id'])) {
            $query->where('doctor_id', $filters['doctor_id']);
        }

        if (isset($filters['patient_id'])) {
            $query->where('patient_id', $filters['patient_id']);
        }

        if (isset($filters['date'])) {
            $query->whereDate('appointment_date', $filters['date']);
        }

        if (isset($filters['date_from'])) {
            $query->whereDate('appointment_date', '>=', $filters['date_from']);
        }

        if (isset($filters['date_to'])) {
            $query->whereDate('appointment_date', '<=', $filters['date_to']);
        }

        $query->orderBy('appointment_date', 'desc')
              ->orderBy('appointment_time', 'desc');

        return $query->paginate($filters['per_page'] ?? 15);
    }

    public function findById(int $id): ?Appointment
    {
        return Appointment::with(['patient.user', 'doctor.user', 'doctor.department'])->find($id);
    }

    public function create(array $data): Appointment
    {
        return Appointment::create($data);
    }

    public function update(int $id, array $data): bool
    {
        $appointment = Appointment::find($id);
        if (!$appointment) {
            return false;
        }
        return $appointment->update($data);
    }

    public function delete(int $id): bool
    {
        $appointment = Appointment::find($id);
        if (!$appointment) {
            return false;
        }
        return $appointment->delete();
    }

    public function getByDoctor(int $doctorId, array $filters = []): LengthAwarePaginator
    {
        $filters['doctor_id'] = $doctorId;
        return $this->getAll($filters);
    }

    public function getByPatient(int $patientId, array $filters = []): LengthAwarePaginator
    {
        $filters['patient_id'] = $patientId;
        return $this->getAll($filters);
    }

    public function checkAvailability(int $doctorId, string $date, string $time): bool
    {
        $exists = Appointment::where('doctor_id', $doctorId)
            ->whereDate('appointment_date', $date)
            ->whereTime('appointment_time', $time)
            ->whereIn('status', ['pending', 'confirmed'])
            ->exists();

        return !$exists;
    }
}

