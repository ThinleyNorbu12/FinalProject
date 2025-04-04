

<?php $__env->startSection('content'); ?>
<h2>Car Owner Register</h2>

<?php if($errors->any()): ?>
    <ul style="color:red;">
        <?php $__currentLoopData = $errors->all(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $error): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <li><?php echo e($error); ?></li>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
    </ul>
<?php endif; ?>

<form method="POST" action="<?php echo e(route('carowner.register.submit')); ?>">
    <?php echo csrf_field(); ?>
    <input type="text" name="name" placeholder="Name" required><br><br>
    <input type="text" name="phone" placeholder="Phone Number" required><br><br>
    <input type="email" name="email" placeholder="Email" required><br><br>
    <textarea name="address" placeholder="Address" required></textarea><br><br>
    <button type="submit">Register</button>
</form>

<p>Already have an account? <a href="<?php echo e(route('carowner.login')); ?>">Login</a></p>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\Thinley Norbu\Documents\GitHub\FinalProject\resources\views/CarOwner/register.blade.php ENDPATH**/ ?>