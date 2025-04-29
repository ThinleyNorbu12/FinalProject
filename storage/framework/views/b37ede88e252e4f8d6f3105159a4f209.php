

<?php $__env->startSection('content'); ?>
    <div class="container py-4">
        <div class="row">
            <div class="col-lg-10 col-md-12 mx-auto">
                <!-- Car Image Carousel -->
                <h3 class="text-center mb-3"><?php echo e($car->maker); ?> <?php echo e($car->model); ?></h3>
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
        <?php else: ?>
            <div class="alert alert-info mb-4">No images available for this car</div>
        <?php endif; ?>
            </div>
        </div>

        <!-- Car Information -->
        <div class="car-details-card mb-4">
            <h4><?php echo e($car->maker); ?> <?php echo e($car->model); ?></h4>
            
            <div class="car-info-row">
                <div>
                    <strong>Brand:</strong> <?php echo e($car->maker); ?>

                </div>
                <div>
                    <strong>Body Type:</strong> <?php echo e($car->vehicle_type); ?>

                </div>
                <div>
                    <strong>Condition:</strong> <?php echo e($car->car_condition); ?>

                </div>
            </div>
            
            <div class="car-info-row">
                <div>
                    <strong>Registration:</strong> <?php echo e($car->registration_no); ?>

                </div>
                <div>
                    <strong>Mileage:</strong> <?php echo e($car->mileage); ?> km
                </div>
                <div>
                    <strong>Price:</strong> $<?php echo e($car->price); ?>/day
                </div>
            </div>
            
            <div class="mt-3">
                <div class="car-spec">
                    <i class="spec-icon">🚗</i>
                    <span id="doors">4 Doors</span>
                </div>
                <div class="car-spec">
                    <i class="spec-icon">👥</i>
                    <span id="seats">5 Seats</span>
                </div>
                <div class="car-spec">
                    <i class="spec-icon">⚙️</i>
                    <span id="transmission">Automatic</span>
                </div>
            </div>
            
            <?php if($car->description): ?>
                <div class="mt-3">
                    <p><strong>Description:</strong> <?php echo e($car->description); ?></p>
                </div>
            <?php endif; ?>
        </div>

        <!-- Booking Time Form -->
        <div class="booking-section mb-4">
            <h4>Book this Car</h4>
            <form action="<?php echo e(route('car.booking.submit', $car->id)); ?>" method="POST">
                <?php echo csrf_field(); ?>
                <div class="booking-inputs">
                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label for="name" class="form-label">Full Name:</label>
                            <input type="text" class="form-control" name="name" required>
                        </div>
                        <div class="col-md-6">
                            <label for="email" class="form-label">Email Address:</label>
                            <input type="email" class="form-control" name="email" required>
                        </div>
                    </div>

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
                    
                    <div class="booking-timeline mb-3">
                        <div class="timeline-car">🚗</div>
                        <div class="timeline-line"></div>
                    </div>
                    
                    <div class="text-muted small mb-3">Note: Time will be rounded off to the hour</div>

                    <button type="submit" class="btn btn-primary">Confirm Booking</button>
                </div>
            </form>
        </div>
    </div>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('styles'); ?>
<style>
    body {
        background-color: #f7f9fc;
    }
    .carousel-container {
        background-color: white;
        padding: 15px;
        border-radius: 5px;
        box-shadow: 0 1px 3px rgba(0,0,0,0.1);
        max-width: 600px;
        margin: 0 auto;
    }
    
    .carousel-inner img {
        max-height: 280px;
        object-fit: contain;
        margin: 0 auto;
        width: auto;
        max-width: 100%;
        border-radius: 5px;
    }
    
    .carousel-control-prev, .carousel-control-next {
        width: 40px;
        height: 40px;
        background-color: rgba(0,0,0,0.5);
        border-radius: 50%;
        top: 50%;
        transform: translateY(-50%);
        opacity: 0.7;
    }
    
    .carousel-control-prev:hover, .carousel-control-next:hover {
        background-color: rgba(0,0,0,0.8);
        opacity: 0.9;
    }
    
    .carousel-indicators {
        bottom: -10px;
    }
    
    .carousel-indicators button {
        width: 10px;
        height: 10px;
        border-radius: 50%;
        margin: 0 5px;
        background-color: #ccc;
    }
    
    .carousel-indicators button.active {
        background-color: #f00;
    }
    
    .car-details-card {
        background-color: white;
        padding: 20px;
        border-radius: 5px;
        box-shadow: 0 1px 3px rgba(0,0,0,0.1);
    }
    
    .car-info-row {
        display: flex;
        justify-content: space-between;
        border-bottom: 1px solid #eee;
        padding: 10px 0;
    }
    
    .car-spec {
        display: inline-flex;
        align-items: center;
        margin-right: 20px;
        margin-bottom: 10px;
        color: #666;
    }
    
    .spec-icon {
        margin-right: 5px;
        font-style: normal;
    }
    
    .booking-section {
        background-color: white;
        padding: 20px;
        border-radius: 5px;
        box-shadow: 0 1px 3px rgba(0,0,0,0.1);
    }
    
    .booking-timeline {
        position: relative;
        padding: 15px 0;
        margin: 25px 0;
    }
    
    .timeline-car {
        color: red;
        position: absolute;
        top: -10px;
        left: 20%;
        font-size: 24px;
    }
    
    .timeline-line {
        border-top: 2px dashed #ccc;
        width: 100%;
    }
</style>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('scripts'); ?>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Initialize the carousel with auto-play
        var carCarousel = new bootstrap.Carousel(document.getElementById('carImageCarousel'), {
            interval: 3000, // Change slides every 3 seconds
            ride: 'carousel'
        });
    });
</script>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\Sangay Ngedup\Documents\GitHub\FinalProject\resources\views/cars/book.blade.php ENDPATH**/ ?>