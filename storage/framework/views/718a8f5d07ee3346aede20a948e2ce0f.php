

<?php $__env->startSection('content'); ?>
 <link rel="stylesheet" href="<?php echo e(asset('assets/css/admin/dashboard.css')); ?>">
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
    
            <a href="<?php echo e(route('admin.verify-users')); ?>" class="sidebar-menu-item <?php echo e(request()->routeIs('admin.verify-users') || request()->routeIs('admin.user-verification.*') ? 'active' : ''); ?>">
                <i class="fas fa-id-card"></i>
                <span>Verify Users</span>
            </a>
            <a href="<?php echo e(url('admin/view-payments')); ?>" class="sidebar-menu-item <?php echo e(request()->routeIs('admin.view-payments') ? 'active' : ''); ?>">
                <i class="fas fa-credit-card"></i>
                <span>Payments</span>
            </a>
            <a href="<?php echo e(url('admin/update-car-registration')); ?>" class="sidebar-menu-item <?php echo e(request()->routeIs('admin.update-car-registration') ? 'active' : ''); ?>">
                <i class="fas fa-edit"></i>
                <span>Update Registration</span>
            </a>
            <a href="<?php echo e(url('admin/car-information-update')); ?>" class="sidebar-menu-item <?php echo e(request()->routeIs('admin.car-information-update') ? 'active' : ''); ?>">
                <i class="fas fa-info-circle"></i>
                <span>Car Information</span>
            </a>
            <a href="<?php echo e(url('admin/booked-car')); ?>" class="sidebar-menu-item <?php echo e(request()->routeIs('admin.booked-car') ? 'active' : ''); ?>">
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
</div>
<div class="container">
        <h1>Car Registration Request</h1>

        <?php if($cars->isEmpty()): ?>
            <p>No cars found.</p>
        <?php else: ?>
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
                        <th>Car Image</th> <!-- Image Column -->
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
                            <td><?php echo e($car->status); ?></td>
                            <td>
                                <!-- Display Car Image -->
                                <?php if($car->car_image): ?>
                                    <img src="<?php echo e(asset($car->car_image)); ?>" alt="Car Image" style="width: 100px; height: auto;">
                                <?php else: ?>
                                    <p>No image</p>
                                <?php endif; ?>
                            </td>
                            <td>
                                <?php if(strtolower($car->status) === 'rejected'): ?>
                                    <span class="text-danger">Rejected</span>
                                <?php else: ?>
                                    <a href="<?php echo e(route('car-admin.view-car', $car->id)); ?>" class="btn btn-info">View</a>
                                <?php endif; ?>
                            </td>                            
                        </tr>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </tbody>
            </table>
        <?php endif; ?>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\Sangay Ngedup\Documents\GitHub\FinalProject\resources\views/admin/newly-registered-cars.blade.php ENDPATH**/ ?>