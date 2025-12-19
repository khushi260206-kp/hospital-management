<?php

namespace App\Services;

use App\Repositories\Interfaces\DepartmentRepositoryInterface;
use Illuminate\Support\Collection;

class DepartmentService
{
    public function __construct(
        private DepartmentRepositoryInterface $departmentRepository
    ) {}

    public function getAllDepartments(): Collection
    {
        return $this->departmentRepository->getAll();
    }

    public function getDepartmentById(int $id)
    {
        return $this->departmentRepository->findById($id);
    }

    public function createDepartment(array $data)
    {
        return $this->departmentRepository->create($data);
    }

    public function updateDepartment(int $id, array $data): bool
    {
        return $this->departmentRepository->update($id, $data);
    }

    public function deleteDepartment(int $id): bool
    {
        return $this->departmentRepository->delete($id);
    }

    public function getActiveDepartments(): Collection
    {
        return $this->departmentRepository->getActive();
    }
}

