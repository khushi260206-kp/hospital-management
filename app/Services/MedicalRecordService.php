<?php

namespace App\Services;

use App\Repositories\Interfaces\MedicalRecordRepositoryInterface;
use Illuminate\Pagination\LengthAwarePaginator;

class MedicalRecordService
{
    public function __construct(
        private MedicalRecordRepositoryInterface $medicalRecordRepository
    ) {}

    public function getAllMedicalRecords(array $filters = []): LengthAwarePaginator
    {
        return $this->medicalRecordRepository->getAll($filters);
    }

    public function getMedicalRecordById(int $id)
    {
        return $this->medicalRecordRepository->findById($id);
    }

    public function createMedicalRecord(array $data)
    {
        if (!isset($data['record_date'])) {
            $data['record_date'] = now()->toDateString();
        }

        return $this->medicalRecordRepository->create($data);
    }

    public function updateMedicalRecord(int $id, array $data): bool
    {
        return $this->medicalRecordRepository->update($id, $data);
    }

    public function deleteMedicalRecord(int $id): bool
    {
        return $this->medicalRecordRepository->delete($id);
    }

    public function getMedicalRecordsByPatient(int $patientId): LengthAwarePaginator
    {
        return $this->medicalRecordRepository->getByPatient($patientId);
    }
}

