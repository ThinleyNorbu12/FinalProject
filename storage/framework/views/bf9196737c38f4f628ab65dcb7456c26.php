

<?php $__env->startSection('content'); ?>
<h2>Welcome to Car Owner Dashboard</h2>
<p>Hello, <?php echo e(Auth::user()->name); ?>!</p>
<form method="POST" action="<?php echo e(route('carowner.logout')); ?>">
    <?php echo csrf_field(); ?>
    <button type="submit">Logout</button>
</form>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\Thinley Norbu\Documents\GitHub\FinalProject\resources\views/CarOwner/dashboard.blade.php ENDPATH**/ ?>