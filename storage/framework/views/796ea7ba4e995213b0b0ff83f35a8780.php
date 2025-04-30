

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
                                <p><strong>Booking Date:</strong> <?php echo e($booking->created_at->format('M d, Y')); ?></p>
                                <p><strong>Status:</strong> 
                                    <span class="badge bg-success">Confirmed</span>
                                </p>
                                
                                <h5 class="border-bottom pb-2 mb-3 mt-4">Trip Details</h5>
                                <div class="row">
                                    <div class="col-md-6">
                                        <p><strong>Pick-up:</strong></p>
                                        <p><?php echo e($booking->pickup_location); ?></p>
                                        <p><?php echo e(\Carbon\Carbon::parse($booking->pickup_date)->format('M d, Y')); ?></p>
                                    </div>
                                    <div class="col-md-6">
                                        <p><strong>Drop-off:</strong></p>
                                        <p><?php echo e($booking->dropoff_location); ?></p>
                                        <p><?php echo e(\Carbon\Carbon::parse($booking->dropoff_date)->format('M d, Y')); ?></p>
                                    </div>
                                </div>
                                
                                <div class="mt-4">
                                    <p><strong>Duration:</strong> 
                                        <?php echo e(\Carbon\Carbon::parse($booking->pickup_date)->diffInDays(\Carbon\Carbon::parse($booking->dropoff_date)) + 1); ?> days
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
                                        
                                        <h5 class="mb-2"><?php echo e($booking->car->maker); ?> <?php echo e($booking->car->model); ?></h5>
                                        <p class="mb-1"><i class="fas fa-cog me-2"></i> <?php echo e($booking->car->transmission_type); ?></p>
                                        <p class="mb-1"><i class="fas fa-gas-pump me-2"></i> <?php echo e($booking->car->fuel_type); ?></p>
                                        <p class="mb-1"><i class="fas fa-users me-2"></i> <?php echo e($booking->car->number_of_seats); ?> seats</p>
                                        
                                        <div class="mt-3 pt-3 border-top">
                                            <h6>Daily Rate:</h6>
                                            <h4>Nu. <?php echo e(number_format($booking->car->price, 2)); ?>/day</h4>
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
                        <!-- Price Summary -->
                        <?php if($booking->car): ?>
                        <?php
                            $days = \Carbon\Carbon::parse($booking->pickup_date)->diffInDays(\Carbon\Carbon::parse($booking->dropoff_date)) + 1;
                            $dailyRate = $booking->car->price;
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
                                                <p><?php echo e($days); ?> days x Nu. <?php echo e(number_format($dailyRate, 2)); ?></p>
                                                <p>Insurance</p>
                                                <p>Service Fee</p>
                                            </div>
                                            <div class="col-md-4 text-end">
                                                <p>Nu. <?php echo e(number_format($dailyRate * $days, 2)); ?></p>
                                                <p>Nu. <?php echo e(number_format($insuranceFee, 2)); ?></p>
                                                <p>Nu. <?php echo e(number_format($serviceFee, 2)); ?></p>
                                            </div>
                                        </div>
                                        <hr>
                                        <div class="row">
                                            <div class="col-md-8">
                                                <h5>Total</h5>
                                            </div>
                                            <div class="col-md-4 text-end">
                                                <h5>Nu. <?php echo e(number_format($totalPrice, 2)); ?></h5>
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
                                    
                                    
                                    
                                    <a href="<?php echo e(route('payment.page')); ?>" class="btn btn-success">
                                        <i class="fas fa-credit-card me-2"></i>Pay Now
                                    </a>                                    
                                    <a href="#" class="btn btn-primary" onclick="window.print()">
                                        <i class="fas fa-print me-2"></i>Print Booking
                                    </a>
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