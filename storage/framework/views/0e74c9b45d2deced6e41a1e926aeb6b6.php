<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="<?php echo e(csrf_token()); ?>">
    <title><?php echo $__env->yieldContent('title', 'Car Rental System'); ?></title>

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    
    <!-- Font Awesome (Icons) -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    <!-- Custom CSS -->
    <link rel="stylesheet" href="<?php echo e(asset('assets/css/styles.css')); ?>">

    <?php echo $__env->yieldContent('head'); ?>
</head>
<body class="bg-light d-flex flex-column min-vh-100">

    <!-- Header Section -->
    <header class="bg-dark text-white">
        <nav class="navbar navbar-expand-lg navbar-dark container">
            <div class="container-fluid">
                <a class="navbar-brand" href="/">Car Rental System</a>
                
                <?php if (! (
                    Request::is('login') || 
                    Request::is('register') ||
                    Request::is('admin/login') ||
                    Request::is('admin/register') ||
                    Request::is('customer/login') ||
                    Request::is('customer/register') ||
                    Request::is('carowner/login') ||
                    Request::is('carowner/register')
                )): ?>
                    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                        <span class="navbar-toggler-icon"></span>
                    </button>
                    <div class="collapse navbar-collapse" id="navbarNav">
                        
                        <ul class="navbar-nav">
                            <?php if(auth()->guard()->check()): ?>
                                <li class="nav-item dropdown">
                                    <a class="nav-link dropdown-toggle" href="#" id="userDropdown" role="button" data-bs-toggle="dropdown">
                                        <i class="fas fa-user-circle me-1"></i> <?php echo e(Auth::user()->name); ?>

                                    </a>
                                    <ul class="dropdown-menu dropdown-menu-end">
                                        <li><a class="dropdown-item" href="/profile">Profile</a></li>
                                        <li><a class="dropdown-item" href="/bookings">My Bookings</a></li>
                                        <li><hr class="dropdown-divider"></li>
                                        <li>
                                            <form method="POST" action="<?php echo e(route('logout')); ?>">
                                                <?php echo csrf_field(); ?>
                                                <button type="submit" class="dropdown-item">Logout</button>
                                            </form>
                                        </li>
                                    </ul>
                                </li>
                            <?php else: ?>
                                <li class="nav-item">
                                    <a class="nav-link" href="<?php echo e(route('login')); ?>">Login</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" href="<?php echo e(route('register')); ?>">Register</a>
                                </li>
                            <?php endif; ?>
                        </ul>
                    </div>
                <?php endif; ?>
            </div>
        </nav>
    </header>

    <!-- Main Content Section -->
    <main class="flex-grow-1 py-4">
        <div class="container">
            <?php echo $__env->yieldContent('content'); ?>
        </div>
    </main>

    <!-- Footer Section - Hidden on auth pages -->
    <?php if (! (
        Request::is('login') || 
        Request::is('register') ||
        Request::is('admin/login') ||
        Request::is('admin/register') ||
        Request::is('customer/login') ||
        Request::is('customer/register') ||
        Request::is('carowner/login') ||
        Request::is('carowner/register')
    )): ?>
        <footer class="bg-dark text-white py-4 mt-auto">
            <div class="container">
                <div class="row">
                    <div class="col-md-4 mb-3">
                        <h5>About Us</h5>
                        <p>Your premier car rental service offering quality vehicles at competitive prices.</p>
                    </div>
                    <div class="col-md-4 mb-3">
                        <h5>Quick Links</h5>
                        <ul class="list-unstyled">
                            <li><a href="/" class="text-white">Home</a></li>
                            <li><a href="/cars" class="text-white">Our Fleet</a></li>
                            <li><a href="/terms" class="text-white">Terms & Conditions</a></li>
                            <li><a href="/privacy" class="text-white">Privacy Policy</a></li>
                        </ul>
                    </div>
                    <div class="col-md-4 mb-3">
                        <h5>Contact Us</h5>
                        <address>
                            <i class="fas fa-map-marker-alt me-2"></i> 123 Rental St, City<br>
                            <i class="fas fa-phone me-2"></i> (123) 456-7890<br>
                            <i class="fas fa-envelope me-2"></i> info@carrental.com
                        </address>
                        <div class="social-icons">
                            <a href="#" class="text-white me-2"><i class="fab fa-facebook-f"></i></a>
                            <a href="#" class="text-white me-2"><i class="fab fa-twitter"></i></a>
                            <a href="#" class="text-white me-2"><i class="fab fa-instagram"></i></a>
                            <a href="#" class="text-white"><i class="fab fa-linkedin-in"></i></a>
                        </div>
                    </div>
                </div>
                <hr class="bg-light">
                <div class="text-center">
                    <p class="mb-0">&copy; <?php echo e(date('Y')); ?> Car Rental System. All rights reserved.</p>
                </div>
            </div>
        </footer>
    <?php endif; ?>

    <!-- Bootstrap Bundle with Popper -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>

    <!-- AJAX setup for CSRF token -->
    <script>
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
    </script>

    <!-- Page Specific Scripts -->
    <?php echo $__env->yieldContent('scripts'); ?>
</body>
</html><?php /**PATH C:\Users\Thinley Norbu\Documents\GitHub\FinalProject\resources\views/layouts/app.blade.php ENDPATH**/ ?>