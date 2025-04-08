


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
            <li><a href="<?php echo e(url('/car-admin')); ?>">ADMIN  DASHBOARD</a></li>
            <li><a href="<?php echo e(url('/customer')); ?>">CUSTOMER DASHBOARD</a></li>
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
    
    // Car owner authentication check
    document.addEventListener('DOMContentLoaded', function() {
        // Check if the carowner dashboard link exists
        const carOwnerLink = document.querySelector('a[href="<?php echo e(route("carowner.login")); ?>"]');
        
        if (carOwnerLink) {
            // Override the click behavior
            carOwnerLink.addEventListener('click', function(e) {
                // Check if user is logged in as car owner
                const isLoggedIn = <?php echo e(Auth::guard('carowner')->check() ? 'true' : 'false'); ?>;
                
                if (!isLoggedIn) {
                    e.preventDefault();
                    
                    // Create modal or alert
                    const modal = document.createElement('div');
                    modal.className = 'custom-modal';
                    modal.innerHTML = `
                        <div class="modal-content">
                            <h3>Car Owner Access Required</h3>
                            <p>You need to register or login as a car owner first.</p>
                            <div class="modal-buttons">
                                <a href="<?php echo e(route('carowner.register')); ?>" class="modal-btn register-btn">Register</a>
                                <a href="<?php echo e(route('carowner.login')); ?>" class="modal-btn login-btn">Login</a>
                            </div>
                        </div>
                    `;
                    
                    document.body.appendChild(modal);
                    
                    // Add style for the modal
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
                    
                    // Close modal when clicking outside
                    modal.addEventListener('click', function(event) {
                        if (event.target === modal) {
                            document.body.removeChild(modal);
                        }
                    });
                }
            });
        }
    });
</script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\Thinley Norbu\Documents\GitHub\FinalProject\resources\views/home.blade.php ENDPATH**/ ?>