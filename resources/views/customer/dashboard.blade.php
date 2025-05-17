@extends('layouts.app')

@section('content')
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Car Rental Dashboard</title>
    <!-- Link to the external CSS file -->
    <link rel="stylesheet" href="{{ asset('assets/css/customer/dashboard.css') }}">

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
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
                <a href="#" class="sidebar-menu-item active">
                    <i class="fas fa-home"></i>
                    <span>Dashboard</span>
                </a>
                
                <a href="{{ route('customer.browse-cars') }}" class="sidebar-menu-item">
                    <i class="fas fa-car"></i>
                    <span>Browse Cars</span>
                </a>
                
                <a href="{{ route('customer.my-reservations') }}" class="sidebar-menu-item ">
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
            <div class="welcome-card">
                <h2>Welcome to Your Car Rental Dashboard</h2>
                @if(Auth::guard('customer')->check())
                    <p>Hello, {{ Auth::guard('customer')->user()->name }}! Here's a summary of your rental activities.</p>
                @else
                    <p>Hello, Guest! Please log in to access your car rental dashboard.</p>
                @endif
            </div>
            
            <!-- Current Rental -->
            <div class="current-rental">
                <h3>Your Current Rental</h3>
                
                @php
                // Get the current authenticated customer ID
                $customerId = Auth::guard('customer')->id();
                
                try {
                    // Get current confirmed rental for this customer
                    // Note: We're not joining with locations table as it doesn't exist
                    $currentRental = DB::table('car_bookings')
                        ->join('car_details_tbl', 'car_bookings.car_id', '=', 'car_details_tbl.id')
                        ->select(
                            'car_bookings.id as booking_id',
                            'car_bookings.pickup_datetime',
                            'car_bookings.dropoff_datetime',
                            'car_bookings.pickup_location',  // This is a string value, not a foreign key
                            'car_bookings.dropoff_location', // This is a string value, not a foreign key
                            'car_details_tbl.maker',
                            'car_details_tbl.model',
                            'car_details_tbl.vehicle_type',
                            'car_details_tbl.car_image',
                            'car_details_tbl.number_of_doors',
                            'car_details_tbl.number_of_seats',
                            'car_details_tbl.transmission_type',
                            'car_details_tbl.fuel_type',
                            'car_details_tbl.air_conditioning'
                        )
                        ->where('car_bookings.customer_id', $customerId)
                        ->where('car_bookings.status', 'confirmed')
                        ->whereDate('car_bookings.dropoff_datetime', '>=', now())
                        ->orderBy('car_bookings.pickup_datetime', 'asc')
                        ->first();
                } catch (\Exception $e) {
                    $currentRental = null;
                }
                @endphp
                
                @if($currentRental)
                    <div class="rental-details">
                        <div class="car-image">
                            @if($currentRental->car_image)
                                <img src="{{ asset($currentRental->car_image) }}" alt="{{ $currentRental->maker }} {{ $currentRental->model }}">
                            @else
                                <img src="/api/placeholder/600/350" alt="{{ $currentRental->maker }} {{ $currentRental->model }}">
                            @endif
                        </div>
                        
                        <div class="rental-info">
                            <h4>{{ $currentRental->maker }} {{ $currentRental->model }}</h4>
                            
                            <div class="rental-info-row">
                                <div class="rental-info-label">Rental ID:</div>
                                <div>RNT-{{ str_pad($currentRental->booking_id, 5, '0', STR_PAD_LEFT) }}</div>
                            </div>
                            
                            <div class="rental-info-row">
                                <div class="rental-info-label">Pickup Date:</div>
                                <div>{{ \Carbon\Carbon::parse($currentRental->pickup_datetime)->format('F d, Y') }}</div>
                            </div>
                            
                            <div class="rental-info-row">
                                <div class="rental-info-label">Return Date:</div>
                                <div>{{ \Carbon\Carbon::parse($currentRental->dropoff_datetime)->format('F d, Y') }}</div>
                            </div>
                            
                            <div class="rental-info-row">
                                <div class="rental-info-label">Pickup Location:</div>
                                <div>{{ $currentRental->pickup_location }}</div>
                            </div>
                            
                            <div class="rental-info-row">
                                <div class="rental-info-label">Return Location:</div>
                                <div>{{ $currentRental->dropoff_location }}</div>
                            </div>
                            
                            <div class="rental-info-row">
                                <div class="rental-info-label">Vehicle Details:</div>
                                <div>
                                    {{ $currentRental->vehicle_type }} | 
                                    {{ $currentRental->number_of_seats }} seats | 
                                    {{ $currentRental->transmission_type }} | 
                                    {{ $currentRental->fuel_type }}
                                    @if($currentRental->air_conditioning == 'Yes')
                                    | A/C
                                    @endif
                                </div>
                            </div>
                            
                            <div class="rental-info-row">
                                <div class="rental-info-label">Remaining Time:</div>
                                <div>
                                    @php
                                        $now = \Carbon\Carbon::now();
                                        $endDate = \Carbon\Carbon::parse($currentRental->dropoff_datetime);
                                        $diff = $now->diff($endDate);
                                        
                                        if ($diff->days > 0) {
                                            echo $diff->days . ' days, ' . $diff->h . ' hours';
                                        } else {
                                            echo $diff->h . ' hours, ' . $diff->i . ' minutes';
                                        }
                                    @endphp
                                </div>
                            </div>
                            
                            <div class="rental-actions">
                                <button class="btn-extend" data-booking-id="{{ $currentRental->booking_id }}">Extend Rental</button>
                                <button class="btn-return" data-booking-id="{{ $currentRental->booking_id }}">Early Return</button>
                            </div>
                        </div>
                    </div>
                @else
                    <div class="no-rental">
                        <p>You don't have any active rentals at the moment.</p>
                        <a href="{{ route('customer.browse-cars') }}" class="btn-browse">Browse Available Cars</a>
                    </div>
                @endif
            </div>

            
            <!-- Stats -->
            <div class="stats-grid">
                <div class="stat-card">
                    <div class="stat-number">1</div>
                    <div class="stat-label">Active Rentals</div>
                </div>
                
                <div class="stat-card">
                    <div class="stat-number">2</div>
                    <div class="stat-label">Upcoming Reservations</div>
                </div>
                
                <div class="stat-card">
                    <div class="stat-number">8</div>
                    <div class="stat-label">Completed Rentals</div>
                </div>
                
                <div class="stat-card">
                    <div class="stat-number">850</div>
                    <div class="stat-label">Loyalty Points</div>
                </div>
            </div>
            
            <!-- Rental History -->
            <!-- Rental History Component -->
            <div class="history-card">
                <h3>Recent Rental History</h3>
                
                @php
                // Get the current authenticated customer ID
                $customerId = Auth::guard('customer')->id();
                
                try {
                    // Get rental history for this customer
                    $rentalHistory = DB::table('car_bookings')
                        ->join('car_details_tbl', 'car_bookings.car_id', '=', 'car_details_tbl.id')
                        ->select(
                            'car_bookings.id as booking_id',
                            'car_bookings.pickup_datetime',
                            'car_bookings.dropoff_datetime',
                            'car_bookings.status',
                            'car_details_tbl.maker',
                            'car_details_tbl.model',
                            'car_details_tbl.vehicle_type',
                            'car_details_tbl.price'
                        )
                        ->where('car_bookings.customer_id', $customerId)
                        ->orderBy('car_bookings.pickup_datetime', 'desc')
                        ->limit(5)
                        ->get();
                } catch (\Exception $e) {
                    $rentalHistory = collect([]);
                }
                @endphp
                
                <table class="rental-table">
                    <thead>
                        <tr>
                            <th>Rental ID</th>
                            <th>Car</th>
                            <th>Dates</th>
                            <th>Cost</th>
                            <th>Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        @if(count($rentalHistory) > 0)
                            @foreach($rentalHistory as $rental)
                                <tr>
                                    <td>RNT-{{ str_pad($rental->booking_id, 5, '0', STR_PAD_LEFT) }}</td>
                                    <td>{{ $rental->maker }} {{ $rental->model }}</td>
                                    <td>
                                        {{ \Carbon\Carbon::parse($rental->pickup_datetime)->format('M d') }} - 
                                        {{ \Carbon\Carbon::parse($rental->dropoff_datetime)->format('M d, Y') }}
                                    </td>
                                    <td>
                                        @php
                                            // Calculate the number of days between pickup and dropoff
                                            $pickupDate = \Carbon\Carbon::parse($rental->pickup_datetime);
                                            $dropoffDate = \Carbon\Carbon::parse($rental->dropoff_datetime);
                                            $days = $pickupDate->diffInDays($dropoffDate);
                                            // Calculate the total cost (days * daily price)
                                            $totalCost = $days * $rental->price;
                                            // Format as currency
                                            echo '$' . number_format($totalCost, 2);
                                        @endphp
                                    </td>
                                    <td>
                                        @if($rental->status == 'confirmed' && \Carbon\Carbon::parse($rental->dropoff_datetime) >= now())
                                            <span class="badge badge-active">Active</span>
                                        @elseif($rental->status == 'confirmed' && \Carbon\Carbon::parse($rental->dropoff_datetime) < now())
                                            <span class="badge badge-completed">Completed</span>
                                        @elseif($rental->status == 'completed')
                                            <span class="badge badge-completed">Completed</span>
                                        @elseif($rental->status == 'cancelled')
                                            <span class="badge badge-cancelled">Cancelled</span>
                                        @elseif($rental->status == 'pending')
                                            <span class="badge badge-pending">Pending</span>
                                        @elseif($rental->status == 'pending_verification')
                                            <span class="badge badge-pending">Pending Verification</span>
                                        @else
                                            <span class="badge badge-{{ $rental->status }}">{{ ucfirst($rental->status) }}</span>
                                        @endif
                                    </td>
                                </tr>
                            @endforeach
                        @else
                            <tr>
                                <td colspan="5" class="no-rentals">No rental history found.</td>
                            </tr>
                        @endif
                    </tbody>
                </table>
                
                @if(count($rentalHistory) > 0)
                    <div class="view-all">
                        <a href="{{ route('customer.rental-history') }}" class="btn-view-all">View All History</a>
                    </div>
                @endif
            </div>
            
            <!-- Recommended Cars -->
            <!-- <div class="recommended-card">
                <h3>Recommended For You</h3>
                @if(isset($recommendedCars) && is_countable($recommendedCars) && count($recommendedCars) > 0)
                    <div class="cars-grid">
                        @foreach($recommendedCars as $car)
                        <div class="car-card-container">
                            <div class="car-status">Available</div>
                            <div class="car-card">
                                @if($car->car_image)
                                    <img src="{{ asset('storage/' . $car->car_image) }}" alt="Car Image" style="width: 100px; height: auto;">
                                @else
                                    <img src="{{ asset('images/car-placeholder.png') }}" alt="{{ $car->maker }} {{ $car->model }}">
                                @endif
                                
                                <div class="car-details">
                                    <h4 class="car-title">{{ $car->maker }} {{ $car->model }}</h4>
                                    
                                    <div class="car-specs">
                                        <i class="fas fa-user"></i> {{ $car->number_of_seats ?? 'N/A' }} &nbsp;
                                        <i class="fas fa-door-open"></i> {{ $car->number_of_doors ?? 'N/A' }} &nbsp;
                                        <i class="fas fa-gas-pump"></i> {{ ucfirst($car->fuel_type ?? 'N/A') }} &nbsp;
                                        <i class="fas fa-cog"></i> {{ ucfirst($car->transmission_type ?? 'Auto') }}
                                    </div>
                                    
                                    <div class="car-description">
                                        {{ \Illuminate\Support\Str::limit($car->description, 100) ?? 'No description available.' }}
                                    </div>
                                    
                                    <div class="car-features">
                                        @if(strtolower($car->air_conditioning) === 'yes')
                                            <span class="car-feature"><i class="fas fa-snowflake"></i> A/C</span>
                                        @endif
                                        
                                        @if(strtolower($car->backup_camera) === 'yes')
                                            <span class="car-feature"><i class="fas fa-camera"></i> Backup Camera</span>
                                        @endif
                                        
                                        @if(strtolower($car->bluetooth) === 'yes')
                                            <span class="car-feature"><i class="fab fa-bluetooth-b"></i> Bluetooth</span>
                                        @endif
                                        
                                        <span class="car-feature"><i class="fas fa-suitcase"></i> {{ $car->large_bags_capacity ?? '0' }} Large / {{ $car->small_bags_capacity ?? '0' }} Small</span>
                                    </div>
                                    
                                    <div class="car-price">${{ number_format($car->price, 2) }}/day</div>
                                    
                                    <div class="car-actions">
                                        <a href="{{ route('customer.car-details', $car->id) }}" class="btn-view-details">View Details</a>
                                        <a href="{{ route('customer.book-car', $car->id) }}" class="btn-book-now">Book Now</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                        @endforeach
                    </div>
                @else
                    <div class="no-cars-message">
                        <p>No available cars at the moment. Please check back later.</p>
                    </div>
                @endif
            </div> -->
            <div class="recommended-cars-section">
                <h3>Recommended For You</h3>
                
                @if($recommendedCars->count() > 0)
                    <div class="cars-grid">
                        @foreach($recommendedCars as $car)
                        <div class="car-card">
                            <div class="car-status">Available</div>
                            <div class="car-image">
                                @if($car->car_image)
                                    <img src="{{ asset($car->car_image) }}" alt="{{ $car->model }}" >
                                @else
                                    <img src="{{ asset('images/car-placeholder.jpg') }}" alt="Car Image">
                                @endif
                            </div>
                            
                            <div class="car-info">
                                <h4>{{ $car->maker }} {{ $car->model }}</h4>
                                <div class="car-specs">
                                    <span><i class="fas fa-gas-pump"></i> {{ $car->fuel_type }}</span>
                                    <span><i class="fas fa-cog"></i> {{ $car->transmission_type }}</span>
                                    <span><i class="fas fa-users"></i> {{ $car->number_of_seats }} seats</span>
                                </div>
                                <div class="car-price">${{ number_format($car->price, 2) }}/day</div>
                                <a href="{{ route('customer.car-details', $car->id) }}" class="btn btn-primary">View Details</a>
                                <a href="{{ route('customer.book-car', $car->id) }}" class="btn-book-now">Book Now</a>
                            </div>
                        </div>
                        @endforeach
                    </div>
                @else
                    <div class="alert alert-info">
                        No available cars at the moment. Please check back later.
                    </div>
                @endif
            </div>
        </div>
    </div>

    <script>
document.addEventListener('DOMContentLoaded', function() {
    // Handle Extend Rental button click
    const extendButtons = document.querySelectorAll('.btn-extend');
    extendButtons.forEach(button => {
        button.addEventListener('click', function() {
            const bookingId = this.getAttribute('data-booking-id');
            window.location.href = `/customer/extend-rental/${bookingId}`;
        });
    });
    
    // Handle Early Return button click
    const returnButtons = document.querySelectorAll('.btn-return');
    returnButtons.forEach(button => {
        button.addEventListener('click', function() {
            const bookingId = this.getAttribute('data-booking-id');
            if (confirm('Are you sure you want to return this vehicle early?')) {
                window.location.href = `/customer/early-return/${bookingId}`;
            }
        });
    });
});
</script>
</body>
</html>
@endsection