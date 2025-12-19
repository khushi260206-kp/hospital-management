<?php

namespace App\Repositories\Interfaces;

use App\Models\Bill;
use Illuminate\Pagination\LengthAwarePaginator;

interface BillRepositoryInterface
{
    public function getAll(array $filters = []): LengthAwarePaginator;
    public function findById(int $id): ?Bill;
    public function create(array $data): Bill;
    public function update(int $id, array $data): bool;
    public function delete(int $id): bool;
    public function getByPatient(int $patientId): LengthAwarePaginator;
    public function generateBillNumber(): string;
}

