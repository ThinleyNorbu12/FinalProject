

<?php $__env->startSection('content'); ?>
    <h1>Rent a Car</h1>
    <link rel="stylesheet" href="<?php echo e(asset('assets/css/carowner/rent-car.css')); ?>">
    <form action="<?php echo e(route('carowner.storeRentCar')); ?>" method="POST" enctype="multipart/form-data">
        <?php echo csrf_field(); ?>

        <?php if(session('success')): ?>
            <p style="color: green;"><?php echo e(session('success')); ?></p>
        <?php endif; ?>

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

        

        <h3>Car Features</h3>

        <label for="number_of_doors">Number of Doors:</label>
        <input type="number" name="number_of_doors" id="number_of_doors" value="<?php echo e(old('number_of_doors')); ?>">
        <?php $__errorArgs = ['number_of_doors'];
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

        <label for="number_of_seats">Number of Seats:</label>
        <input type="number" name="number_of_seats" id="number_of_seats" value="<?php echo e(old('number_of_seats')); ?>">
        <?php $__errorArgs = ['number_of_seats'];
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

        <label for="transmission_type">Transmission Type:</label>
        <select name="transmission_type" id="transmission_type">
            <option value="">Select transmission</option>
            <option value="Automatic" <?php echo e(old('transmission_type') == 'Automatic' ? 'selected' : ''); ?>>Automatic</option>
            <option value="Manual" <?php echo e(old('transmission_type') == 'Manual' ? 'selected' : ''); ?>>Manual</option>
        </select>
        <?php $__errorArgs = ['transmission_type'];
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

        <label for="large_bags_capacity">Large Bags Capacity:</label>
        <input type="number" name="large_bags_capacity" id="large_bags_capacity" value="<?php echo e(old('large_bags_capacity')); ?>">
        <?php $__errorArgs = ['large_bags_capacity'];
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

        <label for="small_bags_capacity">Small Bags Capacity:</label>
        <input type="number" name="small_bags_capacity" id="small_bags_capacity" value="<?php echo e(old('small_bags_capacity')); ?>">
        <?php $__errorArgs = ['small_bags_capacity'];
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

         <!-- Fuel Type Field Added -->
         <label for="fuel_type">Fuel Type:</label>
         <select name="fuel_type" id="fuel_type">
             <option value="">Select fuel type</option>
             <option value="Petrol" <?php echo e(old('fuel_type') == 'Petrol' ? 'selected' : ''); ?>>Petrol</option>
             <option value="Diesel" <?php echo e(old('fuel_type') == 'Diesel' ? 'selected' : ''); ?>>Diesel</option>
             <option value="Electric" <?php echo e(old('fuel_type') == 'Electric' ? 'selected' : ''); ?>>Electric</option>
             <option value="Hybrid" <?php echo e(old('fuel_type') == 'Hybrid' ? 'selected' : ''); ?>>Hybrid</option>
         </select>
         <?php $__errorArgs = ['fuel_type'];
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
        <!-- Air Conditioning -->
        <label for="air_conditioning">Air Conditioning:</label><br>
        <input type="radio" name="air_conditioning" value="Yes" 
            <?php echo e(old('air_conditioning') == 'Yes' ? 'checked' : ''); ?>> Yes
        <input type="radio" name="air_conditioning" value="No" 
            <?php echo e(old('air_conditioning') == 'No' ? 'checked' : ''); ?>> No
        <?php $__errorArgs = ['air_conditioning'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
            <span style="color: red;"><?php echo e($message); ?></span>
        <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
        <br><br>

        <!-- Backup Camera -->
        <label for="backup_camera">Backup Camera:</label><br>
        <input type="radio" name="backup_camera" value="Yes" 
            <?php echo e(old('backup_camera') == 'Yes' ? 'checked' : ''); ?>> Yes
        <input type="radio" name="backup_camera" value="No" 
            <?php echo e(old('backup_camera') == 'No' ? 'checked' : ''); ?>> No
        <?php $__errorArgs = ['backup_camera'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
            <span style="color: red;"><?php echo e($message); ?></span>
        <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
        <br><br>

        <!-- Bluetooth -->
        <label for="bluetooth">Bluetooth:</label><br>
        <input type="radio" name="bluetooth" value="Yes" 
            <?php echo e(old('bluetooth') == 'Yes' ? 'checked' : ''); ?>> Yes
        <input type="radio" name="bluetooth" value="No" 
            <?php echo e(old('bluetooth') == 'No' ? 'checked' : ''); ?>> No
        <?php $__errorArgs = ['bluetooth'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
            <span style="color: red;"><?php echo e($message); ?></span>
        <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
        <br><br>




        

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