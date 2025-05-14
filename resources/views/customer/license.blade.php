@extends('layouts.app')

@section('content')
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Driving License - Car Rental</title>
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
            transition: transform 0.3s ease, width 0.3s ease;
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
            flex: 1;
            padding: 20px;
            margin-left: 240px; /* Width of sidebar */
            margin-top: 56px; /* Height of header */
            width: calc(100% - 240px);
            transition: margin-left 0.3s ease, width 0.3s ease;
        }

        /* Welcome Card */
        .welcome-card {
            background-color: white;
            border-radius: 8px;
            padding: 24px;
            margin-bottom: 20px;
            box-shadow: 0 1px 3px rgba(0, 0, 0, 0.1);
        }

        .welcome-card h2 {
            margin-top: 0;
            color: #333;
            font-weight: 700;
        }

        .welcome-card p {
            color: #666;
            margin-bottom: 0;
        }

        /* License Container */
        .license-container {
            background-color: white;
            border-radius: 8px;
            padding: 20px;
            box-shadow: 0 1px 3px rgba(0, 0, 0, 0.1);
        }

        .license-container.no-license {
            display: flex;
            flex-direction: column;
            align-items: center;
            padding: 60px 20px;
            text-align: center;
        }

        .license-container.no-license i {
            font-size: 64px;
            color: #ccc;
            margin-bottom: 20px;
        }

        .license-container.no-license h3 {
            margin-bottom: 16px;
            color: #333;
        }

        .license-container.no-license p {
            max-width: 500px;
            margin-bottom: 24px;
            color: #666;
        }

        /* License Header */
        .license-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 20px;
            border-bottom: 1px solid #e5e5e5;
            padding-bottom: 15px;
        }

        .license-title h2 {
            margin: 0 0 5px 0;
            font-size: 22px;
            color: #333;
        }

        .license-title p {
            margin: 0;
            color: #666;
            font-size: 14px;
        }

        .license-status {
            display: inline-flex;
            align-items: center;
            padding: 6px 12px;
            border-radius: 20px;
            font-weight: 500;
            font-size: 14px;
        }

        .status-valid {
            background-color: #e6f7eb;
            color: #28a745;
        }

        .status-expiring {
            background-color: #fff3cd;
            color: #ffc107;
        }

        .status-expired {
            background-color: #ffebee;
            color: #dc3545;
        }

        /* License Info */
        .license-info {
            display: flex;
            flex-wrap: wrap;
            gap: 20px;
            margin-bottom: 20px;
        }

        .license-info > div {
            flex: 1;
            min-width: 250px;
        }

        .info-group {
            margin-bottom: 15px;
        }

        .info-label {
            font-size: 14px;
            color: #666;
            margin-bottom: 5px;
        }

        .info-value {
            font-size: 16px;
            color: #333;
            font-weight: 500;
        }

        /* License Status Section */
        .license-status-section {
            background-color: #f9f9f9;
            border-radius: 6px;
            padding: 15px;
            margin-bottom: 20px;
        }

        /* License Validity */
        .validity-section {
            margin-bottom: 20px;
        }

        .validity-text {
            margin-bottom: 10px;
        }

        .validity-progress {
            margin-top: 10px;
        }

        .progress-bar {
            height: 8px;
            background-color: #eee;
            border-radius: 4px;
            overflow: hidden;
            margin-bottom: 8px;
        }

        .progress-fill {
            height: 100%;
            border-radius: 4px;
            transition: width 0.3s ease;
        }

        .progress-labels {
            display: flex;
            justify-content: space-between;
            font-size: 12px;
            color: #666;
        }

        /* License Images */
        .license-images {
            display: flex;
            flex-wrap: wrap;
            gap: 20px;
            margin-bottom: 20px;
        }

        .image-container {
            flex: 1;
            min-width: 250px;
        }

        .image-container h4 {
            margin-top: 0;
            margin-bottom: 10px;
            color: #333;
            font-size: 16px;
        }

        .license-image {
            width: 100%;
            border-radius: 6px;
            border: 1px solid #e5e5e5;
            object-fit: cover;
            max-height: 200px;
        }

        .no-image {
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            height: 200px;
            background-color: #f5f5f5;
            border-radius: 6px;
            border: 1px dashed #ccc;
            color: #999;
            text-align: center;
        }

        .no-image i {
            font-size: 40px;
            margin-bottom: 10px;
        }

        /* License Actions */
        .license-actions {
            display: flex;
            gap: 15px;
            margin-top: 30px;
        }

        .btn-primary {
            background-color: #3366ff;
            color: white;
            border: none;
            border-radius: 4px;
            padding: 10px 20px;
            font-size: 14px;
            cursor: pointer;
            text-decoration: none;
            display: inline-flex;
            align-items: center;
        }

        .btn-outline {
            background-color: transparent;
            color: #3366ff;
            border: 1px solid #3366ff;
            border-radius: 4px;
            padding: 10px 20px;
            font-size: 14px;
            cursor: pointer;
            text-decoration: none;
            display: inline-flex;
            align-items: center;
        }

        /* Responsive Adjustments */
        @media (max-width: 992px) {
            .sidebar {
                width: 70px;
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
            .license-info,
            .license-images {
                flex-direction: column;
            }
            
            .header-search {
                max-width: 300px;
            }
            
            .header-user-name {
                display: none;
            }
        }

        @media (max-width: 576px) {
            .sidebar {
                transform: translateX(-100%);
                width: 240px;
            }
            
            .sidebar.expanded {
                transform: translateX(0);
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
            
            .main-content {
                margin-left: 0;
                width: 100%;
            }
            
            .license-header {
                flex-direction: column;
                align-items: flex-start;
            }
            
            .license-status {
                margin-top: 10px;
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
            @if(Auth::guard('customer')->check())
                <span class="header-user-name">{{ Auth::guard('customer')->user()->name }}</span>
                <form method="POST" action="{{ route('customer.logout') }}" class="d-inline">
                    @csrf
                    <button type="submit" class="btn-logout">Logout</button>
                </form>
            @else
                <a href="{{ route('customer.login') }}" class="btn-logout">Login</a>
            @endif
        </div>        
    </header>

    <!-- Dashboard Container -->
    <div class="dashboard-container">
        <!-- Sidebar -->
        <div class="sidebar" id="sidebar">
            <div class="sidebar-menu">
                <a href="{{ route('customer.dashboard') }}" class="sidebar-menu-item">
                    <i class="fas fa-home"></i>
                    <span>Dashboard</span>
                </a>
                
                <a href="{{ route('customer.browse-cars') }}" class="sidebar-menu-item active">
                    <i class="fas fa-car"></i>
                    <span>Browse Cars</span>
                </a>
                
                <a href="#" class="sidebar-menu-item">
                    <i class="fas fa-calendar-alt"></i>
                    <span>My Reservations</span>
                </a>
                
                <div class="sidebar-divider"></div>
                
                <div class="sidebar-heading">My Account</div>
                
                <a href="{{ route('customer.profile') }}" class="sidebar-menu-item">
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

                <a href="{{ route('customer.paylater') }}" class="sidebar-menu-item">
                    <i class="fas fa-money-bill-wave"></i>
                    <span>Pay Later</span>
                </a>
                
                <a href="{{ route('customer.license') }}" class="sidebar-menu-item active">
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
                <h2>Your Driving License</h2>
                <p>View and manage your driving license details for car rentals</p>
            </div>
            
            @if($license)
                @php
                    $today = \Carbon\Carbon::today();
                    $expiry = \Carbon\Carbon::parse($license->expiry_date);
                    $days_remaining = $today->diffInDays($expiry, false);
                    
                    if($days_remaining < 0) {
                        $status_class = 'status-expired';
                        $status_text = 'Expired';
                    } elseif($days_remaining <= 30) {
                        $status_class = 'status-expiring';
                        $status_text = 'Expiring Soon';
                    } else {
                        $status_class = 'status-valid';
                        $status_text = 'Valid';
                    }
                    
                    // Debug image paths
                    $front_image_path = $license->license_front_image; // Remove 'licenses/' prefix
                    $back_image_path = $license->license_back_image;   // Remove 'licenses/' prefix
                    $front_exists = $license->license_front_image && file_exists(public_path('licenses/' . $front_image_path));
                    $back_exists = $license->license_back_image && file_exists(public_path('licenses/' . $back_image_path));
                @endphp
                
                <div class="license-header">
                    <div class="license-title">
                        <h2><i class="fas fa-id-card me-2"></i>Driving License Details</h2>
                        <p><i class="fas fa-hashtag me-1"></i>License #{{ $license->license_no }}</p>
                    </div>
                    <span class="license-status {{ $status_class }}">
                        @if($days_remaining < 0)
                            <i class="fas fa-times-circle me-1"></i>
                        @elseif($days_remaining <= 30)
                            <i class="fas fa-exclamation-triangle me-1"></i>
                        @else
                            <i class="fas fa-check-circle me-1"></i>
                        @endif
                        {{ $status_text }}
                    </span>
                </div>

                <div class="license-info">
                    <div>
                        <div class="info-group">
                            <div class="info-label"><i class="fas fa-user me-2"></i>Full Name</div>
                            <div class="info-value">{{ $customer->name }}</div>
                        </div>
                        
                        <div class="info-group">
                            <div class="info-label"><i class="fas fa-id-badge me-2"></i>CID Number</div>
                            <div class="info-value">{{ $customer->cid_no }}</div>
                        </div>
                        
                        <div class="info-group">
                            <div class="info-label"><i class="fas fa-birthday-cake me-2"></i>Date of Birth</div>
                            <div class="info-value">{{ \Carbon\Carbon::parse($customer->date_of_birth)->format('F d, Y') }}</div>
                        </div>
                        
                        <div class="info-group">
                            <div class="info-label"><i class="fas fa-venus-mars me-2"></i>Gender</div>
                            <div class="info-value">{{ $customer->gender ?? 'Not specified' }}</div>
                        </div>
                    </div>
                    
                    <div>
                        <div class="info-group">
                            <div class="info-label"><i class="fas fa-id-card me-2"></i>License Number</div>
                            <div class="info-value">{{ $license->license_no }}</div>
                        </div>
                        
                        <div class="info-group">
                            <div class="info-label"><i class="fas fa-map-marker-alt me-2"></i>Issuing Dzongkhag</div>
                            <div class="info-value">{{ $license->issuing_dzongkhag }}</div>
                        </div>
                        
                        <div class="info-group">
                            <div class="info-label"><i class="fas fa-calendar-plus me-2"></i>Issue Date</div>
                            <div class="info-value">{{ \Carbon\Carbon::parse($license->issue_date)->format('F d, Y') }}</div>
                        </div>
                        
                        <div class="info-group">
                            <div class="info-label"><i class="fas fa-calendar-times me-2"></i>Expiry Date</div>
                            <div class="info-value">{{ \Carbon\Carbon::parse($license->expiry_date)->format('F d, Y') }}</div>
                        </div>
                    </div>
                </div>

                <!-- License Status -->
                <div class="license-status-section">
                    <div class="info-group">
                        <div class="info-label"><i class="fas fa-check-square me-2"></i>License Status</div>
                        <div class="info-value">
                            @php
                                $statusBadgeClass = '';
                                $statusIcon = '';
                                
                                switch($license->status) {
                                    case 'active':
                                        $statusBadgeClass = 'badge bg-success';
                                        $statusIcon = 'fa-check-circle';
                                        break;
                                    case 'pending':
                                        $statusBadgeClass = 'badge bg-warning';
                                        $statusIcon = 'fa-clock';
                                        break;
                                    case 'rejected':
                                        $statusBadgeClass = 'badge bg-danger';
                                        $statusIcon = 'fa-times-circle';
                                        break;
                                    case 'expired':
                                        $statusBadgeClass = 'badge bg-danger';
                                        $statusIcon = 'fa-calendar-times';
                                        break;
                                    case 'suspended':
                                        $statusBadgeClass = 'badge bg-secondary';
                                        $statusIcon = 'fa-ban';
                                        break;
                                    default:
                                        $statusBadgeClass = 'badge bg-info';
                                        $statusIcon = 'fa-info-circle';
                                }
                            @endphp
                            
                            <span class="{{ $statusBadgeClass }}">
                                <i class="fas {{ $statusIcon }} me-1"></i>
                                {{ ucfirst($license->status) }}
                            </span>
                        </div>
                    </div>
                </div>

                <!-- Validity Progress Bar -->
                <div class="validity-section">
                    <div class="info-group">
                        <div class="info-label"><i class="fas fa-clock me-2"></i>License Validity</div>
                        <div class="info-value">
                            @php
                                // Calculate total validity period in days
                                $issue_date = \Carbon\Carbon::parse($license->issue_date);
                                $expiry_date = \Carbon\Carbon::parse($license->expiry_date);
                                $total_validity_days = $issue_date->diffInDays($expiry_date);
                                
                                // Calculate days used and remaining
                                $days_used = $issue_date->diffInDays($today);
                                $percentage_used = $total_validity_days > 0 ? min(100, max(0, ($days_used / $total_validity_days) * 100)) : 100;
                                $percentage_remaining = 100 - $percentage_used;
                            @endphp
                            
                            <div class="validity-text">
                                @if($days_remaining < 0)
                                    <span class="text-danger"><i class="fas fa-exclamation-circle me-1"></i>Expired {{ abs($days_remaining) }} days ago</span>
                                @elseif($days_remaining <= 30)
                                    <span class="text-warning"><i class="fas fa-exclamation-triangle me-1"></i>Expires in {{ $days_remaining }} days</span>
                                @else
                                    <span class="text-success"><i class="fas fa-check-circle me-1"></i>Valid for {{ $days_remaining }} days</span>
                                @endif
                            </div>
                            
                            <div class="validity-progress">
                                <div class="progress-bar">
                                    <div class="progress-fill 
                                        @if($days_remaining < 0) bg-danger
                                        @elseif($days_remaining <= 30) bg-warning
                                        @else bg-success
                                        @endif"
                                        style="width: {{ $percentage_used }}%">
                                    </div>
                                </div>
                                <div class="progress-labels">
                                    <span><i class="fas fa-calendar-check me-1"></i>Issued: {{ $issue_date->format('M d, Y') }}</span>
                                    <span><i class="fas fa-calendar-times me-1"></i>Expires: {{ $expiry_date->format('M d, Y') }}</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- License Images -->
                <div class="license-images">
                        <div class="image-container">
                            <h4><i class="fas fa-id-card"></i> License Front</h4>
                            @if(!empty($license->license_front_image))
                                <img src="{{ asset($license->license_front_image) }}" 
                                    alt="License Front" 
                                    class="license-image"
                                    onerror="this.onerror=null; this.parentNode.innerHTML='<div class=\'no-image\'><i class=\'fas fa-id-card\'></i><p>Front image not available</p></div>';">
                            @else
                                <div class="no-image">
                                    <i class="fas fa-id-card"></i>
                                    <p>Front image not available</p>
                                </div>
                            @endif
                        </div>
                        
                        <div class="image-container">
                            <h4><i class="fas fa-id-card-alt"></i>License Back</h4>
                            @if(!empty($license->license_back_image))
                                <img src="{{ asset($license->license_back_image) }}" 
                                    alt="License Back" 
                                    class="license-image"
                                    onerror="this.onerror=null; this.parentNode.innerHTML='<div class=\'no-image\'><i class=\'fas fa-id-card\'></i><p>Back image not available</p></div>';">
                            @else
                                <div class="no-image">
                                    <i class="fas fa-id-card"></i>
                                    <p>Back image not available</p>
                                </div>
                            @endif
                        </div>
                </div>
                {{-- <div class="license-images">
                    <div class="image-container">
                        <h4><i class="fas fa-id-card"></i> License Front</h4>
                        @if(!empty($license->license_front_image))
                            <img src="{{ asset('licenses/' . $license->license_front_image) }}" 
                                alt="License Front" 
                                class="license-image"
                                onerror="this.onerror=null; this.parentNode.innerHTML='<div class=\'no-image\'><i class=\'fas fa-id-card\'></i><p>Front image not available</p></div>';"
                            >
                        @else
                            <div class="no-image">
                                <i class="fas fa-id-card"></i>
                                <p>Front image not available</p>
                            </div>
                        @endif
                    </div>
                    
                    <div class="image-container">
                        <h4><i class="fas fa-id-card-alt"></i> License Back</h4>
                        @if(!empty($license->license_back_image))
                            <img src="{{ asset('licenses/' . $license->license_back_image) }}" 
                                alt="License Back" 
                                class="license-image"
                                onerror="this.onerror=null; this.parentNode.innerHTML='<div class=\'no-image\'><i class=\'fas fa-id-card\'></i><p>Back image not available</p></div>';"
                            >
                        @else
                            <div class="no-image">
                                <i class="fas fa-id-card"></i>
                                <p>Back image not available</p>
                            </div>
                        @endif
                    </div>
                </div> --}}
                

                <!-- License Actions -->
                {{-- <div class="license-actions">
                    @if($days_remaining < 30)
                        <a href="https://eralis.rsta.gov.bt/services/driving/search?serviceType=driving_renewal" class="btn-primary" target="_blank">
                            <i class="fas fa-sync-alt me-1"></i> Renew License
                        </a>
                    @endif
                    <button class="btn-outline" id="updateLicense">
                        <i class="fas fa-edit me-1"></i> Update License Information
                    </button>
                </div> --}}
                    
                    {{-- @if(config('app.debug'))
                        <div class="debug-info mt-4 p-3 bg-light border rounded">
                            <h5>Debug Information</h5>
                            <p><strong>Front Image:</strong> {{ $license->license_front_image ?? 'Not set' }}</p>
                            <p><strong>Front Image Path:</strong> {{ $front_image_path }}</p>
                            <p><strong>Front Image Exists:</strong> {{ $front_exists ? 'Yes' : 'No' }}</p>
                            <p><strong>Back Image:</strong> {{ $license->license_back_image ?? 'Not set' }}</p>
                            <p><strong>Back Image Path:</strong> {{ $back_image_path }}</p>
                            <p><strong>Back Image Exists:</strong> {{ $back_exists ? 'Yes' : 'No' }}</p>
                        </div>
                    @endif  --}}
                </div>
            @else
                <div class="license-container no-license">
                    <i class="fas fa-id-card"></i>
                    <h3>No Driving License Found</h3>
                    <p>You haven't added your driving license information yet. To rent a car, you'll need to provide your valid driving license details.</p>
                    <a href="#" class="btn-primary" id="addLicense">
                        <i class="fas fa-plus"></i> Add Driving License
                    </a>
                </div>
            @endif
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
            
            // License button handlers (placeholder functionality)
            const addLicenseBtn = document.getElementById('addLicense');
            const updateLicenseBtn = document.getElementById('updateLicense');
            
            if(addLicenseBtn) {
                addLicenseBtn.addEventListener('click', function(e) {
                    e.preventDefault();
                    alert('Add license functionality will be implemented here');
                });
            }
            
            if(updateLicenseBtn) {
                updateLicenseBtn.addEventListener('click', function(e) {
                    e.preventDefault();
                    alert('Update license functionality will be implemented here');
                });
            }
        });
    </script>
</body>
</html>
@endsection



