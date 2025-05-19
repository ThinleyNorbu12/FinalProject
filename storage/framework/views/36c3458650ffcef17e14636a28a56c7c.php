
 <link rel="stylesheet" href="<?php echo e(asset('assets/css/admin/adminsidebar.css')); ?>">
<?php $__env->startSection('content'); ?>
<div class="dashboard-sidebar">
    <div class="sidebar-header">
        <div class="logo">
            <img src="<?php echo e(asset('assets/images/logo.png')); ?>" alt="Logo">
            <h2>Admin Portal</h2>
        </div>
        <button id="sidebar-toggle" class="sidebar-toggle">
            <i class="fas fa-bars"></i>
        </button>
    </div>

    <div class="admin-profile">
        <?php if(Auth::guard('admin')->check()): ?>
            <div class="profile-avatar">
                <img src="<?php echo e(asset('assets/images/thinley.jpg')); ?>" alt="Admin Avatar">
            </div>
            <div class="profile-info">
                <h3><?php echo e(Auth::guard('admin')->user()->name); ?></h3>
                <span>Administrator</span>
            </div>
        <?php endif; ?>
    </div>

    <div class="sidebar" id="sidebar">
        <div class="sidebar-menu">
            <a href="<?php echo e(route('admin.dashboard')); ?>" class="sidebar-menu-item">
                <i class="fas fa-tachometer-alt"></i>
                <span>Dashboard</span>
            </a>

            <div class="sidebar-divider"></div>
            <div class="sidebar-heading">Car Owner</div>

            <a href="<?php echo e(route('car-admin.new-registration-cars')); ?>" class="sidebar-menu-item active">
                <i class="fas fa-car"></i>
                <span>Car Registration</span>
            </a>

            <a href="<?php echo e(route('car-admin.inspection-requests')); ?>" class="sidebar-menu-item">
                <i class="fas fa-clipboard-check"></i>
                <span>Inspection Requests</span>
            </a>

            <a href="<?php echo e(route('car-admin.approve-inspected-cars')); ?>" class="sidebar-menu-item">
                <i class="fas fa-check-circle"></i>
                <span>Approve Inspections</span>
            </a>

            <div class="sidebar-divider"></div>
            <div class="sidebar-heading">Customer</div>

            <a href="<?php echo e(route('admin.verify-users')); ?>" class="sidebar-menu-item">
                <i class="fas fa-id-card"></i>
                <span>Verify Users</span>
            </a>

            <a href="<?php echo e(route('admin.payments.index')); ?>" class="sidebar-menu-item">
                <i class="fas fa-credit-card"></i>
                <span>Payments</span>
            </a>

            <a href="<?php echo e(url('admin/update-car-registration')); ?>" class="sidebar-menu-item">
                <i class="fas fa-edit"></i>
                <span>Update Registration</span>
            </a>

            <a href="<?php echo e(url('admin/car-information-update')); ?>" class="sidebar-menu-item">
                <i class="fas fa-info-circle"></i>
                <span>Car Information</span>
            </a>

            <a href="<?php echo e(route('admin.booked-car')); ?>" class="sidebar-menu-item">
                <i class="fas fa-calendar-check"></i>
                <span>Booked Cars</span>
            </a>

            <a href="#" class="sidebar-menu-item" onclick="document.getElementById('logout-form').submit();">
                <i class="fas fa-sign-out-alt"></i>
                <span>Logout</span>
            </a>

            <form method="POST" action="<?php echo e(route('admin.logout')); ?>" id="logout-form" style="display: none;">
                <?php echo csrf_field(); ?>
            </form>
        </div>
    </div>
</div>

<div class="container">
    <h1>Car Details</h1>

    
    <?php if($car->car_image): ?>
        <div class="mb-3">
            <img src="<?php echo e(asset($car->car_image)); ?>" alt="Car Image" style="width: 200px; height: auto;">
        </div>
    <?php else: ?>
        <p>No image available</p>
    <?php endif; ?>

    
    <div class="car-details">
        <p><strong>Car Maker:</strong> <?php echo e($car->maker); ?></p>
        <p><strong>Model:</strong> <?php echo e($car->model); ?></p>
        <p><strong>Vehicle Type:</strong> <?php echo e($car->vehicle_type); ?></p>
        <p><strong>Condition:</strong> <?php echo e($car->car_condition); ?></p>
        <p><strong>Mileage:</strong> <?php echo e($car->mileage); ?> km</p>
        <p><strong>Price per Day:</strong> $<?php echo e($car->price); ?> per day</p>
        <p><strong>Registration Number:</strong> <?php echo e($car->registration_no); ?></p>
        <p><strong>Status:</strong> <?php echo e($car->status); ?></p>
        <p><strong>Description:</strong> <?php echo e($car->description); ?></p>
    </div>

    
    <div class="car-actions mt-4">
        <form action="<?php echo e(route('car-admin.admin.requestInspection', ['car' => $car->id])); ?>" method="GET" class="d-inline">
            <button type="submit" class="btn btn-primary">Request for Inspection</button>
        </form>

        <form action="<?php echo e(route('car-admin.showRejectForm', ['car' => $car->id])); ?>" method="GET" class="d-inline">
            <button type="submit" class="btn btn-danger">Reject</button>
        </form>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\Sangay Ngedup\Documents\GitHub\FinalProject\resources\views/admin/view-car.blade.php ENDPATH**/ ?>