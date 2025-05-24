

<?php $__env->startSection('title', 'Request Car Inspection'); ?>

<?php $__env->startSection('breadcrumbs'); ?>
    <li class="breadcrumb-item">
        <a href="<?php echo e(route('car-admin.new-registration-cars')); ?>">Car Registration</a>
    </li>
    
    <li class="breadcrumb-item active">Request Inspection</li>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('page-header'); ?>
    <div class="d-flex justify-content-between align-items-center">
        <h1 class="page-title">
            <i class="fas fa-clipboard-check me-2"></i>
            Request for Car Inspection
        </h1>
    </div>
<?php $__env->stopSection(); ?>


<?php $__env->startSection('content'); ?>
<div class="container mt-4">
    <div class="row justify-content-center">
        <div class="col-12 col-lg-10">
            
            

            
            <div class="card shadow mb-4">
                <div class="card-header bg-primary text-white">
                    <h5 class="card-title mb-0"><i class="fas fa-car me-2"></i>Vehicle Details</h5>
                </div>
                <div class="card-body">
                    <div class="row g-3">
                        <div class="col-12 col-sm-6 col-md-4">
                            <p class="mb-2"><strong>Maker:</strong><br class="d-sm-none"> <?php echo e($car->maker); ?></p>
                        </div>
                        <div class="col-12 col-sm-6 col-md-4">
                            <p class="mb-2"><strong>Model:</strong><br class="d-sm-none"> <?php echo e($car->model); ?></p>
                        </div>
                        <div class="col-12 col-md-4">
                            <p class="mb-2"><strong>Registration #:</strong><br class="d-md-none"> <code><?php echo e($car->registration_no); ?></code></p>
                        </div>
                    </div>
                </div>
            </div>

            
            <div class="card shadow mb-4">
                <div class="card-header bg-secondary text-white">
                    <h5 class="card-title mb-0"><i class="fas fa-user me-2"></i>Owner Information</h5>
                </div>
                <div class="card-body">
                    <?php if($car->owner): ?>
                        <div class="row g-3">
                            <div class="col-12 col-md-6">
                                <p class="mb-2"><strong>Name:</strong><br class="d-md-none"> <?php echo e($car->owner->name); ?></p>
                            </div>
                            <div class="col-12 col-md-6">
                                <p class="mb-2">
                                    <strong>Email:</strong><br class="d-md-none"> 
                                    <a href="mailto:<?php echo e($car->owner->email); ?>" class="text-break"><?php echo e($car->owner->email); ?></a>
                                </p>
                            </div>
                        </div>
                    <?php else: ?>
                        <div class="alert alert-warning mb-0">No owner information available</div>
                    <?php endif; ?>
                </div>
            </div>

            
            <div class="card shadow">
                <div class="card-header bg-info text-white">
                    <h5 class="card-title mb-0"><i class="fas fa-clipboard-list me-2"></i>Inspection Details</h5>
                </div>
                <div class="card-body">
                    <form action="<?php echo e(url('car-admin/submit-inspection-request/' . $car->id)); ?>" method="POST">
                        <?php echo csrf_field(); ?>
                        
                        
                        <div class="form-row-mobile form-group-spacing">
                            <div>
                                <label for="date" class="form-label">Inspection Date <span class="text-danger">*</span></label>
                                <input type="date" 
                                       id="date" 
                                       name="date" 
                                       class="form-control <?php $__errorArgs = ['date'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" 
                                       min="<?php echo e(date('Y-m-d')); ?>" 
                                       required>
                                <?php $__errorArgs = ['date'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                    <div class="invalid-feedback"><?php echo e($message); ?></div>
                                <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                            </div>

                            <div>
                                <label for="time" class="form-label">Time Slot <span class="text-danger">*</span></label>
                                <select id="time" 
                                        name="time" 
                                        class="form-select <?php $__errorArgs = ['time'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" 
                                        required
                                        disabled>
                                    <option value="">Select date first</option>
                                </select>
                                <div class="spinner-border text-primary mt-2 d-none" id="timeLoader" role="status">
                                    <span class="visually-hidden">Loading...</span>
                                </div>
                                <?php $__errorArgs = ['time'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                    <div class="invalid-feedback"><?php echo e($message); ?></div>
                                <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                            </div>

                            <div>
                                <label for="location" class="form-label">Location <span class="text-danger">*</span></label>
                                <input type="text" 
                                       id="location" 
                                       name="location" 
                                       class="form-control <?php $__errorArgs = ['location'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" 
                                       placeholder="Enter inspection location"
                                       required>
                                <?php $__errorArgs = ['location'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                    <div class="invalid-feedback"><?php echo e($message); ?></div>
                                <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                            </div>
                        </div>

                        
                        <div class="form-group-spacing">
                            <label for="details" class="form-label">Additional Notes</label>
                            <textarea id="details" 
                                      name="details" 
                                      class="form-control <?php $__errorArgs = ['details'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" 
                                      rows="4"
                                      placeholder="Any special requirements or notes..."></textarea>
                            <?php $__errorArgs = ['details'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                <div class="invalid-feedback"><?php echo e($message); ?></div>
                            <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                        </div>

                        
                        <div class="text-end">
                            <button type="submit" class="btn btn-primary btn-lg">
                                <i class="fas fa-paper-plane me-2"></i>
                                Submit Request
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
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
$(document).ready(function() {
    const timeField = $('#time');
    const timeLoader = $('#timeLoader');

    $('#date').on('change', function() {
        const selectedDate = $(this).val();
        timeField.prop('disabled', true).html('<option value="">Loading time slots...</option>');
        timeLoader.removeClass('d-none');

        $.ajax({
            url: "<?php echo e(route('car-admin.getAvailableTimes')); ?>",
            type: "GET",
            data: { date: selectedDate },
            success: function(response) {
                let options = '<option value="">Select time slot</option>';
                
                if (response.length > 0) {
                    response.forEach(slot => {
                        options += `<option value="${slot}">${slot}</option>`;
                    });
                } else {
                    options = '<option value="" disabled>No available slots</option>';
                }
                
                timeField.html(options).prop('disabled', false);
            },
            error: function() {
                timeField.html('<option value="" disabled>Error loading slots</option>');
            },
            complete: function() {
                timeLoader.addClass('d-none');
            }
        });
    });

    // Enable form validation
    $('form').on('submit', function(e) {
        if (!this.checkValidity()) {
            e.preventDefault();
            e.stopPropagation();
        }
        this.classList.add('was-validated');
    });
});
</script>
<?php $__env->stopPush(); ?>
<?php echo $__env->make('layouts.admin', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\Thinley Norbu\Documents\GitHub\FinalProject\resources\views/admin/request-inspection.blade.php ENDPATH**/ ?>