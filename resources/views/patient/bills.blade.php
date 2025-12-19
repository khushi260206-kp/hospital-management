@extends('layouts.app')

@section('title', 'My Bills')

@section('content')
<div class="row mb-4">
    <div class="col-12">
        <h2><i class="bi bi-receipt"></i> My Bills</h2>
    </div>
</div>

<div class="card">
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th>Bill Number</th>
                        <th>Date</th>
                        <th>Type</th>
                        <th>Total</th>
                        <th>Payment Status</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($bills as $bill)
                        <tr>
                            <td>{{ $bill->bill_number }}</td>
                            <td>{{ \Carbon\Carbon::parse($bill->bill_date)->format('M d, Y') }}</td>
                            <td>{{ strtoupper($bill->bill_type) }}</td>
                            <td>${{ number_format($bill->total, 2) }}</td>
                            <td>
                                <span class="badge bg-{{ $bill->payment_status === 'paid' ? 'success' : ($bill->payment_status === 'partial' ? 'warning' : 'danger') }}">
                                    {{ ucfirst($bill->payment_status) }}
                                </span>
                            </td>
                            <td>
                                <a href="{{ route('billing.show', $bill->id) }}" class="btn btn-sm btn-info">
                                    <i class="bi bi-eye"></i> View
                                </a>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="text-center">No bills found</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="mt-3">
            {{ $bills->links() }}
        </div>
    </div>
</div>
@endsection

