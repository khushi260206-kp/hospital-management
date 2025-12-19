@extends('layouts.app')

@section('title', 'Admin Dashboard')

@section('content')
<div class="page-header">
    <div class="d-flex justify-content-between align-items-center">
        <div>
            <h2 class="mb-1"><i class="bi bi-speedometer2"></i> Admin Dashboard</h2>
            <p class="text-muted mb-0">Welcome back, {{ auth()->user()->name }}! Here's your hospital overview.</p>
        </div>
        <div>
            <span class="badge bg-primary" style="font-size: 1rem; padding: 0.75rem 1.5rem;">
                <i class="bi bi-calendar3"></i> {{ now()->format('l, F d, Y') }}
            </span>
        </div>
    </div>
</div>

<div class="row mb-4">
    <div class="col-md-3 mb-3">
        <div class="stat-card" style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <h5>Total Doctors</h5>
                    <h2>{{ $stats['total_doctors'] }}</h2>
                </div>
                <i class="bi bi-people" style="font-size: 3rem; opacity: 0.3;"></i>
            </div>
        </div>
    </div>
    <div class="col-md-3 mb-3">
        <div class="stat-card" style="background: linear-gradient(135deg, #10b981 0%, #059669 100%);">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <h5>Total Patients</h5>
                    <h2>{{ $stats['total_patients'] }}</h2>
                </div>
                <i class="bi bi-person-heart" style="font-size: 3rem; opacity: 0.3;"></i>
            </div>
        </div>
    </div>
    <div class="col-md-3 mb-3">
        <div class="stat-card" style="background: linear-gradient(135deg, #3b82f6 0%, #2563eb 100%);">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <h5>Total Appointments</h5>
                    <h2>{{ $stats['total_appointments'] }}</h2>
                </div>
                <i class="bi bi-calendar-check" style="font-size: 3rem; opacity: 0.3;"></i>
            </div>
        </div>
    </div>
    <div class="col-md-3 mb-3">
        <div class="stat-card" style="background: linear-gradient(135deg, #f59e0b 0%, #d97706 100%);">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <h5>Pending Appointments</h5>
                    <h2>{{ $stats['pending_appointments'] }}</h2>
                </div>
                <i class="bi bi-clock-history" style="font-size: 3rem; opacity: 0.3;"></i>
            </div>
        </div>
    </div>
</div>

<div class="row mb-4">
    <div class="col-md-4 mb-3">
        <div class="stat-card" style="background: linear-gradient(135deg, #ef4444 0%, #dc2626 100%);">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <h5>Today's Appointments</h5>
                    <h2>{{ $stats['today_appointments'] }}</h2>
                </div>
                <i class="bi bi-calendar-day" style="font-size: 3rem; opacity: 0.3;"></i>
            </div>
        </div>
    </div>
    <div class="col-md-4 mb-3">
        <div class="stat-card" style="background: linear-gradient(135deg, #1f2937 0%, #111827 100%);">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <h5>Total Revenue</h5>
                    <h2>${{ number_format($stats['total_revenue'], 2) }}</h2>
                </div>
                <i class="bi bi-currency-dollar" style="font-size: 3rem; opacity: 0.3;"></i>
            </div>
        </div>
    </div>
    <div class="col-md-4 mb-3">
        <div class="stat-card" style="background: linear-gradient(135deg, #6b7280 0%, #4b5563 100%);">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <h5>Pending Bills</h5>
                    <h2>{{ $stats['pending_bills'] }}</h2>
                </div>
                <i class="bi bi-receipt-cutoff" style="font-size: 3rem; opacity: 0.3;"></i>
            </div>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-header">
                <h5 class="mb-0"><i class="bi bi-clock-history"></i> Recent Appointments</h5>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-hover">
                        <thead>
                            <tr>
                                <th>Date</th>
                                <th>Time</th>
                                <th>Patient</th>
                                <th>Doctor</th>
                                <th>Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($recentAppointments as $appointment)
                                <tr>
                                    <td><i class="bi bi-calendar3"></i> {{ \Carbon\Carbon::parse($appointment->appointment_date)->format('M d, Y') }}</td>
                                    <td><i class="bi bi-clock"></i> {{ \Carbon\Carbon::parse($appointment->appointment_time)->format('h:i A') }}</td>
                                    <td><i class="bi bi-person"></i> {{ $appointment->patient->user->name }}</td>
                                    <td><i class="bi bi-heart-pulse"></i> {{ $appointment->doctor->user->name }}</td>
                                    <td>
                                        <span class="badge bg-{{ $appointment->status === 'confirmed' ? 'success' : ($appointment->status === 'pending' ? 'warning' : 'secondary') }}">
                                            {{ ucfirst($appointment->status) }}
                                        </span>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5" class="text-center py-4">
                                        <i class="bi bi-inbox" style="font-size: 2rem; color: #ccc;"></i>
                                        <p class="text-muted mt-2">No appointments found</p>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

