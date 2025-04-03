

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
            <li><a href="<?php echo e(route('car_owner_register')); ?>" >CAROWNER</a></li>
            <li><a href="<?php echo e(route('car_admin')); ?>" >ADMIN</a></li>
            <li><a href="<?php echo e(route('car_user_dashboard')); ?>">CUSTOMER</a></li>
            <li><a href="<?php echo e(route('contact')); ?>">CONTACT</a></li>
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
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\Sangay Ngedup\Documents\GitHub\FinalProject\resources\views/home.blade.php ENDPATH**/ ?>