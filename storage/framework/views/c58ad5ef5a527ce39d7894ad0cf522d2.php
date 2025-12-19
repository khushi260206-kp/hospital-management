<?php $__env->startSection('title', 'Patient Dashboard'); ?>

<?php $__env->startSection('content'); ?>
<div class="page-header">
    <div class="d-flex justify-content-between align-items-center">
        <div>
            <h2 class="mb-1"><i class="bi bi-speedometer2"></i> Patient Dashboard</h2>
            <p class="text-muted mb-0">Welcome, <?php echo e(auth()->user()->name); ?>! Manage your health records and appointments.</p>
        </div>
        <div>
            <span class="badge bg-primary" style="font-size: 1rem; padding: 0.75rem 1.5rem;">
                <i class="bi bi-calendar3"></i> <?php echo e(now()->format('l, F d, Y')); ?>

            </span>
        </div>
    </div>
</div>

<div class="row mb-4">
    <div class="col-md-4 mb-3">
        <div class="stat-card" style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <h5>Upcoming Appointments</h5>
                    <h2><?php echo e($stats['upcoming_appointments']); ?></h2>
                </div>
                <i class="bi bi-calendar-event" style="font-size: 3rem; opacity: 0.3;"></i>
            </div>
        </div>
    </div>
    <div class="col-md-4 mb-3">
        <div class="stat-card" style="background: linear-gradient(135deg, #10b981 0%, #059669 100%);">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <h5>Total Appointments</h5>
                    <h2><?php echo e($stats['total_appointments']); ?></h2>
                </div>
                <i class="bi bi-calendar-check" style="font-size: 3rem; opacity: 0.3;"></i>
            </div>
        </div>
    </div>
    <div class="col-md-4 mb-3">
        <div class="stat-card" style="background: linear-gradient(135deg, #f59e0b 0%, #d97706 100%);">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <h5>Pending Bills</h5>
                    <h2><?php echo e($stats['pending_bills']); ?></h2>
                </div>
                <i class="bi bi-receipt-cutoff" style="font-size: 3rem; opacity: 0.3;"></i>
            </div>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-header">
                <h5 class="mb-0"><i class="bi bi-calendar-event"></i> Upcoming Appointments</h5>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-hover">
                        <thead>
                            <tr>
                                <th>Date</th>
                                <th>Time</th>
                                <th>Doctor</th>
                                <th>Department</th>
                                <th>Status</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php $__empty_1 = true; $__currentLoopData = $upcomingAppointments; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $appointment): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                                <tr>
                                    <td><i class="bi bi-calendar3"></i> <?php echo e(\Carbon\Carbon::parse($appointment->appointment_date)->format('M d, Y')); ?></td>
                                    <td><i class="bi bi-clock"></i> <?php echo e(\Carbon\Carbon::parse($appointment->appointment_time)->format('h:i A')); ?></td>
                                    <td><i class="bi bi-heart-pulse"></i> <?php echo e($appointment->doctor->user->name); ?></td>
                                    <td><i class="bi bi-building"></i> <?php echo e($appointment->doctor->department->name); ?></td>
                                    <td>
                                        <span class="badge bg-<?php echo e($appointment->status === 'confirmed' ? 'success' : 'warning'); ?>">
                                            <?php echo e(ucfirst($appointment->status)); ?>

                                        </span>
                                    </td>
                                    <td>
                                        <a href="<?php echo e(route('appointments.show', $appointment->id)); ?>" class="btn btn-sm btn-info">
                                            <i class="bi bi-eye"></i> View
                                        </a>
                                    </td>
                                </tr>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                                <tr>
                                    <td colspan="6" class="text-center py-4">
                                        <i class="bi bi-inbox" style="font-size: 2rem; color: #ccc;"></i>
                                        <p class="text-muted mt-2">No upcoming appointments</p>
                                    </td>
                                </tr>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>


<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home/nirmalgoswami/Documents/clg-projects/Hospital-management/resources/views/patient/dashboard.blade.php ENDPATH**/ ?>