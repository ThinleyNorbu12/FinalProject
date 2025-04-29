


<!-- Link to the external CSS file -->
<link rel="stylesheet" href="<?php echo e(asset('assets/css/admin/dashboard.css')); ?>">

<?php $__env->startSection('content'); ?>
    <div class="container">
        <div class="row">
            <!-- Left Panel: Profile Section -->
            <div class="col-md-4">
                <div class="profile-section">
                    <h2>Welcome to the Admin Dashboard</h2>

                    <?php if(Auth::guard('admin')->check()): ?>
                        <p>Hello, <?php echo e(Auth::guard('admin')->user()->name); ?>!</p>
                        <form method="POST" action="<?php echo e(route('admin.logout')); ?>">
                            <?php echo csrf_field(); ?>
                            <button type="submit" class="btn btn-danger">Logout</button>
                        </form>
                    <?php else: ?>
                        <p>You are not logged in as Admin.</p>
                        <a href="<?php echo e(route('admin.login')); ?>" class="btn btn-primary">Login as Admin</a>
                    <?php endif; ?>
                </div>
            </div>

            <!-- Right Panel: Dashboard Links -->
            <div class="col-md-8">
                <div class="dashboard-links">
                    <p>Manage system operations and view key updates from car owners here.</p>

                    <div class="links-container">
                        <a href="<?php echo e(route('car-admin.new-registration-cars')); ?>" class="btn btn-primary"> CAR REGISTRATION REQUEST</a>
                        <a href="<?php echo e(route('car-admin.inspection-requests')); ?>" class="btn btn-primary"> MANAGE INSPECTION REQUESTS</a>
                        <a href="<?php echo e(route('car-admin.approve-inspected-cars')); ?>" class="btn btn-primary">APPROVE/REJECT INSPECTED CARS</a>
                        <a href="<?php echo e(url('admin/view-payments')); ?>" class="btn btn-primary">3. VIEW PAYMENTS</a>
                        <a href="<?php echo e(url('admin/update-car-registration')); ?>" class="btn btn-primary">4. UPDATE CAR REGISTRATION</a>
                        <a href="<?php echo e(url('admin/car-information-update')); ?>" class="btn btn-primary">5. CAR INFORMATION UPDATE</a>
                        <a href="<?php echo e(url('admin/booked-car')); ?>" class="btn btn-primary">6. BOOKED CAR</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\Sangay Ngedup\Documents\GitHub\FinalProject\resources\views/admin/auth/dashboard.blade.php ENDPATH**/ ?>