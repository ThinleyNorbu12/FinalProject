


<?php $__env->startSection('title', 'Edit Mileage - ' . $car->registration_no); ?>

<?php $__env->startSection('content'); ?>
<div class="container-fluid">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">
                    <div class="d-flex justify-content-between align-items-center">
                        <h4 class="card-title mb-0">
                            <i class="fas fa-edit mr-2"></i>
                            Edit Mileage - <?php echo e($car->registration_no); ?>

                        </h4>
                        <a href="<?php echo e(route('car-admin.record-mileage')); ?>" class="btn btn-outline-secondary">
                            <i class="fas fa-arrow-left mr-1"></i>
                            Back to List
                        </a>
                    </div>
                </div>

                <div class="card-body">
                    <!-- Car Information Card -->
                    <div class="alert alert-info mb-4">
                        <h6><i class="fas fa-car mr-2"></i>Car Information</h6>
                        <div class="row">
                            <div class="col-md-6">
                                <strong>Registration No:</strong> <?php echo e($car->registration_no); ?><br>
                                <strong>Make & Model:</strong> <?php echo e($car->maker); ?> <?php echo e($car->model); ?><br>
                                <strong>Vehicle Type:</strong> <?php echo e(ucfirst($car->vehicle_type)); ?><br>
                                <strong>Status:</strong> 
                                <span class="badge badge-<?php echo e($car->status === 'approved' ? 'success' : 'warning'); ?>">
                                    <?php echo e(ucfirst($car->status)); ?>

                                </span>
                            </div>
                            <div class="col-md-6">
                                <strong>Current Mileage:</strong> 
                                <?php echo e($car->mileage ? number_format($car->mileage) . ' km' : 'Not recorded'); ?><br>
                                <strong>Start Mileage:</strong> 
                                <?php echo e($car->start_mileage ? number_format($car->start_mileage) . ' km' : 'Not set'); ?><br>
                                <strong>End Mileage:</strong> 
                                <?php echo e($car->end_mileage ? number_format($car->end_mileage) . ' km' : 'Not set'); ?><br>
                                <?php if($car->start_mileage && ($car->end_mileage || $car->mileage)): ?>
                                    <strong>Distance Traveled:</strong> 
                                    <?php echo e(number_format(($car->end_mileage ?: $car->mileage) - $car->start_mileage)); ?> km
                                <?php endif; ?>
                            </div>
                        </div>
                    </div>

                    <form action="<?php echo e(route('car-admin.record-mileage.update', $car->id)); ?>" method="POST">
                        <?php echo csrf_field(); ?>
                        <?php echo method_field('PUT'); ?>
                        
                        <div class="row">
                            <!-- Current Mileage -->
                            <div class="col-md-4 mb-3">
                                <label for="mileage" class="form-label">
                                    <i class="fas fa-tachometer-alt mr-1 text-info"></i>
                                    Current Mileage (km)
                                </label>
                                <input type="number" name="mileage" id="mileage" 
                                       class="form-control <?php $__errorArgs = ['mileage'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" 
                                       value="<?php echo e(old('mileage', $car->mileage)); ?>" 
                                       min="0" step="0.1" placeholder="Enter current mileage">
                                <?php $__errorArgs = ['mileage'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                    <div class="invalid-feedback"><?php echo e($message); ?></div>
                                <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                                <small class="form-text text-muted">Current odometer reading</small>
                            </div>

                            <!-- Start Mileage -->
                            <div class="col-md-4 mb-3">
                                <label for="start_mileage" class="form-label">
                                    <i class="fas fa-play mr-1 text-success"></i>
                                    Start Mileage (km)
                                </label>
                                <input type="number" name="start_mileage" id="start_mileage" 
                                       class="form-control <?php $__errorArgs = ['start_mileage'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" 
                                       value="<?php echo e(old('start_mileage', $car->start_mileage)); ?>" 
                                       min="0" step="0.1" placeholder="Enter start mileage">
                                <?php $__errorArgs = ['start_mileage'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                    <div class="invalid-feedback"><?php echo e($message); ?></div>
                                <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                                <small class="form-text text-muted">Initial mileage when service started</small>
                            </div>

                            <!-- End Mileage -->
                            <div class="col-md-4 mb-3">
                                <label for="end_mileage" class="form-label">
                                    <i class="fas fa-stop mr-1 text-warning"></i>
                                    End Mileage (km)
                                </label>
                                <input type="number" name="end_mileage" id="end_mileage" 
                                       class="form-control <?php $__errorArgs = ['end_mileage'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" 
                                       value="<?php echo e(old('end_mileage', $car->end_mileage)); ?>" 
                                       min="0" step="0.1" placeholder="Enter end mileage">
                                <?php $__errorArgs = ['end_mileage'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                    <div class="invalid-feedback"><?php echo e($message); ?></div>
                                <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                                <small class="form-text text-muted">Final mileage when service ended</small>
                            </div>
                        </div>

                        <!-- Calculated Distance -->
                        <div class="alert alert-secondary" id="distance-info" style="display: none;">
                            <h6><i class="fas fa-route mr-2"></i>Calculated Distance</h6>
                            <div id="distance-details"></div>
                        </div>

                        <!-- Validation Rules -->
                        <div class="alert alert-light border">
                            <h6><i class="fas fa-exclamation-triangle mr-2 text-warning"></i>Validation Rules</h6>
                            <ul class="mb-0 small">
                                <li>Current mileage should be greater than or equal to start mileage</li>
                                <li>End mileage should be greater than or equal to start mileage</li>
                                <li>End mileage should be greater than or equal to current mileage</li>
                                <li>All mileage values must be positive numbers</li>
                            </ul>
                        </div>

                        <!-- Submit Buttons -->
                        <div class="d-flex justify-content-end">
                            <a href="<?php echo e(route('car-admin.record-mileage')); ?>" class="btn btn-secondary mr-2">
                                <i class="fas fa-times mr-1"></i>
                                Cancel
                            </a>
                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-save mr-1"></i>
                                Update Mileage
                            </button>
                        </div>
                    </form>
                </div>
            </div>

            <!-- Mileage History Card (if you want to add history tracking later) -->
            <div class="card mt-4">
                <div class="card-header">
                    <h5 class="card-title mb-0">
                        <i class="fas fa-history mr-2"></i>
                        Quick Actions
                    </h5>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="d-flex align-items-center mb-2">
                                <i class="fas fa-calculator text-primary mr-2"></i>
                                <span>Calculate fuel efficiency or maintenance schedules</span>
                            </div>
                            <div class="d-flex align-items-center mb-2">
                                <i class="fas fa-chart-line text-success mr-2"></i>
                                <span>Track mileage trends over time</span>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="d-flex align-items-center mb-2">
                                <i class="fas fa-bell text-warning mr-2"></i>
                                <span>Set maintenance reminders based on mileage</span>
                            </div>
                            <div class="d-flex align-items-center mb-2">
                                <i class="fas fa-file-export text-info mr-2"></i>
                                <span>Export mileage reports</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php $__env->startPush('scripts'); ?>
<script>
document.addEventListener('DOMContentLoaded', function() {
    const mileageInput = document.getElementById('mileage');
    const startMileageInput = document.getElementById('start_mileage');
    const endMileageInput = document.getElementById('end_mileage');
    const distanceInfo = document.getElementById('distance-info');
    const distanceDetails = document.getElementById('distance-details');

    function calculateDistance() {
        const mileage = parseFloat(mileageInput.value) || 0;
        const startMileage = parseFloat(startMileageInput.value) || 0;
        const endMileage = parseFloat(endMileageInput.value) || 0;

        let html = '';
        let showInfo = false;

        if (startMileage && mileage && mileage >= startMileage) {
            const currentDistance = mileage - startMileage;
            html += `<strong>Distance from Start to Current:</strong> ${currentDistance.toLocaleString()} km<br>`;
            showInfo = true;
        }

        if (startMileage && endMileage && endMileage >= startMileage) {
            const totalDistance = endMileage - startMileage;
            html += `<strong>Total Distance (Start to End):</strong> ${totalDistance.toLocaleString()} km<br>`;
            showInfo = true;
        }

        if (mileage && endMileage && endMileage >= mileage) {
            const remainingDistance = endMileage - mileage;
            html += `<strong>Remaining Distance (Current to End):</strong> ${remainingDistance.toLocaleString()} km`;
            showInfo = true;
        }

        if (showInfo) {
            distanceDetails.innerHTML = html;
            distanceInfo.style.display = 'block';
        } else {
            distanceInfo.style.display = 'none';
        }
    }

    function validateMileage() {
        const mileage = parseFloat(mileageInput.value) || 0;
        const startMileage = parseFloat(startMileageInput.value) || 0;
        const endMileage = parseFloat(endMileageInput.value) || 0;

        // Reset validation states
        [mileageInput, startMileageInput, endMileageInput].forEach(input => {
            input.classList.remove('is-invalid', 'is-valid');
        });

        let isValid = true;

        // Validate current mileage
        if (mileage && startMileage && mileage < startMileage) {
            mileageInput.classList.add('is-invalid');
            isValid = false;
        } else if (mileage && startMileage) {
            mileageInput.classList.add('is-valid');
        }

        // Validate end mileage
        if (endMileage && startMileage && endMileage < startMileage) {
            endMileageInput.classList.add('is-invalid');
            isValid = false;
        } else if (endMileage && mileage && endMileage < mileage) {
            endMileageInput.classList.add('is-invalid');
            isValid = false;
        } else if (endMileage && (startMileage || mileage)) {
            endMileageInput.classList.add('is-valid');
        }

        // Validate start mileage
        if (startMileage && ((mileage && startMileage <= mileage) || (endMileage && startMileage <= endMileage))) {
            startMileageInput.classList.add('is-valid');
        }

        return isValid;
    }

    function updateFields() {
        validateMileage();
        calculateDistance();
    }

    // Add event listeners
    mileageInput.addEventListener('input', updateFields);
    startMileageInput.addEventListener('input', updateFields);
    endMileageInput.addEventListener('input', updateFields);

    // Initial calculation
    updateFields();

    // Form submission validation
    document.querySelector('form').addEventListener('submit', function(e) {
        if (!validateMileage()) {
            e.preventDefault();
            alert('Please fix the validation errors before submitting.');
        }
    });
});
</script>
<?php $__env->stopPush(); ?>
<?php echo $__env->make('layouts.admin', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\Thinley Norbu\Documents\GitHub\FinalProject\resources\views/admin/record-mileage/edit.blade.php ENDPATH**/ ?>