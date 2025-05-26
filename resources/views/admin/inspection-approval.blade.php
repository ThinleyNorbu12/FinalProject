@extends('layouts.admin')

@section('title', 'Approve Inspected Cars')

@section('breadcrumbs')
    <li class="breadcrumb-item active"> Inspections Approval</li>
@endsection

@section('page-header')
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
@endsection

@section('content')
<div class="container">
    <h2 class="mb-4 text-center">Approve or Reject Inspected Cars</h2>

    @if(session('status'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('status') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    @if($inspectionRequests->count() > 0)
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
                    @foreach($inspectionRequests as $request)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ $request->car->maker ?? 'N/A' }} {{ $request->car->model ?? '' }}</td>
                            <td>{{ $request->car->registration_no ?? 'N/A' }}</td>
                            <td>{{ $request->car->owner->email ?? 'N/A' }}</td>
                            <td>{{ \Carbon\Carbon::parse($request->inspection_date)->format('d M Y') }}</td>
                            <td>
                                @php
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
                                @endphp
                                {{ $formattedTime }}
                            </td>
                            <td>{{ $request->location ?? 'N/A' }}</td>
                            <td>
                                <form id="inspection-form-{{ $request->car->id }}" action="{{ route('car-admin.inspection-approval') }}" method="POST" class="d-flex justify-content-center gap-2">
                                    @csrf
                                    <input type="hidden" name="car_id" value="{{ $request->car->id }}">
                                    <input type="hidden" name="rejection_reason" id="rejection-reason-{{ $request->car->id }}">
                                    
                                    <button type="button" 
                                            onclick="confirmApproval({{ $request->car->id }}, '{{ $request->car->maker ?? 'N/A' }} {{ $request->car->model ?? '' }}', '{{ $request->car->registration_no ?? 'N/A' }}')" 
                                            class="btn btn-success btn-sm" 
                                            data-bs-toggle="tooltip" 
                                            title="Approve this car">
                                        <i class="bi bi-check-circle"></i>
                                    </button>
                                    
                                    <button type="button" 
                                            onclick="confirmRejection({{ $request->car->id }}, '{{ $request->car->maker ?? 'N/A' }} {{ $request->car->model ?? '' }}', '{{ $request->car->registration_no ?? 'N/A' }}')" 
                                            class="btn btn-danger btn-sm" 
                                            data-bs-toggle="tooltip" 
                                            title="Reject this car">
                                        <i class="bi bi-x-circle"></i>
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    @else
        <div class="alert alert-info text-center">No confirmed inspection requests pending approval.</div>
    @endif
</div>
@endsection
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

{{-- Bootstrap Icons --}}
<link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">

{{-- Tooltip Activation --}}
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
