@extends('layouts.app')

@section('title', 'Doctor Details')

@section('content')
<div class="row mb-4">
    <div class="col-12">
        <h2><i class="bi bi-person"></i> Doctor Details</h2>
    </div>
</div>

<div class="row">
    <div class="col-md-6">
        <div class="card">
            <div class="card-header">
                <h5>Personal Information</h5>
            </div>
            <div class="card-body">
                <p><strong>Name:</strong> {{ $doctor->user->name }}</p>
                <p><strong>Email:</strong> {{ $doctor->user->email }}</p>
                <p><strong>Phone:</strong> {{ $doctor->user->phone ?? 'N/A' }}</p>
                <p><strong>Date of Birth:</strong> {{ $doctor->user->date_of_birth ? \Carbon\Carbon::parse($doctor->user->date_of_birth)->format('M d, Y') : 'N/A' }}</p>
                <p><strong>Gender:</strong> {{ ucfirst($doctor->user->gender ?? 'N/A') }}</p>
                <p><strong>Address:</strong> {{ $doctor->user->address ?? 'N/A' }}</p>
            </div>
        </div>
    </div>
    <div class="col-md-6">
        <div class="card">
            <div class="card-header">
                <h5>Professional Information</h5>
            </div>
            <div class="card-body">
                <p><strong>Department:</strong> {{ $doctor->department->name }}</p>
                <p><strong>Specialization:</strong> {{ $doctor->specialization }}</p>
                <p><strong>Qualification:</strong> {{ $doctor->qualification }}</p>
                <p><strong>License Number:</strong> {{ $doctor->license_number }}</p>
                <p><strong>Experience:</strong> {{ $doctor->experience_years }} years</p>
                <p><strong>Consultation Fee:</strong> ${{ number_format($doctor->consultation_fee, 2) }}</p>
                <p><strong>Availability:</strong> 
                    <span class="badge bg-{{ $doctor->availability === 'available' ? 'success' : ($doctor->availability === 'busy' ? 'warning' : 'secondary') }}">
                        {{ ucfirst(str_replace('_', ' ', $doctor->availability)) }}
                    </span>
                </p>
                <p><strong>Working Hours:</strong> {{ \Carbon\Carbon::parse($doctor->working_hours_start)->format('h:i A') }} - {{ \Carbon\Carbon::parse($doctor->working_hours_end)->format('h:i A') }}</p>
                @if($doctor->bio)
                    <p><strong>Bio:</strong> {{ $doctor->bio }}</p>
                @endif
            </div>
        </div>
    </div>
</div>

<div class="row mt-4">
    <div class="col-12">
        <a href="{{ route('admin.doctors.index') }}" class="btn btn-secondary">Back</a>
        <a href="{{ route('admin.doctors.edit', $doctor->id) }}" class="btn btn-primary">Edit</a>
    </div>
</div>
@endsection

