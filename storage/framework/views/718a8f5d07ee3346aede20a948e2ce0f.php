

<?php $__env->startSection('title', 'Car Registration'); ?>

<?php $__env->startSection('breadcrumbs'); ?>
    <li class="breadcrumb-item active">Car Registration</li>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('page-header'); ?>
    <div class="d-flex justify-content-between align-items-center">
        <h1 class="page-title">
            <i class="fas fa-car me-2"></i>
            Car Registration Request
        </h1>
        <div class="page-actions">
            <!-- Add any action buttons here if needed -->
        </div>
    </div>
<?php $__env->stopSection(); ?>

<?php $__env->startPush('styles'); ?>
<link rel="stylesheet" href="<?php echo e(asset('assets/css/admin/newly-registered-cars.css')); ?>">
<?php $__env->stopPush(); ?>

<?php $__env->startSection('content'); ?>
<div class="container-fluid">
    <?php if($cars->isEmpty()): ?>
        <div class="card">
            <div class="card-body">
                <div class="empty-message">
                    <i class="fas fa-car fa-3x mb-3" style="color: #ccc;"></i>
                    <h4>No Car Registration Requests</h4>
                    <p class="mb-0">There are currently no car registration requests to review.</p>
                </div>
            </div>
        </div>
    <?php else: ?>
        <div class="card">
            <div class="card-header">
                <h5 class="card-title mb-0">
                    <i class="fas fa-list me-2"></i>
                    Registration Requests (<?php echo e($cars->count()); ?>)
                </h5>
            </div>
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-hover mb-0">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Maker</th>
                                <th>Model</th>
                                <th>Vehicle Type</th>
                                <th>Price per Day</th>
                                <th>Registration Number</th>
                                <th>Status</th>
                                <th>Car Image</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php $__currentLoopData = $cars; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $car): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <tr>
                                    <td>
                                        <span class="fw-medium">#<?php echo e($car->id); ?></span>
                                    </td>
                                    <td><?php echo e($car->maker); ?></td>
                                    <td><?php echo e($car->model); ?></td>
                                    <td>
                                        <span class="badge bg-secondary"><?php echo e($car->vehicle_type); ?></span>
                                    </td>
                                    <td>
                                        <span class="fw-medium text-success">$<?php echo e(number_format($car->price, 2)); ?></span>
                                    </td>
                                    <td>
                                        <code><?php echo e($car->registration_no); ?></code>
                                    </td>
                                    <td>
                                        <span class="status-<?php echo e(strtolower($car->status)); ?>">
                                            <?php echo e(ucfirst($car->status)); ?>

                                        </span>
                                    </td>
                                    <td>
                                        <?php if($car->car_image): ?>
                                            <img src="<?php echo e(asset($car->car_image)); ?>" alt="Car Image" class="img-thumbnail">
                                        <?php else: ?>
                                            <span class="text-muted">
                                                <i class="fas fa-image"></i> No image
                                            </span>
                                        <?php endif; ?>
                                    </td>
                                    <td>
                                        <?php if(strtolower($car->status) === 'rejected'): ?>
                                            <span class="text-danger">
                                                <i class="fas fa-times-circle me-1"></i>
                                                Rejected
                                            </span>
                                        <?php else: ?>
                                            <a href="<?php echo e(route('car-admin.view-car', $car->id)); ?>" class="btn btn-info btn-sm">
                                                <i class="fas fa-eye"></i> View
                                            </a>
                                        <?php endif; ?>
                                    </td>                            
                                </tr>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        
        
        <?php if(method_exists($cars, 'links')): ?>
            <div class="d-flex justify-content-center mt-4">
                <?php echo e($cars->links()); ?>

            </div>
        <?php endif; ?>
    <?php endif; ?>
</div>
<?php $__env->stopSection(); ?>

<?php $__env->startPush('scripts'); ?>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Add any page-specific JavaScript here
        
        // Example: Add confirmation for view actions
        document.querySelectorAll('.btn-info').forEach(button => {
            button.addEventListener('click', function(e) {
                // You can add confirmation dialog here if needed
                console.log('Viewing car details...');
            });
        });
        
        // Example: Auto-refresh every 30 seconds for real-time updates
        // setInterval(function() {
        //     window.location.reload();
        // }, 30000);
    });
</script>
<?php $__env->stopPush(); ?>
<?php echo $__env->make('layouts.admin', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\Sangay Ngedup\Documents\GitHub\FinalProject\resources\views/admin/newly-registered-cars.blade.php ENDPATH**/ ?>