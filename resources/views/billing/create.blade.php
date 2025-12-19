@extends('layouts.app')

@section('title', 'Create Bill')

@section('content')
<div class="row mb-4">
    <div class="col-12">
        <h2><i class="bi bi-receipt-cutoff"></i> Create Bill</h2>
    </div>
</div>

<div class="card">
    <div class="card-body">
        <form method="POST" action="{{ route('billing.store') }}" id="billForm">
            @csrf
            
            <div class="row mb-3">
                <div class="col-md-6">
                    <label for="patient_id" class="form-label">Patient *</label>
                    <select class="form-select @error('patient_id') is-invalid @enderror" 
                            id="patient_id" name="patient_id" required>
                        <option value="">Select Patient</option>
                        @foreach($patients as $patient)
                            <option value="{{ $patient->id }}" {{ old('patient_id') == $patient->id ? 'selected' : '' }}>
                                {{ $patient->user->name }} ({{ $patient->patient_id }})
                            </option>
                        @endforeach
                    </select>
                    @error('patient_id')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                <div class="col-md-6">
                    <label for="bill_type" class="form-label">Bill Type *</label>
                    <select class="form-select @error('bill_type') is-invalid @enderror" 
                            id="bill_type" name="bill_type" required>
                        <option value="opd" {{ old('bill_type', 'opd') == 'opd' ? 'selected' : '' }}>OPD</option>
                        <option value="ipd" {{ old('bill_type') == 'ipd' ? 'selected' : '' }}>IPD</option>
                        <option value="pharmacy" {{ old('bill_type') == 'pharmacy' ? 'selected' : '' }}>Pharmacy</option>
                        <option value="lab" {{ old('bill_type') == 'lab' ? 'selected' : '' }}>Lab</option>
                        <option value="other" {{ old('bill_type') == 'other' ? 'selected' : '' }}>Other</option>
                    </select>
                    @error('bill_type')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
            </div>

            <div class="row mb-3">
                <div class="col-md-6">
                    <label for="bill_date" class="form-label">Bill Date</label>
                    <input type="date" class="form-control @error('bill_date') is-invalid @enderror" 
                           id="bill_date" name="bill_date" value="{{ old('bill_date', date('Y-m-d')) }}">
                    @error('bill_date')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                <div class="col-md-6">
                    <label for="appointment_id" class="form-label">Appointment (Optional)</label>
                    <select class="form-select" id="appointment_id" name="appointment_id">
                        <option value="">None</option>
                        @if(isset($appointment))
                            <option value="{{ $appointment->id }}" selected>{{ \Carbon\Carbon::parse($appointment->appointment_date)->format('M d, Y') }} - {{ $appointment->doctor->user->name }}</option>
                        @endif
                    </select>
                </div>
            </div>

            <hr>
            <h5 class="mb-3">Bill Items</h5>
            <div id="billItems">
                <div class="bill-item mb-3 p-3 border rounded">
                    <div class="row">
                        <div class="col-md-4">
                            <label class="form-label">Item Name *</label>
                            <input type="text" class="form-control" name="items[0][item_name]" required>
                        </div>
                        <div class="col-md-2">
                            <label class="form-label">Quantity *</label>
                            <input type="number" class="form-control item-quantity" name="items[0][quantity]" value="1" min="1" required>
                        </div>
                        <div class="col-md-2">
                            <label class="form-label">Unit Price *</label>
                            <input type="number" step="0.01" class="form-control item-price" name="items[0][unit_price]" min="0" required>
                        </div>
                        <div class="col-md-2">
                            <label class="form-label">Type</label>
                            <select class="form-select" name="items[0][item_type]">
                                <option value="consultation">Consultation</option>
                                <option value="medicine">Medicine</option>
                                <option value="test">Test</option>
                                <option value="procedure">Procedure</option>
                                <option value="other" selected>Other</option>
                            </select>
                        </div>
                        <div class="col-md-2">
                            <label class="form-label">&nbsp;</label>
                            <button type="button" class="btn btn-danger w-100 remove-item">Remove</button>
                        </div>
                    </div>
                    <div class="row mt-2">
                        <div class="col-md-12">
                            <label class="form-label">Description</label>
                            <textarea class="form-control" name="items[0][description]" rows="1"></textarea>
                        </div>
                    </div>
                </div>
            </div>
            <button type="button" class="btn btn-secondary" id="addItem">Add Item</button>

            <hr>
            <div class="row mb-3">
                <div class="col-md-4">
                    <label for="tax" class="form-label">Tax</label>
                    <input type="number" step="0.01" class="form-control @error('tax') is-invalid @enderror" 
                           id="tax" name="tax" value="{{ old('tax', 0) }}" min="0">
                    @error('tax')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                <div class="col-md-4">
                    <label for="discount" class="form-label">Discount</label>
                    <input type="number" step="0.01" class="form-control @error('discount') is-invalid @enderror" 
                           id="discount" name="discount" value="{{ old('discount', 0) }}" min="0">
                    @error('discount')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                <div class="col-md-4">
                    <label for="payment_status" class="form-label">Payment Status</label>
                    <select class="form-select @error('payment_status') is-invalid @enderror" 
                            id="payment_status" name="payment_status">
                        <option value="pending" {{ old('payment_status', 'pending') == 'pending' ? 'selected' : '' }}>Pending</option>
                        <option value="partial" {{ old('payment_status') == 'partial' ? 'selected' : '' }}>Partial</option>
                        <option value="paid" {{ old('payment_status') == 'paid' ? 'selected' : '' }}>Paid</option>
                    </select>
                    @error('payment_status')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
            </div>

            <div class="mb-3">
                <label for="notes" class="form-label">Notes</label>
                <textarea class="form-control @error('notes') is-invalid @enderror" 
                          id="notes" name="notes" rows="2">{{ old('notes') }}</textarea>
                @error('notes')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="d-flex justify-content-end">
                <a href="{{ route('billing.index') }}" class="btn btn-secondary me-2">Cancel</a>
                <button type="submit" class="btn btn-primary">Create Bill</button>
            </div>
        </form>
    </div>
</div>

@push('scripts')
<script>
let itemIndex = 1;
document.getElementById('addItem').addEventListener('click', function() {
    const itemsContainer = document.getElementById('billItems');
    const newItem = document.createElement('div');
    newItem.className = 'bill-item mb-3 p-3 border rounded';
    newItem.innerHTML = `
        <div class="row">
            <div class="col-md-4">
                <label class="form-label">Item Name *</label>
                <input type="text" class="form-control" name="items[${itemIndex}][item_name]" required>
            </div>
            <div class="col-md-2">
                <label class="form-label">Quantity *</label>
                <input type="number" class="form-control item-quantity" name="items[${itemIndex}][quantity]" value="1" min="1" required>
            </div>
            <div class="col-md-2">
                <label class="form-label">Unit Price *</label>
                <input type="number" step="0.01" class="form-control item-price" name="items[${itemIndex}][unit_price]" min="0" required>
            </div>
            <div class="col-md-2">
                <label class="form-label">Type</label>
                <select class="form-select" name="items[${itemIndex}][item_type]">
                    <option value="consultation">Consultation</option>
                    <option value="medicine">Medicine</option>
                    <option value="test">Test</option>
                    <option value="procedure">Procedure</option>
                    <option value="other" selected>Other</option>
                </select>
            </div>
            <div class="col-md-2">
                <label class="form-label">&nbsp;</label>
                <button type="button" class="btn btn-danger w-100 remove-item">Remove</button>
            </div>
        </div>
        <div class="row mt-2">
            <div class="col-md-12">
                <label class="form-label">Description</label>
                <textarea class="form-control" name="items[${itemIndex}][description]" rows="1"></textarea>
            </div>
        </div>
    `;
    itemsContainer.appendChild(newItem);
    itemIndex++;
    
    // Add remove functionality
    newItem.querySelector('.remove-item').addEventListener('click', function() {
        newItem.remove();
    });
});

// Add remove functionality to existing items
document.querySelectorAll('.remove-item').forEach(btn => {
    btn.addEventListener('click', function() {
        if (document.querySelectorAll('.bill-item').length > 1) {
            this.closest('.bill-item').remove();
        } else {
            alert('At least one item is required');
        }
    });
});
</script>
@endpush
@endsection

