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
    <link rel="stylesheet" href="{{ asset('assets/css/admin/dashboard.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/admin/adminsidebar.css') }}">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <link rel="stylesheet" href="{{ asset('assets/css/admin/darkmode.css') }}">
</head>
<body>
    <!-- Enhanced Admin Header -->
    <header class="admin-header" id="adminHeader">
        <div class="header-left">
            <button class="mobile-menu-toggle d-md-none" id="mobileMenuToggle">
                <i class="fas fa-bars"></i>
            </button>
            
            <a href="{{ route('admin.dashboard') }}" class="header-brand d-none d-md-flex">
                <img src="{{ asset('assets/images/logo.png') }}" alt="Logo">
                <span>Car Rental system </span>
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

            @if(Auth::guard('admin')->check())
                <div class="header-profile">
                    <img src="{{ asset('assets/images/thinley.jpg') }}" alt="Admin Avatar">
                    <div class="header-profile-info d-none d-sm-block">
                        <h4>{{ Auth::guard('admin')->user()->name }}</h4>
                        <span>Administrator</span>
                    </div>
                    <i class="fas fa-chevron-down d-none d-sm-inline"></i>
                </div>
            @else
                <a href="{{ route('admin.login') }}" class="btn btn-primary">Login</a>
            @endif
        </div>
    </header>

    <div class="admin-dashboard" id="adminDashboard">
        <!-- Sidebar Overlay -->
        <div class="sidebar-overlay" id="sidebarOverlay"></div>

        <!-- Dashboard Sidebar -->
        <div class="dashboard-sidebar" id="dashboardSidebar">
            <!-- Enhanced Arrow Toggle Button -->
            <div class="sidebar-header">
                {{-- <button id="sidebar-toggle" class="sidebar-toggle">
                    <i class="fas fa-bars"></i>
                </button> --}}
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
                <div class="sidebar-heading">Manage Service</div>
                
                <a href="{{ route('cars.index') }}" class="sidebar-menu-item ">
                    <i class="fas fa-car"></i>
                    <span> Cars</span>
                    <div class="tooltip"> Cars</div>
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

                <form method="POST" action="{{ route('admin.logout') }}" id="logout-form" style="display: none;">
                    @csrf
                </form>
            </div>
        </div>

        <div class="dashboard-content" id="dashboardContent">
            <!-- Breadcrumb Navigation -->
            <nav class="page-breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item">
                        <i class="fas fa-home"></i>
                        <a href="{{ route('admin.dashboard') }}">Home</a>
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

    <!-- Enhanced Admin Footer -->
    <footer class="admin-footer" id="adminFooter">
        <div class="footer-left">
            <div class="footer-copy">
                <p class="mb-0">&copy; {{ date('Y') }} Car Rental System. All rights reserved.</p>
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

    @section('scripts')
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
       document.addEventListener('DOMContentLoaded', function() {
        // Mobile menu toggle (hamburger in header)
        const mobileMenuToggle = document.getElementById('mobileMenuToggle');
        const dashboardSidebar = document.getElementById('dashboardSidebar');
        const sidebarOverlay = document.getElementById('sidebarOverlay');
        
        if (mobileMenuToggle) {
            mobileMenuToggle.addEventListener('click', function() {
                dashboardSidebar.classList.toggle('active');
                sidebarOverlay.classList.toggle('active');
            });
        }
        
        // Sidebar overlay (closes sidebar when clicking outside)
        if (sidebarOverlay) {
            sidebarOverlay.addEventListener('click', function() {
                dashboardSidebar.classList.remove('active');
                sidebarOverlay.classList.remove('active');
            });
        }
        
        // Sidebar toggle button (arrow)
        const sidebarToggle = document.getElementById('sidebar-toggle');
        const adminDashboard = document.getElementById('adminDashboard');
        
        if (sidebarToggle) {
            sidebarToggle.addEventListener('click', function() {
                adminDashboard.classList.toggle('sidebar-collapsed');
                
                // Store the sidebar state in localStorage
                const isCollapsed = adminDashboard.classList.contains('sidebar-collapsed');
                localStorage.setItem('sidebarCollapsed', isCollapsed);
            });
            
            // Restore sidebar state from localStorage on page load
            const isCollapsed = localStorage.getItem('sidebarCollapsed') === 'true';
            if (isCollapsed) {
                adminDashboard.classList.add('sidebar-collapsed');
            }
        }
        
        // Dark mode toggle
        const darkModeToggle = document.getElementById('darkModeToggle');
        const toggleSwitch = document.getElementById('toggleSwitch');
        
        if (darkModeToggle) {
            // Function to set dark mode
            function setDarkMode(isDark) {
                if (isDark) {
                    document.body.classList.add('dark-mode');
                    toggleSwitch.classList.add('active');
                } else {
                    document.body.classList.remove('dark-mode');
                    toggleSwitch.classList.remove('active');
                }
                localStorage.setItem('darkMode', isDark);
            }
            
            // Check for saved theme preference
            const savedDarkMode = localStorage.getItem('darkMode') === 'true';
            setDarkMode(savedDarkMode);
            
            // Toggle dark mode when the button is clicked
            darkModeToggle.addEventListener('click', function() {
                const isDarkMode = document.body.classList.contains('dark-mode');
                setDarkMode(!isDarkMode);
            });
        }
    });
    </script>
    @endsection
</body>
</html>
@endsection