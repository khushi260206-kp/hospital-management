@extends('layouts.app')

@section('title', 'Billing Management')

@section('content')
<div class="row mb-4">
    <div class="col-md-6">
        <h2><i class="bi bi-receipt"></i> Billing Management</h2>
    </div>
    <div class="col-md-6 text-end">
        <a href="{{ route('billing.create') }}" class="btn btn-primary">
            <i class="bi bi-plus-circle"></i> Create Bill
        </a>
    </div>
</div>

<div class="card">
    <div class="card-body">
        <form method="GET" class="mb-3">
            <div class="row">
                <div class="col-md-3">
                    <select name="payment_status" class="form-select">
                        <option value="">All Payment Status</option>
                        <option value="pending" {{ request('payment_status') == 'pending' ? 'selected' : '' }}>Pending</option>
                        <option value="partial" {{ request('payment_status') == 'partial' ? 'selected' : '' }}>Partial</option>
                        <option value="paid" {{ request('payment_status') == 'paid' ? 'selected' : '' }}>Paid</option>
                    </select>
                </div>
                <div class="col-md-3">
                    <input type="date" name="date_from" class="form-control" value="{{ request('date_from') }}" placeholder="From Date">
                </div>
                <div class="col-md-3">
                    <input type="date" name="date_to" class="form-control" value="{{ request('date_to') }}" placeholder="To Date">
                </div>
                <div class="col-md-3">
                    <button type="submit" class="btn btn-primary w-100">Filter</button>
                </div>
            </div>
        </form>

        <div class="table-responsive">
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th>Bill Number</th>
                        <th>Patient</th>
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
                            <td>{{ $bill->patient->user->name }}</td>
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
                                    <i class="bi bi-eye"></i>
                                </a>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="text-center">No bills found</td>
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

