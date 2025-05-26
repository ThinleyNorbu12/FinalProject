

<?php $__env->startSection('title', 'Edit Car'); ?>
<meta name="csrf-token" content="<?php echo e(csrf_token()); ?>">
<?php $__env->startSection('breadcrumbs'); ?>
    <li class="breadcrumb-item">
        <a href="<?php echo e(route('admin.cars.index')); ?>">Cars Management</a>
    </li>
    <li class="breadcrumb-item active">Edit Car</li>
<?php $__env->stopSection(); ?>

<?php $__env->startPush('styles'); ?>
    <link rel="stylesheet" href="<?php echo e(asset('assets/css/admin/editcar.css')); ?>">
<?php $__env->stopPush(); ?>

<?php $__env->startSection('content'); ?>
<div class="container-fluid">
    <!-- Notification Container -->
    <div class="notification-container mb-4">
        <!-- Notifications will be inserted here via JavaScript -->
    </div>

    <!-- Edit Car Form -->
    <div class="card">
        <div class="card-header">
            <h2><i class="fas fa-edit me-2"></i>Edit Car</h2>
        </div>
        <div class="card-body">
            <form action="<?php echo e(route('cars.update', $car->id)); ?>" method="POST" enctype="multipart/form-data">
                <?php echo csrf_field(); ?>
                <?php echo method_field('PUT'); ?>
                
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label for="maker" class="form-label">Maker <span class="required">*</span></label>
                        <input type="text" class="form-control" id="maker" name="maker" value="<?php echo e(old('maker', $car->maker)); ?>" required>
                        <?php $__errorArgs = ['maker'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                            <div class="text-danger small mt-1"><?php echo e($message); ?></div>
                        <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label for="model" class="form-label">Model <span class="required">*</span></label>
                        <input type="text" class="form-control" id="model" name="model" value="<?php echo e(old('model', $car->model)); ?>" required>
                        <?php $__errorArgs = ['model'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                            <div class="text-danger small mt-1"><?php echo e($message); ?></div>
                        <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                    </div>
                </div>
                
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label for="vehicle_type" class="form-label">Vehicle Type <span class="required">*</span></label>
                        <select id="vehicle_type" name="vehicle_type" class="form-select" required>
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
                            <div class="text-danger small mt-1"><?php echo e($message); ?></div>
                        <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label for="car_condition" class="form-label">Condition <span class="required">*</span></label>
                        <select id="car_condition" name="car_condition" class="form-select" required>
                            <option value="">Select condition</option>
                            <option value="New" <?php echo e(old('car_condition', $car->car_condition) == 'New' ? 'selected' : ''); ?>>New</option>
                            <option value="Used" <?php echo e(old('car_condition', $car->car_condition) == 'Used' ? 'selected' : ''); ?>>Used</option>
                        </select>
                        <?php $__errorArgs = ['car_condition'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                            <div class="text-danger small mt-1"><?php echo e($message); ?></div>
                        <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                    </div>
                </div>
                
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label for="mileage" class="form-label">Mileage (in km) <span class="required">*</span></label>
                        <input type="number" class="form-control" id="mileage" name="mileage" value="<?php echo e(old('mileage', $car->mileage)); ?>" required>
                        <?php $__errorArgs = ['mileage'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                            <div class="text-danger small mt-1"><?php echo e($message); ?></div>
                        <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label for="price" class="form-label">Price per Day <span class="required">*</span></label>
                        <input type="number" class="form-control" id="price" name="price" value="<?php echo e(old('price', $car->price)); ?>" required>
                        <?php $__errorArgs = ['price'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                            <div class="text-danger small mt-1"><?php echo e($message); ?></div>
                        <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                    </div>
                </div>
                
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label for="registration_no" class="form-label">Registration Number <span class="required">*</span></label>
                        <input type="text" class="form-control" id="registration_no" name="registration_no" value="<?php echo e(old('registration_no', $car->registration_no)); ?>" required>
                        <?php $__errorArgs = ['registration_no'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                            <div class="text-danger small mt-1"><?php echo e($message); ?></div>
                        <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label for="status" class="form-label">Status <span class="required">*</span></label>
                        <select id="status" name="status" class="form-select" required>
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
                            <div class="text-danger small mt-1"><?php echo e($message); ?></div>
                        <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                    </div>
                </div>
                
                <hr class="my-4">
                <h4 class="mb-3"><i class="fas fa-cogs me-2"></i>Car Features</h4>
                
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label for="number_of_doors" class="form-label">Number of Doors <span class="required">*</span></label>
                        <input type="number" class="form-control" id="number_of_doors" name="number_of_doors" value="<?php echo e(old('number_of_doors', $car->number_of_doors)); ?>" required>
                        <?php $__errorArgs = ['number_of_doors'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                            <div class="text-danger small mt-1"><?php echo e($message); ?></div>
                        <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label for="number_of_seats" class="form-label">Number of Seats <span class="required">*</span></label>
                        <input type="number" class="form-control" id="number_of_seats" name="number_of_seats" value="<?php echo e(old('number_of_seats', $car->number_of_seats)); ?>" required>
                        <?php $__errorArgs = ['number_of_seats'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                            <div class="text-danger small mt-1"><?php echo e($message); ?></div>
                        <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                    </div>
                </div>
                
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label for="transmission_type" class="form-label">Transmission Type <span class="required">*</span></label>
                        <select id="transmission_type" name="transmission_type" class="form-select" required>
                            <option value="">Select transmission</option>
                            <option value="Automatic" <?php echo e(old('transmission_type', $car->transmission_type) == 'Automatic' ? 'selected' : ''); ?>>Automatic</option>
                            <option value="Manual" <?php echo e(old('transmission_type', $car->transmission_type) == 'Manual' ? 'selected' : ''); ?>>Manual</option>
                        </select>
                        <?php $__errorArgs = ['transmission_type'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                            <div class="text-danger small mt-1"><?php echo e($message); ?></div>
                        <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label for="fuel_type" class="form-label">Fuel Type <span class="required">*</span></label>
                        <select id="fuel_type" name="fuel_type" class="form-select" required>
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
                            <div class="text-danger small mt-1"><?php echo e($message); ?></div>
                        <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                    </div>
                </div>
                
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label for="large_bags_capacity" class="form-label">Large Bags Capacity</label>
                        <input type="number" class="form-control" id="large_bags_capacity" name="large_bags_capacity" value="<?php echo e(old('large_bags_capacity', $car->large_bags_capacity)); ?>">
                        <?php $__errorArgs = ['large_bags_capacity'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                            <div class="text-danger small mt-1"><?php echo e($message); ?></div>
                        <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label for="small_bags_capacity" class="form-label">Small Bags Capacity</label>
                        <input type="number" class="form-control" id="small_bags_capacity" name="small_bags_capacity" value="<?php echo e(old('small_bags_capacity', $car->small_bags_capacity)); ?>">
                        <?php $__errorArgs = ['small_bags_capacity'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                            <div class="text-danger small mt-1"><?php echo e($message); ?></div>
                        <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                    </div>
                </div>
                
                <div class="row">
                    <div class="col-md-4 mb-3">
                        <label class="form-label">Air Conditioning</label>
                        <div class="d-flex gap-3">
                            <div class="form-check">
                                <input type="radio" id="air_conditioning_yes" name="air_conditioning" value="Yes" 
                                    class="form-check-input" <?php echo e(old('air_conditioning', $car->air_conditioning) == 'Yes' ? 'checked' : ''); ?>>
                                <label class="form-check-label" for="air_conditioning_yes">Yes</label>
                            </div>
                            <div class="form-check">
                                <input type="radio" id="air_conditioning_no" name="air_conditioning" value="No" 
                                    class="form-check-input" <?php echo e(old('air_conditioning', $car->air_conditioning) == 'No' ? 'checked' : ''); ?>>
                                <label class="form-check-label" for="air_conditioning_no">No</label>
                            </div>
                        </div>
                        <?php $__errorArgs = ['air_conditioning'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                            <div class="text-danger small mt-1"><?php echo e($message); ?></div>
                        <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                    </div>
                    <div class="col-md-4 mb-3">
                        <label class="form-label">Backup Camera</label>
                        <div class="d-flex gap-3">
                            <div class="form-check">
                                <input type="radio" id="backup_camera_yes" name="backup_camera" value="Yes" 
                                    class="form-check-input" <?php echo e(old('backup_camera', $car->backup_camera) == 'Yes' ? 'checked' : ''); ?>>
                                <label class="form-check-label" for="backup_camera_yes">Yes</label>
                            </div>
                            <div class="form-check">
                                <input type="radio" id="backup_camera_no" name="backup_camera" value="No" 
                                    class="form-check-input" <?php echo e(old('backup_camera', $car->backup_camera) == 'No' ? 'checked' : ''); ?>>
                                <label class="form-check-label" for="backup_camera_no">No</label>
                            </div>
                        </div>
                        <?php $__errorArgs = ['backup_camera'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                            <div class="text-danger small mt-1"><?php echo e($message); ?></div>
                        <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                    </div>
                    <div class="col-md-4 mb-3">
                        <label class="form-label">Bluetooth</label>
                        <div class="d-flex gap-3">
                            <div class="form-check">
                                <input type="radio" id="bluetooth_yes" name="bluetooth" value="Yes" 
                                    class="form-check-input" <?php echo e(old('bluetooth', $car->bluetooth) == 'Yes' ? 'checked' : ''); ?>>
                                <label class="form-check-label" for="bluetooth_yes">Yes</label>
                            </div>
                            <div class="form-check">
                                <input type="radio" id="bluetooth_no" name="bluetooth" value="No" 
                                    class="form-check-input" <?php echo e(old('bluetooth', $car->bluetooth) == 'No' ? 'checked' : ''); ?>>
                                <label class="form-check-label" for="bluetooth_no">No</label>
                            </div>
                        </div>
                        <?php $__errorArgs = ['bluetooth'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                            <div class="text-danger small mt-1"><?php echo e($message); ?></div>
                        <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                    </div>
                </div>
                
                <div class="mb-3">
                    <label for="description" class="form-label">Description</label>
                    <textarea class="form-control" id="description" name="description" rows="3"><?php echo e(old('description', $car->description)); ?></textarea>
                    <?php $__errorArgs = ['description'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                        <div class="text-danger small mt-1"><?php echo e($message); ?></div>
                    <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                </div>
                
                <hr class="my-4">
                
                <!-- Current Images Display -->
                <div class="mb-4">
                    <label class="form-label"><i class="fas fa-images me-2"></i>Current Images</label>
                    <div class="current-images">
                        <?php if($car->car_image): ?>
                            <!-- Primary Image -->
                            <div class="current-image-item" data-image-type="primary">
                                <img src="<?php echo e(asset('admincar_images/' . $car->car_image)); ?>"
                                    alt="Primary Car Image"
                                    class="img-thumbnail">
                                <span class="badge bg-primary">Primary</span>
                                
                                <button type="button" 
                                        class="delete-image-btn" 
                                        data-image-type="primary"
                                        data-car-id="<?php echo e($car->id); ?>"
                                        data-image-name="<?php echo e($car->car_image); ?>"
                                        title="Delete Image">
                                    <i class="fas fa-times"></i>
                                </button>
                            </div>
                        <?php endif; ?>
                        
                        <?php if(isset($car->carImages) && $car->carImages->count() > 0): ?>
                            <!-- Additional Images -->
                            <?php $__currentLoopData = $car->carImages; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $index => $carImage): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <?php if(!empty(trim($carImage->image_path))): ?>
                                    <div class="current-image-item" data-image-id="<?php echo e($carImage->id); ?>">
                                        <img src="<?php echo e(asset('admincar_images/' . $carImage->image_path)); ?>"
                                            alt="Car Image <?php echo e($index + 2); ?>"
                                            class="img-thumbnail">
                                        <span class="badge bg-secondary"><?php echo e($index + 2); ?></span>
                                        
                                        <button type="button" 
                                                class="delete-image-btn" 
                                                data-image-type="additional"
                                                data-image-id="<?php echo e($carImage->id); ?>"
                                                data-car-id="<?php echo e($car->id); ?>"
                                                data-image-name="<?php echo e($carImage->image_path); ?>"
                                                title="Delete Image">
                                            <i class="fas fa-times"></i>
                                        </button>
                                    </div>
                                <?php endif; ?>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        <?php endif; ?>
                        
                        <?php if(!$car->car_image && (!isset($car->carImages) || $car->carImages->count() == 0)): ?>
                            <p class="text-muted">No images uploaded yet.</p>
                        <?php endif; ?>
                    </div>
                </div>

                <!-- New Image Upload -->
                <div class="mb-4">
                    <label class="form-label"><i class="fas fa-upload me-2"></i>Update Car Images</label>
                    <div class="file-upload-container" id="dropZone">
                        <i class="fas fa-cloud-upload-alt fa-3x text-muted mb-3"></i>
                        <h5 class="mb-2">Drop new car images here</h5>
                        <p class="text-muted mb-3">or</p>
                        <div class="mb-3">
                            <label for="car_images" class="btn btn-outline-primary">
                                <i class="fas fa-folder-open me-2"></i>Browse Files
                            </label>
                            <input type="file" name="car_images[]" id="car_images" class="d-none" multiple accept="image/*">
                        </div>
                        <p class="small text-muted mb-2">Supported formats: JPEG, PNG, JPG, WEBP, GIF (max 2MB each)</p>
                        <p class="small text-info">Leave empty to keep current images</p>
                        
                        <div id="selectedFiles" class="image-preview-container">
                            <!-- Image previews will be inserted here -->
                        </div>
                    </div>
                    
                    <?php $__errorArgs = ['car_images'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                        <div class="text-danger small mt-1"><?php echo e($message); ?></div>
                    <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                </div>
                
                <div class="d-flex gap-2">
                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-save me-2"></i>Update Car
                    </button>
                    <a href="<?php echo e(route('admin.cars.index')); ?>" class="btn btn-secondary">
                        <i class="fas fa-times me-2"></i>Cancel
                    </a>
                </div>
            </form>
        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>
<!-- Delete Confirmation Modal -->
<div class="modal fade" id="deleteImageModal" tabindex="-1" role="dialog" aria-labelledby="deleteImageModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="deleteImageModalLabel">
                        <i class="fas fa-exclamation-triangle text-warning me-2"></i>Confirm Delete
                    </h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <p class="mb-3">Are you sure you want to delete this image? This action cannot be undone.</p>
                    <div class="text-center">
                        <img id="deletePreviewImage" src="" alt="Image to delete" class="img-thumbnail" style="max-width: 200px; max-height: 150px;">
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">
                        <i class="fas fa-times me-2"></i>Cancel
                    </button>
                    <button type="button" class="btn btn-danger" id="confirmDeleteBtn">
                        <i class="fas fa-trash me-2"></i>Delete Image
                    </button>
                </div>
            </div>
        </div>
</div>
   


<?php $__env->startPush('scripts'); ?>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.6.0/js/bootstrap.bundle.min.js"></script>

<script>
$(document).ready(function() {
     const csrfToken = document.querySelector('meta[name="csrf-token"]')?.getAttribute('content');
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
    
    // Form validation before submission
    $('form').on('submit', function(e) {
        // Basic validation
        const maker = $('#maker').val().trim();
        const model = $('#model').val().trim();
        const vehicleType = $('#vehicle_type').val();
        const carCondition = $('#car_condition').val();
        const mileage = $('#mileage').val();
        const price = $('#price').val();
        const registrationNo = $('#registration_no').val().trim();
        const status = $('#status').val();
        const doors = $('#number_of_doors').val();
        const seats = $('#number_of_seats').val();
        const transmission = $('#transmission_type').val();
        const fuelType = $('#fuel_type').val();
        
        // Check required fields
        if (!maker || !model || !vehicleType || !carCondition || !mileage || 
            !price || !registrationNo || !status || !doors || !seats || 
            !transmission || !fuelType) {
            e.preventDefault();
            showAlert('error', 'Please fill in all required fields.');
            return false;
        }
        
        // Validate numeric fields
        if (isNaN(mileage) || parseFloat(mileage) < 0) {
            e.preventDefault();
            showAlert('error', 'Please enter a valid mileage value.');
            return false;
        }
        
        if (isNaN(price) || parseFloat(price) <= 0) {
            e.preventDefault();
            showAlert('error', 'Please enter a valid price value.');
            return false;
        }
        
        if (isNaN(doors) || parseInt(doors) <= 0) {
            e.preventDefault();
            showAlert('error', 'Please enter a valid number of doors.');
            return false;
        }
        
        if (isNaN(seats) || parseInt(seats) <= 0) {
            e.preventDefault();
            showAlert('error', 'Please enter a valid number of seats.');
            return false;
        }
        
        // Show loading state on submit button
        const $submitBtn = $('button[type="submit"]');
        $submitBtn.html('<span class="spinner-border spinner-border-sm" role="status"></span> Updating...');
        $submitBtn.prop('disabled', true);
        
        console.log('Form validation passed, submitting...');
    });
    
    // Auto-dismiss alerts after 5 seconds
    setTimeout(function() {
        $('.alert').fadeOut();
    }, 5000);
    
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
    
    // Initialize tooltips if Bootstrap is available
    if (typeof $().tooltip === 'function') {
        $('[title]').tooltip();
    }
    console.log('Car edit form JavaScript initialized successfully');
});
</script>
<?php echo $__env->make('layouts.admin', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\Thinley Norbu\Documents\GitHub\FinalProject\resources\views/admin/car-edit.blade.php ENDPATH**/ ?>