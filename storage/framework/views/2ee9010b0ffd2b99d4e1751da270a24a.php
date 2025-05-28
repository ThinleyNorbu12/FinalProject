

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
                                <button type="button" 
                                        onclick="viewInspectionDetails(<?php echo e($request->car->id); ?>, '<?php echo e($request->car->registration_no ?? ''); ?>', '<?php echo e($request->car->owner->license_number ?? ''); ?>')" 
                                        class="btn btn-primary btn-sm" 
                                        data-bs-toggle="tooltip" 
                                        title="View inspection details">
                                    <i class="bi bi-eye"></i> View
                                </button>
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

<div class="modal fade" id="inspectionDetailsModal" tabindex="-1" aria-labelledby="inspectionDetailsModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="inspectionDetailsModalLabel">
                    <i class="fas fa-car me-2"></i>Car Inspection Details
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="inspectionForm" action="<?php echo e(route('car-admin.inspection-approval')); ?>" method="POST">
                    <?php echo csrf_field(); ?>
                    <input type="hidden" name="car_id" id="modalCarId">
                    <input type="hidden" name="decision" id="modalDecision">
                    <input type="hidden" name="rejection_reason" id="modalRejectionReason">

                    <!-- Vehicle & Owner Information -->
                    <div class="card mb-4">
                        <div class="card-header bg-primary text-white">
                            <h6 class="mb-0"><i class="fas fa-info-circle me-2"></i>Vehicle & Owner Information</h6>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label for="vehicle_registration_number" class="form-label">
                                            <strong>Vehicle Registration Number</strong> <span class="text-danger">*</span>
                                        </label>
                                        <input type="text" class="form-control" id="vehicle_registration_number" 
                                               name="vehicle_registration_number" required 
                                               pattern="[A-Z]{2}[0-9]{2}[A-Z]{2}[0-9]{4}" 
                                               placeholder="e.g.,BP-1-A0000" readonly>
                                        <div class="form-text">Format: ,BP-1-A0000 (Auto-filled from system)</div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label for="owner_license_number" class="form-label">
                                            <strong>Owner License Number</strong> <span class="text-danger">*</span>
                                        </label>
                                        <input type="text" class="form-control" id="owner_license_number" 
                                               name="owner_license_number" required 
                                               pattern="[A-Z]{2}[0-9]{13}" 
                                               placeholder="e.g., T-100000">
                                        <div class="form-text">Format: T-100000</div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Required Documents/Certificates -->
                    <div class="card mb-4">
                        <div class="card-header bg-info text-white">
                            <h6 class="mb-0"><i class="fas fa-file-alt me-2"></i>Required Documents/Certificates</h6>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-4">
                                    <div class="form-check mb-2">
                                        <input class="form-check-input" type="checkbox" id="valid_registration" name="valid_registration" value="1">
                                        <label class="form-check-label" for="valid_registration">Valid Registration</label>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-check mb-2">
                                        <input class="form-check-input" type="checkbox" id="insurance_valid" name="insurance_valid" value="1">
                                        <label class="form-check-label" for="insurance_valid">Insurance Valid</label>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-check mb-2">
                                        <input class="form-check-input" type="checkbox" id="road_tax_paid" name="road_tax_paid" value="1">
                                        <label class="form-check-label" for="road_tax_paid">Road Tax Paid</label>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-check mb-2">
                                        <input class="form-check-input" type="checkbox" id="fitness_certificate" name="fitness_certificate" value="1">
                                        <label class="form-check-label" for="fitness_certificate">Fitness Certificate</label>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-check mb-2">
                                        <input class="form-check-input" type="checkbox" id="pollution_certificate" name="pollution_certificate" value="1">
                                        <label class="form-check-label" for="pollution_certificate">Pollution Certificate</label>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Exterior Condition -->
                    <div class="card mb-4">
                        <div class="card-header bg-warning text-dark">
                            <h6 class="mb-0"><i class="fas fa-car-side me-2"></i>Exterior Condition</h6>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label for="scratches" class="form-label">Scratches Description</label>
                                        <textarea class="form-control" id="scratches" name="scratches" rows="3" 
                                                  placeholder="Describe any scratches, their location and severity..."></textarea>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label for="dents" class="form-label">Dents Description</label>
                                        <textarea class="form-control" id="dents" name="dents" rows="3" 
                                                  placeholder="Describe any dents, their location and severity..."></textarea>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label for="cracked_lights_or_mirrors" class="form-label">Cracked Lights or Mirrors</label>
                                        <textarea class="form-control" id="cracked_lights_or_mirrors" name="cracked_lights_or_mirrors" rows="3" 
                                                  placeholder="Describe any damage to lights, mirrors, or glass components..."></textarea>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label for="tire_condition" class="form-label">Tire Condition</label>
                                        <select class="form-select" id="tire_condition" name="tire_condition">
                                            <option value="">Select tire condition...</option>
                                            <option value="excellent">Excellent</option>
                                            <option value="good">Good</option>
                                            <option value="fair">Fair</option>
                                            <option value="poor">Poor</option>
                                            <option value="needs_replacement">Needs Replacement</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" id="body_exterior_acceptable" name="body_exterior_acceptable" value="1">
                                        <label class="form-check-label" for="body_exterior_acceptable">Body Exterior Acceptable</label>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Interior Condition -->
                    <div class="card mb-4">
                        <div class="card-header bg-secondary text-white">
                            <h6 class="mb-0"><i class="fas fa-couch me-2"></i>Interior Condition</h6>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label for="seat_dashboard_condition" class="form-label">Seat & Dashboard Condition</label>
                                        <textarea class="form-control" id="seat_dashboard_condition" name="seat_dashboard_condition" rows="3" 
                                                  placeholder="Describe the condition of seats, dashboard, and interior components..."></textarea>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox" id="ac_working" name="ac_working" value="1">
                                            <label class="form-check-label" for="ac_working">AC Working</label>
                                        </div>
                                        <div class="form-check mt-2">
                                            <input class="form-check-input" type="checkbox" id="interior_condition_good" name="interior_condition_good" value="1">
                                            <label class="form-check-label" for="interior_condition_good">Interior Condition Good</label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Mechanical & Safety -->
                    <div class="card mb-4">
                        <div class="card-header bg-success text-white">
                            <h6 class="mb-0"><i class="fas fa-tools me-2"></i>Mechanical & Safety</h6>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-4">
                                    <div class="form-check mb-2">
                                        <input class="form-check-input" type="checkbox" id="engine_condition_good" name="engine_condition_good" value="1">
                                        <label class="form-check-label" for="engine_condition_good">Engine Condition Good</label>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-check mb-2">
                                        <input class="form-check-input" type="checkbox" id="brakes_functional" name="brakes_functional" value="1">
                                        <label class="form-check-label" for="brakes_functional">Brakes Functional</label>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-check mb-2">
                                        <input class="form-check-input" type="checkbox" id="lights_working" name="lights_working" value="1">
                                        <label class="form-check-label" for="lights_working">Lights Working</label>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-check mb-2">
                                        <input class="form-check-input" type="checkbox" id="horn_working" name="horn_working" value="1">
                                        <label class="form-check-label" for="horn_working">Horn Working</label>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-check mb-2">
                                        <input class="form-check-input" type="checkbox" id="no_engine_warning_lights" name="no_engine_warning_lights" value="1">
                                        <label class="form-check-label" for="no_engine_warning_lights">No Engine Warning Lights</label>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-check mb-2">
                                        <input class="form-check-input" type="checkbox" id="indicators_wipers_working" name="indicators_wipers_working" value="1">
                                        <label class="form-check-label" for="indicators_wipers_working">Indicators & Wipers Working</label>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-check mb-2">
                                        <input class="form-check-input" type="checkbox" id="safety_features_working" name="safety_features_working" value="1">
                                        <label class="form-check-label" for="safety_features_working">Safety Features Working</label>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Accessories & Tools -->
                    <div class="card mb-4">
                        <div class="card-header bg-dark text-white">
                            <h6 class="mb-0"><i class="fas fa-wrench me-2"></i>Accessories & Tools</h6>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-check mb-2">
                                        <input class="form-check-input" type="checkbox" id="spare_tire_available" name="spare_tire_available" value="1">
                                        <label class="form-check-label" for="spare_tire_available">Spare Tire Available</label>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-check mb-2">
                                        <input class="form-check-input" type="checkbox" id="jack_available" name="jack_available" value="1">
                                        <label class="form-check-label" for="jack_available">Jack Available</label>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Fuel Level -->
                    <div class="card mb-4">
                        <div class="card-header" style="background-color: #6c757d; color: white;">
                            <h6 class="mb-0"><i class="fas fa-gas-pump me-2"></i>Fuel Information</h6>
                        </div>
                        <div class="card-body">
                            <div class="mb-3">
                                <label class="form-label">Initial Fuel Level</label>
                                <div class="row">
                                    <div class="col-md-2">
                                        <div class="form-check">
                                            <input class="form-check-input" type="radio" name="initial_fuel_level" id="fuel_full" value="full">
                                            <label class="form-check-label" for="fuel_full">Full</label>
                                        </div>
                                    </div>
                                    <div class="col-md-2">
                                        <div class="form-check">
                                            <input class="form-check-input" type="radio" name="initial_fuel_level" id="fuel_three_quarter" value="three_quarter">
                                            <label class="form-check-label" for="fuel_three_quarter">3/4</label>
                                        </div>
                                    </div>
                                    <div class="col-md-2">
                                        <div class="form-check">
                                            <input class="form-check-input" type="radio" name="initial_fuel_level" id="fuel_half" value="half">
                                            <label class="form-check-label" for="fuel_half">Half</label>
                                        </div>
                                    </div>
                                    <div class="col-md-2">
                                        <div class="form-check">
                                            <input class="form-check-input" type="radio" name="initial_fuel_level" id="fuel_quarter" value="quarter">
                                            <label class="form-check-label" for="fuel_quarter">1/4</label>
                                        </div>
                                    </div>
                                    <div class="col-md-2">
                                        <div class="form-check">
                                            <input class="form-check-input" type="radio" name="initial_fuel_level" id="fuel_empty" value="empty">
                                            <label class="form-check-label" for="fuel_empty">Empty</label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Additional Notes and Status -->
                    <div class="card mb-4">
                        <div class="card-header" style="background-color: #6c757d; color: white;">
                            <h6 class="mb-0"><i class="fas fa-sticky-note me-2"></i>Additional Information</h6>
                        </div>
                        <div class="card-body">
                            <div class="mb-3">
                                <label for="additional_notes" class="form-label">Additional Notes</label>
                                <textarea class="form-control" id="additional_notes" name="additional_notes" rows="4" 
                                          placeholder="Provide any additional observations, concerns, or comments about the vehicle..."></textarea>
                            </div>
                            <div class="mb-3">
                                <label for="overall_status" class="form-label">Overall Status (Admin Only)</label>
                                <select class="form-select" id="overall_status" name="overall_status">
                                    <option value="pending" selected>Pending</option>
                                    <option value="approved">Approved</option>
                                    <option value="rejected">Rejected</option>
                                </select>
                            </div>
                        </div>
                    </div>

                    <!-- Rejection Reason Section (Initially Hidden) -->
                    <div class="card mb-4" id="rejectionReasonSection" style="display: none;">
                        <div class="card-header bg-danger text-white">
                            <h6 class="mb-0"><i class="fas fa-times-circle me-2"></i>Rejection Reason</h6>
                        </div>
                        <div class="card-body">
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
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                <button type="button" class="btn btn-success" onclick="approveInspection()">
                    <i class="fas fa-check-circle me-2"></i>Approve
                </button>
                <button type="button" class="btn btn-danger" onclick="showRejectionSection()">
                    <i class="fas fa-times-circle me-2"></i>Reject
                </button>
                <button type="button" class="btn btn-danger" id="confirmRejectBtn" onclick="rejectInspection()" style="display: none;">
                    <i class="fas fa-times-circle me-2"></i>Confirm Rejection
                </button>
            </div>
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

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<script>
    document.addEventListener('DOMContentLoaded', function () {
        const tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
        tooltipTriggerList.map(function (tooltipTriggerEl) {
            return new bootstrap.Tooltip(tooltipTriggerEl);
        });
    });

    let currentCarId = null;

    function viewInspectionDetails(carId, registrationNo = '', licenseNo = '') {
        currentCarId = carId;
        document.getElementById('modalCarId').value = carId;
        
        // Auto-fill the registration number if provided
        if (registrationNo && registrationNo !== 'N/A') {
            document.getElementById('vehicle_registration_number').value = registrationNo;
        }
        
        // Auto-fill the license number if provided
        if (licenseNo && licenseNo !== 'N/A') {
            document.getElementById('owner_license_number').value = licenseNo;
        }
        
        // Reset form to default state
        resetModalForm();
        
        const modal = new bootstrap.Modal(document.getElementById('inspectionDetailsModal'));
        modal.show();
    }

    function resetModalForm() {
        // Reset all checkboxes
        const checkboxes = document.querySelectorAll('#inspectionDetailsModal input[type="checkbox"]');
        checkboxes.forEach(checkbox => checkbox.checked = false);
        
        // Reset all textareas
        const textareas = document.querySelectorAll('#inspectionDetailsModal textarea');
        textareas.forEach(textarea => textarea.value = '');
        
        // Reset selects to default
        document.getElementById('tire_condition').value = '';
        document.getElementById('overall_status').value = 'pending';
        
        // Reset radio buttons
        const radios = document.querySelectorAll('#inspectionDetailsModal input[type="radio"]');
        radios.forEach(radio => radio.checked = false);
        
        // Hide rejection section
        document.getElementById('rejectionReasonSection').style.display = 'none';
        document.querySelector('.btn-danger:not(#confirmRejectBtn)').style.display = 'inline-block';
        document.getElementById('confirmRejectBtn').style.display = 'none';
        
        // Reset rejection reason fields
        document.getElementById('rejectionReasonSelect').value = '';
        document.getElementById('rejectionReasonText').value = '';
        
        // Reset hidden form fields
        document.getElementById('modalDecision').value = '';
        document.getElementById('modalRejectionReason').value = '';
    }

    function approveInspection() {
        if (confirm('Are you sure you want to APPROVE this car inspection?\n\nThis action cannot be undone.')) {
            document.getElementById('modalDecision').value = 'approved';
            document.getElementById('overall_status').value = 'approved';
            document.getElementById('inspectionForm').submit();
        }
    }

    function showRejectionSection() {
        document.getElementById('rejectionReasonSection').style.display = 'block';
        document.querySelector('.btn-danger:not(#confirmRejectBtn)').style.display = 'none';
        document.getElementById('confirmRejectBtn').style.display = 'inline-block';
    }

    function rejectInspection() {
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
        
        if (confirm('Are you sure you want to REJECT this car inspection?\n\nReason: ' + fullReason + '\n\nThis action cannot be undone.')) {
            document.getElementById('modalDecision').value = 'rejected';
            document.getElementById('overall_status').value = 'rejected';
            document.getElementById('modalRejectionReason').value = fullReason;
            document.getElementById('inspectionForm').submit();
        }
    }

    // Form validation for registration and license patterns
    document.getElementById('vehicle_registration_number').addEventListener('input', function(e) {
        this.value = this.value.toUpperCase();
    });

    document.getElementById('owner_license_number').addEventListener('input', function(e) {
        this.value = this.value.toUpperCase();
    });
</script>
<?php echo $__env->make('layouts.admin', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\Thinley Norbu\Documents\GitHub\FinalProject\resources\views/admin/inspection-approval.blade.php ENDPATH**/ ?>