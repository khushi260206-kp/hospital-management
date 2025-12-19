<?php

namespace App\Repositories\Interfaces;

use App\Models\Department;
use Illuminate\Support\Collection;

interface DepartmentRepositoryInterface
{
    public function getAll(): Collection;
    public function findById(int $id): ?Department;
    public function create(array $data): Department;
    public function update(int $id, array $data): bool;
    public function delete(int $id): bool;
    public function getActive(): Collection;
}

