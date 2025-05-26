

<?php $__env->startSection('title', 'Cars Management'); ?>

<?php $__env->startSection('breadcrumbs'); ?>
    <li class="breadcrumb-item active">Cars Management</li>
<?php $__env->stopSection(); ?>

<?php $__env->startPush('styles'); ?>
    <link rel="stylesheet" href="<?php echo e(asset('assets/css/admin/cars.css')); ?>">
<?php $__env->stopPush(); ?>

<?php $__env->startSection('content'); ?>
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

<!-- Cars Management Content -->
<div id="cars-management">
    <div class="section-header">
        <h1>Cars Management</h1>
        <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#addCarModal">
            <i class="fas fa-plus"></i> Add New Car
        </button>
    </div>

    <!-- Cars Listing Table -->
    <div class="data-table-container">
        <div class="table-header">
            <div class="table-filters">
                <div class="filter-item">
                    <label for="status-filter">Status:</label>
                    <select id="status-filter" class="form-control">
                        <option value="">All Statuses</option>
                        <option value="available">Available</option>
                        <option value="booked">Booked</option>
                        <option value="maintenance">Maintenance</option>
                        <option value="inactive">Inactive</option>
                    </select>
                </div>
                <div class="filter-item">
                    <label for="brand-filter">Brand:</label>
                    <select id="brand-filter" class="form-control">
                        <option value="">All Brands</option>
                        <?php
                            $makers = DB::table('admin_cars_tbl')
                                ->select('maker')
                                ->distinct()
                                ->orderBy('maker')
                                ->get();
                        ?>
                        <?php $__currentLoopData = $makers; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $maker): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <option value="<?php echo e($maker->maker); ?>"><?php echo e($maker->maker); ?></option>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </select>
                </div>
            </div>
            <div class="table-search">
                <input type="text" id="car-search" class="form-control" placeholder="Search cars...">
                <button class="search-btn"><i class="fas fa-search"></i></button>
            </div>
        </div>

       <table class="data-table">
            <table class="data-table">
            <thead>
                <tr>
                    <th>Image</th>
                    <th>Car Name</th>
                    <th>Brand</th>
                    <th>Model</th>
                    <th>Registration No.</th>
                    <th>Daily Rate</th>
                    <th>Status</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $cars = DB::table('admin_cars_tbl')
                    ->orderBy('id', 'desc')
                    ->paginate(10);
                ?>
                <?php if($cars->count() > 0): ?>
                <?php $__currentLoopData = $cars; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $car): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <?php
                // Determine the status badge class
                $statusClass = '';
                switch (strtolower($car->status)) {
                    case 'available':
                        $statusClass = 'available';
                        break;
                    case 'booked':
                        $statusClass = 'booked';
                        break;
                    case 'maintenance':
                        $statusClass = 'maintenance';
                        break;
                    case 'inactive':
                        $statusClass = 'inactive';
                        break;
                    default:
                        $statusClass = '';
                }

                // Car display name (combine maker and model)
                $carName = $car->maker . ' ' . $car->model;

                // Image path handling with fallback
                $imagePath = asset('admincar_images/' . $car->car_image); // Assuming 'admincar_images' is a directory in your public folder
                if (!file_exists(public_path('admincar_images/' . $car->car_image))) {
                    $imagePath = asset('assets/images/cars/default-car.jpg'); // Fallback image path
                }
                ?>
                <tr>
  
                    <td><img src="<?php echo e($imagePath); ?>" alt="<?php echo e($carName); ?>" class="car-thumbnail"></td>
                    <td><?php echo e($carName); ?></td>
                    <td><?php echo e($car->maker); ?></td>
                    <td><?php echo e($car->model); ?></td>
                    <td><?php echo e($car->registration_no); ?></td>
                    <td>$<?php echo e($car->price); ?>/day</td>
                    <td><span class="status-badge <?php echo e($statusClass); ?>"><?php echo e($car->status); ?></span></td>
                    <td class="actions">
                        <a href="<?php echo e(route('cars.show', $car->id)); ?>" class="action-btn view" title="View Details">
                            <i class="fas fa-eye"></i>
                        </a>
                        <a href="<?php echo e(route('cars.edit', $car->id)); ?>" class="action-btn edit" title="Edit Car">
                            <i class="fas fa-edit"></i>
                        </a>
                        <button class="action-btn delete" title="Delete Car" data-id="<?php echo e($car->id); ?>" data-name="<?php echo e($carName); ?>">
                            <i class="fas fa-trash"></i>
                        </button>
                    </td>
                </tr>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                <?php else: ?>
                <tr>
                    <td colspan="9" class="text-center">No cars found</td>
                </tr>
                <?php endif; ?>
            </tbody>
        </table>



        <div class="pagination-container">
            <div class="showing-entries">
                Showing <?php echo e($cars->firstItem() ?? 0); ?> to <?php echo e($cars->lastItem() ?? 0); ?> of <?php echo e($cars->total()); ?> entries
            </div>
            <div class="pagination">
                <?php echo e($cars->links()); ?>

            </div>
        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>
<!-- Add Car Modal -->
<div class="modal fade" id="addCarModal" tabindex="-1" role="dialog" aria-labelledby="addCarModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="addCarModalLabel">Add New Car</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form id="addCarForm" action="<?php echo e(route('cars.store')); ?>" method="POST" enctype="multipart/form-data">
                    <?php echo csrf_field(); ?>
                    <div class="form-row">
                        <div class="form-group col-md-6">
                            <label for="maker">Maker <span class="required">*</span></label>
                            <input type="text" class="form-control" id="maker" name="maker" value="<?php echo e(old('maker')); ?>" required>
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
                            <input type="text" class="form-control" id="model" name="model" value="<?php echo e(old('model')); ?>" required>
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
                        </div>
                        <div class="form-group col-md-6">
                            <label for="car_condition">Condition <span class="required">*</span></label>
                            <select id="car_condition" name="car_condition" class="form-control" required>
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
                        </div>
                    </div>
                    
                    <div class="form-row">
                        <div class="form-group col-md-6">
                            <label for="mileage">Mileage (in km) <span class="required">*</span></label>
                            <input type="number" class="form-control" id="mileage" name="mileage" value="<?php echo e(old('mileage')); ?>" required>
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
                            <input type="number" class="form-control" id="price" name="price" value="<?php echo e(old('price')); ?>" required>
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
                            <input type="text" class="form-control" id="registration_no" name="registration_no" value="<?php echo e(old('registration_no')); ?>" required>
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
                        </div>
                    </div>
                    
                    <h4 class="mt-4 mb-3">Car Features</h4>
                    
                    <div class="form-row">
                        <div class="form-group col-md-6">
                            <label for="number_of_doors">Number of Doors <span class="required">*</span></label>
                            <input type="number" class="form-control" id="number_of_doors" name="number_of_doors" value="<?php echo e(old('number_of_doors')); ?>" required>
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
                            <input type="number" class="form-control" id="number_of_seats" name="number_of_seats" value="<?php echo e(old('number_of_seats')); ?>" required>
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
                        </div>
                        <div class="form-group col-md-6">
                            <label for="fuel_type">Fuel Type <span class="required">*</span></label>
                            <select id="fuel_type" name="fuel_type" class="form-control" required>
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
                        </div>
                    </div>
                    
                    <div class="form-row">
                        <div class="form-group col-md-6">
                            <label for="large_bags_capacity">Large Bags Capacity</label>
                            <input type="number" class="form-control" id="large_bags_capacity" name="large_bags_capacity" value="<?php echo e(old('large_bags_capacity')); ?>">
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
                            <input type="number" class="form-control" id="small_bags_capacity" name="small_bags_capacity" value="<?php echo e(old('small_bags_capacity')); ?>">
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
                                        class="custom-control-input" <?php echo e(old('air_conditioning') == 'Yes' ? 'checked' : ''); ?>>
                                    <label class="custom-control-label" for="air_conditioning_yes">Yes</label>
                                </div>
                                <div class="custom-control custom-radio">
                                    <input type="radio" id="air_conditioning_no" name="air_conditioning" value="No" 
                                        class="custom-control-input" <?php echo e(old('air_conditioning') == 'No' ? 'checked' : ''); ?>>
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
                                        class="custom-control-input" <?php echo e(old('backup_camera') == 'Yes' ? 'checked' : ''); ?>>
                                    <label class="custom-control-label" for="backup_camera_yes">Yes</label>
                                </div>
                                <div class="custom-control custom-radio">
                                    <input type="radio" id="backup_camera_no" name="backup_camera" value="No" 
                                        class="custom-control-input" <?php echo e(old('backup_camera') == 'No' ? 'checked' : ''); ?>>
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
                                        class="custom-control-input" <?php echo e(old('bluetooth') == 'Yes' ? 'checked' : ''); ?>>
                                    <label class="custom-control-label" for="bluetooth_yes">Yes</label>
                                </div>
                                <div class="custom-control custom-radio">
                                    <input type="radio" id="bluetooth_no" name="bluetooth" value="No" 
                                        class="custom-control-input" <?php echo e(old('bluetooth') == 'No' ? 'checked' : ''); ?>>
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
                        <textarea class="form-control" id="description" name="description" rows="3"><?php echo e(old('description')); ?></textarea>
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
                    
                    <div class="form-group">
                        <label>Car Images</label>
                        <div class="file-upload-container" id="dropZone">
                            <h5 class="text-center mb-2">Drop car images here</h5>
                            <p class="text-center mb-2">or</p>
                            <div class="text-center mb-2">
                                <label for="car_images" class="btn btn-outline-primary">Browse Files</label>
                                <input type="file" name="car_images[]" id="car_images" class="d-none" multiple accept="image/*">
                            </div>
                            <p class="text-center small text-muted">Supported formats: JPEG, PNG, JPG, WEBP, GIF, AVIF (max 2MB each)</p>
                            
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
                    
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary">Add Car</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- Delete Confirmation Modal -->
<div class="modal fade" id="deleteConfirmModal" tabindex="-1" role="dialog" aria-labelledby="deleteConfirmModalLabel" aria-hidden="true" data-backdrop="static" data-keyboard="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="deleteConfirmModalLabel">
                    <i class="fas fa-exclamation-triangle text-warning mr-2"></i>
                    Confirm Delete
                </h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="text-center mb-3">
                    <i class="fas fa-car text-danger" style="font-size: 3rem;"></i>
                </div>
                <p class="text-center">Are you sure you want to delete <strong id="deleteCarName"></strong>?</p>
                <p class="text-danger text-center mb-0">
                    <small><i class="fas fa-warning mr-1"></i>This action cannot be undone.</small>
                </p>
            </div>
            <div class="modal-footer justify-content-center">
                <button type="button" class="btn btn-secondary mr-2" data-dismiss="modal">
                    <i class="fas fa-times mr-1"></i>Cancel
                </button>
                <form id="deleteCarForm" method="POST" style="display: inline;">
                    <?php echo csrf_field(); ?>
                    <?php echo method_field('DELETE'); ?>
                    <button type="submit" class="btn btn-danger">
                        <i class="fas fa-trash mr-1"></i>Delete
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>


<?php $__env->startPush('scripts'); ?>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.0/dist/js/bootstrap.bundle.min.js"></script>
<script>
    $(document).ready(function() {
        // Show/hide "Other" brand input field
        $('#brand').change(function() {
            if ($(this).val() === 'other') {
                $('#other_brand_label, #other_brand').show();
                $('#other_brand').prop('required', true);
            } else {
                $('#other_brand_label, #other_brand').hide();
                $('#other_brand').prop('required', false);
            }
        });

        // Handle file input change for image preview
        $('#car_image').change(function(e) {
            $('#imagePreview').empty();
            const files = e.target.files;
            
            if (files.length > 0) {
                $('.custom-file-label').text(files.length + ' files selected');
                
                for (let i = 0; i < files.length; i++) {
                    const file = files[i];
                    const reader = new FileReader();
                    
                    reader.onload = function(e) {
                        const preview = `
                            <div class="image-preview-item">
                                <img src="${e.target.result}" alt="Preview">
                                <span class="image-preview-name">${file.name}</span>
                            </div>
                        `;
                        $('#imagePreview').append(preview);
                    }
                    
                    reader.readAsDataURL(file);
                }
            } else {
                $('.custom-file-label').text('Choose files');
            }
        });

        // Handle "View" button click
        $('.action-btn.view').click(function() {
            const carId = $(this).closest('tr').find('td:first').text();
            // Here you would fetch car details via AJAX and populate the view modal
            $('#viewCarModal').modal('show');
        });

        // Handle "Edit" button click
        $('.action-btn.edit').click(function() {
            const carId = $(this).data('id');
            $('#edit_car_id').val(carId);
            // Here you would fetch car details via AJAX and populate the edit form
        });

        // Handle "Delete" button click
        $('.action-btn.delete').click(function() {
            const carId = $(this).data('id');
            const carName = $(this).data('name');
            
            // Set the car name in the modal
            $('#deleteCarName').text(carName);
            
            // Set the form action URL with the car ID
            $('#deleteCarForm').attr('action', '/admin/cars?id=' + carId);
            
            // Show the modal
            $('#deleteConfirmModal').modal('show');
        });

        // Handle modal close buttons
        $('#deleteConfirmModal .close, #deleteConfirmModal [data-dismiss="modal"]').click(function() {
            $('#deleteConfirmModal').modal('hide');
        });

        // Handle modal backdrop click
        $('#deleteConfirmModal').on('click', function(e) {
            if (e.target === this) {
                $(this).modal('hide');
            }
        });

        // Handle ESC key press
        $(document).keyup(function(e) {
            if (e.keyCode === 27) { // ESC key
                $('#deleteConfirmModal').modal('hide');
            }
        });

        // Filter functionality
        $('#status-filter, #brand-filter').change(function() {
            filterTable();
        });

        // Search functionality
        $('#car-search').on('input', function() {
            filterTable();
        });

        function filterTable() {
            const statusFilter = $('#status-filter').val().toLowerCase();
            const brandFilter = $('#brand-filter').val().toLowerCase();
            const searchText = $('#car-search').val().toLowerCase();

            $('table tbody tr').each(function() {
                const statusText = $(this).find('td:nth-child(8) .status-badge').text().toLowerCase();
                const brandText = $(this).find('td:nth-child(4)').text().toLowerCase();
                const rowText = $(this).text().toLowerCase();

                const statusMatch = statusFilter === '' || statusText.includes(statusFilter);
                const brandMatch = brandFilter === '' || brandText === brandFilter;
                const searchMatch = searchText === '' || rowText.includes(searchText);

                if (statusMatch && brandMatch && searchMatch) {
                    $(this).show();
                } else {
                    $(this).hide();
                }
            });
        }

        // Auto dismiss alerts after 5 seconds
        setTimeout(function() {
            $('.alert').each(function() {
                $(this).addClass('fade-out');
                var alert = $(this);
                setTimeout(function() {
                    alert.alert('close');
                }, 500);
            });
        }, 5000);
    });

    // Drag and drop functionality (separate from jQuery ready)
    document.addEventListener('DOMContentLoaded', function() {
        const dropZone = document.getElementById('dropZone');
        const fileInput = document.getElementById('car_images');
        const previewContainer = document.getElementById('selectedFiles');
        const form = document.getElementById('addCarForm'); // Changed from 'carForm' to 'addCarForm'
        
        // Only proceed if elements exist
        if (!dropZone || !fileInput || !previewContainer) {
            return;
        }
        
        // Track selected files
        let selectedFiles = new DataTransfer();
        
        // Prevent default drag behaviors
        ['dragenter', 'dragover', 'dragleave', 'drop'].forEach(eventName => {
            dropZone.addEventListener(eventName, preventDefaults, false);
            document.body.addEventListener(eventName, preventDefaults, false);
        });
        
        // Highlight drop zone when dragging over it
        ['dragenter', 'dragover'].forEach(eventName => {
            dropZone.addEventListener(eventName, highlight, false);
        });
        
        ['dragleave', 'drop'].forEach(eventName => {
            dropZone.addEventListener(eventName, unhighlight, false);
        });
        
        // Handle dropped files
        dropZone.addEventListener('drop', handleDrop, false);
        
        // Handle files from file input
        fileInput.addEventListener('change', function(e) {
            handleFiles(this.files);
        });
        
        function preventDefaults(e) {
            e.preventDefault();
            e.stopPropagation();
        }
        
        function highlight() {
            dropZone.classList.add('active');
        }
        
        function unhighlight() {
            dropZone.classList.remove('active');
        }
        
        function handleDrop(e) {
            const dt = e.dataTransfer;
            const files = dt.files;
            handleFiles(files);
        }
        
        function handleFiles(files) {
            if (files.length > 0) {
                // Process each file
                Array.from(files).forEach(file => {
                    if (file.type.startsWith('image/')) {
                        // Add to DataTransfer object
                        selectedFiles.items.add(file);
                        
                        // Create preview
                        createImagePreview(file);
                    }
                });
                
                // Update file input with selected files
                updateFileInput();
            }
        }
        
        function createImagePreview(file) {
            const reader = new FileReader();
            
            reader.onload = function(e) {
                const preview = document.createElement('div');
                preview.className = 'image-preview';
                preview.dataset.name = file.name;
                
                const img = document.createElement('img');
                img.src = e.target.result;
                
                const removeBtn = document.createElement('button');
                removeBtn.className = 'remove-btn';
                removeBtn.innerHTML = '×';
                removeBtn.type = 'button'; // Prevent form submission
                removeBtn.addEventListener('click', function() {
                    removeFile(file.name);
                    preview.remove();
                });
                
                preview.appendChild(img);
                preview.appendChild(removeBtn);
                previewContainer.appendChild(preview);
            };
            
            reader.readAsDataURL(file);
        }
        
        function removeFile(fileName) {
            // Create a new DataTransfer object
            const newFiles = new DataTransfer();
            
            // Copy all files except the one to be removed
            for (let i = 0; i < selectedFiles.files.length; i++) {
                const file = selectedFiles.files[i];
                if (file.name !== fileName) {
                    newFiles.items.add(file);
                }
            }
            
            // Replace old DataTransfer with new one
            selectedFiles = newFiles;
            updateFileInput();
        }
        
        function updateFileInput() {
            // Update the file input with current selections
            fileInput.files = selectedFiles.files;
        }
        
        // Submit the form with the updated file input
        if (form) {
            form.addEventListener('submit', function(e) {
                // The file input is already updated, so just let the form submit
            });
        }
    });
</script>
<?php $__env->stopPush(); ?>
<?php echo $__env->make('layouts.admin', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\Thinley Norbu\Documents\GitHub\FinalProject\resources\views/admin/cars.blade.php ENDPATH**/ ?>