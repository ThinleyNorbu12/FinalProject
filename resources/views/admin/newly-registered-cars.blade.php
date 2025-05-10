@extends('layouts.app')

@section('content')
 <link rel="stylesheet" href="{{ asset('assets/css/admin/dashboard.css') }}">
<link rel="stylesheet" href="{{ asset('assets/css/admin/newly-registered-cars.css') }}">
    
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
                {{-- <img src="{{ asset('assets/images/avatar-placeholder.jpg') }}" alt="Admin Avatar"> --}}
            </div>
            <div class="profile-info">
                <h3>{{ Auth::guard('admin')->user()->name }}</h3>
                <span>Administrator</span>
            </div>
        @endif
    </div>
    
    <nav class="sidebar-nav">
        <ul>
            <a href="{{ route('admin.dashboard') }}" class="sidebar-menu-item {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
                <i class="fas fa-tachometer-alt"></i>
                <span>Dashboard</span>
            </a>
    
            <div class="sidebar-divider"></div>
    
            <div class="sidebar-heading">Car Owner</div>
    
            <a href="{{ route('car-admin.new-registration-cars') }}" class="sidebar-menu-item {{ request()->routeIs('car-admin.new-registration-cars') ? 'active' : '' }}">
                <i class="fas fa-car"></i>
                <span>Car Registration</span>
            </a>
            <a href="{{ route('car-admin.inspection-requests') }}" class="sidebar-menu-item {{ request()->routeIs('car-admin.inspection-requests') ? 'active' : '' }}">
                <i class="fas fa-clipboard-check"></i>
                <span>Inspection Requests</span>
            </a>
            <a href="{{ route('car-admin.approve-inspected-cars') }}" class="sidebar-menu-item {{ request()->routeIs('car-admin.approve-inspected-cars') ? 'active' : '' }}">
                <i class="fas fa-check-circle"></i>
                <span>Approve Inspections</span>
            </a>
    
            <div class="sidebar-divider"></div>
    
            <div class="sidebar-heading">Customer</div>
    
            <a href="{{ route('admin.verify-users') }}" class="sidebar-menu-item {{ request()->routeIs('admin.verify-users') || request()->routeIs('admin.user-verification.*') ? 'active' : '' }}">
                <i class="fas fa-id-card"></i>
                <span>Verify Users</span>
            </a>
            <a href="{{ url('admin/view-payments') }}" class="sidebar-menu-item {{ request()->routeIs('admin.view-payments') ? 'active' : '' }}">
                <i class="fas fa-credit-card"></i>
                <span>Payments</span>
            </a>
            <a href="{{ url('admin/update-car-registration') }}" class="sidebar-menu-item {{ request()->routeIs('admin.update-car-registration') ? 'active' : '' }}">
                <i class="fas fa-edit"></i>
                <span>Update Registration</span>
            </a>
            <a href="{{ url('admin/car-information-update') }}" class="sidebar-menu-item {{ request()->routeIs('admin.car-information-update') ? 'active' : '' }}">
                <i class="fas fa-info-circle"></i>
                <span>Car Information</span>
            </a>
            <a href="{{ url('admin/booked-car') }}" class="sidebar-menu-item {{ request()->routeIs('admin.booked-car') ? 'active' : '' }}">
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
<div class="container">
        <h1>Car Registration Request</h1>

        @if($cars->isEmpty())
            <p>No cars found.</p>
        @else
            <table class="table">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Maker</th>
                        <th>Model</th>
                        <th>Vehicle Type</th>
                        <th>Price per Day</th>
                        <th>Registration Number</th>
                        <th>Status</th>
                        <th>Car Image</th> <!-- Image Column -->
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($cars as $car)
                        <tr>
                            <td>{{ $car->id }}</td>
                            <td>{{ $car->maker }}</td>
                            <td>{{ $car->model }}</td>
                            <td>{{ $car->vehicle_type }}</td>
                            <td>{{ $car->price }}</td>
                            <td>{{ $car->registration_no }}</td>
                            <td>{{ $car->status }}</td>
                            <td>
                                <!-- Display Car Image -->
                                @if($car->car_image)
                                    <img src="{{ asset($car->car_image) }}" alt="Car Image" style="width: 100px; height: auto;">
                                @else
                                    <p>No image</p>
                                @endif
                            </td>
                            <td>
                                @if(strtolower($car->status) === 'rejected')
                                    <span class="text-danger">Rejected</span>
                                @else
                                    <a href="{{ route('car-admin.view-car', $car->id) }}" class="btn btn-info">View</a>
                                @endif
                            </td>                            
                        </tr>
                    @endforeach
                </tbody>
            </table>
        @endif
</div>
@endsection
