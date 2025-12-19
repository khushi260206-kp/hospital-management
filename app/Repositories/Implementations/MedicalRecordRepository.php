<?php

namespace App\Repositories\Implementations;

use App\Models\MedicalRecord;
use App\Repositories\Interfaces\MedicalRecordRepositoryInterface;
use Illuminate\Pagination\LengthAwarePaginator;

class MedicalRecordRepository implements MedicalRecordRepositoryInterface
{
    public function getAll(array $filters = []): LengthAwarePaginator
    {
        $query = MedicalRecord::with(['patient.user', 'doctor.user']);

        if (isset($filters['patient_id'])) {
            $query->where('patient_id', $filters['patient_id']);
        }

        if (isset($filters['doctor_id'])) {
            $query->where('doctor_id', $filters['doctor_id']);
        }

        $query->orderBy('record_date', 'desc');

        return $query->paginate($filters['per_page'] ?? 15);
    }

    public function findById(int $id): ?MedicalRecord
    {
        return MedicalRecord::with(['patient.user', 'doctor.user', 'appointment'])->find($id);
    }

    public function create(array $data): MedicalRecord
    {
        return MedicalRecord::create($data);
    }

    public function update(int $id, array $data): bool
    {
        $record = MedicalRecord::find($id);
        if (!$record) {
            return false;
        }
        return $record->update($data);
    }

    public function delete(int $id): bool
    {
        $record = MedicalRecord::find($id);
        if (!$record) {
            return false;
        }
        return $record->delete();
    }

    public function getByPatient(int $patientId): LengthAwarePaginator
    {
        return $this->getAll(['patient_id' => $patientId]);
    }
}

