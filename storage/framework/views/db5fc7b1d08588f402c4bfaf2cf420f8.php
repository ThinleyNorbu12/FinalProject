<!-- Sidebar Overlay -->
<div class="sidebar-overlay" id="sidebarOverlay"></div>

<!-- Dashboard Sidebar -->
<div class="dashboard-sidebar" id="dashboardSidebar">
    <!-- Enhanced Arrow Toggle Button -->
    <div class="sidebar-header">
        
    </div>

    <div class="admin-profile">
        <?php if(Auth::guard('admin')->check()): ?>
            <div class="profile-avatar">
                <img src="<?php echo e(asset('assets/images/thinley.jpg')); ?>" alt="Admin Avatar">
            </div>
            <div class="profile-info">
                <h3><?php echo e(Auth::guard('admin')->user()->name); ?></h3>
                <span>Administrator</span>
            </div>
        <?php endif; ?>
    </div>

    <div class="sidebar-menu">
        <a href="<?php echo e(route('admin.dashboard')); ?>" class="sidebar-menu-item active">
            <i class="fas fa-tachometer-alt"></i>
            <span>Dashboard</span>
        </a>
        
        <div class="sidebar-divider"></div>
        <div class="sidebar-heading">Manage Service</div>
        
        <a href="<?php echo e(route('cars.index')); ?>" class="sidebar-menu-item">
            <i class="fas fa-car"></i>
            <span>Cars</span>
            <div class="tooltip">Cars</div>
        </a>

        <div class="sidebar-divider"></div>
        <div class="sidebar-heading">Car Owner</div>

        <a href="<?php echo e(route('car-admin.new-registration-cars')); ?>" class="sidebar-menu-item">
            <i class="fas fa-car"></i>
            <span>Car Registration</span>
            <div class="tooltip">Car Registration</div>
        </a>

        <a href="<?php echo e(route('car-admin.inspection-requests')); ?>" class="sidebar-menu-item">
            <i class="fas fa-clipboard-check"></i>
            <span>Inspection Requests</span>
            <div class="tooltip">Inspection Requests</div>
        </a>

        <a href="<?php echo e(route('car-admin.approve-inspected-cars')); ?>" class="sidebar-menu-item">
            <i class="fas fa-check-circle"></i>
            <span>Approve Inspections</span>
            <div class="tooltip">Approve Inspections</div>
        </a>

        <div class="sidebar-divider"></div>
        <div class="sidebar-heading">Customer</div>

        <a href="<?php echo e(route('admin.verify-users')); ?>" class="sidebar-menu-item">
            <i class="fas fa-id-card"></i>
            <span>Verify Users</span>
            <div class="tooltip">Verify Users</div>
        </a>

        <a href="<?php echo e(route('admin.payments.index')); ?>" class="sidebar-menu-item">
            <i class="fas fa-credit-card"></i>
            <span>Payments</span>
            <div class="tooltip">Payments</div>
        </a>

        <a href="#" class="sidebar-menu-item">
            <i class="fas fa-edit"></i>
            <span>Update Registration</span>
            <div class="tooltip">Update Registration</div>
        </a>

        <a href="#" class="sidebar-menu-item">
            <i class="fas fa-info-circle"></i>
            <span>Car Information</span>
            <div class="tooltip">Car Information</div>
        </a>

        <a href="<?php echo e(route('admin.booked-car')); ?>" class="sidebar-menu-item">
            <i class="fas fa-calendar-check"></i>
            <span>Booked Cars</span>
            <div class="tooltip">Booked Cars</div>
        </a>

        <!-- Dark Mode Toggle -->
        <button class="dark-mode-toggle" id="darkModeToggle">
            <div class="toggle-text">
                <i class="fas fa-moon"></i>
                <span>Dark Mode</span>
            </div>
            <div class="toggle-switch" id="toggleSwitch">
                <div class="toggle-slider"></div>
            </div>
        </button>

        <a href="#" class="sidebar-menu-item" onclick="document.getElementById('sidebar-logout-form').submit();">
            <i class="fas fa-sign-out-alt"></i>
            <span>Logout</span>
            <div class="tooltip">Logout</div>
        </a>

        <form method="POST" action="<?php echo e(route('admin.logout')); ?>" id="sidebar-logout-form" style="display: none;">
            <?php echo csrf_field(); ?>
        </form>
    </div>
</div><?php /**PATH C:\Users\Sangay Ngedup\Documents\GitHub\FinalProject\resources\views/partials/admin/sidebar.blade.php ENDPATH**/ ?>