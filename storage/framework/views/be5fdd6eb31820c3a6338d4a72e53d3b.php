


<!-- Link to the external CSS file -->
<link rel="stylesheet" href="<?php echo e(asset('assets/css/admin/dashboard.css')); ?>">

<?php $__env->startSection('content'); ?>
    <div class="container">
        <h1>Welcome to the Admin Dashboard</h1>

        <?php if(Auth::guard('admin')->check()): ?>
            <p>Hello, <?php echo e(Auth::guard('admin')->user()->name); ?>!</p>

            <form method="POST" action="<?php echo e(route('admin.logout')); ?>">
                <?php echo csrf_field(); ?>
                <button type="submit" class="btn btn-danger">Logout</button>
            </form>

            <div class="links-container" style="margin-top: 20px;">
                <a href="<?php echo e(route('car-admin.new-registration-cars')); ?>">CAR REGISTRATION REQUEST </a><br>
                <a href="<?php echo e(route('car-admin.inspection-requests')); ?>">MANAGE INSPECTION REQUEST</a><br>
                <a href="<?php echo e(url('admin/view-payments')); ?>"> VIEW PAYMENTS</a><br>
                <a href="<?php echo e(url('admin/update-car-registration')); ?>">3. UPDATE CAR REGISTRATION</a><br>
                <a href="<?php echo e(url('admin/car-information-update')); ?>">4. CAR INFORMATION UPDATE</a><br>
                <a href="<?php echo e(url('admin/booked-car')); ?>">5. BOOKED CAR</a>
            </div>
            

        <?php else: ?>
            <p>You are not logged in as an admin.</p>
            <a href="<?php echo e(route('admin.login')); ?>" class="btn btn-primary">Login as Admin</a>
        <?php endif; ?>
    </div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\Thinley Norbu\Documents\GitHub\FinalProject\resources\views/admin/auth/dashboard.blade.php ENDPATH**/ ?>