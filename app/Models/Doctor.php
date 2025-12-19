<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Doctor extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'user_id',
        'department_id',
        'specialization',
        'qualification',
        'license_number',
        'experience_years',
        'consultation_fee',
        'bio',
        'availability',
        'working_hours_start',
        'working_hours_end',
    ];

    protected function casts(): array
    {
        return [
            'consultation_fee' => 'decimal:2',
            'working_hours_start' => 'datetime:H:i',
            'working_hours_end' => 'datetime:H:i',
        ];
    }

    // Relationships
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function department()
    {
        return $this->belongsTo(Department::class);
    }

    public function appointments()
    {
        return $this->hasMany(Appointment::class);
    }

    public function medicalRecords()
    {
        return $this->hasMany(MedicalRecord::class);
    }

    public function prescriptions()
    {
        return $this->hasMany(Prescription::class);
    }
}

