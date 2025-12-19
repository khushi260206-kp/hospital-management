@extends('layouts.app')

@section('title', 'Medical Record Details')

@section('content')
<div class="row mb-4">
    <div class="col-12">
        <h2><i class="bi bi-file-medical"></i> Medical Record Details</h2>
    </div>
</div>

<div class="row">
    <div class="col-md-8">
        <div class="card">
            <div class="card-header">
                <h5>Record Information</h5>
            </div>
            <div class="card-body">
                <div class="row mb-3">
                    <div class="col-md-6">
                        <p><strong>Patient:</strong> {{ $record->patient->user->name }}</p>
                        <p><strong>Patient ID:</strong> {{ $record->patient->patient_id }}</p>
                    </div>
                    <div class="col-md-6">
                        <p><strong>Date:</strong> {{ \Carbon\Carbon::parse($record->record_date)->format('M d, Y') }}</p>
                        @if($record->appointment)
                            <p><strong>Appointment:</strong> {{ \Carbon\Carbon::parse($record->appointment->appointment_date)->format('M d, Y') }}</p>
                        @endif
                    </div>
                </div>

                <hr>

                <p><strong>Diagnosis:</strong></p>
                <p>{{ $record->diagnosis }}</p>

                @if($record->symptoms)
                    <p><strong>Symptoms:</strong></p>
                    <p>{{ $record->symptoms }}</p>
                @endif

                @if($record->notes)
                    <p><strong>Notes:</strong></p>
                    <p>{{ $record->notes }}</p>
                @endif
            </div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="card">
            <div class="card-header">
                <h5>Doctor Information</h5>
            </div>
            <div class="card-body">
                <p><strong>Doctor:</strong> {{ $record->doctor->user->name }}</p>
                <p><strong>Department:</strong> {{ $record->doctor->department->name }}</p>
                <p><strong>Specialization:</strong> {{ $record->doctor->specialization }}</p>
            </div>
        </div>
    </div>
</div>

<div class="row mt-4">
    <div class="col-12">
        <a href="{{ route('doctor.medical-records.index') }}" class="btn btn-secondary">Back</a>
    </div>
</div>
@endsection

