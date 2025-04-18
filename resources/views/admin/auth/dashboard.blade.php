@extends('layouts.app')


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
                <a href="{{ route('car-admin.new-registration-cars') }}">1. CAR REGISTRATION REQUEST </a><br>
                <a href="{{ url('car-admin/view-payments') }}">2. VIEW PAYMENTS</a><br>
                <a href="{{ url('car-admin/update-car-registration') }}">3. UPDATE CAR REGISTRATION</a><br>
                <a href="{{ url('car-admin/car-information-update') }}">4. CAR INFORMATION UPDATE</a><br>
                <a href="{{ url('car-admin/booked-car') }}">5. BOOKED CAR</a>
            </div>
            

        @else
            <p>You are not logged in as an admin.</p>
            <a href="{{ route('admin.login') }}" class="btn btn-primary">Login as Admin</a>
        @endif
    </div>
@endsection
