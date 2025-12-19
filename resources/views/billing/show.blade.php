@extends('layouts.app')

@section('title', 'Bill Details')

@section('content')
<div class="row mb-4">
    <div class="col-12">
        <h2><i class="bi bi-receipt"></i> Bill Details</h2>
    </div>
</div>

<div class="row">
    <div class="col-md-8">
        <div class="card">
            <div class="card-header">
                <h5>Bill #{{ $bill->bill_number }}</h5>
            </div>
            <div class="card-body">
                <div class="row mb-3">
                    <div class="col-md-6">
                        <p><strong>Patient:</strong> {{ $bill->patient->user->name }}</p>
                        <p><strong>Patient ID:</strong> {{ $bill->patient->patient_id }}</p>
                    </div>
                    <div class="col-md-6">
                        <p><strong>Bill Date:</strong> {{ \Carbon\Carbon::parse($bill->bill_date)->format('M d, Y') }}</p>
                        <p><strong>Bill Type:</strong> {{ strtoupper($bill->bill_type) }}</p>
                    </div>
                </div>

                <hr>

                <h6>Bill Items</h6>
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th>Item</th>
                            <th>Quantity</th>
                            <th>Unit Price</th>
                            <th>Total</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($bill->items as $item)
                            <tr>
                                <td>{{ $item->item_name }}</td>
                                <td>{{ $item->quantity }}</td>
                                <td>${{ number_format($item->unit_price, 2) }}</td>
                                <td>${{ number_format($item->total_price, 2) }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                    <tfoot>
                        <tr>
                            <td colspan="3" class="text-end"><strong>Subtotal:</strong></td>
                            <td><strong>${{ number_format($bill->subtotal, 2) }}</strong></td>
                        </tr>
                        <tr>
                            <td colspan="3" class="text-end"><strong>Tax:</strong></td>
                            <td><strong>${{ number_format($bill->tax, 2) }}</strong></td>
                        </tr>
                        <tr>
                            <td colspan="3" class="text-end"><strong>Discount:</strong></td>
                            <td><strong>-${{ number_format($bill->discount, 2) }}</strong></td>
                        </tr>
                        <tr>
                            <td colspan="3" class="text-end"><strong>Total:</strong></td>
                            <td><strong>${{ number_format($bill->total, 2) }}</strong></td>
                        </tr>
                    </tfoot>
                </table>

                <p><strong>Payment Status:</strong> 
                    <span class="badge bg-{{ $bill->payment_status === 'paid' ? 'success' : ($bill->payment_status === 'partial' ? 'warning' : 'danger') }}">
                        {{ ucfirst($bill->payment_status) }}
                    </span>
                </p>
                @if($bill->payment_method)
                    <p><strong>Payment Method:</strong> {{ ucfirst($bill->payment_method) }}</p>
                @endif
            </div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="card">
            <div class="card-header">
                <h5>Update Payment Status</h5>
            </div>
            <div class="card-body">
                <form method="POST" action="{{ route('billing.update-payment-status', $bill->id) }}">
                    @csrf
                    <div class="mb-3">
                        <label for="payment_status" class="form-label">Payment Status</label>
                        <select class="form-select" id="payment_status" name="payment_status" required>
                            <option value="pending" {{ $bill->payment_status == 'pending' ? 'selected' : '' }}>Pending</option>
                            <option value="partial" {{ $bill->payment_status == 'partial' ? 'selected' : '' }}>Partial</option>
                            <option value="paid" {{ $bill->payment_status == 'paid' ? 'selected' : '' }}>Paid</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="payment_method" class="form-label">Payment Method</label>
                        <select class="form-select" id="payment_method" name="payment_method">
                            <option value="">Select Method</option>
                            <option value="cash" {{ $bill->payment_method == 'cash' ? 'selected' : '' }}>Cash</option>
                            <option value="card" {{ $bill->payment_method == 'card' ? 'selected' : '' }}>Card</option>
                            <option value="online" {{ $bill->payment_method == 'online' ? 'selected' : '' }}>Online</option>
                            <option value="insurance" {{ $bill->payment_method == 'insurance' ? 'selected' : '' }}>Insurance</option>
                        </select>
                    </div>
                    <button type="submit" class="btn btn-primary w-100">Update</button>
                </form>
            </div>
        </div>
    </div>
</div>

<div class="row mt-4">
    <div class="col-12">
        <a href="{{ route('billing.index') }}" class="btn btn-secondary">Back</a>
    </div>
</div>
@endsection

