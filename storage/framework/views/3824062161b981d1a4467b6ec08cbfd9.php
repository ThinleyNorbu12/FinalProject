

<?php $__env->startSection('title', 'Record Mileage'); ?>

<?php $__env->startSection('content'); ?>
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <div class="d-flex justify-content-between align-items-center">
                        <h4 class="card-title mb-0">
                            <i class="fas fa-tachometer-alt mr-2"></i>
                            Record Mileage
                        </h4>
                        <a href="<?php echo e(route('car-admin.record-mileage.create')); ?>" class="btn btn-primary">
                            <i class="fas fa-plus mr-1"></i>
                            Record New Mileage
                        </a>
                    </div>
                </div>

                <div class="card-body">
                    <!-- Search Form -->
                    <div class="row mb-4">
                        <div class="col-md-6">
                            <form action="<?php echo e(route('car-admin.record-mileage.search')); ?>" method="GET" class="d-flex">
                                <input type="text" name="search" class="form-control" 
                                       placeholder="Search by Registration No, Maker, or Model..." 
                                       value="<?php echo e(request('search')); ?>">
                                <button type="submit" class="btn btn-outline-primary ml-2">
                                    <i class="fas fa-search"></i>
                                </button>
                                <?php if(request('search')): ?>
                                    <a href="<?php echo e(route('car-admin.record-mileage')); ?>" class="btn btn-outline-secondary ml-2">
                                        <i class="fas fa-times"></i>
                                    </a>
                                <?php endif; ?>
                            </form>
                        </div>
                    </div>

                    <?php if(session('success')): ?>
                        <div class="alert alert-success alert-dismissible fade show" role="alert">
                            <i class="fas fa-check-circle mr-2"></i>
                            <?php echo e(session('success')); ?>

                            <button type="button" class="close" data-dismiss="alert">
                                <span>&times;</span>
                            </button>
                        </div>
                    <?php endif; ?>

                    <?php if($cars->count() > 0): ?>
                        <div class="table-responsive">
                            <table class="table table-hover">
                                <thead class="thead-light">
                                    <tr>
                                        <th>Registration No</th>
                                        <th>Car Details</th>
                                        <th>Current Mileage</th>
                                        <th>Start Mileage</th>
                                        <th>End Mileage</th>
                                        <th>Distance Traveled</th>
                                        <th>Status</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php $__currentLoopData = $cars; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $car): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <tr>
                                            <td>
                                                <strong class="text-primary"><?php echo e($car->registration_no); ?></strong>
                                            </td>
                                            <td>
                                                <div>
                                                    <strong><?php echo e($car->maker); ?> <?php echo e($car->model); ?></strong>
                                                </div>
                                            </td>
                                            <td>
                                                <?php if($car->mileage): ?>
                                                    <span class="badge badge-info"><?php echo e(number_format($car->mileage)); ?> km</span>
                                                <?php else: ?>
                                                    <span class="text-muted">Not recorded</span>
                                                <?php endif; ?>
                                            </td>
                                            <td>
                                                <?php if($car->start_mileage): ?>
                                                    <span class="badge badge-success"><?php echo e(number_format($car->start_mileage)); ?> km</span>
                                                <?php else: ?>
                                                    <span class="text-muted">Not set</span>
                                                <?php endif; ?>
                                            </td>
                                            <td>
                                                <?php if($car->end_mileage): ?>
                                                    <span class="badge badge-warning"><?php echo e(number_format($car->end_mileage)); ?> km</span>
                                                <?php else: ?>
                                                    <span class="text-muted">Not set</span>
                                                <?php endif; ?>
                                            </td>
                                            <td>
                                                <?php if($car->start_mileage && $car->end_mileage): ?>
                                                    <span class="badge badge-secondary">
                                                        <?php echo e(number_format($car->end_mileage - $car->start_mileage)); ?> km
                                                    </span>
                                                <?php elseif($car->start_mileage && $car->mileage): ?>
                                                    <span class="badge badge-info">
                                                        <?php echo e(number_format($car->mileage - $car->start_mileage)); ?> km
                                                    </span>
                                                <?php else: ?>
                                                    <span class="text-muted">-</span>
                                                <?php endif; ?>
                                            </td>
                                            <td>
                                                <span class="badge badge-success">
                                                    Inspection Approved
                                                </span>
                                            </td>
                                            <td>
                                                <div class="btn-group" role="group">
                                                    <a href="<?php echo e(route('car-admin.record-mileage.edit', $car->id)); ?>" 
                                                       class="btn btn-sm btn-outline-primary" title="Edit Mileage">
                                                        <i class="fas fa-edit"></i>
                                                    </a>
                                                </div>
                                            </td>
                                        </tr>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                </tbody>
                            </table>
                        </div>

                        <!-- Pagination -->
                        <div class="d-flex justify-content-center">
                            <?php echo e($cars->withQueryString()->links()); ?>

                        </div>
                    <?php else: ?>
                        <div class="text-center py-5">
                            <i class="fas fa-car fa-3x text-muted mb-3"></i>
                            <h5 class="text-muted">No cars found</h5>
                            <?php if(request('search')): ?>
                                <p class="text-muted">No cars match your search criteria.</p>
                                <a href="<?php echo e(route('car-admin.record-mileage')); ?>" class="btn btn-outline-primary">
                                    View All Cars
                                </a>
                            <?php else: ?>
                                <p class="text-muted">No cars with approved inspection decisions available for mileage recording.</p>
                            <?php endif; ?>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Mileage Information Modal -->
<div class="modal fade" id="mileageInfoModal" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">
                    <i class="fas fa-info-circle mr-2"></i>
                    Mileage Information
                </h5>
                <button type="button" class="close" data-dismiss="modal">
                    <span>&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-6">
                        <h6><i class="fas fa-tachometer-alt text-info mr-2"></i>Current Mileage</h6>
                        <p class="text-muted small">The current odometer reading of the vehicle.</p>
                    </div>
                    <div class="col-md-6">
                        <h6><i class="fas fa-play text-success mr-2"></i>Start Mileage</h6>
                        <p class="text-muted small">The mileage when the car was first registered or started service.</p>
                    </div>
                    <div class="col-md-6">
                        <h6><i class="fas fa-stop text-warning mr-2"></i>End Mileage</h6>
                        <p class="text-muted small">The final mileage reading (e.g., when service ends).</p>
                    </div>
                    <div class="col-md-6">
                        <h6><i class="fas fa-route text-secondary mr-2"></i>Distance Traveled</h6>
                        <p class="text-muted small">Calculated difference between start and end/current mileage.</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<?php $__env->stopSection(); ?>

<?php $__env->startPush('scripts'); ?>
<script>
    // Auto-hide success alerts after 5 seconds
    setTimeout(function() {
        $('.alert-success').fadeOut('slow');
    }, 5000);

    // Add tooltip for mileage info
    $(document).ready(function() {
        $('[data-toggle="tooltip"]').tooltip();
    });
</script>
<?php $__env->stopPush(); ?>
<?php echo $__env->make('layouts.admin', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\Thinley Norbu\Documents\GitHub\FinalProject\resources\views/admin/record-mileage/index.blade.php ENDPATH**/ ?>