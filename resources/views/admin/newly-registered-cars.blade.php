@extends('layouts.app')

@section('content')
<link rel="stylesheet" href="{{ asset('assets/css/admin/newly-registered-cars.css') }}">
    
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
    
    <nav class="sidebar-nav">
        <ul>
            <li>
                <a href="{{ route('admin.dashboard') }}" class="sidebar-menu-item">
                    <i class="fas fa-tachometer-alt"></i>
                    <span>Dashboard</span>
                </a>
            </li>
    
            <div class="sidebar-divider"></div>
    
            <div class="sidebar-heading">Car Owner</div>
    
            <li>
                <a href="{{ route('car-admin.new-registration-cars') }}" class="sidebar-menu-item active">
                    <i class="fas fa-car"></i>
                    <span>Car Registration</span>
                </a>
            </li>
            <li>
                <a href="{{ route('car-admin.inspection-requests') }}" class="sidebar-menu-item">
                    <i class="fas fa-clipboard-check"></i>
                    <span>Inspection Requests</span>
                </a>
            </li>
            <li>
                <a href="{{ route('car-admin.approve-inspected-cars') }}" class="sidebar-menu-item">
                    <i class="fas fa-check-circle"></i>
                    <span>Approve Inspections</span>
                </a>
            </li>
    
            <div class="sidebar-divider"></div>
    
            <div class="sidebar-heading">Customer</div>
    
            <li>
                <a href="{{ route('admin.verify-users') }}" class="sidebar-menu-item">
                    <i class="fas fa-id-card"></i>
                    <span>Verify Users</span>
                </a>
            </li>
            <li>
                <a href="{{ url('admin/view-payments') }}" class="sidebar-menu-item">
                    <i class="fas fa-credit-card"></i>
                    <span>Payments</span>
                </a>
            </li>
            <li>
                <a href="{{ url('admin/update-car-registration') }}" class="sidebar-menu-item">
                    <i class="fas fa-edit"></i>
                    <span>Update Registration</span>
                </a>
            </li>
            <li>
                <a href="{{ url('admin/car-information-update') }}" class="sidebar-menu-item">
                    <i class="fas fa-info-circle"></i>
                    <span>Car Information</span>
                </a>
            </li>
            <li>
                <a href="{{ url('admin/booked-car') }}" class="sidebar-menu-item">
                    <i class="fas fa-calendar-check"></i>
                    <span>Booked Cars</span>
                </a>
            </li>
    
            <li>
                <a href="#" class="sidebar-menu-item" onclick="document.getElementById('logout-form').submit();">
                    <i class="fas fa-sign-out-alt"></i>
                    <span>Logout</span>
                </a>
                <form method="POST" action="{{ route('admin.logout') }}" id="logout-form">
                    @csrf
                </form>
            </li>
        </ul>
    </nav>        
</div>

<div class="container">
    <h1>Car Registration Request</h1>

    @if($cars->isEmpty())
        <div class="empty-message">
            <i class="fas fa-car fa-3x mb-3" style="color: #ccc;"></i>
            <p>No cars found.</p>
        </div>
    @else
        <div class="table-container">
            <div class="table-responsive">
                <table class="table">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Maker</th>
                            <th>Model</th>
                            <th>Vehicle Type</th>
                            <th>Price per Day</th>
                            <th>Registration Number</th>
                            <th>Status</th>
                            <th>Car Image</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($cars as $car)
                            <tr>
                                <td>{{ $car->id }}</td>
                                <td>{{ $car->maker }}</td>
                                <td>{{ $car->model }}</td>
                                <td>{{ $car->vehicle_type }}</td>
                                <td>{{ $car->price }}</td>
                                <td>{{ $car->registration_no }}</td>
                                <td>
                                    <span class="status-{{ strtolower($car->status) }}">
                                        {{ $car->status }}
                                    </span>
                                </td>
                                <td>
                                    @if($car->car_image)
                                        <img src="{{ asset($car->car_image) }}" alt="Car Image">
                                    @else
                                        <p>No image</p>
                                    @endif
                                </td>
                                <td>
                                    @if(strtolower($car->status) === 'rejected')
                                        <span class="text-danger">Rejected</span>
                                    @else
                                        <a href="{{ route('car-admin.view-car', $car->id) }}" class="btn btn-info">
                                            <i class="fas fa-eye"></i> View
                                        </a>
                                    @endif
                                </td>                            
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    @endif
</div>

{{-- Font Awesome --}}
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">

{{-- Responsive Dashboard JavaScript --}}
<script>
    // responsive-dashboard.js

    document.addEventListener('DOMContentLoaded', function() {
        // Elements
        const sidebarToggle = document.getElementById('sidebar-toggle');
        const sidebar = document.querySelector('.dashboard-sidebar');
        const body = document.body;
        
        // Create overlay element for mobile
        const overlay = document.createElement('div');
        overlay.className = 'sidebar-overlay';
        document.body.appendChild(overlay);
        
        // Function to check window width and set appropriate classes
        function checkWindowSize() {
            if (window.innerWidth < 992) {
                // Mobile view - sidebar starts hidden
                sidebar.classList.remove('collapsed');
                body.classList.remove('sidebar-collapsed');
                
                // Store current state
                sidebar.setAttribute('data-state', 'closed');
            } else {
                // Desktop view - check previous state
                const savedState = localStorage.getItem('sidebarState');
                if (savedState === 'collapsed') {
                    sidebar.classList.add('collapsed');
                    body.classList.add('sidebar-collapsed');
                } else {
                    sidebar.classList.remove('collapsed');
                    body.classList.remove('sidebar-collapsed');
                }
                
                // Store current state
                sidebar.setAttribute('data-state', savedState || 'open');
            }
        }

        // Initialize
        checkWindowSize();
        
        // Toggle sidebar on button click
        sidebarToggle.addEventListener('click', function() {
            if (window.innerWidth < 992) {
                // Mobile view - show/hide via transform
                if (sidebar.classList.contains('mobile-open')) {
                    // Close sidebar
                    sidebar.classList.remove('mobile-open');
                    overlay.classList.remove('active');
                    sidebar.setAttribute('data-state', 'closed');
                } else {
                    // Open sidebar
                    sidebar.classList.add('mobile-open');
                    overlay.classList.add('active');
                    sidebar.setAttribute('data-state', 'open');
                }
            } else {
                // Desktop view - collapse/expand
                if (sidebar.classList.contains('collapsed')) {
                    // Expand sidebar
                    sidebar.classList.remove('collapsed');
                    body.classList.remove('sidebar-collapsed');
                    localStorage.setItem('sidebarState', 'open');
                    sidebar.setAttribute('data-state', 'open');
                } else {
                    // Collapse sidebar
                    sidebar.classList.add('collapsed');
                    body.classList.add('sidebar-collapsed');
                    localStorage.setItem('sidebarState', 'collapsed');
                    sidebar.setAttribute('data-state', 'collapsed');
                }
            }
        });
        
        // Close sidebar when clicking on overlay
        overlay.addEventListener('click', function() {
            sidebar.classList.remove('mobile-open');
            overlay.classList.remove('active');
        });
        
        // Close sidebar when clicking on a menu item (mobile only)
        const menuItems = document.querySelectorAll('.sidebar-menu-item');
        menuItems.forEach(item => {
            item.addEventListener('click', function() {
                if (window.innerWidth < 992 && sidebar.classList.contains('mobile-open')) {
                    sidebar.classList.remove('mobile-open');
                    overlay.classList.remove('active');
                }
            });
        });
        
        // Listen for window resize
        window.addEventListener('resize', function() {
            checkWindowSize();
            
            // Additional handling for transition between mobile/desktop
            if (window.innerWidth >= 992) {
                // Switching to desktop
                sidebar.classList.remove('mobile-open');
                overlay.classList.remove('active');
            }
        });
        
        // Initialize Bootstrap tooltips if Bootstrap is loaded
        if (typeof bootstrap !== 'undefined' && bootstrap.Tooltip) {
            const tooltipTriggerList = document.querySelectorAll('[data-bs-toggle="tooltip"]');
            [...tooltipTriggerList].map(tooltipTriggerEl => new bootstrap.Tooltip(tooltipTriggerEl));
        }
    });
</script>
@endsection