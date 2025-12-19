<?php

use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\Admin\DoctorController;
use App\Http\Controllers\Admin\PatientController;
use App\Http\Controllers\Admin\DepartmentController;
use App\Http\Controllers\AppointmentController;
use App\Http\Controllers\Doctor\DoctorDashboardController;
use App\Http\Controllers\Doctor\MedicalRecordController;
use App\Http\Controllers\Patient\PatientDashboardController;
use App\Http\Controllers\BillingController;
use Illuminate\Support\Facades\Route;

// Home
Route::get('/', function () {
    return redirect()->route('login');
});

// Authentication Routes
Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
Route::post('/login', [AuthController::class, 'login']);
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// Admin Routes
Route::prefix('admin')->middleware(['auth', 'role:admin'])->name('admin.')->group(function () {
    Route::get('/dashboard', [AdminController::class, 'dashboard'])->name('dashboard');
    
    // Doctors Management
    Route::resource('doctors', DoctorController::class);
    
    // Departments Management
    Route::get('/departments', [DepartmentController::class, 'index'])->name('departments.index');
    Route::post('/departments', [DepartmentController::class, 'store'])->name('departments.store');
    Route::put('/departments/{id}', [DepartmentController::class, 'update'])->name('departments.update');
    Route::delete('/departments/{id}', [DepartmentController::class, 'destroy'])->name('departments.destroy');
});

// Patients Management (Admin and Receptionist)
Route::prefix('admin')->middleware(['auth', 'role:admin,receptionist'])->name('admin.')->group(function () {
    Route::resource('patients', PatientController::class);
});

// Doctor Routes
Route::prefix('doctor')->middleware(['auth', 'role:doctor'])->name('doctor.')->group(function () {
    Route::get('/dashboard', [DoctorDashboardController::class, 'dashboard'])->name('dashboard');
    Route::get('/appointments', [DoctorDashboardController::class, 'appointments'])->name('appointments');
    
    // Medical Records
    Route::get('/medical-records', [MedicalRecordController::class, 'index'])->name('medical-records.index');
    Route::get('/medical-records/create', [MedicalRecordController::class, 'create'])->name('medical-records.create');
    Route::post('/medical-records', [MedicalRecordController::class, 'store'])->name('medical-records.store');
    Route::get('/medical-records/{id}', [MedicalRecordController::class, 'show'])->name('medical-records.show');
});

// Patient Routes
Route::prefix('patient')->middleware(['auth', 'role:patient'])->name('patient.')->group(function () {
    Route::get('/dashboard', [PatientDashboardController::class, 'dashboard'])->name('dashboard');
    Route::get('/appointments', [PatientDashboardController::class, 'appointments'])->name('appointments');
    Route::get('/medical-records', [PatientDashboardController::class, 'medicalRecords'])->name('medical-records');
    Route::get('/bills', [PatientDashboardController::class, 'bills'])->name('bills');
});

// Receptionist Routes
Route::prefix('receptionist')->middleware(['auth', 'role:receptionist'])->name('receptionist.')->group(function () {
    Route::get('/dashboard', function () {
        return view('receptionist.dashboard');
    })->name('dashboard');
});

// Appointments (Common Routes)
Route::middleware('auth')->group(function () {
    Route::resource('appointments', AppointmentController::class);
    Route::post('/appointments/{id}/cancel', [AppointmentController::class, 'cancel'])->name('appointments.cancel');
    Route::post('/appointments/{id}/complete', [AppointmentController::class, 'complete'])->name('appointments.complete');
});

// Billing Routes
Route::prefix('billing')->middleware(['auth', 'role:admin,receptionist'])->name('billing.')->group(function () {
    Route::get('/', [BillingController::class, 'index'])->name('index');
    Route::get('/create', [BillingController::class, 'create'])->name('create');
    Route::post('/', [BillingController::class, 'store'])->name('store');
    Route::get('/{id}', [BillingController::class, 'show'])->name('show');
    Route::post('/{id}/payment-status', [BillingController::class, 'updatePaymentStatus'])->name('update-payment-status');
});

