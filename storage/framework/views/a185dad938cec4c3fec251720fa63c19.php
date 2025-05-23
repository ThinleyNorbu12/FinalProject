

<?php $__env->startSection('title', 'Dashboard'); ?>

<?php $__env->startSection('breadcrumbs'); ?>
    <li class="breadcrumb-item active">Dashboard</li>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>
<!-- DYNAMIC CONTENT LOADER -->
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
                    <p class="trend up">
                        <i class="fas fa-arrow-up"></i> 12% from last month
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
                    <p class="count">18</p>
                    <p class="trend down">
                        <i class="fas fa-arrow-down"></i> 5% from last month
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
                    <p class="count">$15,890</p>
                    <p class="trend up">
                        <i class="fas fa-arrow-up"></i> 8% from last month
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
                    <p class="count">42</p>
                    <p class="trend up">
                        <i class="fas fa-arrow-up"></i> 15% from last month
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
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.admin', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\Sangay Ngedup\Documents\GitHub\FinalProject\resources\views/admin/auth/dashboard.blade.php ENDPATH**/ ?>