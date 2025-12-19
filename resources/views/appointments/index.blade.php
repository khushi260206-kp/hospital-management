@extends('layouts.app')

@section('title', 'Appointments')

@section('content')
<div class="row mb-4">
    <div class="col-md-6">
        <h2><i class="bi bi-calendar-check"></i> Appointments</h2>
    </div>
    <div class="col-md-6 text-end">
        <a href="{{ route('appointments.create') }}" class="btn btn-primary">
            <i class="bi bi-plus-circle"></i> Book Appointment
        </a>
    </div>
</div>

<div class="card">
    <div class="card-body">
        <form method="GET" class="mb-3">
            <div class="row">
                <div class="col-md-3">
                    <select name="status" class="form-select">
                        <option value="">All Status</option>
                        <option value="pending" {{ request('status') == 'pending' ? 'selected' : '' }}>Pending</option>
                        <option value="confirmed" {{ request('status') == 'confirmed' ? 'selected' : '' }}>Confirmed</option>
                        <option value="completed" {{ request('status') == 'completed' ? 'selected' : '' }}>Completed</option>
                        <option value="cancelled" {{ request('status') == 'cancelled' ? 'selected' : '' }}>Cancelled</option>
                    </select>
                </div>
                <div class="col-md-3">
                    <input type="date" name="date" class="form-control" value="{{ request('date') }}">
                </div>
                @if(auth()->user()->isAdmin() || auth()->user()->isReceptionist())
                    <div class="col-md-3">
                        <select name="doctor_id" class="form-select">
                            <option value="">All Doctors</option>
                            @foreach($doctors as $doctor)
                                <option value="{{ $doctor->id }}" {{ request('doctor_id') == $doctor->id ? 'selected' : '' }}>
                                    {{ $doctor->user->name ?? 'N/A' }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                @endif
                <div class="col-md-3">
                    <button type="submit" class="btn btn-primary w-100">Filter</button>
                </div>
            </div>
        </form>

        <div class="table-responsive">
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th>Date</th>
                        <th>Time</th>
                        @if(!auth()->user()->isPatient())
                            <th>Patient</th>
                        @endif
                        @if(!auth()->user()->isDoctor())
                            <th>Doctor</th>
                        @endif
                        <th>Reason</th>
                        <th>Status</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($appointments as $appointment)
                        <tr>
                            <td>{{ \Carbon\Carbon::parse($appointment->appointment_date)->format('M d, Y') }}</td>
                            <td>{{ \Carbon\Carbon::parse($appointment->appointment_time)->format('h:i A') }}</td>
                            @if(!auth()->user()->isPatient())
                                <td>{{ $appointment->patient->user->name }}</td>
                            @endif
                            @if(!auth()->user()->isDoctor())
                                <td>{{ $appointment->doctor->user->name }}</td>
                            @endif
                            <td>{{ $appointment->reason ?? 'N/A' }}</td>
                            <td>
                                <span class="badge bg-{{ $appointment->status === 'confirmed' ? 'success' : ($appointment->status === 'pending' ? 'warning' : ($appointment->status === 'completed' ? 'info' : 'secondary')) }}">
                                    {{ ucfirst($appointment->status) }}
                                </span>
                            </td>
                            <td>
                                <a href="{{ route('appointments.show', $appointment->id) }}" class="btn btn-sm btn-info">
                                    <i class="bi bi-eye"></i>
                                </a>
                                @if(auth()->user()->isDoctor() && $appointment->status !== 'completed' && $appointment->status !== 'cancelled')
                                    <form action="{{ route('appointments.complete', $appointment->id) }}" method="POST" class="d-inline">
                                        @csrf
                                        <button type="submit" class="btn btn-sm btn-success">
                                            <i class="bi bi-check-circle"></i> Complete
                                        </button>
                                    </form>
                                @endif
                                @if($appointment->status !== 'completed' && $appointment->status !== 'cancelled')
                                    <form action="{{ route('appointments.cancel', $appointment->id) }}" method="POST" class="d-inline">
                                        @csrf
                                        <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Are you sure?')">
                                            <i class="bi bi-x-circle"></i> Cancel
                                        </button>
                                    </form>
                                @endif
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="text-center">No appointments found</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="mt-3">
            {{ $appointments->links() }}
        </div>
    </div>
</div>
@endsection

