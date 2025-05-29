

<?php $__env->startSection('head'); ?>
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
        justify-content: space-between;
        padding: 0 20px;
        transition: all 0.3s ease;
    }

    #header.sidebar-open {
        left: 250px;
        width: calc(100% - 250px);
    }

    /* Header Left Section */
    .header-left {
        display: flex;
        align-items: center;
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

    /* Header Right Section */
    .header-right {
        display: flex;
        align-items: center;
        gap: 15px;
    }

    .header-auth-buttons {
        display: flex;
        align-items: center;
        gap: 10px;
    }

    .header-btn {
        padding: 8px 16px;
        border: none;
        border-radius: 5px;
        text-decoration: none;
        font-size: 14px;
        font-weight: 500;
        transition: all 0.3s ease;
        cursor: pointer;
        display: flex;
        align-items: center;
        gap: 5px;
    }

    .header-btn-login {
        background-color: transparent;
        color: #007bff;
        border: 1px solid #007bff;
    }

    .header-btn-login:hover {
        background-color: #007bff;
        color: white;
    }

    .header-btn-signup {
        background-color: #007bff;
        color: white;
        border: 1px solid #007bff;
    }

    .header-btn-signup:hover {
        background-color: #0056b3;
        border-color: #0056b3;
    }

    .header-btn-logout {
        background-color: #dc3545;
        color: white;
        border: 1px solid #dc3545;
    }

    .header-btn-logout:hover {
        background-color: #c82333;
        border-color: #c82333;
    }

    .user-welcome {
        color: #333;
        font-weight: 500;
        margin-right: 10px;
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

        .header-auth-buttons {
            gap: 5px;
        }

        .header-btn {
            padding: 6px 12px;
            font-size: 12px;
        }

        .user-welcome {
            font-size: 14px;
            margin-right: 5px;
        }
    }

    @media (max-width: 480px) {
        .header-right {
            gap: 8px;
        }

        .header-btn {
            padding: 5px 10px;
            font-size: 11px;
        }

        .user-welcome {
            display: none;
        }
    }

    /* Footer Styles */
.footer {
    background-color: #2c3e50;
    color: #ecf0f1;
    padding: 2rem 0 1rem;
    border-top: 3px solid #3498db;
    position: relative;
    bottom: 0;
    width: 100%;
    font-size: 14px;
    margin-top: auto;
    transition: margin-left 0.3s ease;
}

/* Footer when sidebar is open */
.footer.shifted {
    margin-left: 250px;
}

.footer .container {
    max-width: 1200px;
    margin: 0 auto;
    padding: 0 20px;
}

/* Footer content layout */
.footer-content {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
    gap: 2rem;
    margin-bottom: 1.5rem;
}

.footer-section h4 {
    color: #3498db;
    margin-bottom: 1rem;
    font-size: 1.1rem;
    font-weight: 600;
}

.footer-section ul {
    list-style: none;
    padding: 0;
    margin: 0;
}

.footer-section ul li {
    margin-bottom: 0.5rem;
}

.footer-section ul li a {
    color: #bdc3c7;
    text-decoration: none;
    transition: color 0.3s ease;
    display: flex;
    align-items: center;
    gap: 8px;
}

.footer-section ul li a:hover {
    color: #3498db;
}

.footer-section ul li a i {
    font-size: 14px;
    width: 16px;
}

/* Footer bottom section */
.footer-bottom {
    border-top: 1px solid #34495e;
    padding-top: 1rem;
    display: flex;
    justify-content: space-between;
    align-items: center;
    flex-wrap: wrap;
    gap: 1rem;
}

.footer-bottom p {
    margin: 0;
    color: #95a5a6;
}

.footer-social {
    display: flex;
    gap: 15px;
}

.footer-social a {
    color: #bdc3c7;
    font-size: 1.2rem;
    transition: color 0.3s ease;
}

.footer-social a:hover {
    color: #3498db;
}

/* Contact info styling */
.contact-info {
    display: flex;
    flex-direction: column;
    gap: 0.5rem;
}

.contact-item {
    display: flex;
    align-items: center;
    gap: 10px;
    color: #bdc3c7;
}

.contact-item i {
    color: #3498db;
    width: 16px;
    font-size: 14px;
}

/* Responsive design */
@media (max-width: 768px) {
    .footer {
        padding: 1.5rem 0 1rem;
    }
    
    .footer.shifted {
        margin-left: 0;
    }
    
    .footer-content {
        grid-template-columns: 1fr;
        gap: 1.5rem;
    }
    
    .footer-bottom {
        flex-direction: column;
        text-align: center;
    }
    
    .footer-social {
        justify-content: center;
    }
    
    .footer .container {
        padding: 0 15px;
    }
}

@media (max-width: 480px) {
    .footer {
        font-size: 13px;
    }
    
    .footer-section h4 {
        font-size: 1rem;
    }
    
    .footer-content {
        gap: 1rem;
    }
}

/* Alternative simple footer (if you prefer minimal design) */
.simple-footer {
    background-color: #f8f9fa;
    padding: 1.5rem 0;
    border-top: 1px solid #dee2e6;
    position: relative;
    bottom: 0;
    width: 100%;
    font-size: 14px;
    transition: margin-left 0.3s ease;
}

.simple-footer.shifted {
    margin-left: 250px;
}

.simple-footer .container {
    max-width: 1200px;
    margin: 0 auto;
    padding: 0 20px;
    display: flex;
    flex-wrap: wrap;
    justify-content: space-between;
    align-items: center;
}

.simple-footer p {
    margin: 0;
    color: #6c757d;
}

@media (max-width: 768px) {
    .simple-footer.shifted {
        margin-left: 0;
    }
    
    .simple-footer .container {
        flex-direction: column;
        text-align: center;
        gap: 0.5rem;
    }
}

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
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>
<!-- Header -->
<header id="header">
    <div class="header-left">
        <button id="toggle-btn" onclick="toggleSidebar()">
            <i class="fas fa-bars"></i>
        </button>
        <!-- <a href="<?php echo e(route('home')); ?>" class="header-brand d-none d-md-flex">
            <img src="<?php echo e(asset('assets/images/logo1.png')); ?>" alt="Logo" style="height: 70px !important;">
            <span style="font-size: 1.5rem !important; font-weight: 700 !important;">CAR RENTAL SYSTEM</span>
        </a> -->
        <div href="<?php echo e(route('home')); ?>" class="logo">
            <img src="<?php echo e(asset('assets/images/logo1.png')); ?>" alt="Logo" style="height: 60px !important;">
            <span style="font-size: 1.5rem !important; font-weight: 700 !important;">CAR RENTAL SYSTEM</span>
        </div>
    </div>
    
    <div class="header-right">
        <?php if(auth()->guard('customer')->check()): ?>
            <span class="user-welcome">
                <i class="fas fa-user"></i> Welcome, <?php echo e(Auth::guard('customer')->user()->name); ?>

            </span>
            <div class="header-auth-buttons">
                <a href="<?php echo e(route('customer.dashboard')); ?>" class="header-btn header-btn-login">
                    <i class="fas fa-tachometer-alt"></i> Dashboard
                </a>
                <form action="<?php echo e(route('customer.logout')); ?>" method="POST" style="display: inline;">
                    <?php echo csrf_field(); ?>
                    <button type="submit" class="header-btn header-btn-logout">
                        <i class="fas fa-sign-out-alt"></i> Logout
                    </button>
                </form>
            </div>
        <?php else: ?>
            <div class="header-auth-buttons">
                <a href="<?php echo e(route('customer.login')); ?>" class="header-btn header-btn-login">
                    <i class="fas fa-sign-in-alt"></i> Login
                </a>
                <a href="<?php echo e(route('customer.register')); ?>" class="header-btn header-btn-signup">
                    <i class="fas fa-user-plus"></i> Sign Up
                </a>
            </div>
        <?php endif; ?>
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
                <a href="<?php echo e(url('/')); ?>">
                    <i class="fas fa-home"></i>
                    <span style="text-transform: uppercase;">Home</span>
                </a>
            </li>
            <li>
                <a href="<?php echo e(route('carowner.login')); ?>">
                    <i class="fas fa-car"></i>
                    <span style="text-transform: uppercase;">Car Owner Dashboard</span>
                </a>
            </li>
            <li>
                <a href="<?php echo e(route('admin.dashboard')); ?>">
                    <i class="fas fa-user-shield"></i>
                    <span style="text-transform: uppercase;">Admin Dashboard</span>
                </a>
            </li>
            <?php if(auth()->guard('customer')->check()): ?>
                <li>
                    <a href="<?php echo e(route('customer.dashboard')); ?>">
                        <i class="fas fa-user"></i>
                        <span style="text-transform: uppercase;">Customer Dashboard</span>
                    </a>
                </li>
                <li>
                    <a href="#" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                        <i class="fas fa-sign-out-alt"></i>
                        <span style="text-transform: uppercase;">Logout</span>
                    </a>
                    <form id="logout-form" action="<?php echo e(route('customer.logout')); ?>" method="POST" style="display: none;">
                        <?php echo csrf_field(); ?>
                    </form>
                </li>
            <?php else: ?>
                <li>
                    <a href="<?php echo e(route('customer.login')); ?>">
                        <i class="fas fa-sign-in-alt"></i>
                        <span style="text-transform: uppercase;">Login as Customer</span>
                    </a>
                </li>
                <li>
                    <a href="<?php echo e(route('customer.register')); ?>">
                        <i class="fas fa-user-plus"></i>
                        <span style="text-transform: uppercase;">Register</span>
                    </a>
                </li>
            <?php endif; ?>
            
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
        <form action="<?php echo e(route('search.car')); ?>" method="GET">
            <!-- Pickup Location -->
            <input type="text" id="pickup_location" name="pickup_location" placeholder="Pickup Location" required style="margin: 5px; padding: 10px; width: 200px;">

            <!-- Pickup Date + Time -->
            <div style="display: inline-flex; align-items: center; gap: 5px;">
                <input type="date" id="pickup_date" name="pickup_date" required
                    style="margin: 5px; padding: 10px; width: 150px;"
                    min="<?php echo e(\Carbon\Carbon::today()->toDateString()); ?>">

                <select name="pickup_time" id="pickup_time" required style="margin: 5px; padding: 10px; width: 130px;">
                    <?php for($h = 0; $h < 24; $h++): ?>
                        <?php $__currentLoopData = ['00', '30']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $min): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <?php
                                $hour = str_pad($h, 2, '0', STR_PAD_LEFT);
                                $time = "$hour:$min";
                                $ampm = \Carbon\Carbon::createFromTime($h, $min)->format('h:i A');
                            ?>
                            <option value="<?php echo e($time); ?>" <?php echo e($time == '12:00' ? 'selected' : ''); ?>><?php echo e($ampm); ?></option>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    <?php endfor; ?>
                </select>
            </div>

            <!-- Drop-off Location -->
            <input type="text" id="dropoff_location" name="dropoff_location" placeholder="Drop-off Location" required style="margin: 5px; padding: 10px; width: 200px;" readonly>

            <!-- Drop-off Date + Time -->
            <div style="display: inline-flex; align-items: center; gap: 5px;">
                <input type="date" id="dropoff_date" name="dropoff_date" required
                    style="margin: 5px; padding: 10px; width: 150px;"
                    min="<?php echo e(\Carbon\Carbon::tomorrow()->toDateString()); ?>">

                <select name="dropoff_time" id="dropoff_time" required style="margin: 5px; padding: 10px; width: 130px;">
                    <?php for($h = 0; $h < 24; $h++): ?>
                        <?php $__currentLoopData = ['00', '30']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $min): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <?php
                                $hour = str_pad($h, 2, '0', STR_PAD_LEFT);
                                $time = "$hour:$min";
                                $ampm = \Carbon\Carbon::createFromTime($h, $min)->format('h:i A');
                            ?>
                            <option value="<?php echo e($time); ?>" <?php echo e($time == '12:00' ? 'selected' : ''); ?>><?php echo e($ampm); ?></option>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    <?php endfor; ?>
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
    <section class="cars">
        <h2>Available Cars</h2>
        <div class="car-container">
            <?php
                // Combine cars from both tables
                $allCars = collect();
                
                // Add regular cars
                if($cars->count()) {
                    foreach($cars as $car) {
                        // Check if car has confirmed booking
                        $hasConfirmedBooking = $car->bookings()
                            ->where('status', 'confirmed')
                            ->exists();
                            
                        if(!$hasConfirmedBooking) {
                            $car->source = 'regular'; // Mark source for image path logic
                            $allCars->push($car);
                        }
                    }
                }
                
                // Add admin cars (assuming you have $adminCars variable passed from controller)
                if(isset($adminCars) && $adminCars->count()) {
                    foreach($adminCars as $adminCar) {
                        // Check if admin car has confirmed booking (if booking system applies to admin cars)
                        // Adjust this logic based on your admin car booking system
                        $hasConfirmedBooking = false; // You may need to implement this check for admin cars
                        
                        if(!$hasConfirmedBooking) {
                            $adminCar->source = 'admin'; // Mark source for image path logic
                            $allCars->push($adminCar);
                        }
                    }
                }
            ?>
            
            <?php if($allCars->count()): ?>
                <?php $__currentLoopData = $allCars; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $car): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <div class="car">
                        <?php
                            // Handle image paths based on car source
                            if($car->source === 'admin') {
                                $imagePathUploads = 'uploads/admin_cars/' . $car->car_image;
                                $imagePathAdmin = 'admincar_images/' . $car->car_image;
                            } else {
                                $imagePathUploads = 'uploads/cars/' . $car->car_image;
                                $imagePathAdmin = 'admincar_images/' . $car->car_image;
                            }
                            
                            $imageExistsInUploads = $car->car_image && file_exists(public_path($imagePathUploads));
                            $imageExistsInAdmin = $car->car_image && file_exists(public_path($imagePathAdmin));
                        ?>
                        
                        <?php if($imageExistsInUploads): ?>
                            <img src="<?php echo e(asset($imagePathUploads)); ?>" alt="<?php echo e($car->maker); ?> <?php echo e($car->model); ?>" style="width: 200px; height: auto;">
                        <?php elseif($imageExistsInAdmin): ?>
                            <img src="<?php echo e(asset($imagePathAdmin)); ?>" alt="<?php echo e($car->maker); ?> <?php echo e($car->model); ?>" style="width: 200px; height: auto;">
                        <?php elseif($car->car_image): ?>
                            <!-- Fallback: try the direct path in case it's stored differently -->
                            <img src="<?php echo e(asset($car->car_image)); ?>" alt="<?php echo e($car->maker); ?> <?php echo e($car->model); ?>" style="width: 200px; height: auto;" onerror="this.style.display='none'; this.nextElementSibling.style.display='flex';">
                            <div style="width: 200px; height: 150px; background: linear-gradient(135deg, #bdc3c7 0%, #95a5a6 100%); display: none; align-items: center; justify-content: center; color: white; font-size: 2rem;">
                                <i class="fas fa-car"></i>
                            </div>
                        <?php else: ?>
                            <!-- No image placeholder -->
                            <div style="width: 200px; height: 150px; background: linear-gradient(135deg, #bdc3c7 0%, #95a5a6 100%); display: flex; align-items: center; justify-content: center; color: white; font-size: 2rem;">
                                <i class="fas fa-car"></i>
                            </div>
                        <?php endif; ?>
                        
                        <h3><?php echo e($car->maker); ?> <?php echo e($car->model); ?></h3>
                        <p>BTN <?php echo e(number_format($car->price, 2)); ?>/day</p>
                        
                        <?php if($car->source === 'admin'): ?>
                            <span class="admin-badge" style="background: #3498db; color: white; padding: 2px 8px; border-radius: 12px; font-size: 0.8em;">Admin Car</span>
                        <?php endif; ?>
                        
                        <div class="car-buttons">
                            <a href="#" class="btn-details" data-car-id="<?php echo e($car->id); ?>" data-car-source="<?php echo e($car->source); ?>">DETAILS</a>
                            <?php if($car->source === 'admin'): ?>
                                <a href="<?php echo e(route('book.admin.car', $car->id)); ?>" class="btn-contact">BOOK NOW</a>
                            <?php else: ?>
                                <a href="<?php echo e(route('book.car', $car->id)); ?>" class="btn-contact">BOOK NOW</a>
                            <?php endif; ?>
                        </div>
                    </div>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            <?php else: ?>
                <p>No cars available at the moment.</p>
            <?php endif; ?>
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
                    <i class="fas fa-door-open spec-icon"></i>
                    <span id="doors">4 Doors</span>
                </div>
                <div class="car-spec">
                    <i class="fas fa-users spec-icon"></i>
                    <span id="seats">7 Seats</span>
                </div>
            </div>
            <div class="car-specs-row">
                <div class="car-spec">
                    <i class="fas fa-snowflake spec-icon"></i>
                    <span id="ac">Air Conditioning</span>
                </div>
                <div class="car-spec">
                    <i class="fas fa-cogs spec-icon"></i>
                    <span id="transmission">Automatic</span>
                </div>
            </div>
            <div class="car-specs-row">
                <div class="car-spec">
                    <i class="fas fa-suitcase spec-icon"></i>
                    <span id="largeBags">2 Large Bags</span>
                </div>
                <div class="car-spec">
                    <i class="fas fa-briefcase spec-icon"></i>
                    <span id="smallBags">2 Small Bags</span>
                </div>
            </div>
            <div class="car-specs-row">
                <div class="car-spec">
                    <i class="fas fa-tachometer-alt spec-icon"></i>
                    <span id="mpg">16-21 mpg</span>
                </div>
                <div class="car-spec">
                    <i class="fab fa-bluetooth spec-icon"></i>
                    <span id="bluetooth">Bluetooth</span>
                </div>
            </div>
            <div class="car-specs-row">
                <div class="car-spec">
                    <i class="fas fa-video spec-icon"></i>
                    <span id="camera">Backup Camera</span>
                </div>
                <div class="car-spec">
                    <i class="fas fa-gas-pump spec-icon"></i>
                    <span id="fuelType">Gasoline</span>
                </div>
            </div>
        </div>
    </div>
</div>
<footer class="footer mt-auto py-3 bg-light">
    <div class="container">
        <div class="row">
            <div class="col-md-6">
                <p class="text-muted mb-0">&copy; <?php echo e(date('Y')); ?> Car Rental System. All rights reserved.</p>
            </div>
            <div class="col-md-6 text-md-end">
                <p class="text-muted mb-0">Version 1.0.0</p>
            </div>
        </div>
    </div>
</footer>
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
        const carOwnerLink = document.querySelector('a[href="<?php echo e(route("carowner.login")); ?>"]');

        if (carOwnerLink) {
            carOwnerLink.addEventListener('click', function(e) {
                const isLoggedIn = <?php echo e(Auth::guard('carowner')->check() ? 'true' : 'false'); ?>;

                if (!isLoggedIn) {
                    e.preventDefault();
                    showModal(
                        'Car Owner Access Required',
                        'You need to register or login as a car owner first.',
                        '<?php echo e(route("carowner.register")); ?>',
                        '<?php echo e(route("carowner.login")); ?>'
                    );
                }
            });
        }

        // Admin Modal
        const adminLink = document.querySelector('a[href="<?php echo e(route("admin.dashboard")); ?>"]');

        if (adminLink) {
            adminLink.addEventListener('click', function(e) {
                const isAdminLoggedIn = <?php echo e(Auth::guard('admin')->check() ? 'true' : 'false'); ?>;

                if (!isAdminLoggedIn) {
                    e.preventDefault();
                    showModal(
                        'Admin Access Required',
                        'You need to register or login as an admin first.',
                        '<?php echo e(route("admin.register")); ?>',
                        '<?php echo e(route("admin.login")); ?>'
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

<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\Sangay Ngedup\Documents\GitHub\FinalProject\resources\views/home.blade.php ENDPATH**/ ?>