

<?php $__env->startSection('content'); ?>
<form method="POST" action="<?php echo e(route('admin.set-password.submit', $token)); ?>">
    <?php echo csrf_field(); ?>
    <label>New Password:</label>
    <input type="password" name="password" required><br>

    <label>Confirm Password:</label>
    <input type="password" name="password_confirmation" required><br>

    <button type="submit">Set Password</button>
</form>

<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\Thinley Norbu\Documents\GitHub\FinalProject\resources\views/admin/auth/set-password.blade.php ENDPATH**/ ?>