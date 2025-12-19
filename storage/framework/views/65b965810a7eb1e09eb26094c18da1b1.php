<?php $__env->startSection('title', 'Appointment Details'); ?>

<?php $__env->startSection('content'); ?>
<div class="row mb-4">
    <div class="col-12">
        <h2><i class="bi bi-calendar-check"></i> Appointment Details</h2>
    </div>
</div>

<div class="row">
    <div class="col-md-6">
        <div class="card">
            <div class="card-header">
                <h5>Appointment Information</h5>
            </div>
            <div class="card-body">
                <p><strong>Date:</strong> <?php echo e(\Carbon\Carbon::parse($appointment->appointment_date)->format('M d, Y')); ?></p>
                <p><strong>Time:</strong> <?php echo e(\Carbon\Carbon::parse($appointment->appointment_time)->format('h:i A')); ?></p>
                <p><strong>Status:</strong> 
                    <span class="badge bg-<?php echo e($appointment->status === 'confirmed' ? 'success' : ($appointment->status === 'pending' ? 'warning' : ($appointment->status === 'completed' ? 'info' : 'secondary'))); ?>">
                        <?php echo e(ucfirst($appointment->status)); ?>

                    </span>
                </p>
                <p><strong>Reason:</strong> <?php echo e($appointment->reason ?? 'N/A'); ?></p>
                <?php if($appointment->notes): ?>
                    <p><strong>Notes:</strong> <?php echo e($appointment->notes); ?></p>
                <?php endif; ?>
            </div>
        </div>
    </div>
    <div class="col-md-6">
        <div class="card">
            <div class="card-header">
                <h5>Doctor & Patient Information</h5>
            </div>
            <div class="card-body">
                <p><strong>Doctor:</strong> <?php echo e($appointment->doctor->user->name); ?></p>
                <p><strong>Department:</strong> <?php echo e($appointment->doctor->department->name); ?></p>
                <p><strong>Specialization:</strong> <?php echo e($appointment->doctor->specialization); ?></p>
                <p><strong>Patient:</strong> <?php echo e($appointment->patient->user->name); ?></p>
                <p><strong>Patient ID:</strong> <?php echo e($appointment->patient->patient_id); ?></p>
            </div>
        </div>
    </div>
</div>

<div class="row mt-4">
    <div class="col-12">
        <a href="<?php echo e(route('appointments.index')); ?>" class="btn btn-secondary">Back</a>
        <?php if($appointment->status !== 'completed' && $appointment->status !== 'cancelled'): ?>
            <?php if(auth()->user()->isDoctor()): ?>
                <form action="<?php echo e(route('appointments.complete', $appointment->id)); ?>" method="POST" class="d-inline">
                    <?php echo csrf_field(); ?>
                    <button type="submit" class="btn btn-success">Mark as Completed</button>
                </form>
            <?php endif; ?>
            <form action="<?php echo e(route('appointments.cancel', $appointment->id)); ?>" method="POST" class="d-inline">
                <?php echo csrf_field(); ?>
                <button type="submit" class="btn btn-danger" onclick="return confirm('Are you sure?')">Cancel Appointment</button>
            </form>
        <?php endif; ?>
    </div>
</div>
<?php $__env->stopSection(); ?>


<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home/nirmalgoswami/Documents/clg-projects/Hospital-management/resources/views/appointments/show.blade.php ENDPATH**/ ?>