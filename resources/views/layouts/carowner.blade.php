<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Car Owner Dashboard') - Car Rental System</title>

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- CSS Dependencies -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">

    <!-- Custom CSS -->
    <link rel="stylesheet" href="{{ asset('assets/css/carowner/carownersidebar.css') }}">

    @yield('head')
    @stack('styles')
</head>
<body>
<header class="admin-header" id="adminHeader">
    <div class="header-left">
        <button class="mobile-menu-toggle d-md-none" id="mobileMenuToggle">
            <i class="fas fa-bars"></i>
        </button>
         <a href="{{ route('carowner.dashboard') }}" class="header-brand d-none d-md-flex">
            <img src="{{ asset('assets/images/logo1.png') }}" alt="Logo" style="height: 70px !important;">
            <span style="font-size: 1.5rem !important; font-weight: 700 !important;">CAR RENTAL SYSTEM</span>
        </a>
    </div>

    <div class="header-actions">

        @if(Auth::guard('carowner')->check())
            <div class="header-profile dropdown">
                <a class="nav-link dropdown-toggle d-flex align-items-center" href="#" role="button" id="userDropdown"
                   data-bs-toggle="dropdown" aria-expanded="false">
                    <img src="{{ asset('assets/images/thinley.jpg') }}" alt="Avatar"
                         class="rounded-circle me-2" width="32" height="32">
                    <div class="header-profile-info d-none d-sm-block">
                        <h4 class="mb-0">{{ Auth::guard('carowner')->user()->name }}!</h4>
                        <span>Car Owner</span>
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
                        <a class="dropdown-item" href="#" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                            <i class="fas fa-sign-out-alt me-2"></i> Logout
                        </a>
                        <form id="logout-form" action="{{ route('carowner.logout') }}" method="POST" class="d-none">@csrf</form>
                    </li>
                </ul>
            </div>
        @else
            <a href="{{ route('carowner.login') }}" class="btn btn-primary">Login</a>
        @endif
    </div>
</header>

<div class="admin-dashboard" id="adminDashboard">
    <div class="sidebar-overlay" id="sidebarOverlay"></div>

    <div class="dashboard-sidebar" id="dashboardSidebar">
        <div class="sidebar-header"></div>

        <div class="admin-profile">
            @if(Auth::guard('carowner')->check())
                <div class="profile-avatar">
                    <img src="{{ asset('assets/images/thinley.jpg') }}" alt="Avatar">
                </div>
                <div class="profile-info">
                    <h3>{{ Auth::guard('carowner')->user()->name }}</h3>
                    <span>Car Owner</span>
                </div>
            @endif
        </div>

        <div class="sidebar-menu">
            <a href="{{ route('carowner.dashboard') }}" class="sidebar-menu-item {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
                <i class="fas fa-tachometer-alt"></i>
                <span>Dashboard</span>
            </a>

            <!-- <div class="sidebar-divider"></div>
            <div class="sidebar-heading">Manage Service</div> -->
            <div class="sidebar-divider"></div>
            <div class="sidebar-heading">Car Owner</div>

            <a href="{{ route('carowner.rentCar') }}">
                <i class="fas fa-car"></i>
                <span>Rent a Car</span>
                <div class="tooltip">Rent a Car</div>
            </a>

            
            <a href="{{ route('carowner.car-inspection') }}">
                <i class="fas fa-search"></i>
                <span>Inspection Requests</span>
            </a>
            <a href="{{ route('carowner.approved') }}">
                <i class="fas fa-check-circle"></i>
                <span>Approved Cars</span>
            </a>
            <a href="{{ route('carowner.rejected') }}">
                <i class="fas fa-times-circle"></i>
                <span>Rejected Cars</span>
            </a>

            <!-- <a href="{{ route('admin.payments.index') }}" class="sidebar-menu-item {{ request()->routeIs('admin.payments.index') ? 'active' : '' }}">
                <i class="fas fa-credit-card"></i>
                <span>Payments</span>
            </a> -->

            <!-- <button class="dark-mode-toggle" id="darkModeToggle">
                <div class="toggle-text">
                    <i class="fas fa-moon"></i>
                    <span>Dark Mode</span>
                </div>
                <div class="toggle-switch" id="toggleSwitch">
                    <div class="toggle-slider"></div>
                </div>
            </button> -->

            <a href="#" class="sidebar-menu-item" onclick="document.getElementById('sidebar-logout-form').submit();">
                <i class="fas fa-sign-out-alt"></i>
                <span>Logout</span>
            </a>
            <form method="POST" action="{{ route('carowner.logout') }}" id="sidebar-logout-form" class="d-none">@csrf</form>
        </div>
    </div>

    <div class="dashboard-content" id="dashboardContent">
        @if(!empty($breadcrumbs) || View::hasSection('breadcrumbs'))
            <nav class="page-breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item">
                        <i class="fas fa-home"></i>
                        <a href="{{ route('carowner.dashboard') }}">Home</a>
                    </li>
                    @if(View::hasSection('breadcrumbs'))
                        @yield('breadcrumbs')
                    @elseif(isset($breadcrumbs))
                        @foreach($breadcrumbs as $breadcrumb)
                            <li class="breadcrumb-item{{ $loop->last ? ' active' : '' }}">
                                @if(!$loop->last)
                                    <a href="{{ $breadcrumb['url'] }}">{{ $breadcrumb['title'] }}</a>
                                @else
                                    {{ $breadcrumb['title'] }}
                                @endif
                            </li>
                        @endforeach
                    @endif
                </ol>
            </nav>
        @endif

        @if(View::hasSection('page-header'))
            <div class="page-header">@yield('page-header')</div>
        @endif

        @foreach(['success', 'error', 'warning', 'info'] as $msg)
            @if(session($msg))
                <div class="alert alert-{{ $msg }} alert-dismissible fade show" role="alert">
                    <i class="fas fa-{{ $msg == 'success' ? 'check-circle' : ($msg == 'error' ? 'exclamation-circle' : ($msg == 'warning' ? 'exclamation-triangle' : 'info-circle')) }} me-2"></i>
                    {{ session($msg) }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif
        @endforeach

        <div class="main-content">
            @yield('content')
        </div>
    </div>
</div>

<!-- JavaScript Dependencies -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

<script>
    // CSRF Token setup for AJAX
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    // Sidebar toggle for mobile
    $('#mobileMenuToggle').on('click', function () {
        $('#dashboardSidebar').toggleClass('open');
        $('#sidebarOverlay').toggleClass('active');
    });

    $('#sidebarOverlay').on('click', function () {
        $('#dashboardSidebar').removeClass('open');
        $(this).removeClass('active');
    });

    // Dark mode toggle (basic version)
    $('#darkModeToggle').on('click', function () {
        $('body').toggleClass('dark-mode');
    });
</script>

@yield('scripts')
@stack('scripts')
</body>
</html>
