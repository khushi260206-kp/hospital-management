<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // Create Admin User
        $admin = \App\Models\User::firstOrCreate(
            ['email' => 'admin@hospital.com'],
            [
                'name' => 'Admin User',
                'password' => Hash::make('password'),
                'role' => 'admin',
                'phone' => '1234567890',
                'is_active' => true,
            ]
        );

        // Create Departments
        $cardiology = \App\Models\Department::firstOrCreate(
            ['name' => 'Cardiology'],
            [
                'description' => 'Heart and cardiovascular system',
                'is_active' => true,
            ]
        );

        $neurology = \App\Models\Department::firstOrCreate(
            ['name' => 'Neurology'],
            [
                'description' => 'Brain and nervous system',
                'is_active' => true,
            ]
        );

        $orthopedics = \App\Models\Department::firstOrCreate(
            ['name' => 'Orthopedics'],
            [
                'description' => 'Bones, joints, and muscles',
                'is_active' => true,
            ]
        );

        $pediatrics = \App\Models\Department::firstOrCreate(
            ['name' => 'Pediatrics'],
            [
                'description' => 'Children healthcare',
                'is_active' => true,
            ]
        );

        // Create Doctor Users
        $doctor1 = \App\Models\User::firstOrCreate(
            ['email' => 'doctor1@hospital.com'],
            [
                'name' => 'Dr. John Smith',
                'password' => Hash::make('password'),
                'role' => 'doctor',
                'phone' => '1234567891',
                'is_active' => true,
            ]
        );

        \App\Models\Doctor::firstOrCreate(
            ['user_id' => $doctor1->id],
            [
                'department_id' => $cardiology->id,
                'specialization' => 'Cardiologist',
                'qualification' => 'MD, MBBS',
                'license_number' => 'LIC001',
                'experience_years' => 10,
                'consultation_fee' => 500.00,
                'availability' => 'available',
                'working_hours_start' => '09:00',
                'working_hours_end' => '17:00',
            ]
        );

        $doctor2 = \App\Models\User::firstOrCreate(
            ['email' => 'doctor2@hospital.com'],
            [
                'name' => 'Dr. Sarah Johnson',
                'password' => Hash::make('password'),
                'role' => 'doctor',
                'phone' => '1234567892',
                'is_active' => true,
            ]
        );

        \App\Models\Doctor::firstOrCreate(
            ['user_id' => $doctor2->id],
            [
                'department_id' => $neurology->id,
                'specialization' => 'Neurologist',
                'qualification' => 'MD, MBBS',
                'license_number' => 'LIC002',
                'experience_years' => 8,
                'consultation_fee' => 600.00,
                'availability' => 'available',
                'working_hours_start' => '09:00',
                'working_hours_end' => '17:00',
            ]
        );

        // Create Receptionist User
        \App\Models\User::firstOrCreate(
            ['email' => 'receptionist@hospital.com'],
            [
                'name' => 'Receptionist',
                'password' => Hash::make('password'),
                'role' => 'receptionist',
                'phone' => '1234567893',
                'is_active' => true,
            ]
        );

        // Create Patient Users
        $patient1 = \App\Models\User::firstOrCreate(
            ['email' => 'patient1@hospital.com'],
            [
                'name' => 'Patient One',
                'password' => Hash::make('password'),
                'role' => 'patient',
                'phone' => '1234567894',
                'date_of_birth' => '1990-01-01',
                'gender' => 'male',
                'is_active' => true,
            ]
        );

        \App\Models\Patient::firstOrCreate(
            ['user_id' => $patient1->id],
            [
                'patient_id' => 'PAT000001',
                'blood_group' => 'O+',
                'height' => 175.00,
                'weight' => 70.00,
            ]
        );

        $patient2 = \App\Models\User::firstOrCreate(
            ['email' => 'patient2@hospital.com'],
            [
                'name' => 'Patient Two',
                'password' => Hash::make('password'),
                'role' => 'patient',
                'phone' => '1234567895',
                'date_of_birth' => '1985-05-15',
                'gender' => 'female',
                'is_active' => true,
            ]
        );

        \App\Models\Patient::firstOrCreate(
            ['user_id' => $patient2->id],
            [
                'patient_id' => 'PAT000002',
                'blood_group' => 'A+',
                'height' => 160.00,
                'weight' => 55.00,
            ]
        );

        $this->command->info('Database seeded successfully!');
        $this->command->info('Admin Login: admin@hospital.com / password');
        $this->command->info('Doctor Login: doctor1@hospital.com / password');
        $this->command->info('Patient Login: patient1@hospital.com / password');
    }
}

