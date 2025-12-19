<?php

namespace App\Repositories\Interfaces;

use App\Models\MedicalRecord;
use Illuminate\Pagination\LengthAwarePaginator;

interface MedicalRecordRepositoryInterface
{
    public function getAll(array $filters = []): LengthAwarePaginator;
    public function findById(int $id): ?MedicalRecord;
    public function create(array $data): MedicalRecord;
    public function update(int $id, array $data): bool;
    public function delete(int $id): bool;
    public function getByPatient(int $patientId): LengthAwarePaginator;
}

