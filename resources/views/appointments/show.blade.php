@extends('layouts.app')

@section('title', 'Appointment Details')

@section('content')
<div class="row mb-4">
    <div class="col-12">
        <h2><i class="bi bi-calendar-check"></i> Appointment Details</h2>
    </div>
</div>

<div class="row">
    <div class="col-md-6">
        <div class="card">
            <div class="card-header">
                <h5>Appointment Information</h5>
            </div>
            <div class="card-body">
                <p><strong>Date:</strong> {{ \Carbon\Carbon::parse($appointment->appointment_date)->format('M d, Y') }}</p>
                <p><strong>Time:</strong> {{ \Carbon\Carbon::parse($appointment->appointment_time)->format('h:i A') }}</p>
                <p><strong>Status:</strong> 
                    <span class="badge bg-{{ $appointment->status === 'confirmed' ? 'success' : ($appointment->status === 'pending' ? 'warning' : ($appointment->status === 'completed' ? 'info' : 'secondary')) }}">
                        {{ ucfirst($appointment->status) }}
                    </span>
                </p>
                <p><strong>Reason:</strong> {{ $appointment->reason ?? 'N/A' }}</p>
                @if($appointment->notes)
                    <p><strong>Notes:</strong> {{ $appointment->notes }}</p>
                @endif
            </div>
        </div>
    </div>
    <div class="col-md-6">
        <div class="card">
            <div class="card-header">
                <h5>Doctor & Patient Information</h5>
            </div>
            <div class="card-body">
                <p><strong>Doctor:</strong> {{ $appointment->doctor->user->name }}</p>
                <p><strong>Department:</strong> {{ $appointment->doctor->department->name }}</p>
                <p><strong>Specialization:</strong> {{ $appointment->doctor->specialization }}</p>
                <p><strong>Patient:</strong> {{ $appointment->patient->user->name }}</p>
                <p><strong>Patient ID:</strong> {{ $appointment->patient->patient_id }}</p>
            </div>
        </div>
    </div>
</div>

<div class="row mt-4">
    <div class="col-12">
        <a href="{{ route('appointments.index') }}" class="btn btn-secondary">Back</a>
        @if($appointment->status !== 'completed' && $appointment->status !== 'cancelled')
            @if(auth()->user()->isDoctor())
                <form action="{{ route('appointments.complete', $appointment->id) }}" method="POST" class="d-inline">
                    @csrf
                    <button type="submit" class="btn btn-success">Mark as Completed</button>
                </form>
            @endif
            <form action="{{ route('appointments.cancel', $appointment->id) }}" method="POST" class="d-inline">
                @csrf
                <button type="submit" class="btn btn-danger" onclick="return confirm('Are you sure?')">Cancel Appointment</button>
            </form>
        @endif
    </div>
</div>
@endsection

