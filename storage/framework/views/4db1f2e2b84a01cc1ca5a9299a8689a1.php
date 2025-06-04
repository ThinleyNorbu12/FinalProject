

<?php $__env->startSection('title', 'Record New Mileage'); ?>

<?php $__env->startSection('content'); ?>
<div class="container-fluid">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">
                    <div class="d-flex justify-content-between align-items-center">
                        <h4 class="card-title mb-0">
                            <i class="fas fa-plus mr-2"></i>
                            Record New Mileage
                        </h4>
                        <a href="<?php echo e(route('car-admin.record-mileage')); ?>" class="btn btn-outline-secondary">
                            <i class="fas fa-arrow-left mr-1"></i>
                            Back to List
                        </a>
                    </div>
                </div>

                <div class="card-body">
                    <form action="<?php echo e(route('car-admin.record-mileage.store')); ?>" method="POST">
                        <?php echo csrf_field(); ?>
                        
                        <div class="row">
                            <!-- Car Selection -->
                            <div class="col-md-12 mb-3">
                                <label for="car_id" class="form-label">
                                    <i class="fas fa-car mr-1"></i>
                                    Select Car <span class="text-danger">*</span>
                                </label>
                                <select name="car_id" id="car_id" class="form-control <?php $__errorArgs = ['car_id'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" required>
                                    <option value="">Choose a car...</option>
                                    <?php $__currentLoopData = $cars; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $car): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <option value="<?php echo e($car->id); ?>" 
                                                data-current-mileage="<?php echo e($car->mileage); ?>"
                                                <?php echo e(old('car_id') == $car->id ? 'selected' : ''); ?>>
                                            <?php echo e($car->registration_no); ?> - <?php echo e($car->maker); ?> <?php echo e($car->model); ?>

                                            <?php if($car->mileage): ?>
                                                (Current: <?php echo e(number_format($car->mileage)); ?> km)
                                            <?php endif; ?>
                                        </option>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                </select>
                                <?php $__errorArgs = ['car_id'];
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

                            <!-- Mileage Type -->
                            <div class="col-md-6 mb-3">
                                <label for="mileage_type" class="form-label">
                                    <i class="fas fa-tags mr-1"></i>
                                    Mileage Type <span class="text-danger">*</span>
                                </label>
                                <select name="mileage_type" id="mileage_type" class="form-control <?php $__errorArgs = ['mileage_type'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" required>
                                    <option value="">Select type...</option>
                                    <option value="current" <?php echo e(old('mileage_type') == 'current' ? 'selected' : ''); ?>>
                                        Current Mileage
                                    </option>
                                    <option value="start" <?php echo e(old('mileage_type') == 'start' ? 'selected' : ''); ?>>
                                        Start Mileage
                                    </option>
                                    <option value="end" <?php echo e(old('mileage_type') == 'end' ? 'selected' : ''); ?>>
                                        End Mileage
                                    </option>
                                </select>
                                <?php $__errorArgs = ['mileage_type'];
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

                            <!-- Mileage Value -->
                            <div class="col-md-6 mb-3">
                                <label for="mileage_value" class="form-label">
                                    <i class="fas fa-tachometer-alt mr-1"></i>
                                    Mileage Value (km) <span class="text-danger">*</span>
                                </label>
                                <input type="number" name="mileage_value" id="mileage_value" 
                                       class="form-control <?php $__errorArgs = ['mileage_value'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" 
                                       value="<?php echo e(old('mileage_value')); ?>" 
                                       min="0" step="0.1" required>
                                <?php $__errorArgs = ['mileage_value'];
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

                            <!-- Recording Date -->
                            <div class="col-md-6 mb-3">
                                <label for="recording_date" class="form-label">
                                    <i class="fas fa-calendar mr-1"></i>
                                    Recording Date <span class="text-danger">*</span>
                                </label>
                                <input type="date" name="recording_date" id="recording_date" 
                                       class="form-control <?php $__errorArgs = ['recording_date'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" 
                                       value="<?php echo e(old('recording_date', date('Y-m-d'))); ?>" 
                                       max="<?php echo e(date('Y-m-d')); ?>" required>
                                <?php $__errorArgs = ['recording_date'];
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

                            <!-- Notes -->
                            <div class="col-md-12 mb-3">
                                <label for="notes" class="form-label">
                                    <i class="fas fa-sticky-note mr-1"></i>
                                    Notes (Optional)
                                </label>
                                <textarea name="notes" id="notes" rows="3" 
                                          class="form-control <?php $__errorArgs = ['notes'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" 
                                          placeholder="Add any additional notes about this mileage recording..."><?php echo e(old('notes')); ?></textarea>
                                <?php $__errorArgs = ['notes'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                    <div class="invalid-feedback"><?php echo e($message); ?></div>
                                <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                                <small class="form-text text-muted">Maximum 500 characters</small>
                            </div>
                        </div>

                        <!-- Current Car Info Display -->
                        <div id="car-info" class="alert alert-info" style="display: none;">
                            <h6><i class="fas fa-info-circle mr-2"></i>Current Car Information</h6>
                            <div id="car-details"></div>
                        </div>

                        <!-- Mileage Type Information -->
                        <div class="alert alert-light border">
                            <h6><i class="fas fa-lightbulb mr-2"></i>Mileage Types Explanation</h6>
                            <div class="row">
                                <div class="col-md-4">
                                    <strong>Current Mileage:</strong>
                                    <p class="small text-muted mb-0">The current odometer reading</p>
                                </div>
                                <div class="col-md-4">
                                    <strong>Start Mileage:</strong>
                                    <p class="small text-muted mb-0">Initial mileage when service started</p>
                                </div>
                                <div class="col-md-4">
                                    <strong>End Mileage:</strong>
                                    <p class="small text-muted mb-0">Final mileage when service ended</p>
                                </div>
                            </div>
                        </div>

                        <!-- Submit Buttons -->
                        <div class="d-flex justify-content-end">
                            <a href="<?php echo e(route('car-admin.record-mileage')); ?>" class="btn btn-secondary mr-2">
                                <i class="fas fa-times mr-1"></i>
                                Cancel
                            </a>
                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-save mr-1"></i>
                                Record Mileage
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
document.addEventListener('DOMContentLoaded', function() {
    const carSelect = document.getElementById('car_id');
    const carInfo = document.getElementById('car-info');
    const carDetails = document.getElementById('car-details');
    const mileageTypeSelect = document.getElementById('mileage_type');
    const mileageValueInput = document.getElementById('mileage_value');

    // Show car information when a car is selected
    carSelect.addEventListener('change', function() {
        const selectedOption = this.options[this.selectedIndex];
        
        if (this.value) {
            const currentMileage = selectedOption.getAttribute('data-current-mileage');
            const carText = selectedOption.text;
            
            let infoHtml = `<strong>Selected Car:</strong> ${carText}<br>`;
            
            if (currentMileage && currentMileage !== 'null') {
                infoHtml += `<strong>Current Recorded Mileage:</strong> ${Number(currentMileage).toLocaleString()} km`;
            } else {
                infoHtml += `<strong>Current Recorded Mileage:</strong> <span class="text-warning">Not recorded yet</span>`;
            }
            
            carDetails.innerHTML = infoHtml;
            carInfo.style.display = 'block';
        } else {
            carInfo.style.display = 'none';
        }
    });

    // Trigger the change event if a car is already selected (for edit mode)
    if (carSelect.value) {
        carSelect.dispatchEvent(new Event('change'));
    }

    // Add validation hints based on mileage type
    mileageTypeSelect.addEventListener('change', function() {
        const selectedCar = carSelect.options[carSelect.selectedIndex];
        const currentMileage = selectedCar ? selectedCar.getAttribute('data-current-mileage') : null;
        
        if (this.value && currentMileage && currentMileage !== 'null') {
            const current = parseFloat(currentMileage);
            
            switch(this.value) {
                case 'current':
                    mileageValueInput.setAttribute('min', current > 0 ? current : 0);
                    break;
                case 'start':
                    mileageValueInput.setAttribute('min', 0);
                    mileageValueInput.setAttribute('max', current);
                    break;
                case 'end':
                    mileageValueInput.setAttribute('min', current);
                    break;
            }
        } else {
            mileageValueInput.setAttribute('min', 0);
            mileageValueInput.removeAttribute('max');
        }
    });

    // Character counter for notes
    const notesTextarea = document.getElementById('notes');
    const maxLength = 500;
    
    // Create character counter element
    const counterElement = document.createElement('small');
    counterElement.className = 'form-text text-muted';
    counterElement.innerHTML = `<span id="char-count">0</span>/${maxLength} characters`;
    notesTextarea.parentNode.appendChild(counterElement);
    
    const charCount = document.getElementById('char-count');
    
    notesTextarea.addEventListener('input', function() {
        const remaining = this.value.length;
        charCount.textContent = remaining;
        
        if (remaining > maxLength * 0.9) {
            charCount.className = 'text-warning';
        } else if (remaining > maxLength * 0.95) {
            charCount.className = 'text-danger';
        } else {
            charCount.className = '';
        }
    });
});
</script>
<?php $__env->stopPush(); ?>
<?php echo $__env->make('layouts.admin', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\Thinley Norbu\Documents\GitHub\FinalProject\resources\views/admin/record-mileage/create.blade.php ENDPATH**/ ?>