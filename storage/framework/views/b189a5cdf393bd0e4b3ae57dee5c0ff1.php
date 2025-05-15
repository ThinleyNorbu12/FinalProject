<!-- resources/views/layouts/admin-layout.blade.php -->
<!DOCTYPE html>
<html lang="<?php echo e(str_replace('_', '-', app()->getLocale())); ?>">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="<?php echo e(csrf_token()); ?>">
    
    <title><?php echo e(config('app.name', 'Car Rental System')); ?> - Admin</title>
    
    <!-- Fonts -->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Nunito:wght@400;600;700&display=swap">
    
    <!-- Styles -->
    
    <link rel="stylesheet" href="<?php echo e(asset('assets/css/admin-style.css')); ?>">
    <link rel="stylesheet" href="<?php echo e(asset('assets/css/admin-layout.css')); ?>">

    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    
    <!-- Scripts -->
    
    
    <?php echo $__env->yieldPushContent('styles'); ?>
</head>
<body class="admin-dashboard">
    <div class="dashboard-container">
        <!-- Sidebar -->
        <?php echo $__env->make('layouts.partials.sidebars.admin', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
        
        <div class="dashboard-content">
            <!-- Header -->
            <?php echo $__env->make('layouts.partials.headers.admin', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
            
            <!-- Main Content -->
            <main class="main-content">
                <?php echo $__env->yieldContent('content'); ?>
            </main>
            
            <!-- Footer -->
            <?php echo $__env->make('layouts.partials.footers.admin', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
        </div>
    </div>
    
    <!-- Scripts -->
    <script>
        // Toggle sidebar on mobile
        document.addEventListener('DOMContentLoaded', function() {
            const sidebarToggle = document.getElementById('sidebar-toggle');
            const mobileSidebarToggle = document.getElementById('mobile-sidebar-toggle');
            const dashboardSidebar = document.querySelector('.dashboard-sidebar');
            const dashboardContent = document.querySelector('.dashboard-content');
            
            if (sidebarToggle) {
                sidebarToggle.addEventListener('click', function() {
                    dashboardSidebar.classList.toggle('collapsed');
                    dashboardContent.classList.toggle('expanded');
                });
            }
            
            if (mobileSidebarToggle) {
                mobileSidebarToggle.addEventListener('click', function() {
                    dashboardSidebar.classList.toggle('mobile-open');
                });
            }
            
            // Close dropdown menus when clicking outside
            document.addEventListener('click', function(event) {
                const dropdowns = document.querySelectorAll('.dropdown');
                dropdowns.forEach(function(dropdown) {
                    if (!dropdown.contains(event.target)) {
                        const menu = dropdown.querySelector('.dropdown-menu');
                        if (menu) {
                            menu.style.display = 'none';
                        }
                    }
                });
            });
            
            // Toggle dropdown menus
            const dropdownToggles = document.querySelectorAll('.dropdown-toggle');
            dropdownToggles.forEach(function(toggle) {
                toggle.addEventListener('click', function(event) {
                    event.preventDefault();
                    event.stopPropagation();
                    const menu = this.nextElementSibling;
                    if (menu) {
                        menu.style.display = menu.style.display === 'block' ? 'none' : 'block';
                    }
                });
            });
        });

        /* Adding the JavaScript for dropdowns */
document.addEventListener('DOMContentLoaded', function() {
    // Toggle dropdown menus
    const dropdownToggles = document.querySelectorAll('.dropdown-toggle');
    
    dropdownToggles.forEach(toggle => {
        toggle.addEventListener('click', function(e) {
            e.preventDefault();
            e.stopPropagation();
            
            // Close all other open dropdowns
            document.querySelectorAll('.dropdown').forEach(dropdown => {
                if (dropdown !== this.closest('.dropdown')) {
                    dropdown.querySelector('.dropdown-menu').classList.remove('show');
                }
            });
            
            // Toggle current dropdown
            const dropdownMenu = this.closest('.dropdown').querySelector('.dropdown-menu');
            dropdownMenu.classList.toggle('show');
        });
    });
    
    // Close dropdowns when clicking outside
    document.addEventListener('click', function(e) {
        if (!e.target.closest('.dropdown')) {
            document.querySelectorAll('.dropdown-menu').forEach(menu => {
                menu.classList.remove('show');
            });
        }
    });
    
    // Mobile sidebar toggle
    const sidebarToggle = document.getElementById('mobile-sidebar-toggle');
    if (sidebarToggle) {
        sidebarToggle.addEventListener('click', function() {
            document.body.classList.toggle('sidebar-open');
        });
    }
});
    </script>
    
    <?php echo $__env->yieldPushContent('scripts'); ?>
</body>
</html><?php /**PATH C:\Users\Thinley Norbu\Documents\GitHub\FinalProject\resources\views/layouts/admin-layout.blade.php ENDPATH**/ ?>