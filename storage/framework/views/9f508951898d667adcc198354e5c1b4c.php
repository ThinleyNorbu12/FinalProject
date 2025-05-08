

<?php $__env->startSection('content'); ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Car Rental Dashboard</title>
    <!-- Link to the external CSS file -->
    <link rel="stylesheet" href="<?php echo e(asset('assets/css/customer/dashboard.css')); ?>">

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
                <a href="#" class="sidebar-menu-item active">
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
            <div class="welcome-card">
                <h2>Welcome to Your Car Rental Dashboard</h2>
                <?php if(Auth::guard('customer')->check()): ?>
                    <p>Hello, <?php echo e(Auth::guard('customer')->user()->name); ?>! Here's a summary of your rental activities.</p>
                <?php else: ?>
                    <p>Hello, Guest! Please log in to access your car rental dashboard.</p>
                <?php endif; ?>
            </div>
            
            <!-- Current Rental -->
            <div class="current-rental">
                <h3>Your Current Rental</h3>
                
                <div class="rental-details">
                    <div class="car-image">
                        <img src="/api/placeholder/600/350" alt="Toyota Camry">
                    </div>
                    
                    <div class="rental-info">
                        <h4>Toyota Camry (2024)</h4>
                        
                        <div class="rental-info-row">
                            <div class="rental-info-label">Rental ID:</div>
                            <div>RNT-78956</div>
                        </div>
                        
                        <div class="rental-info-row">
                            <div class="rental-info-label">Pickup Date:</div>
                            <div>April 30, 2025</div>
                        </div>
                        
                        <div class="rental-info-row">
                            <div class="rental-info-label">Return Date:</div>
                            <div>May 05, 2025</div>
                        </div>
                        
                        <div class="rental-info-row">
                            <div class="rental-info-label">Pickup Location:</div>
                            <div>Downtown Branch</div>
                        </div>
                        
                        <div class="rental-info-row">
                            <div class="rental-info-label">Return Location:</div>
                            <div>Downtown Branch</div>
                        </div>
                        
                        <div class="rental-info-row">
                            <div class="rental-info-label">Remaining Time:</div>
                            <div>2 days, 8 hours</div>
                        </div>
                        
                        <div class="rental-actions">
                            <button class="btn-extend">Extend Rental</button>
                            <button class="btn-return">Early Return</button>
                        </div>
                    </div>
                </div>
            </div>
            
            <!-- Stats -->
            <div class="stats-grid">
                <div class="stat-card">
                    <div class="stat-number">1</div>
                    <div class="stat-label">Active Rentals</div>
                </div>
                
                <div class="stat-card">
                    <div class="stat-number">2</div>
                    <div class="stat-label">Upcoming Reservations</div>
                </div>
                
                <div class="stat-card">
                    <div class="stat-number">8</div>
                    <div class="stat-label">Completed Rentals</div>
                </div>
                
                <div class="stat-card">
                    <div class="stat-number">850</div>
                    <div class="stat-label">Loyalty Points</div>
                </div>
            </div>
            
            <!-- Rental History -->
            <div class="history-card">
                <h3>Recent Rental History</h3>
                <table class="rental-table">
                    <thead>
                        <tr>
                            <th>Rental ID</th>
                            <th>Car</th>
                            <th>Dates</th>
                            <th>Cost</th>
                            <th>Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>RNT-78956</td>
                            <td>Toyota Camry (2024)</td>
                            <td>Apr 30 - May 05, 2025</td>
                            <td>$310.00</td>
                            <td><span class="badge badge-active">Active</span></td>
                        </tr>
                        <tr>
                            <td>RNT-78567</td>
                            <td>Honda CR-V (2023)</td>
                            <td>Apr 15 - Apr 20, 2025</td>
                            <td>$345.00</td>
                            <td><span class="badge badge-completed">Completed</span></td>
                        </tr>
                        <tr>
                            <td>RNT-77890</td>
                            <td>Nissan Altima (2024)</td>
                            <td>Mar 20 - Mar 24, 2025</td>
                            <td>$256.00</td>
                            <td><span class="badge badge-completed">Completed</span></td>
                        </tr>
                        <tr>
                            <td>RNT-77234</td>
                            <td>Ford Escape (2023)</td>
                            <td>Feb 10 - Feb 15, 2025</td>
                            <td>$298.00</td>
                            <td><span class="badge badge-completed">Completed</span></td>
                        </tr>
                    </tbody>
                </table>
            </div>
            
            <!-- Recommended Cars -->
            <div class="recommended-card">
                <h3>Recommended For You</h3>
                <div class="cars-grid">
                    <div class="car-card">
                        <img src="/api/placeholder/300/200" alt="Ford Mustang">
                        <div class="car-details">
                            <h4 class="car-title">Ford Mustang (2024)</h4>
                            <div class="car-specs">
                                <i class="fas fa-user"></i> 4 &nbsp;
                                <i class="fas fa-suitcase"></i> 2 &nbsp;
                                <i class="fas fa-gas-pump"></i> Auto &nbsp;
                                <i class="fas fa-snowflake"></i> A/C
                            </div>
                            <div class="car-price">$89.99/day</div>
                            <button class="btn-book-now">Book Now</button>
                        </div>
                    </div>
                    
                    <div class="car-card">
                        <img src="/api/placeholder/300/200" alt="Jeep Wrangler">
                        <div class="car-details">
                            <h4 class="car-title">Jeep Wrangler (2024)</h4>
                            <div class="car-specs">
                                <i class="fas fa-user"></i> 5 &nbsp;
                                <i class="fas fa-suitcase"></i> 3 &nbsp;
                                <i class="fas fa-gas-pump"></i> Auto &nbsp;
                                <i class="fas fa-snowflake"></i> A/C
                            </div>
                            <div class="car-price">$79.99/day</div>
                            <button class="btn-book-now">Book Now</button>
                        </div>
                    </div>
                    
                    <div class="car-card">
                        <img src="/api/placeholder/300/200" alt="BMW 3 Series">
                        <div class="car-details">
                            <h4 class="car-title">BMW 3 Series (2024)</h4>
                            <div class="car-specs">
                                <i class="fas fa-user"></i> 5 &nbsp;
                                <i class="fas fa-suitcase"></i> 3 &nbsp;
                                <i class="fas fa-gas-pump"></i> Auto &nbsp;
                                <i class="fas fa-snowflake"></i> A/C
                            </div>
                            <div class="car-price">$109.99/day</div>
                            <button class="btn-book-now">Book Now</button>
                        </div>
                    </div>
                    
                    <div class="car-card">
                        <img src="/api/placeholder/300/200" alt="Tesla Model 3">
                        <div class="car-details">
                            <h4 class="car-title">Tesla Model 3 (2024)</h4>
                            <div class="car-specs">
                                <i class="fas fa-user"></i> 5 &nbsp;
                                <i class="fas fa-suitcase"></i> 2 &nbsp;
                                <i class="fas fa-plug"></i> Electric &nbsp;
                                <i class="fas fa-snowflake"></i> A/C
                            </div>
                            <div class="car-price">$129.99/day</div>
                            <button class="btn-book-now">Book Now</button>
                        </div>
                    </div>
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
</body>
</html>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\Thinley Norbu\Documents\GitHub\FinalProject\resources\views/customer/dashboard.blade.php ENDPATH**/ ?>