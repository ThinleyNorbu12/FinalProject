

<?php $__env->startSection('title', 'Reject Vehicle Registration'); ?>

<?php $__env->startSection('breadcrumbs'); ?>
    <li class="breadcrumb-item">
        <a href="<?php echo e(route('car-admin.new-registration-cars')); ?>">Car Registration</a>
    </li>
    <li class="breadcrumb-item active">Reject Vehicle</li>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('page-header'); ?>
    <div class="d-flex justify-content-between align-items-center">
        <h1 class="page-title">
            <i class="fas fa-times-circle me-2"></i>
            Reject Vehicle Registration
        </h1>
    </div>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>
<div class="container mt-4">
    <div class="row justify-content-center">
        <div class="col-md-8">
            
            <div class="card shadow mb-4">
                <div class="card-header bg-danger text-white">
                    <h5 class="card-title mb-0"><i class="fas fa-car me-2"></i>Vehicle Information</h5>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6">
                            <p><strong>Maker:</strong> <?php echo e($car->maker); ?></p>
                            <p><strong>Model:</strong> <?php echo e($car->model); ?></p>
                        </div>
                        <div class="col-md-6">
                            <p><strong>Registration #:</strong> <code><?php echo e($car->registration_no); ?></code></p>
                            <p><strong>Submitted By:</strong> <?php echo e(optional($car->owner)->name ?? 'Unknown Owner'); ?></p>
                        </div>
                    </div>
                </div>
            </div>

            
            <div class="card shadow">
                <div class="card-header bg-danger text-white">
                    <h5 class="card-title mb-0"><i class="fas fa-comment-dots me-2"></i>Rejection Details</h5>
                </div>
                <div class="card-body">
                    <form action="<?php echo e(route('car-admin.rejectCar', $car->id)); ?>" method="POST" id="rejectionForm">
                        <?php echo csrf_field(); ?>

                        <div class="mb-4">
                            <label for="rejection_reason" class="form-label fw-bold">
                                Reason for Rejection <span class="text-danger">*</span>
                            </label>
                            <textarea name="rejection_reason" 
                                    id="rejection_reason" 
                                    class="form-control <?php $__errorArgs = ['rejection_reason'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" 
                                    rows="5"
                                    placeholder="Provide detailed reason for rejection..."
                                    required
                                    minlength="10"></textarea>
                            
                            <?php $__errorArgs = ['rejection_reason'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                <div class="invalid-feedback"><?php echo e($message); ?></div>
                            <?php else: ?>
                                <div class="form-text">Minimum 10 characters required</div>
                            <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                        </div>

                        <div class="d-flex justify-content-between align-items-center">
                            <a href="<?php echo e(url()->previous()); ?>" class="btn btn-outline-secondary">
                                <i class="fas fa-arrow-left me-2"></i>
                                Back to Details
                            </a>
                            
                            <button type="button" 
                                    class="btn btn-danger" 
                                    onclick="confirmRejection()">
                                <i class="fas fa-times-circle me-2"></i>
                                Confirm Rejection
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php $__env->startPush('scripts'); ?>
<script>
function confirmRejection() {
    const reason = document.getElementById('rejection_reason').value;
    const form = document.getElementById('rejectionForm');
    
    // Client-side validation
    if (reason.length < 10) {
        alert('Please provide at least 10 characters for the rejection reason.');
        return;
    }

    if (confirm('Are you absolutely sure you want to reject this registration?\n\nThis action cannot be undone.')) {
        form.submit();
    }
}

// Bootstrap validation
(function () {
  'use strict'
  const forms = document.querySelectorAll('#rejectionForm')
  Array.from(forms).forEach(form => {
    form.addEventListener('submit', event => {
      if (!form.checkValidity()) {
        event.preventDefault()
        event.stopPropagation()
      }
      form.classList.add('was-validated')
    }, false)
  })
})()
</script>
<?php $__env->stopPush(); ?>
<?php echo $__env->make('layouts.admin', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\Thinley Norbu\Documents\GitHub\FinalProject\resources\views/admin/reject-car.blade.php ENDPATH**/ ?>