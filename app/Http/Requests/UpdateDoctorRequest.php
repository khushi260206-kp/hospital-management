<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateDoctorRequest extends FormRequest
{
    public function authorize(): bool
    {
        return auth()->user()->isAdmin();
    }

    public function rules(): array
    {
        $doctorId = $this->route('doctor');
        
        return [
            'name' => 'sometimes|string|max:255',
            'email' => 'sometimes|email|unique:users,email,' . ($doctorId ? \App\Models\Doctor::find($doctorId)?->user_id : ''),
            'password' => 'sometimes|string|min:8',
            'phone' => 'nullable|string|max:20',
            'date_of_birth' => 'nullable|date',
            'gender' => 'nullable|in:male,female,other',
            'address' => 'nullable|string',
            'department_id' => 'sometimes|exists:departments,id',
            'specialization' => 'sometimes|string|max:255',
            'qualification' => 'sometimes|string|max:255',
            'license_number' => 'sometimes|string|unique:doctors,license_number,' . $doctorId,
            'experience_years' => 'nullable|integer|min:0',
            'consultation_fee' => 'nullable|numeric|min:0',
            'bio' => 'nullable|string',
            'availability' => 'nullable|in:available,busy,on_leave',
            'working_hours_start' => 'nullable|date_format:H:i',
            'working_hours_end' => 'nullable|date_format:H:i',
        ];
    }
}

