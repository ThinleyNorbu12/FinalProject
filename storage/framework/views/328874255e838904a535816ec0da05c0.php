

<?php $__env->startSection('content'); ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Car Rental Dashboard</title>
    <!-- Link to the external CSS file -->
    <link rel="stylesheet" href="<?php echo e(asset('assets/css/customer/dashboard.css')); ?>">

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    
    <style>
        /* Main Layout */
        body {
            font-family: 'Roboto', Arial, sans-serif;
            background-color: #f9f9f9;
            margin: 0;
            padding: 0;
            overflow-x: hidden;
        }

        .dashboard-container {
            display: flex;
        }

        /* Sidebar */
        .sidebar {
            width: 240px;
            height: 100vh;
            background-color: white;
            position: fixed;
            top: 0;
            left: 0;
            overflow-y: auto;
            z-index: 1000;
            box-shadow: 0 1px 2px rgba(0, 0, 0, 0.1);
            padding-top: 56px; /* Height of header */
            transition: transform 0.3s ease, width 0.3s ease;
        }

        .sidebar-brand {
            display: flex;
            align-items: center;
            padding: 14px 20px;
            color: #3366ff;
        }

        .sidebar-brand img {
            width: 30px;
            margin-right: 10px;
        }

        .sidebar-brand span {
            font-size: 18px;
            font-weight: 700;
        }

        .sidebar-menu {
            padding: 10px 0;
        }

        .sidebar-menu-item {
            display: flex;
            align-items: center;
            padding: 10px 20px;
            color: #0f0f0f;
            text-decoration: none;
            transition: all 0.3s;
        }

        .sidebar-menu-item:hover {
            background-color: #f2f2f2;
        }

        .sidebar-menu-item.active {
            background-color: #e5e5e5;
            font-weight: 500;
        }

        .sidebar-menu-item i {
            font-size: 18px;
            width: 24px;
            margin-right: 24px;
            color: #606060;
        }

        .sidebar-divider {
            height: 1px;
            background-color: #e5e5e5;
            margin: 10px 0;
        }

        .sidebar-heading {
            color: #606060;
            font-size: 14px;
            font-weight: 500;
            padding: 10px 20px;
            text-transform: uppercase;
        }

        /* Header */
        .main-header {
            height: 56px;
            background-color: white;
            position: fixed;
            top: 0;
            left: 0;
            right: 0;
            display: flex;
            align-items: center;
            padding: 0 16px;
            box-shadow: 0 1px 2px rgba(0, 0, 0, 0.1);
            z-index: 1001;
        }

        .header-menu-toggle {
            margin-right: 16px;
            background: none;
            border: none;
            cursor: pointer;
            font-size: 20px;
        }

        .header-logo {
            display: flex;
            align-items: center;
            margin-right: 40px;
        }

        .header-logo i {
            color: #3366ff;
            font-size: 24px;
            margin-right: 8px;
        }

        .header-logo span {
            font-size: 18px;
            font-weight: 700;
        }

        .header-search {
            flex: 1;
            max-width: 600px;
            margin: 0 auto;
            position: relative;
        }

        .header-search input {
            width: 100%;
            height: 36px;
            border: 1px solid #ccc;
            border-radius: 20px;
            padding: 0 40px 0 16px;
            font-size: 14px;
        }

        .header-search button {
            position: absolute;
            right: 0;
            top: 0;
            height: 36px;
            width: 36px;
            border: none;
            background: #f8f8f8;
            border-radius: 0 20px 20px 0;
            cursor: pointer;
        }

        .header-user {
            margin-left: auto;
            display: flex;
            align-items: center;
        }

        .header-user-name {
            margin-right: 12px;
            font-weight: 500;
        }

        .btn-logout {
            background-color: #3366ff;
            color: white;
            border: none;
            border-radius: 20px;
            padding: 6px 16px;
            font-size: 14px;
            cursor: pointer;
        }

        /* Main Content */
        .main-content {
            flex: 1;
            padding: 20px;
            margin-left: 240px; /* Width of sidebar */
            margin-top: 56px; /* Height of header */
            width: calc(100% - 240px);
            transition: margin-left 0.3s ease, width 0.3s ease;
        }

        /* Welcome Card */
        .welcome-card {
            background-color: white;
            border-radius: 8px;
            padding: 24px;
            margin-bottom: 20px;
            box-shadow: 0 1px 3px rgba(0, 0, 0, 0.1);
        }

        .welcome-card h2 {
            margin-top: 0;
            color: #333;
            font-weight: 700;
        }

        .welcome-card p {
            color: #666;
            margin-bottom: 0;
        }

        /* License Container */
        .license-container {
            background-color: white;
            border-radius: 8px;
            padding: 20px;
            box-shadow: 0 1px 3px rgba(0, 0, 0, 0.1);
        }

        .license-container.no-license {
            display: flex;
            flex-direction: column;
            align-items: center;
            padding: 60px 20px;
            text-align: center;
        }

        .license-container.no-license i {
            font-size: 64px;
            color: #ccc;
            margin-bottom: 20px;
        }

        .license-container.no-license h3 {
            margin-bottom: 16px;
            color: #333;
        }

        .license-container.no-license p {
            max-width: 500px;
            margin-bottom: 24px;
            color: #666;
        }

        /* License Header */
        .license-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 20px;
            border-bottom: 1px solid #e5e5e5;
            padding-bottom: 15px;
        }

        .license-title h2 {
            margin: 0 0 5px 0;
            font-size: 22px;
            color: #333;
        }

        .license-title p {
            margin: 0;
            color: #666;
            font-size: 14px;
        }

        .license-status {
            display: inline-flex;
            align-items: center;
            padding: 6px 12px;
            border-radius: 20px;
            font-weight: 500;
            font-size: 14px;
        }

        .status-valid {
            background-color: #e6f7eb;
            color: #28a745;
        }

        .status-expiring {
            background-color: #fff3cd;
            color: #ffc107;
        }

        .status-expired {
            background-color: #ffebee;
            color: #dc3545;
        }

        /* License Info */
        .license-info {
            display: flex;
            flex-wrap: wrap;
            gap: 20px;
            margin-bottom: 20px;
        }

        .license-info > div {
            flex: 1;
            min-width: 250px;
        }

        .info-group {
            margin-bottom: 15px;
        }

        .info-label {
            font-size: 14px;
            color: #666;
            margin-bottom: 5px;
        }

        .info-value {
            font-size: 16px;
            color: #333;
            font-weight: 500;
        }

        /* License Status Section */
        .license-status-section {
            background-color: #f9f9f9;
            border-radius: 6px;
            padding: 15px;
            margin-bottom: 20px;
        }

        /* License Validity */
        .validity-section {
            margin-bottom: 20px;
        }

        .validity-text {
            margin-bottom: 10px;
        }

        .validity-progress {
            margin-top: 10px;
        }

        .progress-bar {
            height: 8px;
            background-color: #eee;
            border-radius: 4px;
            overflow: hidden;
            margin-bottom: 8px;
        }

        .progress-fill {
            height: 100%;
            border-radius: 4px;
            transition: width 0.3s ease;
        }

        .progress-labels {
            display: flex;
            justify-content: space-between;
            font-size: 12px;
            color: #666;
        }

        /* License Images */
        .license-images {
            display: flex;
            flex-wrap: wrap;
            gap: 20px;
            margin-bottom: 20px;
        }

        .image-container {
            flex: 1;
            min-width: 250px;
        }

        .image-container h4 {
            margin-top: 0;
            margin-bottom: 10px;
            color: #333;
            font-size: 16px;
        }

        .license-image {
            width: 100%;
            border-radius: 6px;
            border: 1px solid #e5e5e5;
            object-fit: cover;
            max-height: 200px;
        }

        .no-image {
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            height: 200px;
            background-color: #f5f5f5;
            border-radius: 6px;
            border: 1px dashed #ccc;
            color: #999;
            text-align: center;
        }

        .no-image i {
            font-size: 40px;
            margin-bottom: 10px;
        }

        /* License Actions */
        .license-actions {
            display: flex;
            gap: 15px;
            margin-top: 30px;
        }

        .btn-primary {
            background-color: #3366ff;
            color: white;
            border: none;
            border-radius: 4px;
            padding: 10px 20px;
            font-size: 14px;
            cursor: pointer;
            text-decoration: none;
            display: inline-flex;
            align-items: center;
        }

        .btn-outline {
            background-color: transparent;
            color: #3366ff;
            border: 1px solid #3366ff;
            border-radius: 4px;
            padding: 10px 20px;
            font-size: 14px;
            cursor: pointer;
            text-decoration: none;
            display: inline-flex;
            align-items: center;
        }

        /* Responsive Adjustments */
        @media (max-width: 992px) {
            .sidebar {
                width: 70px;
            }
            
            .sidebar-menu-item span,
            .sidebar-heading {
                display: none;
            }
            
            .sidebar-menu-item i {
                margin-right: 0;
            }
            
            .sidebar-menu-item {
                justify-content: center;
                padding: 14px 0;
            }
            
            .main-content {
                margin-left: 70px;
                width: calc(100% - 70px);
            }
            
            .sidebar.expanded {
                width: 240px;
            }
            
            .sidebar.expanded .sidebar-menu-item span,
            .sidebar.expanded .sidebar-heading {
                display: block;
            }
            
            .sidebar.expanded .sidebar-menu-item {
                justify-content: flex-start;
                padding: 10px 20px;
            }
            
            .sidebar.expanded .sidebar-menu-item i {
                margin-right: 24px;
            }
        }

        @media (max-width: 768px) {
            .license-info,
            .license-images {
                flex-direction: column;
            }
            
            .header-search {
                max-width: 300px;
            }
            
            .header-user-name {
                display: none;
            }
        }

        @media (max-width: 576px) {
            .sidebar {
                transform: translateX(-100%);
                width: 240px;
            }
            
            .sidebar.expanded {
                transform: translateX(0);
            }
            
            .sidebar.expanded .sidebar-menu-item span,
            .sidebar.expanded .sidebar-heading {
                display: block;
            }
            
            .sidebar.expanded .sidebar-menu-item {
                justify-content: flex-start;
                padding: 10px 20px;
            }
            
            .sidebar.expanded .sidebar-menu-item i {
                margin-right: 24px;
            }
            
            .main-content {
                margin-left: 0;
                width: 100%;
            }
            
            .license-header {
                flex-direction: column;
                align-items: flex-start;
            }
            
            .license-status {
                margin-top: 10px;
            }
        }
    </style> 
</head>
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
    <!-- Dashboard Container -->
    <div class="dashboard-container">
        <!-- Sidebar -->
        <div class="sidebar" id="sidebar">
            <div class="sidebar-menu">
                <a href="<?php echo e(route('customer.dashboard')); ?>" class="sidebar-menu-item active ">
                    <i class="fas fa-home"></i>
                    <span>Dashboard</span>
                </a>
                
                <a href="<?php echo e(route('customer.browse-cars')); ?>" class="sidebar-menu-item ">
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
                
                <a href="<?php echo e(route('customer.license')); ?>" class="sidebar-menu-item ">
                    <i class="fas fa-id-card"></i>
                    <span>Driving License</span>
                </a>
                
                <div class="sidebar-divider"></div>
                
                <div class="sidebar-heading">Services</div>
                
                <a href="<?php echo e(route('customer.locations')); ?>" class="sidebar-menu-item ">
                    <i class="fas fa-map-marked-alt"></i>
                    <span>Locations</span>
                </a>
                
                <a href="<?php echo e(route('customer.insurance-options')); ?>" class="sidebar-menu-item ">
                    <i class="fas fa-shield-alt"></i>
                    <span>Insurance Options</span>
                </a>
                
                <a href="<?php echo e(route('customer.fuel-policy')); ?>" class="sidebar-menu-item ">
                    <i class="fas fa-gas-pump"></i>
                    <span>Fuel Policy</span>
                </a>
                
                
            </div>
        </div>
        
        <!-- Main Content -->
        <div class="main-content" id="mainContent">
            <div class="welcome-card">
                <h2>Welcome to Your Car Rental Dashboard</h2>
                <?php if(Auth::guard('customer')->check()): ?>
                    <p>Hello, <?php echo e(Auth::guard('customer')->user()->name); ?>! Here's a summary of your rental activities.</p>
                <?php else: ?>
                    <p>Hello, Guest! Please log in to access your car rental dashboard.</p>
                <?php endif; ?>
            </div>
            
            <!-- Current Rental -->
            <div class="current-rental">
                <h3>Your Current Rental</h3>
                
                <?php
                // Get the current authenticated customer ID
                $customerId = Auth::guard('customer')->id();
                
                try {
                    // Get current confirmed rental for this customer
                    // Note: We're not joining with locations table as it doesn't exist
                    $currentRental = DB::table('car_bookings')
                        ->join('car_details_tbl', 'car_bookings.car_id', '=', 'car_details_tbl.id')
                        ->select(
                            'car_bookings.id as booking_id',
                            'car_bookings.pickup_datetime',
                            'car_bookings.dropoff_datetime',
                            'car_bookings.pickup_location',  // This is a string value, not a foreign key
                            'car_bookings.dropoff_location', // This is a string value, not a foreign key
                            'car_details_tbl.maker',
                            'car_details_tbl.model',
                            'car_details_tbl.vehicle_type',
                            'car_details_tbl.car_image',
                            'car_details_tbl.number_of_doors',
                            'car_details_tbl.number_of_seats',
                            'car_details_tbl.transmission_type',
                            'car_details_tbl.fuel_type',
                            'car_details_tbl.air_conditioning'
                        )
                        ->where('car_bookings.customer_id', $customerId)
                        ->where('car_bookings.status', 'confirmed')
                        ->whereDate('car_bookings.dropoff_datetime', '>=', now())
                        ->orderBy('car_bookings.pickup_datetime', 'asc')
                        ->first();
                } catch (\Exception $e) {
                    $currentRental = null;
                }
                ?>
                
                <?php if($currentRental): ?>
                    <div class="rental-details">
                        <div class="car-image">
                            <?php if($currentRental->car_image): ?>
                                <img src="<?php echo e(asset($currentRental->car_image)); ?>" alt="<?php echo e($currentRental->maker); ?> <?php echo e($currentRental->model); ?>">
                            <?php else: ?>
                                <img src="/api/placeholder/600/350" alt="<?php echo e($currentRental->maker); ?> <?php echo e($currentRental->model); ?>">
                            <?php endif; ?>
                        </div>
                        
                        <div class="rental-info">
                            <h4><?php echo e($currentRental->maker); ?> <?php echo e($currentRental->model); ?></h4>
                            
                            <div class="rental-info-row">
                                <div class="rental-info-label">Rental ID:</div>
                                <div>RNT-<?php echo e(str_pad($currentRental->booking_id, 5, '0', STR_PAD_LEFT)); ?></div>
                            </div>
                            
                            <div class="rental-info-row">
                                <div class="rental-info-label">Pickup Date:</div>
                                <div><?php echo e(\Carbon\Carbon::parse($currentRental->pickup_datetime)->format('F d, Y')); ?></div>
                            </div>
                            
                            <div class="rental-info-row">
                                <div class="rental-info-label">Return Date:</div>
                                <div><?php echo e(\Carbon\Carbon::parse($currentRental->dropoff_datetime)->format('F d, Y')); ?></div>
                            </div>
                            
                            <div class="rental-info-row">
                                <div class="rental-info-label">Pickup Location:</div>
                                <div><?php echo e($currentRental->pickup_location); ?></div>
                            </div>
                            
                            <div class="rental-info-row">
                                <div class="rental-info-label">Return Location:</div>
                                <div><?php echo e($currentRental->dropoff_location); ?></div>
                            </div>
                            
                            <div class="rental-info-row">
                                <div class="rental-info-label">Vehicle Details:</div>
                                <div>
                                    <?php echo e($currentRental->vehicle_type); ?> | 
                                    <?php echo e($currentRental->number_of_seats); ?> seats | 
                                    <?php echo e($currentRental->transmission_type); ?> | 
                                    <?php echo e($currentRental->fuel_type); ?>

                                    <?php if($currentRental->air_conditioning == 'Yes'): ?>
                                    | A/C
                                    <?php endif; ?>
                                </div>
                            </div>
                            
                            
                            
                            
                        </div>
                    </div>
                <?php else: ?>
                    <div class="no-rental">
                        <p>You don't have any active rentals at the moment.</p>
                        <a href="<?php echo e(route('customer.browse-cars')); ?>" class="btn-browse">Browse Available Cars</a>
                    </div>
                <?php endif; ?>
            </div>
            
            <!-- Stats
            <div class="stats-grid">
                <div class="stat-card">
                    <div class="stat-number">1</div>
                    <div class="stat-label">Active Rentals</div>
                </div>
                
                <div class="stat-card">
                    <div class="stat-number">2</div>
                    <div class="stat-label">Upcoming Reservations</div>
                </div>
                
                <div class="stat-card">
                    <div class="stat-number">8</div>
                    <div class="stat-label">Completed Rentals</div>
                </div>
            </div> -->
            
            <!-- Rental History -->
            <div class="history-card">
                <h3>Recent Rental History</h3>
                
                <?php
                // Get the current authenticated customer ID
                $customerId = Auth::guard('customer')->id();
                
                try {
                    // Get rental history for this customer
                    $rentalHistory = DB::table('car_bookings')
                        ->join('car_details_tbl', 'car_bookings.car_id', '=', 'car_details_tbl.id')
                        ->select(
                            'car_bookings.id as booking_id',
                            'car_bookings.pickup_datetime',
                            'car_bookings.dropoff_datetime',
                            'car_bookings.status',
                            'car_details_tbl.maker',
                            'car_details_tbl.model',
                            'car_details_tbl.vehicle_type',
                            'car_details_tbl.price'
                        )
                        ->where('car_bookings.customer_id', $customerId)
                        ->orderBy('car_bookings.pickup_datetime', 'desc')
                        ->limit(5)
                        ->get();
                } catch (\Exception $e) {
                    $rentalHistory = collect([]);
                }
                ?>
                
                <div class="table-responsive">
                    <table class="rental-table">
                        <thead>
                            <tr>
                                <th>Rental ID</th>
                                <th>Car</th>
                                <th>Dates</th>
                                <th>Cost</th>
                                <th>Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if(count($rentalHistory) > 0): ?>
                                <?php $__currentLoopData = $rentalHistory; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $rental): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <tr>
                                        <td>RNT-<?php echo e(str_pad($rental->booking_id, 5, '0', STR_PAD_LEFT)); ?></td>
                                        <td><?php echo e($rental->maker); ?> <?php echo e($rental->model); ?></td>
                                        <td>
                                            <?php echo e(\Carbon\Carbon::parse($rental->pickup_datetime)->format('M d')); ?> - 
                                            <?php echo e(\Carbon\Carbon::parse($rental->dropoff_datetime)->format('M d, Y')); ?>

                                        </td>
                                        <td>
                                            <?php
                                                // Calculate the number of days between pickup and dropoff
                                                $pickupDate = \Carbon\Carbon::parse($rental->pickup_datetime);
                                                $dropoffDate = \Carbon\Carbon::parse($rental->dropoff_datetime);
                                                $days = $pickupDate->diffInDays($dropoffDate);
                                                // Calculate the total cost (days * daily price)
                                                $totalCost = $days * $rental->price;
                                                // Format as currency
                                                echo 'BTN ' . number_format($totalCost, 2);
                                            ?>
                                        </td>
                                        <td>
                                            <?php if($rental->status == 'confirmed' && \Carbon\Carbon::parse($rental->dropoff_datetime) >= now()): ?>
                                                <span class="badge" style="background-color: #10b981; color: white; padding: 5px 10px; border-radius: 12px;">Active</span>
                                            <?php elseif($rental->status == 'confirmed' && \Carbon\Carbon::parse($rental->dropoff_datetime) < now()): ?>
                                                <span class="badge" style="background-color: #3b82f6; color: white; padding: 5px 10px; border-radius: 12px;">Completed</span>
                                            <?php elseif($rental->status == 'completed'): ?>
                                                <span class="badge" style="background-color: #3b82f6; color: white; padding: 5px 10px; border-radius: 12px;">Completed</span>
                                            <?php elseif($rental->status == 'cancelled'): ?>
                                                <span class="badge" style="background-color: #ef4444; color: white; padding: 5px 10px; border-radius: 12px;">Cancelled</span>
                                            <?php elseif($rental->status == 'pending'): ?>
                                                <span class="badge" style="background-color: #f59e0b; color: white; padding: 5px 10px; border-radius: 12px;">Pending</span>
                                            <?php elseif($rental->status == 'pending_verification'): ?>
                                                <span class="badge" style="background-color: #f97316; color: white; padding: 5px 10px; border-radius: 12px;">Pending Verification</span>
                                            <?php else: ?>
                                                <span class="badge" style="background-color: #6b7280; color: white; padding: 5px 10px; border-radius: 12px;"><?php echo e(ucfirst($rental->status)); ?></span>
                                            <?php endif; ?>
                                        </td>
                                    </tr>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            <?php else: ?>
                                <tr>
                                    <td colspan="5" class="no-rentals">No rental history found.</td>
                                </tr>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>
                
                <?php if(count($rentalHistory) > 0): ?>
                    <div class="view-all">
                        <a href="<?php echo e(route('customer.rental-history')); ?>" class="btn-view-all">View All History</a>
                    </div>
                <?php endif; ?>
            </div>
            
            <!-- Recommended Cars -->
            <div class="recommended-cars-section">
                <h3>Recommended For You</h3>
                
                <?php if(isset($recommendedCars) && $recommendedCars->count() > 0): ?>
                    <div class="cars-grid">
                        <?php $__currentLoopData = $recommendedCars; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $car): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <div class="car-card">
                            <div class="car-status">Available</div>
                            <div class="car-image">
                                <?php if($car->car_image): ?>
                                    <img src="<?php echo e(asset($car->car_image)); ?>" alt="<?php echo e($car->model); ?>" >
                                <?php else: ?>
                                   <img src="<?php echo e(asset('carimage/defaultcar.jpg')); ?>" alt="Car Image">
                                <?php endif; ?>
                            </div>
                            
                            <div class="car-info">
                                <h4><?php echo e($car->maker); ?> <?php echo e($car->model); ?></h4>
                                <div class="car-specs">
                                    <span><i class="fas fa-gas-pump"></i> <?php echo e($car->fuel_type); ?></span>
                                    <span><i class="fas fa-cog"></i> <?php echo e($car->transmission_type); ?></span>
                                    <span><i class="fas fa-users"></i> <?php echo e($car->number_of_seats); ?> seats</span>
                                </div>
                                <div class="car-price">BTN <?php echo e(number_format($car->price, 2)); ?>/day</div>
                                <a href="<?php echo e(route('customer.car-details', $car->id)); ?>" class="btn btn-primary">View Details</a>

                                <a href="<?php echo e(route('customer.book-car', $car->id)); ?>" class="btn-book-now">Book Now</a>
                            </div>
                        </div>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </div>
                <?php else: ?>
                    <div class="alert alert-info">
                        No available cars at the moment. Please check back later.
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </div>

    <!-- Bootstrap JS and jQuery -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
    
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Toggle sidebar
            const sidebarToggle = document.getElementById('sidebarToggle');
            const sidebar = document.getElementById('sidebar');
            const mainContent = document.getElementById('mainContent');
            
            sidebarToggle.addEventListener('click', function() {
                sidebar.classList.toggle('show');
                mainContent.classList.toggle('main-content-expanded');
            });
            
            // Close sidebar when clicking outside on mobile
            document.addEventListener('click', function(event) {
                const isClickInsideSidebar = sidebar.contains(event.target);
                const isClickOnToggle = sidebarToggle.contains(event.target);
                
                if (!isClickInsideSidebar && !isClickOnToggle && window.innerWidth < 992 && sidebar.classList.contains('show')) {
                    sidebar.classList.remove('show');
                }
            });
            
            // Adjust layout on window resize
            window.addEventListener('resize', function() {
                if (window.innerWidth >= 992) {
                    sidebar.classList.remove('show');
                    mainContent.classList.remove('main-content-expanded');
                }
            });
            
            // Handle Extend Rental button click
            const extendButtons = document.querySelectorAll('.btn-extend');
            extendButtons.forEach(button => {
                button.addEventListener('click', function() {
                    const bookingId = this.getAttribute('data-booking-id');
                    window.location.href = `/customer/extend-rental/${bookingId}`;
                });
            });
            
            // Handle Early Return button click
            const returnButtons = document.querySelectorAll('.btn-return');
            returnButtons.forEach(button => {
                button.addEventListener('click', function() {
                    const bookingId = this.getAttribute('data-booking-id');
                    if (confirm('Are you sure you want to return this vehicle early?')) {
                        window.location.href = `/customer/early-return/${bookingId}`;
                    }
                });
            });
        });
    </script>
</body>
</html>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\Sangay Ngedup\Documents\GitHub\FinalProject\resources\views/customer/dashboard.blade.php ENDPATH**/ ?>