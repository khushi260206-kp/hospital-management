@extends('layouts.app')

@section('title', 'Medical Records')

@section('content')
<div class="row mb-4">
    <div class="col-md-6">
        <h2><i class="bi bi-file-medical"></i> Medical Records</h2>
    </div>
    <div class="col-md-6 text-end">
        <a href="{{ route('doctor.medical-records.create') }}" class="btn btn-primary">
            <i class="bi bi-plus-circle"></i> Add Medical Record
        </a>
    </div>
</div>

<div class="card">
    <div class="card-body">
        <form method="GET" class="mb-3">
            <div class="row">
                <div class="col-md-4">
                    <select name="patient_id" class="form-select">
                        <option value="">All Patients</option>
                        @foreach($patients as $patient)
                            <option value="{{ $patient->id }}" {{ request('patient_id') == $patient->id ? 'selected' : '' }}>
                                {{ $patient->user->name }} ({{ $patient->patient_id }})
                            </option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-2">
                    <button type="submit" class="btn btn-primary w-100">Filter</button>
                </div>
            </div>
        </form>

        <div class="table-responsive">
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th>Date</th>
                        <th>Patient</th>
                        <th>Diagnosis</th>
                        <th>Symptoms</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($records as $record)
                        <tr>
                            <td>{{ \Carbon\Carbon::parse($record->record_date)->format('M d, Y') }}</td>
                            <td>{{ $record->patient->user->name }}</td>
                            <td>{{ Str::limit($record->diagnosis, 50) }}</td>
                            <td>{{ Str::limit($record->symptoms ?? 'N/A', 50) }}</td>
                            <td>
                                <a href="{{ route('doctor.medical-records.show', $record->id) }}" class="btn btn-sm btn-info">
                                    <i class="bi bi-eye"></i>
                                </a>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="text-center">No medical records found</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="mt-3">
            {{ $records->links() }}
        </div>
    </div>
</div>
@endsection

