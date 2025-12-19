<?php

namespace App\Repositories\Interfaces;

use App\Models\Patient;
use Illuminate\Pagination\LengthAwarePaginator;

interface PatientRepositoryInterface
{
    public function getAll(array $filters = []): LengthAwarePaginator;
    public function findById(int $id): ?Patient;
    public function findByPatientId(string $patientId): ?Patient;
    public function create(array $data): Patient;
    public function update(int $id, array $data): bool;
    public function delete(int $id): bool;
    public function generatePatientId(): string;
}

