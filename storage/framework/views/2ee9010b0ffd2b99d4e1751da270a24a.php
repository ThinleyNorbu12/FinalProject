

<?php $__env->startSection('title', 'Approve Inspected Cars'); ?>

<?php $__env->startSection('breadcrumbs'); ?>
    <li class="breadcrumb-item active"> Inspections Approval</li>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('page-header'); ?>
    <div class="d-flex justify-content-between align-items-center">
        <div>
            <h1 class="page-title">Approve Inspected Cars</h1>
            <p class="page-subtitle">Review and approve or reject completed car inspections</p>
        </div>
        <div class="page-actions">
            <button class="btn btn-info" data-bs-toggle="modal" data-bs-target="#inspectionGuidelinesModal">
                <i class="fas fa-info-circle me-2"></i>Guidelines
            </button>
        </div>
    </div>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>
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
                            <td>
                                <?php
                                    $timeRange = $request->inspection_time;
                                    if (strpos($timeRange, ' - ') !== false) {
                                        [$start, $end] = explode(' - ', $timeRange);
                                        try {
                                            $startFormatted = \Carbon\Carbon::parse($start)->format('h:i A');
                                            $endFormatted = \Carbon\Carbon::parse($end)->format('h:i A');
                                            $formattedTime = "$startFormatted - $endFormatted";
                                        } catch (\Exception $e) {
                                            $formattedTime = $timeRange;
                                        }
                                    } else {
                                        $formattedTime = $timeRange;
                                    }
                                ?>
                                <?php echo e($formattedTime); ?>

                            </td>
                            <td><?php echo e($request->location ?? 'N/A'); ?></td>
                            <td>
                                <form id="inspection-form-<?php echo e($request->car->id); ?>" action="<?php echo e(route('car-admin.inspection-approval')); ?>" method="POST" class="d-flex justify-content-center gap-2">
                                    <?php echo csrf_field(); ?>
                                    <input type="hidden" name="car_id" value="<?php echo e($request->car->id); ?>">
                                    <input type="hidden" name="rejection_reason" id="rejection-reason-<?php echo e($request->car->id); ?>">
                                    
                                    <button type="button" 
                                            onclick="confirmApproval(<?php echo e($request->car->id); ?>, '<?php echo e($request->car->maker ?? 'N/A'); ?> <?php echo e($request->car->model ?? ''); ?>', '<?php echo e($request->car->registration_no ?? 'N/A'); ?>')" 
                                            class="btn btn-success btn-sm" 
                                            data-bs-toggle="tooltip" 
                                            title="Approve this car">
                                        <i class="bi bi-check-circle"></i>
                                    </button>
                                    
                                    <button type="button" 
                                            onclick="confirmRejection(<?php echo e($request->car->id); ?>, '<?php echo e($request->car->maker ?? 'N/A'); ?> <?php echo e($request->car->model ?? ''); ?>', '<?php echo e($request->car->registration_no ?? 'N/A'); ?>')" 
                                            class="btn btn-danger btn-sm" 
                                            data-bs-toggle="tooltip" 
                                            title="Reject this car">
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
<?php $__env->stopSection(); ?>
<!-- Guidelines Modal -->
<div class="modal fade" id="inspectionGuidelinesModal" tabindex="-1" aria-labelledby="inspectionGuidelinesModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="inspectionGuidelinesModalLabel">
                    <i class="fas fa-info-circle me-2"></i>Inspection Approval Guidelines
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-6">
                        <h6 class="text-success"><i class="fas fa-check-circle me-2"></i>Approve If:</h6>
                        <ul class="list-unstyled">
                            <li><i class="fas fa-check text-success me-2"></i>Vehicle meets safety standards</li>
                            <li><i class="fas fa-check text-success me-2"></i>All required documents are valid</li>
                            <li><i class="fas fa-check text-success me-2"></i>Vehicle condition matches description</li>
                            <li><i class="fas fa-check text-success me-2"></i>No major mechanical issues</li>
                        </ul>
                    </div>
                    <div class="col-md-6">
                        <h6 class="text-danger"><i class="fas fa-times-circle me-2"></i>Reject If:</h6>
                        <ul class="list-unstyled">
                            <li><i class="fas fa-times text-danger me-2"></i>Safety concerns identified</li>
                            <li><i class="fas fa-times text-danger me-2"></i>Documentation incomplete</li>
                            <li><i class="fas fa-times text-danger me-2"></i>Vehicle condition misrepresented</li>
                            <li><i class="fas fa-times text-danger me-2"></i>Major repairs needed</li>
                        </ul>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>

<!-- Rejection Reason Modal -->
<div class="modal fade" id="rejectionReasonModal" tabindex="-1" aria-labelledby="rejectionReasonModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="rejectionReasonModalLabel">
                    <i class="fas fa-times-circle me-2 text-danger"></i>Rejection Reason
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <p class="mb-3"><strong>Car:</strong> <span id="rejectionCarDetails"></span></p>
                <div class="mb-3">
                    <label for="rejectionReasonSelect" class="form-label">Select Reason for Rejection:</label>
                    <select class="form-select" id="rejectionReasonSelect">
                        <option value="">Choose a reason...</option>
                        <option value="Safety concerns identified">Safety concerns identified</option>
                        <option value="Documentation incomplete or invalid">Documentation incomplete or invalid</option>
                        <option value="Vehicle condition misrepresented">Vehicle condition misrepresented</option>
                        <option value="Major repairs needed">Major repairs needed</option>
                        <option value="Failed emission standards">Failed emission standards</option>
                        <option value="Structural damage found">Structural damage found</option>
                        <option value="Other">Other (specify below)</option>
                    </select>
                </div>
                <div class="mb-3">
                    <label for="rejectionReasonText" class="form-label">Additional Comments:</label>
                    <textarea class="form-control" id="rejectionReasonText" rows="3" placeholder="Provide additional details about the rejection..."></textarea>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                <button type="button" class="btn btn-danger" onclick="proceedWithRejection()">
                    <i class="fas fa-times-circle me-2"></i>Confirm Rejection
                </button>
            </div>
        </div>
    </div>
</div>


<link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">


<script>
    document.addEventListener('DOMContentLoaded', function () {
        const tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
        tooltipTriggerList.map(function (tooltipTriggerEl) {
            return new bootstrap.Tooltip(tooltipTriggerEl);
        });
    });

    let currentCarId = null;

    function confirmApproval(carId, carMaker, regNo) {
        const carDetails = `${carMaker} (${regNo})`;
        
        if (confirm(`Are you sure you want to APPROVE this car?\n\nCar: ${carDetails}\n\nThis action cannot be undone.`)) {
            const form = document.getElementById(`inspection-form-${carId}`);
            const decisionInput = document.createElement('input');
            decisionInput.type = 'hidden';
            decisionInput.name = 'decision';
            decisionInput.value = 'approved';
            form.appendChild(decisionInput);
            form.submit();
        }
    }

    function confirmRejection(carId, carMaker, regNo) {
        currentCarId = carId;
        const carDetails = `${carMaker} (${regNo})`;
        document.getElementById('rejectionCarDetails').textContent = carDetails;
        
        // Reset form
        document.getElementById('rejectionReasonSelect').value = '';
        document.getElementById('rejectionReasonText').value = '';
        
        // Show modal
        const modal = new bootstrap.Modal(document.getElementById('rejectionReasonModal'));
        modal.show();
    }

    function proceedWithRejection() {
        const reasonSelect = document.getElementById('rejectionReasonSelect').value;
        const reasonText = document.getElementById('rejectionReasonText').value;
        
        if (!reasonSelect) {
            alert('Please select a reason for rejection.');
            return;
        }
        
        let fullReason = reasonSelect;
        if (reasonText.trim()) {
            fullReason += ': ' + reasonText.trim();
        }
        
        // Set the rejection reason in the hidden input
        document.getElementById(`rejection-reason-${currentCarId}`).value = fullReason;
        
        // Add decision input and submit form
        const form = document.getElementById(`inspection-form-${currentCarId}`);
        const decisionInput = document.createElement('input');
        decisionInput.type = 'hidden';
        decisionInput.name = 'decision';
        decisionInput.value = 'rejected';
        form.appendChild(decisionInput);
        
        // Hide modal and submit form
        const modal = bootstrap.Modal.getInstance(document.getElementById('rejectionReasonModal'));
        modal.hide();
        
        form.submit();
    }
</script>

<?php echo $__env->make('layouts.admin', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\Thinley Norbu\Documents\GitHub\FinalProject\resources\views/admin/inspection-approval.blade.php ENDPATH**/ ?>