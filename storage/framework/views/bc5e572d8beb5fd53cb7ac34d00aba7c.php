

<?php $__env->startSection('content'); ?>
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