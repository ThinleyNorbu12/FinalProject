

<?php $__env->startSection('title', 'Dashboard'); ?>

<?php $__env->startSection('breadcrumbs'); ?>
    <li class="breadcrumb-item active">Dashboard</li>
<?php $__env->stopSection(); ?>

<?php $__env->startPush('styles'); ?>
    <link rel="stylesheet" href="<?php echo e(asset('assets/css/admin/dashboard.css')); ?>">
<?php $__env->stopPush(); ?>

<?php $__env->startSection('content'); ?>
<!-- DYNAMIC CONTENT LOADER -->
<div id="dynamic-content">
    <!-- Dashboard Cards with Real Data -->
    <div class="dashboard-cards">
        <div class="card">
            <div class="card-inner">
                <div class="card-icon bg-primary">
                    <i class="fas fa-car"></i> 
                </div>
                <div class="card-content">
                    <h3>New Registrations</h3>
                    <p class="count"><?php echo e($stats['new_registrations']['count']); ?></p>
                    <p class="trend <?php echo e($stats['new_registrations']['trend']['direction']); ?>">
                        <i class="fas fa-arrow-<?php echo e($stats['new_registrations']['trend']['direction']); ?>"></i> 
                        <?php echo e($stats['new_registrations']['trend']['percentage']); ?>% from last month
                    </p>
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
                    <p class="count"><?php echo e($stats['pending_inspections']['count']); ?></p>
                    <p class="trend <?php echo e($stats['pending_inspections']['trend']['direction']); ?>">
                        <i class="fas fa-arrow-<?php echo e($stats['pending_inspections']['trend']['direction']); ?>"></i> 
                        <?php echo e($stats['pending_inspections']['trend']['percentage']); ?>% from last month
                    </p>
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
                    <p class="count">BTN <?php echo e($stats['total_revenue']['amount']); ?></p>
                    <p class="trend <?php echo e($stats['total_revenue']['trend']['direction']); ?>">
                        <i class="fas fa-arrow-<?php echo e($stats['total_revenue']['trend']['direction']); ?>"></i> 
                        <?php echo e($stats['total_revenue']['trend']['percentage']); ?>% from last month
                    </p>
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
                    <p class="count"><?php echo e($stats['booked_cars']['count']); ?></p>
                    <p class="trend <?php echo e($stats['booked_cars']['trend']['direction']); ?>">
                        <i class="fas fa-arrow-<?php echo e($stats['booked_cars']['trend']['direction']); ?>"></i> 
                        <?php echo e($stats['booked_cars']['trend']['percentage']); ?>% from last month
                    </p>
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
        <!-- Recent Activity with Real Data -->
        <div class="panel recent-activity">
            <div class="panel-header">
                <h2>Recent Activity</h2>
                <!-- <a href="#" class="view-all">View All</a> -->
            </div>
            <div class="panel-content">
                <ul class="activity-list">
                    <?php $__empty_1 = true; $__currentLoopData = $recentActivities; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $activity): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                        <li>
                            <div class="activity-icon <?php echo e($activity['color']); ?>">
                                <i class="<?php echo e($activity['icon']); ?>"></i>
                            </div>
                            <div class="activity-details">
                                <p><?php echo e($activity['message']); ?></p>
                                <span><?php echo e($activity['time']); ?></span>
                            </div>
                        </li>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                        <li>
                            <div class="activity-icon bg-secondary">
                                <i class="fas fa-info"></i>
                            </div>
                            <div class="activity-details">
                                <p>No recent activity</p>
                                <span>Start managing your car rental business!</span>
                            </div>
                        </li>
                    <?php endif; ?>
                </ul>
            </div>
        </div>

        <!-- Statistics with Real Data -->
        <div class="panel statistics">
            <div class="panel-header">
                <h2>Monthly Statistics</h2>
                <div class="panel-actions">
                    <select id="month-selector">
                        <option value="may"><?php echo e(Carbon\Carbon::now()->format('F Y')); ?></option>
                        <option value="april"><?php echo e(Carbon\Carbon::now()->subMonth()->format('F Y')); ?></option>
                        <option value="march"><?php echo e(Carbon\Carbon::now()->subMonths(2)->format('F Y')); ?></option>
                    </select>
                </div>
            </div>
            <div class="panel-content">
                <div class="stat-container">
                    <div class="stat-item">
                        <h4>New Registrations</h4>
                        <div class="stat-progress">
                            <div class="progress-bar" style="width: <?php echo e($monthlyStats['registrations']['percentage']); ?>%"></div>
                            <span><?php echo e($monthlyStats['registrations']['percentage']); ?>%</span>
                        </div>
                        <small><?php echo e($monthlyStats['registrations']['actual']); ?>/<?php echo e($monthlyStats['registrations']['target']); ?> target</small>
                    </div>
                    <div class="stat-item">
                        <h4>Completed Inspections</h4>
                        <div class="stat-progress">
                            <div class="progress-bar" style="width: <?php echo e($monthlyStats['inspections']['percentage']); ?>%"></div>
                            <span><?php echo e($monthlyStats['inspections']['percentage']); ?>%</span>
                        </div>
                        <small><?php echo e($monthlyStats['inspections']['actual']); ?>/<?php echo e($monthlyStats['inspections']['target']); ?> target</small>
                    </div>
                    <div class="stat-item">
                        <h4>Approved Cars</h4>
                        <div class="stat-progress">
                            <div class="progress-bar" style="width: <?php echo e($monthlyStats['approvals']['percentage']); ?>%"></div>
                            <span><?php echo e($monthlyStats['approvals']['percentage']); ?>%</span>
                        </div>
                        <small><?php echo e($monthlyStats['approvals']['actual']); ?>/<?php echo e($monthlyStats['approvals']['target']); ?> target</small>
                    </div>
                    <div class="stat-item">
                        <h4>Total Revenue</h4>
                        <div class="stat-progress">
                            <div class="progress-bar" style="width: <?php echo e($monthlyStats['revenue']['percentage']); ?>%"></div>
                            <span><?php echo e($monthlyStats['revenue']['percentage']); ?>%</span>
                        </div>
                        <small>BTN <?php echo e(number_format($monthlyStats['revenue']['actual'], 2)); ?>/BTN <?php echo e(number_format($monthlyStats['revenue']['target'], 2)); ?> target</small>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<?php $__env->startPush('scripts'); ?>
<script>
    // Auto-refresh dashboard data every 5 minutes
    setInterval(function() {
        location.reload();
    }, 300000);
    
    // Month selector functionality (you can implement AJAX here)
    document.getElementById('month-selector').addEventListener('change', function() {
        // Implement month filtering functionality
        console.log('Month changed to:', this.value);
    });
</script>
<?php $__env->stopPush(); ?>

<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.admin', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\Thinley Norbu\Documents\GitHub\FinalProject\resources\views/admin/auth/dashboard.blade.php ENDPATH**/ ?>