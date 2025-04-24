<form method="POST" action="<?php echo e(route('customer.password.update')); ?>">
    <?php echo csrf_field(); ?>
    <input type="hidden" name="token" value="<?php echo e($token); ?>">

    <div>
        <label for="email">Email Address</label>
        <input type="email" name="email" value="<?php echo e(old('email', $email)); ?>" required>
    </div>

    <div>
        <label for="password">New Password</label>
        <input type="password" name="password" required>
    </div>

    <div>
        <label for="password_confirmation">Confirm Password</label>
        <input type="password" name="password_confirmation" required>
    </div>

    <button type="submit">Reset Password</button>
</form>
<?php /**PATH C:\Users\Thinley Norbu\Documents\GitHub\FinalProject\resources\views/customer/auth/passwords/reset.blade.php ENDPATH**/ ?>