@extends('layouts.app')

@section('title', 'Patient Details')

@section('content')
<div class="row mb-4">
    <div class="col-12">
        <h2><i class="bi bi-person"></i> Patient Details</h2>
    </div>
</div>

<div class="row">
    <div class="col-md-6">
        <div class="card">
            <div class="card-header">
                <h5>Personal Information</h5>
            </div>
            <div class="card-body">
                <p><strong>Patient ID:</strong> {{ $patient->patient_id }}</p>
                <p><strong>Name:</strong> {{ $patient->user->name }}</p>
                <p><strong>Email:</strong> {{ $patient->user->email }}</p>
                <p><strong>Phone:</strong> {{ $patient->user->phone ?? 'N/A' }}</p>
                <p><strong>Date of Birth:</strong> {{ $patient->user->date_of_birth ? \Carbon\Carbon::parse($patient->user->date_of_birth)->format('M d, Y') : 'N/A' }}</p>
                <p><strong>Gender:</strong> {{ ucfirst($patient->user->gender ?? 'N/A') }}</p>
                <p><strong>Address:</strong> {{ $patient->user->address ?? 'N/A' }}</p>
            </div>
        </div>
    </div>
    <div class="col-md-6">
        <div class="card">
            <div class="card-header">
                <h5>Medical Information</h5>
            </div>
            <div class="card-body">
                <p><strong>Blood Group:</strong> {{ $patient->blood_group ?? 'N/A' }}</p>
                <p><strong>Height:</strong> {{ $patient->height ? $patient->height . ' cm' : 'N/A' }}</p>
                <p><strong>Weight:</strong> {{ $patient->weight ? $patient->weight . ' kg' : 'N/A' }}</p>
                <p><strong>Allergies:</strong> {{ $patient->allergies ?? 'None' }}</p>
                <p><strong>Medical History:</strong> {{ $patient->medical_history ?? 'N/A' }}</p>
                <p><strong>Emergency Contact:</strong> {{ $patient->emergency_contact_name ?? 'N/A' }}</p>
                <p><strong>Emergency Phone:</strong> {{ $patient->emergency_contact_phone ?? 'N/A' }}</p>
            </div>
        </div>
    </div>
</div>

<div class="row mt-4">
    <div class="col-12">
        <a href="{{ route('admin.patients.index') }}" class="btn btn-secondary">Back</a>
        <a href="{{ route('admin.patients.edit', $patient->id) }}" class="btn btn-primary">Edit</a>
    </div>
</div>
@endsection

