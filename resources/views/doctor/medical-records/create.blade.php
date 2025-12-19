@extends('layouts.app')

@section('title', 'Add Medical Record')

@section('content')
<div class="row mb-4">
    <div class="col-12">
        <h2><i class="bi bi-file-plus"></i> Add Medical Record</h2>
    </div>
</div>

<div class="card">
    <div class="card-body">
        <form method="POST" action="{{ route('doctor.medical-records.store') }}">
            @csrf
            
            <div class="row mb-3">
                <div class="col-md-6">
                    <label for="patient_id" class="form-label">Patient *</label>
                    <select class="form-select @error('patient_id') is-invalid @enderror" 
                            id="patient_id" name="patient_id" required>
                        <option value="">Select Patient</option>
                        @foreach($patients as $patient)
                            <option value="{{ $patient->id }}" {{ old('patient_id', $appointment->patient_id ?? '') == $patient->id ? 'selected' : '' }}>
                                {{ $patient->user->name }} ({{ $patient->patient_id }})
                            </option>
                        @endforeach
                    </select>
                    @error('patient_id')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                <div class="col-md-6">
                    <label for="appointment_id" class="form-label">Appointment (Optional)</label>
                    <select class="form-select" id="appointment_id" name="appointment_id">
                        <option value="">None</option>
                        @if(isset($appointment))
                            <option value="{{ $appointment->id }}" selected>
                                {{ \Carbon\Carbon::parse($appointment->appointment_date)->format('M d, Y') }} - {{ $appointment->patient->user->name }}
                            </option>
                        @endif
                    </select>
                </div>
            </div>

            <div class="mb-3">
                <label for="diagnosis" class="form-label">Diagnosis *</label>
                <textarea class="form-control @error('diagnosis') is-invalid @enderror" 
                          id="diagnosis" name="diagnosis" rows="4" required>{{ old('diagnosis') }}</textarea>
                @error('diagnosis')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="mb-3">
                <label for="symptoms" class="form-label">Symptoms</label>
                <textarea class="form-control @error('symptoms') is-invalid @enderror" 
                          id="symptoms" name="symptoms" rows="3">{{ old('symptoms') }}</textarea>
                @error('symptoms')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="mb-3">
                <label for="notes" class="form-label">Notes</label>
                <textarea class="form-control @error('notes') is-invalid @enderror" 
                          id="notes" name="notes" rows="3">{{ old('notes') }}</textarea>
                @error('notes')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="mb-3">
                <label for="record_date" class="form-label">Record Date</label>
                <input type="date" class="form-control @error('record_date') is-invalid @enderror" 
                       id="record_date" name="record_date" value="{{ old('record_date', date('Y-m-d')) }}">
                @error('record_date')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="d-flex justify-content-end">
                <a href="{{ route('doctor.medical-records.index') }}" class="btn btn-secondary me-2">Cancel</a>
                <button type="submit" class="btn btn-primary">Create Medical Record</button>
            </div>
        </form>
    </div>
</div>
@endsection

