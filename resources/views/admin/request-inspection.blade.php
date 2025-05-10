@extends('layouts.app')
 <link rel="stylesheet" href="{{ asset('assets/css/admin/dashboard.css') }}">
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
<div class="container mt-4">
    <h2 class="mb-4">Request for Car Inspection</h2>

    {{-- Success Message --}}
    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    {{-- Car Information --}}
    <div class="card mb-4">
        <div class="card-header bg-primary text-white">Car Details</div>
        <div class="card-body">
            <p><strong>Maker:</strong> {{ $car->maker }}</p>
            <p><strong>Model:</strong> {{ $car->model }}</p>
            <p><strong>Registration Number:</strong> {{ $car->registration_no }}</p>
        </div>
    </div>

    {{-- Car Owner Information --}}
    <div class="car-owner-info mt-4">
        <h4>Registered By:</h4>
        @if($car->owner)
            <p><strong>Name:</strong> {{ $car->owner->name }}</p>
            <p><strong>Email:</strong> {{ $car->owner->email }}</p>
        @else
            <p>Unknown Owner</p>
        @endif
    </div>

    {{-- Inspection Request Form --}}
    <form action="{{ url('car-admin/submit-inspection-request/' . $car->id) }}" method="POST">
        @csrf
        <div class="form-group">
            <label for="date">Inspection Date:</label>
            <input type="date" id="date" name="date" class="form-control" required>
        </div>

        <div class="form-group">
            <label for="time">Inspection Time:</label>
            <select id="time" name="time" class="form-control" required>
                <option value="">-- Select Date First --</option>
            </select>
        </div>

        <div class="form-group">
            <label for="location">Inspection Location:</label>
            <input type="text" id="location" name="location" class="form-control" required>
        </div>

        <div class="form-group">
            <label for="details">Additional Details:</label>
            <textarea id="details" name="details" class="form-control" rows="4"></textarea>
        </div>

        <button type="submit" class="btn btn-primary">Submit Inspection Request</button>
    </form>
</div>
{{-- Include jQuery --}}
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

<script>
    $('#date').on('change', function () {
    const selectedDate = $(this).val();

    $.ajax({
        url: "{{ route('car-admin.getAvailableTimes') }}",
        type: "GET",
        data: { date: selectedDate },
        success: function (response) {
            let options = '<option value="">-- Select Time Slot --</option>';

            if (response.length === 0) {
                options += '<option disabled>No available time slots</option>';
            } else {
                response.forEach(slot => {
                    options += `<option value="${slot}">${slot}</option>`;
                });
            }

            $('#time').html(options);
        },
        error: function () {
            alert('Failed to load time slots. Please try again.');
            $('#time').html('<option value="">-- Select Date First --</option>');
        }
    });
});

</script>


@endsection
