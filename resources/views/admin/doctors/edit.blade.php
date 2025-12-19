@extends('layouts.app')

@section('title', 'Edit Doctor')

@section('content')
<div class="row mb-4">
    <div class="col-12">
        <h2><i class="bi bi-pencil"></i> Edit Doctor</h2>
    </div>
</div>

<div class="card">
    <div class="card-body">
        <form method="POST" action="{{ route('admin.doctors.update', $doctor->id) }}">
            @csrf
            @method('PUT')
            
            <h5 class="mb-3">Personal Information</h5>
            <div class="row mb-3">
                <div class="col-md-6">
                    <label for="name" class="form-label">Name *</label>
                    <input type="text" class="form-control @error('name') is-invalid @enderror" 
                           id="name" name="name" value="{{ old('name', $doctor->user->name) }}" required>
                    @error('name')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                <div class="col-md-6">
                    <label for="email" class="form-label">Email *</label>
                    <input type="email" class="form-control @error('email') is-invalid @enderror" 
                           id="email" name="email" value="{{ old('email', $doctor->user->email) }}" required>
                    @error('email')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
            </div>

            <div class="row mb-3">
                <div class="col-md-6">
                    <label for="phone" class="form-label">Phone</label>
                    <input type="text" class="form-control @error('phone') is-invalid @enderror" 
                           id="phone" name="phone" value="{{ old('phone', $doctor->user->phone) }}">
                    @error('phone')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                <div class="col-md-6">
                    <label for="department_id" class="form-label">Department *</label>
                    <select class="form-select @error('department_id') is-invalid @enderror" 
                            id="department_id" name="department_id" required>
                        @foreach($departments as $dept)
                            <option value="{{ $dept->id }}" {{ old('department_id', $doctor->department_id) == $dept->id ? 'selected' : '' }}>
                                {{ $dept->name }}
                            </option>
                        @endforeach
                    </select>
                    @error('department_id')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
            </div>

            <hr>
            <h5 class="mb-3">Professional Information</h5>
            <div class="row mb-3">
                <div class="col-md-6">
                    <label for="specialization" class="form-label">Specialization *</label>
                    <input type="text" class="form-control @error('specialization') is-invalid @enderror" 
                           id="specialization" name="specialization" value="{{ old('specialization', $doctor->specialization) }}" required>
                    @error('specialization')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                <div class="col-md-6">
                    <label for="consultation_fee" class="form-label">Consultation Fee</label>
                    <input type="number" step="0.01" class="form-control @error('consultation_fee') is-invalid @enderror" 
                           id="consultation_fee" name="consultation_fee" value="{{ old('consultation_fee', $doctor->consultation_fee) }}" min="0">
                    @error('consultation_fee')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
            </div>

            <div class="row mb-3">
                <div class="col-md-6">
                    <label for="availability" class="form-label">Availability</label>
                    <select class="form-select @error('availability') is-invalid @enderror" id="availability" name="availability">
                        <option value="available" {{ old('availability', $doctor->availability) == 'available' ? 'selected' : '' }}>Available</option>
                        <option value="busy" {{ old('availability', $doctor->availability) == 'busy' ? 'selected' : '' }}>Busy</option>
                        <option value="on_leave" {{ old('availability', $doctor->availability) == 'on_leave' ? 'selected' : '' }}>On Leave</option>
                    </select>
                    @error('availability')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
            </div>

            <div class="d-flex justify-content-end">
                <a href="{{ route('admin.doctors.index') }}" class="btn btn-secondary me-2">Cancel</a>
                <button type="submit" class="btn btn-primary">Update Doctor</button>
            </div>
        </form>
    </div>
</div>
@endsection

