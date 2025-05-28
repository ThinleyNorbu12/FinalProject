

<?php $__env->startSection('title', 'Inspection Requests'); ?>

<?php $__env->startSection('breadcrumbs'); ?>
<li class="breadcrumb-item active">Inspection Requests</li>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('page-header'); ?>
<div class="d-flex justify-content-between align-items-center">
    <h2 class="mb-0">
        <i class="fas fa-search me-2"></i>
        Inspection Requests from Admin
    </h2>
    <span class="badge bg-primary fs-6"><?php echo e($inspectionRequests->count()); ?> Request(s)</span>
</div>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>
<div class="row">
    <div class="col-12">
        <?php if($inspectionRequests->count() > 0): ?>
            <div class="row">
                <?php $__currentLoopData = $inspectionRequests; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $request): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <div class="col-lg-6 col-xl-4 mb-4">
                        <div class="card h-100 shadow-sm border-0">
                            <div class="card-header bg-light border-0 pb-0">
                                <div class="d-flex justify-content-between align-items-start">
                                    <div>
                                        <h5 class="card-title mb-1 text-primary">
                                            <i class="fas fa-car me-2"></i>
                                            <?php echo e($request->car->maker ?? 'N/A'); ?> <?php echo e($request->car->model ?? ''); ?>

                                        </h5>
                                        <p class="text-muted mb-0">
                                            <i class="fas fa-hashtag me-1"></i>
                                            <?php echo e($request->car->registration_no ?? 'N/A'); ?>

                                        </p>
                                    </div>
                                    <span class="badge bg-<?php echo e($request->status === 'canceled' ? 'danger' : ($request->request_accepted ? 'success' : 'warning')); ?> fs-6">
                                        <?php echo e(ucfirst($request->status)); ?>

                                    </span>
                                </div>
                            </div>
                            
                            <div class="card-body">
                                <div class="inspection-details mb-3">
                                    <div class="row g-2">
                                        <div class="col-6">
                                            <div class="d-flex align-items-center mb-2">
                                                <i class="fas fa-calendar-alt text-primary me-2"></i>
                                                <small class="text-muted">Date</small>
                                            </div>
                                            <p class="mb-0 fw-medium">
                                                <?php
                                                    try {
                                                        echo \Carbon\Carbon::parse($request->inspection_date)->format('d M Y');
                                                    } catch (Exception $e) {
                                                        echo $request->inspection_date;
                                                    }
                                                ?>
                                            </p>
                                        </div>
                                        <div class="col-6">
                                            <div class="d-flex align-items-center mb-2">
                                                <i class="fas fa-clock text-primary me-2"></i>
                                                <small class="text-muted">Time</small>
                                            </div>
                                            <p class="mb-0 fw-medium"><?php echo e($request->inspection_time); ?></p>
                                        </div>
                                    </div>
                                </div>

                                <div class="mb-3">
                                    <div class="d-flex align-items-center mb-2">
                                        <i class="fas fa-map-marker-alt text-primary me-2"></i>
                                        <small class="text-muted">Location</small>
                                    </div>
                                    <p class="mb-0"><?php echo e($request->location); ?></p>
                                </div>

                                <?php if($request->details): ?>
                                <div class="mb-3">
                                    <div class="d-flex align-items-center mb-2">
                                        <i class="fas fa-info-circle text-primary me-2"></i>
                                        <small class="text-muted">Details</small>
                                    </div>
                                    <p class="mb-0"><?php echo e($request->details); ?></p>
                                </div>
                                <?php endif; ?>

                                <div class="mt-3 pt-3 border-top">
                                    <small class="text-muted">
                                        <i class="fas fa-paper-plane me-1"></i>
                                        Received on 
                                        <?php
                                            try {
                                                echo $request->created_at->timezone('Asia/Thimphu')->format('d M Y, h:i A');
                                            } catch (Exception $e) {
                                                echo $request->created_at;
                                            }
                                        ?>
                                    </small>
                                </div>
                            </div>

                            <div class="card-footer bg-white border-0 pt-0">
                                <div class="d-grid gap-2">
                                    
                                    <?php if($request->status !== 'canceled' && !$request->request_accepted && !$request->date_time_updated): ?>
                                        <form action="<?php echo e(route('inspection.accept', $request->id)); ?>" method="POST" class="accept-form">
                                            <?php echo csrf_field(); ?>
                                            <button type="button" class="btn btn-success w-100 show-confirm-modal" 
                                                data-message="Do you accept the scheduled date and time?" 
                                                data-form-id="<?php echo e($request->id); ?>">
                                                <i class="fas fa-check me-2"></i>
                                                Accept Inspection
                                            </button>
                                        </form>
                                    <?php elseif($request->request_accepted): ?>
                                        <button class="btn btn-success w-100" disabled>
                                            <i class="fas fa-check-circle me-2"></i>
                                            Already Accepted
                                        </button>
                                    <?php endif; ?>

                                    <div class="row g-2">
                                        
                                        <?php if($request->status !== 'canceled' && !$request->request_accepted && !$request->date_time_updated): ?>
                                            <?php if($request->request_new_date_sent): ?>
                                                <div class="col-6">
                                                    <button class="btn btn-secondary w-100" disabled>
                                                        <i class="fas fa-clock me-2"></i>
                                                        Date Requested
                                                    </button>
                                                </div>
                                            <?php else: ?>
                                                <div class="col-6">
                                                    <form action="<?php echo e(route('inspection.editdatetime', $request->id)); ?>" method="GET" class="edit-form">
                                                        <?php echo csrf_field(); ?>
                                                        <button type="button" class="btn btn-warning w-100 show-confirm-modal" 
                                                            data-message="Are you sure you want to request a new date?" 
                                                            data-form-id="<?php echo e($request->id); ?>">
                                                            <i class="fas fa-edit me-2"></i>
                                                            New Date
                                                        </button>
                                                    </form>
                                                </div>
                                            <?php endif; ?>
                                        <?php endif; ?>

                                        
                                        <?php if($request->status !== 'canceled' && !$request->request_accepted && !$request->date_time_updated): ?>
                                            <div class="col-6">
                                                <form action="<?php echo e(route('inspection.cancel', $request->id)); ?>" method="POST" class="cancel-form">
                                                    <?php echo csrf_field(); ?>
                                                    <button type="button" class="btn btn-danger w-100 show-confirm-modal" 
                                                        data-message="Are you sure you want to cancel this inspection request?" 
                                                        data-form-id="<?php echo e($request->id); ?>">
                                                        <i class="fas fa-times me-2"></i>
                                                        Cancel
                                                    </button>
                                                </form>
                                            </div>
                                        <?php elseif($request->status === 'canceled'): ?>
                                            <div class="col-12">
                                                <button class="btn btn-secondary w-100" disabled>
                                                    <i class="fas fa-ban me-2"></i>
                                                    Request Canceled
                                                </button>
                                            </div>
                                        <?php endif; ?>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </div>
        <?php else: ?>
            <div class="text-center py-5">
                <div class="mb-4">
                    <i class="fas fa-search fa-4x text-muted opacity-50"></i>
                </div>
                <h4 class="text-muted mb-2">No Inspection Requests</h4>
                <p class="text-muted">You don't have any inspection requests at the moment.</p>
                <a href="<?php echo e(route('carowner.dashboard')); ?>" class="btn btn-primary">
                    <i class="fas fa-arrow-left me-2"></i>
                    Back to Dashboard
                </a>
            </div>
        <?php endif; ?>
    </div>
</div>

<!-- Enhanced Confirmation Modal -->
<div class="modal fade" id="confirmModal" tabindex="-1" aria-labelledby="confirmModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content border-0 shadow">
            <div class="modal-header bg-warning text-dark border-0">
                <h5 class="modal-title" id="confirmModalLabel">
                    <i class="fas fa-exclamation-triangle me-2"></i>
                    Confirmation Required
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body py-4" id="confirmMessage">
                Are you sure?
            </div>
            <div class="modal-footer border-0 pt-0">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                    <i class="fas fa-times me-2"></i>
                    Cancel
                </button>
                <button type="button" class="btn btn-primary" id="confirmBtn">
                    <i class="fas fa-check me-2"></i>
                    Confirm
                </button>
            </div>
        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('scripts'); ?>
<script>
    let selectedForm = null;

    // Handle confirmation modal
    document.querySelectorAll('.show-confirm-modal').forEach(button => {
        button.addEventListener('click', function () {
            const message = this.getAttribute('data-message');
            selectedForm = this.closest('form');
            document.getElementById('confirmMessage').textContent = message;
            const modal = new bootstrap.Modal(document.getElementById('confirmModal'));
            modal.show();
        });
    });

    // Handle confirm button click
    document.getElementById('confirmBtn').addEventListener('click', function () {
        if (selectedForm) {
            // Add loading state to the confirm button
            this.innerHTML = '<i class="fas fa-spinner fa-spin me-2"></i>Processing...';
            this.disabled = true;
            
            selectedForm.submit();
        }
    });

    // Auto-dismiss alerts after 5 seconds
    setTimeout(function() {
        $('.alert').alert('close');
    }, 5000);

    // Add hover effects to cards
    document.querySelectorAll('.card').forEach(card => {
        card.addEventListener('mouseenter', function() {
            this.style.transform = 'translateY(-2px)';
            this.style.transition = 'transform 0.2s ease';
        });
        
        card.addEventListener('mouseleave', function() {
            this.style.transform = 'translateY(0)';
        });
    });
</script>

<?php $__env->startPush('styles'); ?>
<style>
    .inspection-details {
        background: #f8f9fa;
        border-radius: 8px;
        padding: 15px;
    }
    
    .card {
        transition: all 0.2s ease;
        border-radius: 12px;
    }
    
    .card:hover {
        transform: translateY(-2px);
        box-shadow: 0 8px 25px rgba(0,0,0,0.1) !important;
    }
    
    .card-header {
        border-radius: 12px 12px 0 0 !important;
    }
    
    .btn {
        border-radius: 8px;
        font-weight: 500;
    }
    
    .badge {
        border-radius: 20px;
        padding: 8px 12px;
    }
    
    .modal-content {
        border-radius: 12px;
    }
    
    .text-primary {
        color: #0d6efd !important;
    }
    
    .bg-light {
        background-color: #f8f9fa !important;
    }
</style>
<?php $__env->stopPush(); ?>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.carowner', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\Thinley Norbu\Documents\GitHub\FinalProject\resources\views/CarOwner/inspection-messages.blade.php ENDPATH**/ ?>