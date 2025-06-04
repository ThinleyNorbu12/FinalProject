@extends('layouts.admin')

@section('title', 'Add Car Pricing')

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
                        
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="car_id">Select Car <span class="text-danger">*</span></label>
                                    <select name="car_id" id="car_id" class="form-control @error('car_id') is-invalid @enderror" required>
                                        <option value="">Choose a car...</option>
                                        @foreach($cars as $car)
                                            <option value="{{ $car->id }}" {{ old('car_id') == $car->id ? 'selected' : '' }}>
                                                {{ $car->maker ?? 'N/A' }} {{ $car->model ?? 'N/A' }} - {{ $car->registration_no ?? 'N/A' }}
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

                        <div class="form-group">
                            <button type="submit" class="btn btn-primary">
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
                        $pricingRecords = \App\Models\CarBooking::with('car')->latest()->get();
                    @endphp
                    
                    @if($pricingRecords->count() > 0)
                        <div class="table-responsive">
                            <table class="table table-bordered table-striped">
                                <thead>
                                    <tr>
                                        <th>Car</th>
                                        <th>Rate/Day</th>
                                        <th>Mileage Limit</th>
                                        <th>Price/KM</th>
                                        <th>Current Mileage</th>
                                        <th>Updated</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($pricingRecords as $record)
                                        <tr>
                                            <td>{{ $record->car->maker ?? 'N/A' }} {{ $record->car->model ?? '' }}</td>
                                            <td>Nu. {{ number_format($record->rate_per_day, 2) }}</td>
                                            <td>{{ number_format($record->mileage_limit, 1) }} km/day</td>
                                            <td>Nu. {{ number_format($record->price_per_km, 2) }}</td>
                                            <td>{{ number_format($record->current_mileage, 1) }} km</td>
                                            <td>{{ $record->updated_at->format('M d, Y H:i') }}</td>
                                            <td>
                                                <button class="btn btn-sm btn-warning" onclick="editPricing({{ $record->id }})">
                                                    <i class="fas fa-edit"></i> Edit
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
</style>

<script>
function editPricing(id) {
    // You can implement edit functionality here
    alert('Edit functionality - Pricing ID: ' + id);
}
</script>
@endsection