<?php

namespace App\Repositories\Implementations;

use App\Models\Patient;
use App\Repositories\Interfaces\PatientRepositoryInterface;
use Illuminate\Pagination\LengthAwarePaginator;

class PatientRepository implements PatientRepositoryInterface
{
    public function getAll(array $filters = []): LengthAwarePaginator
    {
        $query = Patient::with('user');

        if (isset($filters['search'])) {
            $search = $filters['search'];
            $query->whereHas('user', function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('email', 'like', "%{$search}%");
            })->orWhere('patient_id', 'like', "%{$search}%");
        }

        return $query->paginate($filters['per_page'] ?? 15);
    }

    public function findById(int $id): ?Patient
    {
        return Patient::with('user')->find($id);
    }

    public function findByPatientId(string $patientId): ?Patient
    {
        return Patient::with('user')->where('patient_id', $patientId)->first();
    }

    public function create(array $data): Patient
    {
        return Patient::create($data);
    }

    public function update(int $id, array $data): bool
    {
        $patient = Patient::find($id);
        if (!$patient) {
            return false;
        }
        return $patient->update($data);
    }

    public function delete(int $id): bool
    {
        $patient = Patient::find($id);
        if (!$patient) {
            return false;
        }
        return $patient->delete();
    }

    public function generatePatientId(): string
    {
        $lastPatient = Patient::orderBy('id', 'desc')->first();
        $nextNumber = $lastPatient ? ((int) substr($lastPatient->patient_id, 3)) + 1 : 1;
        return 'PAT' . str_pad($nextNumber, 6, '0', STR_PAD_LEFT);
    }
}

