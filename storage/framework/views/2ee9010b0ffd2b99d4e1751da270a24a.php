

<?php $__env->startSection('content'); ?>

<!-- Fonts and Icons -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
<link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
<link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">
<link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" rel="stylesheet">

<!-- Custom CSS -->
<link rel="stylesheet" href="<?php echo e(asset('assets/css/admin/inspection-approval.css')); ?>">
<link rel="stylesheet" href="<?php echo e(asset('assets/css/admin/adminsidebar.css')); ?>">
<link rel="stylesheet" href="<?php echo e(asset('assets/css/admin/darkmode.css')); ?>">
<style>
    /* Inspection Approval Styles */
.container {
    padding: 2rem;
    margin-left: 280px; /* Match sidebar width */
    transition: all 0.3s ease;
}

/* Table Styles */
.table {
    background: #fff;
    border-radius: 8px;
    overflow: hidden;
    box-shadow: 0 1px 3px rgba(0,0,0,0.1);
}

.table thead th {
    background: #2c3e50;
    color: #fff;
    font-weight: 600;
    border-bottom: 2px solid #34495e;
}

.table-hover tbody tr:hover {
    background-color: #f8f9fa;
}

.table td, .table th {
    vertical-align: middle;
    padding: 1rem;
    border-color: #dee2e6;
}

/* Alert Styles */
.alert {
    border-radius: 8px;
    padding: 1rem 1.5rem;
    margin-bottom: 2rem;
}

.alert-success {
    background: #d4edda;
    border-color: #c3e6cb;
    color: #155724;
}

.alert-info {
    background: #d1ecf1;
    border-color: #bee5eb;
    color: #0c5460;
}

/* Button Styles */
.btn {
    padding: 0.5rem 1rem;
    border-radius: 5px;
    font-weight: 500;
    transition: all 0.2s ease;
}

.btn-success {
    background: #28a745;
    border-color: #28a745;
}

.btn-success:hover {
    background: #218838;
    border-color: #1e7e34;
}

.btn-danger {
    background: #dc3545;
    border-color: #dc3545;
}

.btn-danger:hover {
    background: #c82333;
    border-color: #bd2130;
}

.btn-sm {
    padding: 0.4rem 0.8rem;
    font-size: 0.875rem;
}

/* Badge Styles */
.badge {
    padding: 0.35em 0.65em;
    font-size: 0.75em;
    font-weight: 700;
    border-radius: 0.25rem;
}

/* Responsive Adjustments */
@media (max-width: 992px) {
    .container {
        margin-left: 0;
        padding: 1rem;
    }
    
    .table-responsive {
        border: 0;
    }
    
    .table thead {
        display: none;
    }
    
    .table tr {
        display: block;
        margin-bottom: 1rem;
        border-radius: 8px;
        box-shadow: 0 1px 3px rgba(0,0,0,0.1);
    }
    
    .table td {
        display: flex;
        justify-content: space-between;
        align-items: center;
        padding: 0.75rem;
        font-size: 0.9rem;
    }
    
    .table td::before {
        content: attr(data-label);
        font-weight: 600;
        margin-right: 1rem;
        flex: 1;
    }
    
    .table td:last-child {
        border-bottom: 0;
    }
}

/* Dark Mode Overrides */
.dark-mode .table {
    background: #2d3748;
    color: #fff;
}

.dark-mode .table thead th {
    background: #1a202c;
    border-color: #2d3748;
}

.dark-mode .table-hover tbody tr:hover {
    background-color: #4a5568;
}

.dark-mode .alert-success {
    background: #2b5935;
    border-color: #23482d;
    color: #c3e6cb;
}

.dark-mode .alert-info {
    background: #2b4e59;
    border-color: #23434d;
    color: #bee5eb;
}
</style>
<!-- Admin Header -->
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
                <a class="nav-link dropdown-toggle d-flex align-items-center" href="#" role="button"
                   id="userDropdown" data-bs-toggle="dropdown" aria-expanded="false">
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
                        <a class="dropdown-item" href="#" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
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
</header>

<!-- Admin Dashboard -->
<div class="admin-dashboard" id="adminDashboard">

    <!-- Sidebar Overlay -->
    <div class="sidebar-overlay" id="sidebarOverlay"></div>

    <!-- Sidebar -->
    <div class="dashboard-sidebar" id="dashboardSidebar">

        <div class="sidebar-header">
            
        </div>

        <?php if(Auth::guard('admin')->check()): ?>
            <div class="admin-profile">
                <div class="profile-avatar">
                    <img src="<?php echo e(asset('assets/images/thinley.jpg')); ?>" alt="Admin Avatar">
                </div>
                <div class="profile-info">
                    <h3><?php echo e(Auth::guard('admin')->user()->name); ?></h3>
                    <span>Administrator</span>
                </div>
            </div>
        <?php endif; ?>

        <div class="sidebar-menu">
            <a href="<?php echo e(route('admin.dashboard')); ?>" class="sidebar-menu-item">
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

            <a href="#" class="sidebar-menu-item" onclick="document.getElementById('logout-form').submit();">
                <i class="fas fa-sign-out-alt"></i>
                <span>Logout</span>
                <div class="tooltip">Logout</div>
            </a>

            <form method="POST" action="<?php echo e(route('admin.logout')); ?>" id="logout-form" style="display: none;">
                <?php echo csrf_field(); ?>
            </form>
        </div>
    </div>
</div>


<div class="container">
    <h2 class="mb-4 text-center">Approve or Reject Inspected Cars</h2>

    <?php if(session('status')): ?>
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <?php echo e(session('status')); ?>

            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    <?php endif; ?>

    <?php if($inspectionRequests->count() > 0): ?>
        <div class="table-responsive">
            <table class="table table-bordered table-hover align-middle text-center">
                <thead class="table-dark">
                    <tr>
                        <th>Sl. No</th>
                        <th>Request ID</th>
                        <th>Car</th>
                        <th>Reg. No.</th>
                        <th>Owner Email</th>
                        <th>Inspection Date</th>
                        <th>Time</th>
                        <th>Location</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php $__currentLoopData = $inspectionRequests; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $request): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <tr>
                            <td><?php echo e($loop->iteration); ?></td>
                            <td><?php echo e($request->id); ?></td>
                            <td><?php echo e($request->car->maker ?? 'N/A'); ?> <?php echo e($request->car->model ?? ''); ?></td>
                            <td><?php echo e($request->car->registration_no ?? 'N/A'); ?></td>
                            <td><?php echo e($request->car->owner->email ?? 'N/A'); ?></td>
                            <td><?php echo e(\Carbon\Carbon::parse($request->inspection_date)->format('d M Y')); ?></td>
                            <?php
                                $timeRange = $request->inspection_time;
                                $formattedTime = $timeRange;

                                if (strpos($timeRange, ' - ') !== false) {
                                    [$startTime, $endTime] = explode(' - ', $timeRange);
                                    try {
                                        $formattedStart = \Carbon\Carbon::parse($startTime)->format('h:i A');
                                        $formattedEnd = \Carbon\Carbon::parse($endTime)->format('h:i A');
                                        $formattedTime = $formattedStart . ' - ' . $formattedEnd;
                                    } catch (Exception $e) {
                                        $formattedTime = $timeRange;
                                    }
                                }
                            ?>
                            <td><?php echo e($formattedTime); ?></td>
                            <td><?php echo e($request->location ?? 'N/A'); ?></td>
                            <td>
                                <form action="<?php echo e(route('car-admin.inspection-approval')); ?>" method="POST" class="d-flex justify-content-center gap-2">
                                    <?php echo csrf_field(); ?>
                                    <input type="hidden" name="car_id" value="<?php echo e($request->car->id); ?>">
                                    <input type="hidden" name="inspection_request_id" value="<?php echo e($request->id); ?>">
                                    
                                    <button type="submit" name="decision" value="approved" class="btn btn-success btn-sm" data-bs-toggle="tooltip" title="Approve this car">
                                        <i class="bi bi-check-circle"></i>
                                    </button>

                                    <button type="submit" name="decision" value="rejected" class="btn btn-danger btn-sm" data-bs-toggle="tooltip" title="Reject this car">
                                        <i class="bi bi-x-circle"></i>
                                    </button>
                                </form>
                            </td>
                        </tr>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </tbody>
            </table>
        </div>
    <?php else: ?>
        <div class="alert alert-info text-center">No confirmed inspection requests pending approval.</div>
    <?php endif; ?>
</div>

<footer class="admin-footer" id="adminFooter">
    <div class="footer-left">
        <div class="footer-copy">
            <p class="mb-0">&copy; <?php echo e(date('Y')); ?> Car Rental System. All rights reserved.</p>
        </div>
    </div>
        
    <div class="footer-right">
        <div class="footer-status">
            <span class="status-dot"></span>
            System Online
        </div>
        <div class="footer-copy">
            Version 2.1.0
        </div>
    </div>
</footer>


<link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">


<script>
        document.addEventListener('DOMContentLoaded', function() {
        // Sidebar toggle functionality
        const sidebarToggle = document.getElementById('sidebar-toggle');
        const sidebar = document.querySelector('.dashboard-sidebar');
        const container = document.querySelector('.container');
        
        sidebarToggle.addEventListener('click', function() {
            sidebar.classList.toggle('collapsed');
            document.body.classList.toggle('sidebar-collapsed');
        });
        
        // Mobile responsive toggle
        function checkWidth() {
            if (window.innerWidth < 992) {
                sidebar.classList.add('collapsed');
                document.body.classList.add('sidebar-collapsed');
            } else {
                // Only reset if it was previously collapsed due to small screen
                if (!sidebar.classList.contains('user-collapsed')) {
                    sidebar.classList.remove('collapsed');
                    document.body.classList.remove('sidebar-collapsed');
                }
            }
        }
        
        // Run on page load and window resize
        window.addEventListener('resize', checkWidth);
        checkWidth();
        
        // Store user preference for sidebar state
        sidebarToggle.addEventListener('click', function() {
            if (sidebar.classList.contains('collapsed')) {
                sidebar.classList.add('user-collapsed');
            } else {
                sidebar.classList.remove('user-collapsed');
            }
        });
        
        // Bootstrap tooltip initialization
        if (typeof bootstrap !== 'undefined') {
            const tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
            tooltipTriggerList.map(function(tooltipTriggerEl) {
                return new bootstrap.Tooltip(tooltipTriggerEl);
            });
        }
    });
</script>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\Thinley Norbu\Documents\GitHub\FinalProject\resources\views/admin/inspection-approval.blade.php ENDPATH**/ ?>