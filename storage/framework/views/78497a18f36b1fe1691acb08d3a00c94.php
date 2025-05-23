<!-- Enhanced Admin Header -->
<header class="admin-header" id="adminHeader">
    <div class="header-left">
        <button class="mobile-menu-toggle d-md-none" id="mobileMenuToggle">
            <i class="fas fa-bars"></i>
        </button>
        
        <a href="<?php echo e(route('admin.dashboard')); ?>" class="header-brand d-none d-md-flex">
            <img src="<?php echo e(asset('assets/images/logo.png')); ?>" alt="Logo">
            <span>Car Rental System</span>
        </a>

        <div class="header-search d-none d-lg-block">
            <i class="fas fa-search"></i>
            <input type="text" placeholder="Search anything...">
        </div>
    </div>

    <div class="header-actions">
        <div class="header-action-item" title="Notifications">
            <i class="fas fa-bell"></i>
            <span class="badge">3</span>
        </div>
        
        <div class="header-action-item" title="Messages">
            <i class="fas fa-envelope"></i>
            <span class="badge">5</span>
        </div>

        <?php if(Auth::guard('admin')->check()): ?>
            <div class="header-profile dropdown">
                <a class="nav-link dropdown-toggle d-flex align-items-center" href="#" role="button" id="userDropdown"
                   data-bs-toggle="dropdown" aria-expanded="false">
                    <img src="<?php echo e(asset('assets/images/thinley.jpg')); ?>" alt="Admin Avatar"
                         class="rounded-circle me-2" width="32" height="32">
                    <div class="header-profile-info d-none d-sm-block">
                        <h4 class="mb-0"><?php echo e(Auth::guard('admin')->user()->name); ?></h4>
                        <span>Administrator</span>
                    </div>
                </a>
                
                <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="userDropdown">
                    <li>
                        <a class="dropdown-item" href="<?php echo e(route('admin.profile')); ?>">
                            <i class="fas fa-user me-2"></i> Profile
                        </a>
                    </li>
                    <li><hr class="dropdown-divider"></li>
                    <li>
                        <a class="dropdown-item" href="#"
                           onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                            <i class="fas fa-sign-out-alt me-2"></i> Logout
                        </a>
                        <form id="logout-form" action="<?php echo e(route('admin.logout')); ?>" method="POST" class="d-none">
                            <?php echo csrf_field(); ?>
                        </form>
                    </li>
                </ul>
            </div>
        <?php else: ?>
            <a href="<?php echo e(route('admin.login')); ?>" class="btn btn-primary">Login</a>
        <?php endif; ?>
    </div>
</header><?php /**PATH C:\Users\Sangay Ngedup\Documents\GitHub\FinalProject\resources\views/partials/admin/header.blade.php ENDPATH**/ ?>