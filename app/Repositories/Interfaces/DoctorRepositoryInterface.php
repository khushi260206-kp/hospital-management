<?php

namespace App\Repositories\Interfaces;

use App\Models\Doctor;
use Illuminate\Pagination\LengthAwarePaginator;

interface DoctorRepositoryInterface
{
    public function getAll(array $filters = []): LengthAwarePaginator;
    public function findById(int $id): ?Doctor;
    public function create(array $data): Doctor;
    public function update(int $id, array $data): bool;
    public function delete(int $id): bool;
    public function getByDepartment(int $departmentId): array;
    public function getAvailableDoctors(): array;
}

