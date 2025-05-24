

<?php $__env->startSection('title', 'Verify Users'); ?>

<?php $__env->startSection('breadcrumbs'); ?>
    <li class="breadcrumb-item active">Verify Users</li>
<?php $__env->stopSection(); ?>

<?php $__env->startPush('styles'); ?>
     <link rel="stylesheet" href="<?php echo e(asset('assets/css/admin/verifyuser.css')); ?>">
<?php $__env->stopPush(); ?>

<?php $__env->startSection('content'); ?>
<div class="container-fluid">
    <!-- Mobile Header -->
    <div class="mobile-header">
        <h1 class="mb-0">Verify Users</h1>
        <div class="stats-badges">
            <span class="badge bg-warning text-dark" id="mobile-pending-count">
                <?php echo e($pendingCount); ?> Pending
            </span>
            <span class="badge bg-success" id="mobile-verified-count">
                <?php echo e($verifiedCount); ?> Verified
            </span>
            <span class="badge bg-danger" id="mobile-rejected-count">
                <?php echo e($rejectedCount); ?> Rejected
            </span>
        </div>
    </div>

    <!-- Desktop Header -->
    <div class="d-none d-md-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Verify Users</h1>
    </div>

    <div class="card shadow mb-4">
        <div class="card-header py-3 d-flex flex-column flex-lg-row justify-content-between align-items-start align-items-lg-center">
            <h6 class="m-0 font-weight-bold text-primary mb-3 mb-lg-0">User Verification Requests</h6>
            <div class="table-controls w-100 w-lg-auto">
                <div class="d-flex flex-column flex-sm-row align-items-stretch align-items-sm-center gap-2">
                    <select id="status-filter" class="form-select form-select-sm" style="min-width: 150px;">
                        <option value="all">All Statuses</option>
                        <option value="pending" selected>Pending</option>
                        <option value="verified">Verified</option>
                        <option value="rejected">Rejected</option>
                    </select>
                    <div class="stats-badges d-none d-lg-flex">
                        <span class="badge bg-warning text-dark" id="pending-count">
                            <?php echo e($pendingCount); ?> Pending
                        </span>
                        <span class="badge bg-success" id="verified-count">
                            <?php echo e($verifiedCount); ?> Verified
                        </span>
                        <span class="badge bg-danger" id="rejected-count">
                            <?php echo e($rejectedCount); ?> Rejected
                        </span>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="card-body p-0 p-md-3">
            <!-- Loading Spinner -->
            <div class="loading-spinner" id="loadingSpinner">
                <div class="spinner-border text-primary" role="status">
                    <span class="visually-hidden">Loading...</span>
                </div>
                <p class="mt-2">Loading users...</p>
            </div>

            <!-- Desktop Table View -->
            <div class="table-responsive desktop-table">
                <table class="table table-bordered table-hover mb-0" id="users-table">
                    <thead class="table-light">
                        <tr>
                            <th class="text-nowrap">ID</th>
                            <th class="text-nowrap">Name</th>
                            <th class="text-nowrap">Email</th>
                            <th class="text-nowrap">Phone</th>
                            <th class="text-nowrap">CID No.</th>
                            <th class="text-nowrap">License No.</th>
                            <th class="text-nowrap">Status</th>
                            <th class="text-nowrap">Registered On</th>
                            <th class="text-nowrap">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $__empty_1 = true; $__currentLoopData = $customers; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $customer): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                        <tr class="status-row <?php echo e($customer->drivingLicense ? strtolower($customer->drivingLicense->status) : 'incomplete'); ?>">
                            <td><?php echo e($customer->id); ?></td>
                            <td class="text-nowrap"><?php echo e($customer->name); ?></td>
                            <td><?php echo e($customer->email); ?></td>
                            <td class="text-nowrap"><?php echo e($customer->phone); ?></td>
                            <td class="text-nowrap"><?php echo e($customer->cid_no); ?></td>
                            <td class="text-nowrap"><?php echo e($customer->drivingLicense ? $customer->drivingLicense->license_no : 'Not submitted'); ?></td>
                            <td>
                                <?php if(!$customer->drivingLicense): ?>
                                    <span class="badge bg-secondary">Not Submitted</span>
                                <?php else: ?>
                                    <?php
                                        $status = $customer->drivingLicense->status;
                                        $badgeClass = [
                                            'Pending' => 'bg-warning text-dark',
                                            'Verified' => 'bg-success',
                                            'Rejected' => 'bg-danger'
                                        ][$status] ?? 'bg-secondary';
                                    ?>
                                    <span class="badge <?php echo e($badgeClass); ?>"><?php echo e($status); ?></span>
                                <?php endif; ?>
                            </td>
                            <td class="text-nowrap"><?php echo e(\Carbon\Carbon::parse($customer->created_at)->format('d M Y')); ?></td>
                            <td class="text-nowrap">
                                <?php if($customer->drivingLicense): ?>
                                <a href="<?php echo e(route('admin.user-verification.show', $customer->id)); ?>" class="btn btn-primary btn-sm">
                                    <i class="fas fa-eye"></i>
                                    <span class="d-none d-xl-inline"> View</span>
                                </a>
                                <?php else: ?>
                                <button class="btn btn-secondary btn-sm" disabled>
                                    <i class="fas fa-eye-slash"></i>
                                    <span class="d-none d-xl-inline"> No License</span>
                                </button>
                                <?php endif; ?>
                            </td>
                        </tr>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                        <tr>
                            <td colspan="9" class="text-center py-4">
                                <div class="empty-state">
                                    <i class="fas fa-users"></i>
                                    <h5>No users found</h5>
                                    <p class="text-muted">There are no users to verify at the moment.</p>
                                </div>
                            </td>
                        </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>

            <!-- Mobile Cards View -->
            <div class="mobile-cards d-block d-md-none">
                <?php $__empty_1 = true; $__currentLoopData = $customers; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $customer): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                <div class="mobile-card status-<?php echo e($customer->drivingLicense ? strtolower($customer->drivingLicense->status) : 'incomplete'); ?>">
                    <div class="mobile-card-header">
                        <div class="flex-grow-1">
                            <div class="mobile-card-title"><?php echo e($customer->name); ?></div>
                            <div class="mobile-card-subtitle">ID: <?php echo e($customer->id); ?></div>
                        </div>
                        <div>
                            <?php if(!$customer->drivingLicense): ?>
                                <span class="badge bg-secondary">Not Submitted</span>
                            <?php else: ?>
                                <?php
                                    $status = $customer->drivingLicense->status;
                                    $badgeClass = [
                                        'Pending' => 'bg-warning text-dark',
                                        'Verified' => 'bg-success',
                                        'Rejected' => 'bg-danger'
                                    ][$status] ?? 'bg-secondary';
                                ?>
                                <span class="badge <?php echo e($badgeClass); ?>"><?php echo e($status); ?></span>
                            <?php endif; ?>
                        </div>
                    </div>
                    
                    <div class="mobile-card-body">
                        <div class="mobile-field">
                            <div class="mobile-field-label">Email</div>
                            <div class="mobile-field-value"><?php echo e($customer->email); ?></div>
                        </div>
                        <div class="mobile-field">
                            <div class="mobile-field-label">Phone</div>
                            <div class="mobile-field-value"><?php echo e($customer->phone); ?></div>
                        </div>
                        <div class="mobile-field">
                            <div class="mobile-field-label">CID No.</div>
                            <div class="mobile-field-value"><?php echo e($customer->cid_no); ?></div>
                        </div>
                        <div class="mobile-field">
                            <div class="mobile-field-label">License No.</div>
                            <div class="mobile-field-value"><?php echo e($customer->drivingLicense ? $customer->drivingLicense->license_no : 'Not submitted'); ?></div>
                        </div>
                        <div class="mobile-field">
                            <div class="mobile-field-label">Registered On</div>
                            <div class="mobile-field-value"><?php echo e(\Carbon\Carbon::parse($customer->created_at)->format('d M Y')); ?></div>
                        </div>
                    </div>
                    
                    <div class="mobile-card-actions">
                        <?php if($customer->drivingLicense): ?>
                        <a href="<?php echo e(route('admin.user-verification.show', $customer->id)); ?>" class="btn btn-primary btn-sm w-100">
                            <i class="fas fa-eye me-1"></i> View Details
                        </a>
                        <?php else: ?>
                        <button class="btn btn-secondary btn-sm w-100" disabled>
                            <i class="fas fa-eye-slash me-1"></i> No License Submitted
                        </button>
                        <?php endif; ?>
                    </div>
                </div>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                <div class="empty-state">
                    <i class="fas fa-users"></i>
                    <h5>No users found</h5>
                    <p class="text-muted">There are no users to verify at the moment.</p>
                </div>
                <?php endif; ?>
            </div>

            <!-- Pagination -->
            <?php if($customers->hasPages()): ?>
            <div class="d-flex justify-content-center mt-4 px-3">
                <?php echo e($customers->links()); ?>

            </div>
            <?php endif; ?>
        </div>
    </div>
</div>

<?php $__env->startPush('scripts'); ?>
<script>
document.addEventListener('DOMContentLoaded', function() {
    const statusFilter = document.getElementById('status-filter');
    const tableRows = document.querySelectorAll('#users-table tbody .status-row');
    const mobileCards = document.querySelectorAll('.mobile-card');
    const loadingSpinner = document.getElementById('loadingSpinner');
    
    // Status filter functionality
    statusFilter.addEventListener('change', function() {
        const selectedStatus = this.value;
        
        // Show loading spinner
        if (loadingSpinner) {
            loadingSpinner.style.display = 'block';
        }
        
        setTimeout(() => {
            // Filter table rows
            tableRows.forEach(row => {
                if (selectedStatus === 'all') {
                    row.style.display = '';
                } else {
                    const hasStatusClass = row.classList.contains(selectedStatus) || 
                                         (selectedStatus === 'incomplete' && row.classList.contains('incomplete'));
                    row.style.display = hasStatusClass ? '' : 'none';
                }
            });
            
            // Filter mobile cards
            mobileCards.forEach(card => {
                if (selectedStatus === 'all') {
                    card.style.display = 'block';
                } else {
                    const hasStatusClass = card.classList.contains(`status-${selectedStatus}`);
                    card.style.display = hasStatusClass ? 'block' : 'none';
                }
            });
            
            // Hide loading spinner
            if (loadingSpinner) {
                loadingSpinner.style.display = 'none';
            }
            
            // Update counts (you can implement this based on your needs)
            updateVisibleCounts();
        }, 300);
    });
    
    // Update visible counts after filtering
    function updateVisibleCounts() {
        // This function can be enhanced to show filtered counts
        // For now, it keeps the original counts
    }
    
    // Add smooth scroll for mobile
    if (window.innerWidth <= 768) {
        const cards = document.querySelectorAll('.mobile-card');
        cards.forEach(card => {
            card.addEventListener('click', function(e) {
                if (!e.target.closest('.btn')) {
                    // Add some interaction feedback
                    this.style.transform = 'scale(0.98)';
                    setTimeout(() => {
                        this.style.transform = 'scale(1)';
                    }, 150);
                }
            });
        });
    }
    
    // Handle window resize
    let resizeTimer;
    window.addEventListener('resize', function() {
        clearTimeout(resizeTimer);
        resizeTimer = setTimeout(function() {
            // Refresh any size-dependent calculations
            console.log('Window resized to:', window.innerWidth);
        }, 250);
    });
});
</script>
<?php $__env->stopPush(); ?>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.admin', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\Sangay Ngedup\Documents\GitHub\FinalProject\resources\views/admin/verify-users.blade.php ENDPATH**/ ?>