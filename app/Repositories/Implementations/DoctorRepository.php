<?php

namespace App\Repositories\Implementations;

use App\Models\Doctor;
use App\Repositories\Interfaces\DoctorRepositoryInterface;
use Illuminate\Pagination\LengthAwarePaginator;

class DoctorRepository implements DoctorRepositoryInterface
{
    public function getAll(array $filters = []): LengthAwarePaginator
    {
        $query = Doctor::with(['user', 'department']);

        if (isset($filters['department_id'])) {
            $query->where('department_id', $filters['department_id']);
        }

        if (isset($filters['availability'])) {
            $query->where('availability', $filters['availability']);
        }

        if (isset($filters['search'])) {
            $search = $filters['search'];
            $query->whereHas('user', function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('email', 'like', "%{$search}%");
            });
        }

        return $query->paginate($filters['per_page'] ?? 15);
    }

    public function findById(int $id): ?Doctor
    {
        return Doctor::with(['user', 'department'])->find($id);
    }

    public function create(array $data): Doctor
    {
        return Doctor::create($data);
    }

    public function update(int $id, array $data): bool
    {
        $doctor = Doctor::find($id);
        if (!$doctor) {
            return false;
        }
        return $doctor->update($data);
    }

    public function delete(int $id): bool
    {
        $doctor = Doctor::find($id);
        if (!$doctor) {
            return false;
        }
        return $doctor->delete();
    }

    public function getByDepartment(int $departmentId): array
    {
        return Doctor::where('department_id', $departmentId)
            ->where('availability', 'available')
            ->with('user')
            ->get()
            ->toArray();
    }

    public function getAvailableDoctors(): array
    {
        return Doctor::where('availability', 'available')
            ->with(['user', 'department'])
            ->get()
            ->toArray();
    }

    public function getDoctorsByDepartmentWithAvailability(int $departmentId, string $date, string $time): \Illuminate\Support\Collection
    {
        // Parse time to check working hours (format: H:i)
        $appointmentTime = \Carbon\Carbon::createFromFormat('H:i', $time)->format('H:i:s');

        return Doctor::where('department_id', $departmentId)
            ->where('availability', 'available')
            ->whereRaw('TIME(?) >= TIME(working_hours_start)', [$appointmentTime])
            ->whereRaw('TIME(?) <= TIME(working_hours_end)', [$appointmentTime])
            ->with(['user', 'department'])
            ->get();
    }

    public function getDoctorAppointmentCount(int $doctorId, string $date): int
    {
        return \App\Models\Appointment::where('doctor_id', $doctorId)
            ->whereDate('appointment_date', $date)
            ->whereIn('status', ['pending', 'confirmed'])
            ->count();
    }

    public function checkWorkingHours(int $doctorId, string $time): bool
    {
        $doctor = Doctor::find($doctorId);
        if (!$doctor) {
            return false;
        }

        // Parse time strings to compare
        $appointmentTime = \Carbon\Carbon::createFromFormat('H:i', $time);
        $startTime = \Carbon\Carbon::parse($doctor->working_hours_start);
        $endTime = \Carbon\Carbon::parse($doctor->working_hours_end);

        // Compare times (ignoring date part)
        $appointmentTimeOnly = $appointmentTime->format('H:i:s');
        $startTimeOnly = $startTime->format('H:i:s');
        $endTimeOnly = $endTime->format('H:i:s');

        return $appointmentTimeOnly >= $startTimeOnly && $appointmentTimeOnly <= $endTimeOnly;
    }
}

