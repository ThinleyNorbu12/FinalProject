
<meta name="csrf-token" content="<?php echo e(csrf_token()); ?>">
<link rel="stylesheet" href="<?php echo e(asset('assets/css/admin/cars.css')); ?>">

<?php $__env->startSection('content'); ?>
<div class="dashboard-content" id="dashboardContent">
    <!-- Breadcrumb Navigation -->
    <nav class="page-breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item">
                <i class="fas fa-home"></i>
                <a href="<?php echo e(route('admin.dashboard')); ?>">Home</a>
            </li>
            <li class="breadcrumb-item">
                <a href="<?php echo e(route('cars.index')); ?>">Cars Management</a>
            </li>
            <li class="breadcrumb-item active">Edit Car</li>
        </ol>
    </nav>

    <!-- Notification Container -->
    <div class="notification-container">
        <?php if(session('success')): ?>
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <i class="fas fa-check-circle mr-2"></i>
            <?php echo e(session('success')); ?>

            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
        <?php endif; ?>

        <?php if(session('error')): ?>
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <i class="fas fa-exclamation-circle mr-2"></i>
            <?php echo e(session('error')); ?>

            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
        <?php endif; ?>

        <?php if($errors->any()): ?>
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <i class="fas fa-exclamation-triangle mr-2"></i>
            <strong>Oops! There were some problems with your input.</strong>
            <ul class="mt-2 mb-0">
                <?php $__currentLoopData = $errors->all(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $error): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <li><?php echo e($error); ?></li>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </ul>
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
        <?php endif; ?>
    </div>

    <!-- Edit Car Form -->
    <div class="card">
        <div class="card-header">
            <h2>Edit Car</h2>
        </div>
        <div class="card-body">
            <form action="<?php echo e(route('cars.update', $car->id)); ?>" method="POST" enctype="multipart/form-data">
                <?php echo csrf_field(); ?>
                <?php echo method_field('PUT'); ?>
                
                <div class="form-row">
                    <div class="form-group col-md-6">
                        <label for="maker">Maker <span class="required">*</span></label>
                        <input type="text" class="form-control" id="maker" name="maker" value="<?php echo e(old('maker', $car->maker)); ?>" required>
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
                    </div>
                    <div class="form-group col-md-6">
                        <label for="model">Model <span class="required">*</span></label>
                        <input type="text" class="form-control" id="model" name="model" value="<?php echo e(old('model', $car->model)); ?>" required>
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
                    </div>
                </div>
                
                <div class="form-row">
                    <div class="form-group col-md-6">
                        <label for="vehicle_type">Vehicle Type <span class="required">*</span></label>
                        <select id="vehicle_type" name="vehicle_type" class="form-control" required>
                            <option value="">Select a vehicle type</option>
                            <option value="Sedan" <?php echo e(old('vehicle_type', $car->vehicle_type) == 'Sedan' ? 'selected' : ''); ?>>Sedan</option>
                            <option value="SUV" <?php echo e(old('vehicle_type', $car->vehicle_type) == 'SUV' ? 'selected' : ''); ?>>SUV</option>
                            <option value="Hatchback" <?php echo e(old('vehicle_type', $car->vehicle_type) == 'Hatchback' ? 'selected' : ''); ?>>Hatchback</option>
                            <option value="Pickup" <?php echo e(old('vehicle_type', $car->vehicle_type) == 'Pickup' ? 'selected' : ''); ?>>Pickup</option>
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
                    </div>
                    <div class="form-group col-md-6">
                        <label for="car_condition">Condition <span class="required">*</span></label>
                        <select id="car_condition" name="car_condition" class="form-control" required>
                            <option value="">Select condition</option>
                            <option value="New" <?php echo e(old('car_condition', $car->car_condition) == 'New' ? 'selected' : ''); ?>>New</option>
                            <option value="Used" <?php echo e(old('car_condition', $car->car_condition) == 'Used' ? 'selected' : ''); ?>>Used</option>
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
                    </div>
                </div>
                
                <div class="form-row">
                    <div class="form-group col-md-6">
                        <label for="mileage">Mileage (in km) <span class="required">*</span></label>
                        <input type="number" class="form-control" id="mileage" name="mileage" value="<?php echo e(old('mileage', $car->mileage)); ?>" required>
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
                    </div>
                    <div class="form-group col-md-6">
                        <label for="price">Price per Day <span class="required">*</span></label>
                        <input type="number" class="form-control" id="price" name="price" value="<?php echo e(old('price', $car->price)); ?>" required>
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
                    </div>
                </div>
                
                <div class="form-row">
                    <div class="form-group col-md-6">
                        <label for="registration_no">Registration Number <span class="required">*</span></label>
                        <input type="text" class="form-control" id="registration_no" name="registration_no" value="<?php echo e(old('registration_no', $car->registration_no)); ?>" required>
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
                    </div>
                    <div class="form-group col-md-6">
                        <label for="status">Status <span class="required">*</span></label>
                        <select id="status" name="status" class="form-control" required>
                            <option value="">Select status</option>
                            <option value="available" <?php echo e(old('status', $car->status) == 'available' ? 'selected' : ''); ?>>Available</option>
                            <option value="rented" <?php echo e(old('status', $car->status) == 'rented' ? 'selected' : ''); ?>>Rented</option>
                            <option value="maintenance" <?php echo e(old('status', $car->status) == 'maintenance' ? 'selected' : ''); ?>>Under Maintenance</option>
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
                    </div>
                </div>
                
                <h4 class="mt-4 mb-3">Car Features</h4>
                
                <div class="form-row">
                    <div class="form-group col-md-6">
                        <label for="number_of_doors">Number of Doors <span class="required">*</span></label>
                        <input type="number" class="form-control" id="number_of_doors" name="number_of_doors" value="<?php echo e(old('number_of_doors', $car->number_of_doors)); ?>" required>
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
                    </div>
                    <div class="form-group col-md-6">
                        <label for="number_of_seats">Number of Seats <span class="required">*</span></label>
                        <input type="number" class="form-control" id="number_of_seats" name="number_of_seats" value="<?php echo e(old('number_of_seats', $car->number_of_seats)); ?>" required>
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
                    </div>
                </div>
                
                <div class="form-row">
                    <div class="form-group col-md-6">
                        <label for="transmission_type">Transmission Type <span class="required">*</span></label>
                        <select id="transmission_type" name="transmission_type" class="form-control" required>
                            <option value="">Select transmission</option>
                            <option value="Automatic" <?php echo e(old('transmission_type', $car->transmission_type) == 'Automatic' ? 'selected' : ''); ?>>Automatic</option>
                            <option value="Manual" <?php echo e(old('transmission_type', $car->transmission_type) == 'Manual' ? 'selected' : ''); ?>>Manual</option>
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
                    </div>
                    <div class="form-group col-md-6">
                        <label for="fuel_type">Fuel Type <span class="required">*</span></label>
                        <select id="fuel_type" name="fuel_type" class="form-control" required>
                            <option value="">Select fuel type</option>
                            <option value="Petrol" <?php echo e(old('fuel_type', $car->fuel_type) == 'Petrol' ? 'selected' : ''); ?>>Petrol</option>
                            <option value="Diesel" <?php echo e(old('fuel_type', $car->fuel_type) == 'Diesel' ? 'selected' : ''); ?>>Diesel</option>
                            <option value="Electric" <?php echo e(old('fuel_type', $car->fuel_type) == 'Electric' ? 'selected' : ''); ?>>Electric</option>
                            <option value="Hybrid" <?php echo e(old('fuel_type', $car->fuel_type) == 'Hybrid' ? 'selected' : ''); ?>>Hybrid</option>
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
                    </div>
                </div>
                
                <div class="form-row">
                    <div class="form-group col-md-6">
                        <label for="large_bags_capacity">Large Bags Capacity</label>
                        <input type="number" class="form-control" id="large_bags_capacity" name="large_bags_capacity" value="<?php echo e(old('large_bags_capacity', $car->large_bags_capacity)); ?>">
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
                    </div>
                    <div class="form-group col-md-6">
                        <label for="small_bags_capacity">Small Bags Capacity</label>
                        <input type="number" class="form-control" id="small_bags_capacity" name="small_bags_capacity" value="<?php echo e(old('small_bags_capacity', $car->small_bags_capacity)); ?>">
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
                    </div>
                </div>
                
                <div class="form-row">
                    <div class="form-group col-md-4">
                        <label>Air Conditioning</label>
                        <div class="d-flex">
                            <div class="custom-control custom-radio mr-3">
                                <input type="radio" id="air_conditioning_yes" name="air_conditioning" value="Yes" 
                                    class="custom-control-input" <?php echo e(old('air_conditioning', $car->air_conditioning) == 'Yes' ? 'checked' : ''); ?>>
                                <label class="custom-control-label" for="air_conditioning_yes">Yes</label>
                            </div>
                            <div class="custom-control custom-radio">
                                <input type="radio" id="air_conditioning_no" name="air_conditioning" value="No" 
                                    class="custom-control-input" <?php echo e(old('air_conditioning', $car->air_conditioning) == 'No' ? 'checked' : ''); ?>>
                                <label class="custom-control-label" for="air_conditioning_no">No</label>
                            </div>
                        </div>
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
                    </div>
                    <div class="form-group col-md-4">
                        <label>Backup Camera</label>
                        <div class="d-flex">
                            <div class="custom-control custom-radio mr-3">
                                <input type="radio" id="backup_camera_yes" name="backup_camera" value="Yes" 
                                    class="custom-control-input" <?php echo e(old('backup_camera', $car->backup_camera) == 'Yes' ? 'checked' : ''); ?>>
                                <label class="custom-control-label" for="backup_camera_yes">Yes</label>
                            </div>
                            <div class="custom-control custom-radio">
                                <input type="radio" id="backup_camera_no" name="backup_camera" value="No" 
                                    class="custom-control-input" <?php echo e(old('backup_camera', $car->backup_camera) == 'No' ? 'checked' : ''); ?>>
                                <label class="custom-control-label" for="backup_camera_no">No</label>
                            </div>
                        </div>
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
                    </div>
                    <div class="form-group col-md-4">
                        <label>Bluetooth</label>
                        <div class="d-flex">
                            <div class="custom-control custom-radio mr-3">
                                <input type="radio" id="bluetooth_yes" name="bluetooth" value="Yes" 
                                    class="custom-control-input" <?php echo e(old('bluetooth', $car->bluetooth) == 'Yes' ? 'checked' : ''); ?>>
                                <label class="custom-control-label" for="bluetooth_yes">Yes</label>
                            </div>
                            <div class="custom-control custom-radio">
                                <input type="radio" id="bluetooth_no" name="bluetooth" value="No" 
                                    class="custom-control-input" <?php echo e(old('bluetooth', $car->bluetooth) == 'No' ? 'checked' : ''); ?>>
                                <label class="custom-control-label" for="bluetooth_no">No</label>
                            </div>
                        </div>
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
                    </div>
                </div>
                
                <div class="form-group">
                    <label for="description">Description</label>
                    <textarea class="form-control" id="description" name="description" rows="3"><?php echo e(old('description', $car->description)); ?></textarea>
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
                </div>
                
                <!-- Current Images Display - UPDATED SECTION -->
                <div class="form-group">
                    <label>Current Images</label>
                    <div class="current-images">
                        <?php
                            $allImages = collect();
                            
                            // Add primary image if exists
                            if($car->car_image) {
                                $allImages->push([
                                    'type' => 'primary',
                                    'path' => $car->car_image,
                                    'id' => null,
                                    'label' => 'Primary'
                                ]);
                            }
                            
                            // For AdminCar model - try different relationship names that might exist
                            $additionalImages = null;
                            
                            // Check for AdminCarImage relationship
                            if(method_exists($car, 'adminCarImages') && $car->adminCarImages) {
                                $additionalImages = $car->adminCarImages;
                            } elseif(method_exists($car, 'carImages') && $car->carImages) {
                                $additionalImages = $car->carImages;
                            } elseif(method_exists($car, 'images') && $car->images) {
                                $additionalImages = $car->images;
                            } elseif(method_exists($car, 'additionalImages') && $car->additionalImages) {
                                $additionalImages = $car->additionalImages;
                            }
                            
                            // Try to load relationship dynamically if not loaded
                            if(!$additionalImages) {
                                try {
                                    // Try to load AdminCarImage records directly
                                    $additionalImages = \App\Models\AdminCarImage::where('car_id', $car->id)->get();
                                } catch(Exception $e) {
                                    // If AdminCarImage doesn't exist, try other possible models
                                    try {
                                        $additionalImages = \App\Models\CarImage::where('car_id', $car->id)->get();
                                    } catch(Exception $e2) {
                                        $additionalImages = collect();
                                    }
                                }
                            }
                            
                            if($additionalImages && $additionalImages->count() > 0) {
                                foreach($additionalImages as $index => $additionalImage) {
                                    // Try different possible column names for image path
                                    $imagePath = $additionalImage->image_path ?? 
                                               $additionalImage->path ?? 
                                               $additionalImage->image_name ?? 
                                               $additionalImage->filename ?? 
                                               $additionalImage->image ??
                                               $additionalImage->file_name ??
                                               $additionalImage->name;
                                               
                                    if($imagePath) {
                                        $allImages->push([
                                            'type' => 'additional',
                                            'path' => $imagePath,
                                            'id' => $additionalImage->id,
                                            'label' => 'Image ' . ($index + 2)
                                        ]);
                                    }
                                }
                            }
                            
                            // If still no additional images found, try other storage methods
                            if($additionalImages->count() === 0) {
                                // Check if images are stored as JSON in the main car table
                                if(isset($car->images) && is_string($car->images)) {
                                    $jsonImages = json_decode($car->images, true);
                                    if(is_array($jsonImages)) {
                                        foreach($jsonImages as $index => $imageName) {
                                            if($imageName !== $car->car_image) { // Don't duplicate primary image
                                                $allImages->push([
                                                    'type' => 'additional',
                                                    'path' => $imageName,
                                                    'id' => null,
                                                    'label' => 'Image ' . ($index + 2)
                                                ]);
                                            }
                                        }
                                    }
                                }
                                
                                // Check for comma-separated string in various fields
                                $stringFields = ['additional_images', 'car_images', 'image_gallery', 'gallery_images'];
                                foreach($stringFields as $field) {
                                    if(isset($car->$field) && is_string($car->$field) && !empty($car->$field)) {
                                        $imageNames = explode(',', $car->$field);
                                        foreach($imageNames as $index => $imageName) {
                                            $imageName = trim($imageName);
                                            if(!empty($imageName)) {
                                                $allImages->push([
                                                    'type' => 'additional',
                                                    'path' => $imageName,
                                                    'id' => null,
                                                    'label' => 'Image ' . ($allImages->count() + 1)
                                                ]);
                                            }
                                        }
                                        break; // Found images, no need to check other fields
                                    }
                                }
                            }
                        ?>
                        
                        <?php if($allImages->count() > 0): ?>
                            <?php $__currentLoopData = $allImages; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $image): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <div class="current-image-item" 
                                     data-image-type="<?php echo e($image['type']); ?>" 
                                     <?php if($image['id']): ?> data-image-id="<?php echo e($image['id']); ?>" <?php endif; ?>>
                                    <img src="<?php echo e(asset('admincar_images/' . $image['path'])); ?>"
                                        alt="<?php echo e($image['label']); ?>"
                                        class="img-thumbnail"
                                        onerror="this.style.display='none'; this.nextElementSibling.style.display='block';">
                                    <div class="image-error" style="display: none; padding: 20px; background: #f8f9fa; border: 1px solid #dee2e6; border-radius: 4px; text-align: center;">
                                        <i class="fas fa-image text-muted"></i>
                                        <p class="text-muted mb-0">Image not found</p>
                                        <small class="text-muted"><?php echo e($image['path']); ?></small>
                                    </div>
                                    <span class="badge <?php echo e($image['type'] === 'primary' ? 'badge-primary' : 'badge-secondary'); ?>">
                                        <?php echo e($image['label']); ?>

                                    </span>
                                    
                                    <!-- Delete Button -->
                                    <button type="button" 
                                            class="delete-image-btn" 
                                            data-image-type="<?php echo e($image['type']); ?>"
                                            data-car-id="<?php echo e($car->id); ?>"
                                            data-image-name="<?php echo e($image['path']); ?>"
                                            <?php if($image['id']): ?> data-image-id="<?php echo e($image['id']); ?>" <?php endif; ?>
                                            title="Delete Image">
                                        <i class="fas fa-times"></i>
                                    </button>
                                </div>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        <?php else: ?>
                            <p class="text-muted">No images uploaded yet.</p>
                        <?php endif; ?>
                    </div>
                    
                    <!-- Enhanced Debug Information -->
                    <div class="alert alert-info mt-2" style="font-size: 0.875rem;">
                        <strong>AdminCar Model Debug:</strong><br>
                        Car ID: <?php echo e($car->id ?? 'Not Set'); ?><br>
                        Model Class: <?php echo e(get_class($car)); ?><br>
                        
                        <strong>Primary Image Field:</strong> 
                        <?php if(isset($car->car_image)): ?>
                            <?php if($car->car_image): ?>
                                ✓ <?php echo e($car->car_image); ?>

                            <?php else: ?>
                                ✗ Empty/Null
                            <?php endif; ?>
                        <?php else: ?>
                            ✗ Field doesn't exist
                        <?php endif; ?>
                        <br>
                        
                        <strong>AdminCar Image-Related Fields:</strong><br>
                        <?php $__currentLoopData = $car->getAttributes(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $value): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <?php if(Str::contains($key, ['image', 'picture', 'photo'])): ?>
                                • <span style="color: #007bff;"><?php echo e($key); ?></span>: 
                                <?php if(is_string($value)): ?>
                                    "<?php echo e(Str::limit($value, 50)); ?>"
                                <?php elseif(is_null($value)): ?>
                                    <em>null</em>
                                <?php else: ?>
                                    <?php echo e($value); ?>

                                <?php endif; ?>
                                <br>
                            <?php endif; ?>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        
                        <strong>AdminCarImage Relationship Test:</strong><br>
                        <?php
                            $relationshipTests = [
                                'adminCarImages', 'carImages', 'images', 'additionalImages', 
                                'adminImages', 'car_images', 'additional_images'
                            ];
                            $workingRelationships = [];
                        ?>
                        
                        <?php $__currentLoopData = $relationshipTests; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $relationName): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            @try
                                <?php if(method_exists($car, $relationName)): ?>
                                    <?php
                                        $relationData = $car->$relationName;
                                        $count = is_countable($relationData) ? $relationData->count() : 'Not Countable';
                                        $workingRelationships[$relationName] = $count;
                                    ?>
                                    • <?php echo e($relationName); ?>: ✓ EXISTS (Count: <?php echo e($count); ?>)
                                    <?php if($count > 0): ?>
                                        <span style="color: green; font-weight: bold;">← FOUND <?php echo e($count); ?> IMAGES!</span>
                                    <?php endif; ?>
                                    <br>
                                <?php else: ?>
                                    • <?php echo e($relationName); ?>: ✗ Method doesn't exist<br>
                                <?php endif; ?>
                            @catch(Exception $e)
                                • <?php echo e($relationName); ?>: ❌ Error: <?php echo e($e->getMessage()); ?><br>
                            @endtry
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        
                        <strong>Direct AdminCarImage Query:</strong><br>
                        <?php
                            try {
                                $directImages = \App\Models\AdminCarImage::where('car_id', $car->id)->get();
                                $directCount = $directImages->count();
                            } catch(Exception $e) {
                                $directImages = null;
                                $directCount = 'Error: ' . $e->getMessage();
                            }
                        ?>
                        
                        AdminCarImage records for car_id <?php echo e($car->id); ?>: 
                        <?php if(is_numeric($directCount)): ?>
                            <span style="color: <?php echo e($directCount > 0 ? 'green' : 'orange'); ?>; font-weight: bold;">
                                <?php echo e($directCount); ?> records found
                            </span>
                            <?php if($directCount > 0 && $directImages): ?>
                                <br>
                                <details style="margin-left: 20px;">
                                    <summary>Click to see AdminCarImage records</summary>
                                    <?php $__currentLoopData = $directImages->take(5); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $img): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        • ID: <?php echo e($img->id); ?>, 
                                        <?php $__currentLoopData = $img->getAttributes(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $col => $val): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                            <?php if(Str::contains($col, ['image', 'path', 'name', 'file'])): ?>
                                                <?php echo e($col); ?>: "<?php echo e($val); ?>", 
                                            <?php endif; ?>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                        <br>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                    <?php if($directCount > 5): ?>
                                        ... and <?php echo e($directCount - 5); ?> more
                                    <?php endif; ?>
                                </details>
                            <?php endif; ?>
                        <?php else: ?>
                            <span style="color: red;"><?php echo e($directCount); ?></span>
                        <?php endif; ?>
                        <br>
                        
                        <strong>AdminCar Database Structure Check:</strong><br>
                        <?php
                            try {
                                $dbCheck = DB::table('admin_cars')->where('id', $car->id)->first();
                                $imageFields = [];
                                if($dbCheck) {
                                    foreach((array)$dbCheck as $key => $value) {
                                        if(Str::contains($key, ['image', 'picture', 'photo']) && !empty($value)) {
                                            $imageFields[$key] = $value;
                                        }
                                    }
                                }
                            } catch(Exception $e) {
                                $imageFields = ['error' => $e->getMessage()];
                            }
                        ?>
                        
                        <?php if(empty($imageFields)): ?>
                            ⚠️ No image fields with data found in admin_cars table
                        <?php elseif(isset($imageFields['error'])): ?>
                            ❌ Database error: <?php echo e($imageFields['error']); ?>

                        <?php else: ?>
                            <?php $__currentLoopData = $imageFields; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $field => $value): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                • admin_cars.<?php echo e($field); ?>: <?php echo e($value); ?><br>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        <?php endif; ?>
                        
                        <strong>AdminCarImage Table Check:</strong><br>
                        <?php
                            try {
                                $imageTableCheck = DB::table('admin_car_images')->where('car_id', $car->id)->get();
                                $imageTableCount = $imageTableCheck->count();
                            } catch(Exception $e) {
                                $imageTableCheck = null;
                                $imageTableCount = 'Table not found or error: ' . $e->getMessage();
                            }
                        ?>
                        
                        admin_car_images table: 
                        <?php if(is_numeric($imageTableCount)): ?>
                            <span style="color: <?php echo e($imageTableCount > 0 ? 'green' : 'orange'); ?>; font-weight: bold;">
                                <?php echo e($imageTableCount); ?> records
                            </span>
                            <?php if($imageTableCount > 0): ?>
                                <br>
                                <details style="margin-left: 20px;">
                                    <summary>Click to see table records</summary>
                                    <?php $__currentLoopData = $imageTableCheck->take(5); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $record): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        • <?php $__currentLoopData = (array)$record; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $col => $val): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                            <?php echo e($col); ?>: "<?php echo e($val); ?>", 
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><br>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                </details>
                            <?php endif; ?>
                        <?php else: ?>
                            <span style="color: red;"><?php echo e($imageTableCount); ?></span>
                        <?php endif; ?>
                        <br>
                        
                        <strong>File System Check:</strong><br>
                        <?php
                            $imageDir = public_path('admincar_images');
                            $dirExists = is_dir($imageDir);
                            $imageFiles = [];
                            
                            if($dirExists) {
                                $files = glob($imageDir . '/*');
                                $imageFiles = array_filter($files, function($file) {
                                    return in_array(strtolower(pathinfo($file, PATHINFO_EXTENSION)), 
                                        ['jpg', 'jpeg', 'png', 'gif', 'webp', 'avif']);
                                });
                            }
                        ?>
                        
                        Directory 'public/admincar_images': <?php echo e($dirExists ? '✓ EXISTS' : '✗ NOT FOUND'); ?><br>
                        <?php if($dirExists): ?>
                            Total image files: <?php echo e(count($imageFiles)); ?><br>
                            <?php if(count($imageFiles) > 0): ?>
                                <details>
                                    <summary>Recent files (showing max 10)</summary>
                                    <?php $__currentLoopData = array_slice($imageFiles, -10); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $file): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        • <?php echo e(basename($file)); ?> (<?php echo e(date('Y-m-d H:i:s', filemtime($file))); ?>)<br>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                </details>
                            <?php endif; ?>
                        <?php endif; ?>
                        
                        <br><strong>Images Successfully Displayed:</strong> <?php echo e($allImages->count()); ?>

                        
                        <?php if($allImages->count() === 0): ?>
                            <div style="background: #fff3cd; padding: 10px; border-radius: 4px; margin-top: 10px; border-left: 4px solid #ffc107;">
                                <strong>⚠️ Fix Your AdminCar Setup:</strong><br>
                                
                                <?php if(is_numeric($directCount) && $directCount > 0): ?>
                                    <span style="color: green;">✓ Found <?php echo e($directCount); ?> AdminCarImage records!</span><br>
                                    <strong>Issue:</strong> Your AdminCar model needs a relationship. Add this to your AdminCar model:<br>
                                    <code style="background: #f8f9fa; padding: 2px 4px;">
                                        public function adminCarImages() {<br>
                                        &nbsp;&nbsp;&nbsp;&nbsp;return $this->hasMany(AdminCarImage::class, 'car_id');<br>
                                        }
                                    </code><br><br>
                                    
                                    And in your controller, load it with:<br>
                                    <code style="background: #f8f9fa; padding: 2px 4px;">
                                        $car = AdminCar::with('adminCarImages')->findOrFail($id);
                                    </code>
                                    
                                <?php elseif(is_numeric($imageTableCount) && $imageTableCount > 0): ?>
                                    <span style="color: green;">✓ Found <?php echo e($imageTableCount); ?> records in admin_car_images table!</span><br>
                                    <strong>Issue:</strong> The AdminCarImage model might have wrong foreign key or the relationship isn't defined properly.
                                    
                                <?php else: ?>
                                    <span style="color: red;">✗ No image records found in database</span><br>
                                    <strong>Issue:</strong> Images might not be saving correctly during upload. Check your upload controller.
                                <?php endif; ?>
                            </div>
                        <?php endif; ?>
                    </div>
                </div>

                <!-- Delete Confirmation Modal -->
                <div class="modal fade" id="deleteImageModal" tabindex="-1" role="dialog" aria-labelledby="deleteImageModalLabel" aria-hidden="true">
                    <div class="modal-dialog" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="deleteImageModalLabel">Confirm Delete</h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <div class="modal-body">
                                <p>Are you sure you want to delete this image? This action cannot be undone.</p>
                                <div class="text-center">
                                    <img id="deletePreviewImage" src="" alt="Image to delete" class="img-thumbnail" style="max-width: 200px; max-height: 150px;">
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                                <button type="button" class="btn btn-danger" id="confirmDeleteBtn">Delete Image</button>
                            </div>
                        </div>
                    </div>
                </div>
                
                <div class="form-group">
                    <label>Update Car Images</label>
                    <div class="file-upload-container" id="dropZone">
                        <h5 class="text-center mb-2">Drop new car images here</h5>
                        <p class="text-center mb-2">or</p>
                        <div class="text-center mb-2">
                            <label for="car_images" class="btn btn-outline-primary">Browse Files</label>
                            <input type="file" name="car_images[]" id="car_images" class="d-none" multiple accept="image/*">
                        </div>
                        <p class="text-center small text-muted">Supported formats: JPEG, PNG, JPG, WEBP, GIF, AVIF (max 2MB each)</p>
                        <p class="text-center small text-info">Leave empty to keep current images</p>
                        
                        <div id="selectedFiles" class="image-preview-container">
                            <!-- Image previews will be inserted here -->
                        </div>
                    </div>
                    
                    <?php $__errorArgs = ['car_images'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                        <span style="color: red;"><?php echo e($message); ?></span>
                    <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                </div>
                
                <div class="form-group mt-4">
                    <button type="submit" class="btn btn-primary">Update Car</button>
                    <a href="<?php echo e(route('cars.index')); ?>" class="btn btn-secondary">Cancel</a>
                </div>
            </form>
        </div>
    </div>
</div>

<style>
.current-images {
    display: flex;
    flex-wrap: wrap;
    gap: 15px;
    margin-bottom: 20px;
}

.current-image-item {
    position: relative;
    border-radius: 8px;
    overflow: hidden;
    box-shadow: 0 2px 8px rgba(0,0,0,0.1);
    transition: all 0.3s ease;
}

.current-image-item:hover {
    transform: scale(1.02);
}

.current-image-item img {
    width: 150px;
    height: 120px;
    object-fit: cover;
    border-radius: 6px;
}

.image-error {
    width: 150px;
    height: 120px;
    display: flex;
    flex-direction: column;
    justify-content: center;
    align-items: center;
}

/* Delete button styling with higher z-index and better positioning */
.delete-image-btn {
    position: absolute;
    top: 5px;
    right: 5px;
    background: rgba(220, 53, 69, 0.9) !important;
    color: white !important;
    border: none !important;
    border-radius: 50% !important;
    width: 28px !important;
    height: 28px !important;
    font-size: 14px !important;
    cursor: pointer !important;
    display: flex !important;
    align-items: center !important;
    justify-content: center !important;
    z-index: 1000 !important;
    transition: all 0.3s ease !important;
    opacity: 0.8 !important;
    padding: 0 !important;
    line-height: 1 !important;
    box-shadow: 0 2px 4px rgba(0,0,0,0.3) !important;
}

.delete-image-btn:hover {
    opacity: 1 !important;
    background: rgba(220, 53, 69, 1) !important;
    transform: scale(1.1) !important;
    box-shadow: 0 3px 6px rgba(0,0,0,0.4) !important;
}

.current-image-item:hover .delete-image-btn {
    opacity: 1 !important;
}

.delete-image-btn i {
    font-size: 12px !important;
    line-height: 1 !important;
}

/* Badge positioning */
.badge {
    position: absolute;
    top: 5px;
    left: 5px;
    font-size: 0.75em;
    padding: 0.25em 0.5em;
    z-index: 5;
}

.image-preview-container {
    display: flex;
    flex-wrap: wrap;
    gap: 10px;
    margin-top: 15px;
    justify-content: center;
}

.image-preview {
    position: relative;
    border-radius: 8px;
    overflow: hidden;
    box-shadow: 0 2px 8px rgba(0,0,0,0.1);
}

.image-preview img {
    width: 120px;
    height: 90px;
    object-fit: cover;
    border-radius: 6px;
}

.remove-btn {
    position: absolute;
    top: 5px;
    right: 5px;
    background: rgba(255, 0, 0, 0.8);
    color: white;
    border: none;
    border-radius: 50%;
    width: 25px;
    height: 25px;
    font-size: 18px;
    line-height: 1;
    cursor: pointer;
    display: flex;
    align-items: center;
    justify-content: center;
}

.remove-btn:hover {
    background: rgba(255, 0, 0, 1);
}

.file-upload-container {
    border: 2px dashed #ddd;
    padding: 20px;
    border-radius: 8px;
    text-align: center;
    transition: all 0.3s ease;
}

#dropZone.active {
    border-color: #007bff;
    background-color: rgba(0, 123, 255, 0.1);
}

.spinner-border-sm {
    width: 1rem;
    height: 1rem;
}
</style>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.6.0/js/bootstrap.bundle.min.js"></script>

<script>
$(document).ready(function() {
    let currentImageData = {};
    let selectedFiles = [];
    
    console.log('Document ready, initializing drag and drop functionality...');
    
    // Function to show alerts
    function showAlert(type, message) {
        const alertClass = type === 'success' ? 'alert-success' : 'alert-danger';
        const iconClass = type === 'success' ? 'fas fa-check-circle' : 'fas fa-exclamation-circle';
        
        const alertHtml = `
            <div class="alert ${alertClass} alert-dismissible fade show" role="alert">
                <i class="${iconClass} mr-2"></i>
                ${message}
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
        `;
        
        // Remove existing alerts first
        $('.notification-container .alert').remove();
        
        // Add alert to notification container
        $('.notification-container').prepend(alertHtml);
        
        // Auto-hide after 5 seconds
        setTimeout(function() {
            $('.notification-container .alert').fadeOut();
        }, 5000);
    }
    
    // File validation function
    function validateFile(file) {
        const allowedTypes = ['image/jpeg', 'image/jpg', 'image/png', 'image/webp', 'image/gif', 'image/avif'];
        const maxSize = 2 * 1024 * 1024; // 2MB
        
        if (!allowedTypes.includes(file.type)) {
            return { valid: false, message: `File ${file.name} has an invalid format. Please use JPEG, PNG, JPG, WEBP, GIF, or AVIF.` };
        }
        
        if (file.size > maxSize) {
            return { valid: false, message: `File ${file.name} is too large. Maximum size is 2MB.` };
        }
        
        return { valid: true };
    }
    
    // Function to create image preview
    function createImagePreview(file, index) {
        return new Promise((resolve, reject) => {
            const reader = new FileReader();
            reader.onload = function(e) {
                const previewHtml = `
                    <div class="image-preview" data-index="${index}">
                        <img src="${e.target.result}" alt="Preview ${index + 1}">
                        <button type="button" class="remove-btn" data-index="${index}" title="Remove image">
                            <i class="fas fa-times"></i>
                        </button>
                    </div>
                `;
                resolve(previewHtml);
            };
            reader.onerror = function() {
                reject(new Error('Failed to read file'));
            };
            reader.readAsDataURL(file);
        });
    }
    
    // Function to update file input and previews
    async function updateFileInputAndPreviews() {
        const $previewContainer = $('#selectedFiles');
        $previewContainer.empty();
        
        if (selectedFiles.length === 0) {
            return;
        }
        
        // Create DataTransfer object to update file input
        const dt = new DataTransfer();
        
        // Add all selected files to DataTransfer and create previews
        for (let i = 0; i < selectedFiles.length; i++) {
            const file = selectedFiles[i];
            dt.items.add(file);
            
            try {
                const previewHtml = await createImagePreview(file, i);
                $previewContainer.append(previewHtml);
            } catch (error) {
                console.error('Error creating preview for file:', file.name, error);
            }
        }
        
        // Update the file input
        $('#car_images')[0].files = dt.files;
        
        console.log(`Updated file input with ${selectedFiles.length} files`);
    }
    
    // Handle drag events for the drop zone
    const dropZone = document.getElementById('dropZone');
    
    // Prevent default drag behaviors
    ['dragenter', 'dragover', 'dragleave', 'drop'].forEach(eventName => {
        dropZone.addEventListener(eventName, preventDefaults, false);
        document.body.addEventListener(eventName, preventDefaults, false);
    });
    
    // Highlight drop zone when item is dragged over it
    ['dragenter', 'dragover'].forEach(eventName => {
        dropZone.addEventListener(eventName, highlight, false);
    });
    
    ['dragleave', 'drop'].forEach(eventName => {
        dropZone.addEventListener(eventName, unhighlight, false);
    });
    
    // Handle dropped files
    dropZone.addEventListener('drop', handleDrop, false);
    
    function preventDefaults(e) {
        e.preventDefault();
        e.stopPropagation();
    }
    
    function highlight(e) {
        dropZone.classList.add('active');
    }
    
    function unhighlight(e) {
        dropZone.classList.remove('active');
    }
    
    function handleDrop(e) {
        const dt = e.dataTransfer;
        const files = dt.files;
        
        console.log('Files dropped:', files.length);
        handleFiles(files);
    }
    
    // Handle file selection from browse button
    $('#car_images').on('change', function(e) {
        const files = e.target.files;
        console.log('Files selected via browse:', files.length);
        handleFiles(files);
    });
    
    // Process files (from drag & drop or browse)
    function handleFiles(files) {
        const fileArray = Array.from(files);
        let validFiles = [];
        let errors = [];
        
        // Validate each file
        fileArray.forEach(file => {
            const validation = validateFile(file);
            if (validation.valid) {
                validFiles.push(file);
            } else {
                errors.push(validation.message);
            }
        });
        
        // Show validation errors
        if (errors.length > 0) {
            showAlert('error', errors.join('<br>'));
        }
        
        // Add valid files to selection (replace previous selection)
        if (validFiles.length > 0) {
            selectedFiles = validFiles;
            updateFileInputAndPreviews();
            
            const message = validFiles.length === 1 
                ? '1 image selected for upload' 
                : `${validFiles.length} images selected for upload`;
            console.log(message);
        }
    }
    
    // Handle remove button click for image previews
    $(document).on('click', '.remove-btn', function(e) {
        e.preventDefault();
        e.stopPropagation();
        
        const index = parseInt($(this).data('index'));
        console.log('Removing image at index:', index);
        
        // Remove file from selectedFiles array
        selectedFiles.splice(index, 1);
        
        // Update previews and file input
        updateFileInputAndPreviews();
        
        const message = selectedFiles.length === 0 
            ? 'All images removed' 
            : `Image removed. ${selectedFiles.length} images remaining`;
        console.log(message);
    });
    
    // IMAGE DELETION FUNCTIONALITY (existing code)
    // Handle delete button click with event delegation
    $(document).on('click', '.delete-image-btn', function(e) {
        e.preventDefault();
        e.stopPropagation();
        
        console.log('Delete button clicked!');
        
        const $btn = $(this);
        const imageType = $btn.data('image-type');
        const carId = $btn.data('car-id');
        const imageName = $btn.data('image-name');
        const imageId = $btn.data('image-id');
        const imageElement = $btn.closest('.current-image-item');
        
        console.log('Delete button data:', {
            imageType: imageType,
            carId: carId,
            imageName: imageName,
            imageId: imageId
        });
        
        // Validate required data
        if (!carId || !imageType || !imageName) {
            console.error('Missing required data for image deletion');
            showAlert('error', 'Missing required data. Please refresh the page and try again.');
            return;
        }
        
        // Store current image data
        currentImageData = {
            type: imageType,
            carId: carId,
            imageName: imageName,
            imageId: imageId,
            element: imageElement
        };
        
        // Set preview image in modal
        const imgSrc = $btn.siblings('img').attr('src');
        $('#deletePreviewImage').attr('src', imgSrc);
        
        // Show confirmation modal
        $('#deleteImageModal').modal('show');
    });
    
    // Handle Cancel button and close button
    $(document).on('click', '[data-dismiss="modal"], .modal .close', function(e) {
        console.log('Modal close button clicked');
        $('#deleteImageModal').modal('hide');
    });
    
    // Handle confirm delete
    $('#confirmDeleteBtn').on('click', function(e) {
        e.preventDefault();
        
        const data = currentImageData;
        const $btn = $(this);
        
        console.log('Confirming delete for:', data);
        
        // Validate data again
        if (!data.carId || !data.type || !data.imageName) {
            console.error('Invalid image data:', data);
            showAlert('error', 'Invalid image data. Please refresh the page and try again.');
            $('#deleteImageModal').modal('hide');
            return;
        }
        
        // Show loading state
        $btn.html('<span class="spinner-border spinner-border-sm" role="status"></span> Deleting...');
        $btn.prop('disabled', true);
        
        // Get CSRF token - try multiple methods
        let csrfToken = $('meta[name="csrf-token"]').attr('content');
        if (!csrfToken) {
            csrfToken = $('input[name="_token"]').val();
        }
        if (!csrfToken) {
            csrfToken = $('[name="csrf-token"]').attr('content');
        }
        
        if (!csrfToken) {
            console.error('CSRF token not found');
            showAlert('error', 'Security token not found. Please refresh the page.');
            $btn.html('Delete Image').prop('disabled', false);
            return;
        }
        
        console.log('CSRF Token found:', csrfToken.substring(0, 10) + '...');
        
        // Prepare request data
        const requestData = {
            _token: csrfToken,
            car_id: parseInt(data.carId),
            image_type: data.type,
            image_name: data.imageName
        };
        
        // Add image_id for additional images
        if (data.type === 'additional' && data.imageId) {
            requestData.image_id = parseInt(data.imageId);
        }
        
        console.log('Sending request with data:', requestData);
        
        // Make AJAX request to delete image
        $.ajax({
            url: '/admin/cars/delete-image', // Update this to match your actual route
            type: 'POST',
            headers: {
                'X-CSRF-TOKEN': csrfToken,
                'Accept': 'application/json',
                'Content-Type': 'application/json'
            },
            data: JSON.stringify(requestData),
            dataType: 'json',
            timeout: 30000,
            success: function(response) {
                console.log('Delete response received:', response);
                
                if (response && response.success) {
                    // Remove the image element from DOM
                    data.element.fadeOut(300, function() {
                        $(this).remove();
                        
                        // Check if no images left and update display
                        setTimeout(function() {
                            if ($('.current-image-item').length === 0) {
                                $('.current-images').html('<p class="text-muted">No images uploaded yet.</p>');
                            }
                        }, 350);
                    });
                    
                    // Close modal
                    $('#deleteImageModal').modal('hide');
                    
                    // Show success message
                    showAlert('success', response.message || 'Image deleted successfully!');
                } else {
                    console.error('Delete operation failed:', response);
                    const errorMsg = response && response.message ? response.message : 'Failed to delete image - unknown error';
                    showAlert('error', errorMsg);
                }
            },
            error: function(xhr, status, error) {
                console.error('AJAX Error Details:', {
                    status: xhr.status,
                    statusText: xhr.statusText,
                    responseText: xhr.responseText,
                    error: error,
                    readyState: xhr.readyState
                });
                
                let errorMessage = 'An error occurred while deleting the image';
                
                // Try to parse error response
                try {
                    const response = JSON.parse(xhr.responseText);
                    if (response && response.message) {
                        errorMessage = response.message;
                    }
                } catch (parseError) {
                    console.log('Could not parse error response as JSON');
                    
                    // Handle different HTTP status codes
                    switch (xhr.status) {
                        case 0:
                            errorMessage = 'Network error - please check your connection';
                            break;
                        case 404:
                            errorMessage = 'Delete endpoint not found - please check the route configuration';
                            break;
                        case 419:
                            errorMessage = 'Session expired - please refresh the page and try again';
                            break;
                        case 422:
                            errorMessage = 'Validation error - invalid data sent to server';
                            break;
                        case 500:
                            errorMessage = 'Server error - please try again or contact support';
                            break;
                        default:
                            errorMessage = `Server returned error ${xhr.status}: ${xhr.statusText}`;
                    }
                }
                
                showAlert('error', errorMessage);
            },
            complete: function() {
                // Reset button state
                $btn.html('Delete Image').prop('disabled', false);
            }
        });
    });
    
    // Reset modal when closed
    $('#deleteImageModal').on('hidden.bs.modal', function() {
        console.log('Modal closed, resetting data');
        currentImageData = {};
        $('#deletePreviewImage').attr('src', '');
        $('#confirmDeleteBtn').html('Delete Image').prop('disabled', false);
    });
    
    // Debug: Log when page loads
    console.log('Available data attributes on delete buttons:');
    $('.delete-image-btn').each(function(index) {
        console.log(`Button ${index + 1}:`, {
            'data-image-type': $(this).data('image-type'),
            'data-car-id': $(this).data('car-id'),
            'data-image-name': $(this).data('image-name'),
            'data-image-id': $(this).data('image-id')
        });
    });
});
</script>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\Sangay Ngedup\Documents\GitHub\FinalProject\resources\views/admin/car-edit.blade.php ENDPATH**/ ?>