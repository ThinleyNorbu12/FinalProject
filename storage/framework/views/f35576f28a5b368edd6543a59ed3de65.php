

<?php $__env->startSection('content'); ?>
<style>
    /* Admin Dashboard CSS - Improved Version */
:root {
    /* Color Palette */
    --primary-color: #4361ee;
    --primary-light: rgba(67, 97, 238, 0.1);
    --secondary-color: #3f37c9;
    --success-color: #4cc9f0;
    --warning-color: #f72585;
    --danger-color: #e5383b;
    --info-color: #4895ef;
    --dark-color: #212529;
    --light-color: #f8f9fa;
    --gray-color: #6c757d;
    --light-gray: #e9ecef;
    
    /* Layout */
    --sidebar-width: 280px;
    --sidebar-collapsed-width: 80px;
    --header-height: 70px;
    --transition-speed: 0.3s;
    --card-border-radius: 12px;
    --border-radius-sm: 8px;
    --box-shadow: 0 4px 20px rgba(0, 0, 0, 0.08);
    --box-shadow-hover: 0 8px 25px rgba(0, 0, 0, 0.1);
    
    /* Typography */
    --font-family: 'Poppins', -apple-system, BlinkMacSystemFont, sans-serif;
    --font-size-base: 14px;
}

/* Base Styles */
* {
    margin: 0;
    padding: 0;
    box-sizing: border-box;
}

body {
    font-family: var(--font-family);
    font-size: var(--font-size-base);
    background-color: #f5f7fa;
    color: #333;
    line-height: 1.5;
}

a {
    text-decoration: none;
    color: inherit;
    transition: all var(--transition-speed) ease;
}

/* Layout Structure */
.admin-dashboard {
    display: flex;
    min-height: 100vh;
    position: relative;
}

/* Sidebar Styles */
.dashboard-sidebar {
    width: var(--sidebar-width);
    background: #fff;
    box-shadow: var(--box-shadow);
    height: 100vh;
    position: fixed;
    top: 0;
    left: 0;
    z-index: 1000;
    transition: all var(--transition-speed) ease;
    overflow-y: auto;
    overflow-x: hidden;
    will-change: transform, width;
}

.sidebar-header {
    height: var(--header-height);
    display: flex;
    align-items: center;
    justify-content: space-between;
    padding: 0 20px;
    border-bottom: 1px solid var(--light-gray);
    position: sticky;
    top: 0;
    background: white;
    z-index: 10;
}

.logo {
    display: flex;
    align-items: center;
    min-width: 0; /* Allows text truncation */
}

.logo img {
    height: 40px;
    width: auto;
    margin-right: 10px;
    flex-shrink: 0;
}

.logo h2 {
    font-size: 18px;
    font-weight: 600;
    color: var(--primary-color);
    white-space: nowrap;
    overflow: hidden;
    text-overflow: ellipsis;
}

.sidebar-toggle {
    background: transparent;
    border: none;
    color: var(--dark-color);
    font-size: 18px;
    cursor: pointer;
    display: none;
    flex-shrink: 0;
}

/* Admin Profile */
.admin-profile {
    padding: 20px;
    display: flex;
    align-items: center;
    border-bottom: 1px solid var(--light-gray);
    transition: all var(--transition-speed) ease;
}

.profile-avatar img {
    width: 50px;
    height: 50px;
    border-radius: 50%;
    object-fit: cover;
    box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
    flex-shrink: 0;
}

.profile-info {
    margin-left: 15px;
    min-width: 0; /* Allows text truncation */
    overflow: hidden;
}

.profile-info h3 {
    font-size: 16px;
    font-weight: 600;
    margin-bottom: 3px;
    white-space: nowrap;
    overflow: hidden;
    text-overflow: ellipsis;
}

.profile-info span {
    font-size: 12px;
    color: var(--gray-color);
    display: block;
    white-space: nowrap;
    overflow: hidden;
    text-overflow: ellipsis;
}

/* Navigation */
.sidebar-nav ul {
    list-style: none;
    padding: 0;
    margin: 0;
}

.sidebar-nav a {
    display: flex;
    align-items: center;
    padding: 12px 20px;
    color: #555;
    margin: 2px 0;
    border-left: 3px solid transparent;
    transition: all var(--transition-speed) ease;
    white-space: nowrap;
}

.sidebar-nav a:hover {
    background-color: var(--primary-light);
    color: var(--primary-color);
}

.sidebar-nav a.active {
    background-color: var(--primary-light);
    color: var(--primary-color);
    border-left: 3px solid var(--primary-color);
    font-weight: 500;
}

.sidebar-nav a i {
    font-size: 18px;
    margin-right: 15px;
    width: 20px;
    text-align: center;
    flex-shrink: 0;
}

.sidebar-nav a span {
    opacity: 1;
    transition: opacity var(--transition-speed) ease;
}

.sidebar-divider {
    height: 1px;
    background-color: var(--light-gray);
    margin: 10px 20px;
}

.sidebar-heading {
    color: var(--gray-color);
    font-size: 12px;
    font-weight: 600;
    padding: 10px 20px;
    text-transform: uppercase;
    letter-spacing: 0.5px;
    white-space: nowrap;
}

.sidebar-menu-item.logout-item:hover {
    background-color: rgba(229, 56, 59, 0.1);
}

/* Main Content Area */
.dashboard-content {
    flex: 1;
    margin-left: var(--sidebar-width);
    transition: margin-left var(--transition-speed) ease;
    padding: 20px;
    min-height: 100vh;
    background-color: #f5f7fa;
}

/* Header Styles */
.dashboard-header {
    height: var(--header-height);
    display: flex;
    align-items: center;
    justify-content: space-between;
    background: #fff;
    padding: 0 25px;
    margin-bottom: 20px;
    border-radius: var(--card-border-radius);
    box-shadow: var(--box-shadow);
    position: sticky;
    top: 0;
    z-index: 100;
}

.header-search {
    position: relative;
    width: 300px;
}

.header-search input {
    width: 100%;
    padding: 10px 15px 10px 40px;
    border: 1px solid var(--light-gray);
    border-radius: 30px;
    font-size: 14px;
    transition: all var(--transition-speed) ease;
}

.header-search input:focus {
    border-color: var(--primary-color);
    outline: none;
    box-shadow: 0 0 0 3px rgba(67, 97, 238, 0.1);
}

.header-search i {
    position: absolute;
    left: 15px;
    top: 50%;
    transform: translateY(-50%);
    color: var(--gray-color);
}

.header-actions {
    display: flex;
    align-items: center;
    gap: 20px;
}

.notification, .messages {
    position: relative;
    cursor: pointer;
}

.notification i, .messages i {
    font-size: 18px;
    color: var(--dark-color);
    transition: transform 0.2s ease;
}

.notification:hover i, .messages:hover i {
    transform: translateY(-2px);
    color: var(--primary-color);
}

.badge {
    position: absolute;
    top: -8px;
    right: -8px;
    background: var(--danger-color);
    color: white;
    font-size: 10px;
    min-width: 18px;
    height: 18px;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    padding: 0 4px;
}

.account-menu {
    display: flex;
    align-items: center;
    cursor: pointer;
    padding: 8px 12px;
    border-radius: 30px;
    transition: background-color var(--transition-speed) ease;
}

.account-menu:hover {
    background-color: rgba(0, 0, 0, 0.05);
}

.account-menu span {
    margin-right: 10px;
    font-weight: 500;
    white-space: nowrap;
}

.account-menu img {
    width: 40px;
    height: 40px;
    border-radius: 50%;
    object-fit: cover;
    box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
}

/* Dashboard Cards */
.dashboard-cards {
    display: grid;
    grid-template-columns: repeat(auto-fill, minmax(240px, 1fr));
    gap: 20px;
    margin-bottom: 25px;
}

.card {
    background: #fff;
    border-radius: var(--card-border-radius);
    padding: 20px;
    box-shadow: var(--box-shadow);
    transition: all var(--transition-speed) ease;
    position: relative;
    overflow: hidden;
    border: none;
}

.card:hover {
    transform: translateY(-5px);
    box-shadow: var(--box-shadow-hover);
}

.card::before {
    content: '';
    position: absolute;
    top: 0;
    left: 0;
    width: 4px;
    height: 100%;
    background: var(--primary-color);
    transition: opacity var(--transition-speed) ease;
    opacity: 0;
}

.card:hover::before {
    opacity: 1;
}

.card-inner {
    display: flex;
    align-items: center;
}

.card-icon {
    width: 50px;
    height: 50px;
    border-radius: var(--border-radius-sm);
    display: flex;
    align-items: center;
    justify-content: center;
    margin-right: 15px;
    flex-shrink: 0;
    box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);
}

.card-icon i {
    font-size: 20px;
    color: #fff;
}

.card-content {
    min-width: 0; /* Allows text truncation */
}

.card-content h3 {
    font-size: 14px;
    font-weight: 500;
    color: var(--gray-color);
    margin-bottom: 8px;
    white-space: nowrap;
    overflow: hidden;
    text-overflow: ellipsis;
}

.card-content .count {
    font-size: 24px;
    font-weight: 700;
    margin-bottom: 5px;
    color: var(--dark-color);
}

.card-content .trend {
    font-size: 12px;
    display: flex;
    align-items: center;
    font-weight: 500;
}

.trend.up {
    color: #2ecc71;
}

.trend.down {
    color: #e74c3c;
}

.trend i {
    margin-right: 5px;
    font-size: 10px;
}

/* Quick Actions */
.quick-actions {
    background: #fff;
    border-radius: var(--card-border-radius);
    padding: 20px;
    box-shadow: var(--box-shadow);
    margin-bottom: 25px;
}

.quick-actions h2 {
    font-size: 18px;
    font-weight: 600;
    margin-bottom: 20px;
    color: var(--dark-color);
    position: relative;
    padding-bottom: 10px;
}

.quick-actions h2::after {
    content: '';
    position: absolute;
    bottom: 0;
    left: 0;
    width: 50px;
    height: 3px;
    background: var(--primary-color);
    transition: width var(--transition-speed) ease;
}

.quick-actions:hover h2::after {
    width: 80px;
}

.action-buttons {
    display: grid;
    grid-template-columns: repeat(auto-fill, minmax(180px, 1fr));
    gap: 15px;
}

.action-btn {
    background: var(--light-color);
    border-radius: var(--card-border-radius);
    padding: 20px 15px;
    display: flex;
    flex-direction: column;
    align-items: center;
    justify-content: center;
    text-align: center;
    transition: all var(--transition-speed) ease;
}

.action-btn:hover {
    background: var(--primary-color);
    color: #fff;
    transform: translateY(-5px);
    box-shadow: 0 10px 20px rgba(67, 97, 238, 0.2);
}

.action-btn i {
    font-size: 24px;
    margin-bottom: 12px;
    transition: transform var(--transition-speed) ease;
}

.action-btn:hover i {
    transform: scale(1.1);
}

.action-btn span {
    font-size: 13px;
    font-weight: 500;
}

/* Dashboard Panels */
.dashboard-panels {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
    gap: 20px;
}

.panel {
    background: #fff;
    border-radius: var(--card-border-radius);
    box-shadow: var(--box-shadow);
    overflow: hidden;
    transition: transform var(--transition-speed) ease;
}

.panel:hover {
    transform: translateY(-5px);
}

.panel-header {
    display: flex;
    align-items: center;
    justify-content: space-between;
    padding: 15px 20px;
    border-bottom: 1px solid var(--light-gray);
}

.panel-header h2 {
    font-size: 16px;
    font-weight: 600;
    color: var(--dark-color);
}

.view-all {
    font-size: 13px;
    color: var(--primary-color);
    font-weight: 500;
}

.view-all:hover {
    text-decoration: underline;
}

.panel-content {
    padding: 20px;
}

/* Activity List */
.activity-list {
    list-style: none;
}

.activity-list li {
    display: flex;
    align-items: flex-start;
    padding: 12px 0;
    border-bottom: 1px solid var(--light-gray);
    transition: background-color var(--transition-speed) ease;
}

.activity-list li:last-child {
    border-bottom: none;
}

.activity-list li:hover {
    background-color: rgba(245, 247, 250, 0.5);
}

.activity-icon {
    width: 36px;
    height: 36px;
    border-radius: 8px;
    display: flex;
    align-items: center;
    justify-content: center;
    margin-right: 12px;
    flex-shrink: 0;
    box-shadow: 0 3px 10px rgba(0, 0, 0, 0.1);
}

.activity-icon i {
    color: #fff;
    font-size: 14px;
}

.activity-details {
    flex: 1;
    min-width: 0;
}

.activity-details p {
    font-size: 13px;
    margin-bottom: 4px;
    font-weight: 500;
    white-space: nowrap;
    overflow: hidden;
    text-overflow: ellipsis;
}

.activity-details span {
    font-size: 11px;
    color: var(--gray-color);
}

/* Statistics */
.stat-container {
    display: flex;
    flex-direction: column;
    gap: 15px;
}

.stat-item h4 {
    font-size: 13px;
    font-weight: 500;
    margin-bottom: 8px;
    display: flex;
    justify-content: space-between;
}

.stat-item h4 span {
    color: var(--primary-color);
    font-weight: 600;
}

.stat-progress {
    display: flex;
    align-items: center;
    background-color: #edf2f7;
    height: 8px;
    border-radius: 10px;
    overflow: hidden;
}

.progress-bar {
    height: 100%;
    background: var(--primary-color);
    border-radius: 10px;
    transition: width 0.6s ease;
}

.stat-progress span {
    font-size: 13px;
    font-weight: 600;
    margin-left: 8px;
    color: var(--primary-color);
}

/* Form Elements */
select {
    padding: 8px 12px;
    border-radius: var(--border-radius-sm);
    border: 1px solid var(--light-gray);
    outline: none;
    font-size: 13px;
    cursor: pointer;
    transition: all var(--transition-speed) ease;
    background-color: white;
}

select:focus {
    border-color: var(--primary-color);
    box-shadow: 0 0 0 3px rgba(67, 97, 238, 0.1);
}

/* Animations */
@keyframes pulse {
    0% { transform: scale(1); }
    50% { transform: scale(1.1); }
    100% { transform: scale(1); }
}

.notification .badge, 
.messages .badge {
    animation: pulse 2s infinite;
}

/* Responsive Design */
@media (max-width: 1200px) {
    .dashboard-cards {
        grid-template-columns: repeat(2, 1fr);
    }
    
    .action-buttons {
        grid-template-columns: repeat(2, 1fr);
    }
}

@media (max-width: 992px) {
    .dashboard-sidebar {
        width: var(--sidebar-collapsed-width);
    }
    
    .dashboard-content {
        margin-left: var(--sidebar-collapsed-width);
    }
    
    .logo h2,
    .profile-info,
    .sidebar-nav a span,
    .sidebar-heading {
        opacity: 0;
        visibility: hidden;
        width: 0;
        height: 0;
        overflow: hidden;
    }
    
    .sidebar-toggle {
        display: block;
    }
    
    .admin-dashboard.sidebar-expanded .dashboard-sidebar {
        width: var(--sidebar-width);
    }
    
    .admin-dashboard.sidebar-expanded .logo h2,
    .admin-dashboard.sidebar-expanded .profile-info,
    .admin-dashboard.sidebar-expanded .sidebar-nav a span,
    .admin-dashboard.sidebar-expanded .sidebar-heading {
        opacity: 1;
        visibility: visible;
        width: auto;
        height: auto;
        transition: opacity var(--transition-speed) ease;
    }
    
    .header-search {
        width: 200px;
    }
}

@media (max-width: 768px) {
    .dashboard-header {
        flex-wrap: wrap;
        height: auto;
        padding: 15px;
        gap: 15px;
    }
    
    .header-search {
        order: 1;
        width: 100%;
    }
    
    .header-actions {
        order: 2;
        margin-left: auto;
    }
    
    .dashboard-panels {
        grid-template-columns: 1fr;
    }
}

@media (max-width: 576px) {
    .dashboard-content {
        padding: 15px;
    }
    
    .dashboard-cards,
    .action-buttons {
        grid-template-columns: 1fr;
    }
    
    .dashboard-sidebar {
        transform: translateX(-100%);
        width: var(--sidebar-width);
    }
    
    .admin-dashboard.sidebar-mobile-open .dashboard-sidebar {
        transform: translateX(0);
    }
    
    .sidebar-overlay {
        display: none;
        position: fixed;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        background: rgba(0, 0, 0, 0.5);
        z-index: 999;
    }
    
    .admin-dashboard.sidebar-mobile-open .sidebar-overlay {
        display: block;
    }
}
</style>
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
<div class="container-fluid">
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Verify Users</h1>
    </div>

    <?php if(session('success')): ?>
    <div class="alert alert-success alert-dismissible fade show" role="alert">
        <?php echo e(session('success')); ?>

        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
    </div>
    <?php endif; ?>

    <div class="card shadow mb-4">
        <div class="card-header py-3 d-flex justify-content-between align-items-center">
            <h6 class="m-0 font-weight-bold text-primary">User Verification Requests</h6>
            <div>
                <select id="status-filter" class="form-control form-control-sm mr-2 d-inline-block" style="width: 150px;">
                    <option value="all">All Statuses</option>
                    <option value="pending" selected>Pending</option>
                    <option value="verified">Verified</option>
                    <option value="rejected">Rejected</option>
                </select>
                <span class="badge badge-warning mr-2" id="pending-count">
                    <?php echo e($pendingCount); ?> Pending
                </span>
                <span class="badge badge-success mr-2" id="verified-count">
                    <?php echo e($verifiedCount); ?> Verified
                </span>
                <span class="badge badge-danger mr-2" id="rejected-count">
                    <?php echo e($rejectedCount); ?> Rejected
                </span>
            </div>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered" id="users-table" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Name</th>
                            <th>Email</th>
                            <th>Phone</th>
                            <th>CID No.</th>
                            <th>License No.</th>
                            <th>Status</th>
                            <th>Registered On</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $__currentLoopData = $customers; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $customer): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <tr class="status-row <?php echo e($customer->drivingLicense ? strtolower($customer->drivingLicense->status) : 'incomplete'); ?>">
                            <td><?php echo e($customer->id); ?></td>
                            <td><?php echo e($customer->name); ?></td>
                            <td><?php echo e($customer->email); ?></td>
                            <td><?php echo e($customer->phone); ?></td>
                            <td><?php echo e($customer->cid_no); ?></td>
                            <td><?php echo e($customer->drivingLicense ? $customer->drivingLicense->license_no : 'Not submitted'); ?></td>
                            <td>
                                <?php if(!$customer->drivingLicense): ?>
                                    <span class="badge badge-secondary">Not Submitted</span>
                                <?php else: ?>
                                    <?php
                                        $status = $customer->drivingLicense->status;
                                        $badgeClass = [
                                            'Pending' => 'badge-warning',
                                            'Verified' => 'badge-success',
                                            'Rejected' => 'badge-danger'
                                        ][$status] ?? 'badge-secondary';
                                    ?>
                                    <span class="badge <?php echo e($badgeClass); ?>"><?php echo e($status); ?></span>
                                <?php endif; ?>
                            </td>
                            <td><?php echo e(\Carbon\Carbon::parse($customer->created_at)->format('d M Y')); ?></td>
                            <td>
                                <?php if($customer->drivingLicense): ?>
                                <a href="<?php echo e(route('admin.user-verification.show', $customer->id)); ?>" class="btn btn-primary btn-sm">
                                    <i class="fas fa-eye"></i> View
                                </a>
                                <?php else: ?>
                                <button class="btn btn-secondary btn-sm" disabled>
                                    <i class="fas fa-eye-slash"></i> No License
                                </button>
                                <?php endif; ?>
                            </td>
                        </tr>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </tbody>
                </table>

                <div class="mt-4">
                    <?php echo e($customers->links()); ?>

                </div>
            </div>
        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\Sangay Ngedup\Documents\GitHub\FinalProject\resources\views/admin/verify-users.blade.php ENDPATH**/ ?>