
 <link rel="stylesheet" href="<?php echo e(asset('assets/css/admin/dashboard.css')); ?>">
<?php $__env->startSection('content'); ?>

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
<div class="container mt-4">
    <h2 class="mb-4">Request for Car Inspection</h2>

    
    <?php if(session('success')): ?>
        <div class="alert alert-success"><?php echo e(session('success')); ?></div>
    <?php endif; ?>

    
    <div class="card mb-4">
        <div class="card-header bg-primary text-white">Car Details</div>
        <div class="card-body">
            <p><strong>Maker:</strong> <?php echo e($car->maker); ?></p>
            <p><strong>Model:</strong> <?php echo e($car->model); ?></p>
            <p><strong>Registration Number:</strong> <?php echo e($car->registration_no); ?></p>
        </div>
    </div>

    
    <div class="car-owner-info mt-4">
        <h4>Registered By:</h4>
        <?php if($car->owner): ?>
            <p><strong>Name:</strong> <?php echo e($car->owner->name); ?></p>
            <p><strong>Email:</strong> <?php echo e($car->owner->email); ?></p>
        <?php else: ?>
            <p>Unknown Owner</p>
        <?php endif; ?>
    </div>

    
    <form action="<?php echo e(url('car-admin/submit-inspection-request/' . $car->id)); ?>" method="POST">
        <?php echo csrf_field(); ?>
        <div class="form-group">
            <label for="date">Inspection Date:</label>
            <input type="date" id="date" name="date" class="form-control" required>
        </div>

        <div class="form-group">
            <label for="time">Inspection Time:</label>
            <select id="time" name="time" class="form-control" required>
                <option value="">-- Select Date First --</option>
            </select>
        </div>

        <div class="form-group">
            <label for="location">Inspection Location:</label>
            <input type="text" id="location" name="location" class="form-control" required>
        </div>

        <div class="form-group">
            <label for="details">Additional Details:</label>
            <textarea id="details" name="details" class="form-control" rows="4"></textarea>
        </div>

        <button type="submit" class="btn btn-primary">Submit Inspection Request</button>
    </form>
</div>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

<script>
    $('#date').on('change', function () {
    const selectedDate = $(this).val();

    $.ajax({
        url: "<?php echo e(route('car-admin.getAvailableTimes')); ?>",
        type: "GET",
        data: { date: selectedDate },
        success: function (response) {
            let options = '<option value="">-- Select Time Slot --</option>';

            if (response.length === 0) {
                options += '<option disabled>No available time slots</option>';
            } else {
                response.forEach(slot => {
                    options += `<option value="${slot}">${slot}</option>`;
                });
            }

            $('#time').html(options);
        },
        error: function () {
            alert('Failed to load time slots. Please try again.');
            $('#time').html('<option value="">-- Select Date First --</option>');
        }
    });
});

</script>


<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\Thinley Norbu\Documents\GitHub\FinalProject\resources\views/admin/request-inspection.blade.php ENDPATH**/ ?>