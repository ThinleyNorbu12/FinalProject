  -->

<!-- 


<?php $__env->startSection('content'); ?>
<div class="container mt-4">
    <div class="row justify-content-center">
        <div class="col-md-10">
            <div class="card shadow">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <span><?php echo e(__('Car Owner Dashboard')); ?></span>

                    <form action="<?php echo e(route('carowner.logout')); ?>" method="POST">
                        <?php echo csrf_field(); ?>
                        <button type="submit" class="btn btn-sm btn-danger">Logout</button>
                    </form>
                </div>

                <div class="card-body">
                    <?php if(session('success')): ?>
                        <div class="alert alert-success">
                            <?php echo e(session('success')); ?>

                        </div>
                    <?php endif; ?>

                    <h3>Hello, <?php echo e(Auth::user()->name ?? 'Car Owner'); ?>!</h3>
                    <p>Email: <?php echo e(Auth::user()->email); ?></p>
                    <p>Phone: <?php echo e(Auth::user()->phone ?? 'N/A'); ?></p>

                    <hr>

                    <h4 class="mt-4">Your Cars</h4>
                    <?php if(Auth::user()->cars && Auth::user()->cars->count() > 0): ?>
                        <table class="table table-striped">
                            <thead>
                                <tr>
                                    <th>Model</th>
                                    <th>Year</th>
                                    <th>License Plate</th>
                                    <th>Status</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php $__currentLoopData = Auth::user()->cars; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $car): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <tr>
                                    <td><?php echo e($car->model); ?></td>
                                    <td><?php echo e($car->year); ?></td>
                                    <td><?php echo e($car->license_plate); ?></td>
                                    <td><?php echo e(ucfirst($car->status)); ?></td>
                                    <td>
                                        <a href="#" class="btn btn-sm btn-info">View</a>
                                        <a href="#" class="btn btn-sm btn-warning">Edit</a>
                                    </td>
                                </tr>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </tbody>
                        </table>
                    <?php else: ?>
                        <div class="alert alert-info">
                            You haven’t listed any cars yet. <a href="#">Add your first car</a>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
</div>
<?php $__env->stopSection(); ?> -->

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\Sangay Ngedup\Documents\GitHub\FinalProject\resources\views/CarOwner/dashboard.blade.php ENDPATH**/ ?>