@extends('layouts.app')

@section('title', 'Medical Records')

@section('content')
<div class="row mb-4">
    <div class="col-12">
        <h2><i class="bi bi-file-medical"></i> Medical Records</h2>
    </div>
</div>

<div class="card">
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th>Date</th>
                        <th>Doctor</th>
                        <th>Diagnosis</th>
                        <th>Symptoms</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($records as $record)
                        <tr>
                            <td>{{ \Carbon\Carbon::parse($record->record_date)->format('M d, Y') }}</td>
                            <td>{{ $record->doctor->user->name }}</td>
                            <td>{{ Str::limit($record->diagnosis, 50) }}</td>
                            <td>{{ Str::limit($record->symptoms ?? 'N/A', 50) }}</td>
                            <td>
                                <button type="button" class="btn btn-sm btn-info" data-bs-toggle="modal" data-bs-target="#recordModal{{ $record->id }}">
                                    <i class="bi bi-eye"></i> View
                                </button>
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

@foreach($records as $record)
<div class="modal fade" id="recordModal{{ $record->id }}" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Medical Record - {{ \Carbon\Carbon::parse($record->record_date)->format('M d, Y') }}</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <p><strong>Doctor:</strong> {{ $record->doctor->user->name }}</p>
                <p><strong>Date:</strong> {{ \Carbon\Carbon::parse($record->record_date)->format('M d, Y') }}</p>
                <p><strong>Diagnosis:</strong></p>
                <p>{{ $record->diagnosis }}</p>
                @if($record->symptoms)
                    <p><strong>Symptoms:</strong></p>
                    <p>{{ $record->symptoms }}</p>
                @endif
                @if($record->notes)
                    <p><strong>Notes:</strong></p>
                    <p>{{ $record->notes }}</p>
                @endif
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>
@endforeach
@endsection

