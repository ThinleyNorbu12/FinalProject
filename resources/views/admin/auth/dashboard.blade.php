{{-- @extends('layouts.app')


<!-- Link to the external CSS file -->
<link rel="stylesheet" href="{{ asset('assets/css/admin/dashboard.css') }}">

@section('content')
    <div class="container">
        <h1>Welcome to the Admin Dashboard</h1>

        @if(Auth::guard('admin')->check())
            <p>Hello, {{ Auth::guard('admin')->user()->name }}!</p>

            <form method="POST" action="{{ route('admin.logout') }}">
                @csrf
                <button type="submit" class="btn btn-danger">Logout</button>
            </form>

            <div class="links-container" style="margin-top: 20px;">
                <a href="{{ route('car-admin.new-registration-cars') }}">CAR REGISTRATION REQUEST FROM CAROWNER </a><br>
                <a href="{{ route('car-admin.inspection-requests') }}">MANAGE INSPECTION REQUEST FROM CAROWNER</a><br>
                <a href="{{ url('admin/view-payments') }}"> VIEW PAYMENTS</a><br>
                <a href="{{ url('admin/update-car-registration') }}">3. UPDATE CAR REGISTRATION</a><br>
                <a href="{{ url('admin/car-information-update') }}">4. CAR INFORMATION UPDATE</a><br>
                <a href="{{ url('admin/booked-car') }}">5. BOOKED CAR</a>
            </div>
            

        @else
            <p>You are not logged in as an admin.</p>
            <a href="{{ route('admin.login') }}" class="btn btn-primary">Login as Admin</a>
        @endif
    </div>
@endsection --}}
@extends('layouts.app')

<!-- Link to the external CSS file -->
<link rel="stylesheet" href="{{ asset('assets/css/admin/dashboard.css') }}">

@section('content')
    <div class="container">
        <div class="row">
            <!-- Left Panel: Profile Section -->
            <div class="col-md-4">
                <div class="profile-section">
                    <h2>Welcome to the Admin Dashboard</h2>

                    @if(Auth::guard('admin')->check())
                        <p>Hello, {{ Auth::guard('admin')->user()->name }}!</p>
                        <form method="POST" action="{{ route('admin.logout') }}">
                            @csrf
                            <button type="submit" class="btn btn-danger">Logout</button>
                        </form>
                    @else
                        <p>You are not logged in as Admin.</p>
                        <a href="{{ route('admin.login') }}" class="btn btn-primary">Login as Admin</a>
                    @endif
                </div>
            </div>

            <!-- Right Panel: Dashboard Links -->
            <div class="col-md-8">
                <div class="dashboard-links">
                    <p>Manage system operations and view key updates from car owners here.</p>

                    <div class="links-container">
                        <a href="{{ route('car-admin.new-registration-cars') }}" class="btn btn-primary"> CAR REGISTRATION REQUEST</a>
                        <a href="{{ route('car-admin.inspection-requests') }}" class="btn btn-primary"> MANAGE INSPECTION REQUESTS</a>
                        <a href="{{ route('car-admin.approve-inspected-cars') }}" class="btn btn-primary">APPROVE/REJECT INSPECTED CARS</a>
                        <a href="{{ url('admin/view-payments') }}" class="btn btn-primary">3. VIEW PAYMENTS</a>
                        <a href="{{ url('admin/update-car-registration') }}" class="btn btn-primary">4. UPDATE CAR REGISTRATION</a>
                        <a href="{{ url('admin/car-information-update') }}" class="btn btn-primary">5. CAR INFORMATION UPDATE</a>
                        <a href="{{ url('admin/booked-car') }}" class="btn btn-primary">6. BOOKED CAR</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
