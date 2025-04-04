

<?php $__env->startSection('content'); ?>
<h2>Car Owner Login</h2>

<?php if(session('error')): ?>
    <p style="color:red;"><?php echo e(session('error')); ?></p>
<?php endif; ?>

<form method="POST" action="<?php echo e(route('carowner.login.submit')); ?>">
    <?php echo csrf_field(); ?>
    <input type="email" name="email" placeholder="Email" required><br><br>
    <input type="password" name="password" placeholder="Password" required><br><br>
    <button type="submit">Login</button>
</form>

<p>Don't have an account? <a href="<?php echo e(route('carowner.register')); ?>">Register</a></p>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\Thinley Norbu\Documents\GitHub\FinalProject\resources\views/CarOwner/login.blade.php ENDPATH**/ ?>