

<?php $__env->startSection('title', 'Rescheduled Inspection Requests'); ?>

<?php $__env->startSection('breadcrumbs'); ?>
    <li class="breadcrumb-item active">Inspection Requests</li>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('page-header'); ?>
    <div class="d-flex justify-content-between align-items-center">
        <div>
            <h1 class="page-title">Inspection Requests</h1>
            <p class="page-subtitle">Manage and confirm rescheduled inspection appointments</p>
        </div>
    </div>
<?php $__env->stopSection(); ?>

<?php $__env->startPush('styles'); ?>
    <link rel="stylesheet" href="<?php echo e(asset('assets/css/admin/menage-inspection-requests.css')); ?>">
<?php $__env->stopPush(); ?>

<?php $__env->startSection('content'); ?>
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <?php if($inspectionRequests->count() > 0): ?>
                <div class="table-responsive">
                    <table class="table table-bordered align-middle text-center">
                        <thead class="table-dark">
                            <tr>
                                <th>Sl. No</th>
                                <th>Car</th>
                                <th>Reg. No.</th>
                                <th>Owner Email</th>
                                <th>Date</th>
                                <th>Time</th>
                                <th>Location</th>
                                <th>CarOwner Response</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php $__currentLoopData = $inspectionRequests; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $request): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <tr>
                                    <td><?php echo e($loop->iteration); ?></td>
                                    <td>
                                        <strong><?php echo e($request->car->maker ?? 'N/A'); ?></strong>
                                        <br>
                                        <small class="text-muted"><?php echo e($request->car->model ?? ''); ?></small>
                                    </td>
                                    <td>
                                        <span class="badge bg-light text-dark">
                                            <?php echo e($request->car->registration_no ?? 'N/A'); ?>

                                        </span>
                                    </td>
                                    <td>
                                        <a href="mailto:<?php echo e($request->car->owner->email ?? ''); ?>" 
                                           class="text-decoration-none">
                                            <?php echo e($request->car->owner->email ?? 'N/A'); ?>

                                        </a>
                                    </td>
                                    <td>
                                        <i class="fas fa-calendar-alt me-1"></i>
                                        <?php echo e(\Carbon\Carbon::parse($request->inspection_date)->format('M d, Y')); ?>

                                    </td>
                                    <td>
                                        <i class="fas fa-clock me-1"></i>
                                        <?php echo e($request->inspection_time); ?>

                                    </td>
                                    <td>
                                        <i class="fas fa-map-marker-alt me-1"></i>
                                        <?php echo e($request->location); ?>

                                    </td>
                                    <td>
                                        <?php if($request->request_accepted): ?>
                                            <span class="badge bg-success">
                                                <i class="fas fa-check me-1"></i>Accepted
                                            </span>
                                        <?php elseif($request->status === 'canceled'): ?>
                                            <span class="badge bg-danger">
                                                <i class="fas fa-times me-1"></i>Cancelled
                                            </span>
                                        <?php elseif($request->request_new_date_sent): ?>
                                            <span class="badge bg-warning text-dark">
                                                <i class="fas fa-clock me-1"></i>Requested New Date
                                            </span>
                                        <?php else: ?>
                                            <span class="badge bg-secondary">
                                                <i class="fas fa-hourglass-half me-1"></i>Pending
                                            </span>
                                        <?php endif; ?>
                                    </td>                           
                                    
                                    <td>
                                        <?php if($request->status !== 'canceled'): ?>
                                            <?php if(!$request->is_confirmed_by_admin): ?>
                                                <form action="<?php echo e(route('car-admin.inspection.confirm', $request->id)); ?>" 
                                                      method="POST" 
                                                      class="d-inline" 
                                                      onsubmit="return disableButton(this)">
                                                    <?php echo csrf_field(); ?>
                                                    <button type="submit" 
                                                            class="btn btn-success btn-sm" 
                                                            id="btn-<?php echo e($request->id); ?>"
                                                            title="Confirm Inspection">
                                                        <i class="bi bi-check-circle me-1"></i>Confirm
                                                    </button>
                                                </form>
                                            <?php else: ?>
                                                <button class="btn btn-secondary btn-sm" 
                                                        disabled
                                                        title="Already Confirmed">
                                                    <i class="bi bi-check2-circle me-1"></i>Booked
                                                </button>
                                            <?php endif; ?>
                                        <?php else: ?>
                                            <span class="text-muted">
                                                <i class="fas fa-ban"></i> Cancelled
                                            </span>
                                        <?php endif; ?>
                                    </td>
                                </tr>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </tbody>
                    </table>
                </div>

                
                <?php if(method_exists($inspectionRequests, 'links')): ?>
                    <div class="d-flex justify-content-center mt-4">
                        <?php echo e($inspectionRequests->links()); ?>

                    </div>
                <?php endif; ?>
            <?php else: ?>
                <div class="text-center py-5">
                    <div class="mb-4">
                        <i class="fas fa-clipboard-list fa-4x text-muted"></i>
                    </div>
                    <div class="alert alert-info d-inline-block">
                        <h5 class="mb-2">
                            <i class="fas fa-info-circle me-2"></i>No Rescheduled Requests
                        </h5>
                        <p class="mb-0">No inspection responses found from car owners.</p>
                    </div>
                    <div class="mt-3">
                        <a href="<?php echo e(route('car-admin.inspection-requests')); ?>" 
                           class="btn btn-primary">
                            <i class="fas fa-arrow-left me-2"></i>View All Inspection Requests
                        </a>
                    </div>
                </div>
            <?php endif; ?>
        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php $__env->startPush('scripts'); ?>
<script>
    document.addEventListener('DOMContentLoaded', function () {
        // Initialize tooltips if Bootstrap tooltips are available
        if (typeof bootstrap !== 'undefined' && bootstrap.Tooltip) {
            var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
            var tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {
                return new bootstrap.Tooltip(tooltipTriggerEl);
            });
        }
    });
    
    function disableButton(form) {
        const btn = form.querySelector('button[type="submit"]');
        const originalText = btn.innerHTML;
        
        // Disable button and show loading state
        btn.disabled = true;
        btn.innerHTML = '<span class="spinner-border spinner-border-sm me-2" role="status" aria-hidden="true"></span>Processing...';
        
        // Simulate processing time (you can remove this setTimeout in production)
        setTimeout(() => {
            btn.innerHTML = '<i class="bi bi-check2-circle me-1"></i>Done';
            btn.classList.remove('btn-success');
            btn.classList.add('btn-secondary');
            
            // Show success message
            const row = btn.closest('tr');
            row.style.backgroundColor = '#d4edda';
            
            setTimeout(() => {
                row.style.backgroundColor = '';
            }, 2000);
        }, 1000);
        
        return true;
    }
    
    // Add smooth animations for table rows
    document.querySelectorAll('.table tbody tr').forEach(row => {
        row.addEventListener('mouseenter', function() {
            this.style.transform = 'translateY(-2px)';
        });
        
        row.addEventListener('mouseleave', function() {
            this.style.transform = 'translateY(0)';
        });
    });
</script>
<?php $__env->stopPush(); ?>
<?php echo $__env->make('layouts.admin', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\Sangay Ngedup\Documents\GitHub\FinalProject\resources\views/admin/menage-inspection-requests.blade.php ENDPATH**/ ?>