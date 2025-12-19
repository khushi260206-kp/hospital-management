<?php

namespace App\Services;

use App\Models\BillItem;
use App\Repositories\Interfaces\BillRepositoryInterface;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\DB;

class BillService
{
    public function __construct(
        private BillRepositoryInterface $billRepository
    ) {}

    public function getAllBills(array $filters = []): LengthAwarePaginator
    {
        return $this->billRepository->getAll($filters);
    }

    public function getBillById(int $id)
    {
        return $this->billRepository->findById($id);
    }

    public function createBill(array $data)
    {
        DB::beginTransaction();
        try {
            // Generate bill number
            $billNumber = $this->billRepository->generateBillNumber();

            $billData = [
                'patient_id' => $data['patient_id'],
                'appointment_id' => $data['appointment_id'] ?? null,
                'bill_number' => $billNumber,
                'bill_type' => $data['bill_type'] ?? 'opd',
                'bill_date' => $data['bill_date'] ?? now()->toDateString(),
                'due_date' => $data['due_date'] ?? null,
                'notes' => $data['notes'] ?? null,
                'payment_method' => $data['payment_method'] ?? null,
            ];

            // Calculate totals
            $subtotal = 0;
            if (isset($data['items']) && is_array($data['items'])) {
                foreach ($data['items'] as $item) {
                    $itemTotal = ($item['quantity'] ?? 1) * ($item['unit_price'] ?? 0);
                    $subtotal += $itemTotal;
                }
            }

            $tax = ($data['tax'] ?? 0);
            $discount = ($data['discount'] ?? 0);
            $total = $subtotal + $tax - $discount;

            $billData['subtotal'] = $subtotal;
            $billData['tax'] = $tax;
            $billData['discount'] = $discount;
            $billData['total'] = $total;
            $billData['payment_status'] = $data['payment_status'] ?? 'pending';

            $bill = $this->billRepository->create($billData);

            // Create bill items
            if (isset($data['items']) && is_array($data['items'])) {
                foreach ($data['items'] as $item) {
                    BillItem::create([
                        'bill_id' => $bill->id,
                        'item_name' => $item['item_name'],
                        'description' => $item['description'] ?? null,
                        'quantity' => $item['quantity'] ?? 1,
                        'unit_price' => $item['unit_price'],
                        'total_price' => ($item['quantity'] ?? 1) * $item['unit_price'],
                        'item_type' => $item['item_type'] ?? 'other',
                    ]);
                }
            }

            DB::commit();
            return $bill->load('items');
        } catch (\Exception $e) {
            DB::rollBack();
            throw $e;
        }
    }

    public function updateBill(int $id, array $data): bool
    {
        DB::beginTransaction();
        try {
            $bill = $this->billRepository->findById($id);
            if (!$bill) {
                return false;
            }

            // Update bill items if provided
            if (isset($data['items']) && is_array($data['items'])) {
                // Delete existing items
                $bill->items()->delete();

                // Create new items
                $subtotal = 0;
                foreach ($data['items'] as $item) {
                    $itemTotal = ($item['quantity'] ?? 1) * ($item['unit_price'] ?? 0);
                    $subtotal += $itemTotal;

                    BillItem::create([
                        'bill_id' => $bill->id,
                        'item_name' => $item['item_name'],
                        'description' => $item['description'] ?? null,
                        'quantity' => $item['quantity'] ?? 1,
                        'unit_price' => $item['unit_price'],
                        'total_price' => $itemTotal,
                        'item_type' => $item['item_type'] ?? 'other',
                    ]);
                }

                // Recalculate totals
                $tax = $data['tax'] ?? $bill->tax;
                $discount = $data['discount'] ?? $bill->discount;
                $total = $subtotal + $tax - $discount;

                $data['subtotal'] = $subtotal;
                $data['total'] = $total;
            }

            $result = $this->billRepository->update($id, $data);

            DB::commit();
            return $result;
        } catch (\Exception $e) {
            DB::rollBack();
            throw $e;
        }
    }

    public function deleteBill(int $id): bool
    {
        return $this->billRepository->delete($id);
    }

    public function getBillsByPatient(int $patientId): LengthAwarePaginator
    {
        return $this->billRepository->getByPatient($patientId);
    }

    public function updatePaymentStatus(int $id, string $status, ?string $paymentMethod = null): bool
    {
        $data = ['payment_status' => $status];
        if ($paymentMethod) {
            $data['payment_method'] = $paymentMethod;
        }
        return $this->billRepository->update($id, $data);
    }
}

