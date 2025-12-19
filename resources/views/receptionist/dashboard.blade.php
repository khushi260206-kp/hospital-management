@extends('layouts.app')

@section('title', 'Receptionist Dashboard')

@section('content')
<div class="page-header">
    <div class="d-flex justify-content-between align-items-center">
        <div>
            <h2 class="mb-1"><i class="bi bi-speedometer2"></i> Receptionist Dashboard</h2>
            <p class="text-muted mb-0">Welcome, {{ auth()->user()->name }}! Manage front desk operations efficiently.</p>
        </div>
        <div>
            <span class="badge bg-primary" style="font-size: 1rem; padding: 0.75rem 1.5rem;">
                <i class="bi bi-calendar3"></i> {{ now()->format('l, F d, Y') }}
            </span>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-md-4 mb-4">
        <div class="card h-100" style="border-left: 5px solid #667eea;">
            <div class="card-body text-center">
                <i class="bi bi-lightning-charge" style="font-size: 3rem; color: #667eea; margin-bottom: 1rem;"></i>
                <h5 class="mb-4">Quick Actions</h5>
                <a href="{{ route('admin.patients.create') }}" class="btn btn-primary w-100 mb-3" style="padding: 1rem;">
                    <i class="bi bi-person-plus"></i> Register Patient
                </a>
                <a href="{{ route('appointments.create') }}" class="btn btn-success w-100 mb-3" style="padding: 1rem;">
                    <i class="bi bi-calendar-plus"></i> Book Appointment
                </a>
                <a href="{{ route('billing.create') }}" class="btn btn-info w-100" style="padding: 1rem;">
                    <i class="bi bi-receipt"></i> Create Bill
                </a>
            </div>
        </div>
    </div>
    <div class="col-md-8 mb-4">
        <div class="card h-100">
            <div class="card-header">
                <h5 class="mb-0"><i class="bi bi-info-circle"></i> Welcome, Receptionist!</h5>
            </div>
            <div class="card-body">
                <p class="lead">Manage your front desk operations efficiently with these tools:</p>
                <div class="row mt-4">
                    <div class="col-md-6 mb-3">
                        <div class="d-flex align-items-start">
                            <div class="flex-shrink-0">
                                <div style="width: 50px; height: 50px; background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); border-radius: 10px; display: flex; align-items: center; justify-content: center;">
                                    <i class="bi bi-person-heart text-white" style="font-size: 1.5rem;"></i>
                                </div>
                            </div>
                            <div class="flex-grow-1 ms-3">
                                <h6>Patient Management</h6>
                                <p class="text-muted mb-0">Register new patients and manage existing patient records.</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6 mb-3">
                        <div class="d-flex align-items-start">
                            <div class="flex-shrink-0">
                                <div style="width: 50px; height: 50px; background: linear-gradient(135deg, #10b981 0%, #059669 100%); border-radius: 10px; display: flex; align-items: center; justify-content: center;">
                                    <i class="bi bi-calendar-check text-white" style="font-size: 1.5rem;"></i>
                                </div>
                            </div>
                            <div class="flex-grow-1 ms-3">
                                <h6>Appointment Booking</h6>
                                <p class="text-muted mb-0">Schedule and manage patient appointments with doctors.</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6 mb-3">
                        <div class="d-flex align-items-start">
                            <div class="flex-shrink-0">
                                <div style="width: 50px; height: 50px; background: linear-gradient(135deg, #3b82f6 0%, #2563eb 100%); border-radius: 10px; display: flex; align-items: center; justify-content: center;">
                                    <i class="bi bi-receipt text-white" style="font-size: 1.5rem;"></i>
                                </div>
                            </div>
                            <div class="flex-grow-1 ms-3">
                                <h6>Billing & Invoices</h6>
                                <p class="text-muted mb-0">Generate bills and manage payment processing.</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6 mb-3">
                        <div class="d-flex align-items-start">
                            <div class="flex-shrink-0">
                                <div style="width: 50px; height: 50px; background: linear-gradient(135deg, #f59e0b 0%, #d97706 100%); border-radius: 10px; display: flex; align-items: center; justify-content: center;">
                                    <i class="bi bi-clipboard-data text-white" style="font-size: 1.5rem;"></i>
                                </div>
                            </div>
                            <div class="flex-grow-1 ms-3">
                                <h6>Reports & Analytics</h6>
                                <p class="text-muted mb-0">View daily reports and track operations.</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

