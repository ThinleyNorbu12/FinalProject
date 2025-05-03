

<?php $__env->startSection('content'); ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Car Rental Dashboard</title>
    <!-- Bootstrap CSS -->
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
        
        /* Main Content */
        .main-content {
            margin-left: 240px;
            padding: 76px 20px 20px;
            width: calc(100% - 240px);
        }
        
        .welcome-card {
            background-color: white;
            border-radius: 8px;
            padding: 20px;
            margin-bottom: 20px;
            box-shadow: 0 1px 2px rgba(0, 0, 0, 0.1);
        }
        
        .welcome-card h2 {
            margin-top: 0;
            color: #0f0f0f;
        }
        
        /* Current Rental Section */
        .current-rental {
            background-color: white;
            border-radius: 8px;
            padding: 20px;
            margin-bottom: 20px;
            box-shadow: 0 1px 2px rgba(0, 0, 0, 0.1);
        }
        
        .current-rental h3 {
            margin-top: 0;
            color: #0f0f0f;
        }
        
        .rental-details {
            display: flex;
            flex-wrap: wrap;
            gap: 20px;
            margin-top: 20px;
        }
        
        .car-image {
            flex: 0 0 300px;
            border-radius: 8px;
            overflow: hidden;
        }
        
        .car-image img {
            width: 100%;
            height: auto;
            object-fit: cover;
        }
        
        .rental-info {
            flex: 1;
            min-width: 300px;
        }
        
        .rental-info-row {
            display: flex;
            margin-bottom: 8px;
        }
        
        .rental-info-label {
            font-weight: 500;
            width: 150px;
            color: #606060;
        }
        
        .rental-actions {
            margin-top: 20px;
        }
        
        .btn-extend, .btn-return {
            padding: 8px 16px;
            border-radius: 20px;
            font-size: 14px;
            font-weight: 500;
            margin-right: 10px;
            cursor: pointer;
            border: none;
        }
        
        .btn-extend {
            background-color: #28a745;
            color: white;
        }
        
        .btn-return {
            background-color: #dc3545;
            color: white;
        }
        
        /* Stats Cards */
        .stats-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(220px, 1fr));
            gap: 20px;
            margin-bottom: 20px;
        }
        
        .stat-card {
            background-color: white;
            border-radius: 8px;
            padding: 20px;
            text-align: center;
            box-shadow: 0 1px 2px rgba(0, 0, 0, 0.1);
        }
        
        .stat-number {
            font-size: 28px;
            font-weight: 700;
            color: #3366ff;
            margin: 10px 0;
        }
        
        .stat-label {
            color: #606060;
            font-size: 14px;
        }
        
        /* Rental History */
        .history-card {
            background-color: white;
            border-radius: 8px;
            padding: 20px;
            margin-bottom: 20px;
            box-shadow: 0 1px 2px rgba(0, 0, 0, 0.1);
        }
        
        .history-card h3 {
            margin-top: 0;
            color: #0f0f0f;
        }
        
        .rental-table {
            width: 100%;
            border-collapse: collapse;
        }
        
        .rental-table th, 
        .rental-table td {
            padding: 12px;
            text-align: left;
            border-bottom: 1px solid #e5e5e5;
        }
        
        .rental-table th {
            color: #606060;
            font-weight: 500;
        }
        
        .badge {
            display: inline-block;
            padding: 4px 8px;
            border-radius: 4px;
            font-size: 12px;
            font-weight: 500;
            color: white;
        }
        
        .badge-completed {
            background-color: #28a745;
        }
        
        .badge-active {
            background-color: #007bff;
        }
        
        .badge-reserved {
            background-color: #17a2b8;
        }
        
        .badge-cancelled {
            background-color: #dc3545;
        }
        
        /* Recommended Cars */
        .recommended-card {
            background-color: white;
            border-radius: 8px;
            padding: 20px;
            box-shadow: 0 1px 2px rgba(0, 0, 0, 0.1);
        }
        
        .recommended-card h3 {
            margin-top: 0;
            color: #0f0f0f;
        }
        
        .cars-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(250px, 1fr));
            gap: 20px;
        }
        
        .car-card {
            border: 1px solid #e5e5e5;
            border-radius: 8px;
            overflow: hidden;
        }
        
        .car-card img {
            width: 100%;
            height: 160px;
            object-fit: cover;
        }
        
        .car-details {
            padding: 12px;
        }
        
        .car-title {
            margin: 0 0 8px;
            font-size: 16px;
            font-weight: 500;
        }
        
        .car-specs {
            color: #606060;
            font-size: 13px;
            margin-bottom: 8px;
        }
        
        .car-price {
            color: #3366ff;
            font-weight: 700;
            margin-bottom: 10px;
        }
        
        .btn-book-now {
            background-color: #3366ff;
            color: white;
            border: none;
            border-radius: 20px;
            padding: 6px 12px;
            font-size: 12px;
            cursor: pointer;
            transition: all 0.2s;
        }
        
        .btn-book-now:hover {
            background-color: #2952cc;
        }
        
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
                <form method="POST" action="#" class="d-inline">
                    <?php echo csrf_field(); ?>
                    <button type="submit" class="btn-logout">Logout</button>
                </form>
            <?php else: ?>
                <a href="#" class="btn-logout">Login</a>
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
                
                <a href="https://eralis.rsta.gov.bt/services/driving/search?serviceType=driving_renewal" class="sidebar-menu-item" target="_blank">
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
<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\Sangay Ngedup\Documents\GitHub\FinalProject\resources\views/customer/dashboard.blade.php ENDPATH**/ ?>