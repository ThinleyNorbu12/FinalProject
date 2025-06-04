

<?php $__env->startSection('title', 'Add Car Pricing'); ?>

<?php $__env->startSection('content'); ?>
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Add Car Pricing Information</h3>
                </div>
                
                <div class="card-body">
                    <?php if(session('success')): ?>
                        <div class="alert alert-success alert-dismissible fade show" role="alert">
                            <?php echo e(session('success')); ?>

                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                    <?php endif; ?>

                    <?php if(session('error')): ?>
                        <div class="alert alert-danger alert-dismissible fade show" role="alert">
                            <?php echo e(session('error')); ?>

                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                    <?php endif; ?>

                    <form action="<?php echo e(route('car-admin.add-price.store')); ?>" method="POST">
                        <?php echo csrf_field(); ?>
                        
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="car_id">Select Car <span class="text-danger">*</span></label>
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
                                            <option value="<?php echo e($car->id); ?>" <?php echo e(old('car_id') == $car->id ? 'selected' : ''); ?>>
                                                <?php echo e($car->maker ?? 'N/A'); ?> <?php echo e($car->model ?? 'N/A'); ?> - <?php echo e($car->registration_no ?? 'N/A'); ?>

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
                            </div>

                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="rate_per_day">Rate per Day (Nu.) <span class="text-danger">*</span></label>
                                    <input type="number" 
                                           name="rate_per_day" 
                                           id="rate_per_day" 
                                           class="form-control <?php $__errorArgs = ['rate_per_day'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                                           placeholder="Enter daily rate"
                                           step="0.01"
                                           min="0"
                                           value="<?php echo e(old('rate_per_day')); ?>"
                                           required>
                                    <?php $__errorArgs = ['rate_per_day'];
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
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="mileage_limit">Mileage Limit (km/day) <span class="text-danger">*</span></label>
                                    <input type="number" 
                                           name="mileage_limit" 
                                           id="mileage_limit" 
                                           class="form-control <?php $__errorArgs = ['mileage_limit'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                                           placeholder="Enter daily mileage limit"
                                           step="0.1"
                                           min="0"
                                           value="<?php echo e(old('mileage_limit')); ?>"
                                           required>
                                    <?php $__errorArgs = ['mileage_limit'];
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

                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="price_per_km">Price per Kilometer (Nu.) <span class="text-danger">*</span></label>
                                    <input type="number" 
                                           name="price_per_km" 
                                           id="price_per_km" 
                                           class="form-control <?php $__errorArgs = ['price_per_km'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                                           placeholder="Enter price per km above limit"
                                           step="0.01"
                                           min="0"
                                           value="<?php echo e(old('price_per_km')); ?>"
                                           required>
                                    <?php $__errorArgs = ['price_per_km'];
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
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="current_mileage">Current Mileage (km) <span class="text-danger">*</span></label>
                                    <input type="number" 
                                           name="current_mileage" 
                                           id="current_mileage" 
                                           class="form-control <?php $__errorArgs = ['current_mileage'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                                           placeholder="Enter current odometer reading"
                                           step="0.1"
                                           min="0"
                                           value="<?php echo e(old('current_mileage')); ?>"
                                           required>
                                    <?php $__errorArgs = ['current_mileage'];
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
                        </div>

                        <div class="form-group">
                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-save"></i> Save Pricing Information
                            </button>
                            <a href="<?php echo e(route('admin.dashboard')); ?>" class="btn btn-secondary">
                                <i class="fas fa-times"></i> Cancel
                            </a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Display existing pricing records -->
    <div class="row mt-4">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Current Car Pricing Records</h3>
                </div>
                <div class="card-body">
                    <?php
                        $pricingRecords = \App\Models\CarBooking::with('car')->latest()->get();
                    ?>
                    
                    <?php if($pricingRecords->count() > 0): ?>
                        <div class="table-responsive">
                            <table class="table table-bordered table-striped">
                                <thead>
                                    <tr>
                                        <th>Car</th>
                                        <th>Rate/Day</th>
                                        <th>Mileage Limit</th>
                                        <th>Price/KM</th>
                                        <th>Current Mileage</th>
                                        <th>Updated</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php $__currentLoopData = $pricingRecords; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $record): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <tr>
                                            <td><?php echo e($record->car->maker ?? 'N/A'); ?> <?php echo e($record->car->model ?? ''); ?></td>
                                            <td>Nu. <?php echo e(number_format($record->rate_per_day, 2)); ?></td>
                                            <td><?php echo e(number_format($record->mileage_limit, 1)); ?> km/day</td>
                                            <td>Nu. <?php echo e(number_format($record->price_per_km, 2)); ?></td>
                                            <td><?php echo e(number_format($record->current_mileage, 1)); ?> km</td>
                                            <td><?php echo e($record->updated_at->format('M d, Y H:i')); ?></td>
                                            <td>
                                                <button class="btn btn-sm btn-warning" onclick="editPricing(<?php echo e($record->id); ?>)">
                                                    <i class="fas fa-edit"></i> Edit
                                                </button>
                                            </td>
                                        </tr>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                </tbody>
                            </table>
                        </div>
                    <?php else: ?>
                        <p class="text-muted">No pricing records found.</p>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
.alert {
    margin-bottom: 20px;
}

.form-group label {
    font-weight: 600;
}

.text-danger {
    color: #dc3545 !important;
}

.card {
    box-shadow: 0 0 1px rgba(0,0,0,.125), 0 1px 3px rgba(0,0,0,.2);
}

.btn {
    margin-right: 10px;
}

.table {
    margin-bottom: 0;
}
</style>

<script>
function editPricing(id) {
    // You can implement edit functionality here
    alert('Edit functionality - Pricing ID: ' + id);
}
</script>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.admin', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\Thinley Norbu\Documents\GitHub\FinalProject\resources\views/admin/add-price.blade.php ENDPATH**/ ?>