


<?php $__env->startSection('content'); ?>

<body>
    <!-- Header -->
     <?php if(session('success')): ?>
    <div class="alert alert-success">
        <?php echo e(session('success')); ?>

    </div>
    <?php endif; ?>

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
                
                <a href="<?php echo e(route('customer.browse-cars')); ?>" class="sidebar-menu-item">
                    <i class="fas fa-car"></i>
                    <span>Browse Cars</span>
                </a>
                
                <a href="<?php echo e(route('customer.my-reservations')); ?>" class="sidebar-menu-item">
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
                
                <a href="<?php echo e(route('customer.locations')); ?>" class="sidebar-menu-item active">
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
                
                
            </div>
        </div>
        
        <!-- Main Content -->
        <div class="main-content">
            <h1 class="page-title">Our Locations</h1>
            
            <div class="location-info-section">
                <div class="location-card primary-location">
                    <div class="location-header">
                        <i class="fas fa-building"></i>
                        <h3>Main Office</h3>
                    </div>
                    <div class="location-details">
                        <p><strong>Royal Institute of Management</strong></p>
                        <p><i class="fas fa-map-marker-alt"></i> Simtokha, Thimphu, Bhutan</p>
                        <p><i class="fas fa-phone"></i> +975 2 351013</p>
                        <p><i class="fas fa-clock"></i> Mon-Fri: 9:00 AM - 5:00 PM</p>
                        <p><i class="fas fa-clock"></i> Sat: 10:00 AM - 2:00 PM</p>
                        <p><i class="fas fa-clock"></i> Sun: Closed</p>
                    </div>
                </div>
                
                <div class="location-map">
                    <iframe 
                        src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3539.5834220155395!2d89.63466537557882!3d27.44462247631368!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x39e19419925ef911%3A0x3fa898c3ce9708dc!2sRoyal%20Institute%20of%20Management!5e0!3m2!1sen!2sus!4v1715943100222!5m2!1sen!2sus" 
                        width="100%" 
                        height="400" 
                        style="border:0;" 
                        allowfullscreen="" 
                        loading="lazy" 
                        referrerpolicy="no-referrer-when-downgrade">
                    </iframe>
                </div>
            </div>
            
            <div class="services-at-location">
                <h3>Services Available at This Location</h3>
                <div class="services-grid">
                    <div class="service-item">
                        <i class="fas fa-car"></i>
                        <span>Car Pickup/Return</span>
                    </div>
                    <div class="service-item">
                        <i class="fas fa-gas-pump"></i>
                        <span>Fuel Service</span>
                    </div>
                    <div class="service-item">
                        <i class="fas fa-tools"></i>
                        <span>Car Maintenance</span>
                    </div>
                    <div class="service-item">
                        <i class="fas fa-credit-card"></i>
                        <span>Payment Center</span>
                    </div>
                    <div class="service-item">
                        <i class="fas fa-car-crash"></i>
                        <span>Accident Support</span>
                    </div>
                    <div class="service-item">
                        <i class="fas fa-route"></i>
                        <span>Trip Planning</span>
                    </div>
                </div>
            </div>
            
            <div class="contact-section">
                <h3>Contact Us</h3>
                <div class="contact-form">
                    <form action="<?php echo e(route('customer.contact-submit')); ?>" method="POST">

                        <?php echo csrf_field(); ?>
                        <div class="form-group">
                            <label for="name">Name</label>
                            <input type="text" id="name" name="name" class="form-control" placeholder="Your name" required>
                        </div>
                        
                        <div class="form-group">
                            <label for="email">Email</label>
                            <input type="email" id="email" name="email" class="form-control" placeholder="Your email" required>
                        </div>
                        
                        <div class="form-group">
                            <label for="subject">Subject</label>
                            <input type="text" id="subject" name="subject" class="form-control" placeholder="Subject" required>
                        </div>
                        
                        <div class="form-group">
                            <label for="message">Message</label>
                            <textarea id="message" name="message" class="form-control" rows="4" placeholder="Your message" required></textarea>
                        </div>
                        
                        <button type="submit" class="btn-send-message">
                            <i class="fas fa-paper-plane"></i> Send Message
                        </button>
                    </form>
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
            
            // Resize handler
            window.addEventListener('resize', function() {
                if (window.innerWidth > 576) {
                    sidebar.classList.remove('expanded');
                }
            });
        });
    </script>
     <link rel="stylesheet" href="<?php echo e(asset('assets/css/customer/dashboard.css')); ?>">
    <style>
        /* Location Page Specific Styles */
        .location-info-section {
            display: grid;
            grid-template-columns: 1fr 2fr;
            gap: 20px;
            margin-bottom: 30px;
        }
        
        @media (max-width: 768px) {
            .location-info-section {
                grid-template-columns: 1fr;
            }
        }
        
        .location-card {
            background: #fff;
            border-radius: 8px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
            padding: 20px;
        }
        
        .primary-location {
            border-left: 4px solid #4CAF50;
        }
        
        .location-header {
            display: flex;
            align-items: center;
            margin-bottom: 15px;
        }
        
        .location-header i {
            font-size: 24px;
            color: #4CAF50;
            margin-right: 10px;
        }
        
        .location-header h3 {
            margin: 0;
            font-size: 20px;
        }
        
        .location-details p {
            margin: 10px 0;
            color: #555;
        }
        
        .location-details i {
            width: 20px;
            color: #666;
            margin-right: 8px;
        }
        
        .location-map {
            border-radius: 8px;
            overflow: hidden;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
        }
        
        .services-at-location {
            background: #fff;
            border-radius: 8px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
            padding: 20px;
            margin-bottom: 30px;
        }
        
        .services-at-location h3 {
            margin-top: 0;
            margin-bottom: 20px;
            font-size: 18px;
            color: #333;
        }
        
        .services-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(150px, 1fr));
            gap: 15px;
        }
        
        .service-item {
            display: flex;
            flex-direction: column;
            align-items: center;
            text-align: center;
            padding: 15px;
            background: #f9f9f9;
            border-radius: 6px;
            transition: all 0.2s ease;
        }
        
        .service-item:hover {
            transform: translateY(-3px);
            box-shadow: 0 5px 15px rgba(0,0,0,0.1);
        }
        
        .service-item i {
            font-size: 24px;
            color: #4285F4;
            margin-bottom: 8px;
        }
        
        .contact-section {
            background: #fff;
            border-radius: 8px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
            padding: 20px;
        }
        
        .contact-section h3 {
            margin-top: 0;
            margin-bottom: 20px;
            font-size: 18px;
            color: #333;
        }
        
        .contact-form .form-group {
            margin-bottom: 15px;
        }
        
        .contact-form label {
            display: block;
            margin-bottom: 5px;
            font-weight: 500;
        }
        
        .form-control {
            width: 100%;
            padding: 10px;
            border: 1px solid #ddd;
            border-radius: 4px;
            font-size: 14px;
        }
        
        .btn-send-message {
            background: #4CAF50;
            color: white;
            border: none;
            padding: 10px 20px;
            border-radius: 4px;
            cursor: pointer;
            font-size: 14px;
            transition: background 0.2s ease;
        }
        
        .btn-send-message:hover {
            background: #43A047;
        }
        
    </style>
</body>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\Sangay Ngedup\Documents\GitHub\FinalProject\resources\views/customer/locations.blade.php ENDPATH**/ ?>