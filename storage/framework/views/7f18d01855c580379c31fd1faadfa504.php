 <!-- Replace with your actual layout -->

<?php $__env->startSection('content'); ?>
    <div class="container">
        <h2>Rejected Cars</h2>
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>Sl. No</th>
                    <th>Maker</th>
                    <th>Model</th>
                    <th>Vehicle Type</th>
                    <th>Condition</th>
                    <th>Price</th>
                    <th>Registration No</th>
                </tr>
            </thead>
            <tbody>
                <?php $__empty_1 = true; $__currentLoopData = $rejectedCars; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $car): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                    <tr>
                        <td><?php echo e($loop->iteration); ?></td>
                        <td><?php echo e($car->maker); ?></td>
                        <td><?php echo e($car->model); ?></td>
                        <td><?php echo e($car->vehicle_type); ?></td>
                        <td><?php echo e($car->car_condition); ?></td>
                        <td><?php echo e($car->price); ?></td>
                        <td><?php echo e($car->registration_no); ?></td>
                    </tr>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                    <tr>
                        <td colspan="6">No rejected cars found.</td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\Sangay Ngedup\Documents\GitHub\FinalProject\resources\views/CarOwner/rejected-cars.blade.php ENDPATH**/ ?>