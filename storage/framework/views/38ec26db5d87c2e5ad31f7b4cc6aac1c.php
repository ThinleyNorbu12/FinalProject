

<?php $__env->startSection('content'); ?>
 <link rel="stylesheet" href="<?php echo e(asset('assets/css/customer/dashboard.css')); ?>">
 <style>
    /* Car Details Container */
.car-details-container {
    background-color: white;
    border-radius: 8px;
    box-shadow: 0 1px 2px rgba(0, 0, 0, 0.1);
    overflow: hidden;
    margin-bottom: 20px;
}

/* Car Header */
.car-header {
    padding: 20px;
    border-bottom: 1px solid #e5e5e5;
    position: relative;
}

.car-title {
    font-size: 28px;
    font-weight: 700;
    color: #0f0f0f;
    margin: 0 0 8px 0;
}

.car-subtitle {
    color: #606060;
    font-size: 16px;
    margin: 0 0 16px 0;
}

.price-badge {
    position: absolute;
    top: 20px;
    right: 20px;
    background-color: #3366ff;
    color: white;
    padding: 8px 16px;
    border-radius: 20px;
    font-weight: 600;
    font-size: 16px;
}

/* Car Content */
.car-content {
    padding: 20px;
}

/* Car Image Section */
.car-image-section {
    position: relative;
    margin-bottom: 30px;
}

.car-image {
    width: 100%;
    height: 300px;
    object-fit: cover;
    border-radius: 8px;
    background-color: #f1f1f1;
}

.status-badge {
    position: absolute;
    top: 15px;
    left: 15px;
    padding: 6px 12px;
    border-radius: 20px;
    font-size: 12px;
    font-weight: 600;
    text-transform: uppercase;
}

.status-available {
    background-color: #28a745;
    color: white;
}

.status-rented {
    background-color: #dc3545;
    color: white;
}

.status-maintenance {
    background-color: #ffc107;
    color: #212529;
}

/* Info Grid */
.info-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
    gap: 16px;
    margin-bottom: 30px;
}

.info-card {
    background-color: #f9f9f9;
    border-radius: 8px;
    padding: 16px;
    text-align: center;
    border: 1px solid #e5e5e5;
}

.info-card i {
    font-size: 20px;
    color: #3366ff;
    margin-bottom: 8px;
    display: block;
}

.info-label {
    font-size: 12px;
    color: #606060;
    text-transform: uppercase;
    font-weight: 500;
    margin-bottom: 4px;
}

.info-value {
    font-size: 16px;
    color: #0f0f0f;
    font-weight: 600;
}

/* Features Section */
.features-section {
    margin-bottom: 30px;
}

.section-title {
    font-size: 18px;
    font-weight: 600;
    color: #0f0f0f;
    margin-bottom: 16px;
    display: flex;
    align-items: center;
    gap: 8px;
}

.section-title i {
    color: #3366ff;
}

.features-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
    gap: 12px;
}

.feature-item {
    display: flex;
    align-items: center;
    gap: 8px;
    padding: 12px;
    background-color: #f9f9f9;
    border-radius: 6px;
    border: 1px solid #e5e5e5;
}

.feature-item i {
    color: #28a745;
    font-size: 16px;
}

.feature-item.unavailable {
    opacity: 0.6;
}

.feature-item.unavailable i {
    color: #dc3545;
}

/* Description Section */
.description-section {
    margin-bottom: 30px;
}

.description-box {
    background-color: #f9f9f9;
    border-radius: 8px;
    padding: 16px;
    border: 1px solid #e5e5e5;
}

.description-text {
    color: #0f0f0f;
    line-height: 1.6;
    margin: 0;
}

/* Action Buttons */
.action-buttons {
    display: flex;
    gap: 12px;
    flex-wrap: wrap;
    margin-top: 20px;
}

.btn {
    padding: 12px 24px;
    border-radius: 20px;
    font-size: 14px;
    font-weight: 600;
    text-decoration: none;
    border: none;
    cursor: pointer;
    display: inline-flex;
    align-items: center;
    gap: 8px;
    transition: all 0.3s ease;
}

.btn-success {
    background-color: #28a745;
    color: white;
}

.btn-success:hover {
    background-color: #218838;
}

.btn-primary {
    background-color: #3366ff;
    color: white;
}

.btn-primary:hover {
    background-color: #2659d8;
}

/* Responsive Design */
@media (max-width: 992px) {
    .car-title {
        font-size: 24px;
    }
    
    .price-badge {
        position: static;
        display: inline-block;
        margin-top: 10px;
    }
    
    .info-grid {
        grid-template-columns: repeat(auto-fit, minmax(180px, 1fr));
        gap: 12px;
    }
}

@media (max-width: 768px) {
    .car-header {
        text-align: center;
    }
    
    .car-title {
        font-size: 22px;
    }
    
    .car-image {
        height: 250px;
    }
    
    .info-grid {
        grid-template-columns: repeat(auto-fit, minmax(150px, 1fr));
        gap: 10px;
    }
    
    .info-card {
        padding: 12px;
    }
    
    .features-grid {
        grid-template-columns: 1fr;
    }
    
    .action-buttons {
        flex-direction: column;
    }
    
    .btn {
        width: 100%;
        justify-content: center;
    }
}

@media (max-width: 576px) {
    .car-header,
    .car-content {
        padding: 16px;
    }
    
    .car-title {
        font-size: 20px;
    }
    
    .car-image {
        height: 200px;
    }
    
    .info-grid {
        grid-template-columns: 1fr 1fr;
    }
    
    .info-card {
        padding: 10px;
    }
    
    .info-label {
        font-size: 11px;
    }
    
    .info-value {
        font-size: 14px;
    }
    
    .price-badge {
        font-size: 14px;
        padding: 6px 12px;
    }
}

/* Additional responsive adjustments for very small screens */
@media (max-width: 400px) {
    .info-grid {
        grid-template-columns: 1fr;
    }
    
    .car-title {
        font-size: 18px;
    }
    
    .section-title {
        font-size: 16px;
    }
}
</style>
<body>
    <!-- Header -->
    <header class="main-header">
        <button class="header-menu-toggle" id="sidebarToggle">
            <i class="fas fa-bars"></i>
        </button>
        
        <div class="header-logo">
            <i class="fas fa-car"></i>
            <span style="font-size: 1.5rem !important; font-weight: 700 !important;">CAR RENTAL SYSTEM</span>
        </div>
        
        <div class="header-search">
            <input type="text" placeholder="Search for cars...">
            <button><i class="fas fa-search"></i></button>
        </div>
        
        <div class="header-user">
            <?php if(Auth::guard('customer')->check()): ?>
                <span class="header-user-name"><?php echo e(Auth::guard('customer')->user()->name); ?></span>
                <form method="POST" action="<?php echo e(route('customer.logout')); ?>" class="d-inline">
                    <?php echo csrf_field(); ?>
                    <button type="submit" class="btn-logout">Logout</button>
                </form>
            <?php else: ?>
                <a href="<?php echo e(route('customer.login')); ?>" class="btn-logout">Login</a>
            <?php endif; ?>
        </div>        
    </header>

    <!-- Dashboard Container -->
    <div class="dashboard-container">
        <!-- Sidebar -->
        <div class="sidebar" id="sidebar">
            <div class="sidebar-menu">
                <a href="<?php echo e(route('customer.dashboard')); ?>" class="sidebar-menu-item active">
                    <i class="fas fa-home"></i>
                    <span>Dashboard</span>
                </a>
                
                <a href="<?php echo e(route('customer.browse-cars')); ?>" class="sidebar-menu-item ">
                    <i class="fas fa-car"></i>
                    <span>Browse Cars</span>
                </a>
                
                <a href="<?php echo e(route('customer.my-reservations')); ?>" class="sidebar-menu-item">
                    <i class="fas fa-calendar-alt"></i>
                    <span>My Reservations</span>
                </a>
                
                <div class="sidebar-divider"></div>
                
                <div class="sidebar-heading">My Account</div>
                
                <a href="<?php echo e(route('customer.profile')); ?>" class="sidebar-menu-item">
                    <i class="fas fa-user"></i>
                    <span>Profile</span>
                </a>
                
                <a href="<?php echo e(route('customer.rental-history')); ?>" class="sidebar-menu-item">
                    <i class="fas fa-history"></i>
                    <span>Rental History</span>
                </a>
                
                <a href="<?php echo e(route('customer.payment-history')); ?>" class="sidebar-menu-item">
                    <i class="fas fa-credit-card"></i>
                    <span>Payment History</span>
                </a>

                <a href="<?php echo e(route('customer.paylater')); ?>" class="sidebar-menu-item">
                    <i class="fas fa-money-bill-wave"></i>
                    <span>Pay Later</span>
                </a>
                
                <a href="<?php echo e(route('customer.license')); ?>" class="sidebar-menu-item">
                    <i class="fas fa-id-card"></i>
                    <span>Driving License</span>
                </a>
                
                <div class="sidebar-divider"></div>
                
                <div class="sidebar-heading">Services</div>
                
                <a href="<?php echo e(route('customer.locations')); ?>" class="sidebar-menu-item">
                    <i class="fas fa-map-marked-alt"></i>
                    <span>Locations</span>
                </a>
                
                <a href="<?php echo e(route('customer.insurance-options')); ?>" class="sidebar-menu-item">
                    <i class="fas fa-shield-alt"></i>
                    <span>Insurance Options</span>
                </a>
                
                <a href="<?php echo e(route('customer.fuel-policy')); ?>" class="sidebar-menu-item">
                    <i class="fas fa-gas-pump"></i>
                    <span>Fuel Policy</span>
                </a>
                
                <div class="sidebar-divider"></div>
                
                <div class="sidebar-heading">Help</div>
                
                <a href="#" class="sidebar-menu-item">
                    <i class="fas fa-headset"></i>
                    <span>Support</span>
                </a>
                
                <a href="#" class="sidebar-menu-item">
                    <i class="fas fa-question-circle"></i>
                    <span>FAQ</span>
                </a>
                
                <a href="#" class="sidebar-menu-item">
                    <i class="fas fa-exclamation-circle"></i>
                    <span>Report Issue</span>
                </a>
            </div>
        </div>

        <!-- Main Content -->
        <div class="main-content">
            <div class="container">
                

                <div class="car-details-container">
                    <div class="car-header">
                        <h1 class="car-title"><?php echo e($car->maker); ?> <?php echo e($car->model); ?></h1>
                        <p class="car-subtitle"><?php echo e($car->vehicle_type); ?> • <?php echo e($car->car_condition); ?></p>
                        <div class="price-badge">
                            $<?php echo e(number_format($car->price, 2)); ?>/day
                        </div>
                    </div>

                    <div class="car-content">
                        <div class="car-image-section">
                            <?php
                                // Extract just the filename from the stored path
                                $filename = basename($car->car_image);
                                
                                // Build proper paths
                                $imagePathUploads = 'uploads/cars/' . $filename;
                                $imagePathAdmin = 'admincar_images/' . $filename;
                                
                                // Check if files exist
                                $imageExistsInUploads = $car->car_image && file_exists(public_path($imagePathUploads));
                                $imageExistsInAdmin = $car->car_image && file_exists(public_path($imagePathAdmin));
                                
                                // Debug information (remove in production)
                                if(config('app.debug')) {
                                    echo "<!-- Debug: Original: {$car->car_image}, Filename: {$filename}, Uploads Path: " . public_path($imagePathUploads) . ", Exists: " . ($imageExistsInUploads ? 'Yes' : 'No') . " -->";
                                }
                            ?>
                            
                            <?php if($imageExistsInUploads): ?>
                                <img src="<?php echo e(asset($imagePathUploads)); ?>" 
                                    alt="<?php echo e($car->maker); ?> <?php echo e($car->model); ?>" 
                                    class="car-image"
                                    onerror="console.log('Failed to load: <?php echo e(asset($imagePathUploads)); ?>');">
                            <?php elseif($imageExistsInAdmin): ?>
                                <img src="<?php echo e(asset($imagePathAdmin)); ?>" 
                                    alt="<?php echo e($car->maker); ?> <?php echo e($car->model); ?>" 
                                    class="car-image"
                                    onerror="console.log('Failed to load: <?php echo e(asset($imagePathAdmin)); ?>');">
                            <?php else: ?>
                                <div class="car-image" style="background: linear-gradient(135deg, #bdc3c7 0%, #95a5a6 100%); display: flex; align-items: center; justify-content: center; color: white; font-size: 2rem;">
                                    <i class="fas fa-car"></i>
                                </div>
                            <?php endif; ?>
                            
                            <div class="status-badge
                                <?php if($car->status == 'available'): ?> status-available
                                <?php elseif($car->status == 'rented'): ?> status-rented
                                <?php else: ?> status-maintenance <?php endif; ?>">
                                <?php echo e(ucfirst($car->status)); ?>

                            </div>
                        </div>


                        <div class="car-info-section">
                            <div class="info-grid">
                                <div class="info-card">
                                    <i class="fas fa-id-card"></i>
                                    <div class="info-label">Registration No</div>
                                    <div class="info-value"><?php echo e($car->registration_no); ?></div>
                                </div>

                                <div class="info-card">
                                    <i class="fas fa-tachometer-alt"></i>
                                    <div class="info-label">Mileage</div>
                                    <div class="info-value"><?php echo e(number_format($car->mileage)); ?> km</div>
                                </div>

                                <div class="info-card">
                                    <i class="fas fa-gas-pump"></i>
                                    <div class="info-label">Fuel Type</div>
                                    <div class="info-value"><?php echo e(ucfirst($car->fuel_type)); ?></div>
                                </div>

                                <div class="info-card">
                                    <i class="fas fa-cog"></i>
                                    <div class="info-label">Transmission</div>
                                    <div class="info-value"><?php echo e(ucfirst($car->transmission_type)); ?></div>
                                </div>

                                <div class="info-card">
                                    <i class="fas fa-users"></i>
                                    <div class="info-label">Seating Capacity</div>
                                    <div class="info-value"><?php echo e($car->number_of_seats); ?> seats</div>
                                </div>

                                <div class="info-card">
                                    <i class="fas fa-door-open"></i>
                                    <div class="info-label">Number of Doors</div>
                                    <div class="info-value"><?php echo e($car->number_of_doors); ?> doors</div>
                                </div>

                                <div class="info-card">
                                    <i class="fas fa-suitcase"></i>
                                    <div class="info-label">Large Bags</div>
                                    <div class="info-value"><?php echo e($car->large_bags_capacity); ?></div>
                                </div>

                                <div class="info-card">
                                    <i class="fas fa-shopping-bag"></i>
                                    <div class="info-label">Small Bags</div>
                                    <div class="info-value"><?php echo e($car->small_bags_capacity); ?></div>
                                </div>
                            </div>
                        </div>

                        <div class="features-section">
                            <h3 class="section-title">
                                <i class="fas fa-star"></i>
                                Features & Amenities
                            </h3>
                            <div class="features-grid">
                                <div class="feature-item <?php echo e($car->air_conditioning ? '' : 'unavailable'); ?>">
                                    <i class="fas fa-snowflake"></i>
                                    <span>Air Conditioning <?php echo e($car->air_conditioning ? '✓' : '✗'); ?></span>
                                </div>

                                <div class="feature-item <?php echo e($car->backup_camera ? '' : 'unavailable'); ?>">
                                    <i class="fas fa-video"></i>
                                    <span>Backup Camera <?php echo e($car->backup_camera ? '✓' : '✗'); ?></span>
                                </div>

                                <div class="feature-item <?php echo e($car->bluetooth ? '' : 'unavailable'); ?>">
                                    <i class="fab fa-bluetooth"></i>
                                    <span>Bluetooth <?php echo e($car->bluetooth ? '✓' : '✗'); ?></span>
                                </div>
                            </div>
                        </div>

                        <?php if($car->description): ?>
                        <div class="description-section">
                            <h3 class="section-title">
                                <i class="fas fa-info-circle"></i>
                                Description
                            </h3>
                            <div class="description-box">
                                <p class="description-text"><?php echo e($car->description); ?></p>
                            </div>
                        </div>
                        <?php endif; ?>

                        <div class="action-buttons">
                            <?php if($car->status == 'available'): ?>
                                <a href="<?php echo e(route('customer.book-car', $car->id)); ?>" class="btn btn-success">
                                    <i class="fas fa-calendar-check"></i>
                                    Book This Car Now
                                </a>
                            <?php else: ?>
                                <button class="btn btn-primary" disabled style="opacity: 0.6; cursor: not-allowed;">
                                    <i class="fas fa-ban"></i>
                                    Currently <?php echo e(ucfirst($car->status)); ?>

                                </button>
                            <?php endif; ?>
                            
                            <a href="<?php echo e(route('customer.browse-cars')); ?>" class="btn btn-primary">
                                <i class="fas fa-search"></i>
                                Browse More Cars
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        // Sidebar toggle functionality
        document.getElementById('sidebarToggle').addEventListener('click', function() {
            const sidebar = document.getElementById('sidebar');
            const dashboardContainer = document.querySelector('.dashboard-container');
            
            sidebar.classList.toggle('collapsed');
            dashboardContainer.classList.toggle('sidebar-collapsed');
        });
    </script>
</body>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\Sangay Ngedup\Documents\GitHub\FinalProject\resources\views/customer/cardetails.blade.php ENDPATH**/ ?>