

<!-- Link to the external CSS file -->
<link rel="stylesheet" href="<?php echo e(asset('assets/css/carowner/dashboard.css')); ?>">

<?php $__env->startSection('content'); ?>
    <div class="container">
        <div class="row">
            <!-- First Container: Profile Section -->
            <div class="col-md-4">
                <div class="profile-section">
                    <h2>Welcome to the Car Owner Dashboard</h2>

                    <?php if(Auth::guard('carowner')->check()): ?>
                        <p>Hello, <?php echo e(Auth::guard('carowner')->user()->name); ?>!</p>
                        <form method="POST" action="<?php echo e(route('carowner.logout')); ?>">
                            <?php echo csrf_field(); ?>
                            <button type="submit" class="btn btn-danger">Logout</button>
                        </form>
                    <?php else: ?>
                        <p>Hello, Guest!</p>
                    <?php endif; ?>
                </div>
            </div>

            <!-- Second Container: Dashboard Links -->
            <div class="col-md-8">
                <div class="dashboard-links">
                    <p>This is where car owners can manage their cars.</p>

                    <!-- Wrap the links in a div container for styling -->
                    <div class="links-container">
                        <a href="<?php echo e(url('CarOwner/rent-car')); ?>" class="btn btn-primary">1. RENT A CAR</a>
                        <a href="<?php echo e(url('carowner/view-rented-car')); ?>" class="btn btn-primary">2. VIEW CAR REGISTRARION REQUEST</a>  <!--VIEW RENTED CAR change to VIEW REGISTRARION REQUEST -->
                        <a href="<?php echo e(url('carowner/car-inspection')); ?>" class="btn btn-primary">
                            3. CAR INSPECTION REQUIRED
                            <?php if(isset($car) && $car->inspection_requested): ?> 
                                <span class="badge badge-warning">Inspection Requested</span>
                            <?php endif; ?>
                        </a>
                        <a href="<?php echo e(url('carowner/car-approval-denied')); ?>" class="btn btn-primary">4. CAR APPROVAL DENIED</a>
                        <a href="<?php echo e(url('carowner/approved-car')); ?>" class="btn btn-primary">5. APPROVED CAR</a>
                        <a href="<?php echo e(url('carowner/payment-summary')); ?>" class="btn btn-primary">6. PAYMENT SUMMARY</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\Thinley Norbu\Documents\GitHub\FinalProject\resources\views/CarOwner/dashboard.blade.php ENDPATH**/ ?>