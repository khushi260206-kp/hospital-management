<?php

namespace App\Providers;

use App\Repositories\Implementations\AppointmentRepository;
use App\Repositories\Implementations\BillRepository;
use App\Repositories\Implementations\DepartmentRepository;
use App\Repositories\Implementations\DoctorRepository;
use App\Repositories\Implementations\MedicalRecordRepository;
use App\Repositories\Implementations\PatientRepository;
use App\Repositories\Interfaces\AppointmentRepositoryInterface;
use App\Repositories\Interfaces\BillRepositoryInterface;
use App\Repositories\Interfaces\DepartmentRepositoryInterface;
use App\Repositories\Interfaces\DoctorRepositoryInterface;
use App\Repositories\Interfaces\MedicalRecordRepositoryInterface;
use App\Repositories\Interfaces\PatientRepositoryInterface;
use Illuminate\Support\ServiceProvider;

class RepositoryServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        $this->app->bind(DoctorRepositoryInterface::class, DoctorRepository::class);
        $this->app->bind(PatientRepositoryInterface::class, PatientRepository::class);
        $this->app->bind(AppointmentRepositoryInterface::class, AppointmentRepository::class);
        $this->app->bind(DepartmentRepositoryInterface::class, DepartmentRepository::class);
        $this->app->bind(MedicalRecordRepositoryInterface::class, MedicalRecordRepository::class);
        $this->app->bind(BillRepositoryInterface::class, BillRepository::class);
    }

    public function boot(): void
    {
        //
    }
}

