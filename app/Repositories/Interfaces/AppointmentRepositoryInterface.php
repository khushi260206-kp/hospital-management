<?php

namespace App\Repositories\Interfaces;

use App\Models\Appointment;
use Illuminate\Pagination\LengthAwarePaginator;

interface AppointmentRepositoryInterface
{
    public function getAll(array $filters = []): LengthAwarePaginator;
    public function findById(int $id): ?Appointment;
    public function create(array $data): Appointment;
    public function update(int $id, array $data): bool;
    public function delete(int $id): bool;
    public function getByDoctor(int $doctorId, array $filters = []): LengthAwarePaginator;
    public function getByPatient(int $patientId, array $filters = []): LengthAwarePaginator;
    public function checkAvailability(int $doctorId, string $date, string $time): bool;
}

