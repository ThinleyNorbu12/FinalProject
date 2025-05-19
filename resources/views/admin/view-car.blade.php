@extends('layouts.app')
 <link rel="stylesheet" href="{{ asset('assets/css/admin/adminsidebar.css') }}">
@section('content')
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

            <a href="{{ route('car-admin.new-registration-cars') }}" class="sidebar-menu-item active">
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

            <a href="{{ route('admin.booked-car') }}" class="sidebar-menu-item">
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

<div class="container">
    <h1>Car Details</h1>

    {{-- Car Image --}}
    @if($car->car_image)
        <div class="mb-3">
            <img src="{{ asset($car->car_image) }}" alt="Car Image" style="width: 200px; height: auto;">
        </div>
    @else
        <p>No image available</p>
    @endif

    {{-- Car Information --}}
    <div class="car-details">
        <p><strong>Car Maker:</strong> {{ $car->maker }}</p>
        <p><strong>Model:</strong> {{ $car->model }}</p>
        <p><strong>Vehicle Type:</strong> {{ $car->vehicle_type }}</p>
        <p><strong>Condition:</strong> {{ $car->car_condition }}</p>
        <p><strong>Mileage:</strong> {{ $car->mileage }} km</p>
        <p><strong>Price per Day:</strong> ${{ $car->price }} per day</p>
        <p><strong>Registration Number:</strong> {{ $car->registration_no }}</p>
        <p><strong>Status:</strong> {{ $car->status }}</p>
        <p><strong>Description:</strong> {{ $car->description }}</p>
    </div>

    {{-- Admin Actions --}}
    <div class="car-actions mt-4">
        <form action="{{ route('car-admin.admin.requestInspection', ['car' => $car->id]) }}" method="GET" class="d-inline">
            <button type="submit" class="btn btn-primary">Request for Inspection</button>
        </form>

        <form action="{{ route('car-admin.showRejectForm', ['car' => $car->id]) }}" method="GET" class="d-inline">
            <button type="submit" class="btn btn-danger">Reject</button>
        </form>
    </div>
</div>
@endsection
