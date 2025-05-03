<!-- Link to the external CSS file -->
<link rel="stylesheet" href="<?php echo e(asset('assets/css/cars/book.css')); ?>">
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>




<?php $__env->startSection('content'); ?>
<div class="container py-4">
    <div class="row">
        <div class="col-lg-10 col-md-12 mx-auto">
            <!-- Car Title -->
            <h3 class="text-center mb-3"><?php echo e($car->maker); ?> <?php echo e($car->model); ?></h3>

            <!-- Image Section -->
            <?php if($car->images && count($car->images)): ?>
                <div class="carousel-container mb-4">
                    <div id="carImageCarousel" class="carousel slide" data-bs-ride="carousel">
                        <div class="carousel-inner">
                            <?php $__currentLoopData = $car->images; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $image): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <div class="carousel-item <?php echo e($key == 0 ? 'active' : ''); ?>">
                                    <img src="<?php echo e(asset($image->image_path)); ?>" class="d-block mx-auto" alt="Car Image">
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
                            <?php $__currentLoopData = $car->images; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $image): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <button type="button" data-bs-target="#carImageCarousel" data-bs-slide-to="<?php echo e($key); ?>"
                                    class="<?php echo e($key == 0 ? 'active' : ''); ?>" aria-current="<?php echo e($key == 0 ? 'true' : 'false'); ?>"
                                    aria-label="Slide <?php echo e($key + 1); ?>"></button>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </div>
                    </div>
                </div>
            <?php elseif($car->car_image): ?>
                <div class="mb-4 text-center">
                    <img src="<?php echo e(asset($car->car_image)); ?>" alt="Car Image" style="max-width: 100%; max-height: 300px;" class="img-fluid rounded">
                </div>
            <?php else: ?>
                <div class="alert alert-info mb-4">No image available for this car</div>
            <?php endif; ?>

            <!-- Car Information -->
            <div class="car-details-card mb-4">
                <div class="car-info-row">
                    <div><strong>Brand:</strong> <?php echo e($car->maker); ?></div>
                    <div><strong>Body Type:</strong> <?php echo e($car->vehicle_type); ?></div>
                    <div><strong>Condition:</strong> <?php echo e($car->car_condition); ?></div>
                </div>
                <div class="car-info-row">
                    <div><strong>Registration:</strong> <?php echo e($car->registration_no); ?></div>
                    <div><strong>Mileage:</strong> <?php echo e(number_format($car->mileage)); ?> km</div>
                    <div><strong>Price:</strong> Nu <?php echo e(number_format($car->price)); ?>/day</div>
                </div>
                <div class="mt-3">
                    <div class="car-spec"><i class="spec-icon">🚗</i><span><?php echo e($car->number_of_doors); ?> Doors</span></div>
                    <div class="car-spec"><i class="spec-icon">👥</i><span><?php echo e($car->number_of_seats); ?> Seats</span></div>
                    <div class="car-spec"><i class="spec-icon">⚙️</i><span><?php echo e(ucfirst($car->transmission_type)); ?></span></div>
                    <div class="car-spec"><i class="spec-icon">🧳</i><span><?php echo e($car->large_bags_capacity); ?> Large Bags</span></div>
                    <div class="car-spec"><i class="spec-icon">🎒</i><span><?php echo e($car->small_bags_capacity); ?> Small Bags</span></div>
                    <div class="car-spec"><i class="spec-icon">⛽</i><span><?php echo e($car->fuel_type); ?></span></div>
                    <div class="car-spec"><i class="spec-icon">❄️</i><span><?php echo e($car->air_conditioning ? 'Air Conditioning' : 'No AC'); ?></span></div>
                    <div class="car-spec"><i class="spec-icon">🎥</i><span><?php echo e($car->backup_camera ? 'Backup Camera' : 'No Backup Camera'); ?></span></div>
                    <div class="car-spec"><i class="spec-icon">🔊</i><span><?php echo e($car->bluetooth ? 'Bluetooth Enabled' : 'No Bluetooth'); ?></span></div>
                </div>
                <?php if($car->description): ?>
                    <div class="mt-3"><p><strong>Description:</strong> <?php echo e($car->description); ?></p></div>
                <?php endif; ?>
            </div>

            <!-- Booking Form -->
            <div class="booking-section mb-4">
                <h4>Book this Car</h4>

                <?php if(Auth::guard('customer')->check()): ?>
                    <form action="<?php echo e(route('car.booking.submit', $car->id)); ?>" method="POST">
                        <?php echo csrf_field(); ?>
                        <div class="booking-inputs">
                            <div class="row mb-3">
                                <div class="col-md-6">
                                    <label for="pickup_date" class="form-label">Pickup Date:</label>
                                    <input type="date" class="form-control" name="pickup_date" required>
                                </div>
                                <div class="col-md-6">
                                    <label for="return_date" class="form-label">Return Date:</label>
                                    <input type="date" class="form-control" name="return_date" required>
                                </div>
                            </div>
                            <div class="row mb-3">
                                <div class="col-md-6">
                                    <label for="pickup_location" class="form-label">Pickup Location:</label>
                                    <input type="text" class="form-control" name="pickup_location" required>
                                </div>
                                <div class="col-md-6">
                                    <label for="drop_location" class="form-label">Drop Location:</label>
                                    <input type="text" class="form-control" name="drop_location" required>
                                </div>
                            </div>
                            <div class="booking-timeline mb-3">
                                <div class="timeline-car">🚗</div>
                                <div class="timeline-line"></div>
                            </div>
                            <div class="text-muted small mb-3">Note: Time will be rounded off to the hour</div>
                            <div class="d-flex gap-2">
                                <button type="submit" class="btn btn-primary">Book</button>
                                <a href="<?php echo e(route('home')); ?>" class="btn btn-secondary">Cancel</a>
                            </div>                        
                        </div>
                    </form>
                <?php else: ?>
                    <div class="alert alert-warning">You must be logged in to book a car.</div>
                    <a href="<?php echo e(route('customer.login', ['redirectTo' => url()->full()])); ?>" class="btn btn-primary">Login to Book</a>
                    <a href="<?php echo e(route('home')); ?>" class="btn btn-secondary">Cancel</a>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('scripts'); ?>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        var carCarousel = new bootstrap.Carousel(document.getElementById('carImageCarousel'), {
            interval: 3000,
            ride: 'carousel'
        });
    });
</script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\Sangay Ngedup\Documents\GitHub\FinalProject\resources\views/cars/book.blade.php ENDPATH**/ ?>