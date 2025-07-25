<!-- Link to the external CSS file -->
<link rel="stylesheet" href="<?php echo e(asset('assets/css/cars/book.css')); ?>">
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/pikaday/css/pikaday.css">
<script src="https://cdn.jsdelivr.net/npm/moment/moment.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/pikaday/pikaday.js"></script>




<?php $__env->startSection('content'); ?>
<div class="container py-4">
    <div class="row">
        <div class="col-lg-10 col-md-12 mx-auto">
            <!-- Car Title -->
            <h3 class="text-center mb-3"><?php echo e($car->maker); ?> <?php echo e($car->model); ?></h3>

            <!-- Image Section -->
            <!-- <?php if($car->images && count($car->images)): ?>
                <div class="carousel-container mb-4">
                    <div id="carImageCarousel" class="carousel slide" data-bs-ride="carousel">
                        <div class="carousel-inner">
                            <?php $__currentLoopData = $car->images; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $image): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <div class="carousel-item <?php echo e($key == 0 ? 'active' : ''); ?>">
                                    <img src="<?php echo e(asset($image->image_path)); ?>" class="d-block mx-auto" alt="Car Image">
                                </div>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </div>
                        <button class="carousel-control-prev" type="button" data-bs-target="#carImageCarousel" data-bs-slide="prev">
                            <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                            <span class="visually-hidden">Previous</span>
                        </button>
                        <button class="carousel-control-next" type="button" data-bs-target="#carImageCarousel" data-bs-slide="next">
                            <span class="carousel-control-next-icon" aria-hidden="true"></span>
                            <span class="visually-hidden">Next</span>
                        </button>
                        <div class="carousel-indicators">
                            <?php $__currentLoopData = $car->images; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $image): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <button type="button" data-bs-target="#carImageCarousel" data-bs-slide-to="<?php echo e($key); ?>"
                                    class="<?php echo e($key == 0 ? 'active' : ''); ?>" aria-current="<?php echo e($key == 0 ? 'true' : 'false'); ?>"
                                    aria-label="Slide <?php echo e($key + 1); ?>"></button>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </div>
                    </div>
                </div>
            <?php elseif($car->car_image): ?>
                <div class="mb-4 text-center">
                    <img src="<?php echo e(asset($car->car_image)); ?>" alt="Car Image" style="max-width: 100%; max-height: 300px;" class="img-fluid rounded">
                </div>
            <?php else: ?>
                <div class="alert alert-info mb-4">No image available for this car</div>
            <?php endif; ?> -->

            <!-- Image Section -->
            <!-- Image Section -->
<!-- Image Section -->
            <?php if($car->car_image): ?>
                <div class="mb-4 text-center">
                    <?php
                        // Check if car_image already contains the full path or just filename
                        $isFullPath = str_contains($car->car_image, '/');
                        
                        if ($isFullPath) {
                            // car_image already contains full path like 'uploads/cars/filename.webp'
                            $imagePathUploads = $car->car_image;
                            $imagePathAdmin = str_replace('uploads/cars/', 'admincar_images/', $car->car_image);
                        } else {
                            // car_image contains only filename
                            $imagePathUploads = 'uploads/cars/' . $car->car_image;
                            $imagePathAdmin = 'admincar_images/' . $car->car_image;
                        }
                        
                        // Check if files exist
                        $imageExistsInUploads = file_exists(public_path($imagePathUploads));
                        $imageExistsInAdmin = file_exists(public_path($imagePathAdmin));
                    ?>
                    
                    
                    <!-- <?php if(config('app.debug')): ?>
                        <div class="alert alert-warning small">
                            <strong>Debug Info:</strong><br>
                            Image name: <?php echo e($car->car_image); ?><br>
                            Uploads path: <?php echo e(public_path($imagePathUploads)); ?><br>
                            Admin path: <?php echo e(public_path($imagePathAdmin)); ?><br>
                            Uploads exists: <?php echo e($imageExistsInUploads ? 'Yes' : 'No'); ?><br>
                            Admin exists: <?php echo e($imageExistsInAdmin ? 'Yes' : 'No'); ?>

                        </div>
                    <?php endif; ?> -->
                    
                    <?php if($imageExistsInUploads): ?>
                        <img src="<?php echo e(asset($imagePathUploads)); ?>" 
                            alt="<?php echo e($car->maker ?? 'Car'); ?> <?php echo e($car->model ?? 'Image'); ?>" 
                            style="max-width: 100%; max-height: 300px; object-fit: cover;" 
                            class="img-fluid rounded"
                            onerror="console.log('Image failed to load: <?php echo e(asset($imagePathUploads)); ?>'); this.style.display='none'; this.nextElementSibling.style.display='flex';">
                        
                    <?php elseif($imageExistsInAdmin): ?>
                        <img src="<?php echo e(asset($imagePathAdmin)); ?>" 
                            alt="<?php echo e($car->maker ?? 'Car'); ?> <?php echo e($car->model ?? 'Image'); ?>" 
                            style="max-width: 100%; max-height: 300px; object-fit: cover;" 
                            class="img-fluid rounded"
                            onerror="console.log('Image failed to load: <?php echo e(asset($imagePathAdmin)); ?>'); this.style.display='none'; this.nextElementSibling.style.display='flex';">
                        
                    <?php else: ?>
                        
                        <div class="alert alert-warning mb-2">
                            <small>Image file not found in either directory</small>
                        </div>
                    <?php endif; ?>
                    
                    
                    <div style="max-width: 100%; max-height: 300px; min-height: 200px; background: linear-gradient(135deg, #bdc3c7 0%, #95a5a6 100%); display: <?php echo e(($imageExistsInUploads || $imageExistsInAdmin) ? 'none' : 'flex'); ?>; align-items: center; justify-content: center; color: white; font-size: 2rem;" 
                        class="img-fluid rounded">
                        <div class="text-center">
                            <i class="fas fa-car mb-2"></i>
                            <div style="font-size: 0.8rem;">No Image Available</div>
                        </div>
                    </div>
                </div>
            <?php else: ?>
                <div class="alert alert-info mb-4">
                    <i class="fas fa-info-circle me-2"></i>No image specified for this car
                </div>
            <?php endif; ?>

            
            

            <!-- Car Information -->
            <div class="car-details-card mb-4">
                <div class="car-info-row">
                    <div><strong>Brand:</strong> <?php echo e($car->maker); ?></div>
                    <div><strong>Body Type:</strong> <?php echo e($car->vehicle_type); ?></div>
                    <div><strong>Condition:</strong> <?php echo e($car->car_condition); ?></div>
                </div>
                <div class="car-info-row">
                    <div><strong>Registration:</strong> <?php echo e($car->registration_no); ?></div>
                    <div><strong>Current Mileage:</strong> <?php echo e(number_format($car->current_mileage ?? 0)); ?> km</div>
                    <div><strong>Rate:</strong> BTN <?php echo e(number_format($car->rate_per_day ?? 0, 2)); ?>/day</div>
                </div>
                
                <?php if($car->price_per_km || $car->mileage_limit): ?>
                <div class="car-info-row">
                    <?php if($car->mileage_limit): ?>
                        <div><strong>Daily Limit:</strong> <?php echo e(number_format($car->mileage_limit)); ?> km/day</div>
                    <?php endif; ?>
                    <?php if($car->price_per_km): ?>
                        <div><strong>Extra KM Rate:</strong> BTN <?php echo e(number_format($car->price_per_km, 2)); ?>/km</div>
                    <?php endif; ?>
                    <?php if($car->pricing_active !== null): ?>
                        <div><strong>Status:</strong> 
                            <span class="badge <?php echo e($car->pricing_active ? 'bg-success' : 'bg-warning'); ?>">
                                <?php echo e($car->pricing_active ? 'Active' : 'Inactive'); ?>

                            </span>
                        </div>
                    <?php endif; ?>
                </div>
                <?php endif; ?>
                
                <div class="mt-3">
                    <div class="car-spec">
                        <i class="fas fa-door-open me-2"></i>
                        <span><?php echo e($car->number_of_doors ?? 'N/A'); ?> <?php echo e(($car->number_of_doors ?? 0) == 1 ? 'Door' : 'Doors'); ?></span>
                    </div>
                    <div class="car-spec">
                        <i class="fas fa-users me-2"></i>
                        <span><?php echo e($car->number_of_seats ?? 'N/A'); ?> <?php echo e(($car->number_of_seats ?? 0) == 1 ? 'Seat' : 'Seats'); ?></span>
                    </div>
                    <div class="car-spec">
                        <i class="fas fa-cogs me-2"></i>
                        <span><?php echo e(ucfirst($car->transmission_type ?? 'Unknown')); ?></span>
                    </div>
                    <div class="car-spec">
                        <i class="fas fa-suitcase-rolling me-2"></i>
                        <span><?php echo e($car->large_bags_capacity ?? 0); ?> Large <?php echo e(($car->large_bags_capacity ?? 0) == 1 ? 'Bag' : 'Bags'); ?></span>
                    </div>
                    <div class="car-spec">
                        <i class="fas fa-suitcase me-2"></i>
                        <span><?php echo e($car->small_bags_capacity ?? 0); ?> Small <?php echo e(($car->small_bags_capacity ?? 0) == 1 ? 'Bag' : 'Bags'); ?></span>
                    </div>
                    <div class="car-spec">
                        <i class="fas fa-gas-pump me-2"></i>
                        <span><?php echo e(ucfirst($car->fuel_type ?? 'Unknown')); ?></span>
                    </div>
                    <div class="car-spec">
                        <i class="fas fa-snowflake me-2"></i>
                        <span>
                            <?php
                                $hasAC = false;
                                if (is_bool($car->air_conditioning)) {
                                    $hasAC = $car->air_conditioning;
                                } elseif (is_string($car->air_conditioning)) {
                                    $hasAC = strtolower($car->air_conditioning) === 'yes' || $car->air_conditioning === '1';
                                } else {
                                    $hasAC = (bool) $car->air_conditioning;
                                }
                            ?>
                            <?php echo e($hasAC ? 'Air Conditioning' : 'No AC'); ?>

                        </span>
                    </div>
                    <div class="car-spec">
                        <i class="fas fa-video me-2"></i>
                        <span>
                            <?php
                                $hasCamera = false;
                                if (is_bool($car->backup_camera)) {
                                    $hasCamera = $car->backup_camera;
                                } elseif (is_string($car->backup_camera)) {
                                    $hasCamera = strtolower($car->backup_camera) === 'yes' || $car->backup_camera === '1';
                                } else {
                                    $hasCamera = (bool) $car->backup_camera;
                                }
                            ?>
                            <?php echo e($hasCamera ? 'Rear-View Camera' : 'No Rear-View Camera'); ?>

                        </span>
                    </div>
                    <div class="car-spec">
                        <i class="fas fa-music me-2"></i>
                        <span>
                            <?php
                                $hasBluetooth = false;
                                if (is_bool($car->bluetooth)) {
                                    $hasBluetooth = $car->bluetooth;
                                } elseif (is_string($car->bluetooth)) {
                                    $hasBluetooth = strtolower($car->bluetooth) === 'yes' || $car->bluetooth === '1';
                                } else {
                                    $hasBluetooth = (bool) $car->bluetooth;
                                }
                            ?>
                            <?php echo e($hasBluetooth ? 'Bluetooth Enabled' : 'No Bluetooth'); ?>

                        </span>
                    </div>
                </div>
                
                <?php if($car->description): ?>
                    <div class="mt-3">
                        <p><strong>Description:</strong> <?php echo e($car->description); ?></p>
                    </div>
                <?php endif; ?>
            </div>

            <!-- Booking Form -->
            <div class="booking-section mb-4">
                <h4>Book this Car</h4>

                <?php if(Auth::guard('customer')->check()): ?>
                    <form action="<?php echo e(route('car.booking.submit', $car->id)); ?>" method="POST">
                        <?php echo csrf_field(); ?>
                        <div class="booking-inputs">
                            <div class="row mb-3">
                                <div class="col-md-6">
                                    <label for="pickup_date" class="form-label">Pickup Date:</label>
                                    <input type="date" class="form-control" name="pickup_date" id="pickup_date" required>
                                    <div class="mt-2">
                                        <label for="pickup_time" class="form-label">Pickup Time:</label>
                                        <input type="time" class="form-control" name="pickup_time" id="pickup_time" required>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <label for="return_date" class="form-label">Return Date:</label>
                                    <input type="date" class="form-control" name="return_date" id="return_date" required>
                                    <div class="mt-2">
                                        <label for="return_time" class="form-label">Return Time:</label>
                                        <input type="time" class="form-control" name="return_time" id="return_time" required>
                                    </div>
                                </div>
                            </div>
                            <div class="row mb-3">
                                <div class="col-md-6">
                                    <label for="pickup_location" class="form-label">Pickup Location:</label>
                                    <input type="text" class="form-control" name="pickup_location" required>
                                </div>
                                <div class="col-md-6">
                                    <label for="drop_location" class="form-label">Drop Location:</label>
                                    <input type="text" class="form-control" name="drop_location" required>
                                </div>
                            </div>
                            
                            <div class="d-flex gap-2">
                                <button type="submit" class="btn btn-primary">Book</button>
                                <a href="<?php echo e(route('home')); ?>" class="btn btn-secondary">Cancel</a>
                            </div>                        
                        </div>
                    </form>
                <?php else: ?>
                    <div class="alert alert-warning">You must be logged in to book a car.</div>
                    <a href="<?php echo e(route('customer.login', ['redirectTo' => url()->full()])); ?>" class="btn btn-primary">Login to Book</a>
                    <a href="<?php echo e(route('home')); ?>" class="btn btn-secondary">Cancel</a>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('scripts'); ?>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        var carCarousel = new bootstrap.Carousel(document.getElementById('carImageCarousel'), {
            interval: 3000,
            ride: 'carousel'
        });
        
        // Set minimum date for date inputs (today)
        const today = new Date();
        const formattedToday = today.toISOString().split('T')[0]; // YYYY-MM-DD format
        
        const pickupDateInput = document.getElementById('pickup_date');
        const returnDateInput = document.getElementById('return_date');
        const pickupTimeInput = document.getElementById('pickup_time');
        const returnTimeInput = document.getElementById('return_time');
        
        let pickupDatepicker, returnDatepicker, pickupTextInput, returnTextInput;
        
        // Set default time values (9:00 AM for pickup, 6:00 PM for return)
        if (pickupTimeInput) {
            pickupTimeInput.value = '09:00';
        }
        
        if (returnTimeInput) {
            returnTimeInput.value = '18:00';
        }
        
        // Time validation and sync logic
        if (pickupDateInput && returnDateInput && pickupTimeInput && returnTimeInput) {
            // Handle the case when pickup and return dates are the same
            function validateTimes() {
                if (pickupDateInput.value && returnDateInput.value && 
                    pickupDateInput.value === returnDateInput.value) {
                    // If same day, ensure return time is after pickup time
                    const pickupTime = pickupTimeInput.value;
                    const returnTime = returnTimeInput.value;
                    
                    if (returnTime <= pickupTime) {
                        // If return time is earlier or same as pickup time, set it to pickup time + 1 hour
                        const [hours, minutes] = pickupTime.split(':').map(Number);
                        let newHours = hours + 1;
                        if (newHours > 23) newHours = 23;
                        returnTimeInput.value = `${String(newHours).padStart(2, '0')}:${String(minutes).padStart(2, '0')}`;
                    }
                }
            }
            
            pickupTimeInput.addEventListener('change', validateTimes);
            returnTimeInput.addEventListener('change', validateTimes);
        }
        
        // Function to format date as DD/MM/YYYY
        function formatDateToDMY(date) {
            const d = new Date(date);
            const day = String(d.getDate()).padStart(2, '0');
            const month = String(d.getMonth() + 1).padStart(2, '0');
            const year = d.getFullYear();
            return `${day}/${month}/${year}`;
        }
        
        // Create custom date inputs that display DD/MM/YYYY
        if (pickupDateInput) {
            // Set min date
            pickupDateInput.min = formattedToday;
            
            // Create a wrapper around the date input
            const pickupWrapper = document.createElement('div');
            pickupWrapper.className = 'date-input-wrapper';
            pickupDateInput.parentNode.insertBefore(pickupWrapper, pickupDateInput);
            
            // Create a text input for DD/MM/YYYY display
            pickupTextInput = document.createElement('input');
            pickupTextInput.type = 'text';
            pickupTextInput.className = 'form-control';
            pickupTextInput.placeholder = 'DD/MM/YYYY';
            pickupTextInput.required = true;
            
            // Move the date input out of view but keep it in the DOM for form submission
            pickupDateInput.style.position = 'absolute';
            pickupDateInput.style.opacity = '0';
            pickupDateInput.style.height = '0';
            pickupDateInput.style.width = '0';
            pickupDateInput.style.overflow = 'hidden';
            
            // Add the text input to the wrapper
            pickupWrapper.appendChild(pickupTextInput);
            pickupWrapper.appendChild(pickupDateInput);
            
            // Initialize datepicker
            pickupDatepicker = new Pikaday({
                field: pickupTextInput,
                format: 'DD/MM/YYYY',
                minDate: today,
                onSelect: function(date) {
                    // Update the hidden date input with YYYY-MM-DD format
                    pickupDateInput.value = date.toISOString().split('T')[0];
                    pickupDateInput.dispatchEvent(new Event('change'));
                    
                    // Update return date if needed
                    if (returnDatepicker) {
                        // Force return date to be at least the pickup date
                        const returnCurrentDate = returnDatepicker.getDate();
                        if (!returnCurrentDate || returnCurrentDate < date) {
                            returnDatepicker.setDate(date);
                            returnDateInput.value = pickupDateInput.value;
                            
                            // Validate times when dates are the same
                            validateTimes();
                        }
                        // Set the minimum selectable date for return
                        returnDatepicker.setMinDate(date);
                    }
                }
            });
        }
        
        if (returnDateInput) {
            // Set min date
            returnDateInput.min = formattedToday;
            
            // Create a wrapper around the date input
            const returnWrapper = document.createElement('div');
            returnWrapper.className = 'date-input-wrapper';
            returnDateInput.parentNode.insertBefore(returnWrapper, returnDateInput);
            
            // Create a text input for DD/MM/YYYY display
            returnTextInput = document.createElement('input');
            returnTextInput.type = 'text';
            returnTextInput.className = 'form-control';
            returnTextInput.placeholder = 'DD/MM/YYYY';
            returnTextInput.required = true;
            
            // Move the date input out of view but keep it in the DOM for form submission
            returnDateInput.style.position = 'absolute';
            returnDateInput.style.opacity = '0';
            returnDateInput.style.height = '0';
            returnDateInput.style.width = '0';
            returnDateInput.style.overflow = 'hidden';
            
            // Add the text input to the wrapper
            returnWrapper.appendChild(returnTextInput);
            returnWrapper.appendChild(returnDateInput);
            
            // Initialize datepicker
            returnDatepicker = new Pikaday({
                field: returnTextInput,
                format: 'DD/MM/YYYY',
                minDate: pickupDateInput.value ? new Date(pickupDateInput.value) : today,
                onSelect: function(date) {
                    // Update the hidden date input with YYYY-MM-DD format
                    returnDateInput.value = date.toISOString().split('T')[0];
                    returnDateInput.dispatchEvent(new Event('change'));
                    
                    // Ensure return date is not before pickup date
                    if (pickupDateInput.value) {
                        const pickupDate = new Date(pickupDateInput.value);
                        if (date < pickupDate) {
                            // Reset to pickup date if user somehow selects earlier date
                            returnDatepicker.setDate(pickupDate);
                            returnDateInput.value = pickupDateInput.value;
                        }
                    }
                    
                    // Check if dates are the same to validate times
                    validateTimes();
                }
            });
        }
    });
</script>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\Sangay Ngedup\Documents\GitHub\FinalProject\resources\views/cars/book.blade.php ENDPATH**/ ?>