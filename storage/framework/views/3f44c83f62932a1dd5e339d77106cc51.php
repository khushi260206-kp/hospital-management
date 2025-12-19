<?php $__env->startSection('title', 'My Bills'); ?>

<?php $__env->startSection('content'); ?>
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
                    <?php $__empty_1 = true; $__currentLoopData = $bills; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $bill): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                        <tr>
                            <td><?php echo e($bill->bill_number); ?></td>
                            <td><?php echo e(\Carbon\Carbon::parse($bill->bill_date)->format('M d, Y')); ?></td>
                            <td><?php echo e(strtoupper($bill->bill_type)); ?></td>
                            <td>$<?php echo e(number_format($bill->total, 2)); ?></td>
                            <td>
                                <span class="badge bg-<?php echo e($bill->payment_status === 'paid' ? 'success' : ($bill->payment_status === 'partial' ? 'warning' : 'danger')); ?>">
                                    <?php echo e(ucfirst($bill->payment_status)); ?>

                                </span>
                            </td>
                            <td>
                                <a href="<?php echo e(route('billing.show', $bill->id)); ?>" class="btn btn-sm btn-info">
                                    <i class="bi bi-eye"></i> View
                                </a>
                            </td>
                        </tr>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                        <tr>
                            <td colspan="6" class="text-center">No bills found</td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>

        <div class="mt-3">
            <?php echo e($bills->links()); ?>

        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>


<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home/nirmalgoswami/Documents/clg-projects/Hospital-management/resources/views/patient/bills.blade.php ENDPATH**/ ?>