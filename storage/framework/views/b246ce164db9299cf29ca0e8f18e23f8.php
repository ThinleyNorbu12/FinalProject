<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $__env->yieldContent('title', 'Admin Dashboard'); ?> - Car Rental System</title>
    
    <!-- CSS Dependencies -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    
    
    <!-- Custom Admin CSS -->
    
    <link rel="stylesheet" href="<?php echo e(asset('assets/css/admin/adminsidebar.css')); ?>">
    <!-- Additional CSS -->
    <?php echo $__env->yieldPushContent('styles'); ?>
</head>
<body>
    <!-- Enhanced Admin Header -->
    <header class="admin-header" id="adminHeader">
        <div class="header-left">
            <button class="mobile-menu-toggle d-md-none" id="mobileMenuToggle">
                <i class="fas fa-bars"></i>
            </button>
            
            <a href="<?php echo e(route('admin.dashboard')); ?>" class="header-brand d-none d-md-flex">
                <img src="<?php echo e(asset('assets/images/logo.png')); ?>" alt="Logo">
                <span>Car Rental System</span>
            </a>

            <div class="header-search d-none d-lg-block">
                <i class="fas fa-search"></i>
                <input type="text" placeholder="Search anything...">
            </div>
        </div>

        <div class="header-actions">
            <div class="header-action-item" title="Notifications">
                <i class="fas fa-bell"></i>
                <span class="badge">3</span>
            </div>
            
            <div class="header-action-item" title="Messages">
                <i class="fas fa-envelope"></i>
                <span class="badge">5</span>
            </div>

            <?php if(Auth::guard('admin')->check()): ?>
                <div class="header-profile dropdown">
                    <a class="nav-link dropdown-toggle d-flex align-items-center" href="#" role="button" id="userDropdown"
                       data-bs-toggle="dropdown" aria-expanded="false">
                        <img src="<?php echo e(asset('assets/images/thinley.jpg')); ?>" alt="Admin Avatar"
                             class="rounded-circle me-2" width="32" height="32">
                        <div class="header-profile-info d-none d-sm-block">
                            <h4 class="mb-0"><?php echo e(Auth::guard('admin')->user()->name); ?></h4>
                            <span>Administrator</span>
                        </div>
                    </a>
                    
                    <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="userDropdown">
                        <li>
                            <a class="dropdown-item" href="<?php echo e(route('admin.profile')); ?>">
                                <i class="fas fa-user me-2"></i> Profile
                            </a>
                        </li>
                        <li><hr class="dropdown-divider"></li>
                        <li>
                            <a class="dropdown-item" href="#"
                               onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                                <i class="fas fa-sign-out-alt me-2"></i> Logout
                            </a>
                            <form id="logout-form" action="<?php echo e(route('admin.logout')); ?>" method="POST" class="d-none">
                                <?php echo csrf_field(); ?>
                            </form>
                        </li>
                    </ul>
                </div>
            <?php else: ?>
                <a href="<?php echo e(route('admin.login')); ?>" class="btn btn-primary">Login</a>
            <?php endif; ?>
        </div>
    </header>

    <div class="admin-dashboard" id="adminDashboard">
        <!-- Sidebar Overlay -->
        <div class="sidebar-overlay" id="sidebarOverlay"></div>

        <!-- Dashboard Sidebar -->
        <div class="dashboard-sidebar" id="dashboardSidebar">
            <!-- Enhanced Arrow Toggle Button -->
            <div class="sidebar-header">
                
            </div>

            <div class="admin-profile">
                <?php if(Auth::guard('admin')->check()): ?>
                    <div class="profile-avatar">
                        <img src="<?php echo e(asset('assets/images/thinley.jpg')); ?>" alt="Admin Avatar">
                    </div>
                    <div class="profile-info">
                        <h3><?php echo e(Auth::guard('admin')->user()->name); ?></h3>
                        <span>Administrator</span>
                    </div>
                <?php endif; ?>
            </div>

            <div class="sidebar-menu">
                <a href="<?php echo e(route('admin.dashboard')); ?>" class="sidebar-menu-item <?php echo e(request()->routeIs('admin.dashboard') ? 'active' : ''); ?>">
                    <i class="fas fa-tachometer-alt"></i>
                    <span>Dashboard</span>
                </a>
                
                <div class="sidebar-divider"></div>
                <div class="sidebar-heading">Manage Service</div>
                
                <a href="<?php echo e(route('cars.index')); ?>" class="sidebar-menu-item <?php echo e(request()->routeIs('cars.index') ? 'active' : ''); ?>">
                    <i class="fas fa-car"></i>
                    <span>Cars</span>
                    <div class="tooltip">Cars</div>
                </a>

                <div class="sidebar-divider"></div>
                <div class="sidebar-heading">Car Owner</div>

                <a href="<?php echo e(route('car-admin.new-registration-cars')); ?>" class="sidebar-menu-item <?php echo e(request()->routeIs('car-admin.new-registration-cars') ? 'active' : ''); ?>">
                    <i class="fas fa-car"></i>
                    <span>Car Registration</span>
                    <div class="tooltip">Car Registration</div>
                </a>

                <a href="<?php echo e(route('car-admin.inspection-requests')); ?>" class="sidebar-menu-item <?php echo e(request()->routeIs('car-admin.inspection-requests') ? 'active' : ''); ?>">
                    <i class="fas fa-clipboard-check"></i>
                    <span>Inspection Requests</span>
                    <div class="tooltip">Inspection Requests</div>
                </a>

                <a href="<?php echo e(route('car-admin.approve-inspected-cars')); ?>" class="sidebar-menu-item <?php echo e(request()->routeIs('car-admin.approve-inspected-cars') ? 'active' : ''); ?>">
                    <i class="fas fa-check-circle"></i>
                    <span>Approve Inspections</span>
                    <div class="tooltip">Approve Inspections</div>
                </a>

                <div class="sidebar-divider"></div>
                <div class="sidebar-heading">Customer</div>

                <a href="<?php echo e(route('admin.verify-users')); ?>" class="sidebar-menu-item <?php echo e(request()->routeIs('admin.verify-users') ? 'active' : ''); ?>">
                    <i class="fas fa-id-card"></i>
                    <span>Verify Users</span>
                    <div class="tooltip">Verify Users</div>
                </a>

                <a href="<?php echo e(route('admin.payments.index')); ?>" class="sidebar-menu-item <?php echo e(request()->routeIs('admin.payments.index') ? 'active' : ''); ?>">
                    <i class="fas fa-credit-card"></i>
                    <span>Payments</span>
                    <div class="tooltip">Payments</div>
                </a>

                <a href="#" class="sidebar-menu-item">
                    <i class="fas fa-edit"></i>
                    <span>Update Registration</span>
                    <div class="tooltip">Update Registration</div>
                </a>

                <a href="#" class="sidebar-menu-item">
                    <i class="fas fa-info-circle"></i>
                    <span>Car Information</span>
                    <div class="tooltip">Car Information</div>
                </a>

                <a href="<?php echo e(route('admin.booked-car')); ?>" class="sidebar-menu-item <?php echo e(request()->routeIs('admin.booked-car') ? 'active' : ''); ?>">
                    <i class="fas fa-calendar-check"></i>
                    <span>Booked Cars</span>
                    <div class="tooltip">Booked Cars</div>
                </a>

                <!-- Dark Mode Toggle -->
                <button class="dark-mode-toggle" id="darkModeToggle">
                    <div class="toggle-text">
                        <i class="fas fa-moon"></i>
                        <span>Dark Mode</span>
                    </div>
                    <div class="toggle-switch" id="toggleSwitch">
                        <div class="toggle-slider"></div>
                    </div>
                </button>

                <a href="#" class="sidebar-menu-item" onclick="document.getElementById('sidebar-logout-form').submit();">
                    <i class="fas fa-sign-out-alt"></i>
                    <span>Logout</span>
                    <div class="tooltip">Logout</div>
                </a>

                <form method="POST" action="<?php echo e(route('admin.logout')); ?>" id="sidebar-logout-form" style="display: none;">
                    <?php echo csrf_field(); ?>
                </form>
            </div>
        </div>

        <div class="dashboard-content" id="dashboardContent">
            <!-- Breadcrumb Navigation -->
            <?php if(!empty($breadcrumbs) || View::hasSection('breadcrumbs')): ?>
                <nav class="page-breadcrumb">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item">
                            <i class="fas fa-home"></i>
                            <a href="<?php echo e(route('admin.dashboard')); ?>">Home</a>
                        </li>
                        <?php if(View::hasSection('breadcrumbs')): ?>
                            <?php echo $__env->yieldContent('breadcrumbs'); ?>
                        <?php else: ?>
                            <?php if(isset($breadcrumbs)): ?>
                                <?php $__currentLoopData = $breadcrumbs; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $breadcrumb): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <?php if($loop->last): ?>
                                        <li class="breadcrumb-item active"><?php echo e($breadcrumb['title']); ?></li>
                                    <?php else: ?>
                                        <li class="breadcrumb-item">
                                            <a href="<?php echo e($breadcrumb['url']); ?>"><?php echo e($breadcrumb['title']); ?></a>
                                        </li>
                                    <?php endif; ?>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            <?php endif; ?>
                        <?php endif; ?>
                    </ol>
                </nav>
            <?php endif; ?>

            <!-- Page Header -->
            <?php if(View::hasSection('page-header')): ?>
                <div class="page-header">
                    <?php echo $__env->yieldContent('page-header'); ?>
                </div>
            <?php endif; ?>

            <!-- Flash Messages -->
            <?php if(session('success')): ?>
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    <i class="fas fa-check-circle me-2"></i>
                    <?php echo e(session('success')); ?>

                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            <?php endif; ?>

            <?php if(session('error')): ?>
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    <i class="fas fa-exclamation-circle me-2"></i>
                    <?php echo e(session('error')); ?>

                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            <?php endif; ?>

            <?php if(session('warning')): ?>
                <div class="alert alert-warning alert-dismissible fade show" role="alert">
                    <i class="fas fa-exclamation-triangle me-2"></i>
                    <?php echo e(session('warning')); ?>

                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            <?php endif; ?>

            <?php if(session('info')): ?>
                <div class="alert alert-info alert-dismissible fade show" role="alert">
                    <i class="fas fa-info-circle me-2"></i>
                    <?php echo e(session('info')); ?>

                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            <?php endif; ?>

            <!-- Main Content Area -->
            <div class="main-content">
                <?php echo $__env->yieldContent('content'); ?>
            </div>
        </div>
    </div>

    <!-- Enhanced Admin Footer -->
    

    <!-- JavaScript Dependencies -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="<?php echo e(asset('assets/js/admin-dashboard.js')); ?>"></script>
    
    <!-- Additional JavaScript -->
    <?php echo $__env->yieldPushContent('scripts'); ?>
</body>
</html><?php /**PATH C:\Users\Sangay Ngedup\Documents\GitHub\FinalProject\resources\views/layouts/admin.blade.php ENDPATH**/ ?>