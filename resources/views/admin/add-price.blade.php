@extends('layouts.admin')

@section('title', 'Add Car Pricing')
@section('breadcrumbs')
    <li class="breadcrumb-item active">Add Price</li>
@endsection
@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Add Car Pricing Information</h3>
                </div>
                
                <div class="card-body">
                    @if(session('success'))
                        <div class="alert alert-success alert-dismissible fade show" role="alert">
                            {{ session('success') }}
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                    @endif

                    @if(session('error'))
                        <div class="alert alert-danger alert-dismissible fade show" role="alert">
                            {{ session('error') }}
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                    @endif

                    <form action="{{ route('car-admin.add-price.store') }}" method="POST">
                        @csrf
                        
                        <!-- Car Search Section -->
                        <div class="row">
                            <div class="col-12">
                                <div class="form-group">
                                    <label for="car_search">Search Car <span class="text-danger">*</span></label>
                                    <input type="text" 
                                           id="car_search" 
                                           class="form-control"
                                           placeholder="Search by car maker, model, or registration number..."
                                           autocomplete="off">
                                    <div id="search_results" class="search-results"></div>
                                </div>
                            </div>
                        </div>
                        
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="car_id">Select Car <span class="text-danger">*</span></label>
                                    <select name="car_id" id="car_id" class="form-control @error('car_id') is-invalid @enderror" required>
                                        <option value="">Choose a car...</option>
                                        @php
                                            // Get approved cars that need pricing (don't have pricing_active = true or missing pricing fields)
                                            $approvedCarsNeedingPricing = $cars->filter(function($car) {
                                                $hasApprovedInspection = $car->inspectionRequests()->whereHas('inspectionDecision', function($query) {
                                                    $query->where('decision', 'approved');
                                                })->exists();
                                                
                                                // Return cars that are approved but don't have complete pricing
                                                return $hasApprovedInspection && (
                                                    !$car->pricing_active || 
                                                    is_null($car->rate_per_day) || 
                                                    is_null($car->price_per_km) || 
                                                    is_null($car->mileage_limit) || 
                                                    is_null($car->current_mileage)
                                                );
                                            });
                                        @endphp
                                        @foreach($approvedCarsNeedingPricing as $car)
                                            <option value="{{ $car->id }}" {{ old('car_id') == $car->id ? 'selected' : '' }}>
                                                {{ $car->maker ?? 'N/A' }} {{ $car->model ?? 'N/A' }} - {{ $car->registration_no ?? 'N/A' }}
                                                @if($car->pricing_active && !is_null($car->rate_per_day))
                                                    (Has Pricing - Update Available)
                                                @else
                                                    (Needs Pricing)
                                                @endif
                                            </option>
                                        @endforeach
                                    </select>
                                    @error('car_id')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="rate_per_day">Rate per Day (Nu.) <span class="text-danger">*</span></label>
                                    <input type="number" 
                                           name="rate_per_day" 
                                           id="rate_per_day" 
                                           class="form-control @error('rate_per_day') is-invalid @enderror"
                                           placeholder="Enter daily rate"
                                           step="0.01"
                                           min="0"
                                           value="{{ old('rate_per_day') }}"
                                           required>
                                    @error('rate_per_day')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="mileage_limit">Mileage Limit (km/day) <span class="text-danger">*</span></label>
                                    <input type="number" 
                                           name="mileage_limit" 
                                           id="mileage_limit" 
                                           class="form-control @error('mileage_limit') is-invalid @enderror"
                                           placeholder="Enter daily mileage limit"
                                           step="0.1"
                                           min="0"
                                           value="{{ old('mileage_limit') }}"
                                           required>
                                    @error('mileage_limit')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="price_per_km">Price per Kilometer (Nu.) <span class="text-danger">*</span></label>
                                    <input type="number" 
                                           name="price_per_km" 
                                           id="price_per_km" 
                                           class="form-control @error('price_per_km') is-invalid @enderror"
                                           placeholder="Enter price per km above limit"
                                           step="0.01"
                                           min="0"
                                           value="{{ old('price_per_km') }}"
                                           required>
                                    @error('price_per_km')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="current_mileage">Current Mileage (km) <span class="text-danger">*</span></label>
                                    <input type="number" 
                                           name="current_mileage" 
                                           id="current_mileage" 
                                           class="form-control @error('current_mileage') is-invalid @enderror"
                                           placeholder="Enter current odometer reading"
                                           step="0.1"
                                           min="0"
                                           value="{{ old('current_mileage') }}"
                                           required>
                                    @error('current_mileage')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <div class="form-group mt-3">
                            <button type="submit" class="btn btn-primary me-2">
                                <i class="fas fa-save"></i> Save Pricing Information
                            </button>
                            <a href="{{ route('admin.dashboard') }}" class="btn btn-secondary">
                                <i class="fas fa-times"></i> Cancel
                            </a>
                        </div>

                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Display existing pricing records -->
    <div class="row mt-4">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Current Car Pricing Records</h3>
                </div>
                <div class="card-body">
                    @php
                        // Get cars that have pricing information (pricing_active = true and have pricing fields)
                        $carsWithPricing = \App\Models\CarDetail::where('pricing_active', true)
                            ->whereNotNull('rate_per_day')
                            ->whereNotNull('price_per_km')
                            ->whereNotNull('mileage_limit')
                            ->whereNotNull('current_mileage')
                            ->with('owner')
                            ->latest()
                            ->get();
                    @endphp
                    
                    @if($carsWithPricing->count() > 0)
                        <div class="table-responsive">
                            <table class="table table-bordered table-striped">
                                <thead>
                                    <tr>
                                        <th>Car</th>
                                        <th>Owner</th>
                                        <th>Rate/Day</th>
                                        <th>Mileage Limit</th>
                                        <th>Price/KM</th>
                                        <th>Current Mileage</th>
                                        <th>Status</th>
                                        <th>Updated</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($carsWithPricing as $car)
                                        <tr>
                                            <td>
                                                <strong>{{ $car->maker ?? 'N/A' }} {{ $car->model ?? '' }}</strong><br>
                                                <small class="text-muted">{{ $car->registration_no ?? 'No Reg' }}</small>
                                            </td>
                                            <td>{{ $car->owner->name ?? 'N/A' }}</td>
                                            <td>Nu. {{ number_format($car->rate_per_day, 2) }}</td>
                                            <td>{{ number_format($car->mileage_limit, 1) }} km/day</td>
                                            <td>Nu. {{ number_format($car->price_per_km, 2) }}</td>
                                            <td>{{ number_format($car->current_mileage, 1) }} km</td>
                                            <td>
                                                @if($car->pricing_active)
                                                    <span class="badge badge-success">Active</span>
                                                @else
                                                    <span class="badge badge-warning">Inactive</span>
                                                @endif
                                            </td>
                                            <td>{{ $car->updated_at->format('M d, Y H:i') }}</td>
                                            <td>
                                                <button class="btn btn-sm btn-warning" onclick="editPricing({{ $car->id }})">
                                                    <i class="fas fa-edit"></i> Edit
                                                </button>
                                                <button class="btn btn-sm {{ $car->pricing_active ? 'btn-secondary' : 'btn-success' }}" 
                                                        onclick="togglePricingStatus({{ $car->id }})">
                                                    <i class="fas fa-{{ $car->pricing_active ? 'pause' : 'play' }}"></i> 
                                                    {{ $car->pricing_active ? 'Deactivate' : 'Activate' }}
                                                </button>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @else
                        <p class="text-muted">No pricing records found.</p>
                    @endif
                </div>
            </div>
        </div>
    </div>
@endsection
    <!-- Edit Pricing Modal -->
    <div class="modal fade" id="editPricingModal" tabindex="-1" role="dialog" aria-labelledby="editPricingModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="editPricingModalLabel">Edit Car Pricing</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close" onclick="closeModal()">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form id="editPricingForm">
                    <div class="modal-body">
                        <div class="alert alert-danger" id="editErrorAlert" style="display: none;"></div>
                        
                        <input type="hidden" id="edit_pricing_id">
                        
                        <div class="form-group">
                            <label>Selected Car</label>
                            <input type="text" id="edit_car_name" class="form-control" readonly>
                        </div>
                        
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="edit_rate_per_day">Rate per Day (Nu.) <span class="text-danger">*</span></label>
                                    <input type="number" 
                                           id="edit_rate_per_day" 
                                           class="form-control"
                                           placeholder="Enter daily rate"
                                           step="0.01"
                                           min="0"
                                           required>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="edit_price_per_km">Price per Kilometer (Nu.) <span class="text-danger">*</span></label>
                                    <input type="number" 
                                           id="edit_price_per_km" 
                                           class="form-control"
                                           placeholder="Enter price per km"
                                           step="0.01"
                                           min="0"
                                           required>
                                </div>
                            </div>
                        </div>
                        
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="edit_mileage_limit">Mileage Limit (km/day) <span class="text-danger">*</span></label>
                                    <input type="number" 
                                           id="edit_mileage_limit" 
                                           class="form-control"
                                           placeholder="Enter daily mileage limit"
                                           step="0.1"
                                           min="0"
                                           required>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="edit_current_mileage">Current Mileage (km) <span class="text-danger">*</span></label>
                                    <input type="number" 
                                           id="edit_current_mileage" 
                                           class="form-control"
                                           placeholder="Enter current odometer reading"
                                           step="0.1"
                                           min="0"
                                           required>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal" onclick="closeModal()">Cancel</button>
                        <button type="submit" class="btn btn-primary" id="updatePricingBtn">
                            <i class="fas fa-save"></i> Update Pricing
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<style>
.alert {
    margin-bottom: 20px;
}

.form-group label {
    font-weight: 600;
}

.text-danger {
    color: #dc3545 !important;
}

.card {
    box-shadow: 0 0 1px rgba(0,0,0,.125), 0 1px 3px rgba(0,0,0,.2);
}

.btn {
    margin-right: 10px;
}

.table {
    margin-bottom: 0;
}

.badge {
    font-size: 0.75em;
}

/* Search Results Styling */
.search-results {
    position: relative;
    max-height: 300px;
    overflow-y: auto;
    border: 1px solid #ddd;
    border-top: none;
    background: white;
    z-index: 1000;
    display: none;
}

.search-result-item {
    padding: 12px 15px;
    border-bottom: 1px solid #eee;
    cursor: pointer;
    transition: background-color 0.2s;
}

.search-result-item:hover {
    background-color: #f8f9fa;
}

.search-result-item:last-child {
    border-bottom: none;
}

.car-info {
    font-weight: 600;
    color: #333;
}

.car-details {
    font-size: 0.9em;
    color: #666;
    margin-top: 2px;
}

.no-results {
    padding: 15px;
    text-align: center;
    color: #999;
    font-style: italic;
}

#car_search:focus + .search-results {
    border-color: #80bdff;
    box-shadow: 0 0 0 0.2rem rgba(0, 123, 255, 0.25);
}
</style>

<!-- Add jQuery if not already included -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<!-- Make sure Bootstrap JS is included for modal functionality -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.0/dist/js/bootstrap.bundle.min.js"></script>

<script>
// Car search functionality
document.addEventListener('DOMContentLoaded', function() {
    const searchInput = document.getElementById('car_search');
    const searchResults = document.getElementById('search_results');
    const carSelect = document.getElementById('car_id');
    
    // All cars data for searching (only approved cars needing pricing)
    const carsData = [
        @php
            $approvedCarsNeedingPricing = $cars->filter(function($car) {
                $hasApprovedInspection = $car->inspectionRequests()->whereHas('inspectionDecision', function($query) {
                    $query->where('decision', 'approved');
                })->exists();
                
                return $hasApprovedInspection && (
                    !$car->pricing_active || 
                    is_null($car->rate_per_day) || 
                    is_null($car->price_per_km) || 
                    is_null($car->mileage_limit) || 
                    is_null($car->current_mileage)
                );
            });
        @endphp
        @foreach($approvedCarsNeedingPricing as $car)
            {
                id: {{ $car->id }},
                maker: "{{ $car->maker ?? 'N/A' }}",
                model: "{{ $car->model ?? 'N/A' }}",
                registration_no: "{{ $car->registration_no ?? 'N/A' }}",
                display: "{{ ($car->maker ?? 'N/A') . ' ' . ($car->model ?? 'N/A') . ' - ' . ($car->registration_no ?? 'N/A') }}",
                has_pricing: {{ $car->pricing_active && !is_null($car->rate_per_day) ? 'true' : 'false' }}
            }{{ !$loop->last ? ',' : '' }}
        @endforeach
    ];
    
    searchInput.addEventListener('input', function() {
        const query = this.value.toLowerCase().trim();
        
        if (query.length < 2) {
            searchResults.style.display = 'none';
            return;
        }
        
        const filteredCars = carsData.filter(car => {
            return car.maker.toLowerCase().includes(query) ||
                   car.model.toLowerCase().includes(query) ||
                   car.registration_no.toLowerCase().includes(query) ||
                   car.display.toLowerCase().includes(query);
        });
        
        displaySearchResults(filteredCars);
    });
    
    function displaySearchResults(cars) {
        if (cars.length === 0) {
            searchResults.innerHTML = '<div class="no-results">No cars found matching your search</div>';
            searchResults.style.display = 'block';
            return;
        }
        
        let html = '';
        cars.forEach(car => {
            const status = car.has_pricing ? 'Has Pricing - Update Available' : 'Needs Pricing';
            const statusClass = car.has_pricing ? 'text-warning' : 'text-info';
            
            html += `
                <div class="search-result-item" data-car-id="${car.id}">
                    <div class="car-info">${car.maker} ${car.model}</div>
                    <div class="car-details">
                        Registration: ${car.registration_no} 
                        <span class="${statusClass}">• ${status}</span>
                    </div>
                </div>
            `;
        });
        
        searchResults.innerHTML = html;
        searchResults.style.display = 'block';
        
        // Add click listeners to search results
        searchResults.querySelectorAll('.search-result-item').forEach(item => {
            item.addEventListener('click', function() {
                const carId = this.getAttribute('data-car-id');
                const carInfo = this.querySelector('.car-info').textContent;
                const carReg = this.querySelector('.car-details').textContent.split('•')[0].replace('Registration: ', '').trim();
                
                // Update the dropdown selection
                carSelect.value = carId;
                
                // Update search input with selected car info
                searchInput.value = `${carInfo} - ${carReg}`;
                
                // Hide search results
                searchResults.style.display = 'none';
            });
        });
    }
    
    // Hide search results when clicking outside
    document.addEventListener('click', function(e) {
        if (!searchInput.contains(e.target) && !searchResults.contains(e.target)) {
            searchResults.style.display = 'none';
        }
    });
    
    // Show search results when focusing on search input
    searchInput.addEventListener('focus', function() {
        if (this.value.length >= 2) {
            searchResults.style.display = 'block';
        }
    });
});

// Edit pricing function
function editPricing(id) {
    $.ajax({
        url: `/car-admin/get-pricing/${id}`,
        type: 'GET',
        success: function(response) {
            if (response.success) {
                // Populate modal with data
                $('#edit_pricing_id').val(response.data.id);
                $('#edit_car_name').val(response.data.car_name);
                $('#edit_rate_per_day').val(response.data.rate_per_day);
                $('#edit_price_per_km').val(response.data.price_per_km);
                $('#edit_mileage_limit').val(response.data.mileage_limit);
                $('#edit_current_mileage').val(response.data.current_mileage);
                
                // Hide error alert
                $('#editErrorAlert').hide();
                
                // Show modal
                $('#editPricingModal').modal('show');
            } else {
                alert('Error: ' + response.message);
            }
        },
        error: function(xhr) {
            alert('Failed to load pricing data');
        }
    });
}

// Toggle pricing status function
function togglePricingStatus(id) {
    if (confirm('Are you sure you want to change the pricing status for this car?')) {
        $.ajax({
            url: `/car-admin/toggle-pricing-status/${id}`,
            type: 'POST',
            data: {
                _token: $('meta[name="csrf-token"]').attr('content')
            },
            success: function(response) {
                if (response.success) {
                    alert(response.message);
                    location.reload();
                } else {
                    alert('Error: ' + response.message);
                }
            },
            error: function(xhr) {
                alert('Failed to toggle pricing status');
            }
        });
    }
}

// Handle edit form submission
$('#editPricingForm').on('submit', function(e) {
    e.preventDefault();
    
    const pricingId = $('#edit_pricing_id').val();
    const formData = {
        rate_per_day: $('#edit_rate_per_day').val(),
        price_per_km: $('#edit_price_per_km').val(),
        mileage_limit: $('#edit_mileage_limit').val(),
        current_mileage: $('#edit_current_mileage').val(),
        _token: $('meta[name="csrf-token"]').attr('content'),
        _method: 'PUT'
    };
    
    // Disable submit button
    $('#updatePricingBtn').prop('disabled', true).html('<i class="fas fa-spinner fa-spin"></i> Updating...');
    
    $.ajax({
        url: `/car-admin/update-pricing/${pricingId}`,
        type: 'POST',
        data: formData,
        success: function(response) {
            if (response.success) {
                // Close modal
                $('#editPricingModal').modal('hide');
                
                // Show success message and reload page
                alert(response.message);
                location.reload();
            } else {
                $('#editErrorAlert').text(response.message).show();
            }
        },
        error: function(xhr) {
            let errorMessage = 'Failed to update pricing information';
            
            if (xhr.responseJSON && xhr.responseJSON.errors) {
                errorMessage = Object.values(xhr.responseJSON.errors).flat().join('. ');
            } else if (xhr.responseJSON && xhr.responseJSON.message) {
                errorMessage = xhr.responseJSON.message;
            }
            
            $('#editErrorAlert').text(errorMessage).show();
        },
        complete: function() {
            // Re-enable submit button
            $('#updatePricingBtn').prop('disabled', false).html('<i class="fas fa-save"></i> Update Pricing');
        }
    });
});

// Clear form when modal is hidden
$('#editPricingModal').on('hidden.bs.modal', function() {
    $('#editPricingForm')[0].reset();
    $('#editErrorAlert').hide();
});

// Function to manually close modal
function closeModal() {
    $('#editPricingModal').modal('hide');
    $('#editPricingForm')[0].reset();
    $('#editErrorAlert').hide();
}

// Also handle clicking outside modal or pressing ESC
$(document).ready(function() {
    $('#editPricingModal').on('click', function(e) {
        if (e.target === this) {
            closeModal();
        }
    });
    
    $(document).on('keydown', function(e) {
        if (e.key === 'Escape' && $('#editPricingModal').hasClass('show')) {
            closeModal();
        }
    });
});
</script>
