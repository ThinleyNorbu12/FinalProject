

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


    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
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
            display: flex;
            align-items: center;
            font-size: 0.9rem;
            color: #666;
            margin-bottom: 5px;
        }
    
        .info-label i {
            color: #4e73df;
            width: 20px;
            text-align: center;
            margin-right: 5px;
        }
    
        .info-value {
            font-size: 1.1rem;
            color: #333;
            font-weight: 500;
            padding-left: 22px;
        }
    
        .license-images {
            display: flex;
            flex-wrap: wrap;
            gap: 20px;
            justify-content: center;
            margin-top: 20px;
        }
    
        .image-container {
            flex: 1 1 45%;
            text-align: center;
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
            max-width: 100%;
            height: auto;
            border: 1px solid #ddd;
            border-radius: 8px;
            box-shadow: 0 2px 5px rgba(0,0,0,0.1);
            margin-top: 10px;
        }
    
        .no-image {
            height: 280px;
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            background-color: #f8f9fa;
            border: 1px dashed #ccc;
            border-radius: 8px;
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
    
        .license-status-section {
            margin: 15px 0;
            padding: 15px;
            background-color: #f1f5ff;
            border-radius: 8px;
            border-left: 4px solid #4e73df;
        }
    
        .badge {
            font-size: 0.9rem;
            padding: 0.5em 0.75em;
            border-radius: 30px;
        }
    
        .validity-section {
            margin: 20px 0;
            padding: 15px;
            border-radius: 8px;
            background-color: #f8f9fa;
            border: 1px solid #e9ecef;
        }
    
        .validity-text {
            font-size: 1.1rem;
            font-weight: 500;
            margin-bottom: 12px;
        }
    
        .validity-progress {
            margin-top: 10px;
        }
    
        .progress-bar {
            height: 12px;
            background-color: #e9ecef;
            border-radius: 6px;
            overflow: hidden;
            position: relative;
        }
    
        .progress-fill {
            height: 100%;
            position: absolute;
            left: 0;
            top: 0;
            transition: width 0.5s ease;
        }
    
        .bg-danger { background-color: #dc3545; }
        .bg-warning { background-color: #ffc107; }
        .bg-success { background-color: #28a745; }
    
        .progress-labels {
            display: flex;
            justify-content: space-between;
            font-size: 0.8rem;
            color: #6c757d;
            margin-top: 5px;
        }
    
        /* Responsive Adjustments */
        @media (max-width: 992px) {
            .image-container {
                flex: 1 1 100%;
            }
            .license-info {
                grid-template-columns: 1fr;
            }
            .info-value {
                font-size: 1rem;
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




<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\Sangay Ngedup\Documents\GitHub\FinalProject\resources\views/customer/license.blade.php ENDPATH**/ ?>