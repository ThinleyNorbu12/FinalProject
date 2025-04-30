

<?php $__env->startSection('content'); ?>
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
            <li><a href="<?php echo e(route('carowner.login')); ?>">CAROWNER DASHBOARD</a></li>
            <li><a href="<?php echo e(route('admin.dashboard')); ?>">ADMIN DASHBOARD</a></li>
            <?php if(auth()->guard('customer')->check()): ?>
                <li><a href="<?php echo e(route('customer.dashboard')); ?>">CUSTOMER DASHBOARD</a></li>
            <?php else: ?>
                <li><a href="<?php echo e(route('customer.login')); ?>">LOGIN AS CUSTOMER</a></li>
            <?php endif; ?>
            <li><a href="<?php echo e(url('/contact')); ?>">CONTACT</a></li>
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

    
    

    <!-- Display Cars -->
    <section class="cars">
        <h2>Available Cars</h2>
        <div class="car-container">
            <?php if($cars->count()): ?>
                <?php $__currentLoopData = $cars; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $car): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <div class="car">
                        <img src="<?php echo e(asset($car->car_image)); ?>" alt="<?php echo e($car->model); ?>" style="width: 200px; height: auto;">
                        <h3><?php echo e($car->maker); ?> <?php echo e($car->model); ?></h3>
                        <p><?php echo e($car->price); ?>/day</p>
                        <div class="car-buttons">
                            <a href="#" class="btn-details" data-car-id="<?php echo e($car->id); ?>">DETAILS</a>
                            <a href="<?php echo e(route('book.car', $car->id)); ?>" class="btn-contact">BOOK NOW</a>
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

        sidebar.classList.toggle('open');
        mainContent.classList.toggle('shifted');
        header.classList.toggle('shifted');
        if (footer) {
            footer.classList.toggle('shifted');
        }
    }

    function searchCar() {
        alert("Searching for available cars...");
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
        const adminLink = document.querySelector('a[href="<?php echo e(url("/car-admin")); ?>"]');

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
                    <h3>${title}</h3>
                    <p>${message}</p>
                    <div class="modal-buttons">
                        <a href="${registerUrl}" class="modal-btn register-btn">Register</a>
                        <a href="${loginUrl}" class="modal-btn login-btn">Login</a>
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
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\Thinley Norbu\Documents\GitHub\FinalProject\resources\views/home.blade.php ENDPATH**/ ?>