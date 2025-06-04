@extends('layouts.admin')

@section('title', 'Record New Mileage')

@section('content')
<div class="container-fluid">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">
                    <div class="d-flex justify-content-between align-items-center">
                        <h4 class="card-title mb-0">
                            <i class="fas fa-plus mr-2"></i>
                            Record New Mileage
                        </h4>
                        <a href="{{ route('car-admin.record-mileage') }}" class="btn btn-outline-secondary">
                            <i class="fas fa-arrow-left mr-1"></i>
                            Back to List
                        </a>
                    </div>
                </div>

                <div class="card-body">
                    <form action="{{ route('car-admin.record-mileage.store') }}" method="POST">
                        @csrf
                        
                        <div class="row">
                            <!-- Car Selection -->
                            <div class="col-md-12 mb-3">
                                <label for="car_id" class="form-label">
                                    <i class="fas fa-car mr-1"></i>
                                    Select Car <span class="text-danger">*</span>
                                </label>
                                <select name="car_id" id="car_id" class="form-control @error('car_id') is-invalid @enderror" required>
                                    <option value="">Choose a car...</option>
                                    @foreach($cars as $car)
                                        <option value="{{ $car->id }}" 
                                                data-current-mileage="{{ $car->mileage }}"
                                                {{ old('car_id') == $car->id ? 'selected' : '' }}>
                                            {{ $car->registration_no }} - {{ $car->maker }} {{ $car->model }}
                                            @if($car->mileage)
                                                (Current: {{ number_format($car->mileage) }} km)
                                            @endif
                                        </option>
                                    @endforeach
                                </select>
                                @error('car_id')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Mileage Type -->
                            <div class="col-md-6 mb-3">
                                <label for="mileage_type" class="form-label">
                                    <i class="fas fa-tags mr-1"></i>
                                    Mileage Type <span class="text-danger">*</span>
                                </label>
                                <select name="mileage_type" id="mileage_type" class="form-control @error('mileage_type') is-invalid @enderror" required>
                                    <option value="">Select type...</option>
                                    <option value="current" {{ old('mileage_type') == 'current' ? 'selected' : '' }}>
                                        Current Mileage
                                    </option>
                                    <option value="start" {{ old('mileage_type') == 'start' ? 'selected' : '' }}>
                                        Start Mileage
                                    </option>
                                    <option value="end" {{ old('mileage_type') == 'end' ? 'selected' : '' }}>
                                        End Mileage
                                    </option>
                                </select>
                                @error('mileage_type')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Mileage Value -->
                            <div class="col-md-6 mb-3">
                                <label for="mileage_value" class="form-label">
                                    <i class="fas fa-tachometer-alt mr-1"></i>
                                    Mileage Value (km) <span class="text-danger">*</span>
                                </label>
                                <input type="number" name="mileage_value" id="mileage_value" 
                                       class="form-control @error('mileage_value') is-invalid @enderror" 
                                       value="{{ old('mileage_value') }}" 
                                       min="0" step="0.1" required>
                                @error('mileage_value')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Recording Date -->
                            <div class="col-md-6 mb-3">
                                <label for="recording_date" class="form-label">
                                    <i class="fas fa-calendar mr-1"></i>
                                    Recording Date <span class="text-danger">*</span>
                                </label>
                                <input type="date" name="recording_date" id="recording_date" 
                                       class="form-control @error('recording_date') is-invalid @enderror" 
                                       value="{{ old('recording_date', date('Y-m-d')) }}" 
                                       max="{{ date('Y-m-d') }}" required>
                                @error('recording_date')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Notes -->
                            <div class="col-md-12 mb-3">
                                <label for="notes" class="form-label">
                                    <i class="fas fa-sticky-note mr-1"></i>
                                    Notes (Optional)
                                </label>
                                <textarea name="notes" id="notes" rows="3" 
                                          class="form-control @error('notes') is-invalid @enderror" 
                                          placeholder="Add any additional notes about this mileage recording...">{{ old('notes') }}</textarea>
                                @error('notes')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                                <small class="form-text text-muted">Maximum 500 characters</small>
                            </div>
                        </div>

                        <!-- Current Car Info Display -->
                        <div id="car-info" class="alert alert-info" style="display: none;">
                            <h6><i class="fas fa-info-circle mr-2"></i>Current Car Information</h6>
                            <div id="car-details"></div>
                        </div>

                        <!-- Mileage Type Information -->
                        <div class="alert alert-light border">
                            <h6><i class="fas fa-lightbulb mr-2"></i>Mileage Types Explanation</h6>
                            <div class="row">
                                <div class="col-md-4">
                                    <strong>Current Mileage:</strong>
                                    <p class="small text-muted mb-0">The current odometer reading</p>
                                </div>
                                <div class="col-md-4">
                                    <strong>Start Mileage:</strong>
                                    <p class="small text-muted mb-0">Initial mileage when service started</p>
                                </div>
                                <div class="col-md-4">
                                    <strong>End Mileage:</strong>
                                    <p class="small text-muted mb-0">Final mileage when service ended</p>
                                </div>
                            </div>
                        </div>

                        <!-- Submit Buttons -->
                        <div class="d-flex justify-content-end">
                            <a href="{{ route('car-admin.record-mileage') }}" class="btn btn-secondary mr-2">
                                <i class="fas fa-times mr-1"></i>
                                Cancel
                            </a>
                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-save mr-1"></i>
                                Record Mileage
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    const carSelect = document.getElementById('car_id');
    const carInfo = document.getElementById('car-info');
    const carDetails = document.getElementById('car-details');
    const mileageTypeSelect = document.getElementById('mileage_type');
    const mileageValueInput = document.getElementById('mileage_value');

    // Show car information when a car is selected
    carSelect.addEventListener('change', function() {
        const selectedOption = this.options[this.selectedIndex];
        
        if (this.value) {
            const currentMileage = selectedOption.getAttribute('data-current-mileage');
            const carText = selectedOption.text;
            
            let infoHtml = `<strong>Selected Car:</strong> ${carText}<br>`;
            
            if (currentMileage && currentMileage !== 'null') {
                infoHtml += `<strong>Current Recorded Mileage:</strong> ${Number(currentMileage).toLocaleString()} km`;
            } else {
                infoHtml += `<strong>Current Recorded Mileage:</strong> <span class="text-warning">Not recorded yet</span>`;
            }
            
            carDetails.innerHTML = infoHtml;
            carInfo.style.display = 'block';
        } else {
            carInfo.style.display = 'none';
        }
    });

    // Trigger the change event if a car is already selected (for edit mode)
    if (carSelect.value) {
        carSelect.dispatchEvent(new Event('change'));
    }

    // Add validation hints based on mileage type
    mileageTypeSelect.addEventListener('change', function() {
        const selectedCar = carSelect.options[carSelect.selectedIndex];
        const currentMileage = selectedCar ? selectedCar.getAttribute('data-current-mileage') : null;
        
        if (this.value && currentMileage && currentMileage !== 'null') {
            const current = parseFloat(currentMileage);
            
            switch(this.value) {
                case 'current':
                    mileageValueInput.setAttribute('min', current > 0 ? current : 0);
                    break;
                case 'start':
                    mileageValueInput.setAttribute('min', 0);
                    mileageValueInput.setAttribute('max', current);
                    break;
                case 'end':
                    mileageValueInput.setAttribute('min', current);
                    break;
            }
        } else {
            mileageValueInput.setAttribute('min', 0);
            mileageValueInput.removeAttribute('max');
        }
    });

    // Character counter for notes
    const notesTextarea = document.getElementById('notes');
    const maxLength = 500;
    
    // Create character counter element
    const counterElement = document.createElement('small');
    counterElement.className = 'form-text text-muted';
    counterElement.innerHTML = `<span id="char-count">0</span>/${maxLength} characters`;
    notesTextarea.parentNode.appendChild(counterElement);
    
    const charCount = document.getElementById('char-count');
    
    notesTextarea.addEventListener('input', function() {
        const remaining = this.value.length;
        charCount.textContent = remaining;
        
        if (remaining > maxLength * 0.9) {
            charCount.className = 'text-warning';
        } else if (remaining > maxLength * 0.95) {
            charCount.className = 'text-danger';
        } else {
            charCount.className = '';
        }
    });
});
</script>
@endpush