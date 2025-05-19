
<?php $__env->startSection('content'); ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Responsive Admin Dashboard</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="<?php echo e(asset('assets/css/admin/dashboard.css')); ?>">
    <link rel="stylesheet" href="<?php echo e(asset('assets/css/admin/adminsidebar.css')); ?>">
    <style>
        /* Dark Mode Styles */
        .dark-mode {
            --bg-primary: #1a1a1a;
            --bg-secondary: #2d2d2d;
            --text-primary: #ffffff;
            --text-secondary: #b0b0b0;
            --border-color: #404040;
            --card-bg: #2d2d2d;
            --sidebar-bg: #1e1e1e;
        }

        .dark-mode .admin-dashboard {
            background-color: var(--bg-primary);
            color: var(--text-primary);
        }

        .dark-mode .dashboard-sidebar {
            background-color: var(--sidebar-bg);
            border-right: 1px solid var(--border-color);
        }

        .dark-mode .dashboard-content {
            background-color: var(--bg-primary);
        }

        .dark-mode .card {
            background-color: var(--card-bg);
            border: 1px solid var(--border-color);
        }

        .dark-mode .panel {
            background-color: var(--card-bg);
            border: 1px solid var(--border-color);
        }

        .dark-mode .dashboard-header {
            background-color: var(--sidebar-bg);
            border-bottom: 1px solid var(--border-color);
        }

        .dark-mode .sidebar-menu-item {
            color: var(--text-secondary);
        }

        .dark-mode .sidebar-menu-item:hover {
            background-color: #333;
            color: var(--text-primary);
        }

        .dark-mode .sidebar-menu-item.active {
            background-color: #4f46e5;
            color: white;
        }

        /* Enhanced Sidebar Toggle Button */
        .sidebar-arrow-toggle {
            position: absolute;
            top: 20px;
            right: -15px;
            width: 30px;
            height: 30px;
            background: #4f46e5;
            border: none;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            cursor: pointer;
            transition: all 0.3s ease;
            box-shadow: 0 2px 8px rgba(79, 70, 229, 0.3);
            z-index: 1000;
        }

        .sidebar-arrow-toggle:hover {
            background: #4338ca;
            transform: scale(1.1);
        }

        .sidebar-arrow-toggle i {
            color: white;
            font-size: 14px;
            transition: transform 0.3s ease;
        }

        .dashboard-sidebar.collapsed .sidebar-arrow-toggle i {
            transform: rotate(180deg);
        }

        /* Dark Mode Toggle */
        .dark-mode-toggle {
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 12px 20px;
            margin: 10px 0;
            background: transparent;
            border: none;
            cursor: pointer;
            color: inherit;
            width: 100%;
            transition: all 0.3s ease;
        }

        .dark-mode-toggle:hover {
            background: rgba(79, 70, 229, 0.1);
        }

        .dark-mode-toggle .toggle-text {
            display: flex;
            align-items: center;
            gap: 12px;
        }

        .toggle-switch {
            position: relative;
            width: 50px;
            height: 25px;
            background: #ccc;
            border-radius: 25px;
            transition: background 0.3s ease;
        }

        .toggle-switch.active {
            background: #4f46e5;
        }

        .toggle-slider {
            position: absolute;
            top: 2px;
            left: 2px;
            width: 21px;
            height: 21px;
            background: white;
            border-radius: 50%;
            transition: transform 0.3s ease;
        }

        .toggle-switch.active .toggle-slider {
            transform: translateX(25px);
        }

        /* Hide toggle text when collapsed */
        .dashboard-sidebar.collapsed .dark-mode-toggle .toggle-text span,
        .dashboard-sidebar.collapsed .sidebar-menu-item span {
            display: none;
        }

        .dashboard-sidebar.collapsed .dark-mode-toggle {
            justify-content: center;
            padding: 12px;
        }

        /* Responsive adjustments */
        @media (max-width: 768px) {
            .sidebar-arrow-toggle {
                display: none;
            }
        }
        /* Enhanced Header Styles */
        .admin-header {
            position: fixed;
            top: 0;
            left: 0;
            right: 0;
            height: 70px;
            background: #ffffff;
            border-bottom: 1px solid #e5e5e5;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 0 20px;
            z-index: 1000;
            transition: all 0.3s ease;
        }

        .admin-header.sidebar-collapsed {
            left: 80px;
        }

        .admin-header.dark-mode {
            background: #1e293b;
            border-bottom-color: #334155;
            color: white;
        }

        .header-left {
            display: flex;
            align-items: center;
            gap: 20px;
        }

        .header-brand {
            display: flex;
            align-items: center;
            gap: 10px;
            font-size: 18px;
            font-weight: 600;
            color: #333;
            text-decoration: none;
        }

        .header-brand img {
            width: 40px;
            height: 40px;
            border-radius: 8px;
        }

        .dark-mode .header-brand {
            color: white;
        }

        .header-search {
            position: relative;
            display: flex;
            align-items: center;
        }

        .header-search input {
            width: 350px;
            padding: 10px 15px 10px 45px;
            border: 1px solid #e5e5e5;
            border-radius: 25px;
            background: #f8f9fa;
            font-size: 14px;
            transition: all 0.3s ease;
        }

        .header-search input:focus {
            outline: none;
            border-color: #007bff;
            box-shadow: 0 0 0 3px rgba(0, 123, 255, 0.1);
            background: white;
        }

        .header-search i {
            position: absolute;
            left: 15px;
            color: #6c757d;
            z-index: 1;
        }

        .dark-mode .header-search input {
            background: #334155;
            border-color: #475569;
            color: white;
        }

        .dark-mode .header-search input:focus {
            background: #475569;
            border-color: #64748b;
        }

        .header-actions {
            display: flex;
            align-items: center;
            gap: 20px;
        }

        .header-action-item {
            position: relative;
            padding: 10px;
            border-radius: 8px;
            cursor: pointer;
            transition: all 0.3s ease;
            color: #6c757d;
        }

        .header-action-item:hover {
            background: #f8f9fa;
            color: #007bff;
        }

        .dark-mode .header-action-item:hover {
            background: #334155;
            color: #60a5fa;
        }

        .header-action-item .badge {
            position: absolute;
            top: 5px;
            right: 5px;
            background: #dc3545;
            color: white;
            border-radius: 50%;
            width: 18px;
            height: 18px;
            font-size: 11px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: 600;
        }

        .header-profile {
            display: flex;
            align-items: center;
            gap: 10px;
            padding: 5px 15px;
            border-radius: 25px;
            border: 1px solid #e5e5e5;
            cursor: pointer;
            transition: all 0.3s ease;
        }

        .header-profile:hover {
            background: #f8f9fa;
            border-color: #007bff;
        }

        .dark-mode .header-profile {
            border-color: #475569;
        }

        .dark-mode .header-profile:hover {
            background: #334155;
            border-color: #60a5fa;
        }

        .header-profile img {
            width: 35px;
            height: 35px;
            border-radius: 50%;
            object-fit: cover;
        }

        .header-profile-info h4 {
            font-size: 14px;
            font-weight: 500;
            margin: 0;
            color: #333;
        }

        .header-profile-info span {
            font-size: 12px;
            color: #6c757d;
        }

        .dark-mode .header-profile-info h4 {
            color: white;
        }

        .dark-mode .header-profile-info span {
            color: #94a3b8;
        }

        /* Enhanced Footer Styles */
        .admin-footer {
            position: fixed;
            bottom: 0;
            left: 260px;
            right: 0;
            height: 60px;
            background: #ffffff;
            border-top: 1px solid #e5e5e5;
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 0 30px;
            z-index: 999;
            transition: all 0.3s ease;
        }

        .admin-footer.sidebar-collapsed {
            left: 80px;
        }

        .admin-footer.dark-mode {
            background: #1e293b;
            border-top-color: #334155;
            color: white;
        }

        .footer-left {
            display: flex;
            align-items: center;
            gap: 20px;
        }

        .footer-copy {
            font-size: 14px;
            color: #6c757d;
        }

        .dark-mode .footer-copy {
            color: #94a3b8;
        }

        .footer-links {
            display: flex;
            gap: 20px;
        }

        .footer-links a {
            color: #6c757d;
            text-decoration: none;
            font-size: 14px;
            transition: color 0.3s ease;
        }

        .footer-links a:hover {
            color: #007bff;
        }

        .dark-mode .footer-links a {
            color: #94a3b8;
        }

        .dark-mode .footer-links a:hover {
            color: #60a5fa;
        }

        .footer-right {
            display: flex;
            align-items: center;
            gap: 15px;
        }

        .footer-status {
            display: flex;
            align-items: center;
            gap: 8px;
            padding: 5px 15px;
            background: #e7f3ff;
            border-radius: 20px;
            font-size: 13px;
            color: #007bff;
        }

        .dark-mode .footer-status {
            background: #1e3a8a;
            color: #93c5fd;
        }

        .footer-status .status-dot {
            width: 8px;
            height: 8px;
            background: #28a745;
            border-radius: 50%;
            animation: pulse 2s infinite;
        }

        @keyframes pulse {
            0% { opacity: 1; }
            50% { opacity: 0.5; }
            100% { opacity: 1; }
        }

        /* Layout Adjustments */
        .admin-dashboard {
            min-height: 100vh;
            display: flex;
            padding-top: 70px;
            padding-bottom: 60px;
        }

        .dashboard-content {
            margin-left: 260px;
            flex: 1;
            padding: 30px;
            transition: margin-left 0.3s ease;
            min-height: calc(100vh - 130px);
        }

        .dashboard-content.sidebar-collapsed {
            margin-left: 80px;
        }

        .dashboard-sidebar {
            position: fixed;
            top: 70px;
            bottom: 60px;
            left: 0;
            width: 260px;
            overflow-y: auto;
            transition: all 0.3s ease;
        }

        .dashboard-sidebar.collapsed {
            width: 80px;
        }

        /* Mobile Responsive Adjustments */
        @media (max-width: 768px) {
            .admin-header {
                left: 0;
                padding: 0 15px;
            }

            .admin-header.sidebar-collapsed {
                left: 0;
            }

            .header-search {
                display: none;
            }

            .header-actions {
                gap: 10px;
            }

            .header-profile-info {
                display: none;
            }

            .admin-footer {
                left: 0;
                padding: 0 15px;
            }

            .admin-footer.sidebar-collapsed {
                left: 0;
            }

            .footer-links {
                display: none;
            }

            .dashboard-content {
                margin-left: 0;
                padding: 20px 15px;
            }

            .dashboard-content.sidebar-collapsed {
                margin-left: 0;
            }

            .dashboard-sidebar {
                top: 70px;
                bottom: 60px;
                transform: translateX(-100%);
            }

            .dashboard-sidebar.mobile-open {
                transform: translateX(0);
            }
        }

        @media (max-width: 480px) {
            .footer-copy {
                font-size: 12px;
            }

            .footer-status {
                font-size: 11px;
                padding: 3px 10px;
            }

            .header-action-item .badge {
                width: 16px;
                height: 16px;
                font-size: 10px;
            }
        }

        /* Breadcrumb Styles */
        .page-breadcrumb {
            display: flex;
            align-items: center;
            gap: 10px;
            margin-bottom: 30px;
            padding: 15px 0;
            border-bottom: 1px solid #e5e5e5;
        }

        .dark-mode .page-breadcrumb {
            border-bottom-color: #334155;
        }

        .breadcrumb {
            display: flex;
            align-items: center;
            gap: 8px;
            list-style: none;
            margin: 0;
            padding: 0;
        }

        .breadcrumb-item {
            display: flex;
            align-items: center;
            gap: 8px;
            font-size: 14px;
            color: #6c757d;
        }

        .breadcrumb-item.active {
            color: #333;
            font-weight: 500;
        }

        .dark-mode .breadcrumb-item {
            color: #94a3b8;
        }

        .dark-mode .breadcrumb-item.active {
            color: white;
        }

        .breadcrumb-item:not(:last-child)::after {
            content: '/';
            margin-left: 8px;
            color: #dee2e6;
        }

        .dark-mode .breadcrumb-item:not(:last-child)::after {
            color: #475569;
        }
    </style>
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
                <span>Admin Portal</span>
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
            
            <div class="header-action-item d-none d-md-block" title="Settings">
                <i class="fas fa-cog"></i>
            </div>

            <?php if(Auth::guard('admin')->check()): ?>
                <div class="header-profile">
                    <img src="<?php echo e(asset('assets/images/thinley.jpg')); ?>" alt="Admin Avatar">
                    <div class="header-profile-info d-none d-sm-block">
                        <h4><?php echo e(Auth::guard('admin')->user()->name); ?></h4>
                        <span>Administrator</span>
                    </div>
                    <i class="fas fa-chevron-down d-none d-sm-inline"></i>
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
            <button class="sidebar-arrow-toggle" id="sidebarArrowToggle">
                <i class="fas fa-chevron-left"></i>
            </button>

            <div class="sidebar-header">
                <div class="logo">
                    <img src="<?php echo e(asset('assets/images/logo.png')); ?>" alt="Logo">
                    <h2>Admin Portal</h2>
                </div>
                <button id="sidebarToggle" class="sidebar-toggle">
                    <i class="fas fa-bars"></i>
                </button>
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
                <a href="<?php echo e(route('admin.dashboard')); ?>" class="sidebar-menu-item active">
                    <i class="fas fa-tachometer-alt"></i>
                    <span>Dashboard</span>
                </a>

                <div class="sidebar-divider"></div>
                <div class="sidebar-heading">Car Owner</div>

                <a href="<?php echo e(route('car-admin.new-registration-cars')); ?>" class="sidebar-menu-item">
                    <i class="fas fa-car"></i>
                    <span>Car Registration</span>
                    <div class="tooltip">Car Registration</div>
                </a>

                <a href="<?php echo e(route('car-admin.inspection-requests')); ?>" class="sidebar-menu-item">
                    <i class="fas fa-clipboard-check"></i>
                    <span>Inspection Requests</span>
                    <div class="tooltip">Inspection Requests</div>
                </a>

                <a href="<?php echo e(route('car-admin.approve-inspected-cars')); ?>" class="sidebar-menu-item">
                    <i class="fas fa-check-circle"></i>
                    <span>Approve Inspections</span>
                    <div class="tooltip">Approve Inspections</div>
                </a>

                <div class="sidebar-divider"></div>
                <div class="sidebar-heading">Customer</div>

                <a href="<?php echo e(route('admin.verify-users')); ?>" class="sidebar-menu-item">
                    <i class="fas fa-id-card"></i>
                    <span>Verify Users</span>
                    <div class="tooltip">Verify Users</div>
                </a>

                <a href="<?php echo e(route('admin.payments.index')); ?>" class="sidebar-menu-item">
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

                <a href="<?php echo e(route('admin.booked-car')); ?>" class="sidebar-menu-item">
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

                <a href="#" class="sidebar-menu-item" onclick="document.getElementById('logout-form').submit();">
                    <i class="fas fa-sign-out-alt"></i>
                    <span>Logout</span>
                    <div class="tooltip">Logout</div>
                </a>

                <form method="POST" action="<?php echo e(route('admin.logout')); ?>" id="logout-form" style="display: none;">
                    <?php echo csrf_field(); ?>
                </form>
            </div>
        </div>

        <div class="dashboard-content" id="dashboardContent">
            <!-- Breadcrumb Navigation -->
            <nav class="page-breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item">
                        <i class="fas fa-home"></i>
                        <a href="<?php echo e(route('admin.dashboard')); ?>">Home</a>
                    </li>
                    <li class="breadcrumb-item active">Dashboard</li>
                </ol>
            </nav>

            <!-- DYNAMIC CONTENT LOADER -->
            <div id="dynamic-content">
                <!-- Default Dashboard Cards -->
                <div class="dashboard-cards">
                    <div class="card">
                        <div class="card-inner">
                            <div class="card-icon bg-primary">
                                <i class="fas fa-car"></i>
                            </div>
                            <div class="card-content">
                                <h3>New Registrations</h3>
                                <p class="count">24</p>
                                <p class="trend up"><i class="fas fa-arrow-up"></i> 12% from last month</p>
                            </div>
                        </div>
                    </div>
                
                    <div class="card">
                        <div class="card-inner">
                            <div class="card-icon bg-success">
                                <i class="fas fa-clipboard-check"></i>
                            </div>
                            <div class="card-content">
                                <h3>Pending Inspections</h3>
                                <p class="count">18</p>
                                <p class="trend down"><i class="fas fa-arrow-down"></i> 5% from last month</p>
                            </div>
                        </div>
                    </div>
                    
                    <div class="card">
                        <div class="card-inner">
                            <div class="card-icon bg-warning">
                                <i class="fas fa-credit-card"></i>
                            </div>
                            <div class="card-content">
                                <h3>Total Revenue</h3>
                                <p class="count">$15,890</p>
                                <p class="trend up"><i class="fas fa-arrow-up"></i> 8% from last month</p>
                            </div>
                        </div>
                    </div>
                    
                    <div class="card">
                        <div class="card-inner">
                            <div class="card-icon bg-info">
                                <i class="fas fa-calendar-check"></i>
                            </div>
                            <div class="card-content">
                                <h3>Booked Cars</h3>
                                <p class="count">42</p>
                                <p class="trend up"><i class="fas fa-arrow-up"></i> 15% from last month</p>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Quick Actions -->
                <div class="quick-actions">
                    <h2>Quick Actions</h2>
                    <div class="action-buttons">
                        <a href="<?php echo e(route('car-admin.new-registration-cars')); ?>" class="action-btn">
                            <i class="fas fa-car"></i>
                            <span>Car Registration Request</span>
                        </a>
                        <a href="<?php echo e(route('car-admin.inspection-requests')); ?>" class="action-btn">
                            <i class="fas fa-clipboard-check"></i>
                            <span>Manage Inspection Requests</span>
                        </a>
                        <a href="<?php echo e(route('car-admin.approve-inspected-cars')); ?>" class="action-btn">
                            <i class="fas fa-check-circle"></i>
                            <span>Approve/Reject Inspected Cars</span>
                        </a>
                        <a href="<?php echo e(url('admin/view-payments')); ?>" class="action-btn">
                            <i class="fas fa-credit-card"></i>
                            <span>View Payments</span>
                        </a>
                    </div>
                </div>

                <!-- Recent Activity & Stats Panel -->
                <div class="dashboard-panels">
                    <!-- Recent Activity -->
                    <div class="panel recent-activity">
                        <div class="panel-header">
                            <h2>Recent Activity</h2>
                            <a href="#" class="view-all">View All</a>
                        </div>
                        <div class="panel-content">
                            <ul class="activity-list">
                                <li>
                                    <div class="activity-icon bg-success">
                                        <i class="fas fa-check"></i>
                                    </div>
                                    <div class="activity-details">
                                        <p>Car inspection approved for Honda Civic</p>
                                        <span>10 minutes ago</span>
                                    </div>
                                </li>
                                <li>
                                    <div class="activity-icon bg-primary">
                                        <i class="fas fa-car"></i>
                                    </div>
                                    <div class="activity-details">
                                        <p>New registration request from John Doe</p>
                                        <span>1 hour ago</span>
                                    </div>
                                </li>
                                <li>
                                    <div class="activity-icon bg-warning">
                                        <i class="fas fa-calendar"></i>
                                    </div>
                                    <div class="activity-details">
                                        <p>Inspection scheduled for Toyota Corolla</p>
                                        <span>3 hours ago</span>
                                    </div>
                                </li>
                                <li>
                                    <div class="activity-icon bg-danger">
                                        <i class="fas fa-times"></i>
                                    </div>
                                    <div class="activity-details">
                                        <p>Car inspection rejected for Ford Focus</p>
                                        <span>Yesterday</span>
                                    </div>
                                </li>
                                <li>
                                    <div class="activity-icon bg-info">
                                        <i class="fas fa-credit-card"></i>
                                    </div>
                                    <div class="activity-details">
                                        <p>Payment received for Tesla Model 3</p>
                                        <span>Yesterday</span>
                                    </div>
                                </li>
                            </ul>
                        </div>
                    </div>

                    <!-- Statistics -->
                    <div class="panel statistics">
                        <div class="panel-header">
                            <h2>Monthly Statistics</h2>
                            <div class="panel-actions">
                                <select id="month-selector">
                                    <option value="may">May 2025</option>
                                    <option value="april">April 2025</option>
                                    <option value="march">March 2025</option>
                                </select>
                            </div>
                        </div>
                        <div class="panel-content">
                            <div class="stat-container">
                                <div class="stat-item">
                                    <h4>New Registrations</h4>
                                    <div class="stat-progress">
                                        <div class="progress-bar" style="width: 75%"></div>
                                        <span>75%</span>
                                    </div>
                                </div>
                                <div class="stat-item">
                                    <h4>Completed Inspections</h4>
                                    <div class="stat-progress">
                                        <div class="progress-bar" style="width: 60%"></div>
                                        <span>60%</span>
                                    </div>
                                </div>
                                <div class="stat-item">
                                    <h4>Approved Cars</h4>
                                    <div class="stat-progress">
                                        <div class="progress-bar" style="width: 85%"></div>
                                        <span>85%</span>
                                    </div>
                                </div>
                                <div class="stat-item">
                                    <h4>Total Revenue</h4>
                                    <div class="stat-progress">
                                        <div class="progress-bar" style="width: 45%"></div>
                                        <span>45%</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Enhanced Admin Footer -->
    <footer class="admin-footer" id="adminFooter">
        <div class="footer-left">
            <div class="footer-copy">
                © 2025 Admin Portal. All rights reserved.
            </div>
            <div class="footer-links">
                <a href="#">Privacy Policy</a>
                <a href="#">Terms of Service</a>
                <a href="#">Support</a>
                <a href="#">Documentation</a>
            </div>
        </div>
        
        <div class="footer-right">
            <div class="footer-status">
                <span class="status-dot"></span>
                System Online
            </div>
            <div class="footer-copy">
                Version 2.1.0
            </div>
        </div>
    </footer>


    <?php $__env->startSection('scripts'); ?>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
        $(document).ready(function () {
            // Existing AJAX functionality
            $('.menu-link').on('click', function (e) {
                e.preventDefault();
                let url = $(this).data('url');

                $('#dynamic-content').html('<p>Loading...</p>');

                $.ajax({
                    url: url,
                    method: 'GET',
                    success: function (data) {
                        $('#dynamic-content').html(data);
                    },
                    error: function () {
                        $('#dynamic-content').html('<p>Error loading content. Please try again.</p>');
                    }
                });
            });

            // Dark Mode Functionality
            const darkModeToggle = document.getElementById('darkModeToggle');
            const toggleSwitch = document.getElementById('toggleSwitch');
            const adminDashboard = document.getElementById('adminDashboard');

            // Check for saved dark mode preference
            const isDarkMode = localStorage.getItem('darkMode') === 'true';
            if (isDarkMode) {
                adminDashboard.classList.add('dark-mode');
                toggleSwitch.classList.add('active');
            }

            // Dark mode toggle functionality
            darkModeToggle.addEventListener('click', function() {
                adminDashboard.classList.toggle('dark-mode');
                toggleSwitch.classList.toggle('active');
                
                // Save preference to localStorage
                const isNowDarkMode = adminDashboard.classList.contains('dark-mode');
                localStorage.setItem('darkMode', isNowDarkMode);
            });
        });

        // Enhanced Sidebar Toggle Functionality
        const sidebarToggle = document.getElementById('sidebarToggle');
        const sidebarArrowToggle = document.getElementById('sidebarArrowToggle');
        const mobileMenuToggle = document.getElementById('mobileMenuToggle');
        const dashboardSidebar = document.getElementById('dashboardSidebar');
        const sidebarOverlay = document.getElementById('sidebarOverlay');
        const adminDashboard = document.getElementById('adminDashboard');

        // Function to toggle sidebar
        function toggleSidebar() {
            dashboardSidebar.classList.toggle('collapsed');
            // Update content area if you have a main content class
            const mainContent = document.querySelector('.dashboard-content');
            if (mainContent) {
                mainContent.classList.toggle('collapsed');
            }
        }

        // Desktop sidebar toggle (existing button)
        sidebarToggle.addEventListener('click', toggleSidebar);

        // Enhanced arrow toggle
        sidebarArrowToggle.addEventListener('click', toggleSidebar);

        // Mobile menu toggle
        mobileMenuToggle.addEventListener('click', function() {
            dashboardSidebar.classList.toggle('mobile-open');
            sidebarOverlay.classList.toggle('active');
            document.body.style.overflow = dashboardSidebar.classList.contains('mobile-open') ? 'hidden' : 'auto';
        });

        // Close mobile menu when overlay is clicked
        sidebarOverlay.addEventListener('click', function() {
            dashboardSidebar.classList.remove('mobile-open');
            sidebarOverlay.classList.remove('active');
            document.body.style.overflow = 'auto';
        });

        // Close mobile menu when pressing escape key
        document.addEventListener('keydown', function(e) {
            if (e.key === 'Escape' && dashboardSidebar.classList.contains('mobile-open')) {
                dashboardSidebar.classList.remove('mobile-open');
                sidebarOverlay.classList.remove('active');
                document.body.style.overflow = 'auto';
            }
        });

        // Active menu item handling
        const menuItems = document.querySelectorAll('.sidebar-menu-item');
        menuItems.forEach(item => {
            item.addEventListener('click', function(e) {
                // Remove active class from all items
                menuItems.forEach(menuItem => menuItem.classList.remove('active'));
                // Add active class to clicked item
                this.classList.add('active');
                
                // Close mobile menu if open
                if (window.innerWidth <= 768) {
                    dashboardSidebar.classList.remove('mobile-open');
                    sidebarOverlay.classList.remove('active');
                    document.body.style.overflow = 'auto';
                }
            });
        });

        // Handle window resize
        window.addEventListener('resize', function() {
            if (window.innerWidth > 768) {
                dashboardSidebar.classList.remove('mobile-open');
                sidebarOverlay.classList.remove('active');
                document.body.style.overflow = 'auto';
            }
        });

        // Auto-collapse sidebar on smaller screens
        function handleResize() {
            if (window.innerWidth <= 992 && window.innerWidth > 768) {
                dashboardSidebar.classList.add('collapsed');
                const mainContent = document.querySelector('.dashboard-content');
                if (mainContent) {
                    mainContent.classList.add('collapsed');
                }
            } else if (window.innerWidth > 992) {
                dashboardSidebar.classList.remove('collapsed');
                const mainContent = document.querySelector('.dashboard-content');
                if (mainContent) {
                    mainContent.classList.remove('collapsed');
                }
            }
        }

        // Run on load
        handleResize();
        window.addEventListener('resize', handleResize);
    </script>
    <?php $__env->stopSection(); ?>
</body>
</html>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\Sangay Ngedup\Documents\GitHub\FinalProject\resources\views/admin/auth/dashboard.blade.php ENDPATH**/ ?>