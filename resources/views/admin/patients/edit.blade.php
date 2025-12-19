@extends('layouts.app')

@section('title', 'Edit Patient')

@section('content')
<div class="row mb-4">
    <div class="col-12">
        <h2><i class="bi bi-pencil"></i> Edit Patient</h2>
    </div>
</div>

<div class="card">
    <div class="card-body">
        <form method="POST" action="{{ route('admin.patients.update', $patient->id) }}">
            @csrf
            @method('PUT')
            
            <h5 class="mb-3">Personal Information</h5>
            <div class="row mb-3">
                <div class="col-md-6">
                    <label for="name" class="form-label">Name *</label>
                    <input type="text" class="form-control @error('name') is-invalid @enderror" 
                           id="name" name="name" value="{{ old('name', $patient->user->name) }}" required>
                    @error('name')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                <div class="col-md-6">
                    <label for="email" class="form-label">Email *</label>
                    <input type="email" class="form-control @error('email') is-invalid @enderror" 
                           id="email" name="email" value="{{ old('email', $patient->user->email) }}" required>
                    @error('email')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
            </div>

            <div class="row mb-3">
                <div class="col-md-6">
                    <label for="phone" class="form-label">Phone</label>
                    <input type="text" class="form-control @error('phone') is-invalid @enderror" 
                           id="phone" name="phone" value="{{ old('phone', $patient->user->phone) }}">
                    @error('phone')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                <div class="col-md-6">
                    <label for="blood_group" class="form-label">Blood Group</label>
                    <input type="text" class="form-control @error('blood_group') is-invalid @enderror" 
                           id="blood_group" name="blood_group" value="{{ old('blood_group', $patient->blood_group) }}">
                    @error('blood_group')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
            </div>

            <div class="row mb-3">
                <div class="col-md-6">
                    <label for="height" class="form-label">Height (cm)</label>
                    <input type="number" step="0.01" class="form-control @error('height') is-invalid @enderror" 
                           id="height" name="height" value="{{ old('height', $patient->height) }}">
                    @error('height')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                <div class="col-md-6">
                    <label for="weight" class="form-label">Weight (kg)</label>
                    <input type="number" step="0.01" class="form-control @error('weight') is-invalid @enderror" 
                           id="weight" name="weight" value="{{ old('weight', $patient->weight) }}">
                    @error('weight')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
            </div>

            <div class="mb-3">
                <label for="allergies" class="form-label">Allergies</label>
                <textarea class="form-control @error('allergies') is-invalid @enderror" 
                          id="allergies" name="allergies" rows="2">{{ old('allergies', $patient->allergies) }}</textarea>
                @error('allergies')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="mb-3">
                <label for="medical_history" class="form-label">Medical History</label>
                <textarea class="form-control @error('medical_history') is-invalid @enderror" 
                          id="medical_history" name="medical_history" rows="3">{{ old('medical_history', $patient->medical_history) }}</textarea>
                @error('medical_history')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="d-flex justify-content-end">
                <a href="{{ route('admin.patients.index') }}" class="btn btn-secondary me-2">Cancel</a>
                <button type="submit" class="btn btn-primary">Update Patient</button>
            </div>
        </form>
    </div>
</div>
@endsection

