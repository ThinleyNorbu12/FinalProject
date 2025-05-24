

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

<?php $__env->startPush('styles'); ?>
<style>
    .approval-table {
        border-radius: 12px;
        box-shadow: 0 8px 25px rgba(0, 0, 0, 0.1);
        overflow: hidden;
        background: white;
    }
    
    .table {
        margin-bottom: 0;
    }
    
    .table thead th {
        border: none;
        font-weight: 600;
        text-transform: uppercase;
        font-size: 0.85rem;
        letter-spacing: 0.5px;
        background: linear-gradient(135deg, #343a40 0%, #495057 100%);
    }
    
    .table tbody tr {
        transition: all 0.3s ease;
        border: none;
    }
    
    .table tbody tr:hover {
        background: linear-gradient(135deg, rgba(0, 123, 255, 0.05) 0%, rgba(0, 123, 255, 0.02) 100%);
        transform: translateY(-2px);
        box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
    }
    
    .table tbody td {
        border-top: 1px solid #e9ecef;
        vertical-align: middle;
        padding: 1rem 0.75rem;
    }
    
    .car-info {
        display: flex;
        flex-direction: column;
        align-items: center;
    }
    
    .car-maker {
        font-weight: 600;
        color: #2c3e50;
        margin-bottom: 0.25rem;
    }
    
    .car-model {
        font-size: 0.85rem;
        color: #6c757d;
    }
    
    .reg-badge {
        background: linear-gradient(135deg, #e3f2fd 0%, #bbdefb 100%);
        color: #1976d2;
        padding: 0.5rem 1rem;
        border-radius: 20px;
        font-weight: 600;
        font-size: 0.85rem;
        border: 2px solid #2196f3;
    }
    
    .email-link {
        color: #495057;
        text-decoration: none;
        transition: color 0.3s ease;
    }
    
    .email-link:hover {
        color: #007bff;
        text-decoration: underline;
    }
    
    .date-display {
        display: flex;
        flex-direction: column;
        align-items: center;
    }
    
    .date-day {
        font-size: 1.2rem;
        font-weight: 700;
        color: #2c3e50;
    }
    
    .date-month {
        font-size: 0.85rem;
        color: #6c757d;
        text-transform: uppercase;
    }
    
    .time-display {
        background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%);
        padding: 0.75rem;
        border-radius: 8px;
        font-weight: 500;
        color: #495057;
        border: 1px solid #dee2e6;
    }
    
    .location-display {
        display: flex;
        align-items: center;
        justify-content: center;
        color: #495057;
    }
    
    .location-display i {
        color: #dc3545;
        margin-right: 0.5rem;
    }
    
    .action-buttons {
        display: flex;
        gap: 0.5rem;
        justify-content: center;
    }
    
    .btn-approve {
        background: linear-gradient(135deg, #28a745 0%, #20c997 100%);
        border: none;
        color: white;
        padding: 0.6rem 1rem;
        border-radius: 8px;
        transition: all 0.3s ease;
        font-weight: 500;
    }
    
    .btn-approve:hover {
        transform: translateY(-2px);
        box-shadow: 0 4px 15px rgba(40, 167, 69, 0.4);
        color: white;
    }
    
    .btn-reject {
        background: linear-gradient(135deg, #dc3545 0%, #c82333 100%);
        border: none;
        color: white;
        padding: 0.6rem 1rem;
        border-radius: 8px;
        transition: all 0.3s ease;
        font-weight: 500;
    }
    
    .btn-reject:hover {
        transform: translateY(-2px);
        box-shadow: 0 4px 15px rgba(220, 53, 69, 0.4);
        color: white;
    }
    
    .loading-btn {
        position: relative;
        overflow: hidden;
    }
    
    .loading-btn:disabled {
        opacity: 0.7;
        cursor: not-allowed;
    }
    
    .spinner-overlay {
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        background: rgba(255, 255, 255, 0.8);
        display: flex;
        align-items: center;
        justify-content: center;
        border-radius: 8px;
    }
    
    .empty-state {
        text-align: center;
        padding: 4rem 2rem;
        background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%);
        border-radius: 12px;
        border: 2px dashed #dee2e6;
    }
    
    .empty-state-icon {
        font-size: 4rem;
        color: #6c757d;
        margin-bottom: 1.5rem;
    }
    
    .empty-state h4 {
        color: #495057;
        margin-bottom: 1rem;
    }
    
    .empty-state p {
        color: #6c757d;
        margin-bottom: 2rem;
    }
    
    .stats-card {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        color: white;
        padding: 1.5rem;
        border-radius: 12px;
        margin-bottom: 2rem;
        text-align: center;
    }
    
    .stats-number {
        font-size: 2.5rem;
        font-weight: 700;
        margin-bottom: 0.5rem;
    }
    
    .stats-label {
        font-size: 1rem;
        opacity: 0.9;
    }
</style>
<?php $__env->stopPush(); ?>

<?php $__env->startSection('content'); ?>
<div class="container-fluid">
    <!-- Statistics Card -->
    <?php if($inspectionRequests->count() > 0): ?>
        <div class="row mb-4">
            <div class="col-12">
                <div class="stats-card">
                    <div class="stats-number"><?php echo e($inspectionRequests->count()); ?></div>
                    <div class="stats-label">
                        <i class="fas fa-clipboard-check me-2"></i>
                        Inspections Pending Approval
                    </div>
                </div>
            </div>
        </div>
    <?php endif; ?>

    <div class="row">
        <div class="col-12">
            <?php if($inspectionRequests->count() > 0): ?>
                <div class="approval-table table-responsive">
                    <table class="table align-middle text-center">
                        <thead class="table-dark">
                            <tr>
                                <th>
                                    <i class="fas fa-hashtag me-1"></i>
                                    Sl. No
                                </th>
                                <th>
                                    <i class="fas fa-id-card me-1"></i>
                                    Request ID
                                </th>
                                <th>
                                    <i class="fas fa-car me-1"></i>
                                    Vehicle
                                </th>
                                <th>
                                    <i class="fas fa-certificate me-1"></i>
                                    Registration
                                </th>
                                <th>
                                    <i class="fas fa-envelope me-1"></i>
                                    Owner
                                </th>
                                <th>
                                    <i class="fas fa-calendar me-1"></i>
                                    Date
                                </th>
                                <th>
                                    <i class="fas fa-clock me-1"></i>
                                    Time
                                </th>
                                <th>
                                    <i class="fas fa-map-marker-alt me-1"></i>
                                    Location
                                </th>
                                <th>
                                    <i class="fas fa-cogs me-1"></i>
                                    Action
                                </th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php $__currentLoopData = $inspectionRequests; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $request): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <tr id="row-<?php echo e($request->id); ?>">
                                    <td>
                                        <span class="badge bg-primary"><?php echo e($loop->iteration); ?></span>
                                    </td>
                                    <td>
                                        <span class="badge bg-secondary">#<?php echo e($request->id); ?></span>
                                    </td>
                                    <td>
                                        <div class="car-info">
                                            <div class="car-maker"><?php echo e($request->car->maker ?? 'N/A'); ?></div>
                                            <div class="car-model"><?php echo e($request->car->model ?? 'Model N/A'); ?></div>
                                        </div>
                                    </td>
                                    <td>
                                        <span class="reg-badge">
                                            <?php echo e($request->car->registration_no ?? 'N/A'); ?>

                                        </span>
                                    </td>
                                    <td>
                                        <a href="mailto:<?php echo e($request->car->owner->email ?? ''); ?>" 
                                           class="email-link">
                                            <i class="fas fa-envelope me-1"></i>
                                            <?php echo e($request->car->owner->email ?? 'N/A'); ?>

                                        </a>
                                    </td>
                                    <td>
                                        <?php
                                            $date = \Carbon\Carbon::parse($request->inspection_date);
                                        ?>
                                        <div class="date-display">
                                            <div class="date-day"><?php echo e($date->format('d')); ?></div>
                                            <div class="date-month"><?php echo e($date->format('M Y')); ?></div>
                                        </div>
                                    </td>
                                    <td>
                                        <?php
                                            $timeRange = $request->inspection_time;
                                            $formattedTime = $timeRange;

                                            if (strpos($timeRange, ' - ') !== false) {
                                                [$startTime, $endTime] = explode(' - ', $timeRange);
                                                try {
                                                    $formattedStart = \Carbon\Carbon::parse(trim($startTime))->format('h:i A');
                                                    $formattedEnd = \Carbon\Carbon::parse(trim($endTime))->format('h:i A');
                                                    $formattedTime = $formattedStart . ' - ' . $formattedEnd;
                                                } catch (Exception $e) {
                                                    $formattedTime = $timeRange;
                                                }
                                            }
                                        ?>
                                        <div class="time-display">
                                            <i class="fas fa-clock me-2"></i>
                                            <?php echo e($formattedTime); ?>

                                        </div>
                                    </td>
                                    <td>
                                        <div class="location-display">
                                            <i class="fas fa-map-marker-alt"></i>
                                            <?php echo e($request->location ?? 'N/A'); ?>

                                        </div>
                                    </td>
                                    <td>
                                        <form action="<?php echo e(route('car-admin.inspection-approval')); ?>" 
                                              method="POST" 
                                              class="approval-form"
                                              data-request-id="<?php echo e($request->id); ?>">
                                            <?php echo csrf_field(); ?>
                                            <input type="hidden" name="car_id" value="<?php echo e($request->car->id); ?>">
                                            <input type="hidden" name="inspection_request_id" value="<?php echo e($request->id); ?>">
                                            
                                            <div class="action-buttons">
                                                <button type="submit" 
                                                        name="decision" 
                                                        value="approved" 
                                                        class="btn btn-approve btn-sm loading-btn" 
                                                        data-bs-toggle="tooltip" 
                                                        title="Approve this inspection"
                                                        onclick="return confirmAction('approve', '<?php echo e($request->car->maker); ?> <?php echo e($request->car->model); ?>')">
                                                    <i class="fas fa-check-circle me-1"></i>
                                                    Approve
                                                </button>

                                                <button type="submit" 
                                                        name="decision" 
                                                        value="rejected" 
                                                        class="btn btn-reject btn-sm loading-btn" 
                                                        data-bs-toggle="tooltip" 
                                                        title="Reject this inspection"
                                                        onclick="return confirmAction('reject', '<?php echo e($request->car->maker); ?> <?php echo e($request->car->model); ?>')">
                                                    <i class="fas fa-times-circle me-1"></i>
                                                    Reject
                                                </button>
                                            </div>
                                        </form>
                                    </td>
                                </tr>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </tbody>
                    </table>
                </div>

                
                <?php if(method_exists($inspectionRequests, 'links')): ?>
                    <div class="d-flex justify-content-center mt-4">
                        <?php echo e($inspectionRequests->links()); ?>

                    </div>
                <?php endif; ?>
            <?php else: ?>
                <div class="empty-state">
                    <div class="empty-state-icon">
                        <i class="fas fa-clipboard-check"></i>
                    </div>
                    <h4>No Inspections Pending Approval</h4>
                    <p>All completed inspections have been reviewed. New requests will appear here once inspections are completed.</p>
                    <a href="<?php echo e(route('car-admin.inspection-requests')); ?>" class="btn btn-primary">
                        <i class="fas fa-eye me-2"></i>View All Inspection Requests
                    </a>
                </div>
            <?php endif; ?>
        </div>
    </div>
</div>

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
<?php $__env->stopSection(); ?>

<?php $__env->startPush('scripts'); ?>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Initialize tooltips
        if (typeof bootstrap !== 'undefined' && bootstrap.Tooltip) {
            const tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
            tooltipTriggerList.map(function(tooltipTriggerEl) {
                return new bootstrap.Tooltip(tooltipTriggerEl);
            });
        }

        // Handle form submissions with loading states
        document.querySelectorAll('.approval-form').forEach(form => {
            form.addEventListener('submit', function(e) {
                const submitButton = e.submitter;
                if (submitButton) {
                    handleButtonLoading(submitButton);
                }
            });
        });
    });

    function confirmAction(action, carInfo) {
        const actionText = action === 'approve' ? 'approve' : 'reject';
        const message = `Are you sure you want to ${actionText} the inspection for ${carInfo}?`;
        
        return confirm(message);
    }

    function handleButtonLoading(button) {
        const originalContent = button.innerHTML;
        const isApprove = button.value === 'approved';
        
        // Disable button and show loading
        button.disabled = true;
        button.innerHTML = `
            <div class="spinner-overlay">
                <div class="spinner-border spinner-border-sm" role="status">
                    <span class="visually-hidden">Loading...</span>
                </div>
            </div>
            <span style="visibility: hidden;">${originalContent}</span>
        `;
        
        // Optional: Add visual feedback to the row
        const row = button.closest('tr');
        row.style.opacity = '0.7';
        row.style.transform = 'scale(0.98)';
        
        // Show processing message after a short delay
        setTimeout(() => {
            if (isApprove) {
                button.innerHTML = '<i class="fas fa-check me-1"></i> Processing...';
                button.style.background = 'linear-gradient(135deg, #28a745 0%, #20c997 100%)';
            } else {
                button.innerHTML = '<i class="fas fa-times me-1"></i> Processing...';
                button.style.background = 'linear-gradient(135deg, #dc3545 0%, #c82333 100%)';
            }
        }, 500);
    }

    // Add smooth hover effects
    document.querySelectorAll('.table tbody tr').forEach(row => {
        row.addEventListener('mouseenter', function() {
            this.style.transform = 'translateY(-3px)';
        });
        
        row.addEventListener('mouseleave', function() {
            this.style.transform = 'translateY(0)';
        });
    });

    // Auto-refresh functionality (optional)
    let autoRefreshInterval;
    
    function startAutoRefresh() {
        autoRefreshInterval = setInterval(() => {
            // Only refresh if there are no pending forms
            const pendingForms = document.querySelectorAll('.approval-form button:disabled');
            if (pendingForms.length === 0) {
                location.reload();
            }
        }, 30000); // Refresh every 30 seconds
    }
    
    function stopAutoRefresh() {
        if (autoRefreshInterval) {
            clearInterval(autoRefreshInterval);
        }
    }
    
    // Start auto-refresh when page loads
    // startAutoRefresh();
    
    // Stop auto-refresh when user is about to leave
    window.addEventListener('beforeunload', stopAutoRefresh);
</script>
<?php $__env->stopPush(); ?>
<?php echo $__env->make('layouts.admin', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\Thinley Norbu\Documents\GitHub\FinalProject\resources\views/admin/inspection-approval.blade.php ENDPATH**/ ?>