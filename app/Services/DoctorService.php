<?php

namespace App\Services;

use App\Repositories\Interfaces\DoctorRepositoryInterface;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class DoctorService
{
    public function __construct(
        private DoctorRepositoryInterface $doctorRepository
    ) {}

    public function getAllDoctors(array $filters = []): LengthAwarePaginator
    {
        return $this->doctorRepository->getAll($filters);
    }

    public function getDoctorById(int $id)
    {
        return $this->doctorRepository->findById($id);
    }

    public function createDoctor(array $data)
    {
        DB::beginTransaction();
        try {
            // Create user first
            $userData = [
                'name' => $data['name'],
                'email' => $data['email'],
                'password' => Hash::make($data['password']),
                'role' => 'doctor',
                'phone' => $data['phone'] ?? null,
                'date_of_birth' => $data['date_of_birth'] ?? null,
                'gender' => $data['gender'] ?? null,
                'address' => $data['address'] ?? null,
            ];

            $user = \App\Models\User::create($userData);

            // Create doctor profile
            $doctorData = [
                'user_id' => $user->id,
                'department_id' => $data['department_id'],
                'specialization' => $data['specialization'],
                'qualification' => $data['qualification'],
                'license_number' => $data['license_number'],
                'experience_years' => $data['experience_years'] ?? 0,
                'consultation_fee' => $data['consultation_fee'] ?? 0,
                'bio' => $data['bio'] ?? null,
                'availability' => $data['availability'] ?? 'available',
                'working_hours_start' => $data['working_hours_start'] ?? '09:00',
                'working_hours_end' => $data['working_hours_end'] ?? '17:00',
            ];

            $doctor = $this->doctorRepository->create($doctorData);

            DB::commit();
            return $doctor;
        } catch (\Exception $e) {
            DB::rollBack();
            throw $e;
        }
    }

    public function updateDoctor(int $id, array $data): bool
    {
        DB::beginTransaction();
        try {
            $doctor = $this->doctorRepository->findById($id);
            if (!$doctor) {
                return false;
            }

            // Update user if provided
            if (isset($data['name']) || isset($data['email']) || isset($data['phone'])) {
                $userData = [];
                if (isset($data['name'])) $userData['name'] = $data['name'];
                if (isset($data['email'])) $userData['email'] = $data['email'];
                if (isset($data['phone'])) $userData['phone'] = $data['phone'];
                if (isset($data['date_of_birth'])) $userData['date_of_birth'] = $data['date_of_birth'];
                if (isset($data['gender'])) $userData['gender'] = $data['gender'];
                if (isset($data['address'])) $userData['address'] = $data['address'];

                $doctor->user->update($userData);
            }

            // Update password if provided
            if (isset($data['password'])) {
                $doctor->user->update(['password' => Hash::make($data['password'])]);
            }

            // Update doctor data
            $doctorData = array_filter($data, function ($key) {
                return !in_array($key, ['name', 'email', 'password', 'phone', 'date_of_birth', 'gender', 'address']);
            }, ARRAY_FILTER_USE_KEY);

            $result = $this->doctorRepository->update($id, $doctorData);

            DB::commit();
            return $result;
        } catch (\Exception $e) {
            DB::rollBack();
            throw $e;
        }
    }

    public function deleteDoctor(int $id): bool
    {
        return $this->doctorRepository->delete($id);
    }

    public function getDoctorsByDepartment(int $departmentId): array
    {
        return $this->doctorRepository->getByDepartment($departmentId);
    }

    public function getAvailableDoctors()
    {
        // Get doctors with proper relationships loaded
        $doctors = \App\Models\Doctor::where('availability', 'available')
            ->with(['user', 'department'])
            ->get();
        
        return $doctors;
    }
}

