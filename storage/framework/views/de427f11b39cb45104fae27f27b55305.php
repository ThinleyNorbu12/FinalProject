

<?php $__env->startSection('content'); ?>
<div class="container">
    <h2>My Rented Cars</h2>

    <?php if(isset($message)): ?>
        <p><?php echo e($message); ?></p>
    <?php elseif($rentedCars->isEmpty()): ?>
        <p>You have not rented any cars yet.</p>
    <?php else: ?>
        <div class="table-responsive">
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Car Name</th>
                        <th>Model</th>
                        <th>Rental Date</th>
                        <th>Status</th>
                    </tr>
                </thead>
                <tbody>
                    <?php $__currentLoopData = $rentedCars; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $index => $car): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <tr>
                            <td><?php echo e($index + 1); ?></td>
                            <td><?php echo e($car->name); ?></td>
                            <td><?php echo e($car->model); ?></td>
                            <td><?php echo e($car->rental_date); ?></td>
                            <td>
                                <?php if($car->status == 'pending'): ?>
                                    <span class="badge badge-warning">Pending Approval</span>
                                <?php else: ?>
                                    <span class="badge badge-success">Rented</span>
                                <?php endif; ?>
                            </td>
                        </tr>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </tbody>
            </table>
        </div>
    <?php endif; ?>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\Thinley Norbu\Documents\GitHub\FinalProject\resources\views/CarOwner/view-rented-car.blade.php ENDPATH**/ ?>