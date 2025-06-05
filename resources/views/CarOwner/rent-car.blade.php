@extends('layouts.carowner')

@section('title', 'Rent a Car')
@section('breadcrumbs')
    <li class="breadcrumb-item active">Rent a Car</li>
@endsection
@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title mb-0">
                        <i class="fas fa-car me-2"></i>
                        Add New Car for Rent
                    </h4>
                </div>
                <div class="card-body">
        

                    <form action="{{ route('carowner.storeRentCar') }}" method="POST" enctype="multipart/form-data" id="carForm">
                        @csrf

                        <!-- Basic Car Information -->
                        <div class="row mb-4">
                            <div class="col-12">
                                <h5 class="section-title">
                                    <i class="fas fa-info-circle me-2"></i>
                                    Basic Information
                                </h5>
                            </div>
                        </div>

                        <div class="row g-3 mb-4">
                            <div class="col-md-6">
                                <label for="maker" class="form-label">Car Maker <span class="text-danger">*</span></label>
                                <input type="text" class="form-control @error('maker') is-invalid @enderror" 
                                       name="maker" id="maker" value="{{ old('maker') }}" placeholder="e.g., Toyota, Honda">
                                @error('maker')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-6">
                                <label for="model" class="form-label">Model <span class="text-danger">*</span></label>
                                <input type="text" class="form-control @error('model') is-invalid @enderror" 
                                       name="model" id="model" value="{{ old('model') }}" placeholder="e.g., Camry, Civic">
                                @error('model')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-6">
                                <label for="vehicle_type" class="form-label">Vehicle Type <span class="text-danger">*</span></label>
                                <select class="form-select @error('vehicle_type') is-invalid @enderror" name="vehicle_type" id="vehicle_type">
                                    <option value="">Select a vehicle type</option>
                                    <option value="Sedan" {{ old('vehicle_type') == 'Sedan' ? 'selected' : '' }}>Sedan</option>
                                    <option value="SUV" {{ old('vehicle_type') == 'SUV' ? 'selected' : '' }}>SUV</option>
                                    <option value="Hatchback" {{ old('vehicle_type') == 'Hatchback' ? 'selected' : '' }}>Hatchback</option>
                                    <option value="Pickup" {{ old('vehicle_type') == 'Pickup' ? 'selected' : '' }}>Pickup</option>
                                </select>
                                @error('vehicle_type')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-6">
                                <label for="car_condition" class="form-label">Condition <span class="text-danger">*</span></label>
                                <select class="form-select @error('car_condition') is-invalid @enderror" name="car_condition" id="car_condition">
                                    <option value="">Select condition</option>
                                    <option value="New" {{ old('car_condition') == 'New' ? 'selected' : '' }}>New</option>
                                    <option value="Used" {{ old('car_condition') == 'Used' ? 'selected' : '' }}>Used</option>
                                </select>
                                @error('car_condition')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            {{-- <div class="col-md-6">
                                <label for="mileage" class="form-label">Mileage (km)</label>
                                <input type="number" class="form-control @error('mileage') is-invalid @enderror" 
                                       name="mileage" id="mileage" value="{{ old('mileage') }}" placeholder="0">
                                @error('mileage')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-6">
                                <label for="price" class="form-label">Price per Day (BTN) <span class="text-danger">*</span></label>
                                <input type="number" class="form-control @error('price') is-invalid @enderror" 
                                       name="price" id="price" value="{{ old('price') }}" placeholder="0.00" step="0.01">
                                @error('price')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div> --}}

                            <div class="col-md-6">
                                <label for="registration_no" class="form-label">Registration Number <span class="text-danger">*</span></label>
                                <input type="text" class="form-control @error('registration_no') is-invalid @enderror" 
                                       name="registration_no" id="registration_no" value="{{ old('registration_no') }}" 
                                       placeholder="e.g., BP-1-A0000">
                                @error('registration_no')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-6">
                                <label for="status" class="form-label">Status <span class="text-danger">*</span></label>
                                <select class="form-select @error('status') is-invalid @enderror" name="status" id="status">
                                    <option value="">Select status</option>
                                    <option value="available" {{ old('status') == 'available' ? 'selected' : '' }}>Available</option>
                                    <option value="rented" {{ old('status') == 'rented' ? 'selected' : '' }}>Rented</option>
                                    <option value="maintenance" {{ old('status') == 'maintenance' ? 'selected' : '' }}>Under Maintenance</option>
                                </select>
                                @error('status')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <!-- Car Features Section -->
                        <div class="row mb-4">
                            <div class="col-12">
                                <h5 class="section-title">
                                    <i class="fas fa-cogs me-2"></i>
                                    Car Features & Specifications
                                </h5>
                            </div>
                        </div>

                        <div class="row g-3 mb-4">
                            <div class="col-md-6">
                                <label for="number_of_doors" class="form-label">Number of Doors</label>
                                <input type="number" class="form-control @error('number_of_doors') is-invalid @enderror" 
                                       name="number_of_doors" id="number_of_doors" value="{{ old('number_of_doors') }}" 
                                       min="2" max="6" placeholder="4">
                                @error('number_of_doors')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-6">
                                <label for="number_of_seats" class="form-label">Number of Seats</label>
                                <input type="number" class="form-control @error('number_of_seats') is-invalid @enderror" 
                                       name="number_of_seats" id="number_of_seats" value="{{ old('number_of_seats') }}" 
                                       min="2" max="12" placeholder="5">
                                @error('number_of_seats')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-6">
                                <label for="transmission_type" class="form-label">Transmission Type</label>
                                <select class="form-select @error('transmission_type') is-invalid @enderror" name="transmission_type" id="transmission_type">
                                    <option value="">Select transmission</option>
                                    <option value="Automatic" {{ old('transmission_type') == 'Automatic' ? 'selected' : '' }}>Automatic</option>
                                    <option value="Manual" {{ old('transmission_type') == 'Manual' ? 'selected' : '' }}>Manual</option>
                                </select>
                                @error('transmission_type')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-6">
                                <label for="fuel_type" class="form-label">Fuel Type</label>
                                <select class="form-select @error('fuel_type') is-invalid @enderror" name="fuel_type" id="fuel_type">
                                    <option value="">Select fuel type</option>
                                    <option value="Petrol" {{ old('fuel_type') == 'Petrol' ? 'selected' : '' }}>Petrol</option>
                                    <option value="Diesel" {{ old('fuel_type') == 'Diesel' ? 'selected' : '' }}>Diesel</option>
                                    <option value="Electric" {{ old('fuel_type') == 'Electric' ? 'selected' : '' }}>Electric</option>
                                    <option value="Hybrid" {{ old('fuel_type') == 'Hybrid' ? 'selected' : '' }}>Hybrid</option>
                                </select>
                                @error('fuel_type')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-6">
                                <label for="large_bags_capacity" class="form-label">Large Bags Capacity</label>
                                <input type="number" class="form-control @error('large_bags_capacity') is-invalid @enderror" 
                                       name="large_bags_capacity" id="large_bags_capacity" value="{{ old('large_bags_capacity') }}" 
                                       min="0" max="10" placeholder="2">
                                @error('large_bags_capacity')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-6">
                                <label for="small_bags_capacity" class="form-label">Small Bags Capacity</label>
                                <input type="number" class="form-control @error('small_bags_capacity') is-invalid @enderror" 
                                       name="small_bags_capacity" id="small_bags_capacity" value="{{ old('small_bags_capacity') }}" 
                                       min="0" max="10" placeholder="3">
                                @error('small_bags_capacity')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <!-- Features Checkboxes -->
                        <div class="row mb-4">
                            <div class="col-12">
                                <h6 class="mb-3">Additional Features</h6>
                            </div>
                            
                            <div class="col-md-4">
                                <div class="form-check">
                                    <label class="form-check-label fw-bold">Air Conditioning:</label>
                                </div>
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="radio" name="air_conditioning" 
                                           id="ac_yes" value="Yes" {{ old('air_conditioning') == 'Yes' ? 'checked' : '' }}>
                                    <label class="form-check-label" for="ac_yes">Yes</label>
                                </div>
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="radio" name="air_conditioning" 
                                           id="ac_no" value="No" {{ old('air_conditioning') == 'No' ? 'checked' : '' }}>
                                    <label class="form-check-label" for="ac_no">No</label>
                                </div>
                                @error('air_conditioning')
                                    <div class="text-danger small">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-4">
                                <div class="form-check">
                                    <label class="form-check-label fw-bold">Rear-View Camera:</label>
                                </div>
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="radio" name="backup_camera" 
                                           id="camera_yes" value="Yes" {{ old('backup_camera') == 'Yes' ? 'checked' : '' }}>
                                    <label class="form-check-label" for="camera_yes">Yes</label>
                                </div>
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="radio" name="backup_camera" 
                                           id="camera_no" value="No" {{ old('backup_camera') == 'No' ? 'checked' : '' }}>
                                    <label class="form-check-label" for="camera_no">No</label>
                                </div>
                                @error('backup_camera')
                                    <div class="text-danger small">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-4">
                                <div class="form-check">
                                    <label class="form-check-label fw-bold">Bluetooth:</label>
                                </div>
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="radio" name="bluetooth" 
                                           id="bt_yes" value="Yes" {{ old('bluetooth') == 'Yes' ? 'checked' : '' }}>
                                    <label class="form-check-label" for="bt_yes">Yes</label>
                                </div>
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="radio" name="bluetooth" 
                                           id="bt_no" value="No" {{ old('bluetooth') == 'No' ? 'checked' : '' }}>
                                    <label class="form-check-label" for="bt_no">No</label>
                                </div>
                                @error('bluetooth')
                                    <div class="text-danger small">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <!-- Description -->
                        <div class="row mb-4">
                            <div class="col-12">
                                <label for="description" class="form-label">Description</label>
                                <textarea class="form-control @error('description') is-invalid @enderror" 
                                          name="description" id="description" rows="4" 
                                          placeholder="Describe your car's condition, special features, or any additional information...">{{ old('description') }}</textarea>
                                @error('description')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <!-- Image Upload Section -->
                        <div class="row mb-4">
                            <div class="col-12">
                                <h5 class="section-title">
                                    <i class="fas fa-camera me-2"></i>
                                    Car Images
                                </h5>
                            </div>
                        </div>

                        <div class="file-upload-section">
                            <div class="file-upload-container" id="dropZone">
                                <div class="text-center">
                                    <i class="fas fa-cloud-upload-alt fa-3x text-muted mb-3"></i>
                                    <h5>Drop car images here</h5>
                                    <p class="text-muted">or</p>
                                    <label for="car_images" class="btn btn-primary">
                                        <i class="fas fa-folder-open me-2"></i>
                                        Browse Files
                                    </label>
                                    <input type="file" name="car_images[]" id="car_images" class="d-none" multiple accept="image/*">
                                    <p class="small text-muted mt-2">
                                        Supported formats: JPEG, PNG, JPG, WEBP, GIF (max 2MB each)
                                    </p>
                                </div>
                                
                                <div id="selectedFiles" class="image-preview-container mt-3">
                                    <!-- Image previews will be inserted here -->
                                </div>
                            </div>
                            
                            @error('car_images')
                                <div class="text-danger mt-2">{{ $message }}</div>
                            @enderror
                            @if($errors->has('car_images.*'))
                                @foreach($errors->get('car_images.*') as $messages)
                                    @foreach($messages as $message)
                                        <div class="text-danger mt-1">{{ $message }}</div>
                                    @endforeach
                                @endforeach
                            @endif
                        </div>

                        <!-- Submit Button -->
                        <div class="row">
                            <div class="col-12">
                                <div class="d-flex justify-content-end gap-3">
                                    <button type="button" class="btn btn-secondary" onclick="history.back()">
                                        <i class="fas fa-arrow-left me-2"></i>
                                        Cancel
                                    </button>
                                    <button type="submit" class="btn btn-primary">
                                        <i class="fas fa-plus me-2"></i>
                                        Add Car for Rent
                                    </button>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('styles')
<style>
    .section-title {
        color: #495057;
        border-bottom: 2px solid #e9ecef;
        padding-bottom: 8px;
        margin-bottom: 20px;
    }

    .file-upload-container {
        border: 2px dashed #dee2e6;
        border-radius: 8px;
        padding: 40px 20px;
        text-align: center;
        margin-bottom: 20px;
        transition: all 0.3s ease;
        background-color: #f8f9fa;
    }
    
    .file-upload-container.active {
        border-color: #0d6efd;
        background-color: #e7f3ff;
        transform: scale(1.02);
    }
    
    .file-upload-container:hover {
        border-color: #0d6efd;
        background-color: #f0f8ff;
    }
    
    .image-preview-container {
        display: flex;
        flex-wrap: wrap;
        gap: 15px;
        justify-content: center;
    }
    
    .image-preview {
        position: relative;
        width: 150px;
        height: 120px;
        border-radius: 8px;
        overflow: hidden;
        box-shadow: 0 4px 8px rgba(0,0,0,0.1);
        transition: transform 0.2s ease;
    }
    
    .image-preview:hover {
        transform: scale(1.05);
    }
    
    .image-preview img {
        width: 100%;
        height: 100%;
        object-fit: cover;
    }
    
    .image-preview .remove-btn {
        position: absolute;
        top: 8px;
        right: 8px;
        background: rgba(220, 53, 69, 0.9);
        color: white;
        border: none;
        border-radius: 50%;
        width: 28px;
        height: 28px;
        font-size: 14px;
        cursor: pointer;
        display: flex;
        align-items: center;
        justify-content: center;
        transition: all 0.2s ease;
    }
    
    .image-preview .remove-btn:hover {
        background: rgba(220, 53, 69, 1);
        transform: scale(1.1);
    }

    .card {
        box-shadow: 0 0 20px rgba(0,0,0,0.1);
        border: none;
        border-radius: 12px;
    }

    .card-header {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        color: white;
        border-radius: 12px 12px 0 0 !important;
        padding: 20px;
    }

    .form-label {
        font-weight: 500;
        color: #495057;
        margin-bottom: 8px;
    }

    .form-control, .form-select {
        border-radius: 8px;
        border: 1px solid #dee2e6;
        padding: 12px 16px;
        transition: all 0.2s ease;
    }

    .form-control:focus, .form-select:focus {
        border-color: #0d6efd;
        box-shadow: 0 0 0 0.2rem rgba(13, 110, 253, 0.25);
    }

    .btn {
        border-radius: 8px;
        padding: 12px 24px;
        font-weight: 500;
        transition: all 0.2s ease;
    }

    .btn:hover {
        transform: translateY(-2px);
        box-shadow: 0 4px 12px rgba(0,0,0,0.15);
    }

    .form-check-input {
        margin-top: 0.25em;
    }

    .text-danger {
        font-size: 0.875em;
    }
</style>
@endpush

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    const dropZone = document.getElementById('dropZone');
    const fileInput = document.getElementById('car_images');
    const previewContainer = document.getElementById('selectedFiles');
    const form = document.getElementById('carForm');
    
    // Track selected files
    let selectedFiles = new DataTransfer();
    
    // Prevent default drag behaviors
    ['dragenter', 'dragover', 'dragleave', 'drop'].forEach(eventName => {
        dropZone.addEventListener(eventName, preventDefaults, false);
        document.body.addEventListener(eventName, preventDefaults, false);
    });
    
    // Highlight drop zone when dragging over it
    ['dragenter', 'dragover'].forEach(eventName => {
        dropZone.addEventListener(eventName, highlight, false);
    });
    
    ['dragleave', 'drop'].forEach(eventName => {
        dropZone.addEventListener(eventName, unhighlight, false);
    });
    
    // Handle dropped files
    dropZone.addEventListener('drop', handleDrop, false);
    
    // Handle files from file input
    fileInput.addEventListener('change', function(e) {
        handleFiles(this.files);
    });
    
    function preventDefaults(e) {
        e.preventDefault();
        e.stopPropagation();
    }
    
    function highlight() {
        dropZone.classList.add('active');
    }
    
    function unhighlight() {
        dropZone.classList.remove('active');
    }
    
    function handleDrop(e) {
        const dt = e.dataTransfer;
        const files = dt.files;
        handleFiles(files);
    }
    
    function handleFiles(files) {
        if (files.length > 0) {
            // Process each file
            Array.from(files).forEach(file => {
                if (file.type.startsWith('image/')) {
                    // Add to DataTransfer object
                    selectedFiles.items.add(file);
                    
                    // Create preview
                    createImagePreview(file);
                }
            });
            
            // Update file input with selected files
            updateFileInput();
        }
    }
    
    function createImagePreview(file) {
        const reader = new FileReader();
        
        reader.onload = function(e) {
            const preview = document.createElement('div');
            preview.className = 'image-preview';
            preview.dataset.name = file.name;
            
            const img = document.createElement('img');
            img.src = e.target.result;
            
            const removeBtn = document.createElement('button');
            removeBtn.className = 'remove-btn';
            removeBtn.innerHTML = '×';
            removeBtn.type = 'button';
            removeBtn.title = 'Remove image';
            removeBtn.addEventListener('click', function() {
                removeFile(file.name);
                preview.remove();
            });
            
            preview.appendChild(img);
            preview.appendChild(removeBtn);
            previewContainer.appendChild(preview);
        };
        
        reader.readAsDataURL(file);
    }
    
    function removeFile(fileName) {
        // Create a new DataTransfer object
        const newFiles = new DataTransfer();
        
        // Copy all files except the one to be removed
        for (let i = 0; i < selectedFiles.files.length; i++) {
            const file = selectedFiles.files[i];
            if (file.name !== fileName) {
                newFiles.items.add(file);
            }
        }
        
        // Replace old DataTransfer with new one
        selectedFiles = newFiles;
        updateFileInput();
    }
    
    function updateFileInput() {
        // Update the file input with current selections
        fileInput.files = selectedFiles.files;
    }
});
</script>
@endpush