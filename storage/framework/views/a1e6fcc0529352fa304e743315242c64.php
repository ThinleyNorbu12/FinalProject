

<?php $__env->startSection('content'); ?>
<div class="container">
    <h2>Inspection Requests from Admin</h2>
    <?php if(session('success')): ?>
        <div class="alert alert-success">
            <?php echo e(session('success')); ?>

        </div>
    <?php endif; ?>
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
                        <?php if($request->status !== 'canceled'): ?>
                            <form action="<?php echo e(route('inspection.cancel', $request->id)); ?>" method="POST" onsubmit="return confirm('Are you sure you want to cancel this request?');">
                                <?php echo csrf_field(); ?>
                                <button class="btn btn-danger btn-sm" type="submit">Cancel for Inspection Request</button>
                            </form>
                        <?php else: ?>
                            <!-- Disabled button if already canceled -->
                            <button class="btn btn-secondary btn-sm" disabled>Request Canceled</button>
                        <?php endif; ?>
                    
                        <?php if($request->status !== 'canceled'): ?>
                            <form action="<?php echo e(route('inspection.editdatetime', $request->id)); ?>" method="GET" onsubmit="return confirm('Are you sure you want to edit this request?');">
                                <?php echo csrf_field(); ?>
                                <button class="btn btn-warning btn-sm" type="submit">Request for New Date</button>
                            </form>
                        <?php else: ?>
                            <!-- Disabled button if already canceled -->
                            <button class="btn btn-secondary btn-sm" disabled>New Date Requested</button>
                        <?php endif; ?>
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