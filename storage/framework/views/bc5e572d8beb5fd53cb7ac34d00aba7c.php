

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

            <a href="<?php echo e(route('admin.payments.index')); ?>" class="sidebar-menu-item ">
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

            <a href="<?php echo e(route ('admin.booked-car')); ?>" class="sidebar-menu-item ">
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
    <h1>Reject Car</h1>
    <p>Car: <?php echo e($car->maker); ?> <?php echo e($car->model); ?></p>
    <p>Registration No: <?php echo e($car->registration_no); ?></p>

    
    <form action="<?php echo e(route('car-admin.rejectCar', $car->id)); ?>" method="POST">
        <?php echo csrf_field(); ?>
        <div class="form-group">
            <label for="rejection_reason">Reason for Rejection</label>
            <textarea name="rejection_reason" id="rejection_reason" rows="4" class="form-control" required></textarea>
        </div>
        <button type="submit" class="btn btn-danger mt-3">Submit Rejection</button>
    </form>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\Thinley Norbu\Documents\GitHub\FinalProject\resources\views/admin/reject-car.blade.php ENDPATH**/ ?>