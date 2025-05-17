

<?php $__env->startSection('content'); ?>
<link rel="stylesheet" href="<?php echo e(asset('assets/css/admin/newly-registered-cars.css')); ?>">
    
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
                <img src="<?php echo e(asset('assets/images/thinley.jpg')); ?>" alt="Admin Avatar">
            </div>
            <div class="profile-info">
                <h3><?php echo e(Auth::guard('admin')->user()->name); ?></h3>
                <span>Administrator</span>
            </div>
        <?php endif; ?>
    </div>
    
    <nav class="sidebar-nav">
        <ul>
            <li>
                <a href="<?php echo e(route('admin.dashboard')); ?>" class="sidebar-menu-item">
                    <i class="fas fa-tachometer-alt"></i>
                    <span>Dashboard</span>
                </a>
            </li>
    
            <div class="sidebar-divider"></div>
    
            <div class="sidebar-heading">Car Owner</div>
    
            <li>
                <a href="<?php echo e(route('car-admin.new-registration-cars')); ?>" class="sidebar-menu-item active">
                    <i class="fas fa-car"></i>
                    <span>Car Registration</span>
                </a>
            </li>
            <li>
                <a href="<?php echo e(route('car-admin.inspection-requests')); ?>" class="sidebar-menu-item">
                    <i class="fas fa-clipboard-check"></i>
                    <span>Inspection Requests</span>
                </a>
            </li>
            <li>
                <a href="<?php echo e(route('car-admin.approve-inspected-cars')); ?>" class="sidebar-menu-item">
                    <i class="fas fa-check-circle"></i>
                    <span>Approve Inspections</span>
                </a>
            </li>
    
            <div class="sidebar-divider"></div>
    
            <div class="sidebar-heading">Customer</div>
    
            <li>
                <a href="<?php echo e(route('admin.verify-users')); ?>" class="sidebar-menu-item">
                    <i class="fas fa-id-card"></i>
                    <span>Verify Users</span>
                </a>
            </li>
            <li>
                <a href="<?php echo e(route('admin.payments.index')); ?>" class="sidebar-menu-item">
                    <i class="fas fa-credit-card"></i>
                    <span>Payments</span>
                </a>
            </li>
            <li>
                <a href="<?php echo e(url('admin/update-car-registration')); ?>" class="sidebar-menu-item">
                    <i class="fas fa-edit"></i>
                    <span>Update Registration</span>
                </a>
            </li>
            <li>
                <a href="<?php echo e(url('admin/car-information-update')); ?>" class="sidebar-menu-item">
                    <i class="fas fa-info-circle"></i>
                    <span>Car Information</span>
                </a>
            </li>
            <li>
                <a href="<?php echo e(url('admin/booked-car')); ?>" class="sidebar-menu-item">
                    <i class="fas fa-calendar-check"></i>
                    <span>Booked Cars</span>
                </a>
            </li>
    
            <li>
                <a href="#" class="sidebar-menu-item" onclick="document.getElementById('logout-form').submit();">
                    <i class="fas fa-sign-out-alt"></i>
                    <span>Logout</span>
                </a>
                <form method="POST" action="<?php echo e(route('admin.logout')); ?>" id="logout-form">
                    <?php echo csrf_field(); ?>
                </form>
            </li>
        </ul>
    </nav>        
</div>

<div class="container">
    <h1>Car Registration Request</h1>

    <?php if($cars->isEmpty()): ?>
        <div class="empty-message">
            <i class="fas fa-car fa-3x mb-3" style="color: #ccc;"></i>
            <p>No cars found.</p>
        </div>
    <?php else: ?>
        <div class="table-container">
            <div class="table-responsive">
                <table class="table">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Maker</th>
                            <th>Model</th>
                            <th>Vehicle Type</th>
                            <th>Price per Day</th>
                            <th>Registration Number</th>
                            <th>Status</th>
                            <th>Car Image</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $__currentLoopData = $cars; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $car): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <tr>
                                <td><?php echo e($car->id); ?></td>
                                <td><?php echo e($car->maker); ?></td>
                                <td><?php echo e($car->model); ?></td>
                                <td><?php echo e($car->vehicle_type); ?></td>
                                <td><?php echo e($car->price); ?></td>
                                <td><?php echo e($car->registration_no); ?></td>
                                <td>
                                    <span class="status-<?php echo e(strtolower($car->status)); ?>">
                                        <?php echo e($car->status); ?>

                                    </span>
                                </td>
                                <td>
                                    <?php if($car->car_image): ?>
                                        <img src="<?php echo e(asset($car->car_image)); ?>" alt="Car Image">
                                    <?php else: ?>
                                        <p>No image</p>
                                    <?php endif; ?>
                                </td>
                                <td>
                                    <?php if(strtolower($car->status) === 'rejected'): ?>
                                        <span class="text-danger">Rejected</span>
                                    <?php else: ?>
                                        <a href="<?php echo e(route('car-admin.view-car', $car->id)); ?>" class="btn btn-info">
                                            <i class="fas fa-eye"></i> View
                                        </a>
                                    <?php endif; ?>
                                </td>                            
                            </tr>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </tbody>
                </table>
            </div>
        </div>
    <?php endif; ?>
</div>


<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">


<script>
    // responsive-dashboard.js

    document.addEventListener('DOMContentLoaded', function() {
        // Elements
        const sidebarToggle = document.getElementById('sidebar-toggle');
        const sidebar = document.querySelector('.dashboard-sidebar');
        const body = document.body;
        
        // Create overlay element for mobile
        const overlay = document.createElement('div');
        overlay.className = 'sidebar-overlay';
        document.body.appendChild(overlay);
        
        // Function to check window width and set appropriate classes
        function checkWindowSize() {
            if (window.innerWidth < 992) {
                // Mobile view - sidebar starts hidden
                sidebar.classList.remove('collapsed');
                body.classList.remove('sidebar-collapsed');
                
                // Store current state
                sidebar.setAttribute('data-state', 'closed');
            } else {
                // Desktop view - check previous state
                const savedState = localStorage.getItem('sidebarState');
                if (savedState === 'collapsed') {
                    sidebar.classList.add('collapsed');
                    body.classList.add('sidebar-collapsed');
                } else {
                    sidebar.classList.remove('collapsed');
                    body.classList.remove('sidebar-collapsed');
                }
                
                // Store current state
                sidebar.setAttribute('data-state', savedState || 'open');
            }
        }

        // Initialize
        checkWindowSize();
        
        // Toggle sidebar on button click
        sidebarToggle.addEventListener('click', function() {
            if (window.innerWidth < 992) {
                // Mobile view - show/hide via transform
                if (sidebar.classList.contains('mobile-open')) {
                    // Close sidebar
                    sidebar.classList.remove('mobile-open');
                    overlay.classList.remove('active');
                    sidebar.setAttribute('data-state', 'closed');
                } else {
                    // Open sidebar
                    sidebar.classList.add('mobile-open');
                    overlay.classList.add('active');
                    sidebar.setAttribute('data-state', 'open');
                }
            } else {
                // Desktop view - collapse/expand
                if (sidebar.classList.contains('collapsed')) {
                    // Expand sidebar
                    sidebar.classList.remove('collapsed');
                    body.classList.remove('sidebar-collapsed');
                    localStorage.setItem('sidebarState', 'open');
                    sidebar.setAttribute('data-state', 'open');
                } else {
                    // Collapse sidebar
                    sidebar.classList.add('collapsed');
                    body.classList.add('sidebar-collapsed');
                    localStorage.setItem('sidebarState', 'collapsed');
                    sidebar.setAttribute('data-state', 'collapsed');
                }
            }
        });
        
        // Close sidebar when clicking on overlay
        overlay.addEventListener('click', function() {
            sidebar.classList.remove('mobile-open');
            overlay.classList.remove('active');
        });
        
        // Close sidebar when clicking on a menu item (mobile only)
        const menuItems = document.querySelectorAll('.sidebar-menu-item');
        menuItems.forEach(item => {
            item.addEventListener('click', function() {
                if (window.innerWidth < 992 && sidebar.classList.contains('mobile-open')) {
                    sidebar.classList.remove('mobile-open');
                    overlay.classList.remove('active');
                }
            });
        });
        
        // Listen for window resize
        window.addEventListener('resize', function() {
            checkWindowSize();
            
            // Additional handling for transition between mobile/desktop
            if (window.innerWidth >= 992) {
                // Switching to desktop
                sidebar.classList.remove('mobile-open');
                overlay.classList.remove('active');
            }
        });
        
        // Initialize Bootstrap tooltips if Bootstrap is loaded
        if (typeof bootstrap !== 'undefined' && bootstrap.Tooltip) {
            const tooltipTriggerList = document.querySelectorAll('[data-bs-toggle="tooltip"]');
            [...tooltipTriggerList].map(tooltipTriggerEl => new bootstrap.Tooltip(tooltipTriggerEl));
        }
    });
</script>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\Thinley Norbu\Documents\GitHub\FinalProject\resources\views/admin/newly-registered-cars.blade.php ENDPATH**/ ?>