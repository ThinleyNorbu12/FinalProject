@extends('layouts.app')

<!-- Link to external CSS files -->
<link rel="stylesheet" href="{{ asset('assets/css/carowner/dashboard.css') }}">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

@section('content')
<div class="dashboard-container">
    <!-- Sidebar -->
    <div class="sidebar" id="sidebar">
        <div class="sidebar-header">
            <img src="/api/placeholder/200/60" alt="Logo" class="logo">
            <span class="close-sidebar" id="closeSidebar"><i class="fas fa-times"></i></span>
        </div>
        <div class="sidebar-user">
            <div class="user-avatar">
                <img src="/api/placeholder/60/60" alt="User Profile" class="rounded-circle">
            </div>
            <div class="user-info">
                @if(Auth::guard('carowner')->check())
                    <h5>{{ Auth::guard('carowner')->user()->name }}</h5>
                    <p>Car Owner</p>
                @else
                    <h5>Guest User</h5>
                    <p>Please login</p>
                @endif
            </div>
        </div>
        <div class="sidebar-menu">
            <ul>
                <li class="active">
                    <a href="{{ route('carowner.dashboard') }}">
                        <i class="fas fa-tachometer-alt"></i>
                        <span>Dashboard</span>
                    </a>
                </li>
                <li>
                    <a href="{{ route('carowner.rentCar') }}">
                        <i class="fas fa-car"></i>
                        <span>Rent a Car</span>
                    </a>
                </li>
                {{-- <li>
                    <a href="{{ route('carowner.view.rented') }}">
                        <i class="fas fa-clipboard-list"></i>
                        <span>Registration Requests</span>
                    </a>
                </li> --}}
                <li>
                    <a href="{{ route('carowner.car-inspection') }}">
                        <i class="fas fa-search"></i>
                        <span>Inspection Requests</span>
                        <span class="badge bg-danger rounded-pill">2</span>
                    </a>
                </li>
                <li>
                    <a href="{{ route('carowner.approved') }}">
                        <i class="fas fa-check-circle"></i>
                        <span>Approved Cars</span>
                    </a>
                </li>
                <li>
                    <a href="{{ route('carowner.rejected') }}">
                        <i class="fas fa-times-circle"></i>
                        <span>Rejected Cars</span>
                    </a>
                </li>
                <li>
                    <a href="{{ url('carowner/payment-summary') }}">
                        <i class="fas fa-money-bill-wave"></i>
                        <span>Payment Summary</span>
                    </a>
                </li>
                <li class="sidebar-divider"></li>
                <li>
                    <a href="#">
                        <i class="fas fa-cog"></i>
                        <span>Account Settings</span>
                    </a>
                </li>
                <li>
                    <form method="POST" action="{{ route('carowner.logout') }}" id="logoutForm">
                        @csrf
                        <a href="#" onclick="document.getElementById('logoutForm').submit(); return false;">
                            <i class="fas fa-sign-out-alt"></i>
                            <span>Logout</span>
                        </a>
                    </form>
                </li>
            </ul>
        </div>
    </div>

    <!-- Main Content Area -->
    <div class="main-content">
        <!-- Header -->
        <header class="dashboard-header">
            <div class="toggle-sidebar" id="toggleSidebar">
                <i class="fas fa-bars"></i>
            </div>
            <div class="search-box">
                <input type="text" placeholder="Search...">
                <button><i class="fas fa-search"></i></button>
            </div>
            <div class="header-right">
                <div class="notification">
                    <i class="fas fa-bell"></i>
                    <span class="badge">3</span>
                </div>
                <div class="header-user-info">
                    @if(Auth::guard('carowner')->check())
                        <span>{{ Auth::guard('carowner')->user()->name }}</span>
                        <img src="/api/placeholder/40/40" alt="User Profile" class="rounded-circle">
                    @else
                        <span>Guest</span>
                        <img src="/api/placeholder/40/40" alt="User Profile" class="rounded-circle">
                    @endif
                </div>
            </div>
        </header>

        <!-- Content Section -->
        <div class="content-wrapper">
            <div class="page-header">
                <h1>Dashboard</h1>
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="#">Home</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Dashboard</li>
                    </ol>
                </nav>
            </div>

            <!-- Stats Cards -->
            <div class="stats-cards">
                <div class="row">
                    <div class="col-md-3 col-sm-6">
                        <div class="stat-card">
                            <div class="stat-card-icon bg-primary">
                                <i class="fas fa-car"></i>
                            </div>
                            <div class="stat-card-info">
                                <h5>My Cars</h5>
                                <h3>12</h3>
                                <p>Total registered cars</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3 col-sm-6">
                        <div class="stat-card">
                            <div class="stat-card-icon bg-success">
                                <i class="fas fa-check-circle"></i>
                            </div>
                            <div class="stat-card-info">
                                <h5>Approved</h5>
                                <h3>8</h3>
                                <p>Cars ready for rent</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3 col-sm-6">
                        <div class="stat-card">
                            <div class="stat-card-icon bg-warning">
                                <i class="fas fa-clock"></i>
                            </div>
                            <div class="stat-card-info">
                                <h5>Pending</h5>
                                <h3>3</h3>
                                <p>Awaiting approval</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3 col-sm-6">
                        <div class="stat-card">
                            <div class="stat-card-icon bg-danger">
                                <i class="fas fa-times-circle"></i>
                            </div>
                            <div class="stat-card-info">
                                <h5>Rejected</h5>
                                <h3>1</h3>
                                <p>Denied applications</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Quick Actions -->
            <div class="quick-actions">
                <h4>Quick Actions</h4>
                <div class="row">
                    <div class="col-md-4">
                        <a href="{{ route('carowner.rentCar') }}" class="action-card">
                            <div class="action-icon">
                                <i class="fas fa-car-side"></i>
                            </div>
                            <div class="action-text">
                                <h5>Rent A Car</h5>
                                <p>Submit a new car for rental</p>
                            </div>
                        </a>
                    </div>
                    <div class="col-md-4">
                        <a href="{{ route('carowner.car-inspection') }}" class="action-card">
                            <div class="action-icon">
                                <i class="fas fa-clipboard-check"></i>
                            </div>
                            <div class="action-text">
                                <h5>Inspection Requests</h5>
                                <p>View pending inspections</p>
                            </div>
                            <span class="badge bg-danger">2</span>
                        </a>
                    </div>
                    <div class="col-md-4">
                        <a href="{{ url('carowner/payment-summary') }}" class="action-card">
                            <div class="action-icon">
                                <i class="fas fa-wallet"></i>
                            </div>
                            <div class="action-text">
                                <h5>Payment Summary</h5>
                                <p>View your earnings</p>
                            </div>
                        </a>
                    </div>
                </div>
            </div>

            <!-- Recent Activity -->
            <div class="recent-activity">
                <div class="section-header">
                    <h4>Recent Activities</h4>
                    <a href="#" class="view-all">View All</a>
                </div>
                <div class="activity-list">
                    <div class="activity-item">
                        <div class="activity-icon bg-success">
                            <i class="fas fa-check"></i>
                        </div>
                        <div class="activity-details">
                            <h5>Car Approved</h5>
                            <p>Your Toyota Camry has been approved for rental</p>
                            <span class="activity-time">Today, 10:30 AM</span>
                        </div>
                    </div>
                    <div class="activity-item">
                        <div class="activity-icon bg-primary">
                            <i class="fas fa-car"></i>
                        </div>
                        <div class="activity-details">
                            <h5>Car Registration</h5>
                            <p>You registered Honda Civic for inspection</p>
                            <span class="activity-time">Yesterday, 3:45 PM</span>
                        </div>
                    </div>
                    <div class="activity-item">
                        <div class="activity-icon bg-warning">
                            <i class="fas fa-clock"></i>
                        </div>
                        <div class="activity-details">
                            <h5>Inspection Scheduled</h5>
                            <p>Inspection for BMW X5 scheduled on May 25, 2025</p>
                            <span class="activity-time">May 20, 2025, 11:20 AM</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Footer -->
        <footer class="dashboard-footer">
            <div class="footer-content">
                <div class="copyright">
                    &copy; 2025 Car Rental System. All rights reserved.
                </div>
                <div class="footer-links">
                    <a href="#">Privacy Policy</a>
                    <a href="#">Terms of Service</a>
                    <a href="#">Contact Support</a>
                </div>
            </div>
        </footer>
    </div>
</div>

<!-- Add JavaScript for sidebar toggle functionality -->
<script>
document.addEventListener("DOMContentLoaded", function() {
    const sidebar = document.getElementById('sidebar');
    const toggleSidebar = document.getElementById('toggleSidebar');
    const closeSidebar = document.getElementById('closeSidebar');
    const mainContent = document.querySelector('.main-content');
    
    toggleSidebar.addEventListener('click', function() {
        sidebar.classList.toggle('collapsed');
        mainContent.classList.toggle('expanded');
    });
    
    closeSidebar.addEventListener('click', function() {
        sidebar.classList.add('collapsed');
        mainContent.classList.add('expanded');
    });
    
    // Collapse sidebar on small screens by default
    function checkScreenSize() {
        if (window.innerWidth < 768) {
            sidebar.classList.add('collapsed');
            mainContent.classList.add('expanded');
        } else {
            sidebar.classList.remove('collapsed');
            mainContent.classList.remove('expanded');
        }
    }
    
    // Check on load and on resize
    checkScreenSize();
    window.addEventListener('resize', checkScreenSize);
});
</script>
@endsection