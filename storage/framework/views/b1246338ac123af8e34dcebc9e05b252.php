






<?php $__env->startSection('content'); ?>
<link rel="stylesheet" href="<?php echo e(asset('assets/css/admin/menage-inspection-requests.css')); ?>">

<div class="container">
    <h2 class="mb-4 text-center">Rescheduled Inspection Requests</h2>

    <?php if(session('success')): ?>
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <?php echo e(session('success')); ?>

            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    <?php endif; ?>

    <?php if($inspectionRequests->count() > 0): ?>
        <div class="table-responsive">
            <table class="table table-bordered align-middle text-center">
                <thead class="table-dark">
                    <tr>
                        <th>Sl. No</th>
                        <th>Car</th>
                        <th>Reg. No.</th>
                        <th>Owner Email</th>
                        <th>Date</th>
                        <th>Time</th>
                        <th>Location</th>
                        <th>Response</th>
                        <th>Status</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php $__currentLoopData = $inspectionRequests; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $request): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <tr>
                            <td><?php echo e($loop->iteration); ?></td>
                            <td><?php echo e($request->car->maker ?? 'N/A'); ?> <?php echo e($request->car->model ?? ''); ?></td>
                            <td><?php echo e($request->car->registration_no ?? 'N/A'); ?></td>
                            <td><?php echo e($request->car->owner->email ?? 'N/A'); ?></td>
                            <td><?php echo e($request->inspection_date); ?></td>
                            <td><?php echo e($request->inspection_time); ?></td>
                            <td><?php echo e($request->location); ?></td>
                            <td>
                                <?php if($request->request_accepted): ?>
                                    <span class="badge bg-success">Accepted</span>
                                <?php elseif($request->status === 'canceled'): ?>
                                    <span class="badge bg-danger">Cancelled</span>
                                <?php elseif($request->request_new_date_sent): ?>
                                    <span class="badge bg-warning text-dark">Requested New Date</span>
                                <?php else: ?>
                                    <span class="badge bg-secondary">Pending</span>
                                <?php endif; ?>
                            </td>                           
                            <td>
                                <span class="badge bg-<?php echo e($request->status === 'canceled' ? 'danger' : 'primary'); ?>">
                                    <?php echo e(ucfirst($request->status)); ?>

                                </span>
                            </td>
                            <td>
                                <?php if($request->status !== 'canceled'): ?>
                                    <?php if(!$request->is_confirmed_by_admin): ?>
                                        <form action="<?php echo e(route('car-admin.inspection.confirm', $request->id)); ?>" method="POST" class="d-inline" onsubmit="return disableButton(this)">
                                            <?php echo csrf_field(); ?>
                                            <button type="submit" class="btn btn-success btn-sm" id="btn-<?php echo e($request->id); ?>">
                                                <i class="bi bi-check-circle"></i> Confirm
                                            </button>
                                        </form>
                                    <?php else: ?>
                                        <button class="btn btn-secondary btn-sm" disabled>
                                            <i class="bi bi-check2-circle"></i> Done
                                        </button>
                                    <?php endif; ?>
                                <?php endif; ?>
                            </td>
                        </tr>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </tbody>
            </table>
        </div>
    <?php else: ?>
        <div class="alert alert-info text-center">No inspection responses found from car owners.</div>
    <?php endif; ?>
</div>


<link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">

<script>
    function disableButton(form) {
        const btn = form.querySelector('button');
        btn.disabled = true;
        const originalText = btn.innerHTML;
        btn.innerHTML = '<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span> Sending...';

        setTimeout(() => {
            btn.innerHTML = '<i class="bi bi-check2-circle"></i> Done';
            btn.classList.remove('btn-success');
            btn.classList.add('btn-secondary');
        }, 1000);
        return true;
    }
</script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\Thinley Norbu\Documents\GitHub\FinalProject\resources\views/admin/menage-inspection-requests.blade.php ENDPATH**/ ?>