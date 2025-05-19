@extends('layouts.app')

@section('content')
<!-- Main Content -->
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
    <div class="sidebar" id="sidebar">
        <div class="sidebar-menu">
            <a href="{{ route('admin.dashboard') }}" class="sidebar-menu-item">
                <i class="fas fa-tachometer-alt"></i>
                <span>Dashboard</span>
            </a>
            <div class="sidebar-divider"></div>
            <div class="sidebar-heading">Car Owner</div>

            <a href="{{ route('car-admin.new-registration-cars') }}" class="sidebar-menu-item ">
                <i class="fas fa-car"></i>
                <span>Car Registration</span>
            </a>

            <a href="{{ route('car-admin.inspection-requests') }}" class="sidebar-menu-item">
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

            <a href="{{ route ('admin.booked-car') }}" class="sidebar-menu-item active">
                <i class="fas fa-calendar-check"></i>
                <span>Booked Cars</span>
            </a>

            <a href="#" class="sidebar-menu-item" onclick="document.getElementById('logout-form').submit();">
                <i class="fas fa-sign-out-alt"></i>
                <span>Logout</span>
            </a>

            <form method="POST" action="{{ route('admin.logout') }}" id="logout-form" style="display: none;">
                @csrf
            </form>
        </div>
    </div>       
</div>
<div class="dashboard-content">
    <!-- Page Header -->
    <div class="page-header">
        <h1>Booking Details</h1>
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
                <li class="breadcrumb-item"><a href="{{ route('admin.booked-car') }}">Booked Cars</a></li>
                <li class="breadcrumb-item active" aria-current="page">Booking #{{ $booking->id }}</li>
            </ol>
        </nav>
    </div>

    <div class="row">
        <!-- Booking Details Card -->
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">
                    <h5 class="mb-0">Booking Information</h5>
                </div>
                <div class="card-body">
                    <div class="row mb-4">
                        <div class="col-md-6">
                            <h6 class="fw-bold">Booking ID</h6>
                            <p>{{ $booking->id }}</p>
                        </div>
                        <div class="col-md-6">
                            <h6 class="fw-bold">Booking Status</h6>
                            <p>
                                @switch($booking->status)
                                    @case('confirmed')
                                        <span class="badge bg-success">Confirmed</span>
                                        @break
                                    @case('pending')
                                        <span class="badge bg-warning">Pending</span>
                                        @break
                                    @case('pending_verification')
                                        <span class="badge bg-info">Pending Verification</span>
                                        @break
                                    @case('cancelled')
                                        <span class="badge bg-danger">Cancelled</span>
                                        @break
                                    @case('completed')
                                        <span class="badge bg-secondary">Completed</span>
                                        @break
                                    @default
                                        <span class="badge bg-secondary">{{ ucfirst($booking->status) }}</span>
                                @endswitch
                            </p>
                        </div>
                    </div>

                    <div class="row mb-4">
                        <div class="col-md-6">
                            <h6 class="fw-bold">Pickup Location</h6>
                            <p>{{ $booking->pickup_location }}</p>
                        </div>
                        <div class="col-md-6">
                            <h6 class="fw-bold">Dropoff Location</h6>
                            <p>{{ $booking->dropoff_location }}</p>
                        </div>
                    </div>

                    <div class="row mb-4">
                        <div class="col-md-6">
                            <h6 class="fw-bold">Pickup Date & Time</h6>
                            <p>{{ $booking->pickup_datetime->format('M d, Y h:i A') }}</p>
                        </div>
                        <div class="col-md-6">
                            <h6 class="fw-bold">Return Date & Time</h6>
                            <p>{{ $booking->dropoff_datetime->format('M d, Y h:i A') }}</p>
                        </div>
                    </div>

                    <div class="row mb-4">
                        <div class="col-md-6">
                            <h6 class="fw-bold">Booking Duration</h6>
                            <p>{{ $booking->pickup_datetime->diffInDays($booking->dropoff_datetime) + 1 }} days</p>
                        </div>
                        <div class="col-md-6">
                            <h6 class="fw-bold">Created On</h6>
                            <p>{{ $booking->created_at->format('M d, Y h:i A') }}</p>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-12">
                            <h6 class="fw-bold">Payment Information</h6>
                            @if($booking->payment)
                                <div class="table-responsive">
                                    <table class="table table-bordered">
                                        <tr>
                                            <th>Payment Method</th>
                                            <td>{{ ucfirst(str_replace('_', ' ', $booking->payment->payment_method)) }}</td>
                                        </tr>
                                        <tr>
                                            <th>Amount</th>
                                            <td>{{ $booking->payment->currency }} {{ number_format($booking->payment->amount, 2) }}</td>
                                        </tr>
                                        <tr>
                                            <th>Status</th>
                                            <td>
                                                @if($booking->payment->status === 'completed')
                                                    <span class="badge bg-success">Paid</span>
                                                @elseif($booking->payment->status === 'pending_verification')
                                                    <span class="badge bg-warning">Pending Verification</span>
                                                @else
                                                    <span class="badge bg-danger">{{ ucfirst($booking->payment->status) }}</span>
                                                @endif
                                            </td>
                                        </tr>
                                        <tr>
                                            <th>Reference Number</th>
                                            <td>{{ $booking->payment->reference_number }}</td>
                                        </tr>
                                        <tr>
                                            <th>Payment Date</th>
                                            <td>{{ $booking->payment->payment_date->format('M d, Y h:i A') }}</td>
                                        </tr>
                                    </table>
                                </div>
                            @else
                                <p class="text-muted">No payment information available</p>
                            @endif
                        </div>
                    </div>
                </div>
                <div class="card-footer text-end">
                    <button type="button" class="btn btn-warning" data-bs-toggle="modal" data-bs-target="#updateStatusModal">
                        <i class="fas fa-edit"></i> Update Status
                    </button>
                </div>
            </div>
        </div>

        <!-- Customer & Car Info Cards -->
        <div class="col-md-4">
            <!-- Customer Info -->
            <div class="card mb-4">
                <div class="card-header">
                    <h5 class="mb-0">Customer Information</h5>
                </div>             
                <div class="card-body">
                    @if($booking->customer)
                        <div class="d-flex align-items-center mb-3">
                            <div class="flex-shrink-0">
                                @if($booking->customer->profile_image && file_exists(public_path('customerprofile/' . $booking->customer->profile_image)))
                                    <img src="{{ asset('customerprofile/' . $booking->customer->profile_image) }}" class="rounded-circle" width="50" height="50" alt="Customer Avatar" style="object-fit: cover;">
                                @else
                                    <img src="{{ asset('customerprofile/profile.png') }}" class="rounded-circle" width="50" height="50" alt="Customer Avatar">
                                @endif
                            </div>
                            <div class="flex-grow-1 ms-3">
                                <h6 class="mb-0">{{ $booking->customer->name }}</h6>
                                <p class="text-muted mb-0">Customer ID: {{ $booking->customer->id }}</p>
                            </div>
                        </div>

                        <div class="customer-details mt-3">
                            <p><i class="fas fa-envelope me-2"></i> {{ $booking->customer->email }}</p>
                            <p><i class="fas fa-phone me-2"></i> {{ $booking->customer->phone ?? 'N/A' }}</p>
                            <p><i class="fas fa-map-marker-alt me-2"></i> {{ $booking->customer->address ?? 'N/A' }}</p>
                        </div>

                        <a href="#" class="btn btn-sm btn-outline-primary mt-2">
                            <i class="fas fa-user"></i> View Customer Profile
                        </a>
                    @else
                        <p class="text-muted">Customer information not available</p>
                    @endif
                </div>
            </div>

            <!-- Car Info -->
            {{-- <div class="card">
                <div class="card-header">
                    <h5 class="mb-0">Car Information</h5>
                </div>
                <div class="card-body">
                    @if($booking->car)
                        <div class="text-center mb-3">
                            @if(isset($booking->car) && isset($booking->car->car_image) && !empty($booking->car->car_image))
                                <img src="{{ asset($booking->car->car_image) }}" class="img-fluid rounded" alt="Car Image" style="max-height: 200px; object-fit: cover;">
                            @else
                                <img src="{{ asset('carimage/defaultcar.jpg') }}" class="img-fluid rounded" alt="Car Image">
                            @endif
                        </div>
                        <h5 class="mb-3">{{ $booking->car->maker }} {{ $booking->car->model }}</h5>

                        <div class="car-details">
                            <p><i class="fas fa-car me-2"></i> <strong>Type:</strong> {{ $booking->car->vehicle_type ?? 'N/A' }}</p>
                            <p><i class="fas fa-tachometer-alt me-2"></i> <strong>Mileage:</strong> {{ number_format($booking->car->mileage ?? 0) }} km</p>
                            <p><i class="fas fa-gas-pump me-2"></i> <strong>Fuel Type:</strong> {{ $booking->car->fuel_type ?? 'N/A' }}</p>
                            <p><i class="fas fa-money-bill-wave me-2"></i> <strong>Daily Rate:</strong> BTN {{ number_format($booking->car->price ?? 0, 2) }}</p>
                        </div>

                        <a href="#" class="btn btn-sm btn-outline-primary mt-2">
                            <i class="fas fa-info-circle"></i> View Car Details
                        </a>
                    @else
                        <p class="text-muted">Car information not available</p>
                    @endif
                </div>
            </div> --}}
            <div class="card">
                <div class="card-header">
                    <h5 class="mb-0">Car Information</h5>
                </div>
                <div class="card-body">
                    @if($booking->car)
                        <!-- Car Images Carousel -->
                        @if($booking->car->images && count($booking->car->images))
                            <div class="carousel-container mb-4">
                                <div id="carImageCarousel" class="carousel slide" data-bs-ride="carousel">
                                    <div class="carousel-inner">
                                        @foreach($booking->car->images as $key => $image)
                                            <div class="carousel-item {{ $key == 0 ? 'active' : '' }}">
                                                <img src="{{ asset($image->image_path) }}" class="d-block mx-auto" alt="Car Image" style="max-height: 200px; object-fit: cover;">
                                            </div>
                                        @endforeach
                                    </div>
                                    <button class="carousel-control-prev" type="button" data-bs-target="#carImageCarousel" data-bs-slide="prev">
                                        <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                                        <span class="visually-hidden">Previous</span>
                                    </button>
                                    <button class="carousel-control-next" type="button" data-bs-target="#carImageCarousel" data-bs-slide="next">
                                        <span class="carousel-control-next-icon" aria-hidden="true"></span>
                                        <span class="visually-hidden">Next</span>
                                    </button>
                                    <div class="carousel-indicators">
                                        @foreach($booking->car->images as $key => $image)
                                            <button type="button" data-bs-target="#carImageCarousel" data-bs-slide-to="{{ $key }}"
                                                class="{{ $key == 0 ? 'active' : '' }}" aria-current="{{ $key == 0 ? 'true' : 'false' }}"
                                                aria-label="Slide {{ $key + 1 }}"></button>
                                        @endforeach
                                    </div>
                                </div>
                            </div>
                        @elseif(isset($booking->car->car_image) && !empty($booking->car->car_image))
                            <div class="text-center mb-3">
                                <img src="{{ asset($booking->car->car_image) }}" class="img-fluid rounded" alt="Car Image" style="max-height: 200px; object-fit: cover;">
                            </div>
                        @else
                            <div class="text-center mb-3">
                                <img src="{{ asset('carimage/defaultcar.jpg') }}" class="img-fluid rounded" alt="Car Image">
                            </div>
                        @endif
                        
                        <h5 class="mb-3">{{ $booking->car->maker }} {{ $booking->car->model }}</h5>
                        
                        <div class="car-details">
                            <p><i class="fas fa-car me-2"></i> <strong>Type:</strong> {{ $booking->car->vehicle_type ?? 'N/A' }}</p>
                            <p><i class="fas fa-tachometer-alt me-2"></i> <strong>Mileage:</strong> {{ number_format($booking->car->mileage ?? 0) }} km</p>
                            <p><i class="fas fa-gas-pump me-2"></i> <strong>Fuel Type:</strong> {{ $booking->car->fuel_type ?? 'N/A' }}</p>
                            <p><i class="fas fa-money-bill-wave me-2"></i> <strong>Daily Rate:</strong> BTN {{ number_format($booking->car->price ?? 0, 2) }}</p>
                        </div>
                        
                        <a href="#" class="btn btn-sm btn-outline-primary mt-2">
                            <i class="fas fa-info-circle"></i> View Car Details
                        </a>
                    @else
                        <p class="text-muted">Car information not available</p>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Update Status Modal -->
<div class="modal fade" id="updateStatusModal" tabindex="-1" aria-labelledby="updateStatusModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="updateStatusModalLabel">Update Booking Status</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="{{ route('admin.booked-car.update-status', $booking->id) }}" method="POST">
                @csrf
                @method('PUT')
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="status" class="form-label">Status</label>
                        <select name="status" id="status" class="form-select">
                            <option value="pending" {{ $booking->status == 'pending' ? 'selected' : '' }}>Pending</option>
                            <option value="confirmed" {{ $booking->status == 'confirmed' ? 'selected' : '' }}>Confirmed</option>
                            <option value="pending_verification" {{ $booking->status == 'pending_verification' ? 'selected' : '' }}>Pending Verification</option>
                            <option value="cancelled" {{ $booking->status == 'cancelled' ? 'selected' : '' }}>Cancelled</option>
                            <option value="completed" {{ $booking->status == 'completed' ? 'selected' : '' }}>Completed</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="comment" class="form-label">Comment (Optional)</label>
                        <textarea name="comment" id="comment" class="form-control" rows="3"></textarea>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Save Changes</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection