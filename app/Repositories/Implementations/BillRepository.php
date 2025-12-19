<?php

namespace App\Repositories\Implementations;

use App\Models\Bill;
use App\Repositories\Interfaces\BillRepositoryInterface;
use Illuminate\Pagination\LengthAwarePaginator;

class BillRepository implements BillRepositoryInterface
{
    public function getAll(array $filters = []): LengthAwarePaginator
    {
        $query = Bill::with(['patient.user', 'appointment', 'items']);

        if (isset($filters['patient_id'])) {
            $query->where('patient_id', $filters['patient_id']);
        }

        if (isset($filters['payment_status'])) {
            $query->where('payment_status', $filters['payment_status']);
        }

        if (isset($filters['bill_type'])) {
            $query->where('bill_type', $filters['bill_type']);
        }

        if (isset($filters['date_from'])) {
            $query->whereDate('bill_date', '>=', $filters['date_from']);
        }

        if (isset($filters['date_to'])) {
            $query->whereDate('bill_date', '<=', $filters['date_to']);
        }

        $query->orderBy('bill_date', 'desc');

        return $query->paginate($filters['per_page'] ?? 15);
    }

    public function findById(int $id): ?Bill
    {
        return Bill::with(['patient.user', 'appointment', 'items'])->find($id);
    }

    public function create(array $data): Bill
    {
        return Bill::create($data);
    }

    public function update(int $id, array $data): bool
    {
        $bill = Bill::find($id);
        if (!$bill) {
            return false;
        }
        return $bill->update($data);
    }

    public function delete(int $id): bool
    {
        $bill = Bill::find($id);
        if (!$bill) {
            return false;
        }
        return $bill->delete();
    }

    public function getByPatient(int $patientId): LengthAwarePaginator
    {
        return $this->getAll(['patient_id' => $patientId]);
    }

    public function generateBillNumber(): string
    {
        $lastBill = Bill::orderBy('id', 'desc')->first();
        $nextNumber = $lastBill ? ((int) substr($lastBill->bill_number, 4)) + 1 : 1;
        return 'BILL' . str_pad($nextNumber, 6, '0', STR_PAD_LEFT);
    }
}

