@extends('layouts.app')

@section('title', 'Book Appointment')

@section('content')
<div class="row mb-4">
    <div class="col-12">
        <h2><i class="bi bi-calendar-plus"></i> Book Appointment</h2>
    </div>
</div>

<div class="card">
    <div class="card-body">
        <form method="POST" action="{{ route('appointments.store') }}">
            @csrf
            
            @if(auth()->user()->isAdmin() || auth()->user()->isReceptionist())
                <div class="mb-3">
                    <label for="patient_id" class="form-label">Patient *</label>
                    <select class="form-select @error('patient_id') is-invalid @enderror" 
                            id="patient_id" name="patient_id" required>
                        <option value="">Select Patient</option>
                        @foreach($patients as $patient)
                            <option value="{{ $patient->id }}" {{ old('patient_id') == $patient->id ? 'selected' : '' }}>
                                {{ $patient->user->name }} ({{ $patient->patient_id }})
                            </option>
                        @endforeach
                    </select>
                    @error('patient_id')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
            @endif

            <div class="row mb-3">
                <div class="col-md-6">
                    <label for="doctor_id" class="form-label">Doctor *</label>
                    <select class="form-select @error('doctor_id') is-invalid @enderror" 
                            id="doctor_id" name="doctor_id" required>
                        <option value="">Select Doctor</option>
                        @foreach($doctors as $doctor)
                            <option value="{{ $doctor->id }}" {{ old('doctor_id') == $doctor->id ? 'selected' : '' }}>
                                {{ $doctor->user->name ?? 'N/A' }} - {{ $doctor->specialization ?? '' }}
                            </option>
                        @endforeach
                    </select>
                    @error('doctor_id')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                <div class="col-md-6">
                    <label for="appointment_date" class="form-label">Date *</label>
                    <input type="date" class="form-control @error('appointment_date') is-invalid @enderror" 
                           id="appointment_date" name="appointment_date" 
                           value="{{ old('appointment_date') }}" 
                           min="{{ date('Y-m-d') }}" required>
                    @error('appointment_date')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
            </div>

            <div class="row mb-3">
                <div class="col-md-6">
                    <label for="appointment_time" class="form-label">Time *</label>
                    <input type="time" class="form-control @error('appointment_time') is-invalid @enderror" 
                           id="appointment_time" name="appointment_time" 
                           value="{{ old('appointment_time') }}" required>
                    @error('appointment_time')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
            </div>

            <div class="mb-3">
                <label for="reason" class="form-label">Reason</label>
                <textarea class="form-control @error('reason') is-invalid @enderror" 
                          id="reason" name="reason" rows="3">{{ old('reason') }}</textarea>
                @error('reason')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="d-flex justify-content-end">
                <a href="{{ route('appointments.index') }}" class="btn btn-secondary me-2">Cancel</a>
                <button type="submit" class="btn btn-primary">Book Appointment</button>
            </div>
        </form>
    </div>
</div>
@endsection

