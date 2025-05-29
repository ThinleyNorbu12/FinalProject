

<?php $__env->startSection('content'); ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pay Later - Car Rental Dashboard</title>
    <!-- Link to the external CSS file -->
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
        /* 
        /* Responsive Adjustments */
        @media (max-width: 992px) {
            .sidebar {
                width: 70px;
                transform: translateX(0);
                transition: all 0.3s;
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
            .stats-grid,
            .cars-grid {
                grid-template-columns: 1fr 1fr;
            }
            
            .header-search {
                max-width: 400px;
            }
            
            .rental-details {
                flex-direction: column;
            }
        }

        @media (max-width: 576px) {
            .sidebar {
                transform: translateX(-100%);
            }
            
            .sidebar.expanded {
                transform: translateX(0);
                width: 240px;
            }
            
            .main-content {
                margin-left: 0;
                width: 100%;
            }
            
            .stats-grid,
            .cars-grid {
                grid-template-columns: 1fr;
            }
        }
        /* Pay Later Page Specific Styles */
        .main-content {
            margin-left: 240px;
            width: calc(100% - 240px);
            padding: 20px;
            padding-top: 76px; /* Header height + some padding */
            transition: all 0.3s;
        }

        .page-title {
            margin-bottom: 24px;
        }

        .page-title h2 {
            font-size: 24px;
            font-weight: 600;
            margin-bottom: 8px;
            color: #333;
        }

        .page-title p {
            color: #606060;
            font-size: 14px;
        }

        /* Pay Later Container */
        .pay-later-container {
            background: white;
            border-radius: 8px;
            box-shadow: 0 1px 3px rgba(0, 0, 0, 0.1);
            padding: 24px;
            margin-bottom: 24px;
        }

        .pay-later-container h3 {
            font-size: 18px;
            font-weight: 600;
            margin-bottom: 16px;
            color: #333;
        }

        /* Pending Payments Table */
        .pending-payments-table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 24px;
        }

        .pending-payments-table th {
            background-color: #f8f9fa;
            padding: 12px 16px;
            text-align: left;
            font-weight: 600;
            color: #333;
            border-bottom: 1px solid #e5e5e5;
        }

        .pending-payments-table td {
            padding: 16px;
            border-bottom: 1px solid #e5e5e5;
            vertical-align: middle;
        }

        .pending-payments-table tr:last-child td {
            border-bottom: none;
        }

        /* Car Info in Table */
        .car-info {
            display: flex;
            align-items: center;
        }

        .car-thumbnail {
            width: 60px;
            height: 60px;
            border-radius: 4px;
            overflow: hidden;
            margin-right: 12px;
            background-color: #f2f2f2;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .car-thumbnail img {
            width: 100%;
            height: auto;
            object-fit: cover;
        }

        .car-model {
            font-weight: 500;
            margin-bottom: 4px;
        }

        .car-details {
            font-size: 12px;
            color: #606060;
        }

        /* Status Badges */
        .badge {
            padding: 4px 8px;
            border-radius: 4px;
            font-size: 12px;
            font-weight: 500;
        }

        .badge-overdue {
            background-color: #ffe5e5;
            color: #d32f2f;
        }

        .badge-pending {
            background-color: #fff0e0;
            color: #ed6c02;
        }

        .badge-upcoming {
            background-color: #e3f2fd;
            color: #0288d1;
        }

        .badge-paid {
            background-color: #e8f5e9;
            color: #2e7d32;
        }

        /* Payment Buttons */
        .btn-pay {
            background-color: #3366ff;
            color: white;
            border: none;
            border-radius: 4px;
            padding: 6px 12px;
            font-size: 14px;
            cursor: pointer;
            margin-right: 8px;
            margin-bottom: 8px;
            transition: background-color 0.3s;
        }

        .btn-pay:hover {
            background-color: #2952cc;
        }

        .btn-pay:disabled {
            background-color: #cccccc;
            cursor: not-allowed;
        }

        .btn-danger {
            background-color: transparent;
            color: #d32f2f;
            border: 1px solid #d32f2f;
            border-radius: 4px;
            padding: 6px 12px;
            font-size: 14px;
            cursor: pointer;
            transition: all 0.3s;
        }

        .btn-danger:hover {
            background-color: #ffebee;
        }

        /* Payment Summary */
        .payment-summary {
            background-color: #f8f9fa;
            border-radius: 8px;
            padding: 16px;
            margin-top: 24px;
        }

        .payment-summary h4 {
            font-size: 16px;
            font-weight: 600;
            margin-bottom: 12px;
            color: #333;
        }

        .summary-item, .summary-total {
            display: flex;
            justify-content: space-between;
            padding: 8px 0;
        }

        .summary-total {
            border-top: 1px solid #e5e5e5;
            margin-top: 8px;
            padding-top: 12px;
            font-weight: 600;
        }

        /* No Payments Message */
        .no-payments {
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            padding: 48px 0;
            text-align: center;
        }

        .no-payments i {
            font-size: 48px;
            color: #4caf50;
            margin-bottom: 16px;
        }

        .no-payments p {
            font-size: 16px;
            color: #606060;
        }

        /* Payment Modal */
        .modal {
            display: none;
            position: fixed;
            z-index: 1050;
            left: 0;
            top: 0;
            width: 100%;
            height: 100%;
            overflow: auto;
            background-color: rgba(0, 0, 0, 0.5);
        }

        .modal-content {
            background-color: white;
            margin: 10% auto;
            width: 90%;
            max-width: 500px;
            border-radius: 8px;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.3);
            position: relative;
        }

        .modal-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 16px 24px;
            border-bottom: 1px solid #e5e5e5;
        }

        .modal-header h3 {
            font-size: 20px;
            font-weight: 600;
            margin: 0;
        }

        .modal-close {
            font-size: 24px;
            cursor: pointer;
            color: #606060;
        }

        .modal-close:hover {
            color: #333;
        }

        /* Payment Details in Modal */
        .payment-details {
            padding: 16px 24px;
            border-bottom: 1px solid #e5e5e5;
        }

        .payment-detail-item {
            display: flex;
            justify-content: space-between;
            margin-bottom: 8px;
        }

        .payment-detail-item:last-child {
            margin-bottom: 0;
        }

        /* Payment Methods */
        .payment-methods {
            padding: 16px 24px;
            border-bottom: 1px solid #e5e5e5;
        }

        .payment-methods h4 {
            font-size: 16px;
            font-weight: 600;
            margin-bottom: 12px;
            color: #333;
        }

        .payment-method {
            display: flex;
            align-items: center;
            padding: 12px;
            border: 1px solid #e5e5e5;
            border-radius: 8px;
            margin-bottom: 12px;
            cursor: pointer;
            transition: all 0.3s;
        }

        .payment-method:hover {
            border-color: #3366ff;
            background-color: #f5f7ff;
        }

        .payment-method.selected {
            border-color: #3366ff;
            background-color: #f5f7ff;
        }

        .payment-method-icon {
            width: 40px;
            height: 40px;
            border-radius: 50%;
            background-color: #e3f2fd;
            display: flex;
            align-items: center;
            justify-content: center;
            margin-right: 16px;
        }

        .payment-method-icon i {
            font-size: 18px;
            color: #3366ff;
        }

        .payment-method-name {
            font-weight: 500;
            margin-bottom: 4px;
        }

        .payment-method-info {
            font-size: 12px;
            color: #606060;
        }

        /* Payment Method Sections */
        .payment-method-section {
            padding: 16px 24px;
            border-bottom: 1px solid #e5e5e5;
        }

        .payment-method-section.hidden {
            display: none;
        }

        .payment-option-body {
            margin-top: 16px;
        }

        /* Bank Selector */
        .bank-selector {
            display: flex;
            flex-wrap: wrap;
            gap: 12px;
            margin-bottom: 16px;
        }

        .bank-option {
            width: 80px;
            height: 80px;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            border: 1px solid #e5e5e5;
            border-radius: 8px;
            padding: 8px;
            cursor: pointer;
            transition: all 0.3s;
        }

        .bank-option:hover {
            border-color: #3366ff;
            background-color: #f5f7ff;
        }

        .bank-option.selected {
            border-color: #3366ff;
            background-color: #f5f7ff;
        }

        .bank-option img {
            width: 40px;
            height: 40px;
            object-fit: contain;
            margin-bottom: 8px;
        }

        /* Bank Instructions */
        .bank-instructions {
            background-color: #f8f9fa;
            border-radius: 8px;
            padding: 16px;
            margin-bottom: 16px;
        }

        .bank-instructions.hidden {
            display: none;
        }

        .bank-instructions h6 {
            font-size: 14px;
            font-weight: 600;
            margin-bottom: 12px;
            color: #333;
        }

        .bank-instructions ol {
            padding-left: 24px;
            margin-bottom: 0;
        }

        .bank-instructions li {
            margin-bottom: 8px;
            font-size: 14px;
        }

        .bank-instructions li:last-child {
            margin-bottom: 0;
        }

        /* QR Code Container */
        .qr-code-container {
            display: flex;
            flex-direction: column;
            align-items: center;
            margin-top: 16px;
        }

        .qr-code-container.hidden {
            display: none;
        }

        .qr-wrapper {
            width: 200px;
            height: 200px;
            border: 1px solid #e5e5e5;
            border-radius: 8px;
            padding: 8px;
            margin-bottom: 16px;
        }

        .qr-code-image {
            width: 100%;
            height: 100%;
            object-fit: contain;
        }

        .qr-details {
            text-align: center;
            margin-bottom: 16px;
        }

        .qr-details .name {
            font-weight: 500;
            margin-bottom: 4px;
        }

        /* Upload Button */
        .upload-btn {
            display: flex;
            align-items: center;
            justify-content: center;
            background-color: #f5f7ff;
            border: 1px dashed #3366ff;
            border-radius: 8px;
            padding: 12px;
            cursor: pointer;
            transition: all 0.3s;
        }

        .upload-btn:hover {
            background-color: #e6ecff;
        }

        .upload-btn i {
            margin-right: 8px;
            color: #3366ff;
        }

        /* Bank Transfer with OTP Section */
        .bank-dropdown, .account-input, .phone-input {
            width: 100%;
            height: 40px;
            border: 1px solid #e5e5e5;
            border-radius: 4px;
            padding: 8px 12px;
            font-size: 14px;
            margin-bottom: 16px;
        }

        .form-label {
            display: block;
            margin-bottom: 8px;
            font-weight: 500;
            color: #333;
        }

        .otp-inputs {
            display: flex;
            gap: 8px;
            margin-top: 8px;
        }

        .otp-inputs input {
            width: 40px;
            height: 40px;
            border: 1px solid #e5e5e5;
            border-radius: 4px;
            text-align: center;
            font-size: 16px;
            font-weight: 600;
        }

        .otp-btn {
            background-color: #3366ff;
            color: white;
            border: none;
            border-radius: 4px;
            padding: 8px 16px;
            font-size: 14px;
            cursor: pointer;
            transition: background-color 0.3s;
        }

        .otp-btn:hover {
            background-color: #2952cc;
        }

        .otp-btn:disabled {
            background-color: #cccccc;
            cursor: not-allowed;
        }

        /* Hidden Class */
        .hidden {
            display: none;
        }

        /* Confirm Payment Button */
        .payment-action {
            padding: 16px 24px;
            text-align: center;
        }

        .btn-confirm-payment {
            background-color: #3366ff;
            color: white;
            border: none;
            border-radius: 4px;
            padding: 10px 24px;
            font-size: 16px;
            font-weight: 500;
            cursor: pointer;
            transition: background-color 0.3s;
        }

        .btn-confirm-payment:hover {
            background-color: #2952cc;
        }

        /* Responsive Adjustments */
        @media (max-width: 992px) {
            .sidebar {
                width: 70px;
                transition: all 0.3s;
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
                z-index: 1010; /* Higher than header */
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
            
            /* Add overlay when sidebar is expanded on mobile */
            .sidebar-overlay {
                display: none;
                position: fixed;
                top: 0;
                left: 0;
                right: 0;
                bottom: 0;
                background-color: rgba(0, 0, 0, 0.5);
                z-index: 1005;
            }
            
            .sidebar-overlay.active {
                display: block;
            }
        }

        @media (max-width: 768px) {
            .pending-payments-table {
                display: block;
                overflow-x: auto;
            }
            
            .car-info {
                min-width: 200px;
            }
            
            .bank-selector {
                justify-content: center;
            }
            
            .payment-method-section {
                padding: 16px 16px;
            }
            
            .payment-methods,
            .payment-details,
            .payment-action {
                padding: 16px;
            }
            
            .modal-content {
                width: 95%;
                margin: 5% auto;
            }
        }

        @media (max-width: 576px) {
            .sidebar {
                transform: translateX(-100%);
                width: 240px;
            }
            
            .sidebar.expanded {
                transform: translateX(0);
                box-shadow: 0 0 15px rgba(0, 0, 0, 0.2);
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
            
            .page-title h2 {
                font-size: 20px;
            }
            
            .payment-method {
                padding: 8px;
            }
            
            .payment-method-icon {
                width: 32px;
                height: 32px;
                margin-right: 12px;
            }
            
            .bank-option {
                width: 70px;
                height: 70px;
            }
            
            .btn-confirm-payment {
                width: 100%;
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
                                
                <a href="<?php echo e(route('customer.payment-history')); ?>" class="sidebar-menu-item ">
                    <i class="fas fa-credit-card"></i>
                    <span>Payment History</span>
                </a>

                <a href="<?php echo e(route('customer.paylater')); ?>" class="sidebar-menu-item active">
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
                
               
            </div>
        </div>
        
        <!-- Main Content -->
        <div class="main-content">
            <div class="page-title">
                <h2>Pay Later</h2>
                <p>Manage your deferred payments for car rentals</p>
            </div>
            
            <!-- Pay Later Content -->
            <div class="pay-later-container">
                <h3>Pending Payments</h3>
                
                <?php if(count($pendingPayments) > 0 && $pendingPayments->isNotEmpty()): ?>
                <!-- Initialize totals at the beginning -->
                <?php
                $totalPending = 0;
                
                // Pre-calculate all pending payments
                foreach($pendingPayments as $payment) {
                    if($payment->pay_later_status != 'paid') {
                        $totalPending += $payment->amount;
                    }
                }
                ?>
                
                <!-- Pending Payments Table -->
                <table class="pending-payments-table">
                    <thead>
                        <tr>
                            <th>Car</th>
                            <th>Rental Period</th>
                            <th>Payment Due</th>
                            <th>Amount</th>
                            <th>Status</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $__currentLoopData = $pendingPayments; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $payment): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <?php
                            // Get booking details
                            $booking = DB::table('car_bookings')
                                ->where('id', $payment->booking_id)
                                ->first();
                            
                            // Get car details from car_details_tbl instead of cars
                            $car = DB::table('car_details_tbl')
                                ->where('id', $booking->car_id)
                                ->first();
                            
                            // Calculate status based on rental end date and payment status
                            $today = \Carbon\Carbon::now();
                            $rentalEndDate = \Carbon\Carbon::parse($booking->dropoff_datetime);
                            
                            // Set payment due date to be today's date until rental end date
                            $paymentDueDate = $today->lte($rentalEndDate) ? $today : $rentalEndDate;
                            
                            // Check for status in the payments table
                            $paymentStatus = $payment->status ?? '';  // Use null coalescing in case status field doesn't exist
                            $payLaterStatus = $payment->pay_later_status ?? ''; // Use null coalescing in case pay_later_status field doesn't exist
                            
                            // Determine display status
                            if($paymentStatus == 'cancelled' || $payLaterStatus == 'cancelled') {
                                $displayStatus = 'cancelled';
                            } elseif($paymentStatus == 'completed' || $payLaterStatus == 'paid') {
                                $displayStatus = 'paid';
                            } elseif($today->gt($rentalEndDate)) {
                                $displayStatus = 'overdue';
                            } elseif($today->diffInDays($rentalEndDate) <= 7) {
                                $displayStatus = 'pending';
                            } else {
                                $displayStatus = 'upcoming';
                            }
                            ?>
                            
                            <tr>
                                <td>
                                    <div class="car-info">
                                        <div class="car-thumbnail">
                                        <?php if(isset($car->car_image) && $car->car_image): ?>
                                                <img src="<?php echo e(asset($car->car_image)); ?>" alt="Car Image" style="width: 100px; height: auto;">
                                            <?php else: ?>
                                                <p>No image</p>
                                            <?php endif; ?>
                                        </div>
                                        <div>
                                            <div class="car-model"><?php echo e($car->maker ?? 'Unknown'); ?> <?php echo e($car->model ?? 'Car'); ?></div>
                                            <div class="car-details"><?php echo e($car->vehicle_type ?? 'Vehicle'); ?> • <?php echo e($car->registration_no ?? 'N/A'); ?> • <?php echo e($booking->id); ?></div>
                                        </div>
                                    </div>
                                </td>
                                <td>
                                    <?php echo e(\Carbon\Carbon::parse($booking->pickup_datetime)->format('M d')); ?> - 
                                    <?php echo e(\Carbon\Carbon::parse($booking->dropoff_datetime)->format('M d, Y')); ?>

                                </td>
                                <td><?php echo e($paymentDueDate->format('M d, Y')); ?></td>
                                <td><?php echo e($payment->currency ?? '$'); ?> <?php echo e(number_format($payment->amount, 2)); ?></td>
                                <td>
                                    <?php if($displayStatus == 'overdue'): ?>
                                        <span class="badge badge-overdue">Overdue</span>
                                    <?php elseif($displayStatus == 'pending'): ?>
                                        <span class="badge badge-pending">Pending</span>
                                    <?php elseif($displayStatus == 'upcoming'): ?>
                                        <span class="badge badge-upcoming">Upcoming</span>
                                    <?php elseif($displayStatus == 'cancelled'): ?>
                                        <span class="badge badge-cancelled">Cancelled</span>
                                    <?php else: ?>
                                        <span class="badge badge-paid">Paid</span>
                                    <?php endif; ?>
                                </td>
                                <td>
                                    <?php if($displayStatus != 'paid' && $displayStatus != 'cancelled'): ?>
                                        <button class="btn-pay" onclick="openPaymentModal('<?php echo e($car->maker ?? 'Unknown'); ?> <?php echo e($car->model ?? 'Car'); ?>', '<?php echo e($booking->id); ?>', '<?php echo e($payment->amount); ?>', '<?php echo e($payment->id); ?>')">Pay Now</button>
                                        <form action="<?php echo e(route('customer.cancel-payment', $payment->id)); ?>" method="POST" onsubmit="return confirm('Are you sure you want to cancel this payment?');">
                                            <?php echo csrf_field(); ?>
                                            <button type="submit" class="btn btn-danger">Cancel Payment</button>
                                        </form>
                                    <?php elseif($displayStatus == 'cancelled'): ?>
                                        <button class="btn-pay disabled" disabled>Cancelled</button>
                                    <?php else: ?>
                                        <button class="btn-pay disabled" disabled>Completed</button>
                                    <?php endif; ?>
                                </td>
                            </tr>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </tbody>
                </table>
                
                <!-- Payment Summary -->
                <div class="payment-summary">
                    <h4>Payment Summary</h4>
                    <div class="summary-item">
                        <div>Pending Payments:</div>
                        <div><?php echo e($pendingPayments->first()->currency ?? '$'); ?> <?php echo e(number_format($totalPending, 2)); ?></div>
                    </div>
                    <div class="summary-total">
                        <div>Total Amount:</div>
                        <div><?php echo e($pendingPayments->first()->currency ?? '$'); ?> <?php echo e(number_format($totalPending, 2)); ?></div>
                    </div>
                </div>
                <?php else: ?>
                <div class="no-payments">
                    <i class="fas fa-check-circle"></i>
                    <p>You don't have any pending payments at the moment.</p>
                </div>
                <?php endif; ?>
            </div>

            <!-- Payment Modal -->
            <div id="paymentModal" class="modal">
                <div class="modal-content">
                    <div class="modal-header">
                        <h3>Make Payment</h3>
                        <span class="modal-close" onclick="closePaymentModal()">&times;</span>
                    </div>
                    
                    <form action="<?php echo e(route('customer.paylater.process')); ?>" method="POST" id="paymentForm" enctype="multipart/form-data">
                        <?php echo csrf_field(); ?>
                        <input type="hidden" name="payment_id" id="paymentId">
                        <input type="hidden" name="bank_code" id="selected_bank_code">
                        <input type="hidden" name="payment_method" id="selectedPaymentMethod" value="qr_code">
                        
                        <div class="payment-details">
                            <div class="payment-detail-item">
                                <div>Car:</div>
                                <div id="modalCarName"></div>
                            </div>
                            <div class="payment-detail-item">
                                <div>Rental ID:</div>
                                <div id="modalRentalId"></div>
                            </div>
                            <div class="payment-detail-item">
                                <div>Amount Due:</div>
                                <div id="modalAmount"></div>
                            </div>
                        </div>
                        
                        <div class="payment-methods">
                            <h4>Select Payment Method</h4>
                            
                            <!-- Payment Method Options -->
                            <div class="payment-method selected" onclick="selectPaymentMethod(this, 'qr_code')">
                                <input type="radio" name="payment_method_radio" value="qr_code" checked style="display: none;">
                                <div class="payment-method-icon">
                                    <i class="fas fa-qrcode"></i>
                                </div>
                                <div class="payment-method-details">
                                    <div class="payment-method-name">QR Code Payment</div>
                                    <div class="payment-method-info">Scan QR with your banking app</div>
                                </div>
                            </div>
                            
                            <div class="payment-method" onclick="selectPaymentMethod(this, 'bank_otp')">
                                <input type="radio" name="payment_method_radio" value="bank_otp" style="display: none;">
                                <div class="payment-method-icon">
                                    <i class="fas fa-university"></i>
                                </div>
                                <div class="payment-method-details">
                                    <div class="payment-method-name">Bank Transfer with OTP</div>
                                    <div class="payment-method-info">Direct bank payment with verification</div>
                                </div>
                            </div>
                        </div>
                        
                        <!-- QR Code Payment Section -->
                        <div id="qrCodeSection" class="payment-method-section">
                            <div class="payment-option-body">
                                <p>Choose your bank below and follow the instructions to complete your payment.</p>
                                
                                <div class="bank-selector">
                                    <div class="bank-option" data-bank="bob" onclick="selectBank('bob')">
                                        <img src="../assets/images/mbob.png" alt="Bank of Bhutan">
                                        <div>BOB</div>
                                    </div>
                                    <div class="bank-option" data-bank="bnb" onclick="selectBank('bnb')">
                                        <img src="../assets/images/bnb.png" alt="Bhutan National Bank">
                                        <div>BNB</div>
                                    </div>
                                    <div class="bank-option" data-bank="tbank" onclick="selectBank('tbank')">
                                        <img src="../assets/images/Tbank.jpg" alt="T-Bank">
                                        <div>T-Bank</div>
                                    </div>
                                    <div class="bank-option" data-bank="dpnb" onclick="selectBank('dpnb')">
                                        <img src="../assets/images/drukpnb.png" alt="Druk PNB">
                                        <div>DPNB</div>
                                    </div>
                                    <div class="bank-option" data-bank="bdbl" onclick="selectBank('bdbl')">
                                        <img src="../assets/images/bdbl.jpg" alt="BDBL">
                                        <div>BDBL</div>
                                    </div>
                                </div>
                                
                                <!-- Bank Instructions Container -->
                                <div id="bankInstructionsContainer">
                                    <!-- Bank instructions will be displayed here -->
                                    <!-- BOB Instructions -->
                                    <div class="bank-instructions hidden" id="bob-instructions">
                                        <h6>Payment Instructions for Bank of Bhutan</h6>
                                        <ol>
                                            <li>Open your mBOB app</li>
                                            <li>Go to Payments > Scan QR</li>
                                            <li>Scan the QR code shown here</li>
                                            <li>Enter amount as shown above</li>
                                            <li>Confirm payment using your PIN/password</li>
                                            <li>Take a screenshot of the confirmation</li>
                                            <li>Upload the screenshot below</li>
                                        </ol>
                                    </div>
                                    
                                    <!-- BNB Instructions -->
                                    <div class="bank-instructions hidden" id="bnb-instructions">
                                        <h6>Payment Instructions for Bhutan National Bank</h6>
                                        <ol>
                                            <li>Open your BNB mPAY app</li>
                                            <li>Select "Scan & Pay" option</li>
                                            <li>Scan the QR code shown here</li>
                                            <li>Enter amount as shown above</li>
                                            <li>Enter your mPIN to authorize payment</li>
                                            <li>Take a screenshot of the payment receipt</li>
                                            <li>Upload the screenshot below</li>
                                        </ol>
                                    </div>
                                    
                                    <!-- T-Bank Instructions -->
                                    <div class="bank-instructions hidden" id="tbank-instructions">
                                        <h6>Payment Instructions for T-Bank</h6>
                                        <ol>
                                            <li>Log in to your T-Bank mobile app</li>
                                            <li>Tap on "Payments" > "QR Payments"</li>
                                            <li>Scan the QR code shown here</li>
                                            <li>Verify recipient details</li>
                                            <li>Enter amount as shown above</li>
                                            <li>Confirm payment with your secure PIN</li>
                                            <li>Take a screenshot of the transaction receipt</li>
                                            <li>Upload the screenshot below</li>
                                        </ol>
                                    </div>
                                    
                                    <!-- DPNB Instructions -->
                                    <div class="bank-instructions hidden" id="dpnb-instructions">
                                        <h6>Payment Instructions for Druk PNB</h6>
                                        <ol>
                                            <li>Open the Druk PNB mobile banking app</li>
                                            <li>Select "QR Payments" from the main menu</li>
                                            <li>Scan the QR code shown here</li>
                                            <li>Enter amount as shown above</li>
                                            <li>Verify recipient information</li>
                                            <li>Confirm using your MPIN</li>
                                            <li>Take a screenshot of the success page</li>
                                            <li>Upload the screenshot below</li>
                                        </ol>
                                    </div>
                                    
                                    <!-- BDBL Instructions -->
                                    <div class="bank-instructions hidden" id="bdbl-instructions">
                                        <h6>Payment Instructions for BDBL</h6>
                                        <ol>
                                            <li>Login to your BDBL mobile banking app</li>
                                            <li>Tap on "QR Code Payment"</li>
                                            <li>Scan the QR code shown here</li>
                                            <li>Check recipient name: "THINLEY NORBU"</li>
                                            <li>Enter amount as shown above</li>
                                            <li>Enter your security PIN to complete payment</li>
                                            <li>Take a screenshot of the payment confirmation</li>
                                            <li>Upload the screenshot below</li>
                                        </ol>
                                    </div>
                                </div>
                                
                                <div class="qr-code-container hidden" id="qrContainer">
                                    <div class="qr-wrapper">
                                        <img src="../assets/images/bobQRcode.jpg" alt="QR Code" class="qr-code-image" id="bankQrCode">
                                    </div>
                                    
                                    <div class="qr-details">
                                        <p class="name">Car Rental System</p>
                                        <p class="amount">Amount: <strong id="qrAmountDisplay"></strong></p>
                                    </div>
                                    
                                    <label class="upload-btn mt-4">
                                        <i class="fas fa-upload"></i>
                                        <span>Upload Payment Screenshot</span>
                                        <input type="file" name="screenshot" id="payment_screenshot" style="display: none;" accept="image/*">
                                    </label>
                                </div>
                                
                                <p class="text-center mt-3 text-muted" id="qrPrompt">Please select a bank to display the QR code</p>
                            </div>
                        </div>
                        
                        <!-- Bank Transfer with OTP Section -->
                        <div id="bankOtpSection" class="payment-method-section hidden">
                            <div class="payment-option-body">
                                <div class="mb-3">
                                    <label class="form-label">Bank Code</label>
                                    <select class="bank-dropdown" name="bank_code_otp">
                                        <option value="">Select Bank</option>
                                        <option value="bob">BANK OF BHUTAN LIMITED</option>
                                        <option value="bnb">BHUTAN NATIONAL BANK LIMITED</option>
                                        <option value="tbank">T-BANK LIMITED</option>
                                        <option value="dpnb">DRUK PNB BANK LIMITED</option>
                                        <option value="bdbl">BHUTAN DEVELOPMENT BANK LIMITED</option>
                                    </select>
                                </div>
                                
                                <div class="mb-3">
                                    <label class="form-label">Bank Account Number</label>
                                    <input type="text" name="account_number" class="account-input" placeholder="Enter Account Number">
                                </div>
                                                
                                <div class="text-center mt-4">
                                    <button type="button" class="otp-btn" onclick="sendOtp()">Send OTP</button>
                                </div>
                                
                                <div class="mt-4 hidden" id="otpSection">
                                    <label class="form-label">Enter OTP</label>
                                    <div class="d-flex gap-2 otp-inputs">
                                        <input type="text" name="otp[]" maxlength="1" class="form-control text-center">
                                        <input type="text" name="otp[]" maxlength="1" class="form-control text-center">
                                        <input type="text" name="otp[]" maxlength="1" class="form-control text-center">
                                        <input type="text" name="otp[]" maxlength="1" class="form-control text-center">
                                        <input type="text" name="otp[]" maxlength="1" class="form-control text-center">
                                        <input type="text" name="otp[]" maxlength="1" class="form-control text-center">
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                        <div class="payment-action">
                            <button type="submit" class="btn-confirm-payment">Confirm Payment</button>
                        </div>
                    </form>
                </div>
            </div>
</body>
</html>
<script>
// Function to open payment modal
function openPaymentModal(carName, rentalId, amount, paymentId) {
    document.getElementById('modalCarName').textContent = carName;
    document.getElementById('modalRentalId').textContent = rentalId;
    document.getElementById('modalAmount').textContent = formatCurrency(amount);
    document.getElementById('qrAmountDisplay').textContent = 'Nu. ' + formatCurrency(amount);
    document.getElementById('paymentId').value = paymentId;
    
    document.getElementById('paymentModal').style.display = 'block';
}

// Function to close payment modal
function closePaymentModal() {
    document.getElementById('paymentModal').style.display = 'none';
    resetPaymentForm();
}

// Function to format currency
function formatCurrency(amount) {
    return parseFloat(amount).toFixed(2).replace(/\d(?=(\d{3})+\.)/g, '$&,');
}

// Function to select payment method
function selectPaymentMethod(element, methodType) {
    // Remove selected class from all payment methods
    document.querySelectorAll('.payment-method').forEach(function(el) {
        el.classList.remove('selected');
    });
    
    // Add selected class to clicked element
    element.classList.add('selected');
    
    // Update hidden input value
    document.getElementById('selectedPaymentMethod').value = methodType;
    
    // Show/Hide corresponding payment sections
    if (methodType === 'qr_code') {
        document.getElementById('qrCodeSection').classList.remove('hidden');
        document.getElementById('bankOtpSection').classList.add('hidden');
    } else if (methodType === 'bank_otp') {
        document.getElementById('qrCodeSection').classList.add('hidden');
        document.getElementById('bankOtpSection').classList.remove('hidden');
    }
}

// Function to select bank for QR code payment
function selectBank(bankCode) {
    // Remove selected class from all bank options
    document.querySelectorAll('.bank-option').forEach(function(el) {
        el.classList.remove('selected');
    });
    
    // Add selected class to clicked bank option
    document.querySelector('.bank-option[data-bank="' + bankCode + '"]').classList.add('selected');
    
    // Update hidden input value
    document.getElementById('selected_bank_code').value = bankCode;
    
    // Hide all bank instructions
    document.querySelectorAll('.bank-instructions').forEach(function(el) {
        el.classList.add('hidden');
    });
    
    // Show instructions for selected bank
    document.getElementById(bankCode + '-instructions').classList.remove('hidden');
    
    // Show QR code container and update QR image
    document.getElementById('qrContainer').classList.remove('hidden');
    document.getElementById('qrPrompt').classList.add('hidden');
    
    // Update QR code image based on selected bank
    document.getElementById('bankQrCode').src = '../assets/images/' + bankCode + 'QRcode.jpg';
}

// Function to send OTP
function sendOtp() {
    const accountInput = document.querySelector('.account-input').value;
    const phoneInput = document.querySelector('.phone-input').value;
    const bankDropdown = document.querySelector('.bank-dropdown').value;
    
    if (!accountInput || !phoneInput || !bankDropdown) {
        alert('Please fill in all fields');
        return;
    }
    
    // Show OTP section
    document.getElementById('otpSection').classList.remove('hidden');
    
    // Focus on first OTP input
    document.querySelector('.otp-inputs input:first-child').focus();
    
    // Disable send OTP button
    document.querySelector('.otp-btn').disabled = true;
    document.querySelector('.otp-btn').textContent = 'OTP Sent';
    
    // In a real app, you would make an AJAX call to send OTP
    // For demo purposes, we're just showing the OTP section
}

// Function to handle OTP input auto-focus
document.addEventListener('DOMContentLoaded', function() {
    const otpInputs = document.querySelectorAll('.otp-inputs input');
    otpInputs.forEach(function(input, index) {
        input.addEventListener('input', function() {
            if (this.value.length === this.maxLength && index < otpInputs.length - 1) {
                otpInputs[index + 1].focus();
            }
        });
        
        input.addEventListener('keydown', function(e) {
            if (e.key === 'Backspace' && !this.value && index > 0) {
                otpInputs[index - 1].focus();
            }
        });
    });
    
    // Handle file input change
    document.getElementById('payment_screenshot').addEventListener('change', function() {
        if (this.files.length > 0) {
            document.querySelector('.upload-btn span').textContent = 'Screenshot Uploaded';
        }
    });
});

// Function to reset payment form
function resetPaymentForm() {
    document.getElementById('paymentForm').reset();
    document.querySelectorAll('.bank-instructions, #qrContainer').forEach(function(el) {
        el.classList.add('hidden');
    });
    document.getElementById('qrPrompt').classList.remove('hidden');
    document.getElementById('otpSection').classList.add('hidden');
    document.querySelector('.upload-btn span').textContent = 'Upload Payment Screenshot';
    
    // Reset payment method selection
    selectPaymentMethod(document.querySelector('.payment-method'), 'qr_code');
}
</script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\Thinley Norbu\Documents\GitHub\FinalProject\resources\views/customer/pay-later.blade.php ENDPATH**/ ?>