<?php

namespace App\Repositories\Interfaces;

use App\Models\Doctor;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Collection;

interface DoctorRepositoryInterface
{
    public function getAll(array $filters = []): LengthAwarePaginator;
    public function findById(int $id): ?Doctor;
    public function create(array $data): Doctor;
    public function update(int $id, array $data): bool;
    public function delete(int $id): bool;
    public function getByDepartment(int $departmentId): array;
    public function getAvailableDoctors(): array;
    public function getDoctorsByDepartmentWithAvailability(int $departmentId, string $date, string $time): Collection;
    public function getDoctorAppointmentCount(int $doctorId, string $date): int;
    public function checkWorkingHours(int $doctorId, string $time): bool;
}

