<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreAppointmentRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true; // Patients, receptionists, and admins can create appointments
    }

    /**
     * Prepare the data for validation.
     */
    protected function prepareForValidation(): void
    {
        // If patient is creating appointment, auto-set their patient_id
        if (auth()->check() && auth()->user()->isPatient()) {
            $patient = auth()->user()->patient;
            if ($patient) {
                $this->merge([
                    'patient_id' => $patient->id,
                ]);
            }
        }
    }

    public function rules(): array
    {
        // Patient ID is required, but for patients it's auto-set in prepareForValidation
        // For admin/receptionist, it must be provided in the form
        $rules = [
            'patient_id' => 'required|exists:patients,id',
            'doctor_id' => 'required_without:department_id|exists:doctors,id',
            'department_id' => 'required_without:doctor_id|exists:departments,id',
            'appointment_date' => 'required|date|after_or_equal:today',
            'appointment_time' => 'required|date_format:H:i',
            'reason' => 'nullable|string',
            'notes' => 'nullable|string',
        ];

        return $rules;
    }
}

