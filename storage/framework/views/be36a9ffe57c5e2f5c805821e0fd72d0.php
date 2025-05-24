


<?php $__env->startSection('title', 'View CarDetails'); ?>

<?php $__env->startSection('breadcrumbs'); ?>
    <li class="breadcrumb-item">
        <a href="<?php echo e(route('cars.index')); ?>">Cars Management</a>
    </li>
    <li class="breadcrumb-item active">View Car</li>
<?php $__env->stopSection(); ?>

<?php $__env->startPush('styles'); ?>
    <link rel="stylesheet" href="<?php echo e(asset('assets/css/admin/viewcar.css')); ?>">
<?php $__env->stopPush(); ?>
<?php $__env->startSection('content'); ?>
<!-- Car Details -->
<div class="card">
    <div class="card-header d-flex justify-content-between align-items-center">
        <h2><?php echo e($car->maker); ?> <?php echo e($car->model); ?></h2>
        <div>
            <a href="<?php echo e(route('cars.edit', $car->id)); ?>" class="btn btn-primary">
                <i class="fas fa-edit"></i> Edit Car
            </a>
            <a href="<?php echo e(route('cars.index')); ?>" class="btn btn-secondary">
                <i class="fas fa-arrow-left"></i> Back to List
            </a>
        </div>
    </div>
    <div class="card-body">
        <!-- Car Images -->
        <div class="row">
            <div class="col-md-12">
                <h4>Car Images</h4>
                <div class="car-images-gallery">
                    <?php
                    // Collect all images: primary + additional
                    $allImages = [];
                    
                    // Add primary image if exists
                    if ($car->car_image && !empty(trim($car->car_image))) {
                        $allImages[] = trim($car->car_image);
                    }
                    
                    // Add additional images from AdminCarImage table
                    if (isset($car->carImages)) {
                        foreach ($car->carImages as $carImage) {
                            if (!empty(trim($carImage->image_path))) {
                                $allImages[] = trim($carImage->image_path);
                            }
                        }
                    }
                    ?>
                    
                    <?php if(!empty($allImages)): ?>
                        <!-- Main Image Display -->
                        <div class="main-image-container">
                            <img id="mainImage"
                                src="<?php echo e(asset('admincar_images/' . $allImages[0])); ?>"
                                alt="<?php echo e($car->maker ?? 'Car'); ?> <?php echo e($car->model ?? ''); ?>"
                                class="main-car-image"
                                onerror="this.src='<?php echo e(asset('admincar_images/default-car.jpg')); ?>'; this.onerror=null;">
                            
                            <!-- Image counter -->
                            <div class="image-counter">
                                <span id="currentImageIndex">1</span> / <?php echo e(count($allImages)); ?>

                            </div>
                        </div>

                        <!-- Thumbnail Gallery (show if more than 1 image) -->
                        <?php if(count($allImages) > 1): ?>
                            <div class="thumbnail-images">
                                <div class="thumbnail-scroll">
                                    <?php $__currentLoopData = $allImages; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $index => $image): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <div class="thumbnail-wrapper">
                                            <img src="<?php echo e(asset('admincar_images/' . $image)); ?>"
                                                alt="Car Image <?php echo e($index + 1); ?>"
                                                class="thumbnail-image <?php echo e($index == 0 ? 'active' : ''); ?>"
                                                data-index="<?php echo e($index + 1); ?>"
                                                onclick="changeMainImage('<?php echo e(asset('admincar_images/' . $image)); ?>', this, <?php echo e($index + 1); ?>)"
                                                onerror="this.parentElement.style.display='none';">
                                            <div class="thumbnail-overlay"><?php echo e($index + 1); ?></div>
                                        </div>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                </div>
                            </div>

                            <!-- Navigation arrows for mobile -->
                            <div class="image-navigation d-md-none">
                                <button type="button" class="nav-btn prev-btn" onclick="navigateImage(-1)">
                                    <i class="fas fa-chevron-left"></i>
                                </button>
                                <button type="button" class="nav-btn next-btn" onclick="navigateImage(1)">
                                    <i class="fas fa-chevron-right"></i>
                                </button>
                            </div>
                        <?php endif; ?>
                    <?php else: ?>
                        <!-- No images found -->
                        <div class="no-image">
                            <img src="<?php echo e(asset('admincar_images/default-car.jpg')); ?>"
                                alt="No Image Available"
                                class="main-car-image"
                                onerror="this.src='<?php echo e(asset('assets/images/no-image-placeholder.png')); ?>'; this.onerror=null;">
                            <p class="text-muted mt-2">No images available</p>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>
        
        <!-- Car Information -->
        <div class="row mt-4">
            <div class="col-md-6">
                <h4>Basic Information</h4>
                <div class="car-details-grid">
                    <div class="detail-row">
                        <span class="detail-label">Car ID:</span>
                        <span class="detail-value"><?php echo e($car->id); ?></span>
                    </div>
                    <div class="detail-row">
                        <span class="detail-label">Maker:</span>
                        <span class="detail-value"><?php echo e($car->maker); ?></span>
                    </div>
                    <div class="detail-row">
                        <span class="detail-label">Model:</span>
                        <span class="detail-value"><?php echo e($car->model); ?></span>
                    </div>
                    <div class="detail-row">
                        <span class="detail-label">Vehicle Type:</span>
                        <span class="detail-value"><?php echo e($car->vehicle_type); ?></span>
                    </div>
                    <div class="detail-row">
                        <span class="detail-label">Condition:</span>
                        <span class="detail-value"><?php echo e($car->car_condition); ?></span>
                    </div>
                    <div class="detail-row">
                        <span class="detail-label">Registration No:</span>
                        <span class="detail-value"><?php echo e($car->registration_no); ?></span>
                    </div>
                    <div class="detail-row">
                        <span class="detail-label">Mileage:</span>
                        <span class="detail-value"><?php echo e(number_format($car->mileage)); ?> km</span>
                    </div>
                    <div class="detail-row">
                        <span class="detail-label">Daily Rate:</span>
                        <span class="detail-value">$<?php echo e(number_format($car->price, 2)); ?></span>
                    </div>
                    <div class="detail-row">
                        <span class="detail-label">Status:</span>
                        <span class="detail-value">
                            <?php
                            $statusClass = '';
                            switch (strtolower($car->status)) {
                                case 'available':
                                    $statusClass = 'available';
                                    break;
                                case 'booked':
                                case 'rented':
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
                            ?>
                            <span class="status-badge <?php echo e($statusClass); ?>"><?php echo e(ucfirst($car->status)); ?></span>
                        </span>
                    </div>
                </div>
            </div>

            <div class="col-md-6">
                <h4>Technical Specifications</h4>
                <div class="car-details-grid">
                    <div class="detail-row">
                        <span class="detail-label">Number of Doors:</span>
                        <span class="detail-value"><?php echo e($car->number_of_doors); ?></span>
                    </div>
                    <div class="detail-row">
                        <span class="detail-label">Number of Seats:</span>
                        <span class="detail-value"><?php echo e($car->number_of_seats); ?></span>
                    </div>
                    <div class="detail-row">
                        <span class="detail-label">Transmission:</span>
                        <span class="detail-value"><?php echo e($car->transmission_type); ?></span>
                    </div>
                    <div class="detail-row">
                        <span class="detail-label">Fuel Type:</span>
                        <span class="detail-value"><?php echo e($car->fuel_type); ?></span>
                    </div>
                    <div class="detail-row">
                        <span class="detail-label">Large Bags Capacity:</span>
                        <span class="detail-value"><?php echo e($car->large_bags_capacity ?? 'N/A'); ?></span>
                    </div>
                    <div class="detail-row">
                        <span class="detail-label">Small Bags Capacity:</span>
                        <span class="detail-value"><?php echo e($car->small_bags_capacity ?? 'N/A'); ?></span>
                    </div>
                </div>

                <h4 class="mt-4">Features</h4>
                <div class="car-features">
                    <div class="feature-item">
                        <i class="fas fa-snowflake"></i>
                        <span>Air Conditioning: <?php echo e($car->air_conditioning ?? 'N/A'); ?></span>
                    </div>
                    <div class="feature-item">
                        <i class="fas fa-camera"></i>
                        <span>Backup Camera: <?php echo e($car->backup_camera ?? 'N/A'); ?></span>
                    </div>
                    <div class="feature-item">
                        <i class="fas fa-bluetooth"></i>
                        <span>Bluetooth: <?php echo e($car->bluetooth ?? 'N/A'); ?></span>
                    </div>
                </div>
            </div>
        </div>

        <!-- Description -->
        <?php if($car->description): ?>
        <div class="row mt-4">
            <div class="col-md-12">
                <h4>Description</h4>
                <div class="car-description">
                    <p><?php echo e($car->description); ?></p>
                </div>
            </div>
        </div>
        <?php endif; ?>

        <!-- Car Statistics -->
        <div class="row mt-4">
            <div class="col-md-12">
                <h4>Additional Information</h4>
                <div class="car-stats">
                    <div class="stat-card">
                        <div class="stat-icon">
                            <i class="fas fa-calendar-alt"></i>
                        </div>
                        <div class="stat-info">
                            <span class="stat-label">Added On</span>
                            <span class="stat-value"><?php echo e($car->created_at ? $car->created_at->format('M d, Y') : 'N/A'); ?></span>
                        </div>
                    </div>
                    <div class="stat-card">
                        <div class="stat-icon">
                            <i class="fas fa-edit"></i>
                        </div>
                        <div class="stat-info">
                            <span class="stat-label">Last Updated</span>
                            <span class="stat-value"><?php echo e($car->updated_at ? $car->updated_at->format('M d, Y') : 'N/A'); ?></span>
                        </div>
                    </div>
                    <div class="stat-card">
                        <div class="stat-icon">
                            <i class="fas fa-dollar-sign"></i>
                        </div>
                        <div class="stat-info">
                            <span class="stat-label">Monthly Rate</span>
                            <span class="stat-value">$<?php echo e(number_format($car->price * 30, 2)); ?></span>
                        </div>
                    </div>
                    <div class="stat-card">
                        <div class="stat-icon">
                            <i class="fas fa-road"></i>
                        </div>
                        <div class="stat-info">
                            <span class="stat-label">Mileage Status</span>
                            <span class="stat-value">
                                <?php if($car->mileage < 50000): ?>
                                    <span class="text-success">Low Mileage</span>
                                <?php elseif($car->mileage < 100000): ?>
                                    <span class="text-warning">Medium Mileage</span>
                                <?php else: ?>
                                    <span class="text-danger">High Mileage</span>
                                <?php endif; ?>
                            </span>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Action Buttons -->
        <div class="row mt-4">
            <div class="col-md-12">
                <div class="action-buttons">
                    <a href="<?php echo e(route('cars.edit', $car->id)); ?>" class="btn btn-primary">
                        <i class="fas fa-edit"></i> Edit Car
                    </a>
                    <a href="<?php echo e(route('cars.index')); ?>" class="btn btn-secondary">
                        <i class="fas fa-list"></i> Back to Cars List
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php $__env->startPush('scripts'); ?>
<script>
    let currentImages = [];
    let currentImageIndex = 0;

    // Initialize when page loads
    document.addEventListener('DOMContentLoaded', function() {
        // Collect all image sources
        const thumbnails = document.querySelectorAll('.thumbnail-image');
        currentImages = Array.from(thumbnails).map(thumb => thumb.src);
        currentImageIndex = 0;
    });

    function changeMainImage(imageSrc, thumbnailElement, imageIndex) {
        // Update main image
        const mainImage = document.getElementById('mainImage');
        if (mainImage) {
            mainImage.src = imageSrc;
        }
        
        // Update active thumbnail
        document.querySelectorAll('.thumbnail-image').forEach(thumb => {
            thumb.classList.remove('active');
        });
        
        if (thumbnailElement) {
            thumbnailElement.classList.add('active');
        }
        
        // Update counter
        if (imageIndex) {
            currentImageIndex = imageIndex - 1;
            const counter = document.getElementById('currentImageIndex');
            if (counter) {
                counter.textContent = imageIndex;
            }
        }
    }

    function navigateImage(direction) {
        if (currentImages.length === 0) return;
        
        currentImageIndex += direction;
        
        // Loop around
        if (currentImageIndex >= currentImages.length) {
            currentImageIndex = 0;
        } else if (currentImageIndex < 0) {
            currentImageIndex = currentImages.length - 1;
        }
        
        // Update main image
        const mainImage = document.getElementById('mainImage');
        if (mainImage && currentImages[currentImageIndex]) {
            mainImage.src = currentImages[currentImageIndex];
        }
        
        // Update active thumbnail
        const thumbnails = document.querySelectorAll('.thumbnail-image');
        thumbnails.forEach((thumb, index) => {
            thumb.classList.toggle('active', index === currentImageIndex);
        });
        
        // Update counter
        const counter = document.getElementById('currentImageIndex');
        if (counter) {
            counter.textContent = currentImageIndex + 1;
        }
    }

    // Handle image loading errors
    function handleImageError(img) {
        img.style.display = 'none';
        console.log('Failed to load image: ' + img.src);
    }

    // Check if images exist and handle accordingly
    document.addEventListener('DOMContentLoaded', function() {
        const images = document.querySelectorAll('.car-images-gallery img');
        images.forEach(img => {
            img.addEventListener('error', function() {
                handleImageError(this);
            });
        });
    });

    // Optional: Add keyboard navigation
    document.addEventListener('keydown', function(e) {
        if (e.key === 'ArrowLeft') {
            navigateImage(-1);
        } else if (e.key === 'ArrowRight') {
            navigateImage(1);
        }
    });

    // Optional: Add swipe support for mobile
    let startX = 0;
    let endX = 0;

    document.addEventListener('touchstart', function(e) {
        startX = e.changedTouches[0].screenX;
    });

    document.addEventListener('touchend', function(e) {
        endX = e.changedTouches[0].screenX;
        handleSwipe();
    });

    function handleSwipe() {
        const threshold = 50; // minimum distance for swipe
        const diff = startX - endX;
        
        if (Math.abs(diff) > threshold) {
            if (diff > 0) {
                navigateImage(1); // swipe left - next image
            } else {
                navigateImage(-1); // swipe right - previous image
            }
        }
    }
</script>
<?php $__env->stopPush(); ?>
<?php echo $__env->make('layouts.admin', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\Thinley Norbu\Documents\GitHub\FinalProject\resources\views/admin/car-view-details.blade.php ENDPATH**/ ?>