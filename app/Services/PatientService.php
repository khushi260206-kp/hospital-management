<?php

namespace App\Services;

use App\Repositories\Interfaces\PatientRepositoryInterface;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class PatientService
{
    public function __construct(
        private PatientRepositoryInterface $patientRepository
    ) {}

    public function getAllPatients(array $filters = []): LengthAwarePaginator
    {
        return $this->patientRepository->getAll($filters);
    }

    public function getPatientById(int $id)
    {
        return $this->patientRepository->findById($id);
    }

    public function createPatient(array $data)
    {
        DB::beginTransaction();
        try {
            // Create user first
            $userData = [
                'name' => $data['name'],
                'email' => $data['email'],
                'password' => Hash::make($data['password']),
                'role' => 'patient',
                'phone' => $data['phone'] ?? null,
                'date_of_birth' => $data['date_of_birth'] ?? null,
                'gender' => $data['gender'] ?? null,
                'address' => $data['address'] ?? null,
            ];

            $user = \App\Models\User::create($userData);

            // Generate patient ID
            $patientId = $this->patientRepository->generatePatientId();

            // Create patient profile
            $patientData = [
                'user_id' => $user->id,
                'patient_id' => $patientId,
                'blood_group' => $data['blood_group'] ?? null,
                'height' => $data['height'] ?? null,
                'weight' => $data['weight'] ?? null,
                'allergies' => $data['allergies'] ?? null,
                'medical_history' => $data['medical_history'] ?? null,
                'emergency_contact_name' => $data['emergency_contact_name'] ?? null,
                'emergency_contact_phone' => $data['emergency_contact_phone'] ?? null,
            ];

            $patient = $this->patientRepository->create($patientData);

            DB::commit();
            return $patient;
        } catch (\Exception $e) {
            DB::rollBack();
            throw $e;
        }
    }

    public function updatePatient(int $id, array $data): bool
    {
        DB::beginTransaction();
        try {
            $patient = $this->patientRepository->findById($id);
            if (!$patient) {
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

                $patient->user->update($userData);
            }

            // Update password if provided
            if (isset($data['password'])) {
                $patient->user->update(['password' => Hash::make($data['password'])]);
            }

            // Update patient data
            $patientData = array_filter($data, function ($key) {
                return !in_array($key, ['name', 'email', 'password', 'phone', 'date_of_birth', 'gender', 'address']);
            }, ARRAY_FILTER_USE_KEY);

            $result = $this->patientRepository->update($id, $patientData);

            DB::commit();
            return $result;
        } catch (\Exception $e) {
            DB::rollBack();
            throw $e;
        }
    }

    public function deletePatient(int $id): bool
    {
        return $this->patientRepository->delete($id);
    }
}

