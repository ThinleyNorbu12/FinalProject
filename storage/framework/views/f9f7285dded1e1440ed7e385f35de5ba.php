

<?php $__env->startSection('content'); ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Driving License - Car Rental</title>
    <!-- Link to the external CSS file -->
    <link rel="stylesheet" href="<?php echo e(asset('assets/css/customer/dashboard.css')); ?>">
    <!-- Custom CSS for license page -->
    <style>
        .license-container {
            background-color: #fff;
            border-radius: 10px;
            box-shadow: 0 2px 15px rgba(0, 0, 0, 0.1);
            padding: 30px;
            margin-bottom: 30px;
        }
        
        .license-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 20px;
            border-bottom: 1px solid #eee;
            padding-bottom: 15px;
        }
        
        .license-title h2 {
            color: #333;
            margin: 0;
            font-size: 1.8rem;
        }
        
        .license-title p {
            color: #666;
            margin: 5px 0 0;
        }
        
        .license-status {
            padding: 6px 12px;
            border-radius: 30px;
            font-weight: 600;
            font-size: 0.9rem;
        }
        
        .status-valid {
            background-color: #d4edda;
            color: #155724;
        }
        
        .status-expired {
            background-color: #f8d7da;
            color: #721c24;
        }
        
        .status-expiring {
            background-color: #fff3cd;
            color: #856404;
        }
        
        .license-info {
            display: grid;
            grid-template-columns: repeat(2, 1fr);
            gap: 20px;
            margin-bottom: 30px;
        }
        
        .info-group {
            margin-bottom: 15px;
        }
        
        .info-label {
            font-size: 0.9rem;
            color: #666;
            margin-bottom: 5px;
        }
        
        .info-value {
            font-size: 1.1rem;
            color: #333;
            font-weight: 500;
        }
        
        .license-images {
            display: grid;
            grid-template-columns: repeat(2, 1fr);
            gap: 20px;
            margin-top: 20px;
        }
        
        .image-container {
            border: 1px solid #ddd;
            border-radius: 8px;
            overflow: hidden;
        }
        
        .image-container h4 {
            background-color: #f8f9fa;
            margin: 0;
            padding: 10px 15px;
            font-size: 1rem;
            border-bottom: 1px solid #ddd;
        }
        
        .license-image {
            width: 100%;
            padding: 15px;
            object-fit: contain;
            height: 280px;
            display: block;
        }
        
        .no-image {
            height: 280px;
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            background-color: #f8f9fa;
            color: #6c757d;
            padding: 15px;
        }
        
        .no-image i {
            font-size: 4rem;
            margin-bottom: 15px;
            opacity: 0.5;
        }
        
        .no-image p {
            font-size: 1rem;
            margin: 0;
        }
        
        .license-actions {
            display: flex;
            justify-content: flex-start;
            gap: 15px;
            margin-top: 25px;
        }
        
        .btn-primary {
            background-color: #4e73df;
            color: white;
            border: none;
            padding: 10px 20px;
            border-radius: 5px;
            cursor: pointer;
            font-weight: 500;
            transition: all 0.3s;
        }
        
        .btn-primary:hover {
            background-color: #375abd;
        }
        
        .btn-outline {
            background-color: transparent;
            color: #4e73df;
            border: 1px solid #4e73df;
            padding: 10px 20px;
            border-radius: 5px;
            cursor: pointer;
            font-weight: 500;
            transition: all 0.3s;
        }
        
        .btn-outline:hover {
            background-color: #eef1ff;
        }
        
        .no-license {
            text-align: center;
            padding: 50px 20px;
        }
        
        .no-license i {
            font-size: 3rem;
            color: #ccc;
            margin-bottom: 20px;
        }
        
        .no-license h3 {
            margin-bottom: 15px;
            color: #333;
        }
        
        .no-license p {
            color: #666;
            margin-bottom: 25px;
            max-width: 500px;
            margin-left: auto;
            margin-right: auto;
        }
        
        @media (max-width: 768px) {
            .license-info, 
            .license-images {
                grid-template-columns: 1fr;
            }
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
                
                <a href="#" class="sidebar-menu-item">
                    <i class="fas fa-car"></i>
                    <span>Browse Cars</span>
                </a>
                
                <a href="#" class="sidebar-menu-item">
                    <i class="fas fa-calendar-alt"></i>
                    <span>My Reservations</span>
                </a>
                
                <div class="sidebar-divider"></div>
                
                <div class="sidebar-heading">My Account</div>
                
                <a href="<?php echo e(route('customer.profile')); ?>" class="sidebar-menu-item">
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
                
                <a href="<?php echo e(route('customer.license')); ?>" class="sidebar-menu-item active">
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
                
                <div class="license-container">
                    <div class="license-header">
                        <div class="license-title">
                            <h2>Driving License Details</h2>
                            <p>License #<?php echo e($license->license_no); ?></p>
                        </div>
                        <span class="license-status <?php echo e($status_class); ?>"><?php echo e($status_text); ?></span>
                    </div>
                    
                    <div class="license-info">
                        <div>
                            <div class="info-group">
                                <div class="info-label">Full Name</div>
                                <div class="info-value"><?php echo e($customer->name); ?></div>
                            </div>
                            
                            <div class="info-group">
                                <div class="info-label">CID Number</div>
                                <div class="info-value"><?php echo e($customer->cid_no); ?></div>
                            </div>
                            
                            <div class="info-group">
                                <div class="info-label">Date of Birth</div>
                                <div class="info-value"><?php echo e(\Carbon\Carbon::parse($customer->date_of_birth)->format('F d, Y')); ?></div>
                            </div>
                        </div>
                        
                        <div>
                            <div class="info-group">
                                <div class="info-label">License Number</div>
                                <div class="info-value"><?php echo e($license->license_no); ?></div>
                            </div>
                            
                            <div class="info-group">
                                <div class="info-label">Issuing Dzongkhag</div>
                                <div class="info-value"><?php echo e($license->issuing_dzongkhag); ?></div>
                            </div>
                            
                            <div class="info-group">
                                <div class="info-label">Issue Date</div>
                                <div class="info-value"><?php echo e(\Carbon\Carbon::parse($license->issue_date)->format('F d, Y')); ?></div>
                            </div>
                            
                            <div class="info-group">
                                <div class="info-label">Expiry Date</div>
                                <div class="info-value"><?php echo e(\Carbon\Carbon::parse($license->expiry_date)->format('F d, Y')); ?></div>
                            </div>
                            
                            <div class="info-group">
                                <div class="info-label">Validity</div>
                                <div class="info-value">
                                    <?php if($days_remaining < 0): ?>
                                        <span class="text-danger">Expired <?php echo e(abs($days_remaining)); ?> days ago</span>
                                    <?php elseif($days_remaining <= 30): ?>
                                        <span class="text-warning">Expires in <?php echo e($days_remaining); ?> days</span>
                                    <?php else: ?>
                                        <span class="text-success">Valid for <?php echo e($days_remaining); ?> days</span>
                                    <?php endif; ?>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <div class="license-images">
                        <div class="image-container">
                            <h4>License Front</h4>
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
                            <h4>License Back</h4>
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
                    
                    <div class="license-actions">
                        <?php if($days_remaining < 30): ?>
                            <a href="https://eralis.rsta.gov.bt/services/driving/search?serviceType=driving_renewal" class="btn-primary" target="_blank">
                                <i class="fas fa-sync-alt"></i> Renew License
                            </a>
                        <?php endif; ?>
                        <button class="btn-outline" id="updateLicense">
                            <i class="fas fa-edit"></i> Update License Information
                        </button>
                    </div>
                    
                    <!-- <?php if(config('app.debug')): ?>
                        <div class="debug-info mt-4 p-3 bg-light border rounded">
                            <h5>Debug Information</h5>
                            <p><strong>Front Image:</strong> <?php echo e($license->license_front_image ?? 'Not set'); ?></p>
                            <p><strong>Front Image Path:</strong> <?php echo e($front_image_path); ?></p>
                            <p><strong>Front Image Exists:</strong> <?php echo e($front_exists ? 'Yes' : 'No'); ?></p>
                            <p><strong>Back Image:</strong> <?php echo e($license->license_back_image ?? 'Not set'); ?></p>
                            <p><strong>Back Image Path:</strong> <?php echo e($back_image_path); ?></p>
                            <p><strong>Back Image Exists:</strong> <?php echo e($back_exists ? 'Yes' : 'No'); ?></p>
                        </div>
                    <?php endif; ?> -->
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
        :root {
            --primary-color: #4e73df;
            --primary-dark: #375abd;
            --success-color: #1cc88a;
            --warning-color: #f6c23e;
            --danger-color: #e74a3b;
            --light-bg: #f8f9fc;
        }
        
        body {
            font-family: 'Nunito', sans-serif;
            background-color: #f8f9fc;
            color: #5a5c69;
        }
        
        .dashboard-container {
            display: flex;
            min-height: calc(100vh - 60px);
        }
        
        .main-header {
            display: flex;
            align-items: center;
            justify-content: space-between;
            background-color: #fff;
            height: 60px;
            padding: 0 20px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
            position: sticky;
            top: 0;
            z-index: 1000;
        }
        
        .header-logo {
            display: flex;
            align-items: center;
            font-weight: bold;
            font-size: 1.4rem;
            color: var(--primary-color);
        }
        
        .header-logo i {
            margin-right: 10px;
        }
        
        .header-menu-toggle {
            background: none;
            border: none;
            color: #5a5c69;
            font-size: 1.2rem;
            cursor: pointer;
            display: none;
        }
        
        .sidebar {
            width: 260px;
            background-color: #fff;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            padding: 20px 0;
            transition: all 0.3s;
            overflow-y: auto;
        }
        
        .sidebar-menu-item {
            display: flex;
            align-items: center;
            padding: 12px 20px;
            color: #5a5c69;
            text-decoration: none;
            transition: all 0.3s;
        }
        
        .sidebar-menu-item i {
            margin-right: 10px;
            width: 20px;
            text-align: center;
        }
        
        .sidebar-menu-item:hover {
            background-color: rgba(78, 115, 223, 0.1);
            color: var(--primary-color);
        }
        
        .sidebar-menu-item.active {
            background-color: var(--primary-color);
            color: #fff;
            border-radius: 0;
        }
        
        .main-content {
            flex: 1;
            padding: 25px;
            background-color: #f8f9fc;
            overflow-y: auto;
        }
        
        .welcome-card {
            background-color: #fff;
            border-radius: 10px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
            padding: 25px;
            margin-bottom: 25px;
            border-left: 4px solid var(--primary-color);
        }
        
        .welcome-card h2 {
            margin: 0;
            color: #2e384d;
            font-weight: 700;
            font-size: 1.5rem;
        }
        
        .welcome-card p {
            margin: 10px 0 0;
            color: #6e7891;
        }
        
        /* License specific styles (modified) */
        .license-container {
            background-color: #fff;
            border-radius: 10px;
            box-shadow: 0 2px 15px rgba(0, 0, 0, 0.1);
            padding: 30px;
            margin-bottom: 30px;
            animation: fadeIn 0.6s ease;
        }
        
        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(10px); }
            to { opacity: 1; transform: translateY(0); }
        }
        
        .license-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 25px;
            border-bottom: 1px solid #eee;
            padding-bottom: 15px;
        }
        
        .license-title h2 {
            color: #2e384d;
            margin: 0;
            font-size: 1.8rem;
            font-weight: 700;
        }
        
        .license-title p {
            color: #6e7891;
            margin: 5px 0 0;
            font-size: 1.1rem;
        }
        
        .license-status {
            padding: 8px 16px;
            border-radius: 30px;
            font-weight: 600;
            font-size: 0.9rem;
            display: flex;
            align-items: center;
        }
        
        .license-status i {
            margin-right: 6px;
        }
        
        .status-valid {
            background-color: rgba(28, 200, 138, 0.15);
            color: #1cc88a;
        }
        
        .status-expired {
            background-color: rgba(231, 74, 59, 0.15);
            color: #e74a3b;
        }
        
        .status-expiring {
            background-color: rgba(246, 194, 62, 0.15);
            color: #f6c23e;
        }
        
        .license-info {
            display: grid;
            grid-template-columns: repeat(2, 1fr);
            gap: 30px;
            margin-bottom: 30px;
            animation: slideIn 0.7s ease;
        }
        
        @keyframes slideIn {
            from { opacity: 0; transform: translateX(-10px); }
            to { opacity: 1; transform: translateX(0); }
        }
        
        .info-column {
            background-color: #f8f9fc;
            padding: 25px;
            border-radius: 10px;
            border: 1px solid #e3e6f0;
        }
        
        .info-group {
            margin-bottom: 20px;
            position: relative;
            padding-left: 35px;
        }
        
        .info-group:last-child {
            margin-bottom: 0;
        }
        
        .info-group i {
            position: absolute;
            left: 0;
            top: 5px;
            color: var(--primary-color);
            font-size: 1.2rem;
            width: 25px;
            text-align: center;
        }
        
        .info-label {
            font-size: 0.9rem;
            color: #858796;
            margin-bottom: 6px;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }
        
        .info-value {
            font-size: 1.15rem;
            color: #2e384d;
            font-weight: 600;
        }
        
        .validity-indicator {
            display: flex;
            align-items: center;
            margin-top: 5px;
        }
        
        .validity-indicator i {
            position: static;
            margin-right: 8px;
            font-size: 1rem;
        }
        
        .validity-days {
            font-weight: 600;
        }
        
        .license-images {
            display: grid;
            grid-template-columns: repeat(2, 1fr);
            gap: 25px;
            margin-top: 25px;
            animation: fadeUp 0.8s ease;
        }
        
        @keyframes fadeUp {
            from { opacity: 0; transform: translateY(20px); }
            to { opacity: 1; transform: translateY(0); }
        }
        
        .image-container {
            border: 1px solid #e3e6f0;
            border-radius: 8px;
            overflow: hidden;
            transition: all 0.3s;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.05);
        }
        
        .image-container:hover {
            transform: translateY(-5px);
            box-shadow: 0 8px 15px rgba(0, 0, 0, 0.1);
        }
        
        .image-container h4 {
            background-color: #f8f9fc;
            margin: 0;
            padding: 12px 15px;
            font-size: 1rem;
            border-bottom: 1px solid #e3e6f0;
            font-weight: 600;
            color: #2e384d;
            display: flex;
            align-items: center;
        }
        
        .image-container h4 i {
            margin-right: 8px;
            color: var(--primary-color);
        }
        
        .license-image {
            width: 100%;
            padding: 15px;
            object-fit: contain;
            height: 280px;
            display: block;
            transition: all 0.3s;
        }
        
        .license-image:hover {
            transform: scale(1.02);
        }
        
        .no-image {
            height: 280px;
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            background-color: #f8f9fc;
            color: #6c757d;
            padding: 15px;
        }
        
        .no-image i {
            font-size: 4rem;
            margin-bottom: 15px;
            opacity: 0.5;
            color: #b7b9cc;
        }
        
        .no-image p {
            font-size: 1rem;
            margin: 0;
        }
        
        .license-actions {
            display: flex;
            justify-content: flex-start;
            gap: 15px;
            margin-top: 30px;
            animation: fadeIn 0.9s ease;
        }
        
        .btn-primary {
            background-color: var(--primary-color);
            color: white;
            border: none;
            padding: 12px 24px;
            border-radius: 6px;
            cursor: pointer;
            font-weight: 600;
            transition: all 0.3s;
            display: flex;
            align-items: center;
        }
        
        .btn-primary i {
            margin-right: 8px;
        }
        
        .btn-primary:hover {
            background-color: var(--primary-dark);
            transform: translateY(-2px);
            box-shadow: 0 4px 10px rgba(78, 115, 223, 0.25);
        }
        
        .btn-outline {
            background-color: transparent;
            color: var(--primary-color);
            border: 1.5px solid var(--primary-color);
            padding: 12px 24px;
            border-radius: 6px;
            cursor: pointer;
            font-weight: 600;
            transition: all 0.3s;
            display: flex;
            align-items: center;
        }
        
        .btn-outline i {
            margin-right: 8px;
        }
        
        .btn-outline:hover {
            background-color: rgba(78, 115, 223, 0.1);
            transform: translateY(-2px);
        }
        
        .license-features {
            display: flex;
            flex-wrap: wrap;
            gap: 20px;
            margin-top: 30px;
            background-color: #f8f9fc;
            padding: 20px;
            border-radius: 10px;
            border: 1px solid #e3e6f0;
        }
        
        .feature-item {
            display: flex;
            align-items: center;
            padding: 10px 15px;
            background-color: #fff;
            border-radius: 8px;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.05);
            transition: all 0.3s;
        }
        
        .feature-item:hover {
            transform: translateY(-3px);
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
        }
        
        .feature-item i {
            margin-right: 10px;
            color: var(--primary-color);
            font-size: 1.2rem;
        }
        
        /* Responsive styles */
        @media (max-width: 992px) {
            .license-features {
                grid-template-columns: repeat(2, 1fr);
            }
        }
        
        @media (max-width: 768px) {
            .license-info, 
            .license-images {
                grid-template-columns: 1fr;
            }
            
            .header-menu-toggle {
                display: block;
            }
            
            .sidebar {
                position: fixed;
                left: -260px;
                height: calc(100vh - 60px);
                z-index: 999;
            }
            
            .sidebar.expanded {
                left: 0;
            }
            
            .dashboard-container {
                display: block;
            }
            
            .main-content {
                margin-left: 0;
                width: 100%;
            }
            
            .license-features {
                grid-template-columns: 1fr;
            }
        }
        
        /* Progress bar for validity */
        .validity-progress {
            height: 8px;
            background-color: #e9ecef;
            border-radius: 10px;
            margin-top: 8px;
            overflow: hidden;
        }
        
        .validity-bar {
            height: 100%;
            border-radius: 10px;
            background-color: var(--success-color);
            transition: width 1s ease;
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
            <span class="header-user-name">Thinley</span>
            <button type="submit" class="btn-logout">Logout</button>
        </div>        
    </header>

    <!-- Dashboard Container -->
    <div class="dashboard-container">
        <!-- Sidebar -->
        <div class="sidebar" id="sidebar">
            <div class="sidebar-menu">
                <a href="#" class="sidebar-menu-item">
                    <i class="fas fa-home"></i>
                    <span>Dashboard</span>
                </a>
                
                <a href="#" class="sidebar-menu-item">
                    <i class="fas fa-car"></i>
                    <span>Browse Cars</span>
                </a>
                
                <a href="#" class="sidebar-menu-item">
                    <i class="fas fa-calendar-alt"></i>
                    <span>My Reservations</span>
                </a>
                
                <div class="sidebar-divider"></div>
                
                <div class="sidebar-heading">My Account</div>
                
                <a href="#" class="sidebar-menu-item">
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
                
                <a href="#" class="sidebar-menu-item active">
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
                <h2>Your Driving License</h2>
                <p>View and manage your driving license details for car rentals</p>
            </div>
            
            <div class="license-container">
                <div class="license-header">
                    <div class="license-title">
                        <h2>Driving License Details</h2>
                        <p>License #T-109000</p>
                    </div>
                    <span class="license-status status-valid">
                        <i class="fas fa-check-circle"></i>
                        Valid
                    </span>
                </div>
                
                <div class="license-info">
                    <div class="info-column">
                        <div class="info-group">
                            <i class="fas fa-user"></i>
                            <div class="info-label">Full Name</div>
                            <div class="info-value">Thinley</div>
                        </div>
                        
                        <div class="info-group">
                            <i class="fas fa-id-badge"></i>
                            <div class="info-label">CID Number</div>
                            <div class="info-value">11514004750</div>
                        </div>
                        
                        <div class="info-group">
                            <i class="fas fa-birthday-cake"></i>
                            <div class="info-label">Date of Birth</div>
                            <div class="info-value">July 14, 2003</div>
                        </div>
                        
                        <div class="info-group">
                            <i class="fas fa-id-card"></i>
                            <div class="info-label">License Number</div>
                            <div class="info-value">T-109000</div>
                        </div>
                    </div>
                    
                    <div class="info-column">
                        <div class="info-group">
                            <i class="fas fa-map-marker-alt"></i>
                            <div class="info-label">Issuing Dzongkhag</div>
                            <div class="info-value">Thimphu</div>
                        </div>
                        
                        <div class="info-group">
                            <i class="fas fa-calendar-plus"></i>
                            <div class="info-label">Issue Date</div>
                            <div class="info-value">January 08, 2025</div>
                        </div>
                        
                        <div class="info-group">
                            <i class="fas fa-calendar-times"></i>
                            <div class="info-label">Expiry Date</div>
                            <div class="info-value">January 08, 2030</div>
                        </div>
                        
                        <div class="info-group">
                            <i class="fas fa-clock"></i>
                            <div class="info-label">Validity</div>
                            <div class="info-value">
                                <div class="validity-indicator">
                                    <i class="fas fa-shield-alt text-success"></i>
                                    <span class="validity-days text-success">Valid for 1707 days</span>
                                </div>
                                <div class="validity-progress">
                                    <div class="validity-bar" style="width: 95%"></div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                
                <!-- <div class="license-images">
                    <div class="image-container">
                        <h4><i class="fas fa-id-card"></i> License Front</h4>
                        <div class="no-image">
                            <i class="fas fa-id-card"></i>
                            <p>Front image not available</p>
                        </div>
                    </div>
                    
                    <div class="image-container">
                        <h4><i class="fas fa-id-card-alt"></i> License Back</h4>
                        <div class="no-image">
                            <i class="fas fa-id-card-alt"></i>
                            <p>Back image not available</p>
                        </div>
                    </div>
                </div> -->
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
                
                <div class="license-actions">
                    <button class="btn-outline" id="updateLicense">
                        <i class="fas fa-edit"></i> Update License Information
                    </button>
                    <!-- <button class="btn-primary" id="uploadImages">
                        <i class="fas fa-upload"></i> Upload License Images
                    </button> -->
                </div>
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
            
            // Button handlers (placeholder functionality)
            const updateLicenseBtn = document.getElementById('updateLicense');
            const uploadImagesBtn = document.getElementById('uploadImages');
            
            if(updateLicenseBtn) {
                updateLicenseBtn.addEventListener('click', function(e) {
                    e.preventDefault();
                    alert('Update license functionality will be implemented here');
                });
            }
            
            if(uploadImagesBtn) {
                uploadImagesBtn.addEventListener('click', function(e) {
                    e.preventDefault();
                    alert('Upload license images functionality will be implemented here');
                });
            }
        });
    </script>
</body>
</html>
<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\Sangay Ngedup\Documents\GitHub\FinalProject\resources\views/customer/license.blade.php ENDPATH**/ ?>