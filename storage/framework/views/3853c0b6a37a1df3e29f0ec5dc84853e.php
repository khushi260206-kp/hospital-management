<?php $__env->startSection('title', 'My Appointments'); ?>

<?php $__env->startSection('content'); ?>
<div class="page-header">
    <div class="d-flex justify-content-between align-items-center">
        <div>
            <h2 class="mb-1"><i class="bi bi-calendar-check"></i> My Appointments</h2>
            <p class="text-muted mb-0">View and manage your appointments</p>
        </div>
        <div>
            <a href="<?php echo e(route('appointments.create')); ?>" class="btn btn-primary">
                <i class="bi bi-plus-circle"></i> Add Appointment
            </a>
        </div>
    </div>
</div>

<div class="card">
    <div class="card-header">
        <h5 class="mb-0"><i class="bi bi-calendar-event"></i> Appointments List</h5>
    </div>
    <div class="card-body">
        <form method="GET" class="mb-3">
            <div class="row">
                <div class="col-md-4">
                    <label for="status" class="form-label">Status</label>
                    <select name="status" id="status" class="form-select">
                        <option value="">All Status</option>
                        <option value="pending" <?php echo e(request('status') == 'pending' ? 'selected' : ''); ?>>Pending</option>
                        <option value="confirmed" <?php echo e(request('status') == 'confirmed' ? 'selected' : ''); ?>>Confirmed</option>
                        <option value="completed" <?php echo e(request('status') == 'completed' ? 'selected' : ''); ?>>Completed</option>
                        <option value="cancelled" <?php echo e(request('status') == 'cancelled' ? 'selected' : ''); ?>>Cancelled</option>
                    </select>
                </div>
                <div class="col-md-4">
                    <label for="date" class="form-label">Date</label>
                    <input type="date" name="date" id="date" class="form-control" value="<?php echo e(request('date')); ?>">
                </div>
                <div class="col-md-4">
                    <label class="form-label">&nbsp;</label>
                    <div class="d-flex gap-2">
                        <button type="submit" class="btn btn-primary flex-grow-1">
                            <i class="bi bi-funnel"></i> Filter
                        </button>
                        <a href="<?php echo e(route('patient.appointments')); ?>" class="btn btn-secondary">
                            <i class="bi bi-x-circle"></i> Clear
                        </a>
                    </div>
                </div>
            </div>
        </form>

        <div class="table-responsive">
            <table class="table table-hover">
                <thead>
                    <tr>
                        <th>Date</th>
                        <th>Time</th>
                        <th>Doctor</th>
                        <th>Department</th>
                        <th>Reason</th>
                        <th>Status</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php $__empty_1 = true; $__currentLoopData = $appointments; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $appointment): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                        <tr>
                            <td><i class="bi bi-calendar3"></i> <?php echo e(\Carbon\Carbon::parse($appointment->appointment_date)->format('M d, Y')); ?></td>
                            <td><i class="bi bi-clock"></i> <?php echo e(\Carbon\Carbon::parse($appointment->appointment_time)->format('h:i A')); ?></td>
                            <td>
                                <?php if($appointment->doctor && $appointment->doctor->user): ?>
                                    <i class="bi bi-heart-pulse"></i> <?php echo e($appointment->doctor->user->name); ?>

                                <?php else: ?>
                                    <span class="text-muted">N/A</span>
                                <?php endif; ?>
                            </td>
                            <td>
                                <?php if($appointment->doctor && $appointment->doctor->department): ?>
                                    <i class="bi bi-building"></i> <?php echo e($appointment->doctor->department->name); ?>

                                <?php else: ?>
                                    <span class="text-muted">N/A</span>
                                <?php endif; ?>
                            </td>
                            <td><?php echo e($appointment->reason ?? 'N/A'); ?></td>
                            <td>
                                <span class="badge bg-<?php echo e($appointment->status === 'confirmed' ? 'success' : ($appointment->status === 'pending' ? 'warning' : ($appointment->status === 'completed' ? 'info' : 'secondary'))); ?>">
                                    <?php echo e(ucfirst($appointment->status)); ?>

                                </span>
                            </td>
                            <td>
                                <a href="<?php echo e(route('appointments.show', $appointment->id)); ?>" class="btn btn-sm btn-info">
                                    <i class="bi bi-eye"></i> View
                                </a>
                                <?php if($appointment->status !== 'completed' && $appointment->status !== 'cancelled'): ?>
                                    <form action="<?php echo e(route('appointments.cancel', $appointment->id)); ?>" method="POST" class="d-inline">
                                        <?php echo csrf_field(); ?>
                                        <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Are you sure you want to cancel this appointment?')">
                                            <i class="bi bi-x-circle"></i> Cancel
                                        </button>
                                    </form>
                                <?php endif; ?>
                            </td>
                        </tr>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                        <tr>
                            <td colspan="7" class="text-center py-4">
                                <i class="bi bi-inbox" style="font-size: 2rem; color: #ccc;"></i>
                                <p class="text-muted mt-2">No appointments found</p>
                            </td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>

        <?php if($appointments->hasPages()): ?>
            <div class="mt-3">
                <?php echo e($appointments->links()); ?>

            </div>
        <?php endif; ?>
    </div>
</div>
<?php $__env->stopSection(); ?>


<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home/nirmalgoswami/Documents/clg-projects/Hospital-management/resources/views/patient/appointments.blade.php ENDPATH**/ ?>