{{-- @extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('Dashboard') }}</div>

                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif

                    {{ __('You are logged in!') }}
                </div>
            </div>
        </div>
    </div>
</div>
@endsection --}}

@extends('layouts.app')

@section('content')
<!-- Header -->
<header id="header">
    <nav>
        <button onclick="toggleSidebar()">☰</button>   
    </nav>
</header>



<!-- Sidebar -->
<div id="sidebar" class="sidebar">
    <div id="sidebar-content" class="sidebar-content">
        <ul class="sidebar-links">
            <li><a href="{{ route('carowner.login') }}">CAROWNER DASHBOARD</a></li>
        <li><a href="{{ url('/car-admin') }}">ADMIN DASHBOARD</a></li>
        <li><a href="{{ url('/customer') }}" >CUSTOMER DASHBOARD</a></li>
        <li><a href="{{ url('/contact') }}">CONTACT</a></li>
        </ul>
    </div>
</div>


<!-- Main Content -->
<div id="main-content">
    <!-- Hero Section -->
    <section class="hero">
        <h1>Find Your Perfect Ride</h1>
        <p>Browse through our selection of top-quality rental cars.</p>
    </section>

    <!-- Search Form -->
    <section class="search">
        <form action="#" method="GET">
            <input type="text" name="pickup_location" placeholder="Pickup Location">
            <input type="date" name="pickup_date">
            <input type="text" name="dropoff_location" placeholder="Drop-off Location">
            <input type="date" name="dropoff_date">
        </form>
        <div style="text-align: center; margin-top: 10px;">
            <button onclick="searchCar()">Search Car</button>
        </div>
    </section>
</div>



<script>
    function toggleSidebar() {
        const sidebar = document.getElementById('sidebar');
        const mainContent = document.getElementById('main-content');
        const header = document.getElementById('header');
        const footer = document.getElementById('footer');
        
        // Toggle the sidebar open/close
        sidebar.classList.toggle('open');
        
        // Shift both header, footer, and content when sidebar is opened/closed
        mainContent.classList.toggle('shifted');
        header.classList.toggle('shifted');
        footer.classList.toggle('shifted');
    }

    function searchCar() {
        alert("Searching for available cars...");
    }
</script>
@endsection
