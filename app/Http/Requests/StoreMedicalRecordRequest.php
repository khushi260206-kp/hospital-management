<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreMedicalRecordRequest extends FormRequest
{
    public function authorize(): bool
    {
        return auth()->user()->isDoctor() || auth()->user()->isAdmin();
    }

    public function rules(): array
    {
        return [
            'patient_id' => 'required|exists:patients,id',
            'doctor_id' => 'required|exists:doctors,id',
            'appointment_id' => 'nullable|exists:appointments,id',
            'diagnosis' => 'required|string',
            'symptoms' => 'nullable|string',
            'notes' => 'nullable|string',
            'record_date' => 'nullable|date',
        ];
    }
}

