<!-- Header -->
<link rel="stylesheet" href="<?php echo e(asset('assets/css/header.css')); ?>">
<header>
    <nav class="navbar navbar-expand-lg navbar-light bg-white shadow-sm">
        <div class="container-fluid">
            <!-- Sidebar Toggle Button -->
            <button class="btn" id="sidebarToggle">
                <i class="fas fa-bars"></i>
            </button>
            
            <!-- Logo and Brand - Dynamic based on user role -->
            <?php if(Auth::check()): ?>
                <?php if(Auth::user()->role === 'admin'): ?>
                    <a class="navbar-brand ms-2" href="<?php echo e(route('admin.dashboard')); ?>">
                        <img src="<?php echo e(asset('assets/images/logo.png')); ?>" alt="Logo" height="30">
                        <span class="ms-2 fw-bold text-primary">Admin Dashboard</span>
                    </a>
                <?php elseif(Auth::user()->role === 'car_owner'): ?>
                    <a class="navbar-brand ms-2" href="<?php echo e(route('carowner.dashboard')); ?>">
                        <img src="<?php echo e(asset('assets/images/logo.png')); ?>" alt="Logo" height="30">
                        <span class="ms-2 fw-bold text-success">CarOwner Dashboard</span>
                    </a>
                <?php elseif(Auth::user()->role === 'customer'): ?>
                    <a class="navbar-brand ms-2" href="<?php echo e(route('customer.dashboard')); ?>">
                        <img src="<?php echo e(asset('assets/images/logo.png')); ?>" alt="Logo" height="30">
                        <span class="ms-2 fw-bold text-info">Customer Dashboard</span>
                    </a>
                <?php else: ?>
                    <a class="navbar-brand ms-2" href="<?php echo e(route('home')); ?>">
                        <img src="<?php echo e(asset('assets/images/logo.png')); ?>" alt="Logo" height="30">
                        <span class="ms-2 fw-bold text-primary">Car Rental System</span>
                    </a>
                <?php endif; ?>
            <?php else: ?>
                <a class="navbar-brand ms-2" href="<?php echo e(route('home')); ?>">
                    <img src="<?php echo e(asset('assets/images/logo.png')); ?>" alt="Logo" height="30">
                    <span class="ms-2 fw-bold text-primary">Car Rental System</span>
                </a>
            <?php endif; ?>
            
            <!-- Right Side Navigation -->
            <div class="ms-auto d-flex align-items-center">
                <!-- Notifications -->
                <div class="header-notifications">
                    <div class="dropdown me-3">
                        <button class="dropdown-toggle btn btn-link nav-link position-relative" id="notificationDropdown" data-bs-toggle="dropdown" aria-expanded="false">
                            <i class="fas fa-bell"></i>
                            <span class="badge position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger">3</span>
                        </button>
                        <div class="dropdown-menu dropdown-menu-end" aria-labelledby="notificationDropdown">
                            <div class="dropdown-header d-flex justify-content-between align-items-center">
                                <span>Notifications</span>
                                <a href="#" class="text-decoration-none small">Mark all as read</a>
                            </div>
                            <div class="dropdown-item d-flex align-items-center py-2">
                                <i class="fas fa-user-plus text-primary me-3"></i>
                                <div class="notification-content">
                                    <p class="mb-0">New user registration</p>
                                    <span class="small text-muted">15 minutes ago</span>
                                </div>
                            </div>
                            <div class="dropdown-item d-flex align-items-center py-2">
                                <i class="fas fa-car text-success me-3"></i>
                                <div class="notification-content">
                                    <p class="mb-0">New car inspection request</p>
                                    <span class="small text-muted">1 hour ago</span>
                                </div>
                            </div>
                            <div class="dropdown-item d-flex align-items-center py-2">
                                <i class="fas fa-calendar-check text-warning me-3"></i>
                                <div class="notification-content">
                                    <p class="mb-0">New booking request</p>
                                    <span class="small text-muted">3 hours ago</span>
                                </div>
                            </div>
                            <div class="dropdown-footer text-center py-2 border-top">
                                <a href="#" class="text-decoration-none">View all notifications</a>
                            </div>
                        </div>
                    </div>
                </div>
                
                <!-- User Profile -->
                <div class="dropdown">
                    <a class="nav-link dropdown-toggle d-flex align-items-center" href="#" role="button" id="userDropdown" data-bs-toggle="dropdown" aria-expanded="false">
                        <?php if(Auth::check()): ?>
                            <img src="<?php echo e(asset('assets/images/' . (Auth::user()->profile_image ?? 'thinley.jpg'))); ?>" class="rounded-circle me-2" alt="Profile" width="32" height="32">
                            <span><?php echo e(Auth::user()->name ?? 'User'); ?></span>
                        <?php else: ?>
                            <img src="<?php echo e(asset('assets/images/thinley.jpg')); ?>" class="rounded-circle me-2" alt="Profile" width="32" height="32">
                            <span>Guest</span>
                        <?php endif; ?>
                    </a>
                    <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="userDropdown">
                        <li><a class="dropdown-item" href="#"><i class="fas fa-user me-2"></i> Profile</a></li>
                        <li><a class="dropdown-item" href="#"><i class="fas fa-cog me-2"></i> Settings</a></li>
                        <li><hr class="dropdown-divider"></li>
                        <li>
                            <a class="dropdown-item" href="#" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                                <i class="fas fa-sign-out-alt me-2"></i> Logout
                            </a>
                            <form id="logout-form" action="<?php echo e(route('logout')); ?>" method="POST" class="d-none">
                                <?php echo csrf_field(); ?>
                            </form>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </nav>
</header><?php /**PATH C:\Users\Sangay Ngedup\Documents\GitHub\FinalProject\resources\views/layouts/header.blade.php ENDPATH**/ ?>