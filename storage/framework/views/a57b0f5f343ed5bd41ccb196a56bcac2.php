

<?php $__env->startSection('content'); ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Customer Profile - Car Rental</title>
    <!-- Link to the external CSS file -->
    <link rel="stylesheet" href="<?php echo e(asset('assets/css/customer/dashboard.css')); ?>">

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    <!-- Flatpickr CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">

    <!-- Flatpickr JS -->
    <script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
    <style>
        /* Additional CSS for profile page */
        .profile-container {
            padding: 20px;
        }
        
        .profile-header {
            display: flex;
            align-items: center;
            margin-bottom: 30px;
        }
        
        .profile-avatar {
            width: 100px;
            height: 100px;
            border-radius: 50%;
            object-fit: cover;
            margin-right: 20px;
            border: 3px solid #007bff;
        }
        
        .profile-name h2 {
            margin-bottom: 5px;
            color: #333;
        }
        
        .profile-status {
            color: #666;
            font-size: 0.9rem;
        }
        
        .profile-status .status-badge {
            background-color: #28a745;
            color: white;
            padding: 3px 10px;
            border-radius: 12px;
            font-size: 0.8rem;
            margin-left: 5px;
        }
        
        .profile-section {
            background-color: #fff;
            border-radius: 8px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
            padding: 20px;
            margin-bottom: 25px;
        }
        
        .profile-section h3 {
            margin-bottom: 20px;
            color: #333;
            padding-bottom: 10px;
            border-bottom: 1px solid #eee;
        }
        
        .form-group {
            margin-bottom: 20px;
        }
        
        .form-group label {
            font-weight: 600;
            margin-bottom: 8px;
            color: #555;
        }
        
        .input-with-icon {
            position: relative;
        }
        
        .input-with-icon i {
            position: absolute;
            top: 12px;
            left: 10px;
            color: #aaa;
        }
        
        .input-with-icon input,
        .input-with-icon select {
            padding-left: 35px;
        }
        
        .btn-update {
            background-color: #007bff;
            color: white;
            padding: 10px 25px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            transition: all 0.3s ease;
        }
        
        .btn-update:hover {
            background-color: #0069d9;
        }
        
        .upload-btn-wrapper {
            position: relative;
            overflow: hidden;
            display: inline-block;
        }
        
        .upload-btn {
            border: 2px solid #007bff;
            color: #007bff;
            background-color: white;
            padding: 8px 20px;
            border-radius: 5px;
            font-weight: 600;
        }
        
        .upload-btn-wrapper input[type=file] {
            font-size: 100px;
            position: absolute;
            left: 0;
            top: 0;
            opacity: 0;
            cursor: pointer;
        }
        
        .file-name {
            margin-top: 5px;
            font-size: 0.85rem;
            color: #666;
        }
        
        .license-info {
            display: flex;
            align-items: center;
            margin-top: 15px;
        }
        
        .license-image {
            width: 120px;
            height: 80px;
            object-fit: cover;
            border-radius: 5px;
            margin-right: 15px;
        }
        
        .license-details {
            flex: 1;
        }
        
        .license-details p {
            margin-bottom: 5px;
            line-height: 1.5;
        }
        
        .license-status {
            font-weight: 600;
            color: #28a745;
        }
        
        .notification-option {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 10px 0;
            border-bottom: 1px solid #eee;
        }
        
        .notification-option:last-child {
            border-bottom: none;
        }
        
        .notification-text p {
            margin-bottom: 3px;
            color: #333;
        }
        
        .notification-text small {
            color: #777;
            font-size: 0.85rem;
        }
        
        /* Custom toggle switch */
        .switch {
            position: relative;
            display: inline-block;
            width: 50px;
            height: 24px;
        }
        
        .switch input {
            opacity: 0;
            width: 0;
            height: 0;
        }
        
        .slider {
            position: absolute;
            cursor: pointer;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background-color: #ccc;
            transition: .4s;
            border-radius: 24px;
        }
        
        .slider:before {
            position: absolute;
            content: "";
            height: 16px;
            width: 16px;
            left: 4px;
            bottom: 4px;
            background-color: white;
            transition: .4s;
            border-radius: 50%;
        }
        
        input:checked + .slider {
            background-color: #007bff;
        }
        
        input:checked + .slider:before {
            transform: translateX(26px);
        }
        
        .verification-badge {
            display: inline-flex;
            align-items: center;
            background-color: #e9f7ef;
            color: #28a745;
            padding: 3px 10px;
            border-radius: 12px;
            font-size: 0.8rem;
            margin-left: 10px;
        }
        
        .verification-badge i {
            margin-right: 5px;
        }
        
        .security-option {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 15px 0;
            border-bottom: 1px solid #eee;
        }
        
        .security-option:last-child {
            border-bottom: none;
        }
        
        .security-option-text h5 {
            margin-bottom: 5px;
            font-size: 1rem;
        }
        
        .security-option-text p {
            color: #777;
            margin-bottom: 0;
            font-size: 0.9rem;
        }
        
        .btn-security {
            padding: 5px 15px;
            font-size: 0.9rem;
            border-radius: 4px;
            background-color: #f8f9fa;
            color: #333;
            border: 1px solid #ddd;
        }
        
        .btn-security:hover {
            background-color: #e9ecef;
        }
        
        .tab-buttons {
            display: flex;
            margin-bottom: 20px;
            border-bottom: 1px solid #ddd;
        }
        
        .tab-button {
            padding: 12px 20px;
            background: none;
            border: none;
            font-weight: 600;
            color: #777;
            cursor: pointer;
            position: relative;
        }
        
        .tab-button.active {
            color: #007bff;
        }
        
        .tab-button.active:after {
            content: '';
            position: absolute;
            bottom: -1px;
            left: 0;
            width: 100%;
            height: 3px;
            background-color: #007bff;
        }
        
        .tab-content {
            display: none;
        }
        
        .tab-content.active {
            display: block;
        }
        
        @media (max-width: 768px) {
            .profile-header {
                flex-direction: column;
                text-align: center;
            }
            
            .profile-avatar {
                margin-right: 0;
                margin-bottom: 15px;
            }
            
            .input-with-icon i {
                top: 13px;
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
                
                <a href="<?php echo e(route('customer.browse-cars')); ?>" class="sidebar-menu-item active">
                    <i class="fas fa-car"></i>
                    <span>Browse Cars</span>
                </a>
                
                <a href="#" class="sidebar-menu-item">
                    <i class="fas fa-calendar-alt"></i>
                    <span>My Reservations</span>
                </a>
                
                <div class="sidebar-divider"></div>
                
                <div class="sidebar-heading">My Account</div>
                
                <a href="<?php echo e(route('customer.profile')); ?>" class="sidebar-menu-item active">
                    <i class="fas fa-user"></i>
                    <span>Profile</span>
                </a>
                
                <a href="#" class="sidebar-menu-item">
                    <i class="fas fa-history"></i>
                    <span>Rental History</span>
                </a>
                
                <a href="#" class="sidebar-menu-item">
                    <i class="fas fa-credit-card"></i>
                    <span>Payment Methods</span>
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
            <div class="profile-container">
                <!-- Profile Header -->
                <div class="profile-header">
                    <img src="/api/placeholder/150/150" alt="Profile Avatar" class="profile-avatar">
                    <div class="profile-name">
                        <h2>
                            <?php if(Auth::guard('customer')->check()): ?>
                                <?php echo e(Auth::guard('customer')->user()->name); ?>

                            <?php else: ?>
                                Guest User
                            <?php endif; ?>
                        </h2>
                        <div class="profile-status">
                            Member since <?php if(Auth::guard('customer')->check()): ?>
                                <?php echo e(Auth::guard('customer')->user()->created_at->format('F Y')); ?>

                            <?php else: ?>
                                N/A
                            <?php endif; ?>
                       
                        </div>
                    </div>
                </div>
                
                <!-- Tab Navigation -->
                <div class="tab-buttons">
                    <button class="tab-button active" data-tab="personal-info">Personal Information</button>
                    <button class="tab-button" data-tab="license-info">Driver's License</button>
                    <button class="tab-button" data-tab="security">Security</button>
                    <button class="tab-button" data-tab="notifications">Notifications</button>
                </div>

                <div class="container">
                    <!-- Display success message if available -->
                    <?php if(session('success')): ?>
                        <div class="alert alert-success">
                            <?php echo e(session('success')); ?>

                        </div>
                    <?php endif; ?>
            
                    <!-- Display error message if available -->
                    <?php if(session('error')): ?>
                        <div class="alert alert-danger">
                            <?php echo e(session('error')); ?>

                        </div>
                    <?php endif; ?>
            
                    <!-- Personal Information Tab -->
                    <div class="tab-content active" id="personal-info">
                        <div class="profile-section">
                            <h3>Personal Information</h3>
                            <form action="<?php echo e(route('customer.profile.update')); ?>" method="POST">
                                <?php echo csrf_field(); ?>
                                <?php echo method_field('PUT'); ?>
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="fullName">Full Name</label>
                                            <div class="input-with-icon">
                                                <i class="fas fa-user"></i>
                                                <input type="text" class="form-control" id="fullName" name="name" value="<?php echo e(Auth::guard('customer')->user()->name ?? ''); ?>">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="cid">CID Number</label>
                                            <div class="input-with-icon">
                                                <i class="fas fa-id-card"></i>
                                                <input type="text" class="form-control" id="cid" name="cid" value="<?php echo e(Auth::guard('customer')->user()->cid_no ?? ''); ?>" readonly>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="email">Email Address</label>
                                            <div class="input-with-icon">
                                                <i class="fas fa-envelope"></i>
                                                <input type="email" class="form-control" id="email" name="email" value="<?php echo e(Auth::guard('customer')->user()->email ?? ''); ?>">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="phone">Phone Number</label>
                                            <div class="input-with-icon">
                                                <i class="fas fa-phone"></i>
                                                <input type="tel" class="form-control" id="phone" name="phone" value="<?php echo e(Auth::guard('customer')->user()->phone ?? ''); ?>">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                
                                <div class="row">
                                    <div class="col-md-6">
                                        <?php
                                            $dob = Auth::guard('customer')->user()->dob ?? '';
                                            $formattedDob = $dob ? \Carbon\Carbon::parse($dob)->format('d/m/Y') : '';
                                        ?>
            
                                        <div class="form-group">
                                            <label for="dateOfBirth">Date of Birth(DD/MM/YYYY)</label>
                                            <div class="input-with-icon">
                                                <i class="fas fa-calendar"></i>
                                                <input type="text" class="form-control" id="dateOfBirth" name="dob" value="<?php echo e($formattedDob); ?>" placeholder="DD/MM/YYYY" >
                                            </div>
                                        </div>
            
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="address">Address</label>
                                            <div class="input-with-icon">
                                                <i class="fas fa-home"></i>
                                                <input type="text" class="form-control" id="address" name="address" value="<?php echo e(Auth::guard('customer')->user()->address ?? ''); ?>">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="gender">Gender</label>
                                            <div class="input-with-icon">
                                                <i class="fas fa-venus-mars"></i>
                                                <select class="form-control" id="gender" name="gender">
                                                    <?php
                                                        $gender = Auth::guard('customer')->user()->gender ?? '';
                                                    ?>
                                                    <option value="">-- Select Gender --</option>
                                                    <option value="Male" <?php echo e($gender === 'Male' ? 'selected' : ''); ?>>Male</option>
                                                    <option value="Female" <?php echo e($gender === 'Female' ? 'selected' : ''); ?>>Female</option>
                                                    <option value="Other" <?php echo e($gender === 'Other' ? 'selected' : ''); ?>>Other</option>
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                
                                <div class="row mt-4">
                                    <div class="col-md-12">
                                        <button type="submit" class="btn-update">Save Changes</button>
                                    </div>
                                </div>                            
                            </form>
                        </div>
                    </div>
                </div>


                <!-- Driver's License Tab -->
                <div class="tab-content" id="license-info">
                    <?php if(session('success')): ?>
                        <div class="alert alert-success">
                            <?php echo e(session('success')); ?>

                        </div>
                    <?php endif; ?>

                    <div class="profile-section">
                        <h3>Driving License Information (Bhutan)</h3>

                        <form action="<?php echo e(route('customer.profile.save-license')); ?>" method="POST" enctype="multipart/form-data">
                            <?php echo csrf_field(); ?>

                            <div class="row">
                                <!-- License Number -->
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="licenseNumber">Driving License No.</label>
                                        <div class="input-with-icon">
                                            <i class="fas fa-id-card"></i>
                                            <input type="text" class="form-control" id="licenseNumber" name="license_number"
                                                value="<?php echo e(Auth::guard('customer')->user()->license_number ?? ''); ?>">
                                        </div>
                                    </div>
                                </div>

                                <!-- Dzongkhag -->
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="dzongkhag">Issuing Dzongkhag</label>
                                        <div class="input-with-icon">
                                            <i class="fas fa-map-marker-alt"></i>
                                            <select class="form-control" id="dzongkhag" name="license_dzongkhag">
                                                <option value="">-- Select Dzongkhag --</option>
                                                <?php
                                                    $dzongkhags = ['Bumthang', 'Chukha', 'Dagana', 'Gasa', 'Haa', 'Lhuentse', 'Mongar', 'Paro', 'Pemagatshel', 'Punakha', 'Samdrup Jongkhar', 'Samtse', 'Sarpang', 'Thimphu', 'Trashigang', 'Trashiyangtse', 'Trongsa', 'Tsirang', 'Wangdue Phodrang', 'Zhemgang'];
                                                ?>
                                                <?php $__currentLoopData = $dzongkhags; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $dzongkhag): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                    <option value="<?php echo e($dzongkhag); ?>"
                                                        <?php echo e((Auth::guard('customer')->user()->license_dzongkhag ?? '') == $dzongkhag ? 'selected' : ''); ?>>
                                                        <?php echo e($dzongkhag); ?>

                                                    </option>
                                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Dates -->
                            <div class="row">
                                <!-- Issue Date -->
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="issueDate">Date of Issue(DD/MM/YYYY)</label>
                                        <div class="input-with-icon">
                                            <i class="fas fa-calendar-plus"></i>
                                            <input type="date" class="form-control" id="issueDate" name="license_issue_date"
                                                value="<?php echo e(Auth::guard('customer')->user()->license_issue_date ?? ''); ?>" placeholder="DD/MM/YYYY">
                                        </div>
                                    </div>
                                </div>

                                <!-- Expiry Date -->
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="expiryDate">Expiry Date(DD/MM/YYYY)</label>
                                        <div class="input-with-icon">
                                            <i class="fas fa-calendar-times"></i>
                                            <input type="date" class="form-control" id="expiryDate" name="license_expiry_date"
                                                value="<?php echo e(Auth::guard('customer')->user()->license_expiry_date ?? ''); ?>" placeholder="DD/MM/YYYY">
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Upload Section -->
                            <div class="row mt-3">
                                <div class="col-md-12">
                                    <h5>Upload License Images</h5>
                                    <p>Upload clear images of the front and back side of your Bhutanese driving license.</p>
                                </div>
                            </div>

                            <div class="row">
                                <!-- Front -->
                                <div class="col-md-6 mb-3">
                                    <div class="form-group">
                                        <label for="license_front">Front Side</label>
                                        <input type="file" class="form-control" name="license_front" id="license_front">
                                    </div>
                                </div>

                                <!-- Back -->
                                <div class="col-md-6 mb-3">
                                    <div class="form-group">
                                        <label for="license_back">Back Side</label>
                                        <input type="file" class="form-control" name="license_back" id="license_back">
                                    </div>
                                </div>
                            </div>

                            <!-- Submit Button -->
                            <div class="row mt-4">
                                <div class="col-md-12">
                                    <button type="submit" class="btn-update">Save License Information</button>
                                </div>
                            </div>
                        </form>

                        <!-- License Preview -->
                        <div class="license-info mt-4">
                            <?php if(Auth::guard('customer')->user()->license_front): ?>
                                <img src="<?php echo e(asset('storage/licenses/' . Auth::guard('customer')->user()->license_front)); ?>" alt="Front License" class="license-image">
                            <?php endif; ?>
                            <?php if(Auth::guard('customer')->user()->license_back): ?>
                                <img src="<?php echo e(asset('storage/licenses/' . Auth::guard('customer')->user()->license_back)); ?>" alt="Back License" class="license-image">
                            <?php endif; ?>

                            <div class="license-details mt-3">
                                <p><strong>Verification Status:</strong> <span class="license-status">Verified</span></p>
                                <p><strong>Last Verified:</strong> April 15, 2025</p>
                                <p><small>Your license has been verified for vehicle services in Bhutan.</small></p>
                            </div>
                        </div>
                    </div>
                </div>


                
                <!-- Security Tab -->
                <div class="tab-content" id="security">
                    <div class="profile-section">
                        <h3>Account Security</h3>
                        
                        <div class="security-option">
                            <div class="security-option-text">
                                <h5>Change Password</h5>
                                <p>It's a good idea to use a strong password that you don't use elsewhere</p>
                            </div>
                            <button class="btn-security" data-bs-toggle="modal" data-bs-target="#changePasswordModal">Change</button>
                        </div>
                        
                        <div class="security-option">
                            <div class="security-option-text">
                                <h5>Two-Factor Authentication</h5>
                                <p>Add an extra layer of security to your account</p>
                            </div>
                            <button class="btn-security" data-bs-toggle="modal" data-bs-target="#twoFactorModal">Enable</button>
                        </div>
                        
                        <div class="security-option">
                            <div class="security-option-text">
                                <h5>Login History</h5>
                                <p>Check your recent login activity</p>
                            </div>
                            <button class="btn-security" data-bs-toggle="modal" data-bs-target="#loginHistoryModal">View</button>
                        </div>
                        
                        <div class="security-option">
                            <div class="security-option-text">
                                <h5>Connected Accounts</h5>
                                <p>Manage your connected social media accounts</p>
                            </div>
                            <button class="btn-security" data-bs-toggle="modal" data-bs-target="#connectedAccountsModal">Manage</button>
                        </div>
                    </div>
                </div>
                
                <!-- Notifications Tab -->
                <div class="tab-content" id="notifications">
                    <div class="profile-section">
                        <h3>Notification Preferences</h3>
                        
                        <div class="notification-option">
                            <div class="notification-text">
                                <p>Reservation Confirmations</p>
                                <small>Receive emails when you make a reservation</small>
                            </div>
                            <label class="switch">
                                <input type="checkbox" checked>
                                <span class="slider"></span>
                            </label>
                        </div>
                        
                        <div class="notification-option">
                            <div class="notification-text">
                                <p>Rental Reminders</p>
                                <small>Get notified before your rental starts and ends</small>
                            </div>
                            <label class="switch">
                                <input type="checkbox" checked>
                                <span class="slider"></span>
                            </label>
                        </div>
                        
                        <div class="notification-option">
                            <div class="notification-text">
                                <p>Special Offers & Promotions</p>
                                <small>Receive special offers, discounts, and promotions</small>
                            </div>
                            <label class="switch">
                                <input type="checkbox">
                                <span class="slider"></span>
                            </label>
                        </div>
                        
                        <div class="notification-option">
                            <div class="notification-text">
                                <p>SMS Notifications</p>
                                <small>Get urgent rental updates via text message</small>
                            </div>
                            <label class="switch">
                                <input type="checkbox" checked>
                                <span class="slider"></span>
                            </label>
                        </div>
                        
                        <div class="notification-option">
                            <div class="notification-text">
                                <p>Account Updates</p>
                                <small>Receive notifications about account security and updates</small>
                            </div>
                            <label class="switch">
                                <input type="checkbox" checked>
                                <span class="slider"></span>
                            </label>
                        </div>
                        
                        <div class="notification-option">
                            <div class="notification-text">
                                <p>Newsletter</p>
                                <small>Stay updated with industry news and travel tips</small>
                            </div>
                            <label class="switch">
                                <input type="checkbox">
                                <span class="slider"></span>
                            </label>
                        </div>
                        
                        <div class="mt-4">
                            <button class="btn-update">Save Notification Preferences</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <!-- Change Password Modal -->
    <div class="modal fade" id="changePasswordModal" tabindex="-1" aria-labelledby="changePasswordModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="changePasswordModalLabel">Change Password</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form action="<?php echo e(route('customer.password.update')); ?>" method="POST">
                        <?php echo csrf_field(); ?>
                        <div class="form-group mb-3">
                            <label for="currentPassword">Current Password</label>
                            <input type="password" class="form-control" id="currentPassword" name="current_password" required>
                        </div>
                        <div class="form-group mb-3">
                            <label for="newPassword">New Password</label>
                            <input type="password" class="form-control" id="newPassword" name="password" required>
                        </div>
                        <div class="form-group mb-3">
                            <label for="confirmPassword">Confirm New Password</label>
                            <input type="password" class="form-control" id="confirmPassword" name="password_confirmation" required>
                        </div>
                        <button type="submit" class="btn-update">Update Password</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Scripts -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
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

            // Tab Switching
            const tabButtons = document.querySelectorAll('.tab-button');
            const tabContents = document.querySelectorAll('.tab-content');
            
            tabButtons.forEach(button => {
                button.addEventListener('click', function() {
                    const tabId = this.dataset.tab;
                    
                    // Remove active class from all buttons
                    tabButtons.forEach(btn => btn.classList.remove('active'));
                    
                    // Add active class to clicked button
                    this.classList.add('active');
                    
                    // Hide all tab contents
                    tabContents.forEach(content => content.classList.remove('active'));
                    
                    // Show the selected tab content
                    document.getElementById(tabId).classList.add('active');
                });
            });

            // File upload name display
            const avatarUpload = document.getElementById('avatarUpload');
            const fileName = document.getElementById('fileName');
            
            if (avatarUpload && fileName) {
                avatarUpload.addEventListener('change', function() {
                    if (this.files && this.files.length > 0) {
                        fileName.textContent = this.files[0].name;
                    } else {
                        fileName.textContent = 'No file chosen';
                    }
                });
            }

            // Initialize flatpickr with day/month/year format
            flatpickr("#dateOfBirth", {
                dateFormat: "d/m/Y",
                allowInput: true,
            });

            flatpickr("#issueDate", {
                dateFormat: "d/m/Y", // DD/MM/YYYY format
                allowInput: true
            });

            flatpickr("#expiryDate", {
                dateFormat: "d/m/Y", // DD/MM/YYYY format
                allowInput: true
            });
        });
    </script>
</body>
</html>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\Sangay Ngedup\Documents\GitHub\FinalProject\resources\views/customer/profile.blade.php ENDPATH**/ ?>