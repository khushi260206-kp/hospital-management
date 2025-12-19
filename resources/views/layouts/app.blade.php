<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Hospital Management System')</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css">
    <style>
        :root {
            --primary-color: #667eea;
            --secondary-color: #764ba2;
            --success-color: #10b981;
            --danger-color: #ef4444;
            --warning-color: #f59e0b;
            --info-color: #3b82f6;
            --dark-color: #1f2937;
            --light-bg: #f8fafc;
        }
        
        body {
            background-color: var(--light-bg);
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }
        
        .navbar {
            background: linear-gradient(135deg, var(--primary-color) 0%, var(--secondary-color) 100%) !important;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
            padding: 1rem 0;
        }
        
        .navbar-brand {
            font-size: 1.5rem;
            font-weight: 700;
            color: white !important;
            display: flex;
            align-items: center;
            gap: 10px;
        }
        
        .navbar-brand i {
            font-size: 2rem;
        }
        
        .navbar-nav .nav-link {
            color: rgba(255, 255, 255, 0.9) !important;
            font-weight: 500;
            padding: 0.5rem 1rem !important;
            margin: 0 0.25rem;
            border-radius: 8px;
            transition: all 0.3s;
        }
        
        .navbar-nav .nav-link:hover {
            background: rgba(255, 255, 255, 0.2);
            color: white !important;
        }
        
        .dropdown-menu {
            border-radius: 10px;
            box-shadow: 0 5px 15px rgba(0,0,0,0.1);
            border: none;
            margin-top: 10px;
        }
        
        .dropdown-item {
            padding: 0.75rem 1.5rem;
            transition: all 0.2s;
        }
        
        .dropdown-item:hover {
            background: var(--light-bg);
            color: var(--primary-color);
        }
        
        .card {
            border: none;
            border-radius: 15px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.08);
            margin-bottom: 2rem;
            transition: transform 0.2s, box-shadow 0.2s;
        }
        
        .card:hover {
            transform: translateY(-2px);
            box-shadow: 0 5px 20px rgba(0,0,0,0.12);
        }
        
        .card-header {
            background: linear-gradient(135deg, var(--primary-color) 0%, var(--secondary-color) 100%);
            color: white;
            border-radius: 15px 15px 0 0 !important;
            padding: 1.25rem;
            font-weight: 600;
        }
        
        .btn {
            border-radius: 10px;
            padding: 0.6rem 1.5rem;
            font-weight: 600;
            transition: all 0.3s;
        }
        
        .btn-primary {
            background: linear-gradient(135deg, var(--primary-color) 0%, var(--secondary-color) 100%);
            border: none;
        }
        
        .btn-primary:hover {
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(102, 126, 234, 0.4);
        }
        
        .btn-success {
            background: linear-gradient(135deg, var(--success-color) 0%, #059669 100%);
            border: none;
        }
        
        .btn-danger {
            background: linear-gradient(135deg, var(--danger-color) 0%, #dc2626 100%);
            border: none;
        }
        
        .btn-info {
            background: linear-gradient(135deg, var(--info-color) 0%, #2563eb 100%);
            border: none;
        }
        
        .btn-warning {
            background: linear-gradient(135deg, var(--warning-color) 0%, #d97706 100%);
            border: none;
        }
        
        .table {
            border-radius: 10px;
            overflow: hidden;
        }
        
        .table thead {
            background: linear-gradient(135deg, var(--primary-color) 0%, var(--secondary-color) 100%);
            color: white;
        }
        
        .table thead th {
            border: none;
            padding: 1rem;
            font-weight: 600;
        }
        
        .table tbody tr {
            transition: all 0.2s;
        }
        
        .table tbody tr:hover {
            background-color: #f8fafc;
            transform: scale(1.01);
        }
        
        .table tbody td {
            padding: 1rem;
            vertical-align: middle;
        }
        
        .badge {
            padding: 0.5rem 1rem;
            border-radius: 20px;
            font-weight: 600;
        }
        
        .form-control, .form-select {
            border-radius: 10px;
            border: 2px solid #e5e7eb;
            padding: 0.75rem 1rem;
            transition: all 0.3s;
        }
        
        .form-control:focus, .form-select:focus {
            border-color: var(--primary-color);
            box-shadow: 0 0 0 0.2rem rgba(102, 126, 234, 0.25);
        }
        
        .alert {
            border-radius: 10px;
            border: none;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
        }
        
        .stat-card {
            border-radius: 15px;
            padding: 2rem;
            color: white;
            transition: transform 0.3s;
            box-shadow: 0 5px 15px rgba(0,0,0,0.2);
        }
        
        .stat-card:hover {
            transform: translateY(-5px);
        }
        
        .stat-card h2 {
            font-size: 2.5rem;
            font-weight: 700;
            margin: 0.5rem 0;
        }
        
        .stat-card h5 {
            opacity: 0.9;
            font-weight: 500;
        }
        
        main {
            padding: 2rem 0;
        }
        
        h2 {
            color: var(--dark-color);
            font-weight: 700;
            margin-bottom: 1.5rem;
        }
        
        .page-header {
            background: white;
            padding: 2rem;
            border-radius: 15px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.08);
            margin-bottom: 2rem;
        }
    </style>
    @stack('styles')
</head>
<body>
    <nav class="navbar navbar-expand-lg navbar-dark">
        <div class="container-fluid">
            <a class="navbar-brand" href="@auth
                @if(auth()->user()->isAdmin()){{ route('admin.dashboard') }}
                @elseif(auth()->user()->isDoctor()){{ route('doctor.dashboard') }}
                @elseif(auth()->user()->isReceptionist()){{ route('receptionist.dashboard') }}
                @elseif(auth()->user()->isPatient()){{ route('patient.dashboard') }}
                @else{{ route('login') }}
                @endif
            @else{{ route('login') }}
            @endauth">
                <i class="bi bi-hospital"></i> Hospital Management
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                @auth
                    <ul class="navbar-nav me-auto">
                        @if(auth()->user()->isAdmin())
                            <li class="nav-item">
                                <a class="nav-link" href="{{ route('admin.dashboard') }}">
                                    <i class="bi bi-speedometer2"></i> Dashboard
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="{{ route('admin.doctors.index') }}">
                                    <i class="bi bi-people"></i> Doctors
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="{{ route('admin.patients.index') }}">
                                    <i class="bi bi-person-heart"></i> Patients
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="{{ route('admin.departments.index') }}">
                                    <i class="bi bi-building"></i> Departments
                                </a>
                            </li>
                        @elseif(auth()->user()->isDoctor())
                            <li class="nav-item">
                                <a class="nav-link" href="{{ route('doctor.dashboard') }}">
                                    <i class="bi bi-speedometer2"></i> Dashboard
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="{{ route('doctor.appointments') }}">
                                    <i class="bi bi-calendar-check"></i> Appointments
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="{{ route('doctor.medical-records.index') }}">
                                    <i class="bi bi-file-medical"></i> Medical Records
                                </a>
                            </li>
                        @elseif(auth()->user()->isPatient())
                            <li class="nav-item">
                                <a class="nav-link" href="{{ route('patient.dashboard') }}">
                                    <i class="bi bi-speedometer2"></i> Dashboard
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="{{ route('patient.appointments') }}">
                                    <i class="bi bi-calendar-check"></i> Appointments
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="{{ route('patient.medical-records') }}">
                                    <i class="bi bi-file-medical"></i> Medical Records
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="{{ route('patient.bills') }}">
                                    <i class="bi bi-receipt"></i> Bills
                                </a>
                            </li>
                        @elseif(auth()->user()->isReceptionist())
                            <li class="nav-item">
                                <a class="nav-link" href="{{ route('receptionist.dashboard') }}">
                                    <i class="bi bi-speedometer2"></i> Dashboard
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="{{ route('admin.patients.index') }}">
                                    <i class="bi bi-person-heart"></i> Patients
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="{{ route('billing.index') }}">
                                    <i class="bi bi-receipt"></i> Billing
                                </a>
                            </li>
                        @endif
                        @if(!auth()->user()->isDoctor() && !auth()->user()->isPatient())
                            <li class="nav-item">
                                <a class="nav-link" href="{{ route('appointments.index') }}">
                                    <i class="bi bi-calendar-event"></i> Appointments
                                </a>
                            </li>
                        @endif
                    </ul>
                    <ul class="navbar-nav">
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown" style="color: white !important;">
                                <i class="bi bi-person-circle"></i> {{ auth()->user()->name }}
                                <span class="badge bg-light text-dark ms-2">{{ ucfirst(auth()->user()->role) }}</span>
                            </a>
                            <ul class="dropdown-menu dropdown-menu-end">
                                <li>
                                    <form method="POST" action="{{ route('logout') }}">
                                        @csrf
                                        <button type="submit" class="dropdown-item">
                                            <i class="bi bi-box-arrow-right"></i> Logout
                                        </button>
                                    </form>
                                </li>
                            </ul>
                        </li>
                    </ul>
                @endauth
            </div>
        </div>
    </nav>

    <main class="container-fluid py-4">
        @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                <i class="bi bi-check-circle-fill"></i> {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif

        @if($errors->any())
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                <i class="bi bi-exclamation-triangle-fill"></i>
                <ul class="mb-0">
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif

        @yield('content')
    </main>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    @stack('scripts')
</body>
</html>
