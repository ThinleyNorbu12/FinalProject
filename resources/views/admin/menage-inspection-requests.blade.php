@extends('layouts.app')

<style>
        /* Admin Layout CSS */
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
    --sidebar-collapsed-width: 80px;
    --header-height: 70px;
    --transition-speed: 0.3s;
    --card-border-radius: 12px;
    --box-shadow: 0 4px 20px rgba(0, 0, 0, 0.08);
    }

    /* Layout Structure */
    body {
    display: flex;
    min-height: 100vh;
    margin: 0;
    font-family: 'Poppins', sans-serif;
    background-color: #f5f7fa;
    color: #333;
    }

    .dashboard-wrapper {
    display: flex;
    width: 100%;
    overflow-x: hidden;
    position: relative;
    }

    /* Sidebar Styles */
    .dashboard-sidebar {
    width: var(--sidebar-width);
    min-height: 100vh;
    background: #fff;
    color: #555;
    position: fixed;
    left: 0;
    top: 0;
    bottom: 0;
    transition: all var(--transition-speed);
    z-index: 1000;
    overflow-y: auto;
    box-shadow: var(--box-shadow);
    }

    .dashboard-sidebar.collapsed {
    width: var(--sidebar-collapsed-width);
    }

    .sidebar-header {
    height: var(--header-height);
    padding: 0 20px;
    display: flex;
    align-items: center;
    justify-content: space-between;
    border-bottom: 1px solid #eee;
    }

    .sidebar-header .logo {
    display: flex;
    align-items: center;
    }

    .sidebar-header .logo img {
    height: 40px;
    width: auto;
    margin-right: 10px;
    }

    .sidebar-header .logo h2 {
    font-size: 18px;
    font-weight: 600;
    color: var(--primary-color);
    white-space: nowrap;
    overflow: hidden;
    transition: opacity var(--transition-speed);
    margin: 0;
    }

    .sidebar-toggle {
    background: transparent;
    border: none;
    color: var(--dark-color);
    cursor: pointer;
    font-size: 18px;
    padding: 5px;
    }

    .dashboard-sidebar.collapsed .logo h2 {
    opacity: 0;
    width: 0;
    }

    /* Admin Profile */
    .admin-profile {
    padding: 20px;
    display: flex;
    align-items: center;
    border-bottom: 1px solid #eee;
    }

    .profile-avatar {
    width: 50px;
    height: 50px;
    border-radius: 50%;
    background-color: rgba(67, 97, 238, 0.1);
    display: flex;
    align-items: center;
    justify-content: center;
    margin-right: 15px;
    overflow: hidden;
    box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
    }

    .profile-avatar img {
    width: 100%;
    height: 100%;
    object-fit: cover;
    }

    .profile-info {
    transition: opacity var(--transition-speed);
    }

    .profile-info h3 {
    margin: 0;
    font-size: 16px;
    font-weight: 600;
    margin-bottom: 3px;
    }

    .profile-info span {
    font-size: 12px;
    color: var(--gray-color);
    }

    .dashboard-sidebar.collapsed .profile-info {
    opacity: 0;
    width: 0;
    display: none;
    }

    /* Sidebar Navigation */
    .sidebar-nav {
    padding: 15px 0;
    }

    .sidebar-nav ul {
    list-style: none;
    padding: 0;
    margin: 0;
    }

    .sidebar-divider {
    height: 1px;
    background-color: #e5e5e5;
    margin: 10px 20px;
    }

    .sidebar-heading {
    color: #606060;
    font-size: 12px;
    font-weight: 600;
    padding: 10px 20px;
    text-transform: uppercase;
    letter-spacing: 0.5px;
    transition: opacity var(--transition-speed);
    }

    .dashboard-sidebar.collapsed .sidebar-heading {
    opacity: 0;
    height: 10px;
    }

    .sidebar-menu-item {
    display: flex;
    align-items: center;
    padding: 12px 20px;
    color: #555;
    text-decoration: none;
    transition: all 0.2s;
    border-left: 3px solid transparent;
    margin: 2px 0;
    }

    .sidebar-menu-item i {
    width: 20px;
    text-align: center;
    margin-right: 15px;
    font-size: 16px;
    }

    .sidebar-menu-item span {
    transition: opacity var(--transition-speed);
    white-space: nowrap;
    }

    .sidebar-menu-item:hover {
    background-color: rgba(67, 97, 238, 0.05);
    color: var(--primary-color);
    }

    .sidebar-menu-item.active {
    background-color: rgba(67, 97, 238, 0.1);
    color: var(--primary-color);
    border-left-color: var(--primary-color);
    font-weight: bold;
    }

    .dashboard-sidebar.collapsed .sidebar-menu-item span {
    opacity: 0;
    width: 0;
    display: none;
    }

    /* Main Content Area */
    .main-content {
    flex: 1;
    margin-left: var(--sidebar-width);
    padding: 20px;
    transition: margin-left var(--transition-speed);
    width: calc(100% - var(--sidebar-width));
    }

    .dashboard-sidebar.collapsed ~ .main-content {
    margin-left: var(--sidebar-collapsed-width);
    width: calc(100% - var(--sidebar-collapsed-width));
    }

    /* Container for page content */
    .container-fluid {
    width: 100%;
    padding-right: 15px;
    padding-left: 15px;
    margin-right: auto;
    margin-left: auto;
    }

    /* Card styling */
    .card {
    background: #fff;
    border-radius: var(--card-border-radius);
    padding: 25px;
    box-shadow: var(--box-shadow);
    transition: all 0.3s;
    border: none;
    overflow: hidden;
    position: relative;
    margin-bottom: 20px;
    }

    .card::before {
    content: '';
    position: absolute;
    top: 0;
    left: 0;
    width: 4px;
    height: 100%;
    background: var(--primary-color);
    opacity: 0;
    transition: opacity 0.3s;
    }

    .card:hover::before {
    opacity: 1;
    }

    .card:hover {
    transform: translateY(-5px);
    box-shadow: 0 8px 25px rgba(0, 0, 0, 0.1);
    }

    /* Responsive Adjustments */
    @media (max-width: 1200px) {
    .container-fluid {
        max-width: 100%;
    }
    }

    @media (max-width: 992px) {
    .sidebar-toggle {
        display: block;
    }
    
    .dashboard-sidebar {
        width: var(--sidebar-collapsed-width);
    }
    
    .logo h2,
    .profile-info,
    .sidebar-nav a span,
    .sidebar-heading {
        opacity: 0;
        visibility: hidden;
    }
    
    .main-content {
        margin-left: var(--sidebar-collapsed-width);
        width: calc(100% - var(--sidebar-collapsed-width));
    }
    
    .dashboard-sidebar.mobile-open {
        width: var(--sidebar-width);
    }
    
    .dashboard-sidebar.mobile-open .logo h2,
    .dashboard-sidebar.mobile-open .profile-info,
    .dashboard-sidebar.mobile-open .sidebar-menu-item span,
    .dashboard-sidebar.mobile-open .sidebar-heading {
        opacity: 1;
        visibility: visible;
        transition-delay: 0.2s;
    }
    }

    @media (max-width: 768px) {
    .main-content {
        padding: 15px;
    }
    }

    @media (max-width: 576px) {
    .dashboard-sidebar {
        transform: translateX(-100%);
        width: var(--sidebar-width);
    }
    
    .logo h2,
    .profile-info,
    .sidebar-nav a span,
    .sidebar-heading {
        opacity: 1;
        visibility: visible;
    }
    
    .main-content {
        margin-left: 0;
        width: 100%;
    }
    
    .dashboard-sidebar.mobile-open {
        transform: translateX(0);
    }
    
    .sidebar-overlay {
        display: none;
        position: fixed;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        background-color: rgba(0, 0, 0, 0.5);
        z-index: 999;
    }
    
    .dashboard-sidebar.mobile-open ~ .sidebar-overlay {
        display: block;
    }
    }

    /* Table Styling Improvements */
    .table {
    margin-bottom: 1.5rem;
    background-color: #fff;
    border-radius: var(--card-border-radius);
    box-shadow: var(--box-shadow);
    overflow: hidden;
    
    }

    .table th {
    font-weight: 600;
    vertical-align: middle;
    background-color: var(--dark-color);
    color: #fff;
    border-color: #32383e;
    }

    .table td {
    vertical-align: middle;
    }

    .table-bordered {
    border: none;
    }

    .table-bordered th,
    .table-bordered td {
    border-color: #edf2f7;
    }

    /* Badge styling */
    .badge {
    padding: 0.5em 0.75em;
    font-weight: 500;
    border-radius: 30px;
    }

    /* Alert Styling */
    .alert {
    margin-bottom: 1.5rem;
    border-radius: var(--card-border-radius);
    border: none;
    box-shadow: 0 2px 10px rgba(0, 0, 0, 0.05);
    }

    /* Button Styles */
    .btn-sm {
    padding: 0.25rem 0.75rem;
    font-size: 0.875rem;
    border-radius: 30px;
    font-weight: 500;
    transition: all 0.3s;
    }

    .btn-success {
    background-color: var(--success-color);
    border-color: var(--success-color);
    }

    .btn-success:hover {
    background-color: var(--success-color);
    opacity: 0.9;
    transform: translateY(-2px);
    box-shadow: 0 5px 15px rgba(76, 201, 240, 0.3);
    }
</style>
@section('content')
<div class="dashboard-wrapper">
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
                <a href="{{ route('admin.dashboard') }}" class="sidebar-menu-item">
                    <i class="fas fa-tachometer-alt"></i>
                    <span>Dashboard</span>
                </a>
        
                <div class="sidebar-divider"></div>
        
                <div class="sidebar-heading">Car Owner</div>
        
                <a href="{{ route('car-admin.new-registration-cars') }}" class="sidebar-menu-item">
                    <i class="fas fa-car"></i>
                    <span>Car Registration</span>
                </a>
                <a href="{{ route('car-admin.inspection-requests') }}" class="sidebar-menu-item active">
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
                <a href="{{ url('admin/booked-car') }}" class="sidebar-menu-item">
                    <i class="fas fa-calendar-check"></i>
                    <span>Booked Cars</span>
                </a>
        
                <a href="#" class="sidebar-menu-item" onclick="document.getElementById('logout-form').submit();">
                    <i class="fas fa-sign-out-alt"></i>
                    <span>Logout</span>
                </a>
                <form method="POST" action="{{ route('admin.logout') }}" id="logout-form">
                    @csrf
                </form>
            </ul>
        </nav>        
    </div>
    
    <div class="sidebar-overlay"></div>
    
    <div class="main-content">
        <div class="container-fluid">
            <h2 class="mb-4 text-center">Rescheduled Inspection Requests</h2>

            @if(session('success'))
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    {{ session('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif

            @if($inspectionRequests->count() > 0)
                <div class="table-responsive">
                    <table class="table table-bordered align-middle text-center">
                        <thead class="table-dark">
                            <tr>
                                <th>Sl. No</th>
                                <th>Car</th>
                                <th>Reg. No.</th>
                                <th>Owner Email</th>
                                <th>Date</th>
                                <th>Time</th>
                                <th>Location</th>
                                <th>Response</th>
                                <th>Status</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($inspectionRequests as $request)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>{{ $request->car->maker ?? 'N/A' }} {{ $request->car->model ?? '' }}</td>
                                    <td>{{ $request->car->registration_no ?? 'N/A' }}</td>
                                    <td>{{ $request->car->owner->email ?? 'N/A' }}</td>
                                    <td>{{ $request->inspection_date }}</td>
                                    <td>{{ $request->inspection_time }}</td>
                                    <td>{{ $request->location }}</td>
                                    <td>
                                        @if($request->request_accepted)
                                            <span class="badge bg-success">Accepted</span>
                                        @elseif($request->status === 'canceled')
                                            <span class="badge bg-danger">Cancelled</span>
                                        @elseif($request->request_new_date_sent)
                                            <span class="badge bg-warning text-dark">Requested New Date</span>
                                        @else
                                            <span class="badge bg-secondary">Pending</span>
                                        @endif
                                    </td>                           
                                    <td>
                                        <span class="badge bg-{{ $request->status === 'canceled' ? 'danger' : 'primary' }}">
                                            {{ ucfirst($request->status) }}
                                        </span>
                                    </td>
                                    <td>
                                        @if($request->status !== 'canceled')
                                            @if(!$request->is_confirmed_by_admin)
                                                <form action="{{ route('car-admin.inspection.confirm', $request->id) }}" method="POST" class="d-inline" onsubmit="return disableButton(this)">
                                                    @csrf
                                                    <button type="submit" class="btn btn-success btn-sm" id="btn-{{ $request->id }}">
                                                        <i class="bi bi-check-circle"></i> Confirm
                                                    </button>
                                                </form>
                                            @else
                                                <button class="btn btn-secondary btn-sm" disabled>
                                                    <i class="bi bi-check2-circle"></i> Done
                                                </button>
                                            @endif
                                        @endif
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @else
                <div class="alert alert-info text-center">No inspection responses found from car owners.</div>
            @endif
        </div>
    </div>
</div>

<link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
<link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">
<link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" rel="stylesheet">

<script>
    document.addEventListener('DOMContentLoaded', function () {
        const sidebarToggle = document.getElementById('sidebar-toggle');
        const sidebar = document.querySelector('.dashboard-sidebar');
        const sidebarOverlay = document.querySelector('.sidebar-overlay');
        
        // Toggle sidebar on button click
        sidebarToggle.addEventListener('click', function () {
            const isMobile = window.innerWidth < 992;
            
            if (isMobile) {
                sidebar.classList.toggle('mobile-open');
            } else {
                sidebar.classList.toggle('collapsed');
            }
        });
        
        // Close sidebar when clicking overlay on mobile
        sidebarOverlay.addEventListener('click', function () {
            sidebar.classList.remove('mobile-open');
        });
        
        // Handle window resize events
        window.addEventListener('resize', function () {
            if (window.innerWidth >= 992) {
                sidebar.classList.remove('mobile-open');
            }
        });
    });
    
    function disableButton(form) {
        const btn = form.querySelector('button');
        btn.disabled = true;
        const originalText = btn.innerHTML;
        btn.innerHTML = '<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span> Sending...';

        setTimeout(() => {
            btn.innerHTML = '<i class="bi bi-check2-circle"></i> Done';
            btn.classList.remove('btn-success');
            btn.classList.add('btn-secondary');
        }, 1000);
        return true;
    }
</script>
@endsection