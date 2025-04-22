@extends('layouts.app')

<!-- Link to the external CSS file -->
<link rel="stylesheet" href="{{ asset('assets/css/carowner/dashboard.css') }}">

@section('content')
    <div class="container">
        <div class="row">
            <!-- First Container: Profile Section -->
            <div class="col-md-4">
                <div class="profile-section">
                    <h2>Welcome to the Car Owner Dashboard</h2>

                    @if(Auth::guard('carowner')->check())
                        <p>Hello, {{ Auth::guard('carowner')->user()->name }}!</p>
                        <form method="POST" action="{{ route('carowner.logout') }}">
                            @csrf
                            <button type="submit" class="btn btn-danger">Logout</button>
                        </form>
                    @else
                        <p>Hello, Guest!</p>
                    @endif
                </div>
            </div>

            <!-- Second Container: Dashboard Links -->
            <div class="col-md-8">
                <div class="dashboard-links">
                    <p>This is where car owners can manage their cars.</p>

                    <!-- Wrap the links in a div container for styling -->
                    <div class="links-container">
                        <a href="{{ url('CarOwner/rent-car') }}" class="btn btn-primary">1. RENT A CAR</a>
                        <a href="{{ url('carowner/view-rented-car') }}" class="btn btn-primary">2. VIEW CAR REGISTRARION REQUEST</a>  <!--VIEW RENTED CAR change to VIEW REGISTRARION REQUEST -->
                        <a href="{{ url('carowner/car-inspection') }}" class="btn btn-primary position-relative">CAR INSPECTION REQUEST FROM ADMIN</a>
                        <a href="{{ url('carowner/car-approval-denied') }}" class="btn btn-primary">4. CAR APPROVAL DENIED</a>
                        <a href="{{ url('carowner/approved-car') }}" class="btn btn-primary">5. APPROVED CAR</a>
                        <a href="{{ url('carowner/payment-summary') }}" class="btn btn-primary">6. PAYMENT SUMMARY</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
