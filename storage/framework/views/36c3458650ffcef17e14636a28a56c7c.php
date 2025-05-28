

<?php $__env->startSection('title', 'Car Details'); ?>

<?php $__env->startSection('breadcrumbs'); ?>
    <li class="breadcrumb-item">
        <a href="<?php echo e(route('car-admin.new-registration-cars')); ?>">Car Registration</a>
    </li>
    <li class="breadcrumb-item active">Car Details</li>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('page-header'); ?>
    <div class="d-flex justify-content-between align-items-center">
        <div>
            <h1 class="page-title">Car Details</h1>
            <p class="page-subtitle">Review and manage car registration details</p>
        </div>
        <div class="page-actions">
            <a href="<?php echo e(route('car-admin.new-registration-cars')); ?>" class="btn btn-outline-secondary">
                <i class="fas fa-arrow-left me-2"></i>Back to List
            </a>
        </div>
    </div>
<?php $__env->stopSection(); ?>

<?php $__env->startPush('styles'); ?>
<link rel="stylesheet" href="<?php echo e(asset('assets/css/admin/view-car.css')); ?>">
<?php $__env->stopPush(); ?>

<?php $__env->startSection('content'); ?>
<div class="container-fluid">
    <div class="car-details-container">
        <!-- Car Image Section -->
        <div class="car-image-section">
            <div class="car-image-wrapper">
                <?php if($car->car_image): ?>
                    <img src="<?php echo e(asset($car->car_image)); ?>" alt="Car Image" class="car-image">
                <?php else: ?>
                    <div class="no-image-placeholder">
                        <i class="fas fa-car fa-3x mb-3"></i>
                        <p class="mb-0">No image available</p>
                    </div>
                <?php endif; ?>
            </div>
        </div>

        <!-- Car Information Section -->
        <div class="car-info-section">
            <div class="info-grid">
                <div class="info-card">
                    <div class="info-label">Car Maker</div>
                    <p class="info-value"><?php echo e($car->maker); ?></p>
                </div>

                <div class="info-card">
                    <div class="info-label">Model</div>
                    <p class="info-value"><?php echo e($car->model); ?></p>
                </div>

                <div class="info-card">
                    <div class="info-label">Vehicle Type</div>
                    <p class="info-value"><?php echo e($car->vehicle_type); ?></p>
                </div>

                <div class="info-card">
                    <div class="info-label">Condition</div>
                    <p class="info-value"><?php echo e($car->car_condition); ?></p>
                </div>

                <div class="info-card">
                    <div class="info-label">Mileage</div>
                    <p class="info-value"><?php echo e(number_format($car->mileage)); ?> km</p>
                </div>

                <div class="info-card">
                    <div class="info-label">Price per Day</div>
                    <p class="info-value price-highlight">BTN <?php echo e(number_format($car->price, 2)); ?></p>
                </div>

                <div class="info-card">
                    <div class="info-label">Registration Number</div>
                    <p class="info-value"><?php echo e($car->registration_no); ?></p>
                </div>

                <div class="info-card">
                    <div class="info-label">Status</div>
                    <span class="status-badge status-<?php echo e(strtolower($car->status)); ?>">
                        <i class="fas fa-circle me-1" style="font-size: 0.5rem;"></i>
                        <?php echo e($car->status); ?>

                    </span>
                </div>
            </div>

            <?php if($car->description): ?>
                <div class="description-card">
                    <div class="info-label mb-2">Description</div>
                    <p class="description-text"><?php echo e($car->description); ?></p>
                </div>
            <?php endif; ?>
        </div>

        <!-- Action Buttons -->
        <div class="action-buttons">
            <form action="<?php echo e(route('car-admin.admin.requestInspection', ['car' => $car->id])); ?>" method="GET" class="d-inline">
                <button type="submit" class="btn-action btn-primary-action">
                    <i class="fas fa-clipboard-check"></i>
                    Request Inspection
                </button>
            </form>

            <form action="<?php echo e(route('car-admin.showRejectForm', ['car' => $car->id])); ?>" method="GET" class="d-inline">
                <button type="submit" class="btn-action btn-danger-action">
                    <i class="fas fa-times-circle"></i>
                    Reject Application
                </button>
            </form>
        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php $__env->startPush('scripts'); ?>
<script>
    // Add any additional JavaScript functionality here
    document.addEventListener('DOMContentLoaded', function() {
        // Add smooth scrolling or other interactions if needed
        console.log('Car details page loaded');
    });
</script>
<?php $__env->stopPush(); ?>
<?php echo $__env->make('layouts.admin', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\Sangay Ngedup\Documents\GitHub\FinalProject\resources\views/admin/view-car.blade.php ENDPATH**/ ?>