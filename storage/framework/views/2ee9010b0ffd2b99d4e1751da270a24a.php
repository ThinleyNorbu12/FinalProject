

<?php $__env->startSection('content'); ?>
<link rel="stylesheet" href="<?php echo e(asset('assets/css/admin/inspection-approval.css')); ?>">

<div class="container">
    <h2 class="mb-4 text-center">Approve or Reject Inspected Cars</h2>

    <?php if(session('status')): ?>
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <?php echo e(session('status')); ?>

            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    <?php endif; ?>

    <?php if($inspectionRequests->count() > 0): ?>
        <div class="table-responsive">
            <table class="table table-bordered table-hover align-middle text-center">
                <thead class="table-dark">
                    <tr>
                        <th>Sl. No</th>
                        <th>Car</th>
                        <th>Reg. No.</th>
                        <th>Owner Email</th>
                        <th>Inspection Date</th>
                        <th>Time</th>
                        <th>Location</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php $__currentLoopData = $inspectionRequests; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $request): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <tr>
                            <td><?php echo e($loop->iteration); ?></td>
                            <td><?php echo e($request->car->maker ?? 'N/A'); ?> <?php echo e($request->car->model ?? ''); ?></td>
                            <td><?php echo e($request->car->registration_no ?? 'N/A'); ?></td>
                            <td><?php echo e($request->car->owner->email ?? 'N/A'); ?></td>
                            <td><?php echo e(\Carbon\Carbon::parse($request->inspection_date)->format('d M Y')); ?></td>
                            <?php
                                $timeRange = $request->inspection_time;
                                $formattedTime = $timeRange;

                                if (strpos($timeRange, ' - ') !== false) {
                                    [$startTime, $endTime] = explode(' - ', $timeRange);
                                    try {
                                        $formattedStart = \Carbon\Carbon::parse($startTime)->format('h:i A');
                                        $formattedEnd = \Carbon\Carbon::parse($endTime)->format('h:i A');
                                        $formattedTime = $formattedStart . ' - ' . $formattedEnd;
                                    } catch (Exception $e) {
                                        $formattedTime = $timeRange;
                                    }
                                }
                            ?>
                            <td><?php echo e($formattedTime); ?></td>
                            <td><?php echo e($request->location ?? 'N/A'); ?></td>
                            <td>
                                <form action="<?php echo e(route('car-admin.inspection-approval')); ?>" method="POST" class="d-flex justify-content-center gap-2">
                                    <?php echo csrf_field(); ?>
                                    <input type="hidden" name="car_id" value="<?php echo e($request->car->id); ?>">
                                    
                                    <button type="submit" name="decision" value="approved" class="btn btn-success btn-sm" data-bs-toggle="tooltip" title="Approve this car">
                                        <i class="bi bi-check-circle"></i>
                                    </button>

                                    <button type="submit" name="decision" value="rejected" class="btn btn-danger btn-sm" data-bs-toggle="tooltip" title="Reject this car">
                                        <i class="bi bi-x-circle"></i>
                                    </button>
                                </form>
                            </td>
                        </tr>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </tbody>
            </table>
        </div>
    <?php else: ?>
        <div class="alert alert-info text-center">No confirmed inspection requests pending approval.</div>
    <?php endif; ?>
</div>


<link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">


<script>
    document.addEventListener('DOMContentLoaded', function () {
        const tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'))
        tooltipTriggerList.map(function (tooltipTriggerEl) {
            return new bootstrap.Tooltip(tooltipTriggerEl)
        })
    });
</script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\Thinley Norbu\Documents\GitHub\FinalProject\resources\views/admin/inspection-approval.blade.php ENDPATH**/ ?>