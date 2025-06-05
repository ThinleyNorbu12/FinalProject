

<?php $__env->startSection('content'); ?>
<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-md-10">
            <div class="card shadow">
                <div class="card-header bg-primary text-white">
                    <h4 class="mb-0">Booking Summary</h4>
                </div>
                
                <div class="card-body">
                    <?php if(session('success')): ?>
                        <div class="alert alert-success alert-dismissible fade show" role="alert">
                            <?php echo e(session('success')); ?>

                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    <?php endif; ?>
                    
                    <?php if($booking): ?>
                        <div class="row">
                            <!-- Booking Details -->
                            <div class="col-md-6">
                                <h5 class="border-bottom pb-2 mb-3">Booking Details</h5>
                                <p><strong>Booking ID:</strong> #<?php echo e($booking->id); ?></p>
                                <p><strong>Booking Date:</strong> <?php echo e($booking->created_at->format('d M, Y h:i A')); ?></p>
                                <p><strong>Status:</strong> 
                                    <?php if($booking->status === 'confirmed'): ?>
                                        <span class="badge bg-success">Confirmed</span>
                                    <?php elseif($booking->status === 'pending_verification'): ?>
                                        <span class="badge bg-info">Payment Under Verification</span>
                                    <?php elseif($booking->status === 'cancelled'): ?>
                                        <span class="badge bg-danger">Cancelled</span>
                                    <?php elseif($booking->status === 'completed'): ?>
                                        <span class="badge bg-primary">Completed</span>
                                    <?php else: ?>
                                        <span class="badge bg-warning text-dark">Pending</span>
                                    <?php endif; ?>
                                </p>

                                
                                <?php if($booking->payment_method): ?>
                                    <p><strong>Payment Method:</strong> 
                                        <?php if($booking->payment_method === 'qr_code'): ?>
                                            QR Code Payment
                                        <?php elseif($booking->payment_method === 'bank_transfer'): ?>
                                            Bank Transfer
                                        <?php elseif($booking->payment_method === 'pay_later'): ?>
                                            Pay at Pickup
                                        <?php else: ?>
                                            <?php echo e(ucfirst(str_replace('_', ' ', $booking->payment_method))); ?>

                                        <?php endif; ?>
                                    </p>
                                <?php endif; ?>

                                
                                <?php if($booking->status === 'pending_verification' && $booking->payment_method === 'qr_code'): ?>
                                    <div class="alert alert-info">
                                        <i class="fas fa-clock me-2"></i>
                                        Your payment screenshot has been submitted and is being verified. We'll confirm your booking shortly.
                                    </div>
                                <?php endif; ?>
                                
                                <h5 class="border-bottom pb-2 mb-3 mt-4">Trip Details</h5>
                                <div class="row">
                                    <div class="col-md-6">
                                        <p><strong>Pick-up:</strong></p>
                                        <p><?php echo e($booking->pickup_location); ?></p>
                                        <p>
                                            <?php echo e($booking->pickup_datetime->setTimezone('Asia/Thimphu')->format('d M, Y h:i A')); ?>

                                        </p>
                                    </div>
                                    
                                    <div class="col-md-6">
                                        <p><strong>Drop-off:</strong></p>
                                        <p><?php echo e($booking->dropoff_location); ?></p>
                                        <p>
                                            <?php echo e($booking->dropoff_datetime->setTimezone('Asia/Thimphu')->format('d M, Y h:i A')); ?>

                                        </p>
                                    </div>                                    
                                </div>
                                
                                <div class="mt-4">
                                    <?php
                                        $hours = $booking->pickup_datetime->diffInHours($booking->dropoff_datetime);
                                        $days = floor($hours / 24);
                                        $remainingHours = $hours % 24;
                                    ?>
                                    <p><strong>Duration:</strong> 
                                        <?php if($days > 0): ?>
                                            <?php echo e($days); ?> day<?php echo e($days > 1 ? 's' : ''); ?>

                                        <?php endif; ?>
                                        <?php if($remainingHours > 0): ?>
                                            <?php echo e($remainingHours); ?> hour<?php echo e($remainingHours > 1 ? 's' : ''); ?>

                                        <?php endif; ?>
                                    </p>
                                </div>
                            </div>
                            
                            <!-- Vehicle Details -->
                            <div class="col-md-6">
                                <?php if($booking->car): ?>
                                    <h5 class="border-bottom pb-2 mb-3">Vehicle Details</h5>
                                    <div class="car-details p-3 bg-light rounded">
                                        <div class="text-center mb-3">
                                            <?php if($booking->car->images && $booking->car->images->count()): ?>
                                                <!-- Carousel for Images -->
                                                <div id="carImageCarouselSummary" class="carousel slide" data-bs-ride="carousel">
                                                    <div class="carousel-inner">
                                                        <?php $__currentLoopData = $booking->car->images; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $image): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                            <div class="carousel-item <?php echo e($key == 0 ? 'active' : ''); ?>">
                                                                <img src="<?php echo e(asset($image->image_path)); ?>" alt="<?php echo e($booking->car->maker); ?> <?php echo e($booking->car->model); ?>" class="d-block mx-auto" style="max-height: 150px;">
                                                            </div>
                                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                                    </div>
                                                    <button class="carousel-control-prev" type="button" data-bs-target="#carImageCarouselSummary" data-bs-slide="prev">
                                                        <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                                                        <span class="visually-hidden">Previous</span>
                                                    </button>
                                                    <button class="carousel-control-next" type="button" data-bs-target="#carImageCarouselSummary" data-bs-slide="next">
                                                        <span class="carousel-control-next-icon" aria-hidden="true"></span>
                                                        <span class="visually-hidden">Next</span>
                                                    </button>
                                                </div>
                                            <?php elseif($booking->car->car_image): ?>
                                                <img src="<?php echo e(asset($booking->car->car_image)); ?>" alt="<?php echo e($booking->car->maker); ?> <?php echo e($booking->car->model); ?>" class="img-fluid" style="max-height: 150px;">
                                            <?php else: ?>
                                                <div class="bg-secondary text-white p-4 rounded">
                                                    <i class="fas fa-car fa-3x"></i>
                                                </div>
                                            <?php endif; ?>
                                        </div>
                                        
                                        <h5 class="mb-3"><?php echo e($booking->car->maker); ?> <?php echo e($booking->car->model); ?></h5>
                                        
                                        <!-- Basic Vehicle Information -->
                                        <div class="row mb-2">
                                            <div class="col-6">
                                                <p class="mb-1"><i class="fas fa-cog me-2"></i><small>Transmission:</small><br>
                                                <strong><?php echo e(ucfirst($booking->car->transmission_type)); ?></strong></p>
                                            </div>
                                            <div class="col-6">
                                                <p class="mb-1"><i class="fas fa-gas-pump me-2"></i><small>Fuel Type:</small><br>
                                                <strong><?php echo e(ucfirst($booking->car->fuel_type)); ?></strong></p>
                                            </div>
                                        </div>
                                        
                                        <div class="row mb-2">
                                            <div class="col-6">
                                                <p class="mb-1"><i class="fas fa-users me-2"></i><small>Seats:</small><br>
                                                <strong><?php echo e($booking->car->number_of_seats); ?> passengers</strong></p>
                                            </div>
                                            <div class="col-6">
                                                <p class="mb-1"><i class="fas fa-door-open me-2"></i><small>Doors:</small><br>
                                                <strong><?php echo e($booking->car->number_of_doors); ?> doors</strong></p>
                                            </div>
                                        </div>
                                        
                                        <!-- Luggage Capacity -->
                                        <div class="row mb-2">
                                            <div class="col-6">
                                                <p class="mb-1"><i class="fas fa-suitcase me-2"></i><small>Large Bags:</small><br>
                                                <strong><?php echo e($booking->car->large_bags_capacity); ?></strong></p>
                                            </div>
                                            <div class="col-6">
                                                <p class="mb-1"><i class="fas fa-briefcase me-2"></i><small>Small Bags:</small><br>
                                                <strong><?php echo e($booking->car->small_bags_capacity); ?></strong></p>
                                            </div>
                                        </div>
                                        
                                        <!-- Vehicle Features -->
                                        <div class="mb-3">
                                            <p class="mb-2"><strong>Features:</strong></p>
                                            <div class="d-flex flex-wrap gap-1">
                                                <?php if($booking->car->air_conditioning === 'Yes'): ?>
                                                    <span class="badge bg-success"><i class="fas fa-snowflake me-1"></i>AC</span>
                                                <?php endif; ?>
                                                <?php if($booking->car->backup_camera === 'Yes'): ?>
                                                    <span class="badge bg-success"><i class="fas fa-video me-1"></i>Backup Camera</span>
                                                <?php endif; ?>
                                                <?php if($booking->car->bluetooth === 'Yes'): ?>
                                                    <span class="badge bg-success"><i class="fas fa-bluetooth me-1"></i>Bluetooth</span>
                                                <?php endif; ?>
                                                <?php if($booking->car->air_conditioning === 'No' && $booking->car->backup_camera === 'No' && $booking->car->bluetooth === 'No'): ?>
                                                    <span class="text-muted">Basic features</span>
                                                <?php endif; ?>
                                            </div>
                                        </div>
                                        
                                        <!-- Vehicle Condition & Registration -->
                                        <div class="row mb-2">
                                            <div class="col-6">
                                                <p class="mb-1"><i class="fas fa-star me-2"></i><small>Condition:</small><br>
                                                <strong><?php echo e(ucfirst($booking->car->car_condition)); ?></strong></p>
                                            </div>
                                            <div class="col-6">
                                                <p class="mb-1"><i class="fas fa-id-card me-2"></i><small>Registration:</small><br>
                                                <strong><?php echo e($booking->car->registration_no); ?></strong></p>
                                            </div>
                                        </div>
                                        
                                        <!-- Mileage Information -->
                                        <?php if($booking->car->mileage_limit || $booking->car->current_mileage): ?>
                                        <div class="row mb-2">
                                            <?php if($booking->car->mileage_limit): ?>
                                            <div class="col-6">
                                                <p class="mb-1"><i class="fas fa-road me-2"></i><small>Daily Limit:</small><br>
                                                <strong><?php echo e(number_format($booking->car->mileage_limit)); ?> km</strong></p>
                                            </div>
                                            <?php endif; ?>
                                            <?php if($booking->car->current_mileage): ?>
                                            <div class="col-6">
                                                <p class="mb-1"><i class="fas fa-tachometer-alt me-2"></i><small>Current Mileage:</small><br>
                                                <strong><?php echo e(number_format($booking->car->current_mileage)); ?> km</strong></p>
                                            </div>
                                            <?php endif; ?>
                                        </div>
                                        <?php endif; ?>
                                        
                                        <!-- Vehicle Type -->
                                        <div class="mb-3">
                                            <p class="mb-1"><i class="fas fa-car me-2"></i><small>Vehicle Type:</small><br>
                                            <strong><?php echo e(ucfirst($booking->car->vehicle_type)); ?></strong></p>
                                        </div>
                                        
                                        <!-- Pricing Information -->
                                        <div class="mt-3 pt-3 border-top">
                                            <h6>Rental Rates:</h6>
                                            <?php if($booking->car->rate_per_day): ?>
                                                <h4 class="text-primary">BTN <?php echo e(number_format($booking->car->rate_per_day, 2)); ?>/day</h4>
                                            <?php elseif($booking->car->price): ?>
                                                <h4 class="text-primary">BTN <?php echo e(number_format($booking->car->price, 2)); ?>/day</h4>
                                            <?php endif; ?>
                                            
                                            <?php if($booking->car->price_per_km): ?>
                                                <p class="mb-0 text-muted"><small>BTN <?php echo e(number_format($booking->car->price_per_km, 2)); ?>/km for excess mileage</small></p>
                                            <?php endif; ?>
                                        </div>
                                    </div>
                                <?php else: ?>
                                    <div class="alert alert-warning">
                                        Vehicle details not available
                                    </div>
                                <?php endif; ?>
                            </div>
                        </div>
                        
                        <!-- Price Summary -->
                        <?php if($booking->car): ?>
                        <?php
                            $hours = $booking->pickup_datetime->diffInHours($booking->dropoff_datetime);
                            $days = ceil($hours / 24); // Round up to full days for pricing
                            $dailyRate = $booking->car->rate_per_day ?? $booking->car->price ?? 0;
                            $insuranceFee = 200;
                            $serviceFee = 100;
                            $totalPrice = ($dailyRate * $days) + $insuranceFee + $serviceFee;
                        ?>

                        <div class="row mt-4">
                            <div class="col-12">
                                <div class="card bg-light">
                                    <div class="card-body">
                                        <h5>Price Summary</h5>
                                        <div class="row">
                                            <div class="col-md-8">
                                                <p><?php echo e($days); ?> day<?php echo e($days > 1 ? 's' : ''); ?> x BTN <?php echo e(number_format($dailyRate, 2)); ?></p>
                                                <p>Insurance</p>
                                                <p>Service Fee</p>
                                               <?php if($booking->car->mileage_limit): ?>
                                                    <p class="text-muted">
                                                        <small class="fw-bold">Daily mileage limit: <?php echo e(number_format($booking->car->mileage_limit)); ?> km</small>
                                                    </p>
                                                <?php endif; ?>


                                            </div>
                                            <div class="col-md-4 text-end">
                                                <p>BTN <?php echo e(number_format($dailyRate * $days, 2)); ?></p>
                                                <p>BTN <?php echo e(number_format($insuranceFee, 2)); ?></p>
                                                <p>BTN <?php echo e(number_format($serviceFee, 2)); ?></p>
                                                <?php if($booking->car->price_per_km && $booking->car->mileage_limit): ?>
                                                    <p class="text-muted"><small>BTN <?php echo e(number_format($booking->car->price_per_km, 2)); ?>/km excess</small></p>
                                                <?php endif; ?>
                                            </div>
                                        </div>
                                        <hr>
                                        <div class="row">
                                            <div class="col-md-8">
                                                <h5>Total</h5>
                                            </div>
                                            <div class="col-md-4 text-end">
                                                <h5>BTN <?php echo e(number_format($totalPrice, 2)); ?></h5>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <?php endif; ?>

                        <!-- Back to Home and Print Booking Buttons -->
                        <div class="row mt-4">
                            <div class="col-12">
                                <div class="d-flex justify-content-between">
                                    <?php if(auth()->guard('customer')->check()): ?>
                                        
                                        <?php if($booking->status === 'pending' && !$booking->payment_method): ?>
                                            <?php if(auth('customer')->user()->drivingLicense): ?>
                                                <a href="<?php echo e(route('payment.page', ['bookingId' => $booking->id])); ?>" class="btn btn-success">
                                                    <i class="fas fa-credit-card me-2"></i>Pay Now
                                                </a>
                                            <?php else: ?>
                                                <!-- Show verification prompt -->
                                                <div class="alert alert-warning w-100 text-center mb-0 me-3">
                                                    <div class="d-flex flex-column align-items-center">
                                                        <h5>Please upload your documents to get your profile verified!</h5>
                                                        <p class="mb-3">Your Profile is not verified.</p>
                                                        <a href="<?php echo e(route('customer.profile')); ?>" class="btn btn-primary">
                                                            <i class="fas fa-upload me-2"></i>Upload Driving License
                                                        </a>
                                                    </div>
                                                </div>
                                            <?php endif; ?>
                                        <?php elseif($booking->status === 'pending_verification'): ?>
                                            <div class="alert alert-success w-100 text-center mb-0 me-3">
                                                <i class="fas fa-check-circle me-2"></i>
                                                Payment submitted successfully! Your booking will be confirmed once payment is verified.
                                            </div>
                                        <?php elseif($booking->status === 'confirmed'): ?>
                                            <div class="alert alert-success w-100 text-center mb-0 me-3">
                                                <i class="fas fa-check-circle me-2"></i>
                                                Your booking is confirmed! We'll contact you before the pickup time.
                                            </div>
                                        <?php endif; ?>
                                    <?php endif; ?>
                                    
                                    <a href="#" class="btn btn-primary me-3" onclick="window.print()">
                                        <i class="fas fa-print me-2"></i>Print Booking
                                    </a>
                                    <a href="<?php echo e(route('home')); ?>" class="btn btn-primary">Browse Cars</a>
                                </div>
                            </div>
                        </div>

                    <?php else: ?>
                        <div class="alert alert-warning">
                            <h5>No booking information found!</h5>
                            <p>It seems like there's no booking information available. Please try booking a car first.</p>
                            <a href="<?php echo e(route('home')); ?>" class="btn btn-primary mt-3">Browse Cars</a>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('scripts'); ?>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        var carCarouselSummary = new bootstrap.Carousel(document.getElementById('carImageCarouselSummary'), {
            interval: 3000,
            ride: 'carousel'
        });
    });
</script>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\Thinley Norbu\Documents\GitHub\FinalProject\resources\views/booking/summary.blade.php ENDPATH**/ ?>