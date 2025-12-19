<?php $__env->startSection('title', 'Doctors Management'); ?>

<?php $__env->startSection('content'); ?>
<div class="row mb-4">
    <div class="col-md-6">
        <h2><i class="bi bi-people"></i> Doctors Management</h2>
    </div>
    <div class="col-md-6 text-end">
        <a href="<?php echo e(route('admin.doctors.create')); ?>" class="btn btn-primary">
            <i class="bi bi-plus-circle"></i> Add Doctor
        </a>
    </div>
</div>

<div class="card">
    <div class="card-body">
        <form method="GET" class="mb-3">
            <div class="row">
                <div class="col-md-4">
                    <input type="text" name="search" class="form-control" placeholder="Search..." value="<?php echo e(request('search')); ?>">
                </div>
                <div class="col-md-3">
                    <select name="department_id" class="form-select">
                        <option value="">All Departments</option>
                        <?php $__currentLoopData = $departments; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $dept): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <option value="<?php echo e($dept->id); ?>" <?php echo e(request('department_id') == $dept->id ? 'selected' : ''); ?>>
                                <?php echo e($dept->name); ?>

                            </option>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </select>
                </div>
                <div class="col-md-3">
                    <select name="availability" class="form-select">
                        <option value="">All Status</option>
                        <option value="available" <?php echo e(request('availability') == 'available' ? 'selected' : ''); ?>>Available</option>
                        <option value="busy" <?php echo e(request('availability') == 'busy' ? 'selected' : ''); ?>>Busy</option>
                        <option value="on_leave" <?php echo e(request('availability') == 'on_leave' ? 'selected' : ''); ?>>On Leave</option>
                    </select>
                </div>
                <div class="col-md-2">
                    <button type="submit" class="btn btn-primary w-100">Filter</button>
                </div>
            </div>
        </form>

        <div class="table-responsive">
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th>Name</th>
                        <th>Email</th>
                        <th>Department</th>
                        <th>Specialization</th>
                        <th>License</th>
                        <th>Availability</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php $__empty_1 = true; $__currentLoopData = $doctors; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $doctor): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                        <tr>
                            <td><?php echo e($doctor->user->name); ?></td>
                            <td><?php echo e($doctor->user->email); ?></td>
                            <td><?php echo e($doctor->department->name); ?></td>
                            <td><?php echo e($doctor->specialization); ?></td>
                            <td><?php echo e($doctor->license_number); ?></td>
                            <td>
                                <span class="badge bg-<?php echo e($doctor->availability === 'available' ? 'success' : ($doctor->availability === 'busy' ? 'warning' : 'secondary')); ?>">
                                    <?php echo e(ucfirst(str_replace('_', ' ', $doctor->availability))); ?>

                                </span>
                            </td>
                            <td>
                                <a href="<?php echo e(route('admin.doctors.show', $doctor->id)); ?>" class="btn btn-sm btn-info">
                                    <i class="bi bi-eye"></i>
                                </a>
                                <a href="<?php echo e(route('admin.doctors.edit', $doctor->id)); ?>" class="btn btn-sm btn-warning">
                                    <i class="bi bi-pencil"></i>
                                </a>
                                <form action="<?php echo e(route('admin.doctors.destroy', $doctor->id)); ?>" method="POST" class="d-inline">
                                    <?php echo csrf_field(); ?>
                                    <?php echo method_field('DELETE'); ?>
                                    <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Are you sure?')">
                                        <i class="bi bi-trash"></i>
                                    </button>
                                </form>
                            </td>
                        </tr>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                        <tr>
                            <td colspan="7" class="text-center">No doctors found</td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>

        <div class="mt-3">
            <?php echo e($doctors->links()); ?>

        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>


<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home/nirmalgoswami/Documents/clg-projects/Hospital-management/resources/views/admin/doctors/index.blade.php ENDPATH**/ ?>