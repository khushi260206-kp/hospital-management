<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreBillRequest extends FormRequest
{
    public function authorize(): bool
    {
        $user = auth()->user();
        return $user && ($user->isAdmin() || $user->isReceptionist());
    }

    public function rules(): array
    {
        return [
            'patient_id' => 'required|exists:patients,id',
            'appointment_id' => 'nullable|exists:appointments,id',
            'bill_type' => 'required|in:opd,ipd,pharmacy,lab,other',
            'bill_date' => 'nullable|date',
            'due_date' => 'nullable|date|after_or_equal:bill_date',
            'tax' => 'nullable|numeric|min:0',
            'discount' => 'nullable|numeric|min:0',
            'payment_status' => 'nullable|in:pending,partial,paid',
            'payment_method' => 'nullable|in:cash,card,online,insurance',
            'notes' => 'nullable|string',
            'items' => 'required|array|min:1',
            'items.*.item_name' => 'required|string|max:255',
            'items.*.description' => 'nullable|string',
            'items.*.quantity' => 'required|integer|min:1',
            'items.*.unit_price' => 'required|numeric|min:0',
            'items.*.item_type' => 'nullable|in:consultation,medicine,test,procedure,other',
        ];
    }
}

