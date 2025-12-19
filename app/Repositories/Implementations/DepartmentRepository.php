<?php

namespace App\Repositories\Implementations;

use App\Models\Department;
use App\Repositories\Interfaces\DepartmentRepositoryInterface;
use Illuminate\Support\Collection;

class DepartmentRepository implements DepartmentRepositoryInterface
{
    public function getAll(): Collection
    {
        return Department::all();
    }

    public function findById(int $id): ?Department
    {
        return Department::find($id);
    }

    public function create(array $data): Department
    {
        return Department::create($data);
    }

    public function update(int $id, array $data): bool
    {
        $department = Department::find($id);
        if (!$department) {
            return false;
        }
        return $department->update($data);
    }

    public function delete(int $id): bool
    {
        $department = Department::find($id);
        if (!$department) {
            return false;
        }
        return $department->delete();
    }

    public function getActive(): Collection
    {
        return Department::where('is_active', true)->get();
    }
}

