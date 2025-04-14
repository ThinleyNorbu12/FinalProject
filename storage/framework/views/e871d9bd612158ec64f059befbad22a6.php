

<?php $__env->startSection('content'); ?>

<link rel="stylesheet" href="<?php echo e(asset('assets/css/admin/newly-registered-cars.css')); ?>">
    <div class="container">
        <h1>Car Registration Request</h1>

        <?php if($cars->isEmpty()): ?>
            <p>No cars found.</p>
        <?php else: ?>
            <table class="table">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Maker</th>
                        <th>Model</th>
                        <th>Vehicle Type</th>
                        <th>Price per Day</th>
                        <th>Registration Number</th>
                        <th>Status</th>
                        <th>Car Image</th> <!-- Image Column -->
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php $__currentLoopData = $cars; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $car): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <tr>
                            <td><?php echo e($car->id); ?></td>
                            <td><?php echo e($car->maker); ?></td>
                            <td><?php echo e($car->model); ?></td>
                            <td><?php echo e($car->vehicle_type); ?></td>
                            <td><?php echo e($car->price); ?></td>
                            <td><?php echo e($car->registration_no); ?></td>
                            <td><?php echo e($car->status); ?></td>
                            <td>
                                <!-- Display Car Image -->
                                <?php if($car->car_image): ?>
                                    <img src="<?php echo e(asset($car->car_image)); ?>" alt="Car Image" style="width: 100px; height: auto;">
                                <?php else: ?>
                                    <p>No image</p>
                                <?php endif; ?>
                            </td>
                            <td>
                                <a href="<?php echo e(route('car-admin.view-car', $car->id)); ?>" class="btn btn-info">View</a>
                            </td>
                        </tr>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </tbody>
            </table>
        <?php endif; ?>
    </div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\Thinley Norbu\Documents\GitHub\FinalProject\resources\views/admin/newly-registered-cars.blade.php ENDPATH**/ ?>