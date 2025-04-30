

<?php $__env->startSection('content'); ?>
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-6">
            <div class="profile-section">
                <h2>Welcome to the Customer Dashboard</h2>

                <?php if(Auth::guard('customer')->check()): ?>
                    <p>Hello, <?php echo e(Auth::guard('customer')->user()->name); ?>!</p>
                    <form method="POST" action="<?php echo e(route('customer.logout')); ?>">
                        <?php echo csrf_field(); ?>
                        <button type="submit" class="btn btn-danger">Logout</button>
                    </form>
                <?php else: ?>
                    <p>Hello, Guest!</p>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\Thinley Norbu\Documents\GitHub\FinalProject\resources\views/customer/dashboard.blade.php ENDPATH**/ ?>