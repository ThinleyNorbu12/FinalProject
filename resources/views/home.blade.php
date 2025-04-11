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
            <li><a href="{{ route('carowner.login') }}" id="carowner-link">CAROWNER DASHBOARD</a></li>
            <li><a href="{{ url('/car-admin') }}" id="admin-link">ADMIN DASHBOARD</a></li>
            <li><a href="{{ url('/customer') }}">CUSTOMER DASHBOARD</a></li>
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

        sidebar.classList.toggle('open');
        mainContent.classList.toggle('shifted');
        header.classList.toggle('shifted');
        if (footer) footer.classList.toggle('shifted');
    }

    function searchCar() {
        alert("Searching for available cars...");
    }

    document.addEventListener('DOMContentLoaded', function () {
        // === CAR OWNER DASHBOARD CHECK ===
        const carOwnerLink = document.getElementById('carowner-link');
        if (carOwnerLink) {
            carOwnerLink.addEventListener('click', function (e) {
                const isCarOwnerLoggedIn = {{ Auth::guard('carowner')->check() ? 'true' : 'false' }};
                if (!isCarOwnerLoggedIn) {
                    e.preventDefault();
                    showModal('Car Owner Access Required', 'You need to register or login as a car owner first.', '{{ route('carowner.register') }}', '{{ route('carowner.login') }}');
                }
            });
        }

        // === ADMIN DASHBOARD CHECK ===
        const adminLink = document.getElementById('admin-link');
        if (adminLink) {
            adminLink.addEventListener('click', function (e) {
                const isAdminLoggedIn = {{ Auth::guard('admin')->check() ? 'true' : 'false' }};
                if (!isAdminLoggedIn) {
                    e.preventDefault();
                    showModal('Admin Access Required', 'You need to register or login as an admin first.', '{{ route('admin.register') }}', '{{ route('admin.login') }}');
                }
            });
        }

        // === MODAL FUNCTION ===
        function showModal(title, message, registerUrl, loginUrl) {
            const modal = document.createElement('div');
            modal.className = 'custom-modal';
            modal.innerHTML = `
                <div class="modal-content">
                    <h3>${title}</h3>
                    <p>${message}</p>
                    <div class="modal-buttons">
                        <a href="${registerUrl}" class="modal-btn register-btn">Register</a>
                        <a href="${loginUrl}" class="modal-btn login-btn">Login</a>
                    </div>
                </div>
            `;
            document.body.appendChild(modal);

            const style = document.createElement('style');
            style.textContent = `
                .custom-modal {
                    position: fixed;
                    top: 0;
                    left: 0;
                    width: 100%;
                    height: 100%;
                    background-color: rgba(0,0,0,0.5);
                    display: flex;
                    align-items: center;
                    justify-content: center;
                    z-index: 1000;
                }
                .modal-content {
                    background-color: white;
                    padding: 30px;
                    border-radius: 5px;
                    text-align: center;
                    max-width: 400px;
                }
                .modal-buttons {
                    display: flex;
                    justify-content: center;
                    gap: 20px;
                    margin-top: 20px;
                }
                .modal-btn {
                    padding: 10px 20px;
                    border-radius: 5px;
                    text-decoration: none;
                    font-weight: bold;
                }
                .register-btn {
                    background-color: #4CAF50;
                    color: white;
                }
                .login-btn {
                    background-color: #2196F3;
                    color: white;
                }
            `;
            document.head.appendChild(style);

            modal.addEventListener('click', function (event) {
                if (event.target === modal) {
                    document.body.removeChild(modal);
                }
            });
        }
    });
</script>
@endsection
