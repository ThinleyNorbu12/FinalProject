@extends('layouts.app')
    <!-- Custom dashboard CSS -->
    <link rel="stylesheet" href="{{ asset('assets/css/admin/dashboard.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/admin/adminsidebar.css') }}">
    <!-- FontAwesome for icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
@section('content')
    <!-- Sidebar -->
    <div class="dashboard-sidebar">
        <div class="sidebar-header">
            <div class="logo">
                <img src="{{ asset('assets/images/logo.png') }}" alt="Logo">
                <h2>Admin Portal</h2>
            </div>
            <button id="sidebar-toggle" class="sidebar-toggle">
                <i class="fas fa-bars"></i>
            </button>
        </div>

        <div class="admin-profile">
            @if(Auth::guard('admin')->check())
                <div class="profile-avatar">
                    <img src="{{ asset('assets/images/thinley.jpg') }}" alt="Admin Avatar">
                </div>
                <div class="profile-info">
                    <h3>{{ Auth::guard('admin')->user()->name }}</h3>
                    <span>Administrator</span>
                </div>
            @endif
        </div>

        <div class="sidebar" id="sidebar">
            <div class="sidebar-menu">
                <a href="{{ route('admin.dashboard') }}" class="sidebar-menu-item">
                    <i class="fas fa-tachometer-alt"></i>
                    <span>Dashboard</span>
                </a>

                <div class="sidebar-divider"></div>
                <div class="sidebar-heading">Car Owner</div>

                <a href="{{ route('car-admin.new-registration-cars') }}" class="sidebar-menu-item active">
                    <i class="fas fa-car"></i>
                    <span>Car Registration</span>
                </a>

                <a href="{{ route('car-admin.inspection-requests') }}" class="sidebar-menu-item">
                    <i class="fas fa-clipboard-check"></i>
                    <span>Inspection Requests</span>
                </a>

                <a href="{{ route('car-admin.approve-inspected-cars') }}" class="sidebar-menu-item">
                    <i class="fas fa-check-circle"></i>
                    <span>Approve Inspections</span>
                </a>

                <div class="sidebar-divider"></div>
                <div class="sidebar-heading">Customer</div>

                <a href="{{ route('admin.verify-users') }}" class="sidebar-menu-item">
                    <i class="fas fa-id-card"></i>
                    <span>Verify Users</span>
                </a>

                <a href="{{ route('admin.payments.index') }}" class="sidebar-menu-item">
                    <i class="fas fa-credit-card"></i>
                    <span>Payments</span>
                </a>

                <a href="{{ url('admin/update-car-registration') }}" class="sidebar-menu-item">
                    <i class="fas fa-edit"></i>
                    <span>Update Registration</span>
                </a>

                <a href="{{ url('admin/car-information-update') }}" class="sidebar-menu-item">
                    <i class="fas fa-info-circle"></i>
                    <span>Car Information</span>
                </a>

                <a href="{{ route('admin.booked-car') }}" class="sidebar-menu-item">
                    <i class="fas fa-calendar-check"></i>
                    <span>Booked Cars</span>
                </a>

                <a href="#" class="sidebar-menu-item" onclick="document.getElementById('logout-form').submit();">
                    <i class="fas fa-sign-out-alt"></i>
                    <span>Logout</span>
                </a>

                <form method="POST" action="{{ route('admin.logout') }}" id="logout-form" style="display: none;">
                    @csrf
                </form>
            </div>
        </div>
    </div>

    <!-- Main Content -->
    <div class="dashboard-content">
        <!-- Top Header -->
        <div class="dashboard-header">
            <div class="header-search">
                <i class="fas fa-search"></i>
                <input type="text" placeholder="Search...">
            </div>
            <div class="header-actions">
                <div class="notification">
                    <i class="fas fa-bell"></i>
                    <span class="badge">3</span>
                </div>
                <div class="messages">
                    <i class="fas fa-envelope"></i>
                    <span class="badge">5</span>
                </div>
                <div class="account-menu">
                    @if(Auth::guard('admin')->check())
                        <span>{{ Auth::guard('admin')->user()->name }}</span>
                        {{-- <img src="{{ asset('assets/images/avatar-placeholder.jpg') }}" alt="Admin Avatar"> --}}
                    @else
                        <a href="{{ route('admin.login') }}" class="btn btn-primary">Login</a>
                    @endif
                </div>
            </div>
        </div>

         <!-- DYNAMIC CONTENT LOADER (this will be updated by JS below) -->
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
                <a href="{{ route('car-admin.new-registration-cars') }}" class="action-btn">
                    <i class="fas fa-car"></i>
                    <span>Car Registration Request</span>
                </a>
                <a href="{{ route('car-admin.inspection-requests') }}" class="action-btn">
                    <i class="fas fa-clipboard-check"></i>
                    <span>Manage Inspection Requests</span>
                </a>
                <a href="{{ route('car-admin.approve-inspected-cars') }}" class="action-btn">
                    <i class="fas fa-check-circle"></i>
                    <span>Approve/Reject Inspected Cars</span>
                </a>
                <a href="{{ url('admin/view-payments') }}" class="action-btn">
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
@section('scripts')
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
    $(document).ready(function () {
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
    });
</script>
@endsection

@endsection











<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Responsive Admin Dashboard</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <style>
        /* Custom CSS Variables */
        :root {
            --primary-color: #4361ee;
            --secondary-color: #3f37c9;
            --success-color: #4cc9f0;
            --warning-color: #f72585;
            --danger-color: #e5383b;
            --info-color: #4895ef;
            --dark-color: #212529;
            --light-color: #f8f9fa;
            --gray-color: #6c757d;
            --sidebar-width: 280px;
            --sidebar-collapsed-width: 70px;
            --header-height: 70px;
            --transition-speed: 0.3s;
            --card-border-radius: 12px;
            --box-shadow: 0 4px 20px rgba(0, 0, 0, 0.08);
        }

        /* Base Styles */
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Poppins', sans-serif;
            background-color: #f5f7fa;
            color: #333;
            overflow-x: hidden;
        }

        /* Dashboard Layout */
        .admin-dashboard {
            display: flex;
            min-height: 100vh;
            position: relative;
        }

        /* Sidebar Styles */
        .dashboard-sidebar {
            width: var(--sidebar-width);
            background: #fff;
            box-shadow: var(--box-shadow);
            height: 100vh;
            position: fixed;
            top: 0;
            left: 0;
            z-index: 1000;
            transition: all var(--transition-speed) ease-in-out;
            overflow-y: auto;
            overflow-x: hidden;
        }

        /* Sidebar Header */
        .sidebar-header {
            height: var(--header-height);
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 0 20px;
            border-bottom: 1px solid #eee;
            background: #fff;
        }

        .logo {
            display: flex;
            align-items: center;
            flex: 1;
            transition: all var(--transition-speed);
        }

        .logo img {
            height: 40px;
            width: auto;
            margin-right: 12px;
            transition: all var(--transition-speed);
        }

        .logo h2 {
            font-size: 18px;
            font-weight: 600;
            color: var(--primary-color);
            white-space: nowrap;
            opacity: 1;
            transition: all var(--transition-speed);
        }

        .sidebar-toggle {
            background: transparent;
            border: none;
            color: var(--dark-color);
            font-size: 18px;
            cursor: pointer;
            padding: 8px;
            border-radius: 4px;
            display: flex;
            align-items: center;
            justify-content: center;
            transition: all var(--transition-speed);
        }

        .sidebar-toggle:hover {
            color: var(--primary-color);
            background: rgba(67, 97, 238, 0.1);
        }

        /* Admin Profile */
        .admin-profile {
            padding: 20px;
            display: flex;
            align-items: center;
            border-bottom: 1px solid #eee;
            transition: all var(--transition-speed);
        }

        .profile-avatar {
            min-width: 50px;
        }

        .profile-avatar img {
            width: 50px;
            height: 50px;
            border-radius: 50%;
            object-fit: cover;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
        }

        .profile-info {
            margin-left: 15px;
            opacity: 1;
            transition: all var(--transition-speed);
        }

        .profile-info h3 {
            font-size: 16px;
            font-weight: 600;
            margin-bottom: 3px;
            white-space: nowrap;
        }

        .profile-info span {
            font-size: 12px;
            color: var(--gray-color);
            white-space: nowrap;
        }

        /* Sidebar Navigation */
        .sidebar-menu {
            padding: 10px 0;
        }

        .sidebar-menu-item {
            display: flex;
            align-items: center;
            padding: 14px 20px;
            color: #555;
            text-decoration: none;
            transition: all 0.3s ease;
            border-left: 3px solid transparent;
            margin: 2px 0;
            position: relative;
            white-space: nowrap;
        }

        .sidebar-menu-item:hover {
            background-color: rgba(67, 97, 238, 0.05);
            color: var(--primary-color);
            border-left: 3px solid rgba(67, 97, 238, 0.3);
        }

        .sidebar-menu-item.active {
            background-color: rgba(67, 97, 238, 0.1);
            color: var(--primary-color);
            border-left: 3px solid var(--primary-color);
        }

        .sidebar-menu-item i {
            font-size: 18px;
            margin-right: 15px;
            width: 20px;
            text-align: center;
            transition: all var(--transition-speed);
            min-width: 20px;
        }

        .sidebar-menu-item span {
            white-space: nowrap;
            opacity: 1;
            transition: all var(--transition-speed);
            overflow: hidden;
        }

        .sidebar-divider {
            height: 1px;
            background-color: #e5e5e5;
            margin: 15px 20px;
            transition: all var(--transition-speed);
        }

        .sidebar-heading {
            color: #606060;
            font-size: 12px;
            font-weight: 600;
            padding: 15px 20px 5px;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            opacity: 1;
            transition: all var(--transition-speed);
            white-space: nowrap;
        }

        /* Collapsed Sidebar Styles */
        .dashboard-sidebar.collapsed {
            width: var(--sidebar-collapsed-width);
        }

        .dashboard-sidebar.collapsed .logo h2 {
            opacity: 0;
            transform: translateX(-20px);
        }

        .dashboard-sidebar.collapsed .logo img {
            margin-right: 0;
        }

        .dashboard-sidebar.collapsed .admin-profile {
            justify-content: center;
            padding: 20px 10px;
        }

        .dashboard-sidebar.collapsed .profile-info {
            opacity: 0;
            transform: translateX(-20px);
            margin-left: 0;
        }

        .dashboard-sidebar.collapsed .sidebar-menu-item {
            padding: 14px 0;
            justify-content: center;
        }

        .dashboard-sidebar.collapsed .sidebar-menu-item i {
            margin-right: 0;
            font-size: 20px;
        }

        .dashboard-sidebar.collapsed .sidebar-menu-item span {
            opacity: 0;
            transform: translateX(-20px);
        }

        .dashboard-sidebar.collapsed .sidebar-heading {
            opacity: 0;
            height: 0;
            padding: 0;
            margin: 0;
        }

        .dashboard-sidebar.collapsed .sidebar-divider {
            margin: 15px 10px;
        }

        /* Tooltip for collapsed sidebar */
        .tooltip {
            position: absolute;
            left: calc(100% + 15px);
            top: 50%;
            transform: translateY(-50%);
            background: rgba(0, 0, 0, 0.8);
            color: white;
            padding: 8px 12px;
            border-radius: 6px;
            font-size: 12px;
            white-space: nowrap;
            opacity: 0;
            pointer-events: none;
            transition: all 0.3s ease;
            z-index: 1001;
        }

        .tooltip::before {
            content: '';
            position: absolute;
            top: 50%;
            left: -5px;
            transform: translateY(-50%);
            border: 5px solid transparent;
            border-right-color: rgba(0, 0, 0, 0.8);
        }

        .dashboard-sidebar.collapsed .sidebar-menu-item:hover .tooltip {
            opacity: 1;
        }

        /* Mobile Navigation Overlay */
        .sidebar-overlay {
            position: fixed;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: rgba(0, 0, 0, 0.5);
            z-index: 999;
            opacity: 0;
            visibility: hidden;
            transition: all var(--transition-speed);
        }

        .sidebar-overlay.active {
            opacity: 1;
            visibility: visible;
        }

        /* Mobile Menu Toggle */
        .mobile-menu-toggle {
            display: none;
            position: fixed;
            top: 20px;
            left: 20px;
            z-index: 1002;
            background: var(--primary-color);
            color: white;
            border: none;
            border-radius: 8px;
            width: 45px;
            height: 45px;
            cursor: pointer;
            box-shadow: var(--box-shadow);
            align-items: center;
            justify-content: center;
            transition: all 0.3s ease;
        }

        .mobile-menu-toggle:hover {
            background: var(--secondary-color);
            transform: scale(1.05);
        }

        /* Main Content */
        .main-content {
            flex: 1;
            margin-left: var(--sidebar-width);
            padding: 20px;
            transition: margin-left var(--transition-speed);
            min-height: 100vh;
        }

        .main-content.collapsed {
            margin-left: var(--sidebar-collapsed-width);
        }

        /* Responsive Design */
        
        /* Large tablets (992px and below) */
        @media (max-width: 992px) {
            .dashboard-sidebar {
                width: var(--sidebar-collapsed-width);
            }
            
            .dashboard-sidebar .logo h2,
            .dashboard-sidebar .profile-info,
            .dashboard-sidebar .sidebar-menu-item span,
            .dashboard-sidebar .sidebar-heading {
                opacity: 0;
                transform: translateX(-20px);
            }
            
            .dashboard-sidebar .admin-profile {
                justify-content: center;
                padding: 20px 10px;
            }
            
            .dashboard-sidebar .sidebar-menu-item {
                justify-content: center;
                padding: 14px 0;
            }
            
            .dashboard-sidebar .sidebar-menu-item i {
                margin-right: 0;
                font-size: 20px;
            }
            
            .dashboard-sidebar .sidebar-divider {
                margin: 15px 10px;
            }
            
            .main-content {
                margin-left: var(--sidebar-collapsed-width);
            }
        }

        /* Small tablets (768px and below) */
        @media (max-width: 768px) {
            .dashboard-sidebar {
                transform: translateX(-100%);
                width: var(--sidebar-width);
            }
            
            .dashboard-sidebar.mobile-open {
                transform: translateX(0);
            }
            
            .dashboard-sidebar .logo h2,
            .dashboard-sidebar .profile-info,
            .dashboard-sidebar .sidebar-menu-item span,
            .dashboard-sidebar .sidebar-heading {
                opacity: 1;
                transform: translateX(0);
            }
            
            .dashboard-sidebar .admin-profile {
                justify-content: flex-start;
                padding: 20px;
            }
            
            .dashboard-sidebar .sidebar-menu-item {
                justify-content: flex-start;
                padding: 14px 20px;
            }
            
            .dashboard-sidebar .sidebar-menu-item i {
                margin-right: 15px;
                font-size: 18px;
            }
            
            .dashboard-sidebar .sidebar-divider {
                margin: 15px 20px;
            }
            
            .mobile-menu-toggle {
                display: flex;
            }
            
            .sidebar-toggle {
                display: none;
            }
            
            .main-content {
                margin-left: 0;
            }
        }

        /* Mobile phones (576px and below) */
        @media (max-width: 576px) {
            .sidebar-header {
                padding: 0 15px;
            }
            
            .admin-profile {
                padding: 15px;
            }
            
            .sidebar-menu-item {
                padding: 12px 15px;
            }
            
            .sidebar-heading {
                padding: 15px 15px 5px;
            }
            
            .sidebar-divider {
                margin: 15px;
            }
            
            .main-content {
                padding: 15px;
            }
            
            .mobile-menu-toggle {
                width: 40px;
                height: 40px;
                top: 15px;
                left: 15px;
            }
        }

        /* Extra small devices (480px and below) */
        @media (max-width: 480px) {
            .dashboard-sidebar {
                width: 85vw;
                max-width: 280px;
            }
        }

        /* Demo Content Styles */
        .demo-content {
            background: white;
            padding: 30px;
            border-radius: var(--card-border-radius);
            box-shadow: var(--box-shadow);
            margin-bottom: 20px;
        }

        .demo-content h1 {
            color: var(--primary-color);
            margin-bottom: 20px;
        }

        .demo-cards {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: 20px;
            margin-top: 30px;
        }

        .demo-card {
            background: white;
            padding: 20px;
            border-radius: var(--card-border-radius);
            box-shadow: var(--box-shadow);
            text-align: center;
        }

        .demo-card i {
            font-size: 2.5rem;
            color: var(--primary-color);
            margin-bottom: 15px;
        }

        .demo-card h3 {
            color: var(--dark-color);
            margin-bottom: 10px;
        }

        .demo-card p {
            color: var(--gray-color);
            font-size: 14px;
        }
    </style>
</head>
<body>
    <div class="admin-dashboard" id="adminDashboard">
        <!-- Mobile Menu Toggle -->
        <button class="mobile-menu-toggle" id="mobileMenuToggle">
            <i class="fas fa-bars"></i>
        </button>

        <!-- Sidebar Overlay -->
        <div class="sidebar-overlay" id="sidebarOverlay"></div>

        <!-- Dashboard Sidebar -->
        <div class="dashboard-sidebar" id="dashboardSidebar">
            <div class="sidebar-header">
                <div class="logo">
                    <img src="/api/placeholder/40/40" alt="Logo">
                    <h2>Admin Portal</h2>
                </div>
                <button id="sidebarToggle" class="sidebar-toggle">
                    <i class="fas fa-bars"></i>
                </button>
            </div>

            <div class="admin-profile">
                <div class="profile-avatar">
                    <img src="/api/placeholder/50/50" alt="Admin Avatar">
                </div>
                <div class="profile-info">
                    <h3>Administrator</h3>
                    <span>System Admin</span>
                </div>
            </div>

            <div class="sidebar-menu">
                <a href="#" class="sidebar-menu-item active">
                    <i class="fas fa-tachometer-alt"></i>
                    <span>Dashboard</span>
                    <div class="tooltip">Dashboard</div>
                </a>

                <div class="sidebar-divider"></div>
                <div class="sidebar-heading">Car Owner</div>

                <a href="#" class="sidebar-menu-item">
                    <i class="fas fa-car"></i>
                    <span>Car Registration</span>
                    <div class="tooltip">Car Registration</div>
                </a>

                <a href="#" class="sidebar-menu-item">
                    <i class="fas fa-clipboard-check"></i>
                    <span>Inspection Requests</span>
                    <div class="tooltip">Inspection Requests</div>
                </a>

                <a href="#" class="sidebar-menu-item">
                    <i class="fas fa-check-circle"></i>
                    <span>Approve Inspections</span>
                    <div class="tooltip">Approve Inspections</div>
                </a>

                <div class="sidebar-divider"></div>
                <div class="sidebar-heading">Customer</div>

                <a href="#" class="sidebar-menu-item">
                    <i class="fas fa-id-card"></i>
                    <span>Verify Users</span>
                    <div class="tooltip">Verify Users</div>
                </a>

                <a href="#" class="sidebar-menu-item">
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

                <a href="#" class="sidebar-menu-item">
                    <i class="fas fa-calendar-check"></i>
                    <span>Booked Cars</span>
                    <div class="tooltip">Booked Cars</div>
                </a>

                <a href="#" class="sidebar-menu-item">
                    <i class="fas fa-sign-out-alt"></i>
                    <span>Logout</span>
                    <div class="tooltip">Logout</div>
                </a>
            </div>
        </div>

        <!-- Main Content -->
        <div class="main-content" id="mainContent">
            <div class="demo-content">
                <h1>Responsive Admin Dashboard</h1>
                <p>This sidebar is fully responsive and adapts to different screen sizes:</p>
                <ul style="margin: 20px 0; padding-left: 20px;">
                    <li><strong>Desktop (> 992px):</strong> Full sidebar with text and icons</li>
                    <li><strong>Large tablets (≤ 992px):</strong> Collapsed sidebar with icons only</li>
                    <li><strong>Small tablets (≤ 768px):</strong> Hidden sidebar with mobile toggle</li>
                    <li><strong>Mobile (≤ 576px):</strong> Slide-in sidebar with overlay</li>
                </ul>
                <p>Try resizing your browser window to see the responsive behavior in action!</p>
            </div>

            <div class="demo-cards">
                <div class="demo-card">
                    <i class="fas fa-users"></i>
                    <h3>Total Users</h3>
                    <p>Manage and track all registered users in the system</p>
                </div>
                <div class="demo-card">
                    <i class="fas fa-car"></i>
                    <h3>Registered Cars</h3>
                    <p>Monitor car registrations and approvals</p>
                </div>
                <div class="demo-card">
                    <i class="fas fa-chart-bar"></i>
                    <h3>Analytics</h3>
                    <p>View detailed analytics and reports</p>
                </div>
                <div class="demo-card">
                    <i class="fas fa-cog"></i>
                    <h3>Settings</h3>
                    <p>Configure system settings and preferences</p>
                </div>
            </div>
        </div>
    </div>

    <script>
        // Get elements
        const sidebarToggle = document.getElementById('sidebarToggle');
        const mobileMenuToggle = document.getElementById('mobileMenuToggle');
        const dashboardSidebar = document.getElementById('dashboardSidebar');
        const sidebarOverlay = document.getElementById('sidebarOverlay');
        const mainContent = document.getElementById('mainContent');
        const adminDashboard = document.getElementById('adminDashboard');

        // Desktop sidebar toggle
        sidebarToggle.addEventListener('click', function() {
            dashboardSidebar.classList.toggle('collapsed');
            mainContent.classList.toggle('collapsed');
        });

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
                mainContent.classList.add('collapsed');
            } else if (window.innerWidth > 992) {
                dashboardSidebar.classList.remove('collapsed');
                mainContent.classList.remove('collapsed');
            }
        }

        // Run on load
        handleResize();
        window.addEventListener('resize', handleResize);
    </script>
</body>
</html>







<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Car Rental System')</title>

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    
    <!-- Font Awesome (Icons) -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    <!-- Custom CSS -->
    <link rel="stylesheet" href="{{ asset('assets/css/styles.css') }}">

    @yield('head')
</head>
<body class="bg-light d-flex flex-column min-vh-100">

    <!-- Header Section -->
    <header class="bg-dark text-white">
        <nav class="navbar navbar-expand-lg navbar-dark container">
            <div class="container-fluid">
                <a class="navbar-brand" href="/">Car Rental System</a>
                
                @unless(
                    Request::is('login') || 
                    Request::is('register') ||
                    Request::is('admin/login') ||
                    Request::is('admin/register') ||
                    Request::is('customer/login') ||
                    Request::is('customer/register') ||
                    Request::is('carowner/login') ||
                    Request::is('carowner/register')
                )
                    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                        <span class="navbar-toggler-icon"></span>
                    </button>
                    <div class="collapse navbar-collapse" id="navbarNav">
                        {{-- <ul class="navbar-nav me-auto">
                            <li class="nav-item">
                                <a class="nav-link" href="/">Home</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="/cars">Cars</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="/about">About</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="/contact">Contact</a>
                            </li>
                        </ul> --}}
                        <ul class="navbar-nav">
                            @auth
                                <li class="nav-item dropdown">
                                    <a class="nav-link dropdown-toggle" href="#" id="userDropdown" role="button" data-bs-toggle="dropdown">
                                        <i class="fas fa-user-circle me-1"></i> {{ Auth::user()->name }}
                                    </a>
                                    <ul class="dropdown-menu dropdown-menu-end">
                                        <li><a class="dropdown-item" href="/profile">Profile</a></li>
                                        <li><a class="dropdown-item" href="/bookings">My Bookings</a></li>
                                        <li><hr class="dropdown-divider"></li>
                                        <li>
                                            <form method="POST" action="{{ route('logout') }}">
                                                @csrf
                                                <button type="submit" class="dropdown-item">Logout</button>
                                            </form>
                                        </li>
                                    </ul>
                                </li>
                            @else
                                <li class="nav-item">
                                    <a class="nav-link" href="{{ route('login') }}">Login</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" href="{{ route('register') }}">Register</a>
                                </li>
                            @endauth
                        </ul>
                    </div>
                @endunless
            </div>
        </nav>
    </header>

    <!-- Main Content Section -->
    <main class="flex-grow-1 py-4">
        <div class="container">
            @yield('content')
        </div>
    </main>

    <!-- Footer Section - Hidden on auth pages -->
    @unless(
        Request::is('login') || 
        Request::is('register') ||
        Request::is('admin/login') ||
        Request::is('admin/register') ||
        Request::is('customer/login') ||
        Request::is('customer/register') ||
        Request::is('carowner/login') ||
        Request::is('carowner/register')
    )
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
                    <p class="mb-0">&copy; {{ date('Y') }} Car Rental System. All rights reserved.</p>
                </div>
            </div>
        </footer>
    @endunless

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
    @yield('scripts')
</body>
</html>


{{-- <!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Car Rental System')</title>

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    
    <!-- Font Awesome (Icons) -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    <!-- Custom CSS -->
    <link rel="stylesheet" href="{{ asset('assets/css/styles.css') }}">

    @yield('head')
</head>

    <!-- Bootstrap Bundle with Popper -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>

    <body>
    <!-- Include Header -->
    @include('layouts.header')

    <!-- Content -->
    <div class="content">
        @yield('content')
    </div>

    <!-- Include Footer -->
    @include('layouts.footer')


</body>

</html> --}}



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
    </style>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Car Rental System')</title>

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    
    <!-- Font Awesome (Icons) -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    <!-- Custom CSS -->
    <link rel="stylesheet" href="{{ asset('assets/css/styles.css') }}">

    @yield('head')
</head>
<body class="bg-light d-flex flex-column min-vh-100">

    <!-- Header Section -->
    <header class="bg-dark text-white">
        <nav class="navbar navbar-expand-lg navbar-dark container">
            <div class="container-fluid">
                <a class="navbar-brand" href="/">Car Rental System</a>
                
                @unless(
                    Request::is('login') || 
                    Request::is('register') ||
                    Request::is('admin/login') ||
                    Request::is('admin/register') ||
                    Request::is('customer/login') ||
                    Request::is('customer/register') ||
                    Request::is('carowner/login') ||
                    Request::is('carowner/register')
                )
                    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                        <span class="navbar-toggler-icon"></span>
                    </button>
                    <div class="collapse navbar-collapse" id="navbarNav">
                        {{-- <ul class="navbar-nav me-auto">
                            <li class="nav-item">
                                <a class="nav-link" href="/">Home</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="/cars">Cars</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="/about">About</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="/contact">Contact</a>
                            </li>
                        </ul> --}}
                        <ul class="navbar-nav">
                            @auth
                                <li class="nav-item dropdown">
                                    <a class="nav-link dropdown-toggle" href="#" id="userDropdown" role="button" data-bs-toggle="dropdown">
                                        <i class="fas fa-user-circle me-1"></i> {{ Auth::user()->name }}
                                    </a>
                                    <ul class="dropdown-menu dropdown-menu-end">
                                        <li><a class="dropdown-item" href="/profile">Profile</a></li>
                                        <li><a class="dropdown-item" href="/bookings">My Bookings</a></li>
                                        <li><hr class="dropdown-divider"></li>
                                        <li>
                                            <form method="POST" action="{{ route('logout') }}">
                                                @csrf
                                                <button type="submit" class="dropdown-item">Logout</button>
                                            </form>
                                        </li>
                                    </ul>
                                </li>
                            @else
                                <li class="nav-item">
                                    <a class="nav-link" href="{{ route('login') }}">Login</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" href="{{ route('register') }}">Register</a>
                                </li>
                            @endauth
                        </ul>
                    </div>
                @endunless
            </div>
        </nav>
    </header>

    <!-- Main Content Section -->
    <main class="flex-grow-1 py-4">
        <div class="container">
            @yield('content')
        </div>
    </main>

    <!-- Footer Section - Hidden on auth pages -->
    @unless(
        Request::is('login') || 
        Request::is('register') ||
        Request::is('admin/login') ||
        Request::is('admin/register') ||
        Request::is('customer/login') ||
        Request::is('customer/register') ||
        Request::is('carowner/login') ||
        Request::is('carowner/register')
    )
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
                    <p class="mb-0">&copy; {{ date('Y') }} Car Rental System. All rights reserved.</p>
                </div>
            </div>
        </footer>
    @endunless

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
    @yield('scripts')
</body>
</html>





@extends('layouts.app')
@section('content')
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Responsive Admin Dashboard</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <!-- <script src="{{ asset('assets/js/sidebar.js') }}"></script> -->
    <link rel="stylesheet" href="{{ asset('assets/css/admin/dashboard.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/admin/adminsidebar.css') }}">
</head>
<body>
    <div class="admin-dashboard" id="adminDashboard">
        <!-- Mobile Menu Toggle -->
        <button class="mobile-menu-toggle" id="mobileMenuToggle">
            <i class="fas fa-bars"></i>
        </button>

        <!-- Sidebar Overlay -->
        <div class="sidebar-overlay" id="sidebarOverlay"></div>

        <!-- Dashboard Sidebar -->
        <div class="dashboard-sidebar" id="dashboardSidebar">
            <div class="sidebar-header">
                <div class="logo">
                    <img src="{{ asset('assets/images/logo.png') }}" alt="Logo">
                    <h2>Admin Portal</h2>
                </div>
                <button id="sidebarToggle" class="sidebar-toggle">
                    <i class="fas fa-bars"></i>
                </button>
            </div>

            <div class="admin-profile">
                @if(Auth::guard('admin')->check())
                    <div class="profile-avatar">
                        <img src="{{ asset('assets/images/thinley.jpg') }}" alt="Admin Avatar">
                    </div>
                    <div class="profile-info">
                        <h3>{{ Auth::guard('admin')->user()->name }}</h3>
                        <span>Administrator</span>
                    </div>
                @endif
            </div>

            <div class="sidebar-menu">
                <a href="{{ route('admin.dashboard') }}" class="sidebar-menu-item active">
                    <i class="fas fa-tachometer-alt"></i>
                    <span>Dashboard</span>
                </a>

                <div class="sidebar-divider"></div>
                <div class="sidebar-heading">Car Owner</div>

                <a href="{{ route('car-admin.new-registration-cars') }}" class="sidebar-menu-item">
                    <i class="fas fa-car"></i>
                    <span>Car Registration</span>
                    <div class="tooltip">Car Registration</div>
                </a>

                <a href="{{ route('car-admin.inspection-requests') }}" class="sidebar-menu-item">
                    <i class="fas fa-clipboard-check"></i>
                    <span>Inspection Requests</span>
                    <div class="tooltip">Inspection Requests</div>
                </a>

                <a href="{{ route('car-admin.approve-inspected-cars') }}" class="sidebar-menu-item">
                    <i class="fas fa-check-circle"></i>
                    <span>Approve Inspections</span>
                    <div class="tooltip">Approve Inspections</div>
                </a>

                <div class="sidebar-divider"></div>
                <div class="sidebar-heading">Customer</div>

                <a href="{{ route('admin.verify-users') }}" class="sidebar-menu-item">
                    <i class="fas fa-id-card"></i>
                    <span>Verify Users</span>
                    <div class="tooltip">Verify Users</div>
                </a>

                <a href="{{ route('admin.payments.index') }}" class="sidebar-menu-item">
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

                <a href="{{ route('admin.booked-car') }}" class="sidebar-menu-item">
                    <i class="fas fa-calendar-check"></i>
                    <span>Booked Cars</span>
                    <div class="tooltip">Booked Cars</div>
                </a>

                <a href="#" class="sidebar-menu-item" onclick="document.getElementById('logout-form').submit();">
                    <i class="fas fa-sign-out-alt"></i>
                    <span>Logout</span>
                    <div class="tooltip">Logout</div>
                </a>

                <form method="POST" action="{{ route('admin.logout') }}" id="logout-form" style="display: none;">
                    @csrf
                </form>
            </div>
        </div>

        <div class="dashboard-content">
            <!-- Top Header -->
            <div class="dashboard-header">
                <div class="header-search">
                    <i class="fas fa-search"></i>
                    <input type="text" placeholder="Search...">
                </div>
                <div class="header-actions">
                    <div class="notification">
                        <i class="fas fa-bell"></i>
                        <span class="badge">3</span>
                    </div>
                    <div class="messages">
                        <i class="fas fa-envelope"></i>
                        <span class="badge">5</span>
                    </div>
                    <div class="account-menu">
                        @if(Auth::guard('admin')->check())
                            <span>{{ Auth::guard('admin')->user()->name }}</span>
                            {{-- <img src="{{ asset('assets/images/avatar-placeholder.jpg') }}" alt="Admin Avatar"> --}}
                        @else
                            <a href="{{ route('admin.login') }}" class="btn btn-primary">Login</a>
                        @endif
                    </div>
                </div>
            </div>

            <!-- DYNAMIC CONTENT LOADER (this will be updated by JS below) -->
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
                        <a href="{{ route('car-admin.new-registration-cars') }}" class="action-btn">
                            <i class="fas fa-car"></i>
                            <span>Car Registration Request</span>
                        </a>
                        <a href="{{ route('car-admin.inspection-requests') }}" class="action-btn">
                            <i class="fas fa-clipboard-check"></i>
                            <span>Manage Inspection Requests</span>
                        </a>
                        <a href="{{ route('car-admin.approve-inspected-cars') }}" class="action-btn">
                            <i class="fas fa-check-circle"></i>
                            <span>Approve/Reject Inspected Cars</span>
                        </a>
                        <a href="{{ url('admin/view-payments') }}" class="action-btn">
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

    @section('scripts')
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
        $(document).ready(function () {
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
        });
         // Get elements
        const sidebarToggle = document.getElementById('sidebarToggle');
        const mobileMenuToggle = document.getElementById('mobileMenuToggle');
        const dashboardSidebar = document.getElementById('dashboardSidebar');
        const sidebarOverlay = document.getElementById('sidebarOverlay');
        const mainContent = document.getElementById('mainContent');
        const adminDashboard = document.getElementById('adminDashboard');

        // Desktop sidebar toggle
        sidebarToggle.addEventListener('click', function() {
            dashboardSidebar.classList.toggle('collapsed');
            mainContent.classList.toggle('collapsed');
        });

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
                mainContent.classList.add('collapsed');
            } else if (window.innerWidth > 992) {
                dashboardSidebar.classList.remove('collapsed');
                mainContent.classList.remove('collapsed');
            }
        }

        // Run on load
        handleResize();
        window.addEventListener('resize', handleResize);
    </script>
    @endsection
</body>
</html>
@endsection