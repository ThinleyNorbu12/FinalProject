@extends('layouts.app')

@section('content')
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>My Reservations - Car Rental</title>
    <!-- Link to the external CSS file -->
    <link rel="stylesheet" href="{{ asset('assets/css/customer/dashboard.css') }}">

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    
    <style>
        .nav-tabs .nav-link {
            color: #333;
            font-weight: 500;
            padding: 12px 20px;
            border-radius: 0;
            border: none;
            border-bottom: 3px solid transparent;
        }
        
        .nav-tabs .nav-link.active {
            background-color: transparent;
            border-bottom: 3px solid #4B89DC;
            color: #4B89DC;
        }
        
        .reservation-card {
            background-color: #fff;
            border-radius: 10px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.05);
            margin-bottom: 20px;
            overflow: hidden;
            transition: transform 0.2s, box-shadow 0.2s;
        }
        
        .reservation-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);
        }
        
        .reservation-header {
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 15px 20px;
            background-color: #f8f9fa;
            border-bottom: 1px solid #eee;
        }
        
        .reservation-id {
            font-weight: 600;
            color: #333;
        }
        
        .reservation-status {
            padding: 5px 12px;
            border-radius: 20px;
            font-size: 0.8rem;
            font-weight: 500;
        }
        
        .status-active, .status-confirmed {
            background-color: #e3f2fd;
            color: #1976d2;
        }
        
        .status-pending {
            background-color: #fff8e1;
            color: #ff8f00;
        }
        
        .status-completed {
            background-color: #e8f5e9;
            color: #388e3c;
        }
        
        .status-cancelled {
            background-color: #ffebee;
            color: #d32f2f;
        }
        
        .reservation-body {
            padding: 20px;
            display: flex;
            flex-wrap: wrap;
        }
        
        .car-image-container {
        width: 300px;
        flex-shrink: 0;
        margin-right: 30px;
        margin-bottom: 20px;
        
        }
        
        .car-image-container img {
            width: 100%;
            height: auto;
            border-radius: 8px;
            box-shadow: 0 3px 10px rgba(0, 0, 0, 0.1);
        }
        
        .reservation-details {
            flex: 1;
            min-width: 200px;
        }
        
        .car-name {
            font-size: 1.25rem;
            font-weight: 600;
            margin-bottom: 15px;
            color: #333;
        }
        
        .detail-row {
            display: flex;
            margin-bottom: 12px;
        }
        
        .detail-label {
            width: 140px;
            color: #666;
            font-weight: 500;
        }
        
        .detail-value {
            flex: 1;
            color: #333;
        }
        
        .reservation-footer {
            padding: 15px 20px;
            border-top: 1px solid #eee;
            display: flex;
            justify-content: space-between;
            align-items: center;
            background-color: #f8f9fa;
        }
        
        .price-info {
            font-size: 1.15rem;
            font-weight: 600;
            color: #333;
        }
        
        .action-buttons .btn {
            margin-left: 10px;
            border-radius: 5px;
            padding: 8px 16px;
            font-weight: 500;
        }
        
        .btn-view-details {
            background-color: #4B89DC;
            color: white;
        }
        
        .btn-view-details:hover {
            background-color: #3b79cc;
            color: white;
        }
        
        .btn-cancel {
            background-color: #f44336;
            color: white;
        }
        
        .btn-cancel:hover {
            background-color: #e53935;
            color: white;
        }
        
        .btn-modify {
            background-color: #ff9800;
            color: white;
        }
        
        .btn-modify:hover {
            background-color: #fb8c00;
            color: white;
        }
        
        .empty-state {
            text-align: center;
            padding: 50px 20px;
            color: #666;
        }
        
        .empty-state i {
            font-size: 3rem;
            color: #ccc;
            margin-bottom: 15px;
        }
        
        @media (max-width: 768px) {
            .car-image-container {
                width: 100%;
                margin-right: 0;
                margin-bottom: 20px;
            }
            
            .reservation-footer {
                flex-direction: column;
                gap: 15px;
            }
            
            .action-buttons {
                display: flex;
                width: 100%;
            }
            
            .action-buttons .btn {
                flex: 1;
                margin: 0 5px;
                padding: 8px 10px;
                font-size: 0.9rem;
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
                
                <a href="{{ route('customer.browse-cars') }}" class="sidebar-menu-item">
                    <i class="fas fa-car"></i>
                    <span>Browse Cars</span>
                </a>
                
                <a href="{{ route('customer.my-reservations') }}" class="sidebar-menu-item active">
                    <i class="fas fa-calendar-alt"></i>
                    <span>My Reservations</span>
                </a>
                
                <div class="sidebar-divider"></div>
                
                <div class="sidebar-heading">My Account</div>
                
                <a href="{{ route('customer.profile') }}" class="sidebar-menu-item">
                    <i class="fas fa-user"></i>
                    <span>Profile</span>
                </a>
                
                <a href="{{ route('customer.rental-history') }}" class="sidebar-menu-item">
                    <i class="fas fa-history"></i>
                    <span>Rental History</span>
                </a>
                
                <a href="{{ route('customer.payment-history') }}" class="sidebar-menu-item">
                    <i class="fas fa-credit-card"></i>
                    <span>Payment History</span>
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
                
                <a href="{{ route('customer.locations') }}" class="sidebar-menu-item ">
                    <i class="fas fa-map-marked-alt"></i>
                    <span>Locations</span>
                </a>
                
                <a href="{{ route('customer.insurance-options') }}" class="sidebar-menu-item ">
                    <i class="fas fa-shield-alt"></i>
                    <span>Insurance Options</span>
                </a>
                
                <a href="{{ route('customer.fuel-policy') }}" class="sidebar-menu-item ">
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
            <div class="page-heading">
                <h2><i class="fas fa-calendar-alt"></i> My Reservations</h2>
                <p>View and manage all your car reservations in one place.</p>
            </div>
            
            <!-- Alert Messages -->
            @if(session('success'))
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    {{ session('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif
            
            @if(session('error'))
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    {{ session('error') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif
            
            <!-- Tabs Navigation -->
            <ul class="nav nav-tabs mb-4" id="reservationsTabs" role="tablist">
                <li class="nav-item" role="presentation">
                    <button class="nav-link active" id="active-tab" data-bs-toggle="tab" data-bs-target="#active" type="button" role="tab" aria-controls="active" aria-selected="true">
                        Active & Upcoming
                        <span class="badge bg-primary rounded-pill ms-2">{{ count($activeBookings) }}</span>
                    </button>
                </li>
                <li class="nav-item" role="presentation">
                    <button class="nav-link" id="completed-tab" data-bs-toggle="tab" data-bs-target="#completed" type="button" role="tab" aria-controls="completed" aria-selected="false">
                        Completed
                        <span class="badge bg-success rounded-pill ms-2">{{ count($completedBookings) }}</span>
                    </button>
                </li>
                <li class="nav-item" role="presentation">
                    <button class="nav-link" id="cancelled-tab" data-bs-toggle="tab" data-bs-target="#cancelled" type="button" role="tab" aria-controls="cancelled" aria-selected="false">
                        Cancelled
                        <span class="badge bg-danger rounded-pill ms-2">{{ count($cancelledBookings) }}</span>
                    </button>
                </li>
            </ul>
            
            <!-- Tab Content -->
            <div class="tab-content" id="reservationsTabsContent">
                <!-- Active & Upcoming Reservations -->
                <div class="tab-pane fade show active" id="active" role="tabpanel" aria-labelledby="active-tab">
                    @if(count($activeBookings) > 0)
                        @foreach($activeBookings as $booking)
                            <div class="reservation-card">
                                <div class="reservation-header">
                                    <div class="reservation-id">Booking #{{ $booking->id }}</div>
                                    <div class="reservation-status status-{{ strtolower($booking->status) }}">{{ ucfirst($booking->status) }}</div>
                                </div>
                                <div class="reservation-body">
                                    <div class="car-image-container">
                                        @if($booking->car->car_image)
                                            <img src="{{ asset($booking->car->car_image) }}" alt="{{ $booking->car->maker }} {{ $booking->car->model }}" onerror="this.src='/api/placeholder/300/200';">
                                        @else
                                            <img src="/api/placeholder/300/200" alt="{{ $booking->car->maker }} {{ $booking->car->model }}">
                                        @endif
                                    </div>
                                    <div class="reservation-details">
                                        <div class="car-name">{{ $booking->car->make }} {{ $booking->car->model }} ({{ $booking->car->year }})</div>
                                        <div class="detail-row">
                                            <div class="detail-label">Pickup Date:</div>
                                            <div class="detail-value">{{ \Carbon\Carbon::parse($booking->pickup_datetime)->format('M d, Y - h:i A') }}</div>
                                        </div>
                                        <div class="detail-row">
                                            <div class="detail-label">Return Date:</div>
                                            <div class="detail-value">{{ \Carbon\Carbon::parse($booking->dropoff_datetime)->format('M d, Y - h:i A') }}</div>
                                        </div>
                                        @php
                                            $pickup = \Carbon\Carbon::parse($booking->pickup_datetime);
                                            $dropoff = \Carbon\Carbon::parse($booking->dropoff_datetime);
                                            $diff = $pickup->diff($dropoff);

                                            $durationParts = [];

                                            if ($diff->d > 0) {
                                                $durationParts[] = $diff->d . ' day' . ($diff->d > 1 ? 's' : '');
                                            }
                                            if ($diff->h > 0) {
                                                $durationParts[] = $diff->h . ' hour' . ($diff->h > 1 ? 's' : '');
                                            }
                                            if ($diff->i > 0) {
                                                $durationParts[] = $diff->i . ' minute' . ($diff->i > 1 ? 's' : '');
                                            }

                                            $formattedDuration = implode(', ', $durationParts);
                                        @endphp

                                        <div class="detail-row">
                                            <div class="detail-label">Duration:</div>
                                            <div class="detail-value">{{ $formattedDuration }}</div>
                                        </div>

                                        <div class="detail-row">
                                            <div class="detail-label">Pickup Location:</div>
                                            <div class="detail-value">{{ $booking->pickup_location }}</div>
                                        </div>
                                        <div class="detail-row">
                                            <div class="detail-label">Return Location:</div>
                                            <div class="detail-value">{{ $booking->dropoff_location }}</div>
                                        </div>
                                        <div class="detail-row">
                                            <div class="detail-label">Payment Method:</div>
                                            @php
                                                $payment = $booking->payments->first(); // or use a more specific logic if needed
                                            @endphp

                                            <div class="detail-value">
                                                @if ($payment)
                                                    @switch($payment->payment_method)
                                                        @case('qr_code')
                                                            QR Code
                                                            @break
                                                        @case('bank_transfer')
                                                            Bank Transfer
                                                            @break
                                                        @case('pay_later')
                                                            Pay Later
                                                            @break
                                                        @case('card')
                                                            Card Payment
                                                            @break
                                                        @default
                                                            {{ ucfirst($payment->payment_method) }}
                                                    @endswitch
                                                @else
                                                    No Payment Made
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="reservation-footer">
                                    <div class="price-info">
                                        @php
                                            $totalAmount = $booking->payments->sum('amount');
                                        @endphp
                                        Total: {{ $totalAmount > 0 ? '$'.number_format($totalAmount, 2) : 'Pending Payment' }}
                                    </div>
                                    <div class="action-buttons">
                                        @if($booking->status === 'pending')
                                            <form action="{{ route('customer.cancel-reservation', $booking->id) }}" method="POST" onsubmit="return confirm('Are you sure you want to cancel this reservation?');" style="display: inline;">
                                                @csrf
                                                <button type="submit" class="btn btn-cancel">Cancel</button>
                                            </form>
                                        @endif
                                        
                                        @if($booking->status === 'confirmed')
                                            <!-- <a href="#" class="btn btn-modify">Modify</a> -->
                                            <form action="{{ route('customer.cancel-reservation', $booking->id) }}" method="POST" onsubmit="return confirm('Are you sure you want to cancel this reservation?');" style="display: inline;">
                                                @csrf
                                                <button type="submit" class="btn btn-cancel">Cancel</button>
                                            </form>
                                        @endif
                                        
                                        <a href="{{ route('customer.reservation-details', $booking->id) }}" class="btn btn-view-details">View Details</a>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    @else
                        <div class="empty-state">
                            <i class="fas fa-calendar-alt"></i>
                            <h4>No Active or Upcoming Reservations</h4>
                            <p>You don't have any active or upcoming car reservations.</p>
                            <a href="{{ route('customer.browse-cars') }}" class="btn btn-view-details mt-3">Browse Cars</a>
                        </div>
                    @endif
                </div>
                
                <!-- Completed Reservations -->
                <div class="tab-pane fade" id="completed" role="tabpanel" aria-labelledby="completed-tab">
                    @if(count($completedBookings) > 0)
                        @foreach($completedBookings as $booking)
                            <div class="reservation-card">
                                <div class="reservation-header">
                                    <div class="reservation-id">Booking #{{ $booking->id }}</div>
                                    <div class="reservation-status status-completed">Completed</div>
                                </div>
                                <div class="reservation-body">
                                    <div class="car-image-container">
                                        @if($booking->car->car_image)
                                            <img src="{{ asset($booking->car->car_image) }}" alt="{{ $booking->car->maker }} {{ $booking->car->model }}" onerror="this.src='/api/placeholder/300/200';">
                                        @else
                                            <img src="/api/placeholder/300/200" alt="{{ $booking->car->maker }} {{ $booking->car->model }}">
                                        @endif
                                    </div>
                                    <div class="reservation-details">
                                        <div class="car-name">{{ $booking->car->make }} {{ $booking->car->model }} ({{ $booking->car->year }})</div>
                                        <div class="detail-row">
                                            <div class="detail-label">Pickup Date:</div>
                                            <div class="detail-value">{{ \Carbon\Carbon::parse($booking->pickup_datetime)->format('M d, Y - h:i A') }}</div>
                                        </div>
                                        <div class="detail-row">
                                            <div class="detail-label">Return Date:</div>
                                            <div class="detail-value">{{ \Carbon\Carbon::parse($booking->dropoff_datetime)->format('M d, Y - h:i A') }}</div>
                                        </div>
                                        @php
                                            $pickup = \Carbon\Carbon::parse($booking->pickup_datetime);
                                            $dropoff = \Carbon\Carbon::parse($booking->dropoff_datetime);
                                            $diff = $pickup->diff($dropoff);

                                            $durationParts = [];

                                            if ($diff->d > 0) {
                                                $durationParts[] = $diff->d . ' day' . ($diff->d > 1 ? 's' : '');
                                            }
                                            if ($diff->h > 0) {
                                                $durationParts[] = $diff->h . ' hour' . ($diff->h > 1 ? 's' : '');
                                            }
                                            if ($diff->i > 0) {
                                                $durationParts[] = $diff->i . ' minute' . ($diff->i > 1 ? 's' : '');
                                            }

                                            $formattedDuration = implode(', ', $durationParts);
                                        @endphp

                                        <div class="detail-row">
                                            <div class="detail-label">Duration:</div>
                                            <div class="detail-value">{{ $formattedDuration }}</div>
                                        </div>
                                        <div class="detail-row">
                                            <div class="detail-label">Pickup Location:</div>
                                            <div class="detail-value">{{ $booking->pickup_location }}</div>
                                        </div>
                                        <div class="detail-row">
                                            <div class="detail-label">Return Location:</div>
                                            <div class="detail-value">{{ $booking->dropoff_location }}</div>
                                        </div>
                                        <div class="detail-row">
                                            <div class="detail-label">Payment Method:</div>
                                            <div class="detail-value">{{ ucfirst($booking->payment_method) }}</div>
                                        </div>
                                    </div>
                                </div>
                                <div class="reservation-footer">
                                    <div class="price-info">
                                        @php
                                            $totalAmount = $booking->payments->sum('amount');
                                        @endphp
                                        Total: ${{ number_format($totalAmount, 2) }}
                                    </div>
                                    <div class="action-buttons">
                                        <a href="{{ route('customer.reservation-details', $booking->id) }}" class="btn btn-view-details">View Details</a>
                                        <button class="btn btn-primary">Book Again</button>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    @else
                        <div class="empty-state">
                            <i class="fas fa-check-circle"></i>
                            <h4>No Completed Reservations</h4>
                            <p>You don't have any completed car reservations yet.</p>
                        </div>
                    @endif
                </div>
                
                <!-- Cancelled Reservations -->
                <div class="tab-pane fade" id="cancelled" role="tabpanel" aria-labelledby="cancelled-tab">
                    @if(count($cancelledBookings) > 0)
                        @foreach($cancelledBookings as $booking)
                            <div class="reservation-card">
                                <div class="reservation-header">
                                    <div class="reservation-id">Booking #{{ $booking->id }}</div>
                                    <div class="reservation-status status-cancelled">Cancelled</div>
                                </div>
                                <div class="reservation-body">
                                    <div class="car-image-container">
                                        @if($booking->car->car_image)
                                            <img src="{{ asset($booking->car->car_image) }}" alt="{{ $booking->car->maker }} {{ $booking->car->model }}" onerror="this.src='/api/placeholder/300/200';">
                                        @else
                                            <img src="/api/placeholder/300/200" alt="{{ $booking->car->maker }} {{ $booking->car->model }}">
                                        @endif
                                    </div>
                                    <div class="reservation-details">
                                        <div class="car-name">{{ $booking->car->make }} {{ $booking->car->model }} ({{ $booking->car->year }})</div>
                                        <div class="detail-row">
                                            <div class="detail-label">Cancelled On:</div>
                                            <div class="detail-value">{{ \Carbon\Carbon::parse($booking->updated_at)->format('M d, Y - h:i A') }}</div>
                                        </div>
                                        <div class="detail-row">
                                            <div class="detail-label">Planned Pickup:</div>
                                            <div class="detail-value">{{ \Carbon\Carbon::parse($booking->pickup_datetime)->format('M d, Y - h:i A') }}</div>
                                        </div>
                                        <div class="detail-row">
                                            <div class="detail-label">Planned Return:</div>
                                            <div class="detail-value">{{ \Carbon\Carbon::parse($booking->dropoff_datetime)->format('M d, Y - h:i A') }}</div>
                                        </div>
                                        <div class="detail-row">
                                            <div class="detail-label">Pickup Location:</div>
                                            <div class="detail-value">{{ $booking->pickup_location }}</div>
                                        </div>
                                        <div class="detail-row">
                                            <div class="detail-label">Return Location:</div>
                                            <div class="detail-value">{{ $booking->dropoff_location }}</div>
                                        </div>
                                    </div>
                                </div>
                                <div class="reservation-footer">
                                    <div class="price-info">
                                        @php
                                            $totalAmount = $booking->payments->sum('amount');
                                            $refundStatus = $totalAmount > 0 ? 'Refund Processed' : 'No Payment Made';
                                        @endphp
                                        {{ $refundStatus }}
                                    </div>
                                    <div class="action-buttons">
                                        <a href="{{ route('customer.reservation-details', $booking->id) }}" class="btn btn-view-details">View Details</a>
                                        <!-- <button class="btn btn-primary">Book Again</button> -->
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    @else
                        <div class="empty-state">
                            <i class="fas fa-ban"></i>
                            <h4>No Cancelled Reservations</h4>
                            <p>You don't have any cancelled car reservations.</p>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
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
        });
    </script>
</body>
</html>
@endsection