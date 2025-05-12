

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
                        
                        <?php if($request->status !== 'canceled' && !$request->request_accepted && !$request->date_time_updated): ?>
                            <form action="<?php echo e(route('inspection.cancel', $request->id)); ?>" method="POST" class="d-inline cancel-form">
                                <?php echo csrf_field(); ?>
                                <button type="button" class="btn btn-danger btn-sm show-confirm-modal" 
                                    data-message="Are you sure you want to cancel this request?" 
                                    data-form-id="<?php echo e($request->id); ?>">
                                    Cancel for Inspection Request
                                </button>
                            </form>
                        <?php else: ?>
                            <button class="btn btn-secondary btn-sm" disabled>Request Canceled / Accepted / Edited</button>
                        <?php endif; ?>
                    
                        
                        <?php if($request->status !== 'canceled' && !$request->request_accepted && !$request->date_time_updated): ?>
                            <?php if($request->request_new_date_sent): ?>
                                <button class="btn btn-secondary btn-sm" disabled>New Date Already Requested</button>
                            <?php else: ?>
                                <form action="<?php echo e(route('inspection.editdatetime', $request->id)); ?>" method="GET" class="d-inline edit-form">
                                    <?php echo csrf_field(); ?>
                                    <button type="button" class="btn btn-warning btn-sm show-confirm-modal" 
                                        data-message="Are you sure you want to edit this request?" 
                                        data-form-id="<?php echo e($request->id); ?>">
                                        Request for New Date
                                    </button>
                                </form>
                            <?php endif; ?>
                        <?php else: ?>
                            <button class="btn btn-secondary btn-sm" disabled>Request Canceled / Accepted / Edited</button>
                        <?php endif; ?>
                    
                        
                        <?php if($request->status !== 'canceled' && !$request->request_accepted && !$request->date_time_updated): ?>
                            <form action="<?php echo e(route('inspection.accept', $request->id)); ?>" method="POST" class="d-inline accept-form">
                                <?php echo csrf_field(); ?>
                                <button type="button" class="btn btn-success btn-sm show-confirm-modal" 
                                    data-message="Do you accept the scheduled date and time?" 
                                    data-form-id="<?php echo e($request->id); ?>">
                                    OK with Inspection Date/Time
                                </button>
                            </form>
                        <?php elseif($request->request_accepted): ?>
                            <button class="btn btn-success btn-sm" disabled>Accepted by You</button>
                        <?php else: ?>
                            <button class="btn btn-secondary btn-sm" disabled>Request Canceled / Accepted / Edited</button>
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

<!-- Confirmation Modal -->
<div class="modal fade" id="confirmModal" tabindex="-1" aria-labelledby="confirmModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header bg-warning text-dark">
        <h5 class="modal-title" id="confirmModalLabel">Please Confirm</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body" id="confirmMessage">
        Are you sure?
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
        <button type="button" class="btn btn-primary" id="confirmBtn">OK</button>
      </div>
    </div>
  </div>
</div>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('scripts'); ?>
<script>
    let selectedForm = null;

    document.querySelectorAll('.show-confirm-modal').forEach(button => {
        button.addEventListener('click', function () {
            const message = this.getAttribute('data-message');
            selectedForm = this.closest('form');
            document.getElementById('confirmMessage').textContent = message;
            const modal = new bootstrap.Modal(document.getElementById('confirmModal'));
            modal.show();
        });
    });

    document.getElementById('confirmBtn').addEventListener('click', function () {
        if (selectedForm) {
            selectedForm.submit();
        }
    });
</script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\Thinley Norbu\Documents\GitHub\FinalProject\resources\views/CarOwner/inspection-messages.blade.php ENDPATH**/ ?>