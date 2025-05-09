
    <!-- Custom dashboard CSS -->
    <link rel="stylesheet" href="<?php echo e(asset('assets/css/admin/dashboard.css')); ?>">
    <!-- FontAwesome for icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
<?php $__env->startSection('content'); ?>
    <!-- Sidebar -->
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

    <!-- Main Content -->
    <div class="dashboard-content">
        <!-- Top Header -->
        <div class="dashboard-header">
            <div class="header-search">
                <i class="fas fa-search"></i>
                <input type="text" placeholder="Search...">
            </div>
            <div class="header-actions">
                <div class="notification">
                    <i class="fas fa-bell"></i>
                    <span class="badge">3</span>
                </div>
                <div class="messages">
                    <i class="fas fa-envelope"></i>
                    <span class="badge">5</span>
                </div>
                <div class="account-menu">
                    <?php if(Auth::guard('admin')->check()): ?>
                        <span><?php echo e(Auth::guard('admin')->user()->name); ?></span>
                        
                    <?php else: ?>
                        <a href="<?php echo e(route('admin.login')); ?>" class="btn btn-primary">Login</a>
                    <?php endif; ?>
                </div>
            </div>
        </div>

         <!-- DYNAMIC CONTENT LOADER (this will be updated by JS below) -->
        <div id="dynamic-content">
            <!-- Default Dashboard Cards -->
            <div class="dashboard-cards">
                <div class="card">
                    <div class="card-inner">
                        <div class="card-icon bg-primary">
                            <i class="fas fa-car"></i>
                        </div>
                        <div class="card-content">
                            <h3>New Registrations</h3>
                            <p class="count">24</p>
                            <p class="trend up"><i class="fas fa-arrow-up"></i> 12% from last month</p>
                        </div>
                    </div>
                </div>
            
            <div class="card">
                <div class="card-inner">
                    <div class="card-icon bg-success">
                        <i class="fas fa-clipboard-check"></i>
                    </div>
                    <div class="card-content">
                        <h3>Pending Inspections</h3>
                        <p class="count">18</p>
                        <p class="trend down"><i class="fas fa-arrow-down"></i> 5% from last month</p>
                    </div>
                </div>
            </div>
            
            <div class="card">
                <div class="card-inner">
                    <div class="card-icon bg-warning">
                        <i class="fas fa-credit-card"></i>
                    </div>
                    <div class="card-content">
                        <h3>Total Revenue</h3>
                        <p class="count">$15,890</p>
                        <p class="trend up"><i class="fas fa-arrow-up"></i> 8% from last month</p>
                    </div>
                </div>
            </div>
            
            <div class="card">
                <div class="card-inner">
                    <div class="card-icon bg-info">
                        <i class="fas fa-calendar-check"></i>
                    </div>
                    <div class="card-content">
                        <h3>Booked Cars</h3>
                        <p class="count">42</p>
                        <p class="trend up"><i class="fas fa-arrow-up"></i> 15% from last month</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Quick Actions -->
        <div class="quick-actions">
            <h2>Quick Actions</h2>
            <div class="action-buttons">
                <a href="<?php echo e(route('car-admin.new-registration-cars')); ?>" class="action-btn">
                    <i class="fas fa-car"></i>
                    <span>Car Registration Request</span>
                </a>
                <a href="<?php echo e(route('car-admin.inspection-requests')); ?>" class="action-btn">
                    <i class="fas fa-clipboard-check"></i>
                    <span>Manage Inspection Requests</span>
                </a>
                <a href="<?php echo e(route('car-admin.approve-inspected-cars')); ?>" class="action-btn">
                    <i class="fas fa-check-circle"></i>
                    <span>Approve/Reject Inspected Cars</span>
                </a>
                <a href="<?php echo e(url('admin/view-payments')); ?>" class="action-btn">
                    <i class="fas fa-credit-card"></i>
                    <span>View Payments</span>
                </a>
            </div>
        </div>

        <!-- Recent Activity & Stats Panel -->
        <div class="dashboard-panels">
            <!-- Recent Activity -->
            <div class="panel recent-activity">
                <div class="panel-header">
                    <h2>Recent Activity</h2>
                    <a href="#" class="view-all">View All</a>
                </div>
                <div class="panel-content">
                    <ul class="activity-list">
                        <li>
                            <div class="activity-icon bg-success">
                                <i class="fas fa-check"></i>
                            </div>
                            <div class="activity-details">
                                <p>Car inspection approved for Honda Civic</p>
                                <span>10 minutes ago</span>
                            </div>
                        </li>
                        <li>
                            <div class="activity-icon bg-primary">
                                <i class="fas fa-car"></i>
                            </div>
                            <div class="activity-details">
                                <p>New registration request from John Doe</p>
                                <span>1 hour ago</span>
                            </div>
                        </li>
                        <li>
                            <div class="activity-icon bg-warning">
                                <i class="fas fa-calendar"></i>
                            </div>
                            <div class="activity-details">
                                <p>Inspection scheduled for Toyota Corolla</p>
                                <span>3 hours ago</span>
                            </div>
                        </li>
                        <li>
                            <div class="activity-icon bg-danger">
                                <i class="fas fa-times"></i>
                            </div>
                            <div class="activity-details">
                                <p>Car inspection rejected for Ford Focus</p>
                                <span>Yesterday</span>
                            </div>
                        </li>
                        <li>
                            <div class="activity-icon bg-info">
                                <i class="fas fa-credit-card"></i>
                            </div>
                            <div class="activity-details">
                                <p>Payment received for Tesla Model 3</p>
                                <span>Yesterday</span>
                            </div>
                        </li>
                    </ul>
                </div>
            </div>

            <!-- Statistics -->
            <div class="panel statistics">
                <div class="panel-header">
                    <h2>Monthly Statistics</h2>
                    <div class="panel-actions">
                        <select id="month-selector">
                            <option value="may">May 2025</option>
                            <option value="april">April 2025</option>
                            <option value="march">March 2025</option>
                        </select>
                    </div>
                </div>
                <div class="panel-content">
                    <div class="stat-container">
                        <div class="stat-item">
                            <h4>New Registrations</h4>
                            <div class="stat-progress">
                                <div class="progress-bar" style="width: 75%"></div>
                                <span>75%</span>
                            </div>
                        </div>
                        <div class="stat-item">
                            <h4>Completed Inspections</h4>
                            <div class="stat-progress">
                                <div class="progress-bar" style="width: 60%"></div>
                                <span>60%</span>
                            </div>
                        </div>
                        <div class="stat-item">
                            <h4>Approved Cars</h4>
                            <div class="stat-progress">
                                <div class="progress-bar" style="width: 85%"></div>
                                <span>85%</span>
                            </div>
                        </div>
                        <div class="stat-item">
                            <h4>Total Revenue</h4>
                            <div class="stat-progress">
                                <div class="progress-bar" style="width: 45%"></div>
                                <span>45%</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<?php $__env->startSection('scripts'); ?>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
    $(document).ready(function () {
        $('.menu-link').on('click', function (e) {
            e.preventDefault();
            let url = $(this).data('url');

            $('#dynamic-content').html('<p>Loading...</p>');

            $.ajax({
                url: url,
                method: 'GET',
                success: function (data) {
                    $('#dynamic-content').html(data);
                },
                error: function () {
                    $('#dynamic-content').html('<p>Error loading content. Please try again.</p>');
                }
            });
        });
    });
</script>
<?php $__env->stopSection(); ?>

<?php $__env->stopSection(); ?>


<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\Thinley Norbu\Documents\GitHub\FinalProject\resources\views/admin/auth/dashboard.blade.php ENDPATH**/ ?>