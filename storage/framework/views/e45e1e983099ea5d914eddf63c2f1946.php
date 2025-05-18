

<?php $__env->startSection('content'); ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Rental History - Car Rental</title>
    <!-- Link to the external CSS file -->
    <!-- <link rel="stylesheet" href="<?php echo e(asset('assets/css/customer/dashboard.css')); ?>"> -->

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    
    <style>
        /* Base styles */
        * {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
        }

        body {
            font-family: 'Roboto', Arial, sans-serif;
            background-color: #f9f9f9;
            margin: 0;
            padding: 0;
            overflow-x: hidden;
        }

        /* Dashboard Container */
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
            transition: all 0.3s ease;
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
            /* color: #3366ff;
            border-left: 3px solid #3366ff; */
        }

        .sidebar-menu-item i {
            font-size: 18px;
            width: 24px;
            margin-right: 24px;
            color: #606060;
        }

        /* .sidebar-menu-item.active i {
            color: #3366ff;
        } */

        .sidebar-divider {
            height: 1px;
            background-color: #e5e5e5;
            margin: 10px 0;
        }

        .sidebar-heading {
            color: #606060;
            font-size: 12px;
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
            background: none;
            border: none;
            cursor: pointer;
            font-size: 20px;
            color: #606060;
            margin-right: 16px;
            display: none;
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
            text-decoration: none;
        }

        .btn-logout:hover {
            background-color: #2952cc;
        }

        /* Main Content */
        .main-content {
            margin-left: 240px;
            padding: 76px 20px 20px;
            min-height: 100vh;
            transition: all 0.3s ease;
            width: calc(100% - 240px); /* Ensure content fills available width */
        }

        /* Rental History Section */
        .rental-history-container {
            width: 100%;
            max-width: 1200px;
            margin: 0 auto;
        }

        .rental-history-container h2 {
            margin-bottom: 8px;
            font-size: 24px;
            color: #333;
        }

        .rental-history-container p {
            margin-bottom: 24px;
            color: #666;
        }

        .filter-controls {
            display: flex;
            align-items: center;
            margin-bottom: 20px;
            flex-wrap: wrap;
        }

        .filter-label {
            margin-right: 16px;
            font-weight: 500;
            color: #333;
        }

        .filter-buttons {
            display: flex;
            flex-wrap: wrap;
            gap: 8px;
        }

        .filter-btn {
            background-color: #f0f0f0;
            border: none;
            border-radius: 20px;
            padding: 6px 16px;
            cursor: pointer;
            transition: all 0.2s;
        }

        .filter-btn:hover {
            background-color: #e0e0e0;
        }

        .filter-btn.active {
            background-color: #3366ff;
            color: white;
        }

        /* Rental Card */
        .rental-card {
            background-color: white;
            border-radius: 8px;
            box-shadow: 0 2px 4px rgba(0,0,0,0.05);
            margin-bottom: 24px;
            overflow: hidden;
            width: 100%;
        }

        .rental-header {
            display: flex;
            justify-content: space-between;
            padding: 12px 16px;
            background-color: #f8f8f8;
            border-bottom: 1px solid #eee;
        }

        .rental-id {
            font-weight: 500;
            color: #333;
        }

        .rental-status {
            font-size: 14px;
            font-weight: 500;
            padding: 2px 10px;
            border-radius: 12px;
        }

        .status-completed {
            background-color: #e6f7e9;
            color: #28a745;
        }

        .status-active {
            background-color: #e3f2fd;
            color: #0d6efd;
        }

        .status-cancelled {
            background-color: #feecf0;
            color: #dc3545;
        }

        .status-pending {
            background-color: #fff3cd;
            color: #ffc107;
        }

        .rental-body {
            display: flex;
            padding: 20px;
            align-items: flex-start;
        }

        .rental-image {
            width: 220px;
            height: 150px;
            margin-right: 24px;
            overflow: hidden;
            border-radius: 6px;
            flex-shrink: 0;
        }

        .rental-image img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }

        .rental-details {
            flex: 1;
            display: flex;
            flex-direction: column;
            gap: 16px;
        }

        .car-name {
            font-size: 20px;
            font-weight: 600;
            margin-bottom: 12px;
            color: #333;
        }

        .rental-info-grid {
            display: grid;
            grid-template-columns: repeat(2, 1fr);
            gap: 16px;
            width: 100%;
        }

        .rental-info-label {
            font-size: 14px;
            color: #666;
            margin-bottom: 4px;
        }

        .rental-info-value {
            font-weight: 500;
            color: #333;
        }

        .payment-info, .pay-later-section {
            background-color: #f9f9f9;
            padding: 14px;
            border-radius: 6px;
            width: 100%;
            font-size: 14px;
        }

        .payment-info-title {
            font-weight: 500;
            margin-bottom: 8px;
            color: #333;
        }

        .payment-status {
            display: inline-block;
            padding: 2px 8px;
            border-radius: 10px;
            font-size: 12px;
            margin-top: 4px;
        }

        .rental-footer {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 12px 16px;
            background-color: #f8f8f8;
            border-top: 1px solid #eee;
        }

        .rental-price {
            font-size: 18px;
            font-weight: 600;
            color: #333;
        }

        .rental-actions {
            display: flex;
            gap: 10px;
        }

        .btn-primary {
            background-color: #3366ff;
            color: white;
            border: none;
            border-radius: 4px;
            padding: 8px 16px;
            cursor: pointer;
            font-size: 14px;
            text-decoration: none;
        }

        .btn-secondary {
            background-color: #f0f0f0;
            color: #333;
            border: none;
            border-radius: 4px;
            padding: 8px 16px;
            cursor: pointer;
            font-size: 14px;
            text-decoration: none;
        }

        .btn-primary:hover {
            background-color: #2952cc;
        }

        .btn-secondary:hover {
            background-color: #e0e0e0;
        }

        /* No rentals state */
        .no-rentals {
            text-align: center;
            padding: 60px 20px;
            background-color: white;
            border-radius: 8px;
            box-shadow: 0 2px 4px rgba(0,0,0,0.05);
        }

        .no-rentals-icon {
            font-size: 60px;
            color: #ccc;
            margin-bottom: 20px;
        }

        .no-rentals h3 {
            margin-bottom: 12px;
            color: #333;
        }

        .no-rentals p {
            color: #666;
            max-width: 500px;
            margin: 0 auto 20px;
        }

        /* Media queries for responsive design */
        @media (max-width: 992px) {
            .rental-info-grid {
                grid-template-columns: 1fr;
            }
        }

        @media (max-width: 768px) {
            .sidebar {
                transform: translateX(-100%);
                width: 260px;
            }
            
            .sidebar.expanded {
                transform: translateX(0);
            }
            
            .main-content {
                margin-left: 0;
                padding: 76px 16px 16px;
                width: 100%;
            }
            
            .header-menu-toggle {
                display: block;
            }
            
            .rental-body {
                flex-direction: column;
            }
            
            .rental-image {
                width: 100%;
                height: 180px;
                margin-right: 0;
                margin-bottom: 20px;
            }
            
            .rental-footer {
                flex-direction: column;
                gap: 12px;
                align-items: flex-start;
            }
            
            .rental-actions {
                width: 100%;
                justify-content: space-between;
            }
        }

        @media (max-width: 576px) {
            .main-header {
                padding: 0 8px;
            }
            
            .header-logo span {
                display: none;
            }
            
            .header-logo {
                margin-right: 16px;
            }
            
            .header-search {
                max-width: none;
            }
            
            .header-user-name {
                display: none;
            }
            
            .filter-controls {
                flex-direction: column;
                align-items: flex-start;
            }
            
            .filter-label {
                margin-bottom: 8px;
            }
            
            .rental-header {
                flex-direction: column;
                gap: 8px;
            }
            
            .rental-actions {
                flex-direction: column;
                gap: 8px;
            }
            
            .btn-primary, .btn-secondary {
                width: 100%;
                text-align: center;
            }
            
            .payment-info, .pay-later-section {
                padding: 8px;
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
                
                <a href="<?php echo e(route('customer.browse-cars')); ?>" class="sidebar-menu-item">
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
                
                <a href="<?php echo e(route('customer.rental-history')); ?>" class="sidebar-menu-item active">
                    <i class="fas fa-history"></i>
                    <span>Rental History</span>
                </a>
                
                <a href="<?php echo e(route('customer.payment-history')); ?>" class="sidebar-menu-item ">
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
            <div class="rental-history-container">
                <h2>Your Rental History</h2>
                <p>View all your past and current rentals in one place.</p>
                
                <div class="filter-controls">
                    <div class="filter-label">Filter by:</div>
                    <div class="filter-buttons">
                        <button class="filter-btn active" data-filter="all">All</button>
                        <button class="filter-btn" data-filter="active">Active</button>
                        <button class="filter-btn" data-filter="completed">Completed</button>
                        <button class="filter-btn" data-filter="cancelled">Cancelled</button>
                    </div>
                </div>
                
                <?php if(count($bookings) > 0): ?>
                    <?php $__currentLoopData = $bookings; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $booking): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <?php
                            $paymentInfo = $payments[$booking->id] ?? null;
                            $payLaterInfo = $payLaterPayments[$booking->id] ?? null;
                            
                            // Determine badge class based on status
                            $statusClass = '';
                            switch($booking->status) {
                                case 'completed':
                                    $statusClass = 'status-completed';
                                    break;
                                case 'active':
                                    $statusClass = 'status-active';
                                    break;
                                case 'cancelled':
                                    $statusClass = 'status-cancelled';
                                    break;
                                default:
                                    $statusClass = 'status-pending';
                            }
                        ?>
                        
                        <div class="rental-card rental-item" data-status="<?php echo e($booking->status); ?>">
                            <div class="rental-header">
                                <div class="rental-id">Booking #<?php echo e($booking->id); ?></div>
                                <div class="rental-status <?php echo e($statusClass); ?>"><?php echo e(ucfirst($booking->status)); ?></div>
                            </div>
                            
                            <div class="rental-body">
                                <div class="rental-image">
                                    <?php if(isset($booking->car_image) && !empty($booking->car_image)): ?>
                                        <img src="<?php echo e(asset($booking->car_image)); ?>" alt="Car Image">
                                    <?php else: ?>
                                        <img src="/api/placeholder/150/100" alt="Car Image">
                                    <?php endif; ?>
                                </div>
                                
                                <div class="rental-details">
                                    <?php if(isset($booking->car_name)): ?>
                                        <div class="car-name"><?php echo e($booking->car_name); ?></div>
                                    <?php else: ?>
                                        <div class="car-name">Vehicle Details Not Available</div>
                                    <?php endif; ?>
                                    
                                    <div class="rental-info-grid">
                                        <div class="rental-info-item">
                                            <div class="rental-info-label">Pickup Date</div>
                                            <div class="rental-info-value"><?php echo e(date('M d, Y H:i', strtotime($booking->pickup_datetime))); ?></div>
                                        </div>
                                        
                                        <div class="rental-info-item">
                                            <div class="rental-info-label">Return Date</div>
                                            <div class="rental-info-value"><?php echo e(date('M d, Y H:i', strtotime($booking->dropoff_datetime))); ?></div>
                                        </div>
                                        
                                        <div class="rental-info-item">
                                            <div class="rental-info-label">Pickup Location</div>
                                            <div class="rental-info-value"><?php echo e($booking->pickup_location); ?></div>
                                        </div>
                                        
                                        <div class="rental-info-item">
                                            <div class="rental-info-label">Return Location</div>
                                            <div class="rental-info-value"><?php echo e($booking->dropoff_location); ?></div>
                                        </div>
                                    </div>
                                    
                                    <?php if($paymentInfo): ?>
                                        <div class="payment-info">
                                            <div class="payment-info-title">Payment Information</div>
                                            <div>
                                                <strong>Method:</strong> <?php echo e($paymentInfo->payment_method); ?>

                                                <br>
                                                <strong>Amount:</strong> <?php echo e($paymentInfo->currency); ?> <?php echo e(number_format($paymentInfo->amount, 2)); ?>

                                                <br>
                                                <strong>Date:</strong> <?php echo e(date('M d, Y', strtotime($paymentInfo->payment_date))); ?>

                                                <br>
                                                <div class="payment-status <?php echo e($paymentInfo->status == 'paid' ? 'status-completed' : 'status-pending'); ?>">
                                                    <?php echo e(ucfirst($paymentInfo->status)); ?>

                                                </div>
                                            </div>
                                        </div>
                                    <?php endif; ?>
                                    
                                    <?php if($payLaterInfo && count($payLaterInfo) > 0): ?>
                                        <div class="pay-later-section">
                                            <div class="payment-info-title">Pay Later Information</div>
                                            <?php $__currentLoopData = $payLaterInfo; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $payLater): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                <div>
                                                    <strong>Collection Date:</strong> <?php echo e(date('M d, Y', strtotime($payLater->collection_date))); ?>

                                                    <br>
                                                    <strong>Status:</strong> <?php echo e(ucfirst($payLater->status)); ?>

                                                    <?php if($payLater->status == 'collected'): ?>
                                                        <br>
                                                        <strong>Collection Method:</strong> <?php echo e($payLater->collection_method); ?>

                                                    <?php endif; ?>
                                                </div>
                                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                        </div>
                                    <?php endif; ?>
                                </div>
                            </div>
                            
                            <div class="rental-footer">
                                <div class="rental-price">
                                    <?php if($paymentInfo): ?>
                                        <?php echo e($paymentInfo->currency); ?> <?php echo e(number_format($paymentInfo->amount, 2)); ?>

                                    <?php else: ?>
                                        Price information not available
                                    <?php endif; ?>
                                </div>
                                <div class="rental-actions">
                                    <?php if($booking->status == 'active'): ?>
                                        <button class="btn-primary">Extend Rental</button>
                                        <button class="btn-secondary">Return Car</button>
                                    <?php elseif($booking->status == 'completed'): ?>
                                        <button class="btn-primary">Book Again</button>
                                        <button class="btn-secondary">View Invoice</button>
                                    <?php endif; ?>
                                </div>
                            </div>
                        </div>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                <?php else: ?>
                    <div class="no-rentals">
                        <div class="no-rentals-icon">
                            <i class="fas fa-car"></i>
                        </div>
                        <h3>No rental history found</h3>
                        <p>You haven't rented any cars yet. Start your journey by browsing our collection.</p>
                        <a href="<?php echo e(route('customer.browse-cars')); ?>" class="btn-primary" style="display: inline-block; margin-top: 15px; padding: 10px 20px; text-decoration: none;">Browse Cars</a>
                    </div>
                <?php endif; ?>
            </div>
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
            
            // Filter functionality
            const filterButtons = document.querySelectorAll('.filter-btn');
            const rentalItems = document.querySelectorAll('.rental-item');
            
            filterButtons.forEach(button => {
                button.addEventListener('click', function() {
                    // Remove active class from all buttons
                    filterButtons.forEach(btn => btn.classList.remove('active'));
                    
                    // Add active class to clicked button
                    this.classList.add('active');
                    
                    const filterValue = this.getAttribute('data-filter');
                    
                    rentalItems.forEach(item => {
                        if (filterValue === 'all') {
                            item.style.display = 'block';
                        } else {
                            if (item.getAttribute('data-status') === filterValue) {
                                item.style.display = 'block';
                            } else {
                                item.style.display = 'none';
                            }
                        }
                    });
                });
            });
        });
    </script>
</body>
</html>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\Thinley Norbu\Documents\GitHub\FinalProject\resources\views/customer/rental-history.blade.php ENDPATH**/ ?>