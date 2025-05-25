@extends('layouts.app')

@section('head')
<!-- Additional styles for modern sidebar -->
 
<style>
    /* Main Layout Styles */
    body {
        transition: margin-left 0.3s ease;
        overflow-x: hidden;
    }

    body.sidebar-open {
        margin-left: 250px;
    }

    /* Header Styles */
    #header {
        position: fixed;
        top: 0;
        left: 0;
        width: 100%;
        height: 60px;
        background-color: #fff;
        box-shadow: 0 2px 4px rgba(0,0,0,0.1);
        z-index: 999;
        display: flex;
        align-items: center;
        padding: 0 20px;
        transition: all 0.3s ease;
    }

    #header.sidebar-open {
        left: 250px;
        width: calc(100% - 250px);
    }

    #toggle-btn {
        background: none;
        border: none;
        font-size: 24px;
        cursor: pointer;
        color: #333;
        margin-right: 20px;
        transition: all 0.3s;
    }

    #toggle-btn:hover {
        color: #007bff;
    }

    /* Modern Sidebar Styles */
    .sidebar {
        position: fixed;
        top: 0;
        left: -250px;
        width: 250px;
        height: 100%;
        background-color: #2c3e50;
        z-index: 1000;
        transition: all 0.3s ease;
        box-shadow: 3px 0 5px rgba(0,0,0,0.2);
        overflow-y: auto;
    }

    .sidebar.open {
        left: 0;
    }

    .sidebar-header {
        padding: 20px 15px;
        background-color: #1a2733;
        color: white;
        font-size: 22px;
        font-weight: bold;
        display: flex;
        align-items: center;
        justify-content: space-between;
        height: 60px;
    }

    .sidebar-header .close-btn {
        background: none;
        border: none;
        color: white;
        font-size: 24px;
        cursor: pointer;
    }

    .sidebar-content {
        padding: 15px 0;
    }

    .sidebar-links {
        list-style: none;
        padding: 0;
        margin: 0;
    }

    .sidebar-links li {
        margin-bottom: 5px;
    }

    .sidebar-links a {
        display: flex;
        align-items: center;
        padding: 12px 20px;
        color: rgba(255, 255, 255, 0.8);
        text-decoration: none;
        transition: all 0.3s;
        font-size: 15px;
    }

    .sidebar-links a:hover {
        background-color: #34495e;
        color: white;
        padding-left: 25px;
    }

    .sidebar-links i {
        margin-right: 15px;
        font-size: 18px;
        width: 20px;
        text-align: center;
    }

    .sidebar-divider {
        height: 1px;
        background-color: rgba(255, 255, 255, 0.1);
        margin: 15px 0;
    }

    /* Main Content Adjustment */
    #main-content {
        transition: margin-left 0.3s ease;
        margin-left: 0;
        padding-top: 80px; /* To account for the fixed header */
    }

    #main-content.shifted {
        margin-left: 250px;
    }

    /* Footer Adjustment */
    #footer {
        transition: margin-left 0.3s ease;
    }

    #footer.shifted {
        margin-left: 250px;
    }

    /* Overlay when sidebar is open on mobile */
    .sidebar-overlay {
        position: fixed;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background-color: rgba(0, 0, 0, 0.5);
        z-index: 999;
        display: none;
    }

    .sidebar-overlay.active {
        display: block;
    }

    /* Responsive Adjustments */
    @media (max-width: 768px) {
        body.sidebar-open {
            margin-left: 0;
        }

        #header.sidebar-open {
            left: 0;
            width: 100%;
        }

        #main-content.shifted {
            margin-left: 0;
        }

        #footer.shifted {
            margin-left: 0;
        }
    }
</style>
@endsection

@section('content')
<!-- Header -->
<header id="header">
    <button id="toggle-btn" onclick="toggleSidebar()">
        <i class="fas fa-bars"></i>
    </button>
    <div class="logo">
        <h3>Car Rental System</h3>
    </div>
</header>

<!-- Sidebar Overlay (for mobile) -->
<div class="sidebar-overlay" onclick="toggleSidebar()"></div>

<!-- Sidebar -->
<div id="sidebar" class="sidebar">
    <div class="sidebar-header">
        <span>Menu</span>
        <button class="close-btn" onclick="toggleSidebar()">
            <i class="fas fa-times"></i>
        </button>
    </div>
    <div class="sidebar-content">
        <ul class="sidebar-links">
            <li>
                <a href="{{ url('/') }}">
                    <i class="fas fa-home"></i>
                    <span>Home</span>
                </a>
            </li>
            <li>
                <a href="{{ route('carowner.login') }}">
                    <i class="fas fa-car"></i>
                    <span>Car Owner Dashboard</span>
                </a>
            </li>
            <li>
                <a href="{{ route('admin.dashboard') }}">
                    <i class="fas fa-user-shield"></i>
                    <span>Admin Dashboard</span>
                </a>
            </li>
            @auth('customer')
                <li>
                    <a href="{{ route('customer.dashboard') }}">
                        <i class="fas fa-user"></i>
                        <span>Customer Dashboard</span>
                    </a>
                </li>
                <li>
                    <a href="#" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                        <i class="fas fa-sign-out-alt"></i>
                        <span>Logout</span>
                    </a>
                    <form id="logout-form" action="{{ route('customer.logout') }}" method="POST" style="display: none;">
                        @csrf
                    </form>
                </li>
            @else
                <li>
                    <a href="{{ route('customer.login') }}">
                        <i class="fas fa-sign-in-alt"></i>
                        <span>Login as Customer</span>
                    </a>
                </li>
                <li>
                    <a href="{{ route('customer.register') }}">
                        <i class="fas fa-user-plus"></i>
                        <span>Register</span>
                    </a>
                </li>
            @endauth
            
            <div class="sidebar-divider"></div>
            
            <li>
                <a href="{{ url('/contact') }}">
                    <i class="fas fa-envelope"></i>
                    <span>Contact</span>
                </a>
            </li>
            <li>
                <a href="{{ url('/available-cars') }}">
                    <i class="fas fa-car-side"></i>
                    <span>Browse Cars</span>
                </a>
            </li>
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
    <section class="search" style="padding: 20px; text-align: center;">
        <form action="{{ route('search.car') }}" method="GET">
            <!-- Pickup Location -->
            <input type="text" id="pickup_location" name="pickup_location" placeholder="Pickup Location" required style="margin: 5px; padding: 10px; width: 200px;">

            <!-- Pickup Date + Time -->
            <div style="display: inline-flex; align-items: center; gap: 5px;">
                <input type="date" id="pickup_date" name="pickup_date" required
                    style="margin: 5px; padding: 10px; width: 150px;"
                    min="{{ \Carbon\Carbon::today()->toDateString() }}">

                <select name="pickup_time" id="pickup_time" required style="margin: 5px; padding: 10px; width: 130px;">
                    @for ($h = 0; $h < 24; $h++)
                        @foreach (['00', '30'] as $min)
                            @php
                                $hour = str_pad($h, 2, '0', STR_PAD_LEFT);
                                $time = "$hour:$min";
                                $ampm = \Carbon\Carbon::createFromTime($h, $min)->format('h:i A');
                            @endphp
                            <option value="{{ $time }}" {{ $time == '12:00' ? 'selected' : '' }}>{{ $ampm }}</option>
                        @endforeach
                    @endfor
                </select>
            </div>

            <!-- Drop-off Location -->
            <input type="text" id="dropoff_location" name="dropoff_location" placeholder="Drop-off Location" required style="margin: 5px; padding: 10px; width: 200px;" readonly>

            <!-- Drop-off Date + Time -->
            <div style="display: inline-flex; align-items: center; gap: 5px;">
                <input type="date" id="dropoff_date" name="dropoff_date" required
                    style="margin: 5px; padding: 10px; width: 150px;"
                    min="{{ \Carbon\Carbon::tomorrow()->toDateString() }}">

                <select name="dropoff_time" id="dropoff_time" required style="margin: 5px; padding: 10px; width: 130px;">
                    @for ($h = 0; $h < 24; $h++)
                        @foreach (['00', '30'] as $min)
                            @php
                                $hour = str_pad($h, 2, '0', STR_PAD_LEFT);
                                $time = "$hour:$min";
                                $ampm = \Carbon\Carbon::createFromTime($h, $min)->format('h:i A');
                            @endphp
                            <option value="{{ $time }}" {{ $time == '12:00' ? 'selected' : '' }}>{{ $ampm }}</option>
                        @endforeach
                    @endfor
                </select>
            </div>

            <!-- Search Button -->
            <div style="margin-top: 10px;">
                <button type="submit" style="padding: 10px 20px; background-color: #007bff; color: white; border: none; border-radius: 5px;">
                    Search Car
                </button>
            </div>
        </form>
    </section>

    <script>
        // Autofill dropoff location
        document.getElementById('pickup_location').addEventListener('input', function () {
            document.getElementById('dropoff_location').value = this.value + ' (Return)';
        });

        // Update dropoff date min
        document.getElementById('pickup_date').addEventListener('change', function () {
            const pickupDate = new Date(this.value);
            pickupDate.setDate(pickupDate.getDate() + 1);
            const dropoffDateInput = document.getElementById('dropoff_date');
            dropoffDateInput.min = pickupDate.toISOString().split('T')[0];
        });
    </script>

    <!-- Display Cars -->
    <!-- <section class="cars">
        <h2>Available Cars</h2>
        <div class="car-container">
            @if($cars->count())
                @foreach($cars as $car)
                    <div class="car">
                        <img src="{{ asset($car->car_image) }}" alt="{{ $car->model }}" style="width: 200px; height: auto;">
                        <h3>{{ $car->maker }} {{ $car->model }}</h3>
                        <p>{{ $car->price }}/day</p>
                        <div class="car-buttons">
                            <a href="#" class="btn-details" data-car-id="{{ $car->id }}">DETAILS</a>
                            <a href="{{ route('book.car', $car->id) }}" class="btn-contact">BOOK NOW</a>
                        </div>
                    </div>
                @endforeach
            @else
                <p>No cars available at the moment.</p>
            @endif
        </div>
    </section> -->
    <section class="cars">
        <h2>Available Cars</h2>
        <div class="car-container">
            @if($cars->count())
                @foreach($cars as $car)
                    <div class="car">
                        @php
                            $imagePathUploads = 'uploads/cars/' . $car->car_image;
                            $imagePathAdmin = 'admincar_images/' . $car->car_image;
                            $imageExistsInUploads = $car->car_image && file_exists(public_path($imagePathUploads));
                            $imageExistsInAdmin = $car->car_image && file_exists(public_path($imagePathAdmin));
                        @endphp

                        @if($imageExistsInUploads)
                            <img src="{{ asset($imagePathUploads) }}" alt="{{ $car->maker }} {{ $car->model }}" style="width: 200px; height: auto;">
                        @elseif($imageExistsInAdmin)
                            <img src="{{ asset($imagePathAdmin) }}" alt="{{ $car->maker }} {{ $car->model }}" style="width: 200px; height: auto;">
                        @elseif($car->car_image)
                            <!-- Fallback: try the direct path in case it's stored differently -->
                            <img src="{{ asset($car->car_image) }}" alt="{{ $car->maker }} {{ $car->model }}" style="width: 200px; height: auto;" onerror="this.style.display='none'; this.nextElementSibling.style.display='flex';">
                            <div style="width: 200px; height: 150px; background: linear-gradient(135deg, #bdc3c7 0%, #95a5a6 100%); display: none; align-items: center; justify-content: center; color: white; font-size: 2rem;">
                                <i class="fas fa-car"></i>
                            </div>
                        @else
                            <!-- No image placeholder -->
                            <div style="width: 200px; height: 150px; background: linear-gradient(135deg, #bdc3c7 0%, #95a5a6 100%); display: flex; align-items: center; justify-content: center; color: white; font-size: 2rem;">
                                <i class="fas fa-car"></i>
                            </div>
                        @endif

                        <h3>{{ $car->maker }} {{ $car->model }}</h3>
                        <p>${{ number_format($car->price, 2) }}/day</p>
                        <div class="car-buttons">
                            <a href="#" class="btn-details" data-car-id="{{ $car->id }}">DETAILS</a>
                            <a href="{{ route('book.car', $car->id) }}" class="btn-contact">BOOK NOW</a>
                        </div>
                    </div>
                @endforeach
            @else
                <p>No cars available at the moment.</p>
            @endif
        </div>
    </section>
    
</div>

<!-- Car Details Modal -->
<div id="carDetailsModal" class="car-details-modal">
    <div class="modal-content">
        <span class="close-modal">&times;</span>
        <h2 id="modalCarTitle">Car Details</h2>
        <div class="car-specs-container">
            <div class="car-specs-row">
                <div class="car-spec">
                    <i class="spec-icon">🚘</i>
                    <span id="doors">4 Doors</span>
                </div>
                <div class="car-spec">
                    <i class="spec-icon">👤</i>
                    <span id="seats">7 Seats</span>
                </div>
            </div>
            <div class="car-specs-row">
                <div class="car-spec">
                    <i class="spec-icon">❄️</i>
                    <span id="ac">Air Conditioning</span>
                </div>
                <div class="car-spec">
                    <i class="spec-icon">🔄</i>
                    <span id="transmission">Automatic</span>
                </div>
            </div>
            <div class="car-specs-row">
                <div class="car-spec">
                    <i class="spec-icon">🧳</i>
                    <span id="largeBags">2 Large Bags</span>
                </div>
                <div class="car-spec">
                    <i class="spec-icon">💼</i>
                    <span id="smallBags">2 Small Bags</span>
                </div>
            </div>
            <div class="car-specs-row">
                <div class="car-spec">
                    <i class="spec-icon">⛽</i>
                    <span id="mpg">16-21 mpg</span>
                </div>
                <div class="car-spec">
                    <i class="spec-icon">🔵</i>
                    <span id="bluetooth">Bluetooth</span>
                </div>
            </div>
            <div class="car-specs-row">
                <div class="car-spec">
                    <i class="spec-icon">📹</i>
                    <span id="camera">Backup Camera</span>
                </div>
                <div class="car-spec">
                    <i class="spec-icon">⛽</i>
                    <span id="fuelType">Gasoline</span>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    function toggleSidebar() {
        const sidebar = document.getElementById('sidebar');
        const mainContent = document.getElementById('main-content');
        const header = document.getElementById('header');
        const footer = document.getElementById('footer');
        const body = document.body;
        const overlay = document.querySelector('.sidebar-overlay');

        sidebar.classList.toggle('open');
        mainContent.classList.toggle('shifted');
        header.classList.toggle('sidebar-open');
        body.classList.toggle('sidebar-open');
        overlay.classList.toggle('active');
        
        if (footer) {
            footer.classList.toggle('shifted');
        }
    }

    document.addEventListener('DOMContentLoaded', function() {
        // Car Owner Modal
        const carOwnerLink = document.querySelector('a[href="{{ route("carowner.login") }}"]');

        if (carOwnerLink) {
            carOwnerLink.addEventListener('click', function(e) {
                const isLoggedIn = {{ Auth::guard('carowner')->check() ? 'true' : 'false' }};

                if (!isLoggedIn) {
                    e.preventDefault();
                    showModal(
                        'Car Owner Access Required',
                        'You need to register or login as a car owner first.',
                        '{{ route("carowner.register") }}',
                        '{{ route("carowner.login") }}'
                    );
                }
            });
        }

        // Admin Modal
        const adminLink = document.querySelector('a[href="{{ route("admin.dashboard") }}"]');

        if (adminLink) {
            adminLink.addEventListener('click', function(e) {
                const isAdminLoggedIn = {{ Auth::guard('admin')->check() ? 'true' : 'false' }};

                if (!isAdminLoggedIn) {
                    e.preventDefault();
                    showModal(
                        'Admin Access Required',
                        'You need to register or login as an admin first.',
                        '{{ route("admin.register") }}',
                        '{{ route("admin.login") }}'
                    );
                }
            });
        }

        // Car Details Modal
        const detailButtons = document.querySelectorAll('.btn-details');
        const carDetailsModal = document.getElementById('carDetailsModal');
        const closeModal = document.querySelector('.close-modal');

        detailButtons.forEach(button => {
            button.addEventListener('click', function(e) {
                e.preventDefault();
                const carId = this.getAttribute('data-car-id');
                
                // Show loading state
                document.getElementById('modalCarTitle').textContent = "Loading...";
                carDetailsModal.style.display = 'block';
                
                // Fetch car details from the server
                fetchCarDetails(carId);
            });
        });

        if (closeModal) {
            closeModal.addEventListener('click', function() {
                carDetailsModal.style.display = 'none';
            });
        }

        // Close modal when clicking outside
        window.addEventListener('click', function(event) {
            if (event.target === carDetailsModal) {
                carDetailsModal.style.display = 'none';
            }
        });

        function fetchCarDetails(carId) {
            console.log('Fetching details for car ID:', carId);
            fetch(`/cars/${carId}/details`)
                .then(response => {
                    console.log('Response status:', response.status);
                    if (!response.ok) {
                        throw new Error('Network response was not ok');
                    }
                    return response.json();
                })
                .then(data => {
                    console.log('Received data:', data);
                    if (data.success) {
                        showCarDetails(data.details);
                    } else {
                        throw new Error(data.message || 'Error fetching car details');
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    document.getElementById('modalCarTitle').textContent = "Error loading details";
                });
        }

        function showCarDetails(carData) {
            // Update the modal with car details from the database
            document.getElementById('modalCarTitle').textContent = carData.title;
            document.getElementById('doors').textContent = carData.doors;
            document.getElementById('seats').textContent = carData.seats;
            document.getElementById('ac').textContent = carData.ac;
            document.getElementById('transmission').textContent = carData.transmission;
            document.getElementById('largeBags').textContent = carData.largeBags;
            document.getElementById('smallBags').textContent = carData.smallBags;
            document.getElementById('mpg').textContent = carData.mpg;
            document.getElementById('bluetooth').textContent = carData.bluetooth;
            document.getElementById('camera').textContent = carData.camera;
            document.getElementById('fuelType').textContent = carData.fuelType;
        }

        function showModal(title, message, registerUrl, loginUrl) {
            const modal = document.createElement('div');
            modal.className = 'custom-modal';
            modal.innerHTML = `
                <div class="modal-content">
                    <h2>${title}</h2>
                    <p>${message}</p>
                    <div class="modal-buttons">
                        <a href="${registerUrl}" class="modal-btn register-btn">
                            <i class="fas fa-user-plus"></i> Register
                        </a>
                        <a href="${loginUrl}" class="modal-btn login-btn">
                            <i class="fas fa-sign-in-alt"></i> Login
                        </a>
                    </div>
                </div>
            `;
            document.body.appendChild(modal);

            modal.addEventListener('click', function(event) {
                if (event.target === modal) {
                    document.body.removeChild(modal);
                }
            });

            if (!document.getElementById('modal-style')) {
                const style = document.createElement('style');
                style.id = 'modal-style';
                style.textContent = `
                    .custom-modal {
                        position: fixed;
                        top: 0;
                        left: 0;
                        width: 100%;
                        height: 100%;
                        background-color: rgba(0,0,0,0.6);
                        display: flex;
                        align-items: center;
                        justify-content: center;
                        z-index: 1000;
                        font-family: Arial, sans-serif;
                    }
                    .modal-content {
                        background-color: #fff;
                        padding: 30px;
                        border-radius: 10px;
                        box-shadow: 0 0 10px rgba(0,0,0,0.2);
                        text-align: center;
                        max-width: 400px;
                        width: 90%;
                    }
                    .modal-content h2 {
                        margin-bottom: 15px;
                        color: #333;
                    }
                    .modal-content p {
                        margin-bottom: 25px;
                        color: #555;
                    }
                    .modal-buttons {
                        display: flex;
                        justify-content: center;
                        gap: 20px;
                    }
                    .modal-btn {
                        display: inline-flex;
                        align-items: center;
                        gap: 8px;
                        padding: 10px 20px;
                        border-radius: 5px;
                        text-decoration: none;
                        font-weight: bold;
                        font-size: 14px;
                        transition: background-color 0.3s ease;
                    }
                    .register-btn {
                        background-color: #4CAF50;
                        color: white;
                    }
                    .register-btn:hover {
                        background-color: #45a049;
                    }
                    .login-btn {
                        background-color: #2196F3;
                        color: white;
                    }
                    .login-btn:hover {
                        background-color: #1976d2;
                    }
                `;
                document.head.appendChild(style);
            }
        }

    });
</script>

<style>
    /* Car Details Modal Styles */
    .car-details-modal {
        display: none;
        position: fixed;
        z-index: 1000;
        left: 0;
        top: 0;
        width: 100%;
        height: 100%;
        overflow: auto;
        background-color: rgba(0,0,0,0.5);
    }

    .car-details-modal .modal-content {
        background-color: #f8f8f8;
        margin: 10% auto;
        padding: 20px;
        border-radius: 8px;
        width: 80%;
        max-width: 600px;
        box-shadow: 0 5px 15px rgba(0,0,0,0.3);
    }

    .close-modal {
        color: #aaa;
        float: right;
        font-size: 28px;
        font-weight: bold;
        cursor: pointer;
    }

    .close-modal:hover,
    .close-modal:focus {
        color: black;
        text-decoration: none;
        cursor: pointer;
    }

    .car-specs-container {
        display: flex;
        flex-direction: column;
        gap: 15px;
        margin-top: 20px;
        background-color: #f0f0f0;
        padding: 15px;
        border-radius: 5px;
    }

    .car-specs-row {
        display: flex;
        justify-content: space-between;
    }

    .car-spec {
        display: flex;
        align-items: center;
        gap: 10px;
        width: 48%;
        background-color: white;
        padding: 10px;
        border-radius: 5px;
        box-shadow: 0 2px 4px rgba(0,0,0,0.1);
    }

    .spec-icon {
        font-style: normal;
        font-size: 18px;
    }

    #modalCarTitle {
        text-align: center;
        margin-bottom: 20px;
    }
</style>
@endsection