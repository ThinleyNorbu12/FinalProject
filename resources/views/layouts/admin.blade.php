<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- ADD: CSRF Token Meta Tag -->
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Admin Dashboard') - Car Rental System</title>
    
    <!-- ADD: Bootstrap CSS (consistent version) -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    
    <!-- CSS Dependencies -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">
    
    <!-- Custom Admin CSS -->
    <link rel="stylesheet" href="{{ asset('assets/css/admin/adminsidebar.css') }}">
    
    <!-- ADD: Custom CSS from main app -->
    <link rel="stylesheet" href="{{ asset('assets/css/styles.css') }}">
    
    <!-- ADD: Head section for additional CSS -->
    @yield('head')
    
    <!-- Additional CSS -->
    @stack('styles')
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
                <span>Car Rental System</span>
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

            @if(Auth::guard('admin')->check())
                <div class="header-profile dropdown">
                    <a class="nav-link dropdown-toggle d-flex align-items-center" href="#" role="button" id="userDropdown"
                       data-bs-toggle="dropdown" aria-expanded="false">
                        <img src="{{ asset('assets/images/thinley.jpg') }}" alt="Admin Avatar"
                             class="rounded-circle me-2" width="32" height="32">
                        <div class="header-profile-info d-none d-sm-block">
                            <h4 class="mb-0">{{ Auth::guard('admin')->user()->name }}</h4>
                            <span>Administrator</span>
                        </div>
                    </a>
                    
                    <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="userDropdown">
                        <li>
                            <a class="dropdown-item" href="{{ route('admin.profile') }}">
                                <i class="fas fa-user me-2"></i> Profile
                            </a>
                        </li>
                        <li><hr class="dropdown-divider"></li>
                        <li>
                            <a class="dropdown-item" href="#"
                               onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                                <i class="fas fa-sign-out-alt me-2"></i> Logout
                            </a>
                            <form id="logout-form" action="{{ route('admin.logout') }}" method="POST" class="d-none">
                                @csrf
                            </form>
                        </li>
                    </ul>
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
                <a href="{{ route('admin.dashboard') }}" class="sidebar-menu-item {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
                    <i class="fas fa-tachometer-alt"></i>
                    <span>Dashboard</span>
                </a>
                
                <div class="sidebar-divider"></div>
                <div class="sidebar-heading">Manage Service</div>
                
                <!-- Updated Cars link with better condition -->
                <a href="{{ route('admin.cars.index') }}" class="sidebar-menu-item {{ request()->routeIs('admin.cars.index') || request()->routeIs('admin.cars.create') || request()->routeIs('admin.cars.edit') || request()->routeIs('admin.cars.show') ? 'active' : '' }}">
                    <i class="fas fa-car"></i>
                    <span>Cars</span>
                    <div class="tooltip">Cars</div>
                </a>

                <div class="sidebar-divider"></div>
                <div class="sidebar-heading">Car Owner</div>

                <a href="{{ route('car-admin.new-registration-cars') }}" class="sidebar-menu-item {{ request()->routeIs('car-admin.new-registration-cars') ? 'active' : '' }}">
                    <i class="fas fa-car"></i>
                    <span>Car Registration</span>
                    <div class="tooltip">Car Registration</div>
                </a>

                <a href="{{ route('car-admin.inspection-requests') }}" class="sidebar-menu-item {{ request()->routeIs('car-admin.inspection-requests') ? 'active' : '' }}">
                    <i class="fas fa-clipboard-check"></i>
                    <span>Inspection Requests</span>
                    <div class="tooltip">Inspection Requests</div>
                </a>

                <a href="{{ route('car-admin.approve-inspected-cars') }}" class="sidebar-menu-item {{ request()->routeIs('car-admin.approve-inspected-cars') ? 'active' : '' }}">
                    <i class="fas fa-check-circle"></i>
                    <span>Approve Inspections</span>
                    <div class="tooltip">Approve Inspections</div>
                </a>

                <div class="sidebar-divider"></div>
                <div class="sidebar-heading">Customer</div>

                <a href="{{ route('admin.verify-users') }}" class="sidebar-menu-item {{ request()->routeIs('admin.verify-users') ? 'active' : '' }}">
                    <i class="fas fa-id-card"></i>
                    <span>Verify Users</span>
                    <div class="tooltip">Verify Users</div>
                </a>

                <a href="{{ route('admin.payments.index') }}" class="sidebar-menu-item {{ request()->routeIs('admin.payments.index') ? 'active' : '' }}">
                    <i class="fas fa-credit-card"></i>
                    <span>Payments</span>
                    <div class="tooltip">Payments</div>
                </a>

                <!-- <a href="#" class="sidebar-menu-item">
                    <i class="fas fa-edit"></i>
                    <span>Update Registration</span>
                    <div class="tooltip">Update Registration</div>
                </a> -->

                <a href="{{ route('admin.booked-car') }}" class="sidebar-menu-item {{ request()->routeIs('admin.booked-car') ? 'active' : '' }}">
                    <i class="fas fa-calendar-check"></i>
                    <span>Booked Cars</span>
                    <div class="tooltip">Booked Cars</div>
                </a>

                <a href="{{ route('admin.reports.index') }}" class="sidebar-menu-item {{ request()->routeIs('admin.reports.index') ? 'active' : '' }}">
                    <i class="fas fa-chart-bar"></i>
                    <span>Report</span>
                    <div class="tooltip">Report</div>
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

                <a href="#" class="sidebar-menu-item" onclick="document.getElementById('sidebar-logout-form').submit();">
                    <i class="fas fa-sign-out-alt"></i>
                    <span>Logout</span>
                    <div class="tooltip">Logout</div>
                </a>

                <form method="POST" action="{{ route('admin.logout') }}" id="sidebar-logout-form" style="display: none;">
                    @csrf
                </form>
            </div>
        </div>

        <div class="dashboard-content" id="dashboardContent">
            <!-- Breadcrumb Navigation -->
            @if(!empty($breadcrumbs) || View::hasSection('breadcrumbs'))
                <nav class="page-breadcrumb">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item">
                            <i class="fas fa-home"></i>
                            <a href="{{ route('admin.dashboard') }}">Home</a>
                        </li>
                        @if(View::hasSection('breadcrumbs'))
                            @yield('breadcrumbs')
                        @else
                            @if(isset($breadcrumbs))
                                @foreach($breadcrumbs as $breadcrumb)
                                    @if($loop->last)
                                        <li class="breadcrumb-item active">{{ $breadcrumb['title'] }}</li>
                                    @else
                                        <li class="breadcrumb-item">
                                            <a href="{{ $breadcrumb['url'] }}">{{ $breadcrumb['title'] }}</a>
                                        </li>
                                    @endif
                                @endforeach
                            @endif
                        @endif
                    </ol>
                </nav>
            @endif

            <!-- Page Header -->
            @if(View::hasSection('page-header'))
                <div class="page-header">
                    @yield('page-header')
                </div>
            @endif

            <!-- Flash Messages -->
            @if(session('success'))
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    <i class="fas fa-check-circle me-2"></i>
                    {{ session('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif

            @if(session('error'))
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    <i class="fas fa-exclamation-circle me-2"></i>
                    {{ session('error') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif

            @if(session('warning'))
                <div class="alert alert-warning alert-dismissible fade show" role="alert">
                    <i class="fas fa-exclamation-triangle me-2"></i>
                    {{ session('warning') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif

            @if(session('info'))
                <div class="alert alert-info alert-dismissible fade show" role="alert">
                    <i class="fas fa-info-circle me-2"></i>
                    {{ session('info') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif

            <!-- Main Content Area -->
            <div class="main-content">
                @yield('content')
            </div>
        </div>
    </div>

    <!-- JavaScript Dependencies -->
    <!-- ADD: Consistent Bootstrap version -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    
    <!-- ADD: jQuery (if needed for AJAX) -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    
    <!-- ADD: AJAX setup for CSRF token -->
    <script>
        // Only setup AJAX if jQuery is available
        if (typeof $ !== 'undefined') {
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
        }
    </script>
    
    <script src="{{ asset('assets/js/admin-dashboard.js') }}"></script>
    
    <!-- ADD: Page Specific Scripts section -->
    @yield('scripts')
    
    <!-- Additional JavaScript -->
    @stack('scripts')
</body>
</html>