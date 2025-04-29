

<?php $__env->startSection('content'); ?>
    <div class="container">
        
         
         <?php if($car->images && count($car->images)): ?>
         <div class="mb-3 d-flex flex-wrap gap-2">
             <?php $__currentLoopData = $car->images; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $image): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                 <div>
                     <img src="<?php echo e(asset($image->image_path)); ?>" alt="Car Image" style="width: 200px; height: auto;">
                 </div>
             <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
         </div>
         <?php else: ?>
         <p>No images available</p>
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

        <hr>

        
        <h3>Book this Car</h3>
        
            <?php echo csrf_field(); ?>
            <div class="mb-3">
                <label for="name" class="form-label">Full Name:</label>
                <input type="text" class="form-control" name="name" required>
            </div>

            <div class="mb-3">
                <label for="email" class="form-label">Email Address:</label>
                <input type="email" class="form-control" name="email" required>
            </div>

            <div class="mb-3">
                <label for="pickup_date" class="form-label">Pickup Date:</label>
                <input type="date" class="form-control" name="pickup_date" required>
            </div>

            <div class="mb-3">
                <label for="return_date" class="form-label">Return Date:</label>
                <input type="date" class="form-control" name="return_date" required>
            </div>

            <button type="submit" class="btn btn-primary">Confirm Booking</button>
        </form>
    </div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\Thinley Norbu\Documents\GitHub\FinalProject\resources\views/cars/book.blade.php ENDPATH**/ ?>