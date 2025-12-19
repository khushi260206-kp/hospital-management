<?php $__env->startSection('title', 'Create Bill'); ?>

<?php $__env->startSection('content'); ?>
<div class="row mb-4">
    <div class="col-12">
        <h2><i class="bi bi-receipt-cutoff"></i> Create Bill</h2>
    </div>
</div>

<div class="card">
    <div class="card-body">
        <form method="POST" action="<?php echo e(route('billing.store')); ?>" id="billForm">
            <?php echo csrf_field(); ?>
            
            <div class="row mb-3">
                <div class="col-md-6">
                    <label for="patient_id" class="form-label">Patient *</label>
                    <select class="form-select <?php $__errorArgs = ['patient_id'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" 
                            id="patient_id" name="patient_id" required>
                        <option value="">Select Patient</option>
                        <?php $__currentLoopData = $patients; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $patient): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <option value="<?php echo e($patient->id); ?>" <?php echo e(old('patient_id') == $patient->id ? 'selected' : ''); ?>>
                                <?php echo e($patient->user->name); ?> (<?php echo e($patient->patient_id); ?>)
                            </option>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </select>
                    <?php $__errorArgs = ['patient_id'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                        <div class="invalid-feedback"><?php echo e($message); ?></div>
                    <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                </div>
                <div class="col-md-6">
                    <label for="bill_type" class="form-label">Bill Type *</label>
                    <select class="form-select <?php $__errorArgs = ['bill_type'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" 
                            id="bill_type" name="bill_type" required>
                        <option value="opd" <?php echo e(old('bill_type', 'opd') == 'opd' ? 'selected' : ''); ?>>OPD</option>
                        <option value="ipd" <?php echo e(old('bill_type') == 'ipd' ? 'selected' : ''); ?>>IPD</option>
                        <option value="pharmacy" <?php echo e(old('bill_type') == 'pharmacy' ? 'selected' : ''); ?>>Pharmacy</option>
                        <option value="lab" <?php echo e(old('bill_type') == 'lab' ? 'selected' : ''); ?>>Lab</option>
                        <option value="other" <?php echo e(old('bill_type') == 'other' ? 'selected' : ''); ?>>Other</option>
                    </select>
                    <?php $__errorArgs = ['bill_type'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                        <div class="invalid-feedback"><?php echo e($message); ?></div>
                    <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                </div>
            </div>

            <div class="row mb-3">
                <div class="col-md-6">
                    <label for="bill_date" class="form-label">Bill Date</label>
                    <input type="date" class="form-control <?php $__errorArgs = ['bill_date'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" 
                           id="bill_date" name="bill_date" value="<?php echo e(old('bill_date', date('Y-m-d'))); ?>">
                    <?php $__errorArgs = ['bill_date'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                        <div class="invalid-feedback"><?php echo e($message); ?></div>
                    <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                </div>
                <div class="col-md-6">
                    <label for="appointment_id" class="form-label">Appointment (Optional)</label>
                    <select class="form-select" id="appointment_id" name="appointment_id">
                        <option value="">None</option>
                        <?php if(isset($appointment)): ?>
                            <option value="<?php echo e($appointment->id); ?>" selected><?php echo e(\Carbon\Carbon::parse($appointment->appointment_date)->format('M d, Y')); ?> - <?php echo e($appointment->doctor->user->name); ?></option>
                        <?php endif; ?>
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
                    <input type="number" step="0.01" class="form-control <?php $__errorArgs = ['tax'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" 
                           id="tax" name="tax" value="<?php echo e(old('tax', 0)); ?>" min="0">
                    <?php $__errorArgs = ['tax'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                        <div class="invalid-feedback"><?php echo e($message); ?></div>
                    <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                </div>
                <div class="col-md-4">
                    <label for="discount" class="form-label">Discount</label>
                    <input type="number" step="0.01" class="form-control <?php $__errorArgs = ['discount'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" 
                           id="discount" name="discount" value="<?php echo e(old('discount', 0)); ?>" min="0">
                    <?php $__errorArgs = ['discount'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                        <div class="invalid-feedback"><?php echo e($message); ?></div>
                    <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                </div>
                <div class="col-md-4">
                    <label for="payment_status" class="form-label">Payment Status</label>
                    <select class="form-select <?php $__errorArgs = ['payment_status'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" 
                            id="payment_status" name="payment_status">
                        <option value="pending" <?php echo e(old('payment_status', 'pending') == 'pending' ? 'selected' : ''); ?>>Pending</option>
                        <option value="partial" <?php echo e(old('payment_status') == 'partial' ? 'selected' : ''); ?>>Partial</option>
                        <option value="paid" <?php echo e(old('payment_status') == 'paid' ? 'selected' : ''); ?>>Paid</option>
                    </select>
                    <?php $__errorArgs = ['payment_status'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                        <div class="invalid-feedback"><?php echo e($message); ?></div>
                    <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                </div>
            </div>

            <div class="mb-3">
                <label for="notes" class="form-label">Notes</label>
                <textarea class="form-control <?php $__errorArgs = ['notes'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" 
                          id="notes" name="notes" rows="2"><?php echo e(old('notes')); ?></textarea>
                <?php $__errorArgs = ['notes'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                    <div class="invalid-feedback"><?php echo e($message); ?></div>
                <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
            </div>

            <div class="d-flex justify-content-end">
                <a href="<?php echo e(route('billing.index')); ?>" class="btn btn-secondary me-2">Cancel</a>
                <button type="submit" class="btn btn-primary">Create Bill</button>
            </div>
        </form>
    </div>
</div>

<?php $__env->startPush('scripts'); ?>
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
<?php $__env->stopPush(); ?>
<?php $__env->stopSection(); ?>


<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home/nirmalgoswami/Documents/clg-projects/Hospital-management/resources/views/billing/create.blade.php ENDPATH**/ ?>