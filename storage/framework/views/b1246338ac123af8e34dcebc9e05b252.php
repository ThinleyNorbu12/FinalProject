

<?php $__env->startSection('content'); ?>
<link rel="stylesheet" href="<?php echo e(asset('assets/css/admin/menage-inspection-requests.css')); ?>">
<div class="container">
    <h2 class="mb-4">Inspection Requests of TIME and DATE from Car Owners</h2>

    <?php if(session('success')): ?>
        <div class="alert alert-success"><?php echo e(session('success')); ?></div>
    <?php endif; ?>

    <?php if($inspectionRequests->count() > 0): ?>
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>Car</th>
                    <th>Reg. No.</th>
                    <th>Owner Email</th>
                    <th>Date</th>
                    <th>Time</th>
                    <th>Location</th>
                    <th>Status</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php $__currentLoopData = $inspectionRequests; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $request): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <tr>
                        <td><?php echo e($request->car->maker ?? 'N/A'); ?> <?php echo e($request->car->model ?? ''); ?></td>
                        <td><?php echo e($request->car->registration_no ?? 'N/A'); ?></td>
                        <td><?php echo e($request->car->owner->email ?? 'N/A'); ?></td>
                        <td><?php echo e($request->inspection_date); ?></td>
                        <td><?php echo e($request->inspection_time); ?></td>
                        <td><?php echo e($request->location); ?></td>
                        <td><?php echo e(ucfirst($request->status)); ?></td>
                        <td>
                            <?php if($request->status !== 'canceled'): ?>
                                <?php if(!$request->new_date_requested): ?>
                                    <!-- Ok Button (for confirming date and time) -->
                                    <!-- Confirm Inspection -->
                                    <form action="<?php echo e(route('car-admin.inspection.confirm', $request->id)); ?>" method="POST" style="display: inline;">
                                        <?php echo csrf_field(); ?>
                                        <button type="submit" class="btn btn-success btn-sm">Ok</button>
                                    </form>

                                    <!-- Send Mail -->
                                    

                                <?php endif; ?>
                            <?php endif; ?>
                        </td>             
                    </tr>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </tbody>
        </table>
    <?php else: ?>
        <div class="alert alert-info">No inspection requests found.</div>
    <?php endif; ?>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\Thinley Norbu\Documents\GitHub\FinalProject\resources\views/admin/menage-inspection-requests.blade.php ENDPATH**/ ?>