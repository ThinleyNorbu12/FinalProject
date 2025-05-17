

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
                <a href="#" class="sidebar-menu-item active">
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
                            
                            <div class="rental-info-row">
                                <div class="rental-info-label">Remaining Time:</div>
                                <div>
                                    <?php
                                        $now = \Carbon\Carbon::now();
                                        $endDate = \Carbon\Carbon::parse($currentRental->dropoff_datetime);
                                        $diff = $now->diff($endDate);
                                        
                                        if ($diff->days > 0) {
                                            echo $diff->days . ' days, ' . $diff->h . ' hours';
                                        } else {
                                            echo $diff->h . ' hours, ' . $diff->i . ' minutes';
                                        }
                                    ?>
                                </div>
                            </div>
                            
                            <div class="rental-actions">
                                <button class="btn-extend" data-booking-id="<?php echo e($currentRental->booking_id); ?>">Extend Rental</button>
                                <button class="btn-return" data-booking-id="<?php echo e($currentRental->booking_id); ?>">Early Return</button>
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

            
            <!-- Stats -->
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
                
                <div class="stat-card">
                    <div class="stat-number">850</div>
                    <div class="stat-label">Loyalty Points</div>
                </div>
            </div>
            
            <!-- Rental History -->
            <!-- Rental History Component -->
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
                                            echo '$' . number_format($totalCost, 2);
                                        ?>
                                    </td>
                                    <td>
                                        <?php if($rental->status == 'confirmed' && \Carbon\Carbon::parse($rental->dropoff_datetime) >= now()): ?>
                                            <span class="badge badge-active">Active</span>
                                        <?php elseif($rental->status == 'confirmed' && \Carbon\Carbon::parse($rental->dropoff_datetime) < now()): ?>
                                            <span class="badge badge-completed">Completed</span>
                                        <?php elseif($rental->status == 'completed'): ?>
                                            <span class="badge badge-completed">Completed</span>
                                        <?php elseif($rental->status == 'cancelled'): ?>
                                            <span class="badge badge-cancelled">Cancelled</span>
                                        <?php elseif($rental->status == 'pending'): ?>
                                            <span class="badge badge-pending">Pending</span>
                                        <?php elseif($rental->status == 'pending_verification'): ?>
                                            <span class="badge badge-pending">Pending Verification</span>
                                        <?php else: ?>
                                            <span class="badge badge-<?php echo e($rental->status); ?>"><?php echo e(ucfirst($rental->status)); ?></span>
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
                
                <?php if(count($rentalHistory) > 0): ?>
                    <div class="view-all">
                        <a href="<?php echo e(route('customer.rental-history')); ?>" class="btn-view-all">View All History</a>
                    </div>
                <?php endif; ?>
            </div>
            
            <!-- Recommended Cars -->
            <!-- <div class="recommended-card">
                <h3>Recommended For You</h3>
                <?php if(isset($recommendedCars) && is_countable($recommendedCars) && count($recommendedCars) > 0): ?>
                    <div class="cars-grid">
                        <?php $__currentLoopData = $recommendedCars; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $car): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <div class="car-card-container">
                            <div class="car-status">Available</div>
                            <div class="car-card">
                                <?php if($car->car_image): ?>
                                    <img src="<?php echo e(asset('storage/' . $car->car_image)); ?>" alt="Car Image" style="width: 100px; height: auto;">
                                <?php else: ?>
                                    <img src="<?php echo e(asset('images/car-placeholder.png')); ?>" alt="<?php echo e($car->maker); ?> <?php echo e($car->model); ?>">
                                <?php endif; ?>
                                
                                <div class="car-details">
                                    <h4 class="car-title"><?php echo e($car->maker); ?> <?php echo e($car->model); ?></h4>
                                    
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
                                        <?php if(strtolower($car->air_conditioning) === 'yes'): ?>
                                            <span class="car-feature"><i class="fas fa-snowflake"></i> A/C</span>
                                        <?php endif; ?>
                                        
                                        <?php if(strtolower($car->backup_camera) === 'yes'): ?>
                                            <span class="car-feature"><i class="fas fa-camera"></i> Backup Camera</span>
                                        <?php endif; ?>
                                        
                                        <?php if(strtolower($car->bluetooth) === 'yes'): ?>
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
                        <p>No available cars at the moment. Please check back later.</p>
                    </div>
                <?php endif; ?>
            </div> -->
            <div class="recommended-cars-section">
                <h3>Recommended For You</h3>
                
                <?php if($recommendedCars->count() > 0): ?>
                    <div class="cars-grid">
                        <?php $__currentLoopData = $recommendedCars; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $car): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <div class="car-card">
                            <div class="car-status">Available</div>
                            <div class="car-image">
                                <?php if($car->car_image): ?>
                                    <img src="<?php echo e(asset($car->car_image)); ?>" alt="<?php echo e($car->model); ?>" >
                                <?php else: ?>
                                    <img src="<?php echo e(asset('images/car-placeholder.jpg')); ?>" alt="Car Image">
                                <?php endif; ?>
                            </div>
                            
                            <div class="car-info">
                                <h4><?php echo e($car->maker); ?> <?php echo e($car->model); ?></h4>
                                <div class="car-specs">
                                    <span><i class="fas fa-gas-pump"></i> <?php echo e($car->fuel_type); ?></span>
                                    <span><i class="fas fa-cog"></i> <?php echo e($car->transmission_type); ?></span>
                                    <span><i class="fas fa-users"></i> <?php echo e($car->number_of_seats); ?> seats</span>
                                </div>
                                <div class="car-price">$<?php echo e(number_format($car->price, 2)); ?>/day</div>
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

    <script>
document.addEventListener('DOMContentLoaded', function() {
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
<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\Thinley Norbu\Documents\GitHub\FinalProject\resources\views/customer/dashboard.blade.php ENDPATH**/ ?>