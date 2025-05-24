

<?php $__env->startSection('title', 'Booking Details'); ?>

<?php $__env->startSection('breadcrumbs'); ?>
    <li class="breadcrumb-item">
        <a href="<?php echo e(route('admin.booked-car')); ?>">Booked Cars</a>
    </li>
    <li class="breadcrumb-item active">Booking #<?php echo e($booking->id); ?></li>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('page-header'); ?>
    <div class="d-flex justify-content-between align-items-center">
        <div>
            <h1 class="page-title">Booking Details</h1>
            <p class="text-muted mb-0">View and manage booking information</p>
        </div>
        <div>
            <a href="<?php echo e(route('admin.booked-car')); ?>" class="btn btn-outline-secondary">
                <i class="fas fa-arrow-left me-2"></i>Back to Bookings
            </a>
        </div>
    </div>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>
<div class="row">
    <!-- Booking Details Card -->
    <div class="col-md-8">
        <div class="card">
            <div class="card-header">
                <h5 class="mb-0">Booking Information</h5>
            </div>
            <div class="card-body">
                <div class="row mb-4">
                    <div class="col-md-6">
                        <h6 class="fw-bold">Booking ID</h6>
                        <p><?php echo e($booking->id); ?></p>
                    </div>
                    <div class="col-md-6">
                        <h6 class="fw-bold">Booking Status</h6>
                        <p>
                            <?php switch($booking->status):
                                case ('confirmed'): ?>
                                    <span class="badge bg-success">Confirmed</span>
                                    <?php break; ?>
                                <?php case ('pending'): ?>
                                    <span class="badge bg-warning">Pending</span>
                                    <?php break; ?>
                                <?php case ('pending_verification'): ?>
                                    <span class="badge bg-info">Pending Verification</span>
                                    <?php break; ?>
                                <?php case ('cancelled'): ?>
                                    <span class="badge bg-danger">Cancelled</span>
                                    <?php break; ?>
                                <?php case ('completed'): ?>
                                    <span class="badge bg-secondary">Completed</span>
                                    <?php break; ?>
                                <?php default: ?>
                                    <span class="badge bg-secondary"><?php echo e(ucfirst($booking->status)); ?></span>
                            <?php endswitch; ?>
                        </p>
                    </div>
                </div>

                <div class="row mb-4">
                    <div class="col-md-6">
                        <h6 class="fw-bold">Pickup Location</h6>
                        <p><?php echo e($booking->pickup_location); ?></p>
                    </div>
                    <div class="col-md-6">
                        <h6 class="fw-bold">Dropoff Location</h6>
                        <p><?php echo e($booking->dropoff_location); ?></p>
                    </div>
                </div>

                <div class="row mb-4">
                    <div class="col-md-6">
                        <h6 class="fw-bold">Pickup Date & Time</h6>
                        <p><?php echo e($booking->pickup_datetime->format('M d, Y h:i A')); ?></p>
                    </div>
                    <div class="col-md-6">
                        <h6 class="fw-bold">Return Date & Time</h6>
                        <p><?php echo e($booking->dropoff_datetime->format('M d, Y h:i A')); ?></p>
                    </div>
                </div>

                <div class="row mb-4">
                    <div class="col-md-6">
                        <h6 class="fw-bold">Booking Duration</h6>
                        <p><?php echo e($booking->pickup_datetime->diffInDays($booking->dropoff_datetime) + 1); ?> days</p>
                    </div>
                    <div class="col-md-6">
                        <h6 class="fw-bold">Created On</h6>
                        <p><?php echo e($booking->created_at->format('M d, Y h:i A')); ?></p>
                    </div>
                </div>

                <div class="row">
                    <div class="col-12">
                        <h6 class="fw-bold">Payment Information</h6>
                        <?php if($booking->payment): ?>
                            <div class="table-responsive">
                                <table class="table table-bordered">
                                    <tr>
                                        <th>Payment Method</th>
                                        <td><?php echo e(ucfirst(str_replace('_', ' ', $booking->payment->payment_method))); ?></td>
                                    </tr>
                                    <tr>
                                        <th>Amount</th>
                                        <td><?php echo e($booking->payment->currency); ?> <?php echo e(number_format($booking->payment->amount, 2)); ?></td>
                                    </tr>
                                    <tr>
                                        <th>Status</th>
                                        <td>
                                            <?php if($booking->payment->status === 'completed'): ?>
                                                <span class="badge bg-success">Paid</span>
                                            <?php elseif($booking->payment->status === 'pending_verification'): ?>
                                                <span class="badge bg-warning">Pending Verification</span>
                                            <?php else: ?>
                                                <span class="badge bg-danger"><?php echo e(ucfirst($booking->payment->status)); ?></span>
                                            <?php endif; ?>
                                        </td>
                                    </tr>
                                    <tr>
                                        <th>Reference Number</th>
                                        <td><?php echo e($booking->payment->reference_number); ?></td>
                                    </tr>
                                    <tr>
                                        <th>Payment Date</th>
                                        <td><?php echo e($booking->payment->payment_date->format('M d, Y h:i A')); ?></td>
                                    </tr>
                                </table>
                            </div>
                        <?php else: ?>
                            <p class="text-muted">No payment information available</p>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
            <div class="card-footer text-end">
                <button type="button" class="btn btn-warning" data-bs-toggle="modal" data-bs-target="#updateStatusModal">
                    <i class="fas fa-edit"></i> Update Status
                </button>
            </div>
        </div>
    </div>

    <!-- Customer & Car Info Cards -->
    <div class="col-md-4">
        <!-- Customer Info -->
        <div class="card mb-4">
            <div class="card-header">
                <h5 class="mb-0">Customer Information</h5>
            </div>             
            <div class="card-body">
                <?php if($booking->customer): ?>
                    <div class="d-flex align-items-center mb-3">
                        <div class="flex-shrink-0">
                            <?php if($booking->customer->profile_image && file_exists(public_path('customerprofile/' . $booking->customer->profile_image))): ?>
                                <img src="<?php echo e(asset('customerprofile/' . $booking->customer->profile_image)); ?>" class="rounded-circle" width="50" height="50" alt="Customer Avatar" style="object-fit: cover;">
                            <?php else: ?>
                                <img src="<?php echo e(asset('customerprofile/profile.png')); ?>" class="rounded-circle" width="50" height="50" alt="Customer Avatar">
                            <?php endif; ?>
                        </div>
                        <div class="flex-grow-1 ms-3">
                            <h6 class="mb-0"><?php echo e($booking->customer->name); ?></h6>
                            <p class="text-muted mb-0">Customer ID: <?php echo e($booking->customer->id); ?></p>
                        </div>
                    </div>

                    <div class="customer-details mt-3">
                        <p><i class="fas fa-envelope me-2"></i> <?php echo e($booking->customer->email); ?></p>
                        <p><i class="fas fa-phone me-2"></i> <?php echo e($booking->customer->phone ?? 'N/A'); ?></p>
                        <p><i class="fas fa-map-marker-alt me-2"></i> <?php echo e($booking->customer->address ?? 'N/A'); ?></p>
                    </div>

                    <a href="#" class="btn btn-sm btn-outline-primary mt-2">
                        <i class="fas fa-user"></i> View Customer Profile
                    </a>
                <?php else: ?>
                    <p class="text-muted">Customer information not available</p>
                <?php endif; ?>
            </div>
        </div>

        <!-- Car Info -->
        <div class="card">
            <div class="card-header">
                <h5 class="mb-0">Car Information</h5>
            </div>
            <div class="card-body">
                <?php if($booking->car): ?>
                    <!-- Car Images Carousel -->
                    <?php if($booking->car->images && count($booking->car->images)): ?>
                        <div class="carousel-container mb-4">
                            <div id="carImageCarousel" class="carousel slide" data-bs-ride="carousel">
                                <div class="carousel-inner">
                                    <?php $__currentLoopData = $booking->car->images; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $image): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <div class="carousel-item <?php echo e($key == 0 ? 'active' : ''); ?>">
                                            <img src="<?php echo e(asset($image->image_path)); ?>" class="d-block mx-auto" alt="Car Image" style="max-height: 200px; object-fit: cover;">
                                        </div>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                </div>
                                <button class="carousel-control-prev" type="button" data-bs-target="#carImageCarousel" data-bs-slide="prev">
                                    <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                                    <span class="visually-hidden">Previous</span>
                                </button>
                                <button class="carousel-control-next" type="button" data-bs-target="#carImageCarousel" data-bs-slide="next">
                                    <span class="carousel-control-next-icon" aria-hidden="true"></span>
                                    <span class="visually-hidden">Next</span>
                                </button>
                                <div class="carousel-indicators">
                                    <?php $__currentLoopData = $booking->car->images; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $image): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <button type="button" data-bs-target="#carImageCarousel" data-bs-slide-to="<?php echo e($key); ?>"
                                            class="<?php echo e($key == 0 ? 'active' : ''); ?>" aria-current="<?php echo e($key == 0 ? 'true' : 'false'); ?>"
                                            aria-label="Slide <?php echo e($key + 1); ?>"></button>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                </div>
                            </div>
                        </div>
                    <?php elseif(isset($booking->car->car_image) && !empty($booking->car->car_image)): ?>
                        <div class="text-center mb-3">
                            <img src="<?php echo e(asset($booking->car->car_image)); ?>" class="img-fluid rounded" alt="Car Image" style="max-height: 200px; object-fit: cover;">
                        </div>
                    <?php else: ?>
                        <div class="text-center mb-3">
                            <img src="<?php echo e(asset('carimage/defaultcar.jpg')); ?>" class="img-fluid rounded" alt="Car Image">
                        </div>
                    <?php endif; ?>
                    
                    <h5 class="mb-3"><?php echo e($booking->car->maker); ?> <?php echo e($booking->car->model); ?></h5>
                    
                    <div class="car-details">
                        <p><i class="fas fa-car me-2"></i> <strong>Type:</strong> <?php echo e($booking->car->vehicle_type ?? 'N/A'); ?></p>
                        <p><i class="fas fa-tachometer-alt me-2"></i> <strong>Mileage:</strong> <?php echo e(number_format($booking->car->mileage ?? 0)); ?> km</p>
                        <p><i class="fas fa-gas-pump me-2"></i> <strong>Fuel Type:</strong> <?php echo e($booking->car->fuel_type ?? 'N/A'); ?></p>
                        <p><i class="fas fa-money-bill-wave me-2"></i> <strong>Daily Rate:</strong> BTN <?php echo e(number_format($booking->car->price ?? 0, 2)); ?></p>
                    </div>
                    
                    <a href="#" class="btn btn-sm btn-outline-primary mt-2">
                        <i class="fas fa-info-circle"></i> View Car Details
                    </a>
                <?php else: ?>
                    <p class="text-muted">Car information not available</p>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>

<!-- Update Status Modal -->
<div class="modal fade" id="updateStatusModal" tabindex="-1" aria-labelledby="updateStatusModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="updateStatusModalLabel">Update Booking Status</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="<?php echo e(route('admin.booked-car.update-status', $booking->id)); ?>" method="POST">
                <?php echo csrf_field(); ?>
                <?php echo method_field('PUT'); ?>
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="status" class="form-label">Status</label>
                        <select name="status" id="status" class="form-select">
                            <option value="pending" <?php echo e($booking->status == 'pending' ? 'selected' : ''); ?>>Pending</option>
                            <option value="confirmed" <?php echo e($booking->status == 'confirmed' ? 'selected' : ''); ?>>Confirmed</option>
                            <option value="pending_verification" <?php echo e($booking->status == 'pending_verification' ? 'selected' : ''); ?>>Pending Verification</option>
                            <option value="cancelled" <?php echo e($booking->status == 'cancelled' ? 'selected' : ''); ?>>Cancelled</option>
                            <option value="completed" <?php echo e($booking->status == 'completed' ? 'selected' : ''); ?>>Completed</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="comment" class="form-label">Comment (Optional)</label>
                        <textarea name="comment" id="comment" class="form-control" rows="3"></textarea>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Save Changes</button>
                </div>
            </form>
        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.admin', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\Sangay Ngedup\Documents\GitHub\FinalProject\resources\views/admin/booking-details.blade.php ENDPATH**/ ?>