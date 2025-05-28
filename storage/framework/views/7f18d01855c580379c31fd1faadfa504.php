

<?php $__env->startSection('title', 'Rejected Cars'); ?>

<?php $__env->startSection('breadcrumbs'); ?>
    <li class="breadcrumb-item active">Rejected Cars</li>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('page-header'); ?>
    <div class="d-flex justify-content-between align-items-center">
        <div>
            <h1 class="page-title">Rejected Cars</h1>
            <p class="page-description text-muted">View all cars that have been rejected during inspection</p>
        </div>
    </div>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>
    <div class="row">
        <div class="col-12">
            <div class="card shadow-sm">
                <div class="card-header bg-danger text-white">
                    <h5 class="card-title mb-0">
                        <i class="fas fa-times-circle me-2"></i>Rejected Cars List
                    </h5>
                </div>
                <div class="card-body">
                    <?php if($rejectedCars->count() > 0): ?>
                        <div class="table-responsive">
                            <table class="table table-striped table-hover">
                                <thead class="table-light">
                                    <tr>
                                        <th scope="col">Sl. No</th>
                                        <th scope="col">
                                            <i class="fas fa-industry me-1"></i>Maker
                                        </th>
                                        <th scope="col">
                                            <i class="fas fa-car me-1"></i>Model
                                        </th>
                                        <th scope="col">
                                            <i class="fas fa-tags me-1"></i>Vehicle Type
                                        </th>
                                        <th scope="col">
                                            <i class="fas fa-tools me-1"></i>Condition
                                        </th>
                                        <th scope="col">
                                            <i class="fas fa-dollar-sign me-1"></i>Price
                                        </th>
                                        <th scope="col">
                                            <i class="fas fa-id-card me-1"></i>Registration No
                                        </th>
                                        <th scope="col">
                                            <i class="fas fa-calendar me-1"></i>Rejected Date
                                        </th>
                                        <th scope="col">Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php $__currentLoopData = $rejectedCars; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $car): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <tr>
                                            <td>
                                                <span class="badge bg-secondary"><?php echo e($loop->iteration); ?></span>
                                            </td>
                                            <td>
                                                <strong><?php echo e($car->maker); ?></strong>
                                            </td>
                                            <td><?php echo e($car->model); ?></td>
                                            <td>
                                                <span class="badge bg-info"><?php echo e($car->vehicle_type); ?></span>
                                            </td>
                                            <td>
                                                <span class="badge bg-warning text-dark"><?php echo e($car->car_condition); ?></span>
                                            </td>
                                            <td>
                                                <strong class="text-success">$<?php echo e(number_format($car->price, 2)); ?></strong>
                                            </td>
                                            <td>
                                                <code><?php echo e($car->registration_no); ?></code>
                                            </td>
                                            <td>
                                                <?php if(isset($car->updated_at) && $car->updated_at): ?>
                                                    <small class="text-muted">
                                                        <?php echo e(\Carbon\Carbon::parse($car->updated_at)->format('M d, Y')); ?>

                                                    </small>
                                                <?php else: ?>
                                                    <small class="text-muted">N/A</small>
                                                <?php endif; ?>
                                            </td>
                                            <td>
                                                <div class="btn-group" role="group">
                                                    <button type="button" class="btn btn-sm btn-outline-primary" 
                                                            data-bs-toggle="modal" 
                                                            data-bs-target="#viewCarModal<?php echo e($car->id); ?>"
                                                            title="View Details">
                                                        <i class="fas fa-eye"></i>
                                                    </button>
                                                    <?php if(isset($car->rejection_reason)): ?>
                                                        <button type="button" class="btn btn-sm btn-outline-danger" 
                                                                data-bs-toggle="modal" 
                                                                data-bs-target="#reasonModal<?php echo e($car->id); ?>"
                                                                title="View Rejection Reason">
                                                            <i class="fas fa-exclamation-triangle"></i>
                                                        </button>
                                                    <?php endif; ?>
                                                </div>
                                            </td>
                                        </tr>

                                        <!-- View Car Details Modal -->
                                        <div class="modal fade" id="viewCarModal<?php echo e($car->id); ?>" tabindex="-1">
                                            <div class="modal-dialog modal-lg">
                                                <div class="modal-content">
                                                    <div class="modal-header bg-primary text-white">
                                                        <h5 class="modal-title">
                                                            <i class="fas fa-car me-2"></i>Car Details - <?php echo e($car->maker); ?> <?php echo e($car->model); ?>

                                                        </h5>
                                                        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                                                    </div>
                                                    <div class="modal-body">
                                                        <div class="row">
                                                            <div class="col-md-6">
                                                                <h6><i class="fas fa-info-circle text-primary me-2"></i>Basic Information</h6>
                                                                <table class="table table-sm">
                                                                    <tr><td><strong>Maker:</strong></td><td><?php echo e($car->maker); ?></td></tr>
                                                                    <tr><td><strong>Model:</strong></td><td><?php echo e($car->model); ?></td></tr>
                                                                    <tr><td><strong>Type:</strong></td><td><?php echo e($car->vehicle_type); ?></td></tr>
                                                                    <tr><td><strong>Condition:</strong></td><td><?php echo e($car->car_condition); ?></td></tr>
                                                                </table>
                                                            </div>
                                                            <div class="col-md-6">
                                                                <h6><i class="fas fa-dollar-sign text-success me-2"></i>Pricing & Registration</h6>
                                                                <table class="table table-sm">
                                                                    <tr><td><strong>Price:</strong></td><td>$<?php echo e(number_format($car->price, 2)); ?></td></tr>
                                                                    <tr><td><strong>Registration:</strong></td><td><?php echo e($car->registration_no); ?></td></tr>
                                                                    <tr><td><strong>Status:</strong></td><td><span class="badge bg-danger">Rejected</span></td></tr>
                                                                </table>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="modal-footer">
                                                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <!-- Rejection Reason Modal -->
                                        <?php if(isset($car->rejection_reason)): ?>
                                            <div class="modal fade" id="reasonModal<?php echo e($car->id); ?>" tabindex="-1">
                                                <div class="modal-dialog">
                                                    <div class="modal-content">
                                                        <div class="modal-header bg-danger text-white">
                                                            <h5 class="modal-title">
                                                                <i class="fas fa-exclamation-triangle me-2"></i>Rejection Reason
                                                            </h5>
                                                            <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                                                        </div>
                                                        <div class="modal-body">
                                                            <div class="alert alert-danger">
                                                                <h6><strong>Car:</strong> <?php echo e($car->maker); ?> <?php echo e($car->model); ?></h6>
                                                                <hr>
                                                                <p class="mb-0"><?php echo e($car->rejection_reason); ?></p>
                                                            </div>
                                                        </div>
                                                        <div class="modal-footer">
                                                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        <?php endif; ?>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                </tbody>
                            </table>
                        </div>

                        <?php if(method_exists($rejectedCars, 'links')): ?>
                            <div class="d-flex justify-content-center mt-4">
                                <?php echo e($rejectedCars->links()); ?>

                            </div>
                        <?php endif; ?>
                    <?php else: ?>
                        <div class="text-center py-5">
                            <div class="empty-state">
                                <i class="fas fa-check-circle text-success" style="font-size: 4rem; opacity: 0.3;"></i>
                                <h4 class="mt-3 text-muted">No Rejected Cars</h4>
                                <p class="text-muted">Great news! You don't have any rejected cars at the moment.</p>
                                <a href="<?php echo e(route('carowner.car-inspection')); ?>" class="btn btn-primary">
                                    <i class="fas fa-plus me-2"></i>Submit New Car for Inspection
                                </a>
                            </div>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
<?php $__env->stopSection(); ?>

<?php $__env->startPush('styles'); ?>
<style>
    .page-title {
        font-size: 1.75rem;
        font-weight: 600;
        color: #2c3e50;
        margin-bottom: 0.25rem;
    }
    
    .page-description {
        font-size: 0.95rem;
        margin-bottom: 0;
    }
    
    .card {
        border: none;
        border-radius: 0.75rem;
    }
    
    .card-header {
        border-radius: 0.75rem 0.75rem 0 0 !important;
        border: none;
        padding: 1rem 1.5rem;
    }
    
    .table th {
        border-top: none;
        font-weight: 600;
        color: #495057;
        padding: 1rem 0.75rem;
    }
    
    .table td {
        padding: 1rem 0.75rem;
        vertical-align: middle;
    }
    
    .table-hover tbody tr:hover {
        background-color: #f8f9fa;
    }
    
    .badge {
        font-size: 0.75rem;
        padding: 0.375rem 0.75rem;
    }
    
    .btn-group .btn {
        margin-right: 0.25rem;
    }
    
    .btn-group .btn:last-child {
        margin-right: 0;
    }
    
    .empty-state {
        padding: 2rem;
    }
    
    code {
        background-color: #f8f9fa;
        color: #e83e8c;
        padding: 0.25rem 0.5rem;
        border-radius: 0.25rem;
        font-size: 0.875rem;
    }
</style>
<?php $__env->stopPush(); ?>

<?php $__env->startPush('scripts'); ?>
<script>
    $(document).ready(function() {
        // Initialize tooltips
        var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
        var tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {
            return new bootstrap.Tooltip(tooltipTriggerEl);
        });
        
        // Add animation to table rows
        $('.table tbody tr').hover(
            function() {
                $(this).addClass('table-active');
            },
            function() {
                $(this).removeClass('table-active');
            }
        );
    });
</script>
<?php $__env->stopPush(); ?>
<?php echo $__env->make('layouts.carowner', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\Sangay Ngedup\Documents\GitHub\FinalProject\resources\views/CarOwner/rejected-cars.blade.php ENDPATH**/ ?>