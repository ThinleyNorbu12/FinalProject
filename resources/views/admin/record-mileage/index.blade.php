@extends('layouts.admin')

@section('title', 'Record Mileage')
@section('breadcrumbs')
    <li class="breadcrumb-item active">Record Mileage</li>
@endsection
@section('content')
<div class="container-fluid">
    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    @if(session('error'))
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            {{ session('error') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    <!-- Search Section -->
    <div class="row mb-4">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <form method="GET" action="{{ route('car-admin.record-mileage') }}" class="row g-3">
                        <div class="col-md-10">
                            <div class="input-group">
                                <span class="input-group-text">
                                    <i class="fas fa-search"></i>
                                </span>
                                <input type="text" 
                                       class="form-control" 
                                       name="search" 
                                       value="{{ request('search') }}"
                                       placeholder="Search by Booking ID, Customer Name, Email, Car Model, or Registration Number..."
                                       autocomplete="off">
                            </div>
                        </div>
                        <div class="col-md-2">
                            <div class="d-flex gap-2">
                                <button type="submit" class="btn btn-primary">
                                    <i class="fas fa-search me-1"></i>Search
                                </button>
                                @if(request('search'))
                                    <a href="{{ route('car-admin.record-mileage') }}" class="btn btn-outline-secondary">
                                        <i class="fas fa-times me-1"></i>Clear
                                    </a>
                                @endif
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    @if(request('search'))
        <div class="row mb-3">
            <div class="col-12">
                <div class="alert alert-info">
                    <i class="fas fa-info-circle me-2"></i>
                    Showing results for: <strong>"{{ request('search') }}"</strong>
                    <span class="ms-3">
                        Found {{ count($pickupBookings) + count($returnBookings) }} total records
                        ({{ count($pickupBookings) }} pickup, {{ count($returnBookings) }} return)
                    </span>
                </div>
            </div>
        </div>
    @endif

    <!-- Pickup Records Section -->
    <div class="row mb-4">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h5 class="card-title mb-0">
                        <i class="fas fa-car text-primary me-2"></i>
                        Car Pickups - Record Initial Mileage
                        <span class="badge bg-primary ms-2">{{ count($pickupBookings) }}</span>
                    </h5>
                </div>
                <div class="card-body">
                    @if(count($pickupBookings) > 0)
                        <div class="table-responsive">
                            <table class="table table-bordered table-hover">
                                <thead class="table-light">
                                    <tr>
                                        <th>Booking ID</th>
                                        <th>Customer</th>
                                        <th>Car Details</th>
                                        <th>Pickup Date</th>
                                        <th>Current Mileage</th>
                                        <th>Daily Limit</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($pickupBookings as $booking)
                                    <tr {{ $booking->status === 'picked_up' ? 'class=table-success' : '' }}>
                                        <td><strong>#{{ $booking->id }}</strong></td>
                                        <td>
                                            <div class="fw-bold">{{ $booking->customer_name }}</div>
                                            <small class="text-muted">{{ $booking->customer_email }}</small>
                                        </td>
                                        <td>
                                            <div class="fw-bold">{{ $booking->maker }} {{ $booking->model }}</div>
                                            <small class="text-muted">{{ $booking->registration_no }}</small>
                                        </td>
                                        <td>{{ \Carbon\Carbon::parse($booking->pickup_datetime)->format('M d, Y H:i') }}</td>
                                        <td>
                                            <span class="badge bg-info">{{ number_format($booking->current_mileage ?? 0) }} km</span>
                                        </td>
                                        <td>
                                            <span class="badge bg-secondary">{{ $booking->mileage_limit ?? 'N/A' }} km/day</span>
                                        </td>
                                        <td>
                                            @if($booking->status === 'picked_up')
                                                <button class="btn btn-success btn-sm" disabled>
                                                    <i class="fas fa-check me-1"></i>Picked Up
                                                </button>
                                            @else
                                                <button class="btn btn-success btn-sm" onclick="openPickupModal({{ $booking->id }}, '{{ $booking->maker }} {{ $booking->model }}', '{{ $booking->customer_name }}', {{ $booking->current_mileage ?? 0 }})">
                                                    <i class="fas fa-clipboard-check me-1"></i>Record Pickup
                                                </button>
                                            @endif
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @else
                        <div class="text-center py-4">
                            <i class="fas fa-car-side fa-3x text-muted mb-3"></i>
                            @if(request('search'))
                                <h5 class="text-muted">No pickup records found</h5>
                                <p class="text-muted">No pickup records match your search criteria.</p>
                            @else
                                <h5 class="text-muted">No pickups pending</h5>
                                <p class="text-muted">All confirmed bookings have been processed for pickup.</p>
                            @endif
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <!-- Return Records Section -->
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h5 class="card-title mb-0">
                        <i class="fas fa-undo text-warning me-2"></i>
                        Car Returns - Record Final Mileage
                        <span class="badge bg-warning ms-2">{{ count($returnBookings) }}</span>
                    </h5>
                </div>
                <div class="card-body">
                    @if(count($returnBookings) > 0)
                        <div class="table-responsive">
                            <table class="table table-bordered table-hover">
                                <thead class="table-light">
                                    <tr>
                                        <th>Booking ID</th>
                                        <th>Customer</th>
                                        <th>Car Details</th>
                                        <th>Return Date</th>
                                        <th>Pickup Mileage</th>
                                        <th>Daily Limit</th>
                                        <th>Rate/km</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($returnBookings as $booking)
                                    <tr {{ ($booking->status === 'returned' || $booking->mileage_at_return) ? 'class=table-warning' : '' }}>
                                        <td><strong>#{{ $booking->id }}</strong></td>
                                        <td>
                                            <div class="fw-bold">{{ $booking->customer_name }}</div>
                                            <small class="text-muted">{{ $booking->customer_email }}</small>
                                        </td>
                                        <td>
                                            <div class="fw-bold">{{ $booking->maker }} {{ $booking->model }}</div>
                                            <small class="text-muted">{{ $booking->registration_no }}</small>
                                        </td>
                                        <td>{{ \Carbon\Carbon::parse($booking->dropoff_datetime)->format('M d, Y H:i') }}</td>
                                        <td>
                                            <span class="badge bg-info">{{ number_format($booking->mileage_at_pickup) }} km</span>
                                        </td>
                                        <td>
                                            <span class="badge bg-secondary">{{ $booking->mileage_limit ?? 'N/A' }} km/day</span>
                                        </td>
                                        <td>
                                            <span class="badge bg-primary">Nu. {{ $booking->price_per_km ?? '0' }}/km</span>
                                        </td>
                                        <td>
                                            @if($booking->status === 'returned' || $booking->mileage_at_return)
                                                <button class="btn btn-secondary btn-sm" disabled title="Already returned">
                                                    <i class="fas fa-check me-1"></i>Returned
                                                </button>
                                                @if($booking->mileage_at_return)
                                                    <br><small class="text-muted mt-1">Final: {{ number_format($booking->mileage_at_return) }} km</small>
                                                @endif
                                            @else
                                                <button class="btn btn-warning btn-sm" onclick="openReturnModal({{ json_encode($booking) }})">
                                                    <i class="fas fa-clipboard-check me-1"></i>Record Return
                                                </button>
                                            @endif
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @else
                        <div class="text-center py-4">
                            <i class="fas fa-car-crash fa-3x text-muted mb-3"></i>
                            @if(request('search'))
                                <h5 class="text-muted">No return records found</h5>
                                <p class="text-muted">No return records match your search criteria.</p>
                            @else
                                <h5 class="text-muted">No returns pending</h5>
                                <p class="text-muted">All cars are either on rent or have been returned.</p>
                            @endif
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

<!-- Pickup Modal -->
<div class="modal fade" id="pickupModal" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <form method="POST" action="{{ route('car-admin.record-pickup') }}">
                @csrf
                <div class="modal-header">
                    <h5 class="modal-title">
                        <i class="fas fa-car-side me-2"></i>Record Car Pickup
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <input type="hidden" name="booking_id" id="pickup_booking_id">
                    
                    <div class="row mb-3">
                        <div class="col-md-6">
                            <strong>Car:</strong> <span id="pickup_car_details"></span>
                        </div>
                        <div class="col-md-6">
                            <strong>Customer:</strong> <span id="pickup_customer_name"></span>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="mileage_at_pickup" class="form-label">Current Mileage (km) <span class="text-danger">*</span></label>
                            <input type="number" class="form-control" name="mileage_at_pickup" id="mileage_at_pickup" required min="0">
                            <small class="text-muted">Previous mileage: <span id="previous_mileage"></span> km</small>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="fuel_level_pickup" class="form-label">Fuel Level <span class="text-danger">*</span></label>
                            <select class="form-select" name="fuel_level_pickup" required>
                                <option value="">Select fuel level</option>
                                <option value="Full">Full</option>
                                <option value="3/4">3/4</option>
                                <option value="1/2">1/2</option>
                                <option value="1/4">1/4</option>
                                <option value="Empty">Empty</option>
                            </select>
                        </div>
                    </div>

                    <div class="mb-3">
                        <label for="car_condition_pickup" class="form-label">Car Condition Notes</label>
                        <textarea class="form-control" name="car_condition_pickup" rows="3" placeholder="Note any existing damages, scratches, or issues..."></textarea>
                    </div>

                    <div class="mb-3">
                        <label for="pickup_notes" class="form-label">Additional Notes</label>
                        <textarea class="form-control" name="pickup_notes" rows="2" placeholder="Any additional information..."></textarea>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-success">
                        <i class="fas fa-save me-1"></i>Record Pickup
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Return Modal -->
<div class="modal fade" id="returnModal" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <form method="POST" action="{{ route('car-admin.record-return') }}" id="returnForm">
                @csrf
                <div class="modal-header">
                    <h5 class="modal-title">
                        <i class="fas fa-undo me-2"></i>Record Car Return
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <input type="hidden" name="booking_id" id="return_booking_id">
                    
                    <div class="row mb-3">
                        <div class="col-md-6">
                            <strong>Car:</strong> <span id="return_car_details"></span>
                        </div>
                        <div class="col-md-6">
                            <strong>Customer:</strong> <span id="return_customer_name"></span>
                        </div>
                    </div>

                    <div class="row mb-3">
                        <div class="col-md-4">
                            <strong>Pickup Mileage:</strong> <span id="return_pickup_mileage" class="badge bg-info"></span>
                        </div>
                        <div class="col-md-4">
                            <strong>Allowed Mileage:</strong> <span id="return_allowed_mileage" class="badge bg-secondary"></span>
                        </div>
                        <div class="col-md-4">
                            <strong>Rate per km:</strong> <span id="return_rate_per_km" class="badge bg-primary"></span>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="mileage_at_return" class="form-label">Current Mileage (km) <span class="text-danger">*</span></label>
                            <input type="number" class="form-control" name="mileage_at_return" id="mileage_at_return" required min="0" onchange="calculateExcess()">
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="fuel_level_return" class="form-label">Fuel Level <span class="text-danger">*</span></label>
                            <select class="form-select" name="fuel_level_return" required>
                                <option value="">Select fuel level</option>
                                <option value="Full">Full</option>
                                <option value="3/4">3/4</option>
                                <option value="1/2">1/2</option>
                                <option value="1/4">1/4</option>
                                <option value="Empty">Empty</option>
                            </select>
                        </div>
                    </div>

                    <div class="row mb-3">
                        <div class="col-md-4">
                            <label class="form-label">Mileage Used</label>
                            <input type="text" class="form-control" id="mileage_used_display" readonly>
                        </div>
                        <div class="col-md-4">
                            <label class="form-label">Excess Mileage</label>
                            <input type="text" class="form-control" id="excess_mileage_display" readonly>
                        </div>
                        <div class="col-md-4">
                            <label class="form-label">Excess Charges</label>
                            <input type="text" class="form-control" id="excess_charges_display" readonly>
                        </div>
                    </div>

                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label for="damage_reported" class="form-label">Any Damage Reported?</label>
                            <select class="form-select" name="damage_reported" id="damage_reported" onchange="toggleDamageDescription()">
                                <option value="No">No</option>
                                <option value="Yes">Yes</option>
                            </select>
                        </div>
                        <div class="col-md-6" id="damage_description_container" style="display: none;">
                            <label for="damage_description" class="form-label">Damage Description</label>
                            <textarea class="form-control" name="damage_description" id="damage_description" rows="2"></textarea>
                        </div>
                    </div>

                    <div class="mb-3">
                        <label for="car_condition_return" class="form-label">Car Condition Notes</label>
                        <textarea class="form-control" name="car_condition_return" rows="3" placeholder="Note the condition of the car upon return..."></textarea>
                    </div>

                    <div class="mb-3">
                        <label for="return_notes" class="form-label">Additional Notes</label>
                        <textarea class="form-control" name="return_notes" rows="2" placeholder="Any additional information..."></textarea>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-warning" id="submitReturnBtn">
                        <i class="fas fa-save me-1"></i>Record Return
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
function openPickupModal(bookingId, carDetails, customerName, currentMileage) {
    document.getElementById('pickup_booking_id').value = bookingId;
    document.getElementById('pickup_car_details').textContent = carDetails;
    document.getElementById('pickup_customer_name').textContent = customerName;
    document.getElementById('previous_mileage').textContent = currentMileage;
    document.getElementById('mileage_at_pickup').value = currentMileage;
    
    var modal = new bootstrap.Modal(document.getElementById('pickupModal'));
    modal.show();
}

function openReturnModal(booking) {
    document.getElementById('return_booking_id').value = booking.id;
    document.getElementById('return_car_details').textContent = booking.maker + ' ' + booking.model;
    document.getElementById('return_customer_name').textContent = booking.customer_name;
    document.getElementById('return_pickup_mileage').textContent = booking.mileage_at_pickup + ' km';
    
    // Calculate allowed mileage
    var pickupDate = new Date(booking.pickup_datetime);
    var dropoffDate = new Date(booking.dropoff_datetime);
    var rentalDays = Math.ceil((dropoffDate - pickupDate) / (1000 * 60 * 60 * 24)) + 1;
    var allowedMileage = (booking.mileage_limit || 0) * rentalDays;
    
    document.getElementById('return_allowed_mileage').textContent = allowedMileage + ' km';
    document.getElementById('return_rate_per_km').textContent = 'Nu. ' + (booking.price_per_km || 0) + '/km';
    
    // Store values for calculation
    window.pickupMileage = parseInt(booking.mileage_at_pickup);
    window.allowedMileage = allowedMileage;
    window.ratePerKm = parseFloat(booking.price_per_km || 0);
    
    var modal = new bootstrap.Modal(document.getElementById('returnModal'));
    modal.show();
}

function calculateExcess() {
    var returnMileage = parseInt(document.getElementById('mileage_at_return').value) || 0;
    var mileageUsed = returnMileage - window.pickupMileage;
    var excessMileage = Math.max(0, mileageUsed - window.allowedMileage);
    var excessCharges = excessMileage * window.ratePerKm;
    
    document.getElementById('mileage_used_display').value = mileageUsed + ' km';
    document.getElementById('excess_mileage_display').value = excessMileage + ' km';
    document.getElementById('excess_charges_display').value = 'Nu. ' + excessCharges.toFixed(2);
    
    // Highlight excess charges if any
    var chargesField = document.getElementById('excess_charges_display');
    if (excessCharges > 0) {
        chargesField.classList.add('text-danger', 'fw-bold');
    } else {
        chargesField.classList.remove('text-danger', 'fw-bold');
    }
}

function toggleDamageDescription() {
    var damageReported = document.getElementById('damage_reported').value;
    var damageContainer = document.getElementById('damage_description_container');
    
    if (damageReported === 'Yes') {
        damageContainer.style.display = 'block';
        document.getElementById('damage_description').required = true;
    } else {
        damageContainer.style.display = 'none';
        document.getElementById('damage_description').required = false;
        document.getElementById('damage_description').value = '';
    }
}

// Handle form submission for return
document.getElementById('returnForm').addEventListener('submit', function() {
    var submitBtn = document.getElementById('submitReturnBtn');
    submitBtn.disabled = true;
    submitBtn.innerHTML = '<i class="fas fa-spinner fa-spin me-1"></i>Processing...';
});

// Initialize tooltips
document.addEventListener('DOMContentLoaded', function() {
    var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
    var tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {
        return new bootstrap.Tooltip(tooltipTriggerEl);
    });
});
</script>