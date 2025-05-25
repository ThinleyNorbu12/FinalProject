

<?php $__env->startSection('content'); ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Driving License - Car Rental</title>
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

/* Enhanced Responsive License Images Section */
.license-images {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
    gap: 2rem;
    margin: 2rem 0;
    padding: 1.5rem;
    background: #f8f9fa;
    border-radius: 12px;
    border: 1px solid #e9ecef;
}

.image-container {
    background: white;
    border-radius: 8px;
    padding: 1.5rem;
    box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
    transition: transform 0.3s ease, box-shadow 0.3s ease;
    position: relative;
}

.image-container:hover {
    transform: translateY(-2px);
    box-shadow: 0 4px 16px rgba(0, 0, 0, 0.15);
}

.image-container h4 {
    margin: 0 0 1rem 0;
    color: #2c3e50;
    font-size: 1.1rem;
    font-weight: 600;
    display: flex;
    align-items: center;
    gap: 0.5rem;
}

.image-container h4 i {
    color: #3498db;
    font-size: 1.2rem;
}

.license-image {
    width: 100%;
    height: auto;
    max-height: 400px;
    object-fit: contain;
    border-radius: 6px;
    border: 2px solid #e9ecef;
    background: #ffffff;
    cursor: pointer;
    transition: transform 0.3s ease;
}

.license-image:hover {
    transform: scale(1.02);
    border-color: #3498db;
}

.no-image {
    display: flex;
    flex-direction: column;
    align-items: center;
    justify-content: center;
    height: 200px;
    background: #f8f9fa;
    border: 2px dashed #dee2e6;
    border-radius: 6px;
    color: #6c757d;
    text-align: center;
}

.no-image i {
    font-size: 3rem;
    margin-bottom: 1rem;
    opacity: 0.5;
}

.no-image p {
    margin: 0;
    font-size: 0.9rem;
    font-weight: 500;
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

/* Image Modal/Zoom functionality */
.license-image.clickable {
    cursor: zoom-in;
}

.image-modal {
    position: fixed;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    background: rgba(0, 0, 0, 0.9);
    display: none;
    justify-content: center;
    align-items: center;
    z-index: 1000;
    padding: 2rem;
}

.image-modal.active {
    display: flex;
}

.modal-image {
    max-width: 90%;
    max-height: 90%;
    object-fit: contain;
    border-radius: 8px;
    box-shadow: 0 4px 20px rgba(0, 0, 0, 0.5);
}

.modal-close {
    position: absolute;
    top: 2rem;
    right: 2rem;
    background: white;
    border: none;
    border-radius: 50%;
    width: 40px;
    height: 40px;
    display: flex;
    align-items: center;
    justify-content: center;
    cursor: pointer;
    font-size: 1.2rem;
    color: #333;
    box-shadow: 0 2px 8px rgba(0, 0, 0, 0.3);
}

.modal-close:hover {
    background: #f8f9fa;
}

/* Loading state for images */
.license-image.loading {
    opacity: 0.6;
    filter: blur(1px);
}

.image-container.loading::after {
    content: '';
    position: absolute;
    top: 50%;
    left: 50%;
    width: 30px;
    height: 30px;
    margin: -15px 0 0 -15px;
    border: 3px solid #f3f3f3;
    border-top: 3px solid #3498db;
    border-radius: 50%;
    animation: spin 1s linear infinite;
}

@keyframes spin {
    0% { transform: rotate(0deg); }
    100% { transform: rotate(360deg); }
}

/* Badge Styles for License Status */
.badge {
    display: inline-flex;
    align-items: center;
    padding: 4px 8px;
    border-radius: 12px;
    font-size: 12px;
    font-weight: 500;
}

.bg-success {
    background-color: #d4edda;
    color: #155724;
}

.bg-warning {
    background-color: #fff3cd;
    color: #856404;
}

.bg-danger {
    background-color: #f8d7da;
    color: #721c24;
}

.bg-secondary {
    background-color: #e2e3e5;
    color: #383d41;
}

.bg-info {
    background-color: #d1ecf1;
    color: #0c5460;
}

/* Text Utility Classes */
.text-success {
    color: #28a745 !important;
}

.text-warning {
    color: #ffc107 !important;
}

.text-danger {
    color: #dc3545 !important;
}

/* Image Quality Warning */
.image-quality-warning {
    position: absolute;
    top: 10px;
    right: 10px;
    background: rgba(255, 193, 7, 0.9);
    color: #856404;
    padding: 4px 8px;
    border-radius: 4px;
    font-size: 12px;
    font-weight: 500;
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
    .license-info {
        flex-direction: column;
    }
    
    .license-images {
        grid-template-columns: 1fr;
        gap: 1.5rem;
        margin: 1.5rem 0;
        padding: 1rem;
    }
    
    .image-container {
        padding: 1rem;
    }
    
    .image-container h4 {
        font-size: 1rem;
        margin-bottom: 0.8rem;
    }
    
    .license-image {
        max-height: 300px;
    }
    
    .no-image {
        height: 150px;
    }
    
    .no-image i {
        font-size: 2rem;
        margin-bottom: 0.8rem;
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
    
    .license-images {
        margin: 1rem 0;
        padding: 0.8rem;
        gap: 1rem;
    }
    
    .image-container {
        padding: 0.8rem;
    }
    
    .image-container h4 {
        font-size: 0.9rem;
        gap: 0.3rem;
    }
    
    .license-image {
        max-height: 250px;
    }
    
    .no-image {
        height: 120px;
    }
    
    .no-image i {
        font-size: 1.5rem;
        margin-bottom: 0.5rem;
    }
    
    .no-image p {
        font-size: 0.8rem;
    }
}

@media (max-width: 480px) {
    .license-images {
        padding: 0.5rem;
        margin: 0.8rem 0;
    }
    
    .image-container {
        padding: 0.6rem;
    }
    
    .modal-close {
        top: 1rem;
        right: 1rem;
        width: 35px;
        height: 35px;
        font-size: 1rem;
    }
    
    .image-modal {
        padding: 1rem;
    }
}

/* Large screens - show images side by side with more space */
@media (min-width: 1200px) {
    .license-images {
        grid-template-columns: 1fr 1fr;
        gap: 3rem;
        padding: 2rem;
    }
    
    .image-container {
        padding: 2rem;
    }
    
    .license-image {
        max-height: 500px;
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
                
                <a href="<?php echo e(route('customer.license')); ?>" class="sidebar-menu-item active">
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
            <div class="welcome-card">
                <h2>Your Driving License</h2>
                <p>View and manage your driving license details for car rentals</p>
            </div>
            
            <?php if($license): ?>
                <?php
                    $today = \Carbon\Carbon::today();
                    $expiry = \Carbon\Carbon::parse($license->expiry_date);
                    $days_remaining = $today->diffInDays($expiry, false);
                    
                    if($days_remaining < 0) {
                        $status_class = 'status-expired';
                        $status_text = 'Expired';
                    } elseif($days_remaining <= 30) {
                        $status_class = 'status-expiring';
                        $status_text = 'Expiring Soon';
                    } else {
                        $status_class = 'status-valid';
                        $status_text = 'Valid';
                    }
                    
                    // Debug image paths
                    $front_image_path = $license->license_front_image; // Remove 'licenses/' prefix
                    $back_image_path = $license->license_back_image;   // Remove 'licenses/' prefix
                    $front_exists = $license->license_front_image && file_exists(public_path('licenses/' . $front_image_path));
                    $back_exists = $license->license_back_image && file_exists(public_path('licenses/' . $back_image_path));
                ?>
                
                <div class="license-header">
                    <div class="license-title">
                        <h2><i class="fas fa-id-card me-2"></i>Driving License Details</h2>
                        <p><i class="fas fa-hashtag me-1"></i>License #<?php echo e($license->license_no); ?></p>
                    </div>
                    <span class="license-status <?php echo e($status_class); ?>">
                        <?php if($days_remaining < 0): ?>
                            <i class="fas fa-times-circle me-1"></i>
                        <?php elseif($days_remaining <= 30): ?>
                            <i class="fas fa-exclamation-triangle me-1"></i>
                        <?php else: ?>
                            <i class="fas fa-check-circle me-1"></i>
                        <?php endif; ?>
                        <?php echo e($status_text); ?>

                    </span>
                </div>

                <div class="license-info">
                    <div>
                        <div class="info-group">
                            <div class="info-label"><i class="fas fa-user me-2"></i>Full Name</div>
                            <div class="info-value"><?php echo e($customer->name); ?></div>
                        </div>
                        
                        <div class="info-group">
                            <div class="info-label"><i class="fas fa-id-badge me-2"></i>CID Number</div>
                            <div class="info-value"><?php echo e($customer->cid_no); ?></div>
                        </div>
                        
                        <div class="info-group">
                            <div class="info-label"><i class="fas fa-birthday-cake me-2"></i>Date of Birth</div>
                            <div class="info-value"><?php echo e(\Carbon\Carbon::parse($customer->date_of_birth)->format('F d, Y')); ?></div>
                        </div>
                        
                        <div class="info-group">
                            <div class="info-label"><i class="fas fa-venus-mars me-2"></i>Gender</div>
                            <div class="info-value"><?php echo e($customer->gender ?? 'Not specified'); ?></div>
                        </div>
                    </div>
                    
                    <div>
                        <div class="info-group">
                            <div class="info-label"><i class="fas fa-id-card me-2"></i>License Number</div>
                            <div class="info-value"><?php echo e($license->license_no); ?></div>
                        </div>
                        
                        <div class="info-group">
                            <div class="info-label"><i class="fas fa-map-marker-alt me-2"></i>Issuing Dzongkhag</div>
                            <div class="info-value"><?php echo e($license->issuing_dzongkhag); ?></div>
                        </div>
                        
                        <div class="info-group">
                            <div class="info-label"><i class="fas fa-calendar-plus me-2"></i>Issue Date</div>
                            <div class="info-value"><?php echo e(\Carbon\Carbon::parse($license->issue_date)->format('F d, Y')); ?></div>
                        </div>
                        
                        <div class="info-group">
                            <div class="info-label"><i class="fas fa-calendar-times me-2"></i>Expiry Date</div>
                            <div class="info-value"><?php echo e(\Carbon\Carbon::parse($license->expiry_date)->format('F d, Y')); ?></div>
                        </div>
                    </div>
                </div>

                <!-- License Status -->
                <div class="license-status-section">
                    <div class="info-group">
                        <div class="info-label"><i class="fas fa-check-square me-2"></i>License Status</div>
                        <div class="info-value">
                            <?php
                                $statusBadgeClass = '';
                                $statusIcon = '';
                                
                                switch($license->status) {
                                    case 'active':
                                        $statusBadgeClass = 'badge bg-success';
                                        $statusIcon = 'fa-check-circle';
                                        break;
                                    case 'pending':
                                        $statusBadgeClass = 'badge bg-warning';
                                        $statusIcon = 'fa-clock';
                                        break;
                                    case 'rejected':
                                        $statusBadgeClass = 'badge bg-danger';
                                        $statusIcon = 'fa-times-circle';
                                        break;
                                    case 'expired':
                                        $statusBadgeClass = 'badge bg-danger';
                                        $statusIcon = 'fa-calendar-times';
                                        break;
                                    case 'suspended':
                                        $statusBadgeClass = 'badge bg-secondary';
                                        $statusIcon = 'fa-ban';
                                        break;
                                    default:
                                        $statusBadgeClass = 'badge bg-info';
                                        $statusIcon = 'fa-info-circle';
                                }
                            ?>
                            
                            <span class="<?php echo e($statusBadgeClass); ?>">
                                <i class="fas <?php echo e($statusIcon); ?> me-1"></i>
                                <?php echo e(ucfirst($license->status)); ?>

                            </span>
                        </div>
                    </div>
                </div>

                <!-- Validity Progress Bar -->
                <div class="validity-section">
                    <div class="info-group">
                        <div class="info-label"><i class="fas fa-clock me-2"></i>License Validity</div>
                        <div class="info-value">
                            <?php
                                // Calculate total validity period in days
                                $issue_date = \Carbon\Carbon::parse($license->issue_date);
                                $expiry_date = \Carbon\Carbon::parse($license->expiry_date);
                                $total_validity_days = $issue_date->diffInDays($expiry_date);
                                
                                // Calculate days used and remaining
                                $days_used = $issue_date->diffInDays($today);
                                $percentage_used = $total_validity_days > 0 ? min(100, max(0, ($days_used / $total_validity_days) * 100)) : 100;
                                $percentage_remaining = 100 - $percentage_used;
                            ?>
                            
                            <div class="validity-text">
                                <?php if($days_remaining < 0): ?>
                                    <span class="text-danger"><i class="fas fa-exclamation-circle me-1"></i>Expired <?php echo e(abs($days_remaining)); ?> days ago</span>
                                <?php elseif($days_remaining <= 30): ?>
                                    <span class="text-warning"><i class="fas fa-exclamation-triangle me-1"></i>Expires in <?php echo e($days_remaining); ?> days</span>
                                <?php else: ?>
                                    <span class="text-success"><i class="fas fa-check-circle me-1"></i>Valid for <?php echo e($days_remaining); ?> days</span>
                                <?php endif; ?>
                            </div>
                            
                            <div class="validity-progress">
                                <div class="progress-bar">
                                    <div class="progress-fill 
                                        <?php if($days_remaining < 0): ?> bg-danger
                                        <?php elseif($days_remaining <= 30): ?> bg-warning
                                        <?php else: ?> bg-success
                                        <?php endif; ?>"
                                        style="width: <?php echo e($percentage_used); ?>%">
                                    </div>
                                </div>
                                <div class="progress-labels">
                                    <span><i class="fas fa-calendar-check me-1"></i>Issued: <?php echo e($issue_date->format('M d, Y')); ?></span>
                                    <span><i class="fas fa-calendar-times me-1"></i>Expires: <?php echo e($expiry_date->format('M d, Y')); ?></span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- License Images -->
                <div class="license-images">
                        <div class="image-container">
                            <h4><i class="fas fa-id-card"></i> License Front</h4>
                            <?php if(!empty($license->license_front_image)): ?>
                                <img src="<?php echo e(asset($license->license_front_image)); ?>" 
                                    alt="License Front" 
                                    class="license-image"
                                    onerror="this.onerror=null; this.parentNode.innerHTML='<div class=\'no-image\'><i class=\'fas fa-id-card\'></i><p>Front image not available</p></div>';">
                            <?php else: ?>
                                <div class="no-image">
                                    <i class="fas fa-id-card"></i>
                                    <p>Front image not available</p>
                                </div>
                            <?php endif; ?>
                        </div>
                        
                        <div class="image-container">
                            <h4><i class="fas fa-id-card-alt"></i>License Back</h4>
                            <?php if(!empty($license->license_back_image)): ?>
                                <img src="<?php echo e(asset($license->license_back_image)); ?>" 
                                    alt="License Back" 
                                    class="license-image"
                                    onerror="this.onerror=null; this.parentNode.innerHTML='<div class=\'no-image\'><i class=\'fas fa-id-card\'></i><p>Back image not available</p></div>';">
                            <?php else: ?>
                                <div class="no-image">
                                    <i class="fas fa-id-card"></i>
                                    <p>Back image not available</p>
                                </div>
                            <?php endif; ?>
                        </div>
                </div>
                
                

                <!-- License Actions -->
                
                    
                    
                </div>
            <?php else: ?>
                <div class="license-container no-license">
                    <i class="fas fa-id-card"></i>
                    <h3>No Driving License Found</h3>
                    <p>You haven't added your driving license information yet. To rent a car, you'll need to provide your valid driving license details.</p>
                    <a href="#" class="btn-primary" id="addLicense">
                        <i class="fas fa-plus"></i> Add Driving License
                    </a>
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
            
            // License button handlers (placeholder functionality)
            const addLicenseBtn = document.getElementById('addLicense');
            const updateLicenseBtn = document.getElementById('updateLicense');
            
            if(addLicenseBtn) {
                addLicenseBtn.addEventListener('click', function(e) {
                    e.preventDefault();
                    alert('Add license functionality will be implemented here');
                });
            }
            
            if(updateLicenseBtn) {
                updateLicenseBtn.addEventListener('click', function(e) {
                    e.preventDefault();
                    alert('Update license functionality will be implemented here');
                });
            }
        });
    </script>
</body>
</html>
<?php $__env->stopSection(); ?>




<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\Thinley Norbu\Documents\GitHub\FinalProject\resources\views/customer/license.blade.php ENDPATH**/ ?>