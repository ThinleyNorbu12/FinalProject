<!-- resources/views/layouts/partials/sidebars/admin-sidebar.blade.php -->
<div class="dashboard-sidebar">
    <div class="sidebar-header">
        <div class="logo">
            <img src="<?php echo e(asset('assets/images/logo.png')); ?>" alt="Logo">
            <h2>Admin Portal</h2>
        </div>
        <button id="sidebar-toggle" class="sidebar-toggle">
            <i class="fas fa-bars"></i>
        </button>
    </div>
    
    <div class="admin-profile">
        <?php if(Auth::guard('admin')->check()): ?>
            <div class="profile-avatar">
                
            </div>
            <div class="profile-info">
                <h3><?php echo e(Auth::guard('admin')->user()->name); ?></h3>
                <span>Administrator</span>
            </div>
        <?php endif; ?>
    </div>
    
    <nav class="sidebar-nav">
        <ul>
            <a href="<?php echo e(route('admin.dashboard')); ?>" class="sidebar-menu-item <?php echo e(request()->routeIs('admin.dashboard') ? 'active' : ''); ?>">
                <i class="fas fa-tachometer-alt"></i>
                <span>Dashboard</span>
            </a>
            
            <div class="sidebar-divider"></div>
            
            <div class="sidebar-heading">Car Owner</div>
            
            <a href="<?php echo e(route('car-admin.new-registration-cars')); ?>" class="sidebar-menu-item <?php echo e(request()->routeIs('car-admin.new-registration-cars') ? 'active' : ''); ?>">
                <i class="fas fa-car"></i>
                <span>Car Registration</span>
            </a>
            <a href="<?php echo e(route('car-admin.inspection-requests')); ?>" class="sidebar-menu-item <?php echo e(request()->routeIs('car-admin.inspection-requests') ? 'active' : ''); ?>">
                <i class="fas fa-clipboard-check"></i>
                <span>Inspection Requests</span>
            </a>
            <a href="<?php echo e(route('car-admin.approve-inspected-cars')); ?>" class="sidebar-menu-item <?php echo e(request()->routeIs('car-admin.approve-inspected-cars') ? 'active' : ''); ?>">
                <i class="fas fa-check-circle"></i>
                <span>Approve Inspections</span>
            </a>
            
            <div class="sidebar-divider"></div>
            
            <div class="sidebar-heading">Customer</div>
            
            <a href="<?php echo e(route('admin.verify-users')); ?>" class="sidebar-menu-item <?php echo e(request()->routeIs('admin.verify-users') ? 'active' : ''); ?>">
                <i class="fas fa-id-card"></i>
                <span>Verify Users</span>
            </a>
            <a href="<?php echo e(url('admin/view-payments')); ?>" class="sidebar-menu-item <?php echo e(request()->is('admin/view-payments') ? 'active' : ''); ?>">
                <i class="fas fa-credit-card"></i>
                <span>Payments</span>
            </a>
            <a href="<?php echo e(url('admin/update-car-registration')); ?>" class="sidebar-menu-item <?php echo e(request()->is('admin/update-car-registration') ? 'active' : ''); ?>">
                <i class="fas fa-edit"></i>
                <span>Update Registration</span>
            </a>
            <a href="<?php echo e(url('admin/car-information-update')); ?>" class="sidebar-menu-item <?php echo e(request()->is('admin/car-information-update') ? 'active' : ''); ?>">
                <i class="fas fa-info-circle"></i>
                <span>Car Information</span>
            </a>
            <a href="<?php echo e(url('admin/booked-car')); ?>" class="sidebar-menu-item <?php echo e(request()->is('admin/booked-car') ? 'active' : ''); ?>">
                <i class="fas fa-calendar-check"></i>
                <span>Booked Cars</span>
            </a>
            
            <a href="#" class="sidebar-menu-item" onclick="document.getElementById('logout-form').submit();">
                <i class="fas fa-sign-out-alt"></i>
                <span>Logout</span>
            </a>
            <form method="POST" action="<?php echo e(route('admin.logout')); ?>" id="logout-form">
                <?php echo csrf_field(); ?>
            </form>
        </ul>
    </nav>
</div><?php /**PATH C:\Users\Thinley Norbu\Documents\GitHub\FinalProject\resources\views/layouts/partials/sidebars/admin.blade.php ENDPATH**/ ?>