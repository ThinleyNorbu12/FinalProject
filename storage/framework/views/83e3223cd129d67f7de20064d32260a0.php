

<?php $__env->startSection('content'); ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Browse Cars - Car Rental</title>
    <!-- Link to the external CSS file -->
    <link rel="stylesheet" href="<?php echo e(asset('assets/css/customer/dashboard.css')); ?>">
    <!-- Additional CSS for browse cars page -->
    <style>
        .filters-section {
            background-color: #f8f9fa;
            padding: 20px;
            border-radius: 8px;
            margin-bottom: 25px;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.05);
        }
        
        .filter-group {
            margin-bottom: 15px;
        }
        
        .filter-title {
            font-weight: 600;
            margin-bottom: 10px;
            color: #333;
        }
        
        .filter-controls {
            display: flex;
            flex-wrap: wrap;
            gap: 10px;
        }
        
        .price-inputs {
            display: flex;
            gap: 10px;
            align-items: center;
        }
        
        .cars-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(300px, 1fr));
            gap: 25px;
            margin-top: 20px;
        }
        
        .car-card {
            border-radius: 8px;
            overflow: hidden;
            box-shadow: 0 3px 6px rgba(0, 0, 0, 0.1);
            transition: transform 0.3s, box-shadow 0.3s;
            background-color: #fff;
        }
        
        .car-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 6px 12px rgba(0, 0, 0, 0.15);
        }
        
        .car-image {
            height: 200px;
            width: 100%;
            object-fit: cover;
        }
        
        .car-details {
            padding: 15px;
        }
        
        .car-title {
            font-size: 1.2rem;
            font-weight: 600;
            margin-bottom: 8px;
        }
        
        .car-specs {
            font-size: 0.9rem;
            color: #666;
            margin-bottom: 12px;
        }
        
        .car-description {
            font-size: 0.9rem;
            color: #555;
            margin-bottom: 12px;
            display: -webkit-box;
            -webkit-line-clamp: 3;
            -webkit-box-orient: vertical;
            overflow: hidden;
        }
        
        .car-price {
            font-size: 1.3rem;
            font-weight: 700;
            color: #2c3e50;
            margin-bottom: 15px;
        }
        
        .car-features {
            display: flex;
            flex-wrap: wrap;
            gap: 8px;
            margin-bottom: 15px;
        }
        
        .car-feature {
            background-color: #f0f3f7;
            padding: 4px 8px;
            border-radius: 4px;
            font-size: 0.8rem;
            color: #333;
        }
        
        .btn-view-details {
            background-color: #3498db;
            color: white;
            border: none;
            padding: 8px 15px;
            border-radius: 4px;
            cursor: pointer;
            font-weight: 500;
            transition: background-color 0.2s;
            margin-right: 5px;
        }
        
        .btn-book-now {
            background-color: #2ecc71;
            color: white;
            border: none;
            padding: 8px 15px;
            border-radius: 4px;
            cursor: pointer;
            font-weight: 500;
            transition: background-color 0.2s;
        }
        
        .btn-view-details:hover {
            background-color: #2980b9;
        }
        
        .btn-book-now:hover {
            background-color: #27ae60;
        }
        
        .car-actions {
            display: flex;
            gap: 10px;
        }
        
        .no-cars-message {
            text-align: center;
            padding: 40px;
            background-color: #f8f9fa;
            border-radius: 8px;
            color: #555;
        }
        
        .car-status {
            position: absolute;
            top: 10px;
            right: 10px;
            background-color: #2ecc71;
            color: white;
            padding: 3px 8px;
            border-radius: 4px;
            font-size: 0.8rem;
            font-weight: 600;
        }

        .page-title {
            font-size: 1.8rem;
            font-weight: 700;
            margin-bottom: 20px;
            color: #2c3e50;
        }

        .filter-btn {
            background-color: #3498db;
            color: white;
            border: none;
            padding: 10px 15px;
            border-radius: 4px;
            cursor: pointer;
            transition: background-color 0.2s;
        }

        .filter-btn:hover {
            background-color: #2980b9;
        }

        .reset-btn {
            background-color: #95a5a6;
            color: white;
            border: none;
            padding: 10px 15px;
            border-radius: 4px;
            cursor: pointer;
            transition: background-color 0.2s;
        }

        .reset-btn:hover {
            background-color: #7f8c8d;
        }

        .buttons-container {
            display: flex;
            gap: 10px;
            margin-top: 15px;
        }

        .car-card-container {
            position: relative;
        }
    </style>

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>
<body>
    <!-- Header -->
    <header class="main-header">
        <button class="header-menu-toggle" id="sidebarToggle">
            <i class="fas fa-bars"></i>
        </button>
        
        <div class="header-logo">
            <i class="fas fa-car"></i>
            <span>CarRental</span>
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
                <a href="<?php echo e(route('customer.dashboard')); ?>" class="sidebar-menu-item">
                    <i class="fas fa-home"></i>
                    <span>Dashboard</span>
                </a>
                
                <a href="<?php echo e(route('customer.browse-cars')); ?>" class="sidebar-menu-item active">
                    <i class="fas fa-car"></i>
                    <span>Browse Cars</span>
                </a>
                
                <a href="<?php echo e(route('customer.my-reservations')); ?>" class="sidebar-menu-item ">
                    <i class="fas fa-calendar-alt"></i>
                    <span>My Reservations</span>
                </a>
                
                <div class="sidebar-divider"></div>
                
                <div class="sidebar-heading">My Account</div>
                
                <a href="<?php echo e(route('customer.profile')); ?>" class="sidebar-menu-item">
                    <i class="fas fa-user"></i>
                    <span>Profile</span>
                </a>
                
                <a href="<?php echo e(route('customer.rental-history')); ?>" class="sidebar-menu-item ">
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
                
                <a href="#" class="sidebar-menu-item">
                    <i class="fas fa-map-marked-alt"></i>
                    <span>Locations</span>
                </a>
                
                <a href="#" class="sidebar-menu-item">
                    <i class="fas fa-shield-alt"></i>
                    <span>Insurance Options</span>
                </a>
                
                <a href="#" class="sidebar-menu-item">
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
            <h1 class="page-title">Browse Cars</h1>
            
            <!-- Filters Section -->
            <div class="filters-section">
                <form action="<?php echo e(route('customer.browse-cars')); ?>" method="GET">
                    <div class="row">
                        <div class="col-md-4">
                            <div class="filter-group">
                                <div class="filter-title">Vehicle Type</div>
                                <select name="vehicle_type" class="form-select">
                                    <option value="">All Types</option>
                                    <?php $__currentLoopData = $vehicleTypes; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $type): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <option value="<?php echo e($type); ?>" <?php echo e(request('vehicle_type') == $type ? 'selected' : ''); ?>><?php echo e(ucfirst($type)); ?></option>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                </select>
                            </div>
                        </div>
                        
                        <div class="col-md-4">
                            <div class="filter-group">
                                <div class="filter-title">Transmission</div>
                                <select name="transmission_type" class="form-select">
                                    <option value="">All Transmissions</option>
                                    <?php $__currentLoopData = $transmissionTypes; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $transmission): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <option value="<?php echo e($transmission); ?>" <?php echo e(request('transmission_type') == $transmission ? 'selected' : ''); ?>><?php echo e(ucfirst($transmission)); ?></option>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                </select>
                            </div>
                        </div>
                        
                        <div class="col-md-4">
                            <div class="filter-group">
                                <div class="filter-title">Features</div>
                                <div class="form-check">
                                    <input type="checkbox" class="form-check-input" id="air_conditioning" name="air_conditioning" value="1" <?php echo e(request('air_conditioning') ? 'checked' : ''); ?>>
                                    <label class="form-check-label" for="air_conditioning">Air Conditioning</label>
                                </div>
                                <div class="form-check">
                                    <input type="checkbox" class="form-check-input" id="backup_camera" name="backup_camera" value="1" <?php echo e(request('backup_camera') ? 'checked' : ''); ?>>
                                    <label class="form-check-label" for="backup_camera">Backup Camera</label>
                                </div>
                                <div class="form-check">
                                    <input type="checkbox" class="form-check-input" id="bluetooth" name="bluetooth" value="1" <?php echo e(request('bluetooth') ? 'checked' : ''); ?>>
                                    <label class="form-check-label" for="bluetooth">Bluetooth</label>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <div class="row mt-3">
                        <div class="col-md-6">
                            <div class="filter-group">
                                <div class="filter-title">Price Range (per day)</div>
                                <div class="price-inputs">
                                    <input type="number" class="form-control" name="min_price" placeholder="Min" value="<?php echo e(request('min_price')); ?>">
                                    <span>to</span>
                                    <input type="number" class="form-control" name="max_price" placeholder="Max" value="<?php echo e(request('max_price')); ?>">
                                </div>
                            </div>
                        </div>
                        
                        <div class="col-md-6">
                            <div class="filter-group">
                                <div class="filter-title">Sort By</div>
                                <select name="sort_by" class="form-select">
                                    <option value="price_asc" <?php echo e(request('sort_by') == 'price_asc' ? 'selected' : ''); ?>>Price: Low to High</option>
                                    <option value="price_desc" <?php echo e(request('sort_by') == 'price_desc' ? 'selected' : ''); ?>>Price: High to Low</option>
                                    <option value="newest" <?php echo e(request('sort_by') == 'newest' ? 'selected' : ''); ?>>Newest First</option>
                                </select>
                            </div>
                        </div>
                    </div>
                    
                    <div class="buttons-container">
                        <button type="submit" class="filter-btn">
                            <i class="fas fa-filter"></i> Apply Filters
                        </button>
                        
                        <a href="<?php echo e(route('customer.browse-cars')); ?>" class="reset-btn">
                            <i class="fas fa-redo"></i> Reset Filters
                        </a>
                    </div>
                </form>
            </div>
            
            <!-- Cars Grid -->
            <?php if(count($cars) > 0): ?>
                <div class="cars-grid">
                    <?php $__currentLoopData = $cars; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $car): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <div class="car-card-container">
                        <div class="car-status">Available</div>
                        <div class="car-card">
                            <?php if($car->car_image): ?>
                                    <img src="<?php echo e(asset($car->car_image)); ?>" alt="Car Image" style="width: 100px; height: auto;">
                                <?php else: ?>
                                    <p>No image</p>
                                <?php endif; ?>
                            
                            <div class="car-details">
                                <h4 class="car-title"><?php echo e($car->maker); ?> <?php echo e($car->model); ?> (<?php echo e($car->vehicle_type); ?>)</h4>
                                
                                <div class="car-specs">
                                    <i class="fas fa-user"></i> <?php echo e($car->number_of_seats ?? 'N/A'); ?> &nbsp;
                                    <i class="fas fa-door-open"></i> <?php echo e($car->number_of_doors ?? 'N/A'); ?> &nbsp;
                                    <i class="fas fa-gas-pump"></i> <?php echo e(ucfirst($car->fuel_type ?? 'N/A')); ?> &nbsp;
                                    <i class="fas fa-cog"></i> <?php echo e(ucfirst($car->transmission_type ?? 'Auto')); ?>

                                </div>
                                
                                <div class="car-description">
                                    <?php echo e(\Illuminate\Support\Str::limit($car->description, 100) ?? 'No description available.'); ?>

                                </div>
                                
                                <div class="car-features">
                                    <?php if($car->air_conditioning): ?>
                                        <span class="car-feature"><i class="fas fa-snowflake"></i> A/C</span>
                                    <?php endif; ?>
                                    
                                    <?php if($car->backup_camera): ?>
                                        <span class="car-feature"><i class="fas fa-camera"></i> Backup Camera</span>
                                    <?php endif; ?>
                                    
                                    <?php if($car->bluetooth): ?>
                                        <span class="car-feature"><i class="fab fa-bluetooth-b"></i> Bluetooth</span>
                                    <?php endif; ?>
                                    
                                    <span class="car-feature"><i class="fas fa-suitcase"></i> <?php echo e($car->large_bags_capacity ?? '0'); ?> Large / <?php echo e($car->small_bags_capacity ?? '0'); ?> Small</span>
                                </div>
                                
                                <div class="car-price">$<?php echo e(number_format($car->price, 2)); ?>/day</div>
                                
                                <div class="car-actions">
                                    <a href="<?php echo e(route('customer.car-details', $car->id)); ?>" class="btn-view-details">View Details</a>
                                    <a href="<?php echo e(route('customer.book-car', $car->id)); ?>" class="btn-book-now">Book Now</a>
                                </div>
                            </div>
                        </div>
                    </div>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </div>
            <?php else: ?>
                <div class="no-cars-message">
                    <i class="fas fa-car fa-3x mb-3"></i>
                    <h3>No cars found matching your criteria</h3>
                    <p>Try adjusting your filters or check back later for new arrivals.</p>
                </div>
            <?php endif; ?>
        </div>
    </div>

    <script>
        // Toggle sidebar
        document.addEventListener('DOMContentLoaded', function() {
            const sidebarToggle = document.getElementById('sidebarToggle');
            const sidebar = document.getElementById('sidebar');
            
            sidebarToggle.addEventListener('click', function() {
                sidebar.classList.toggle('expanded');
            });
            
            // Close sidebar when clicking outside on mobile
            document.addEventListener('click', function(event) {
                const isClickInsideSidebar = sidebar.contains(event.target);
                const isClickOnToggle = sidebarToggle.contains(event.target);
                
                if (!isClickInsideSidebar && !isClickOnToggle && window.innerWidth <= 576) {
                    sidebar.classList.remove('expanded');
                }
            });
            
            // Resize handler
            window.addEventListener('resize', function() {
                if (window.innerWidth > 576) {
                    sidebar.classList.remove('expanded');
                }
            });
        });
    </script>
</body>
</html>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\Sangay Ngedup\Documents\GitHub\FinalProject\resources\views/customer/browse-cars.blade.php ENDPATH**/ ?>