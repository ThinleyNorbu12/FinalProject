

<?php $__env->startSection('content'); ?>
<link rel="stylesheet" href="<?php echo e(asset('assets/css/admin/inspection-approval.css')); ?>">
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
                <a href="<?php echo e(route('car-admin.new-registration-cars')); ?>" class="sidebar-menu-item">
                    <i class="fas fa-car"></i>
                    <span>Car Registration</span>
                </a>
            </li>
            <li>
                <a href="<?php echo e(route('car-admin.inspection-requests')); ?>" class="sidebar-menu-item ">
                    <i class="fas fa-clipboard-check"></i>
                    <span>Inspection Requests</span>
                </a>
            </li>
            <li>
                <a href="<?php echo e(route('car-admin.approve-inspected-cars')); ?>" class="sidebar-menu-item active">
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
                <a href="<?php echo e(url('admin/view-payments')); ?>" class="sidebar-menu-item">
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