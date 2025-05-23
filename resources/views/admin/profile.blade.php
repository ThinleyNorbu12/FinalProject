@extends('layouts.app')

@section('content')

<!-- Fonts and Icons -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
<link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
<link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">
<link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" rel="stylesheet">

<!-- Custom CSS -->
<link rel="stylesheet" href="{{ asset('assets/css/admin/adminsidebar.css') }}">
<link rel="stylesheet" href="{{ asset('assets/css/admin/darkmode.css') }}">
<link rel="stylesheet" href="{{ asset('assets/css/admin/profile.css') }}">
 <script src="{{ asset('assets/js/admin-dashboard.js') }}"></script>
<!-- Admin Header -->
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
                <a class="nav-link dropdown-toggle d-flex align-items-center" href="#" role="button"
                   id="userDropdown" data-bs-toggle="dropdown" aria-expanded="false">
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
                        <a class="dropdown-item" href="#" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
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

<!-- Admin Dashboard -->
<div class="admin-dashboard" id="adminDashboard">
    <!-- Sidebar Overlay -->
    <div class="sidebar-overlay" id="sidebarOverlay"></div>

    <!-- Sidebar -->
    <div class="dashboard-sidebar" id="dashboardSidebar">
        <div class="sidebar-header">
            {{-- Reserved for future toggle --}}
        </div>

        @if(Auth::guard('admin')->check())
            <div class="admin-profile">
                <div class="profile-avatar">
                    <img src="{{ asset('assets/images/thinley.jpg') }}" alt="Admin Avatar">
                </div>
                <div class="profile-info">
                    <h3>{{ Auth::guard('admin')->user()->name }}</h3>
                    <span>Administrator</span>
                </div>
            </div>
        @endif

        <div class="sidebar-menu">
            <a href="{{ route('admin.dashboard') }}" class="sidebar-menu-item">
                <i class="fas fa-tachometer-alt"></i>
                <span>Dashboard</span>
            </a>

            <div class="sidebar-divider"></div>
            <div class="sidebar-heading">Manage Service</div>

            <a href="{{ route('cars.index') }}" class="sidebar-menu-item">
                <i class="fas fa-car"></i>
                <span>Cars</span>
                <div class="tooltip">Cars</div>
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
</div>

<!-- Main Content -->
<div class="main-content">
    <div class="container-fluid">
        <!-- Page Header -->
        <div class="row">
            <div class="col-12">
                <div class="page-header">
                    <div class="page-header-content">
                        <h1 class="page-title">Profile Settings</h1>
                        <nav aria-label="breadcrumb">
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item">
                                    <a href="{{ route('admin.dashboard') }}">
                                        <i class="fas fa-home me-1"></i>Dashboard
                                    </a>
                                </li>
                                <li class="breadcrumb-item active" aria-current="page">Profile</li>
                            </ol>
                        </nav>
                    </div>
                </div>
            </div>
        </div>

        <!-- Profile Content -->
        <div class="row g-4">
            <!-- Profile Picture Section -->
            <div class="col-lg-4 col-md-12">
                <div class="profile-card">
                    <div class="profile-card-body">
                        <div class="profile-picture-section">
                            <div class="profile-picture-container">
                                <img src="{{ asset('assets/images/thinley.jpg') }}" 
                                     alt="Profile Picture" 
                                     class="profile-picture" 
                                     id="profileImage">
                                <div class="profile-picture-overlay" onclick="document.getElementById('profilePictureInput').click()">
                                    <i class="fas fa-camera"></i>
                                </div>
                            </div>
                            
                            <!-- Profile Picture Upload Form -->
                            <form id="profilePictureForm" action="{{ route('admin.profile.picture') }}" method="POST" enctype="multipart/form-data" class="d-none">
                                @csrf
                                <input type="file" id="profilePictureInput" name="profile_picture" accept="image/*">
                            </form>
                            
                            <div class="profile-basic-info">
                                <h4 class="profile-name">{{ Auth::guard('admin')->user()->name }}</h4>
                                <p class="profile-role">Administrator</p>
                                <p class="profile-member-since">Member since {{ Auth::guard('admin')->user()->created_at->format('M Y') }}</p>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Account Info Card -->
                <div class="profile-card account-info-card">
                    <div class="profile-card-header">
                        <h5 class="card-title">
                            <i class="fas fa-info-circle me-2"></i>Account Information
                        </h5>
                    </div>
                    <div class="profile-card-body">
                        <div class="info-item">
                            <label class="info-label">Account ID</label>
                            <p class="info-value">#{{ Auth::guard('admin')->user()->id }}</p>
                        </div>
                        <div class="info-item">
                            <label class="info-label">Role</label>
                            <p class="info-value">
                                <span class="badge badge-admin">Administrator</span>
                            </p>
                        </div>
                        <div class="info-item">
                            <label class="info-label">Last Updated</label>
                            <p class="info-value">{{ Auth::guard('admin')->user()->updated_at->format('M d, Y') }}</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Profile Information Section -->
            <div class="col-lg-8 col-md-12">
                <!-- Profile Update Form -->
                <div class="profile-card">
                    <div class="profile-card-header">
                        <h5 class="card-title">
                            <i class="fas fa-user-edit me-2"></i>Profile Information
                        </h5>
                    </div>
                    <div class="profile-card-body">
                        @if(session('success'))
                            <div class="alert alert-success alert-dismissible fade show" role="alert">
                                <i class="fas fa-check-circle me-2"></i>
                                {{ session('success') }}
                                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                            </div>
                        @endif

                        @if($errors->any())
                            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                                <i class="fas fa-exclamation-triangle me-2"></i>
                                <ul class="mb-0">
                                    @foreach($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                            </div>
                        @endif

                        <form action="{{ route('admin.profile.update') }}" method="POST" id="profileUpdateForm" class="profile-form">
                            @csrf
                            @method('PUT')

                            <div class="form-group">
                                <label for="name" class="form-label">
                                    <i class="fas fa-user me-1"></i>Full Name
                                </label>
                                <input type="text" 
                                       class="form-control @error('name') is-invalid @enderror" 
                                       id="name" 
                                       name="name" 
                                       value="{{ old('name', Auth::guard('admin')->user()->name) }}" 
                                       required>
                                @error('name')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="form-group">
                                <label for="email" class="form-label">
                                    <i class="fas fa-envelope me-1"></i>Email Address
                                </label>
                                <input type="email" 
                                       class="form-control @error('email') is-invalid @enderror" 
                                       id="email" 
                                       name="email" 
                                       value="{{ old('email', Auth::guard('admin')->user()->email) }}" 
                                       required>
                                @error('email')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="form-actions">
                                <button type="submit" class="btn btn-primary" id="updateProfileBtn">
                                    <i class="fas fa-save me-1"></i> Update Profile
                                </button>
                                <a href="{{ route('admin.dashboard') }}" class="btn btn-secondary">
                                    <i class="fas fa-arrow-left me-1"></i> Back to Dashboard
                                </a>
                            </div>
                        </form>
                    </div>
                </div>

                <!-- Change Password Section -->
                <div class="profile-card password-card">
                    <div class="profile-card-header">
                        <h5 class="card-title">
                            <i class="fas fa-lock me-2"></i>Change Password
                        </h5>
                    </div>
                    <div class="profile-card-body">
                        <form action="{{ route('admin.password.update') }}" method="POST" id="passwordUpdateForm" class="profile-form">
                            @csrf
                            @method('PUT')

                            <div class="form-group">
                                <label for="current_password" class="form-label">
                                    <i class="fas fa-key me-1"></i>Current Password
                                </label>
                                <div class="password-input-group">
                                    <input type="password" 
                                           class="form-control @error('current_password') is-invalid @enderror" 
                                           id="current_password" 
                                           name="current_password" 
                                           required>
                                    <button class="password-toggle-btn" type="button" onclick="togglePassword('current_password')">
                                        <i class="fas fa-eye" id="current_password_icon"></i>
                                    </button>
                                </div>
                                @error('current_password')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="row g-3">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="new_password" class="form-label">
                                            <i class="fas fa-lock me-1"></i>New Password
                                        </label>
                                        <div class="password-input-group">
                                            <input type="password" 
                                                   class="form-control @error('new_password') is-invalid @enderror" 
                                                   id="new_password" 
                                                   name="new_password" 
                                                   required 
                                                   minlength="8">
                                            <button class="password-toggle-btn" type="button" onclick="togglePassword('new_password')">
                                                <i class="fas fa-eye" id="new_password_icon"></i>
                                            </button>
                                        </div>
                                        @error('new_password')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                        <small class="form-text">Password must be at least 8 characters long</small>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="new_password_confirmation" class="form-label">
                                            <i class="fas fa-check-circle me-1"></i>Confirm New Password
                                        </label>
                                        <div class="password-input-group">
                                            <input type="password" 
                                                   class="form-control" 
                                                   id="new_password_confirmation" 
                                                   name="new_password_confirmation" 
                                                   required>
                                            <button class="password-toggle-btn" type="button" onclick="togglePassword('new_password_confirmation')">
                                                <i class="fas fa-eye" id="new_password_confirmation_icon"></i>
                                            </button>
                                        </div>
                                        <small class="form-text" id="password_match_message"></small>
                                    </div>
                                </div>
                            </div>

                            <div class="form-actions">
                                <button type="submit" class="btn btn-warning" id="changePasswordBtn">
                                    <i class="fas fa-key me-1"></i> Change Password
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Footer -->
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

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Profile picture upload handling
    const profilePictureInput = document.getElementById('profilePictureInput');
    const profileImage = document.getElementById('profileImage');
    const profilePictureForm = document.getElementById('profilePictureForm');

    profilePictureInput.addEventListener('change', function(e) {
        const file = e.target.files[0];
        if (file) {
            // Validate file type
            if (!file.type.match('image.*')) {
                alert('Please select a valid image file.');
                return;
            }
            
            // Validate file size (2MB limit)
            if (file.size > 2 * 1024 * 1024) {
                alert('File size must be less than 2MB.');
                return;
            }
            
            const reader = new FileReader();
            reader.onload = function(e) {
                profileImage.src = e.target.result;
                // Auto-submit the form
                profilePictureForm.submit();
            };
            reader.readAsDataURL(file);
        }
    });

    // Password visibility toggle
    window.togglePassword = function(fieldId) {
        const field = document.getElementById(fieldId);
        const icon = document.getElementById(fieldId + '_icon');
        
        if (field.type === 'password') {
            field.type = 'text';
            icon.className = 'fas fa-eye-slash';
        } else {
            field.type = 'password';
            icon.className = 'fas fa-eye';
        }
    };

    // Password confirmation validation
    const newPassword = document.getElementById('new_password');
    const confirmPassword = document.getElementById('new_password_confirmation');
    const passwordMessage = document.getElementById('password_match_message');

    function validatePasswords() {
        if (confirmPassword.value === '') {
            passwordMessage.textContent = '';
            passwordMessage.className = 'form-text text-muted';
            return;
        }
        
        if (newPassword.value === confirmPassword.value) {
            passwordMessage.textContent = 'Passwords match ✓';
            passwordMessage.className = 'form-text text-success';
            confirmPassword.classList.remove('is-invalid');
            confirmPassword.classList.add('is-valid');
        } else {
            passwordMessage.textContent = 'Passwords do not match';
            passwordMessage.className = 'form-text text-danger';
            confirmPassword.classList.remove('is-valid');
            confirmPassword.classList.add('is-invalid');
        }
    }

    newPassword.addEventListener('input', validatePasswords);
    confirmPassword.addEventListener('input', validatePasswords);

    // Form submission loading states
    document.getElementById('profileUpdateForm').addEventListener('submit', function() {
        const btn = document.getElementById('updateProfileBtn');
        btn.innerHTML = '<i class="fas fa-spinner fa-spin me-1"></i> Updating...';
        btn.disabled = true;
    });

    document.getElementById('passwordUpdateForm').addEventListener('submit', function() {
        const btn = document.getElementById('changePasswordBtn');
        btn.innerHTML = '<i class="fas fa-spinner fa-spin me-1"></i> Changing...';
        btn.disabled = true;
    });

    // Auto-hide alerts after 5 seconds
    const alerts = document.querySelectorAll('.alert');
    alerts.forEach(function(alert) {
        setTimeout(function() {
            if (bootstrap && bootstrap.Alert) {
                const bsAlert = new bootstrap.Alert(alert);
                bsAlert.close();
            }
        }, 5000);
    });
});
</script>

@endsection