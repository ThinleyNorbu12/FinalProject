@extends('layouts.app')

@section('content')
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Rental History - Car Rental</title>
    <!-- Link to the external CSS file -->
    <link rel="stylesheet" href="{{ asset('assets/css/customer/dashboard.css') }}">

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    
    <style>
        .rental-history-container {
            padding: 20px;
        }
        
        .rental-card {
            background: #fff;
            border-radius: 8px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
            margin-bottom: 20px;
            overflow: hidden;
        }
        
        .rental-header {
            padding: 15px 20px;
            background: #f8f9fa;
            border-bottom: 1px solid #e9ecef;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }
        
        .rental-id {
            font-weight: 600;
            color: #495057;
        }
        
        .rental-status {
            font-size: 0.9rem;
            padding: 4px 12px;
            border-radius: 50px;
        }
        
        .status-completed {
            background: #d4edda;
            color: #155724;
        }
        
        .status-active {
            background: #cce5ff;
            color: #004085;
        }
        
        .status-cancelled {
            background: #f8d7da;
            color: #721c24;
        }
        
        .status-pending {
            background: #fff3cd;
            color: #856404;
        }
        
        .rental-body {
            display: flex;
            padding: 15px 20px;
        }
        
        .rental-image {
            flex: 0 0 150px;
            margin-right: 20px;
        }
        
        .rental-image img {
            width: 100%;
            height: auto;
            border-radius: 4px;
        }
        
        .rental-details {
            flex: 1;
        }
        
        .car-name {
            font-weight: 600;
            font-size: 1.2rem;
            margin-bottom: 10px;
            color: #212529;
        }
        
        .rental-info-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 15px;
        }
        
        .rental-info-item {
            margin-bottom: 10px;
        }
        
        .rental-info-label {
            font-size: 0.85rem;
            color: #6c757d;
            margin-bottom: 3px;
        }
        
        .rental-info-value {
            font-weight: 500;
            color: #343a40;
        }
        
        .rental-footer {
            padding: 15px 20px;
            border-top: 1px solid #e9ecef;
            display: flex;
            justify-content: space-between;
            align-items: center;
            background: #f8f9fa;
        }
        
        .rental-price {
            font-weight: 600;
            font-size: 1.1rem;
            color: #212529;
        }
        
        .rental-actions button {
            margin-left: 10px;
            padding: 8px 15px;
            border-radius: 4px;
            border: none;
            cursor: pointer;
            font-weight: 500;
            transition: all 0.2s;
        }
        
        .btn-primary {
            background: #007bff;
            color: white;
        }
        
        .btn-primary:hover {
            background: #0069d9;
        }
        
        .btn-secondary {
            background: #6c757d;
            color: white;
        }
        
        .btn-secondary:hover {
            background: #5a6268;
        }
        
        .payment-info {
            background: #f8f9fa;
            border-radius: 4px;
            padding: 10px 15px;
            margin-top: 10px;
        }
        
        .payment-info-title {
            font-weight: 600;
            margin-bottom: 5px;
            font-size: 0.9rem;
        }
        
        .payment-status {
            font-size: 0.85rem;
            padding: 2px 8px;
            border-radius: 50px;
            display: inline-block;
            margin-top: 5px;
        }
        
        .pay-later-section {
            margin-top: 10px;
            border-top: 1px dashed #dee2e6;
            padding-top: 10px;
        }
        
        .no-rentals {
            background: #f8f9fa;
            border-radius: 8px;
            padding: 40px;
            text-align: center;
            margin-top: 20px;
        }
        
        .no-rentals-icon {
            font-size: 3rem;
            color: #adb5bd;
            margin-bottom: 15px;
        }
        
        .filter-controls {
            margin-bottom: 20px;
            display: flex;
            align-items: center;
        }
        
        .filter-label {
            font-weight: 500;
            margin-right: 10px;
        }
        
        .filter-buttons {
            display: flex;
        }
        
        .filter-btn {
            padding: 8px 15px;
            margin-right: 10px;
            border: 1px solid #dee2e6;
            background: white;
            border-radius: 4px;
            font-size: 0.9rem;
            cursor: pointer;
            transition: all 0.2s;
        }
        
        .filter-btn.active {
            background: #007bff;
            color: white;
            border-color: #007bff;
        }
        
        .filter-btn:hover:not(.active) {
            background: #f8f9fa;
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
                
                <a href="{{ route('customer.browse-cars') }}" class="sidebar-menu-item">
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
                
                <a href="{{ route('customer.rental-history') }}" class="sidebar-menu-item active">
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
                
                <a href="{{ route('customer.license') }}" class="sidebar-menu-item">
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
            <div class="rental-history-container">
                <h2>Your Rental History</h2>
                <p>View all your past and current rentals in one place.</p>
                
                <div class="filter-controls">
                    <div class="filter-label">Filter by:</div>
                    <div class="filter-buttons">
                        <button class="filter-btn active" data-filter="all">All</button>
                        <button class="filter-btn" data-filter="active">Active</button>
                        <button class="filter-btn" data-filter="completed">Completed</button>
                        <button class="filter-btn" data-filter="cancelled">Cancelled</button>
                    </div>
                </div>
                
                @if(count($bookings) > 0)
                    @foreach($bookings as $booking)
                        @php
                            $paymentInfo = $payments[$booking->id] ?? null;
                            $payLaterInfo = $payLaterPayments[$booking->id] ?? null;
                            
                            // Determine badge class based on status
                            $statusClass = '';
                            switch($booking->status) {
                                case 'completed':
                                    $statusClass = 'status-completed';
                                    break;
                                case 'active':
                                    $statusClass = 'status-active';
                                    break;
                                case 'cancelled':
                                    $statusClass = 'status-cancelled';
                                    break;
                                default:
                                    $statusClass = 'status-pending';
                            }
                        @endphp
                        
                        <div class="rental-card rental-item" data-status="{{ $booking->status }}">
                            <div class="rental-header">
                                <div class="rental-id">Booking #{{ $booking->id }}</div>
                                <div class="rental-status {{ $statusClass }}">{{ ucfirst($booking->status) }}</div>
                            </div>
                            
                            <div class="rental-body">
                                <div class="rental-image">
                                    <img src="/api/placeholder/150/100" alt="Car Image">
                                </div>
                                
                                <div class="rental-details">
                                    @if(isset($booking->car_name))
                                        <div class="car-name">{{ $booking->car_name }}</div>
                                    @else
                                        <div class="car-name">Vehicle Details Not Available</div>
                                    @endif
                                    
                                    <div class="rental-info-grid">
                                        <div class="rental-info-item">
                                            <div class="rental-info-label">Pickup Date</div>
                                            <div class="rental-info-value">{{ date('M d, Y H:i', strtotime($booking->pickup_datetime)) }}</div>
                                        </div>
                                        
                                        <div class="rental-info-item">
                                            <div class="rental-info-label">Return Date</div>
                                            <div class="rental-info-value">{{ date('M d, Y H:i', strtotime($booking->dropoff_datetime)) }}</div>
                                        </div>
                                        
                                        <div class="rental-info-item">
                                            <div class="rental-info-label">Pickup Location</div>
                                            <div class="rental-info-value">{{ $booking->pickup_location }}</div>
                                        </div>
                                        
                                        <div class="rental-info-item">
                                            <div class="rental-info-label">Return Location</div>
                                            <div class="rental-info-value">{{ $booking->dropoff_location }}</div>
                                        </div>
                                    </div>
                                    
                                    @if($paymentInfo)
                                        <div class="payment-info">
                                            <div class="payment-info-title">Payment Information</div>
                                            <div>
                                                <strong>Method:</strong> {{ $paymentInfo->payment_method }}
                                                <br>
                                                <strong>Amount:</strong> {{ $paymentInfo->currency }} {{ number_format($paymentInfo->amount, 2) }}
                                                <br>
                                                <strong>Date:</strong> {{ date('M d, Y', strtotime($paymentInfo->payment_date)) }}
                                                <br>
                                                <div class="payment-status {{ $paymentInfo->status == 'paid' ? 'status-completed' : 'status-pending' }}">
                                                    {{ ucfirst($paymentInfo->status) }}
                                                </div>
                                            </div>
                                        </div>
                                    @endif
                                    
                                    @if($payLaterInfo && count($payLaterInfo) > 0)
                                        <div class="pay-later-section">
                                            <div class="payment-info-title">Pay Later Information</div>
                                            @foreach($payLaterInfo as $payLater)
                                                <div>
                                                    <strong>Collection Date:</strong> {{ date('M d, Y', strtotime($payLater->collection_date)) }}
                                                    <br>
                                                    <strong>Status:</strong> {{ ucfirst($payLater->status) }}
                                                    @if($payLater->status == 'collected')
                                                        <br>
                                                        <strong>Collection Method:</strong> {{ $payLater->collection_method }}
                                                    @endif
                                                </div>
                                            @endforeach
                                        </div>
                                    @endif
                                </div>
                            </div>
                            
                            <div class="rental-footer">
                                <div class="rental-price">
                                    @if($paymentInfo)
                                        {{ $paymentInfo->currency }} {{ number_format($paymentInfo->amount, 2) }}
                                    @else
                                        Price information not available
                                    @endif
                                </div>
                                <div class="rental-actions">
                                    @if($booking->status == 'active')
                                        <button class="btn-primary">Extend Rental</button>
                                        <button class="btn-secondary">Return Car</button>
                                    @elseif($booking->status == 'completed')
                                        <button class="btn-primary">Book Again</button>
                                        <button class="btn-secondary">View Invoice</button>
                                    @endif
                                </div>
                            </div>
                        </div>
                    @endforeach
                @else
                    <div class="no-rentals">
                        <div class="no-rentals-icon">
                            <i class="fas fa-car"></i>
                        </div>
                        <h3>No rental history found</h3>
                        <p>You haven't rented any cars yet. Start your journey by browsing our collection.</p>
                        <a href="{{ route('customer.browse-cars') }}" class="btn-primary" style="display: inline-block; margin-top: 15px; padding: 10px 20px; text-decoration: none;">Browse Cars</a>
                    </div>
                @endif
            </div>
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
            
            // Filter functionality
            const filterButtons = document.querySelectorAll('.filter-btn');
            const rentalItems = document.querySelectorAll('.rental-item');
            
            filterButtons.forEach(button => {
                button.addEventListener('click', function() {
                    // Remove active class from all buttons
                    filterButtons.forEach(btn => btn.classList.remove('active'));
                    
                    // Add active class to clicked button
                    this.classList.add('active');
                    
                    const filterValue = this.getAttribute('data-filter');
                    
                    rentalItems.forEach(item => {
                        if (filterValue === 'all') {
                            item.style.display = 'block';
                        } else {
                            if (item.getAttribute('data-status') === filterValue) {
                                item.style.display = 'block';
                            } else {
                                item.style.display = 'none';
                            }
                        }
                    });
                });
            });
        });
    </script>
</body>
</html>
@endsection