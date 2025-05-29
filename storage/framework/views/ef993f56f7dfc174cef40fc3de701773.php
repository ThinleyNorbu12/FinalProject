<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="<?php echo e(csrf_token()); ?>">
    <title><?php echo $__env->yieldContent('title', 'Car Owner Dashboard'); ?> - Car Rental System</title>

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- CSS Dependencies -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">

    <!-- Custom CSS -->
    <link rel="stylesheet" href="<?php echo e(asset('assets/css/carowner/carownersidebar.css')); ?>">

    <?php echo $__env->yieldContent('head'); ?>
    <?php echo $__env->yieldPushContent('styles'); ?>
</head>
<body>
<header class="admin-header" id="adminHeader">
    <div class="header-left">
        <button class="mobile-menu-toggle d-md-none" id="mobileMenuToggle">
            <i class="fas fa-bars"></i>
        </button>
         <a href="<?php echo e(route('carowner.dashboard')); ?>" class="header-brand d-none d-md-flex">
            <img src="<?php echo e(asset('assets/images/logo1.png')); ?>" alt="Logo" style="height: 80px !important;">
            <span style="font-size: 1.5rem !important; font-weight: 700 !important;">CAR RENTAL SYSTEM</span>
        </a>
    </div>

    <div class="header-actions">

        <?php if(Auth::guard('carowner')->check()): ?>
            <div class="header-profile dropdown">
                <a class="nav-link dropdown-toggle d-flex align-items-center" href="#" role="button" id="userDropdown"
                   data-bs-toggle="dropdown" aria-expanded="false">
                    <img src="<?php echo e(asset('assets/images/thinley.jpg')); ?>" alt="Avatar"
                         class="rounded-circle me-2" width="32" height="32">
                    <div class="header-profile-info d-none d-sm-block">
                        <h4 class="mb-0"><?php echo e(Auth::guard('carowner')->user()->name); ?>!</h4>
                        <span>Car Owner</span>
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
                        <a class="dropdown-item" href="#" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                            <i class="fas fa-sign-out-alt me-2"></i> Logout
                        </a>
                        <form id="logout-form" action="<?php echo e(route('carowner.logout')); ?>" method="POST" class="d-none"><?php echo csrf_field(); ?></form>
                    </li>
                </ul>
            </div>
        <?php else: ?>
            <a href="<?php echo e(route('carowner.login')); ?>" class="btn btn-primary">Login</a>
        <?php endif; ?>
    </div>
</header>

<div class="admin-dashboard" id="adminDashboard">
    <div class="sidebar-overlay" id="sidebarOverlay"></div>

    <div class="dashboard-sidebar" id="dashboardSidebar">
        <div class="sidebar-header"></div>

        <div class="admin-profile">
            <?php if(Auth::guard('carowner')->check()): ?>
                <div class="profile-avatar">
                    <img src="<?php echo e(asset('assets/images/thinley.jpg')); ?>" alt="Avatar">
                </div>
                <div class="profile-info">
                    <h3><?php echo e(Auth::guard('carowner')->user()->name); ?></h3>
                    <span>Car Owner</span>
                </div>
            <?php endif; ?>
        </div>

        <div class="sidebar-menu">
            <a href="<?php echo e(route('carowner.dashboard')); ?>" class="sidebar-menu-item <?php echo e(request()->routeIs('admin.dashboard') ? 'active' : ''); ?>">
                <i class="fas fa-tachometer-alt"></i>
                <span>Dashboard</span>
            </a>

            <!-- <div class="sidebar-divider"></div>
            <div class="sidebar-heading">Manage Service</div> -->
            <div class="sidebar-divider"></div>
            <div class="sidebar-heading">Car Owner</div>

            <a href="<?php echo e(route('carowner.rentCar')); ?>">
                <i class="fas fa-car"></i>
                <span>Rent a Car</span>
                <div class="tooltip">Rent a Car</div>
            </a>

            
            <a href="<?php echo e(route('carowner.car-inspection')); ?>">
                <i class="fas fa-search"></i>
                <span>Inspection Requests</span>
            </a>
            <a href="<?php echo e(route('carowner.approved')); ?>">
                <i class="fas fa-check-circle"></i>
                <span>Approved Cars</span>
            </a>
            <a href="<?php echo e(route('carowner.rejected')); ?>">
                <i class="fas fa-times-circle"></i>
                <span>Rejected Cars</span>
            </a>

            <!-- <a href="<?php echo e(route('admin.payments.index')); ?>" class="sidebar-menu-item <?php echo e(request()->routeIs('admin.payments.index') ? 'active' : ''); ?>">
                <i class="fas fa-credit-card"></i>
                <span>Payments</span>
            </a> -->

            <!-- <button class="dark-mode-toggle" id="darkModeToggle">
                <div class="toggle-text">
                    <i class="fas fa-moon"></i>
                    <span>Dark Mode</span>
                </div>
                <div class="toggle-switch" id="toggleSwitch">
                    <div class="toggle-slider"></div>
                </div>
            </button> -->

            <a href="#" class="sidebar-menu-item" onclick="document.getElementById('sidebar-logout-form').submit();">
                <i class="fas fa-sign-out-alt"></i>
                <span>Logout</span>
            </a>
            <form method="POST" action="<?php echo e(route('carowner.logout')); ?>" id="sidebar-logout-form" class="d-none"><?php echo csrf_field(); ?></form>
        </div>
    </div>

    <div class="dashboard-content" id="dashboardContent">
        <?php if(!empty($breadcrumbs) || View::hasSection('breadcrumbs')): ?>
            <nav class="page-breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item">
                        <i class="fas fa-home"></i>
                        <a href="<?php echo e(route('carowner.dashboard')); ?>">Home</a>
                    </li>
                    <?php if(View::hasSection('breadcrumbs')): ?>
                        <?php echo $__env->yieldContent('breadcrumbs'); ?>
                    <?php elseif(isset($breadcrumbs)): ?>
                        <?php $__currentLoopData = $breadcrumbs; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $breadcrumb): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <li class="breadcrumb-item<?php echo e($loop->last ? ' active' : ''); ?>">
                                <?php if(!$loop->last): ?>
                                    <a href="<?php echo e($breadcrumb['url']); ?>"><?php echo e($breadcrumb['title']); ?></a>
                                <?php else: ?>
                                    <?php echo e($breadcrumb['title']); ?>

                                <?php endif; ?>
                            </li>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    <?php endif; ?>
                </ol>
            </nav>
        <?php endif; ?>

        <?php if(View::hasSection('page-header')): ?>
            <div class="page-header"><?php echo $__env->yieldContent('page-header'); ?></div>
        <?php endif; ?>

        <?php $__currentLoopData = ['success', 'error', 'warning', 'info']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $msg): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <?php if(session($msg)): ?>
                <div class="alert alert-<?php echo e($msg); ?> alert-dismissible fade show" role="alert">
                    <i class="fas fa-<?php echo e($msg == 'success' ? 'check-circle' : ($msg == 'error' ? 'exclamation-circle' : ($msg == 'warning' ? 'exclamation-triangle' : 'info-circle'))); ?> me-2"></i>
                    <?php echo e(session($msg)); ?>

                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            <?php endif; ?>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

        <div class="main-content">
            <?php echo $__env->yieldContent('content'); ?>
        </div>
    </div>
</div>

<!-- JavaScript Dependencies -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

<script>
    // CSRF Token setup for AJAX
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    // Sidebar toggle for mobile
    $('#mobileMenuToggle').on('click', function () {
        $('#dashboardSidebar').toggleClass('open');
        $('#sidebarOverlay').toggleClass('active');
    });

    $('#sidebarOverlay').on('click', function () {
        $('#dashboardSidebar').removeClass('open');
        $(this).removeClass('active');
    });

    // Dark mode toggle (basic version)
    $('#darkModeToggle').on('click', function () {
        $('body').toggleClass('dark-mode');
    });
</script>

<?php echo $__env->yieldContent('scripts'); ?>
<?php echo $__env->yieldPushContent('scripts'); ?>
</body>
</html>
<?php /**PATH C:\Users\Thinley Norbu\Documents\GitHub\FinalProject\resources\views/layouts/carowner.blade.php ENDPATH**/ ?>