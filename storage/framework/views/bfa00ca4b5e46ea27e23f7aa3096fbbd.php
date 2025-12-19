<?php $__env->startSection('title', 'Medical Records'); ?>

<?php $__env->startSection('content'); ?>
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
                    <?php $__empty_1 = true; $__currentLoopData = $records; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $record): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                        <tr>
                            <td><?php echo e(\Carbon\Carbon::parse($record->record_date)->format('M d, Y')); ?></td>
                            <td><?php echo e($record->doctor->user->name); ?></td>
                            <td><?php echo e(Str::limit($record->diagnosis, 50)); ?></td>
                            <td><?php echo e(Str::limit($record->symptoms ?? 'N/A', 50)); ?></td>
                            <td>
                                <button type="button" class="btn btn-sm btn-info" data-bs-toggle="modal" data-bs-target="#recordModal<?php echo e($record->id); ?>">
                                    <i class="bi bi-eye"></i> View
                                </button>
                            </td>
                        </tr>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                        <tr>
                            <td colspan="5" class="text-center">No medical records found</td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>

        <div class="mt-3">
            <?php echo e($records->links()); ?>

        </div>
    </div>
</div>

<?php $__currentLoopData = $records; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $record): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
<div class="modal fade" id="recordModal<?php echo e($record->id); ?>" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Medical Record - <?php echo e(\Carbon\Carbon::parse($record->record_date)->format('M d, Y')); ?></h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <p><strong>Doctor:</strong> <?php echo e($record->doctor->user->name); ?></p>
                <p><strong>Date:</strong> <?php echo e(\Carbon\Carbon::parse($record->record_date)->format('M d, Y')); ?></p>
                <p><strong>Diagnosis:</strong></p>
                <p><?php echo e($record->diagnosis); ?></p>
                <?php if($record->symptoms): ?>
                    <p><strong>Symptoms:</strong></p>
                    <p><?php echo e($record->symptoms); ?></p>
                <?php endif; ?>
                <?php if($record->notes): ?>
                    <p><strong>Notes:</strong></p>
                    <p><?php echo e($record->notes); ?></p>
                <?php endif; ?>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>
<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
<?php $__env->stopSection(); ?>


<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home/nirmalgoswami/Documents/clg-projects/Hospital-management/resources/views/patient/medical-records.blade.php ENDPATH**/ ?>