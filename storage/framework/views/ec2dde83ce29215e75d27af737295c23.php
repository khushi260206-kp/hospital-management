<?php $__env->startSection('title', 'Appointments'); ?>

<?php $__env->startSection('content'); ?>
<div class="row mb-4">
    <div class="col-md-6">
        <h2><i class="bi bi-calendar-check"></i> Appointments</h2>
    </div>
    <div class="col-md-6 text-end">
        <a href="<?php echo e(route('appointments.create')); ?>" class="btn btn-primary">
            <i class="bi bi-plus-circle"></i> Book Appointment
        </a>
    </div>
</div>

<div class="card">
    <div class="card-body">
        <form method="GET" class="mb-3">
            <div class="row">
                <div class="col-md-3">
                    <select name="status" class="form-select">
                        <option value="">All Status</option>
                        <option value="pending" <?php echo e(request('status') == 'pending' ? 'selected' : ''); ?>>Pending</option>
                        <option value="confirmed" <?php echo e(request('status') == 'confirmed' ? 'selected' : ''); ?>>Confirmed</option>
                        <option value="completed" <?php echo e(request('status') == 'completed' ? 'selected' : ''); ?>>Completed</option>
                        <option value="cancelled" <?php echo e(request('status') == 'cancelled' ? 'selected' : ''); ?>>Cancelled</option>
                    </select>
                </div>
                <div class="col-md-3">
                    <input type="date" name="date" class="form-control" value="<?php echo e(request('date')); ?>">
                </div>
                <?php if(auth()->user()->isAdmin() || auth()->user()->isReceptionist()): ?>
                    <div class="col-md-3">
                        <select name="doctor_id" class="form-select">
                            <option value="">All Doctors</option>
                            <?php $__currentLoopData = $doctors; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $doctor): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <option value="<?php echo e($doctor->id); ?>" <?php echo e(request('doctor_id') == $doctor->id ? 'selected' : ''); ?>>
                                    <?php echo e($doctor->user->name ?? 'N/A'); ?>

                                </option>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </select>
                    </div>
                <?php endif; ?>
                <div class="col-md-3">
                    <button type="submit" class="btn btn-primary w-100">Filter</button>
                </div>
            </div>
        </form>

        <div class="table-responsive">
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th>Date</th>
                        <th>Time</th>
                        <?php if(!auth()->user()->isPatient()): ?>
                            <th>Patient</th>
                        <?php endif; ?>
                        <?php if(!auth()->user()->isDoctor()): ?>
                            <th>Doctor</th>
                        <?php endif; ?>
                        <th>Reason</th>
                        <th>Status</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php $__empty_1 = true; $__currentLoopData = $appointments; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $appointment): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                        <tr>
                            <td><?php echo e(\Carbon\Carbon::parse($appointment->appointment_date)->format('M d, Y')); ?></td>
                            <td><?php echo e(\Carbon\Carbon::parse($appointment->appointment_time)->format('h:i A')); ?></td>
                            <?php if(!auth()->user()->isPatient()): ?>
                                <td><?php echo e($appointment->patient->user->name); ?></td>
                            <?php endif; ?>
                            <?php if(!auth()->user()->isDoctor()): ?>
                                <td><?php echo e($appointment->doctor->user->name); ?></td>
                            <?php endif; ?>
                            <td><?php echo e($appointment->reason ?? 'N/A'); ?></td>
                            <td>
                                <span class="badge bg-<?php echo e($appointment->status === 'confirmed' ? 'success' : ($appointment->status === 'pending' ? 'warning' : ($appointment->status === 'completed' ? 'info' : 'secondary'))); ?>">
                                    <?php echo e(ucfirst($appointment->status)); ?>

                                </span>
                            </td>
                            <td>
                                <a href="<?php echo e(route('appointments.show', $appointment->id)); ?>" class="btn btn-sm btn-info">
                                    <i class="bi bi-eye"></i>
                                </a>
                                <?php if(auth()->user()->isDoctor() && $appointment->status !== 'completed' && $appointment->status !== 'cancelled'): ?>
                                    <form action="<?php echo e(route('appointments.complete', $appointment->id)); ?>" method="POST" class="d-inline">
                                        <?php echo csrf_field(); ?>
                                        <button type="submit" class="btn btn-sm btn-success">
                                            <i class="bi bi-check-circle"></i> Complete
                                        </button>
                                    </form>
                                <?php endif; ?>
                                <?php if($appointment->status !== 'completed' && $appointment->status !== 'cancelled'): ?>
                                    <form action="<?php echo e(route('appointments.cancel', $appointment->id)); ?>" method="POST" class="d-inline">
                                        <?php echo csrf_field(); ?>
                                        <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Are you sure?')">
                                            <i class="bi bi-x-circle"></i> Cancel
                                        </button>
                                    </form>
                                <?php endif; ?>
                            </td>
                        </tr>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                        <tr>
                            <td colspan="7" class="text-center">No appointments found</td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>

        <div class="mt-3">
            <?php echo e($appointments->links()); ?>

        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>


<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home/nirmalgoswami/Documents/clg-projects/Hospital-management/resources/views/appointments/index.blade.php ENDPATH**/ ?>