

<?php $__env->startSection('content'); ?>
<div class="container">
    <h2>Inspection Requests from Admin</h2>

    <?php if($inspectionRequests->count() > 0): ?>
        <ul class="list-group mt-4">
            <?php $__currentLoopData = $inspectionRequests; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $request): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <li class="list-group-item">
                    <strong>Car Name:</strong> <?php echo e($request->car->maker ?? 'N/A'); ?> <?php echo e($request->car->model ?? ''); ?><br>
                    <strong>Registration No:</strong> <?php echo e($request->car->registration_no ?? 'N/A'); ?><br>
                    <strong>Inspection Date:</strong> <?php echo e($request->inspection_date); ?><br>
                    <strong>Inspection Time:</strong> <?php echo e($request->inspection_time); ?><br>
                    <strong>Location:</strong> <?php echo e($request->location); ?><br>
                    <strong>Details:</strong> <?php echo e($request->details); ?><br>
                    <strong>Status:</strong> <?php echo e(ucfirst($request->status)); ?><br>
                    <small class="text-muted">
                        Sent on <?php echo e($request->created_at->timezone('Asia/Thimphu')->format('d M Y, h:i A')); ?>

                    </small>                    
                
                    <div class="mt-3 d-flex gap-2">
                        <button class="btn btn-danger btn-sm" disabled>Cancel</button>
                        <button class="btn btn-warning btn-sm" disabled>Request Edit</button>
                    </div>
                </li>  
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </ul>
    <?php else: ?>
        <div class="alert alert-info mt-4">
            No inspection requests found.
        </div>
    <?php endif; ?>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\Thinley Norbu\Documents\GitHub\FinalProject\resources\views/CarOwner/inspection-messages.blade.php ENDPATH**/ ?>