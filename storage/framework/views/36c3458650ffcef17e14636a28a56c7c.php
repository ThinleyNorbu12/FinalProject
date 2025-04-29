

<?php $__env->startSection('content'); ?>
    <div class="container">
        <h1>Car Details</h1>

        
        <?php if($car->car_image): ?>
            <div class="mb-3">
                <img src="<?php echo e(asset($car->car_image)); ?>" alt="Car Image" style="width: 200px; height: auto;">
            </div>
        <?php else: ?>
            <p>No image available</p>
        <?php endif; ?>

        
        <div class="car-details">
            <p><strong>Car Maker:</strong> <?php echo e($car->maker); ?></p>
            <p><strong>Model:</strong> <?php echo e($car->model); ?></p>
            <p><strong>Vehicle Type:</strong> <?php echo e($car->vehicle_type); ?></p>
            <p><strong>Condition:</strong> <?php echo e($car->car_condition); ?></p>
            <p><strong>Mileage:</strong> <?php echo e($car->mileage); ?> km</p>
            <p><strong>Price per Day:</strong> $<?php echo e($car->price); ?> per day</p>
            <p><strong>Registration Number:</strong> <?php echo e($car->registration_no); ?></p>
            <p><strong>Status:</strong> <?php echo e($car->status); ?></p>
            <p><strong>Description:</strong> <?php echo e($car->description); ?></p>
        </div>

        

        
        <div class="car-actions mt-4">
            <form action="<?php echo e(route('car-admin.admin.requestInspection', ['car' => $car->id])); ?>" method="GET" class="d-inline">
                <button type="submit" class="btn btn-primary">Request for Inspection</button>
            </form>

            
            <form action="<?php echo e(route('car-admin.showRejectForm', ['car' => $car->id])); ?>" method="GET" class="d-inline">
                <button type="submit" class="btn btn-danger">Reject</button>
            </form>
            
        </div>
    </div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\Sangay Ngedup\Documents\GitHub\FinalProject\resources\views/admin/view-car.blade.php ENDPATH**/ ?>