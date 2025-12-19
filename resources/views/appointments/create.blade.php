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
                    <label for="department_id" class="form-label">Department *</label>
                    <select class="form-select @error('department_id') is-invalid @enderror" 
                            id="department_id" name="department_id">
                        <option value="">Select Department</option>
                        @foreach($departments as $department)
                            <option value="{{ $department->id }}" {{ old('department_id') == $department->id ? 'selected' : '' }}>
                                {{ $department->name }}
                            </option>
                        @endforeach
                    </select>
                    @error('department_id')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                    <small class="text-muted">Select department to get doctor recommendation</small>
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

            <!-- Doctor Recommendation Display -->
            <div id="recommendation-alert" class="alert alert-info d-none mb-3" role="alert">
                <div class="d-flex align-items-center">
                    <i class="bi bi-lightbulb-fill me-2"></i>
                    <div class="flex-grow-1">
                        <strong>Recommended Doctor:</strong> <span id="recommended-doctor-name"></span>
                        <br>
                        <small id="recommended-doctor-details" class="text-muted"></small>
                    </div>
                    <button type="button" class="btn btn-sm btn-outline-secondary" id="change-doctor-btn">
                        <i class="bi bi-pencil"></i> Change Doctor
                    </button>
                </div>
            </div>

            <div class="row mb-3" id="doctor-selection-row">
                <div class="col-md-6">
                    <label for="doctor_id" class="form-label">Doctor *</label>
                    <select class="form-select @error('doctor_id') is-invalid @enderror" 
                            id="doctor_id" name="doctor_id" required>
                        <option value="">Select Doctor</option>
                        @foreach($doctors as $doctor)
                            <option value="{{ $doctor->id }}" {{ old('doctor_id') == $doctor->id ? 'selected' : '' }}>
                                @if($doctor->user)
                                    {{ $doctor->user->name }} - {{ $doctor->specialization ?? 'General' }}
                                    @if($doctor->department)
                                        ({{ $doctor->department->name }})
                                    @endif
                                @else
                                    Doctor ID: {{ $doctor->id }} - {{ $doctor->specialization ?? 'General' }}
                                @endif
                            </option>
                        @endforeach
                    </select>
                    @error('doctor_id')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                    <small class="text-muted">Or select manually</small>
                </div>
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

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    const departmentSelect = document.getElementById('department_id');
    const dateInput = document.getElementById('appointment_date');
    const timeInput = document.getElementById('appointment_time');
    const doctorSelect = document.getElementById('doctor_id');
    const recommendationAlert = document.getElementById('recommendation-alert');
    const recommendedDoctorName = document.getElementById('recommended-doctor-name');
    const recommendedDoctorDetails = document.getElementById('recommended-doctor-details');
    const changeDoctorBtn = document.getElementById('change-doctor-btn');
    const doctorSelectionRow = document.getElementById('doctor-selection-row');

    let recommendedDoctorId = null;

    // Function to get recommended doctor
    function getRecommendedDoctor() {
        const departmentId = departmentSelect.value;
        const date = dateInput.value;
        const time = timeInput.value;

        if (!departmentId || !date || !time) {
            hideRecommendation();
            return;
        }

        // Show loading state
        recommendationAlert.classList.remove('d-none', 'alert-danger');
        recommendationAlert.classList.add('alert-info');
        recommendedDoctorName.textContent = 'Loading...';
        recommendedDoctorDetails.textContent = '';

        // Make AJAX request
        fetch('{{ route("appointments.recommend-doctor") }}', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
            },
            body: JSON.stringify({
                department_id: departmentId,
                appointment_date: date,
                appointment_time: time
            })
        })
        .then(response => response.json())
        .then(data => {
            if (data.success && data.doctor) {
                // Show recommendation
                recommendedDoctorId = data.doctor.id;
                recommendedDoctorName.textContent = data.doctor.name;
                recommendedDoctorDetails.textContent = 
                    `${data.doctor.specialization || 'General'} | ${data.doctor.experience_years || 0} years experience`;
                
                // Auto-select doctor in dropdown
                doctorSelect.value = data.doctor.id;
                
                // Keep dropdown visible but highlight it
                doctorSelectionRow.classList.remove('d-none');
                doctorSelect.classList.add('border-success', 'border-2');
                
                // Show success message
                recommendationAlert.classList.remove('d-none', 'alert-danger');
                recommendationAlert.classList.add('alert-info');
                
                // Trigger change event to ensure form validation
                doctorSelect.dispatchEvent(new Event('change'));
            } else {
                // No doctor available
                recommendedDoctorName.textContent = 'No doctors available';
                recommendedDoctorDetails.textContent = data.message || 'Please try a different date or time.';
                recommendationAlert.classList.remove('d-none', 'alert-info');
                recommendationAlert.classList.add('alert-danger');
                
                // Show manual selection
                doctorSelectionRow.classList.remove('d-none');
                doctorSelect.value = '';
                doctorSelect.classList.remove('border-success', 'border-2');
            }
        })
        .catch(error => {
            console.error('Error:', error);
            hideRecommendation();
        });
    }

    // Function to hide recommendation
    function hideRecommendation() {
        recommendationAlert.classList.add('d-none');
        doctorSelectionRow.classList.remove('d-none');
        doctorSelect.classList.remove('border-success', 'border-2');
        recommendedDoctorId = null;
    }

    // Event listeners
    departmentSelect.addEventListener('change', function() {
        if (this.value && dateInput.value && timeInput.value) {
            getRecommendedDoctor();
        } else {
            hideRecommendation();
        }
    });

    dateInput.addEventListener('change', function() {
        if (departmentSelect.value && this.value && timeInput.value) {
            getRecommendedDoctor();
        } else {
            hideRecommendation();
        }
    });

    timeInput.addEventListener('change', function() {
        if (departmentSelect.value && dateInput.value && this.value) {
            getRecommendedDoctor();
        } else {
            hideRecommendation();
        }
    });

    // Change doctor button
    changeDoctorBtn.addEventListener('click', function() {
        recommendationAlert.classList.add('d-none');
        doctorSelect.classList.remove('border-success', 'border-2');
        doctorSelect.focus();
        // Don't clear the selected value, just remove the highlight
    });

    // When user manually changes doctor, remove highlight
    doctorSelect.addEventListener('change', function() {
        if (this.value !== recommendedDoctorId) {
            doctorSelect.classList.remove('border-success', 'border-2');
        }
    });

    // If all fields are pre-filled, get recommendation
    if (departmentSelect.value && dateInput.value && timeInput.value) {
        getRecommendedDoctor();
    }
});
</script>
@endpush
@endsection

