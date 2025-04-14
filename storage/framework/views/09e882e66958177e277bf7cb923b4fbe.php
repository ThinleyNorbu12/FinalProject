

<?php $__env->startSection('content'); ?>
    <h1>Rent a Car</h1>
    <link rel="stylesheet" href="<?php echo e(asset('assets/css/carowner/rent-car.css')); ?>">
    <form action="<?php echo e(route('carowner.storeRentCar')); ?>" method="POST" enctype="multipart/form-data">
        <?php echo csrf_field(); ?>
    <?php if(session('success')): ?>
    <p style="color: green;"><?php echo e(session('success')); ?></p>
<?php endif; ?>

<?php echo csrf_field(); ?>
    <label for="maker">Maker:</label>
    <input type="text" name="maker" id="maker" value="<?php echo e(old('maker')); ?>">
    <?php $__errorArgs = ['maker'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
        <span style="color: red;"><?php echo e($message); ?></span>
    <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
    <br>

    <label for="model">Model:</label>
    <input type="text" name="model" id="model" value="<?php echo e(old('model')); ?>">
    <?php $__errorArgs = ['model'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
        <span style="color: red;"><?php echo e($message); ?></span>
    <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
    <br>

    <label for="vehicle_type">Vehicle Type:</label>
    <select name="vehicle_type" id="vehicle_type">
        <option value="">Select a vehicle type</option>
        <option value="Sedan" <?php echo e(old('vehicle_type') == 'Sedan' ? 'selected' : ''); ?>>Sedan</option>
        <option value="SUV" <?php echo e(old('vehicle_type') == 'SUV' ? 'selected' : ''); ?>>SUV</option>
        <option value="Hatchback" <?php echo e(old('vehicle_type') == 'Hatchback' ? 'selected' : ''); ?>>Hatchback</option>
        <option value="Pickup" <?php echo e(old('vehicle_type') == 'Pickup' ? 'selected' : ''); ?>>Pickup</option>
    </select>
    <?php $__errorArgs = ['vehicle_type'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
        <span style="color: red;"><?php echo e($message); ?></span>
    <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
    <br>

    <label for="car_condition">Condition:</label>
    <select name="car_condition" id="car_condition">
        <option value="">Select condition</option>
        <option value="New" <?php echo e(old('car_condition') == 'New' ? 'selected' : ''); ?>>New</option>
        <option value="Used" <?php echo e(old('car_condition') == 'Used' ? 'selected' : ''); ?>>Used</option>
    </select>
    <?php $__errorArgs = ['car_condition'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
        <span style="color: red;"><?php echo e($message); ?></span>
    <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
    <br>

    <label for="mileage">Mileage (in km):</label>
    <input type="number" name="mileage" id="mileage" value="<?php echo e(old('mileage')); ?>">
    <?php $__errorArgs = ['mileage'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
        <span style="color: red;"><?php echo e($message); ?></span>
    <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
    <br>

    <label for="price">Price per Day:</label>
    <input type="number" name="price" id="price" value="<?php echo e(old('price')); ?>">
    <?php $__errorArgs = ['price'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
        <span style="color: red;"><?php echo e($message); ?></span>
    <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
    <br>

    <label for="registration_no">Registration Number:</label>
    <input type="text" name="registration_no" id="registration_no" value="<?php echo e(old('registration_no')); ?>">
    <?php $__errorArgs = ['registration_no'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
        <span style="color: red;"><?php echo e($message); ?></span>
    <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
    <br>

    <label for="status">Status:</label>
    <select name="status" id="status">
        <option value="">Select status</option>
        <option value="available" <?php echo e(old('status') == 'available' ? 'selected' : ''); ?>>Available</option>
        <option value="rented" <?php echo e(old('status') == 'rented' ? 'selected' : ''); ?>>Rented</option>
        <option value="maintenance" <?php echo e(old('status') == 'maintenance' ? 'selected' : ''); ?>>Under Maintenance</option>
    </select>
    <?php $__errorArgs = ['status'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
        <span style="color: red;"><?php echo e($message); ?></span>
    <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
    <br>

    <label for="description">Description:</label>
    <textarea name="description" id="description"><?php echo e(old('description')); ?></textarea>
    <?php $__errorArgs = ['description'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
        <span style="color: red;"><?php echo e($message); ?></span>
    <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
    <br>

    <label for="car_image">Car Image:</label>
    <input type="file" name="car_image" id="car_image">
    <?php $__errorArgs = ['car_image'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
        <span style="color: red;"><?php echo e($message); ?></span>
    <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
    <br>

    <button type="submit">Submit</button>
</form>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\Thinley Norbu\Documents\GitHub\FinalProject\resources\views/CarOwner/rent-car.blade.php ENDPATH**/ ?>