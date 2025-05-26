
<?php $__env->startSection('content'); ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reservation Details - Car Rental</title>
    <!-- Link to the external CSS file -->
    <link rel="stylesheet" href="<?php echo e(asset('assets/css/customer/dashboard.css')); ?>">
<!-- Bootstrap CSS -->
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
<!-- Font Awesome -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

<style>
    .reservation-details-card {
        background-color: #fff;
        border-radius: 10px;
        box-shadow: 0 2px 15px rgba(0, 0, 0, 0.05);
        margin-bottom: 30px;
        overflow: hidden;
    }
    
    .reservation-header {
        display: flex;
        align-items: center;
        justify-content: space-between;
        padding: 20px 25px;
        background-color: #f8f9fa;
        border-bottom: 1px solid #eee;
    }
    
    .reservation-id {
        font-weight: 600;
        font-size: 1.25rem;
        color: #333;
    }
    
    .reservation-status {
        padding: 6px 15px;
        border-radius: 20px;
        font-size: 0.9rem;
        font-weight: 500;
    }
    
    .status-active, .status-confirmed {
        background-color: #e3f2fd;
        color: #1976d2;
    }
    
    .status-pending {
        background-color: #fff8e1;
        color: #ff8f00;
    }
    
    .status-completed {
        background-color: #e8f5e9;
        color: #388e3c;
    }
    
    .status-cancelled {
        background-color: #ffebee;
        color: #d32f2f;
    }
    
    .car-details-section {
        display: flex;
        padding: 25px;
        border-bottom: 1px solid #eee;
        flex-wrap: wrap;
    }
    
    .car-image-container {
        width: 300px;
        flex-shrink: 0;
        margin-right: 30px;
        margin-bottom: 20px;
    }
    
    .car-image-container img {
        width: 100%;
        height: auto;
        border-radius: 8px;
        box-shadow: 0 3px 10px rgba(0, 0, 0, 0.1);
    }
    
    .car-info {
        flex: 1;
        min-width: 280px;
    }
    
    .car-name {
        font-size: 1.6rem;
        font-weight: 600;
        margin-bottom: 15px;
        color: #333;
    }
    
    .car-specs {
        display: flex;
        flex-wrap: wrap;
        margin-bottom: 20px;
        gap: 15px;
    }
    
    .car-spec-item {
        background-color: #f8f9fa;
        padding: 8px 15px;
        border-radius: 20px;
        font-size: 0.9rem;
        color: #555;
        display: flex;
        align-items: center;
    }
    
    .car-spec-item i {
        margin-right: 8px;
        color: #4B89DC;
    }
    
    .detail-section {
        padding: 25px;
        border-bottom: 1px solid #eee;
    }
    
    .section-title {
        font-size: 1.25rem;
        font-weight: 600;
        margin-bottom: 20px;
        color: #333;
        display: flex;
        align-items: center;
    }
    
    .section-title i {
        margin-right: 10px;
        color: #4B89DC;
    }
    
    .detail-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
        gap: 20px;
    }
    
    .detail-item {
        margin-bottom: 15px;
    }
    
    .detail-label {
        color: #666;
        font-weight: 500;
        margin-bottom: 5px;
    }
    
    .detail-value {
        color: #333;
        font-weight: 600;
    }
    
    .price-breakdown {
        background-color: #f8f9fa;
        border-radius: 8px;
        padding: 20px;
    }
    
    .price-item {
        display: flex;
        justify-content: space-between;
        margin-bottom: 12px;
    }
    
    .price-total {
        display: flex;
        justify-content: space-between;
        margin-top: 15px;
        padding-top: 15px;
        border-top: 1px solid #ddd;
        font-weight: 600;
        font-size: 1.1rem;
    }
    
    .action-buttons {
        padding: 25px;
        display: flex;
        justify-content: space-between;
        align-items: center;
        background-color: #f8f9fa;
    }
    
    .action-buttons .btn {
        border-radius: 5px;
        padding: 10px 20px;
        font-weight: 500;
        margin-left: 10px;
    }
    
    .related-info {
        padding: 25px;
    }
    
    .info-card {
        background-color: #f8f9fa;
        border-radius: 8px;
        padding: 20px;
        margin-bottom: 20px;
    }
    
    .info-card-title {
        font-weight: 600;
        margin-bottom: 15px;
        color: #333;
        display: flex;
        align-items: center;
    }
    
    .info-card-title i {
        margin-right: 10px;
        color: #4B89DC;
    }
    
    .checklist {
        list-style-type: none;
        padding-left: 0;
    }
    
    .checklist-item {
        margin-bottom: 10px;
        display: flex;
        align-items: flex-start;
    }
    
    .checklist-item i {
        color: #4CAF50;
        margin-right: 10px;
        margin-top: 3px;
    }
    
    .timeline {
        position: relative;
        padding-left: 30px;
        margin-top: 25px;
    }
    
    .timeline::before {
        content: '';
        position: absolute;
        left: 7px;
        top: 5px;
        height: calc(100% - 10px);
        width: 2px;
        background-color: #ddd;
    }
    
    .timeline-item {
        position: relative;
        margin-bottom: 25px;
    }
    
    .timeline-item:last-child {
        margin-bottom: 0;
    }
    
    .timeline-point {
        position: absolute;
        left: -30px;
        top: 0;
        width: 16px;
        height: 16px;
        border-radius: 50%;
        background-color: #4B89DC;
    }
    
    .timeline-date {
        font-size: 0.9rem;
        color: #666;
        margin-bottom: 5px;
    }
    
    .timeline-content {
        background-color: #f8f9fa;
        padding: 15px;
        border-radius: 8px;
        border-left: 3px solid #4B89DC;
    }
    
    @media (max-width: 768px) {
        .car-image-container {
            width: 100%;
            margin-right: 0;
        }
        
        .action-buttons {
            flex-direction: column;
            gap: 15px;
            align-items: stretch;
        }
        
        .action-buttons .btn {
            margin-left: 0;
            margin-bottom: 10px;
        }
        
        .action-buttons .btn:last-child {
            margin-bottom: 0;
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
            
            <a href="<?php echo e(route('customer.my-reservations')); ?>" class="sidebar-menu-item active">
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
        <div class="page-heading">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <h2><i class="fas fa-calendar-alt"></i> Reservation Details</h2>
                    <p>Complete information about your car reservation.</p>
                </div>
                <div>
                    <a href="<?php echo e(route('customer.my-reservations')); ?>" class="btn btn-outline-primary">
                        <i class="fas fa-arrow-left"></i> Back to Reservations
                    </a>
                </div>
            </div>
        </div>
        
        <!-- Alert Messages -->
        <?php if(session('success')): ?>
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                <?php echo e(session('success')); ?>

                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        <?php endif; ?>
        
        <?php if(session('error')): ?>
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                <?php echo e(session('error')); ?>

                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        <?php endif; ?>
        
        <!-- Reservation Details -->
        <div class="reservation-details-card">
            <div class="reservation-header">
                <div class="reservation-id">Booking #<?php echo e($booking->id); ?></div>
                <div class="reservation-status status-<?php echo e(strtolower($booking->status)); ?>"><?php echo e(ucfirst($booking->status)); ?></div>
            </div>
            
            <!-- Car Details -->
            <div class="car-details-section">
                <div class="car-image-container">
                    <?php if($booking->car->car_image): ?>
                        <img src="<?php echo e(asset($booking->car->car_image)); ?>" alt="<?php echo e($booking->car->maker); ?> <?php echo e($booking->car->model); ?>" onerror="this.src='/api/placeholder/300/200';">
                    <?php else: ?>
                        <img src="/api/placeholder/300/200" alt="<?php echo e($booking->car->maker); ?> <?php echo e($booking->car->model); ?>">
                    <?php endif; ?>
                </div>
                <div class="car-info">
                    <div class="car-name"><?php echo e($booking->car->maker); ?> <?php echo e($booking->car->model); ?></div>
                    <div class="car-specs">
                        <div class="car-spec-item">
                            <i class="fas fa-car"></i>
                            <?php echo e($booking->car->vehicle_type); ?>

                        </div>
                        <div class="car-spec-item">
                            <i class="fas fa-user"></i>
                            <?php echo e($booking->car->number_of_seats); ?> Seats
                        </div>
                        <div class="car-spec-item">
                            <i class="fas fa-suitcase"></i>
                            <?php echo e($booking->car->large_bags_capacity + $booking->car->small_bags_capacity); ?> Luggage
                        </div>
                        <div class="car-spec-item">
                            <i class="fas fa-gas-pump"></i>
                            <?php echo e($booking->car->fuel_type); ?>

                        </div>
                        <div class="car-spec-item">
                            <i class="fas fa-cog"></i>
                            <?php echo e($booking->car->transmission_type); ?>

                        </div>
                        <div class="car-spec-item">
                            <i class="fas fa-snowflake"></i>
                            <?php echo e($booking->car->air_conditioning ? 'A/C' : 'No A/C'); ?>

                        </div>
                    </div>
                    
                    <p><?php echo e($booking->car->description); ?></p>
                </div>
            </div>
            
            <!-- Rental Details -->
            <div class="detail-section">
                <div class="section-title">
                    <i class="fas fa-info-circle"></i> Rental Information
                </div>
                <div class="detail-grid">
                    <div>
                        <div class="detail-item">
                            <div class="detail-label">Booking Date</div>
                            <div class="detail-value"><?php echo e(\Carbon\Carbon::parse($booking->created_at)->format('M d, Y - h:i A')); ?></div>
                        </div>
                        <div class="detail-item">
                            <div class="detail-label">Booking Status</div>
                            <div class="detail-value"><?php echo e(ucfirst($booking->status)); ?></div>
                        </div>
                        <div class="detail-item">
                            <div class="detail-label">Booking Reference</div>
                            <div class="detail-value"><?php echo e($booking->reference_number ?? 'CR-'.str_pad($booking->id, 6, '0', STR_PAD_LEFT)); ?></div>
                        </div>
                    </div>
                    <div>
                        <div class="detail-item">
                            <div class="detail-label">Pickup Date & Time</div>
                            <div class="detail-value"><?php echo e(\Carbon\Carbon::parse($booking->pickup_datetime)->format('M d, Y - h:i A')); ?></div>
                        </div>
                        <div class="detail-item">
                            <div class="detail-label">Return Date & Time</div>
                            <div class="detail-value"><?php echo e(\Carbon\Carbon::parse($booking->dropoff_datetime)->format('M d, Y - h:i A')); ?></div>
                        </div>
                        <div class="detail-item">
                            <div class="detail-label">Total Duration</div>
                            <div class="detail-value">
                                <?php
                                    $pickup = \Carbon\Carbon::parse($booking->pickup_datetime);
                                    $dropoff = \Carbon\Carbon::parse($booking->dropoff_datetime);
                                    
                                    // Get total hours first
                                    $totalHours = $pickup->diffInHours($dropoff);
                                    
                                    // Calculate days and remaining hours
                                    $days = floor($totalHours / 24);
                                    $remainingHours = $totalHours % 24;
                                    
                                    // Format the output
                                    $durationText = '';
                                    if ($days > 0) {
                                        $durationText .= $days . ' ' . ($days == 1 ? 'day' : 'days');
                                    }
                                    if ($remainingHours > 0) {
                                        $durationText .= ($days > 0 ? ' ' : '') . $remainingHours . ' ' . ($remainingHours == 1 ? 'hour' : 'hours');
                                    }
                                    // Edge case: if total duration is less than an hour
                                    if ($totalHours == 0) {
                                        $minutes = $pickup->diffInMinutes($dropoff);
                                        $durationText = $minutes . ' minutes';
                                    }
                                ?>
                                <?php echo e($durationText); ?>

                            </div>
                        </div>
                    </div>
                    <div>
                        <div class="detail-item">
                            <div class="detail-label">Pickup Location</div>
                            <div class="detail-value"><?php echo e($booking->pickup_location); ?></div>
                        </div>
                        <div class="detail-item">
                            <div class="detail-label">Return Location</div>
                            <div class="detail-value"><?php echo e($booking->dropoff_location); ?></div>
                        </div>
                        <div class="detail-item">
                            <div class="detail-label">Different Return Location</div>
                            <div class="detail-value"><?php echo e($booking->pickup_location !== $booking->dropoff_location ? 'Yes' : 'No'); ?></div>
                        </div>
                    </div>
                </div>
            </div>
            
            <!-- Payment Details -->
            <div class="detail-section">
                <div class="section-title">
                    <i class="fas fa-money-bill-wave"></i> Payment Information
                </div>
                <div class="row">
                    <div class="col-md-7">
                        <div class="detail-item">
                            <div class="detail-label">Payment Method</div>
                            <div class="detail-value"><?php echo e($booking->payments->first()->reference_number ?? 'N/A'); ?></div>
                        </div>
                        <div class="detail-item">
                            <div class="detail-label">Payment Status</div>
                            <div class="detail-value">
                                <?php
                                    $totalAmount = $booking->payments->sum('amount');
                                    $isPaid = $totalAmount > 0;
                                ?>
                                <?php echo e($isPaid ? 'Paid' : 'Pending Payment'); ?>

                            </div>
                        </div>
                        <?php if($booking->payLaterPayments && $booking->payLaterPayments->count() > 0): ?>
                        <div class="detail-item">
                            <div class="detail-label">Pay Later Status</div>
                            <div class="detail-value">
                                <?php echo e($booking->payLaterPayments->where('status', 'pending')->count() > 0 ? 'Pending Payments' : 'All Payments Complete'); ?>

                            </div>
                        </div>
                        <?php endif; ?>
                        
                        <?php if($booking->payments && $booking->payments->count() > 0): ?>
                        <div class="detail-item">
                            <div class="detail-label">Transaction ID</div>
                            <div class="detail-value"><?php echo e($booking->payments->first()->transaction_id ?? 'N/A'); ?></div>
                        </div>
                        <div class="detail-item">
                            <div class="detail-label">Payment Date</div>
                            <div class="detail-value">
                                <?php echo e($booking->payments->first() ? \Carbon\Carbon::parse($booking->payments->first()->created_at)->format('M d, Y - h:i A') : 'N/A'); ?>

                            </div>
                        </div>
                        <?php endif; ?>
                    </div>
                    <div class="col-md-5">
                        <div class="price-breakdown">
                            <h5 class="mb-3">Price Breakdown</h5>
                            
                            <!-- Rental Base Rate -->
                            <div class="price-item">
                                <div>Rental Rate (<?php echo e(\Carbon\Carbon::parse($booking->pickup_datetime)->diffInDays(\Carbon\Carbon::parse($booking->dropoff_datetime))); ?> days)</div>
                                <div>$<?php echo e(number_format($booking->base_price, 2)); ?></div>
                            </div>
                            
                            <!-- Additional Fees from booking table -->
                            <?php if($booking->insurance_fee > 0): ?>
                            <div class="price-item">
                                <div>Insurance</div>
                                <div>$<?php echo e(number_format($booking->insurance_fee, 2)); ?></div>
                            </div>
                            <?php endif; ?>
                            
                            <?php if($booking->additional_services_fee > 0): ?>
                            <div class="price-item">
                                <div>Additional Services</div>
                                <div>$<?php echo e(number_format($booking->additional_services_fee, 2)); ?></div>
                            </div>
                            <?php endif; ?>
                            
                            <?php if($booking->discount > 0): ?>
                            <div class="price-item">
                                <div>Discount</div>
                                <div>-$<?php echo e(number_format($booking->discount, 2)); ?></div>
                            </div>
                            <?php endif; ?>
                            
                            <?php if($booking->tax > 0): ?>
                            <div class="price-item">
                                <div>Tax</div>
                                <div>$<?php echo e(number_format($booking->tax, 2)); ?></div>
                            </div>
                            <?php endif; ?>
                            
                            <!-- Payment History from payments table -->
                            <?php if($booking->payments && $booking->payments->count() > 0): ?>
                            <div class="payment-history mt-4 mb-3">
                                <h6>Payment History</h6>
                                <?php $__currentLoopData = $booking->payments; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $payment): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <div class="price-item payment-item">
                                    <div>
                                        <?php echo e(ucfirst($payment->payment_method)); ?> 
                                        <small class="text-muted">
                                            (<?php echo e(\Carbon\Carbon::parse($payment->payment_date)->format('M d, Y')); ?>)
                                        </small>
                                    </div>
                                    <div>
                                        <span class="badge badge-<?php echo e($payment->status == 'completed' ? 'success' : 'warning'); ?>">
                                            <?php echo e(ucfirst($payment->status)); ?>

                                        </span>
                                        $<?php echo e(number_format($payment->amount, 2)); ?> <?php echo e($payment->currency); ?>

                                    </div>
                                </div>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </div>
                            <?php endif; ?>
                            
                            <!-- Total Amount -->
                            <div class="price-total">
                                <div>Total Amount</div>
                                <div>$<?php echo e(number_format($booking->total_amount, 2)); ?></div>
                            </div>
                            
                            <!-- Amount Paid from payments table -->
                            <div class="price-item">
                                <div>Amount Paid</div>
                                <div>BTN <?php echo e(number_format($booking->payments->where('status', 'completed')->sum('amount'), 2)); ?></div>
                            </div>
                            
                            <!-- Amount Due calculation -->
                            <?php
                                $amountPaid = $booking->payments->where('status', 'completed')->sum('amount');
                                $amountDue = $booking->total_amount - $amountPaid;
                            ?>
                            <?php if($amountDue > 0): ?>
                            <div class="price-item text-danger">
                                <div><strong>Amount Due</strong></div>
                                <div><strong>$<?php echo e(number_format($amountDue, 2)); ?></strong></div>
                            </div>
                            <?php endif; ?>
                            
                            <!-- Security Deposit -->
                            <?php if($booking->deposit > 0): ?>
                            <div class="price-item mt-3">
                                <div>Security Deposit (Refundable)</div>
                                <div>$<?php echo e(number_format($booking->deposit, 2)); ?></div>
                            </div>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
            </div>
            
            <!-- Additional Services -->
            <?php if(isset($booking->selected_services) && !empty($booking->selected_services)): ?>
            <div class="detail-section">
                <div class="section-title">
                    <i class="fas fa-concierge-bell"></i> Additional Services
                </div>
                <div class="row">
                    <?php
                        $services = is_array($booking->selected_services) ? $booking->selected_services : json_decode($booking->selected_services, true);
                    ?>
                    <?php $__currentLoopData = $services; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $service => $details): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <div class="col-md-4 mb-3">
                        <div class="card h-100">
                            <div class="card-body">
                                <h6 class="card-title"><?php echo e(ucfirst(str_replace('_', ' ', $service))); ?></h6>
                                <p class="card-text"><?php echo e($details['description'] ?? 'No description available'); ?></p>
                                <div class="text-muted">Price: $<?php echo e(number_format($details['price'] ?? 0, 2)); ?></div>
                            </div>
                        </div>
                    </div>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </div>
            </div>
            <?php endif; ?>
            
            <!-- Driver Information Section -->
            <div class="detail-section">
                <div class="section-title">
                    <i class="fas fa-user-circle"></i> Driver Information
                </div>
                <div class="row">
                    <!-- Left Column (5 items) -->
                    <div class="col-md-6">
                        <div class="detail-item">
                            <div class="detail-label">Driver Name</div>
                            <div class="detail-value"><?php echo e(Auth::guard('customer')->user()->name ?? 'Not provided'); ?></div>
                        </div>
                        <div class="detail-item">
                            <div class="detail-label">Email Address</div>
                            <div class="detail-value"><?php echo e(Auth::guard('customer')->user()->email ?? 'Not provided'); ?></div>
                        </div>
                        <div class="detail-item">
                            <div class="detail-label">Phone Number</div>
                            <div class="detail-value"><?php echo e(Auth::guard('customer')->user()->phone ?? 'Not provided'); ?></div>
                        </div>
                        <div class="detail-item">
                            <div class="detail-label">CID Number</div>
                            <div class="detail-value"><?php echo e(Auth::guard('customer')->user()->cid_no ?? 'Not provided'); ?></div>
                        </div>
                        <div class="detail-item">
                            <div class="detail-label">Gender</div>
                            <div class="detail-value"><?php echo e(Auth::guard('customer')->user()->gender ?? 'Not provided'); ?></div>
                        </div>
                    </div>
                    
                    <!-- Right Column (5 items) -->
                    <div class="col-md-6">
                        <div class="detail-item">
                            <div class="detail-label">License Number</div>
                            <div class="detail-value"><?php echo e($license->license_no ?? 'Not provided'); ?></div>
                        </div>
                        <div class="detail-item">
                            <div class="detail-label">Issuing Dzongkhag</div>
                            <div class="detail-value"><?php echo e($license->issuing_dzongkhag ?? 'Not provided'); ?></div>
                        </div>
                        <div class="detail-item">
                            <div class="detail-label">Issue Date</div>
                            <div class="detail-value">
                                <?php echo e($license->issue_date ? \Carbon\Carbon::parse($license->issue_date)->format('M d, Y') : 'Not provided'); ?>

                            </div>
                        </div>
                        <div class="detail-item">
                            <div class="detail-label">Expiry Date</div>
                            <div class="detail-value">
                                <?php echo e($license->expiry_date ? \Carbon\Carbon::parse($license->expiry_date)->format('M d, Y') : 'Not provided'); ?>

                            </div>
                        </div>
                        <div class="detail-item">
                            <div class="detail-label">Status</div>
                            <div class="detail-value"><?php echo e(ucfirst($license->status) ?? 'Not provided'); ?></div>
                        </div>
                    </div>
                </div>
                
                <!-- License Images Row -->
                <div class="row mt-4">
                    <!-- Left Column (License Front) -->
                    <div class="col-md-6">
                        <div class="detail-item">
                            <div class="detail-label">License Front Image</div>
                            <div class="detail-value">
                                <?php if($license && $license->license_front_image): ?>
                                    <div class="border" style="display: inline-block; margin-bottom: 5px;">
                                        <img src="<?php echo e(asset('licenses/' . basename($license->license_front_image))); ?>" 
                                            class="img-fluid license-image" 
                                            alt="License Front" 
                                            style="max-height: 300px; display: block;"
                                            onerror="this.onerror=null; this.parentNode.innerHTML='<div class=\'no-image\'><i class=\'fas fa-id-card\'></i><p>Front image not available</p></div>';">
                                    </div>
                                    <div>
                                        <a href="<?php echo e(asset('licenses/' . basename($license->license_front_image))); ?>" 
                                        class="btn btn-info" 
                                        style="background-color: #17a2b8; border: none; border-radius: 2px; padding: 6px 12px;"
                                        target="_blank">
                                            <i class="fas fa-search-plus"></i> View Full Size
                                        </a>
                                    </div>
                                <?php else: ?>
                                    <div class="no-image">
                                        <i class="fas fa-id-card"></i>
                                        <p>Front image not available</p>
                                    </div>
                                <?php endif; ?>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Right Column (License Back) -->
                    <div class="col-md-6">
                        <div class="detail-item">
                            <div class="detail-label">License Back Image</div>
                            <div class="detail-value">
                                <?php if($license && $license->license_back_image): ?>
                                    <div class="border" style="display: inline-block; margin-bottom: 5px;">
                                        <img src="<?php echo e(asset('licenses/' . basename($license->license_back_image))); ?>" 
                                            class="img-fluid license-image" 
                                            alt="License Back" 
                                            style="max-height: 300px; display: block;"
                                            onerror="this.onerror=null; this.parentNode.innerHTML='<div class=\'no-image\'><i class=\'fas fa-id-card\'></i><p>Back image not available</p></div>';">
                                    </div>
                                    <div>
                                        <a href="<?php echo e(asset('licenses/' . basename($license->license_back_image))); ?>" 
                                        class="btn btn-info" 
                                        style="background-color: #17a2b8; border: none; border-radius: 2px; padding: 6px 12px;"
                                        target="_blank">
                                            <i class="fas fa-search-plus"></i> View Full Size
                                        </a>
                                    </div>
                                <?php else: ?>
                                    <div class="no-image">
                                        <i class="fas fa-id-card"></i>
                                        <p>Back image not available</p>
                                    </div>
                                <?php endif; ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            
            <!-- Booking Timeline -->
            <div class="detail-section">
                <div class="section-title">
                    <i class="fas fa-history"></i> Booking Timeline
                </div>
                <div class="timeline">
                    <div class="timeline-item">
                        <div class="timeline-point"></div>
                        <div class="timeline-date"><?php echo e(\Carbon\Carbon::parse($booking->created_at)->format('M d, Y - h:i A')); ?></div>
                        <div class="timeline-content">
                            <strong>Booking Created</strong>
                            <p>Your reservation request was successfully submitted.</p>
                        </div>
                    </div>
                    
                    <?php if($booking->status !== 'pending'): ?>
                    <div class="timeline-item">
                        <div class="timeline-point"></div>
                        <div class="timeline-date"><?php echo e(\Carbon\Carbon::parse($booking->updated_at)->format('M d, Y - h:i A')); ?></div>
                        <div class="timeline-content">
                            <strong>Booking <?php echo e(ucfirst($booking->status)); ?></strong>
                            <p>Your reservation was <?php echo e(strtolower($booking->status)); ?>.</p>
                        </div>
                    </div>
                    <?php endif; ?>
                    
                    <?php if($booking->payments && $booking->payments->count() > 0): ?>
                    <div class="timeline-item">
                        <div class="timeline-point"></div>
                        <div class="timeline-date"><?php echo e(\Carbon\Carbon::parse($booking->payments->first()->created_at)->format('M d, Y - h:i A')); ?></div>
                        <div class="timeline-content">
                            <strong>Payment Received</strong>
                            <p>Payment of $<?php echo e(number_format($booking->payments->first()->amount, 2)); ?> was processed successfully.</p>
                        </div>
                    </div>
                    <?php endif; ?>
                    
                    <?php if($booking->status === 'active'): ?>
                    <div class="timeline-item">
                        <div class="timeline-point"></div>
                        <div class="timeline-date"><?php echo e(\Carbon\Carbon::parse($booking->pickup_datetime)->format('M d, Y - h:i A')); ?></div>
                        <div class="timeline-content">
                            <strong>Car Picked Up</strong>
                            <p>Vehicle was successfully picked up from <?php echo e($booking->pickup_location); ?>.</p>
                        </div>
                    </div>
                    <?php endif; ?>
                    
                    <?php if($booking->status === 'completed'): ?>
                    <div class="timeline-item">
                        <div class="timeline-point"></div>
                        <div class="timeline-date"><?php echo e(\Carbon\Carbon::parse($booking->pickup_datetime)->format('M d, Y - h:i A')); ?></div>
                        <div class="timeline-content">
                            <strong>Car Picked Up</strong>
                            <p>Vehicle was successfully picked up from <?php echo e($booking->pickup_location); ?>.</p>
                        </div>
                    </div>
                    
                    <div class="timeline-item">
                        <div class="timeline-point"></div>
                        <div class="timeline-date"><?php echo e(\Carbon\Carbon::parse($booking->dropoff_datetime)->format('M d, Y - h:i A')); ?></div>
                        <div class="timeline-content">
                            <strong>Car Returned</strong>
                            <p>Vehicle was successfully returned to <?php echo e($booking->dropoff_location); ?>.</p>
                        </div>
                    </div>
                    <?php endif; ?>
                    
                    <?php if($booking->status === 'cancelled'): ?>
                    <div class="timeline-item">
                        <div class="timeline-point"></div>
                        <div class="timeline-date"><?php echo e(\Carbon\Carbon::parse($booking->updated_at)->format('M d, Y - h:i A')); ?></div>
                        <div class="timeline-content">
                            <strong>Booking Cancelled</strong>
                            <p>Your reservation was cancelled.</p>
                            <?php if($booking->cancellation_reason): ?>
                                <p><strong>Reason:</strong> <?php echo e($booking->cancellation_reason); ?></p>
                            <?php endif; ?>
                        </div>
                    </div>
                    <?php endif; ?>
                    
                    <?php if($booking->refunds && $booking->refunds->count() > 0): ?>
                    <div class="timeline-item">
                        <div class="timeline-point"></div>
                        <div class="timeline-date"><?php echo e(\Carbon\Carbon::parse($booking->refunds->first()->created_at)->format('M d, Y - h:i A')); ?></div>
                        <div class="timeline-content">
                            <strong>Refund Processed</strong>
                            <p>Refund of $<?php echo e(number_format($booking->refunds->first()->amount, 2)); ?> was processed to your original payment method.</p>
                        </div>
                    </div>
                    <?php endif; ?>
                </div>
            </div>
            
            <!-- Pay Later Schedule (if applicable) -->
            <?php if($booking->payLaterPayments && $booking->payLaterPayments->count() > 0): ?>
            <div class="detail-section">
                <div class="section-title">
                    <i class="fas fa-calendar-check"></i> Pay Later Schedule
                </div>
                <div class="table-responsive">
                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <th>Payment Date</th>
                                <th>Amount</th>
                                <th>Status</th>
                                <th>Transaction ID</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php $__currentLoopData = $booking->payLaterPayments; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $payment): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <tr>
                                <td><?php echo e(\Carbon\Carbon::parse($payment->due_date)->format('M d, Y')); ?></td>
                                <td>$<?php echo e(number_format($payment->amount, 2)); ?></td>
                                <td>
                                    <?php if($payment->status == 'paid'): ?>
                                        <span class="badge bg-success">Paid</span>
                                    <?php elseif($payment->status == 'pending'): ?>
                                        <span class="badge bg-warning text-dark">Pending</span>
                                    <?php elseif($payment->status == 'overdue'): ?>
                                        <span class="badge bg-danger">Overdue</span>
                                    <?php endif; ?>
                                </td>
                                <td><?php echo e($payment->transaction_id ?? 'N/A'); ?></td>
                                <td>
                                    <?php if($payment->status == 'pending' || $payment->status == 'overdue'): ?>
                                        
                                    <?php endif; ?>
                                </td>
                            </tr>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </tbody>
                    </table>
                </div>
            </div>
            <?php endif; ?>
            
            <!-- Rental Instructions & Important Information -->
            <div class="related-info">
                <!-- Pickup Instructions -->
                <div class="info-card">
                    <div class="info-card-title">
                        <i class="fas fa-car-side"></i> Pickup Instructions
                    </div>
                    <ul class="checklist">
                        <li class="checklist-item">
                            <i class="fas fa-check-circle"></i>
                            <span>Please arrive at the pickup location 30 minutes before your scheduled time.</span>
                        </li>
                        <li class="checklist-item">
                            <i class="fas fa-check-circle"></i>
                            <span>Bring your valid driver's license, the credit card used for the reservation, and your booking confirmation.</span>
                        </li>
                        <li class="checklist-item">
                            <i class="fas fa-check-circle"></i>
                            <span>Check the vehicle for any existing damages and make sure they are noted before leaving.</span>
                        </li>
                        <li class="checklist-item">
                            <i class="fas fa-check-circle"></i>
                            <span>Familiarize yourself with the vehicle's features before driving off.</span>
                        </li>
                    </ul>
                </div>
                
                <!-- Return Instructions -->
                <div class="info-card">
                    <div class="info-card-title">
                        <i class="fas fa-undo-alt"></i> Return Instructions
                    </div>
                    <ul class="checklist">
                        <li class="checklist-item">
                            <i class="fas fa-check-circle"></i>
                            <span>Return the vehicle on time to avoid late fees.</span>
                        </li>
                        <li class="checklist-item">
                            <i class="fas fa-check-circle"></i>
                            <span>The fuel tank should be at the same level as when you picked up the vehicle.</span>
                        </li>
                        <li class="checklist-item">
                            <i class="fas fa-check-circle"></i>
                            <span>Remove all personal belongings from the vehicle before returning.</span>
                        </li>
                        <li class="checklist-item">
                            <i class="fas fa-check-circle"></i>
                            <span>Check with the rental agent for a final inspection to avoid unexpected charges.</span>
                        </li>
                    </ul>
                </div>
                
                <!-- Cancellation Policy -->
                <div class="info-card">
                    <div class="info-card-title">
                        <i class="fas fa-ban"></i> Cancellation Policy
                    </div>
                    <p>To cancel or modify your reservation, please contact customer service as early as possible.</p>
                    <ul>
                        <li>Free cancellation up to 48 hours before pickup</li>
                        <li>50% refund for cancellations between 24-48 hours before pickup</li>
                        <li>No refund for cancellations less than 24 hours before pickup</li>
                        <li>No-shows will be charged the full reservation amount</li>
                    </ul>
                </div>
                
                <!-- Emergency Contact -->
                <div class="info-card">
                    <div class="info-card-title">
                        <i class="fas fa-phone-alt"></i> Emergency Contact
                    </div>
                    <p>If you encounter any issues during your rental period, please contact our 24/7 customer support:</p>
                    <p><strong>Emergency Hotline:</strong> +1-800-CAR-RENT (800-227-7368)</p>
                    <p><strong>Roadside Assistance:</strong> +1-888-555-0123</p>
                    <p><strong>Email:</strong> support@carrental.com</p>
                </div>
            </div>
            
            <!-- Action Buttons -->
            <div class="action-buttons">
                <div>
                    
                        <i class="fas fa-file-invoice"></i> Download Invoice
                    </a>
                    <a href="#" onclick="window.print()" class="btn btn-outline-secondary">
                        <i class="fas fa-print"></i> Print Details
                    </a>
                </div>
                <!-- <div>
                    <?php if($booking->status === 'confirmed'): ?>
                        
                            <i class="fas fa-edit"></i> Modify Reservation
                        </a>
                        
                            <?php echo csrf_field(); ?>
                            <button type="submit" class="btn btn-danger">
                                <i class="fas fa-times"></i> Cancel Reservation
                            </button>
                        </form>
                    <?php elseif($booking->status === 'completed'): ?>
                        
                            <i class="fas fa-star"></i> Leave Review
                        </a>
                    <?php endif; ?>
                </div> -->
            </div>
        </div>
        
        <!-- You might also like section -->
        <!-- <div class="section-title mt-4">
            <i class="fas fa-thumbs-up"></i> You might also like
        </div>
        
        <div class="row">
            <?php if(isset($similarCars) && count($similarCars) > 0): ?>
                <?php $__currentLoopData = $similarCars; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $car): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <div class="col-md-4 mb-4">
                    <div class="card">
                        <img src="<?php echo e($car->image_path ?? '/api/placeholder/300/200'); ?>" class="card-img-top" alt="<?php echo e($car->make); ?> <?php echo e($car->model); ?>">
                        <div class="card-body">
                            <h5 class="card-title"><?php echo e($car->make); ?> <?php echo e($car->model); ?></h5>
                            <p class="card-text"><?php echo e(Str::limit($car->description, 100)); ?></p>
                            <div class="d-flex justify-content-between align-items-center">
                                <span class="text-primary fw-bold">$<?php echo e(number_format($car->daily_rate, 2)); ?>/day</span>
                                <a href="<?php echo e(route('customer.car-details', $car->id)); ?>" class="btn btn-outline-primary btn-sm">View Details</a>
                            </div>
                        </div>
                    </div>
                </div>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            <?php else: ?>
                <div class="col-12">
                    <div class="alert alert-info">
                        No similar cars available at the moment.
                    </div>
                </div>
            <?php endif; ?>
        </div> -->
    </div>
</div>


<!-- Bootstrap JS Bundle with Popper -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>

<script>
    // Toggle sidebar
    document.getElementById('sidebarToggle').addEventListener('click', function() {
        document.getElementById('sidebar').classList.toggle('collapsed');
        document.querySelector('.main-content').classList.toggle('expanded');
    });
    
    // Add active class to current page in sidebar
    document.addEventListener('DOMContentLoaded', function() {
        const currentPath = window.location.pathname;
        const sidebarLinks = document.querySelectorAll('.sidebar-menu-item');
        
        sidebarLinks.forEach(link => {
            if (link.getAttribute('href') === currentPath) {
                link.classList.add('active');
            }
        });
    });
</script>
</body>
</html>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\Thinley Norbu\Documents\GitHub\FinalProject\resources\views/customer/reservation-details.blade.php ENDPATH**/ ?>