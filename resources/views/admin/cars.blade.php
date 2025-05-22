@extends('layouts.app')

@section('content')
<link rel="stylesheet" href="{{ asset('assets/css/admin/cars.css') }}">

<div class="dashboard-content" id="dashboardContent">
    <!-- Breadcrumb Navigation -->
    <nav class="page-breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item">
                <i class="fas fa-home"></i>
                <a href="{{ route('admin.dashboard') }}">Home</a>
            </li>
            <li class="breadcrumb-item active">Cars Management</li>
        </ol>
    </nav>
    
    <div class="notification-container">
        @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <i class="fas fa-check-circle mr-2"></i>
            {{ session('success') }}
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
        @endif

        @if(session('error'))
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <i class="fas fa-exclamation-circle mr-2"></i>
            {{ session('error') }}
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
        @endif

        @if($errors->any())
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <i class="fas fa-exclamation-triangle mr-2"></i>
            <strong>Oops! There were some problems with your input.</strong>
            <ul class="mt-2 mb-0">
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
        @endif
    </div>

    <!-- Cars Management Content -->
    <div id="cars-management">
        <div class="section-header">
            <h1>Cars Management</h1>
            <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#addCarModal">
                <i class="fas fa-plus"></i> Add New Car
            </button>
        </div>

        <!-- Cars Listing Table -->
        <div class="data-table-container">
            <div class="table-header">
                <div class="table-filters">
                    <div class="filter-item">
                        <label for="status-filter">Status:</label>
                        <select id="status-filter" class="form-control">
                            <option value="">All Statuses</option>
                            <option value="available">Available</option>
                            <option value="booked">Booked</option>
                            <option value="maintenance">Maintenance</option>
                            <option value="inactive">Inactive</option>
                        </select>
                    </div>
                    <div class="filter-item">
                        <label for="brand-filter">Brand:</label>
                        <select id="brand-filter" class="form-control">
                            <option value="">All Brands</option>
                            @php
                                $makers = DB::table('admin_cars_tbl')
                                    ->select('maker')
                                    ->distinct()
                                    ->orderBy('maker')
                                    ->get();
                            @endphp
                            @foreach ($makers as $maker)
                                <option value="{{ $maker->maker }}">{{ $maker->maker }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="table-search">
                    <input type="text" id="car-search" class="form-control" placeholder="Search cars...">
                    <button class="search-btn"><i class="fas fa-search"></i></button>
                </div>
            </div>

            <table class="data-table">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Image</th>
                        <th>Car Name</th>
                        <th>Brand</th>
                        <th>Model</th>
                        <th>Registration No.</th>
                        <th>Daily Rate</th>
                        <th>Status</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @php
                        $cars = DB::table('admin_cars_tbl')
                            ->orderBy('id', 'desc')
                            ->paginate(10);
                    @endphp
                    
                    @if ($cars->count() > 0)
                        @foreach ($cars as $car)
                            @php
                                // Determine the status badge class
                                $statusClass = '';
                                switch (strtolower($car->status)) {
                                    case 'available':
                                        $statusClass = 'available';
                                        break;
                                    case 'booked':
                                        $statusClass = 'booked';
                                        break;
                                    case 'maintenance':
                                        $statusClass = 'maintenance';
                                        break;
                                    case 'inactive':
                                        $statusClass = 'inactive';
                                        break;
                                    default:
                                        $statusClass = '';
                                }
                                
                                // Car display name (combine maker and model)
                                $carName = $car->maker . ' ' . $car->model;
                                
                                // Image path handling with fallback
                                $imagePath = !empty($car->car_image) 
                                    ? asset('assets/images/cars/' . $car->car_image) 
                                    : asset('assets/images/cars/default-car.jpg');
                            @endphp
                            <tr>
                                <td>{{ $car->id }}</td>
                                <td><img src="{{ $imagePath }}" alt="{{ $carName }}" class="car-thumbnail"></td>
                                <td>{{ $carName }}</td>
                                <td>{{ $car->maker }}</td>
                                <td>{{ $car->model }}</td>
                                <td>{{ $car->registration_no }}</td>
                                <td>${{ $car->price }}/day</td>
                                <td><span class="status-badge {{ $statusClass }}">{{ $car->status }}</span></td>
                                <td class="actions">
                                    <a href="{{ route('cars.show', $car->id) }}" class="action-btn view" title="View Details">
                                        <i class="fas fa-eye"></i>
                                    </a>
                                    <a href="{{ route('cars.edit', $car->id) }}" class="action-btn edit" title="Edit Car">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                    <button class="action-btn delete" title="Delete Car" data-id="{{ $car->id }}" data-name="{{ $carName }}">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </td>
                            </tr>
                        @endforeach
                    @else
                        <tr>
                            <td colspan="9" class="text-center">No cars found</td>
                        </tr>
                    @endif
                </tbody>
            </table>

            <div class="pagination-container">
                <div class="showing-entries">
                    Showing {{ $cars->firstItem() ?? 0 }} to {{ $cars->lastItem() ?? 0 }} of {{ $cars->total() }} entries
                </div>
                <div class="pagination">
                    {{ $cars->links() }}
                </div>
            </div>
        </div>
    </div>

    <!-- Add Car Modal -->
    <div class="modal fade" id="addCarModal" tabindex="-1" role="dialog" aria-labelledby="addCarModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="addCarModalLabel">Add New Car</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form id="addCarForm" action="{{ route('cars.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="form-row">
                            <div class="form-group col-md-6">
                                <label for="maker">Maker <span class="required">*</span></label>
                                <input type="text" class="form-control" id="maker" name="maker" value="{{ old('maker') }}" required>
                                @error('maker')
                                    <span style="color: red;">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="form-group col-md-6">
                                <label for="model">Model <span class="required">*</span></label>
                                <input type="text" class="form-control" id="model" name="model" value="{{ old('model') }}" required>
                                @error('model')
                                    <span style="color: red;">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>
                        
                        <div class="form-row">
                            <div class="form-group col-md-6">
                                <label for="vehicle_type">Vehicle Type <span class="required">*</span></label>
                                <select id="vehicle_type" name="vehicle_type" class="form-control" required>
                                    <option value="">Select a vehicle type</option>
                                    <option value="Sedan" {{ old('vehicle_type') == 'Sedan' ? 'selected' : '' }}>Sedan</option>
                                    <option value="SUV" {{ old('vehicle_type') == 'SUV' ? 'selected' : '' }}>SUV</option>
                                    <option value="Hatchback" {{ old('vehicle_type') == 'Hatchback' ? 'selected' : '' }}>Hatchback</option>
                                    <option value="Pickup" {{ old('vehicle_type') == 'Pickup' ? 'selected' : '' }}>Pickup</option>
                                </select>
                                @error('vehicle_type')
                                    <span style="color: red;">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="form-group col-md-6">
                                <label for="car_condition">Condition <span class="required">*</span></label>
                                <select id="car_condition" name="car_condition" class="form-control" required>
                                    <option value="">Select condition</option>
                                    <option value="New" {{ old('car_condition') == 'New' ? 'selected' : '' }}>New</option>
                                    <option value="Used" {{ old('car_condition') == 'Used' ? 'selected' : '' }}>Used</option>
                                </select>
                                @error('car_condition')
                                    <span style="color: red;">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>
                        
                        <div class="form-row">
                            <div class="form-group col-md-6">
                                <label for="mileage">Mileage (in km) <span class="required">*</span></label>
                                <input type="number" class="form-control" id="mileage" name="mileage" value="{{ old('mileage') }}" required>
                                @error('mileage')
                                    <span style="color: red;">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="form-group col-md-6">
                                <label for="price">Price per Day <span class="required">*</span></label>
                                <input type="number" class="form-control" id="price" name="price" value="{{ old('price') }}" required>
                                @error('price')
                                    <span style="color: red;">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>
                        
                        <div class="form-row">
                            <div class="form-group col-md-6">
                                <label for="registration_no">Registration Number <span class="required">*</span></label>
                                <input type="text" class="form-control" id="registration_no" name="registration_no" value="{{ old('registration_no') }}" required>
                                @error('registration_no')
                                    <span style="color: red;">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="form-group col-md-6">
                                <label for="status">Status <span class="required">*</span></label>
                                <select id="status" name="status" class="form-control" required>
                                    <option value="">Select status</option>
                                    <option value="available" {{ old('status') == 'available' ? 'selected' : '' }}>Available</option>
                                    <option value="rented" {{ old('status') == 'rented' ? 'selected' : '' }}>Rented</option>
                                    <option value="maintenance" {{ old('status') == 'maintenance' ? 'selected' : '' }}>Under Maintenance</option>
                                </select>
                                @error('status')
                                    <span style="color: red;">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>
                        
                        <h4 class="mt-4 mb-3">Car Features</h4>
                        
                        <div class="form-row">
                            <div class="form-group col-md-6">
                                <label for="number_of_doors">Number of Doors <span class="required">*</span></label>
                                <input type="number" class="form-control" id="number_of_doors" name="number_of_doors" value="{{ old('number_of_doors') }}" required>
                                @error('number_of_doors')
                                    <span style="color: red;">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="form-group col-md-6">
                                <label for="number_of_seats">Number of Seats <span class="required">*</span></label>
                                <input type="number" class="form-control" id="number_of_seats" name="number_of_seats" value="{{ old('number_of_seats') }}" required>
                                @error('number_of_seats')
                                    <span style="color: red;">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>
                        
                        <div class="form-row">
                            <div class="form-group col-md-6">
                                <label for="transmission_type">Transmission Type <span class="required">*</span></label>
                                <select id="transmission_type" name="transmission_type" class="form-control" required>
                                    <option value="">Select transmission</option>
                                    <option value="Automatic" {{ old('transmission_type') == 'Automatic' ? 'selected' : '' }}>Automatic</option>
                                    <option value="Manual" {{ old('transmission_type') == 'Manual' ? 'selected' : '' }}>Manual</option>
                                </select>
                                @error('transmission_type')
                                    <span style="color: red;">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="form-group col-md-6">
                                <label for="fuel_type">Fuel Type <span class="required">*</span></label>
                                <select id="fuel_type" name="fuel_type" class="form-control" required>
                                    <option value="">Select fuel type</option>
                                    <option value="Petrol" {{ old('fuel_type') == 'Petrol' ? 'selected' : '' }}>Petrol</option>
                                    <option value="Diesel" {{ old('fuel_type') == 'Diesel' ? 'selected' : '' }}>Diesel</option>
                                    <option value="Electric" {{ old('fuel_type') == 'Electric' ? 'selected' : '' }}>Electric</option>
                                    <option value="Hybrid" {{ old('fuel_type') == 'Hybrid' ? 'selected' : '' }}>Hybrid</option>
                                </select>
                                @error('fuel_type')
                                    <span style="color: red;">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>
                        
                        <div class="form-row">
                            <div class="form-group col-md-6">
                                <label for="large_bags_capacity">Large Bags Capacity</label>
                                <input type="number" class="form-control" id="large_bags_capacity" name="large_bags_capacity" value="{{ old('large_bags_capacity') }}">
                                @error('large_bags_capacity')
                                    <span style="color: red;">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="form-group col-md-6">
                                <label for="small_bags_capacity">Small Bags Capacity</label>
                                <input type="number" class="form-control" id="small_bags_capacity" name="small_bags_capacity" value="{{ old('small_bags_capacity') }}">
                                @error('small_bags_capacity')
                                    <span style="color: red;">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>
                        
                        <div class="form-row">
                            <div class="form-group col-md-4">
                                <label>Air Conditioning</label>
                                <div class="d-flex">
                                    <div class="custom-control custom-radio mr-3">
                                        <input type="radio" id="air_conditioning_yes" name="air_conditioning" value="Yes" 
                                            class="custom-control-input" {{ old('air_conditioning') == 'Yes' ? 'checked' : '' }}>
                                        <label class="custom-control-label" for="air_conditioning_yes">Yes</label>
                                    </div>
                                    <div class="custom-control custom-radio">
                                        <input type="radio" id="air_conditioning_no" name="air_conditioning" value="No" 
                                            class="custom-control-input" {{ old('air_conditioning') == 'No' ? 'checked' : '' }}>
                                        <label class="custom-control-label" for="air_conditioning_no">No</label>
                                    </div>
                                </div>
                                @error('air_conditioning')
                                    <span style="color: red;">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="form-group col-md-4">
                                <label>Backup Camera</label>
                                <div class="d-flex">
                                    <div class="custom-control custom-radio mr-3">
                                        <input type="radio" id="backup_camera_yes" name="backup_camera" value="Yes" 
                                            class="custom-control-input" {{ old('backup_camera') == 'Yes' ? 'checked' : '' }}>
                                        <label class="custom-control-label" for="backup_camera_yes">Yes</label>
                                    </div>
                                    <div class="custom-control custom-radio">
                                        <input type="radio" id="backup_camera_no" name="backup_camera" value="No" 
                                            class="custom-control-input" {{ old('backup_camera') == 'No' ? 'checked' : '' }}>
                                        <label class="custom-control-label" for="backup_camera_no">No</label>
                                    </div>
                                </div>
                                @error('backup_camera')
                                    <span style="color: red;">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="form-group col-md-4">
                                <label>Bluetooth</label>
                                <div class="d-flex">
                                    <div class="custom-control custom-radio mr-3">
                                        <input type="radio" id="bluetooth_yes" name="bluetooth" value="Yes" 
                                            class="custom-control-input" {{ old('bluetooth') == 'Yes' ? 'checked' : '' }}>
                                        <label class="custom-control-label" for="bluetooth_yes">Yes</label>
                                    </div>
                                    <div class="custom-control custom-radio">
                                        <input type="radio" id="bluetooth_no" name="bluetooth" value="No" 
                                            class="custom-control-input" {{ old('bluetooth') == 'No' ? 'checked' : '' }}>
                                        <label class="custom-control-label" for="bluetooth_no">No</label>
                                    </div>
                                </div>
                                @error('bluetooth')
                                    <span style="color: red;">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>
                        
                        <div class="form-group">
                            <label for="description">Description</label>
                            <textarea class="form-control" id="description" name="description" rows="3">{{ old('description') }}</textarea>
                            @error('description')
                                <span style="color: red;">{{ $message }}</span>
                            @enderror
                        </div>
                        
                        <div class="form-group">
                            <label>Car Images</label>
                            <div class="file-upload-container" id="dropZone">
                                <h5 class="text-center mb-2">Drop car images here</h5>
                                <p class="text-center mb-2">or</p>
                                <div class="text-center mb-2">
                                    <label for="car_images" class="btn btn-outline-primary">Browse Files</label>
                                    <input type="file" name="car_images[]" id="car_images" class="d-none" multiple accept="image/*">
                                </div>
                                <p class="text-center small text-muted">Supported formats: JPEG, PNG, JPG, WEBP, GIF, AVIF (max 2MB each)</p>
                                
                                <div id="selectedFiles" class="image-preview-container">
                                    <!-- Image previews will be inserted here -->
                                </div>
                            </div>
                            
                            @error('car_images')
                                <span style="color: red;">{{ $message }}</span>
                            @enderror
                        </div>
                        
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                            <button type="submit" class="btn btn-primary">Add Car</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Delete Confirmation Modal -->
    <div class="modal fade" id="deleteConfirmModal" tabindex="-1" role="dialog" aria-labelledby="deleteConfirmModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="deleteConfirmModalLabel">Confirm Delete</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <p>Are you sure you want to delete <strong id="deleteCarName"></strong>?</p>
                    <p class="text-danger">This action cannot be undone.</p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                    <form id="deleteCarForm" method="POST" style="display: inline;">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger">Delete</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.0/dist/js/bootstrap.bundle.min.js"></script>
<script>
    $(document).ready(function() {
        // Show/hide "Other" brand input field
        $('#brand').change(function() {
            if ($(this).val() === 'other') {
                $('#other_brand_label, #other_brand').show();
                $('#other_brand').prop('required', true);
            } else {
                $('#other_brand_label, #other_brand').hide();
                $('#other_brand').prop('required', false);
            }
        });

        // Handle file input change for image preview
        $('#car_image').change(function(e) {
            $('#imagePreview').empty();
            const files = e.target.files;
            
            if (files.length > 0) {
                $('.custom-file-label').text(files.length + ' files selected');
                
                for (let i = 0; i < files.length; i++) {
                    const file = files[i];
                    const reader = new FileReader();
                    
                    reader.onload = function(e) {
                        const preview = `
                            <div class="image-preview-item">
                                <img src="${e.target.result}" alt="Preview">
                                <span class="image-preview-name">${file.name}</span>
                            </div>
                        `;
                        $('#imagePreview').append(preview);
                    }
                    
                    reader.readAsDataURL(file);
                }
            } else {
                $('.custom-file-label').text('Choose files');
            }
        });

        // Handle "View" button click
        $('.action-btn.view').click(function() {
            const carId = $(this).closest('tr').find('td:first').text();
            // Here you would fetch car details via AJAX and populate the view modal
            $('#viewCarModal').modal('show');
        });

        // Handle "Edit" button click
        $('.action-btn.edit').click(function() {
            const carId = $(this).data('id');
            $('#edit_car_id').val(carId);
            // Here you would fetch car details via AJAX and populate the edit form
        });

        // Handle "Delete" button click
        $('.action-btn.delete').click(function() {
            const carId = $(this).data('id');
            const carName = $(this).data('name');
            
            // Set the car name in the modal
            $('#deleteCarName').text(carName);
            
            // Set the form action URL with the car ID
            $('#deleteCarForm').attr('action', '/admin/cars?id=' + carId);
            
            // Show the modal
            $('#deleteConfirmModal').modal('show');
        });

        // Handle modal close buttons
        $('#deleteConfirmModal .close, #deleteConfirmModal [data-dismiss="modal"]').click(function() {
            $('#deleteConfirmModal').modal('hide');
        });

        // Handle modal backdrop click
        $('#deleteConfirmModal').on('click', function(e) {
            if (e.target === this) {
                $(this).modal('hide');
            }
        });

        // Handle ESC key press
        $(document).keyup(function(e) {
            if (e.keyCode === 27) { // ESC key
                $('#deleteConfirmModal').modal('hide');
            }
        });

        // Filter functionality
        $('#status-filter, #brand-filter').change(function() {
            filterTable();
        });

        // Search functionality
        $('#car-search').on('input', function() {
            filterTable();
        });

        function filterTable() {
            const statusFilter = $('#status-filter').val().toLowerCase();
            const brandFilter = $('#brand-filter').val().toLowerCase();
            const searchText = $('#car-search').val().toLowerCase();

            $('table tbody tr').each(function() {
                const statusText = $(this).find('td:nth-child(8) .status-badge').text().toLowerCase();
                const brandText = $(this).find('td:nth-child(4)').text().toLowerCase();
                const rowText = $(this).text().toLowerCase();

                const statusMatch = statusFilter === '' || statusText.includes(statusFilter);
                const brandMatch = brandFilter === '' || brandText === brandFilter;
                const searchMatch = searchText === '' || rowText.includes(searchText);

                if (statusMatch && brandMatch && searchMatch) {
                    $(this).show();
                } else {
                    $(this).hide();
                }
            });
        }

        // Auto dismiss alerts after 5 seconds
        setTimeout(function() {
            $('.alert').each(function() {
                $(this).addClass('fade-out');
                var alert = $(this);
                setTimeout(function() {
                    alert.alert('close');
                }, 500);
            });
        }, 5000);
    });

    // Drag and drop functionality (separate from jQuery ready)
    document.addEventListener('DOMContentLoaded', function() {
        const dropZone = document.getElementById('dropZone');
        const fileInput = document.getElementById('car_images');
        const previewContainer = document.getElementById('selectedFiles');
        const form = document.getElementById('addCarForm'); // Changed from 'carForm' to 'addCarForm'
        
        // Only proceed if elements exist
        if (!dropZone || !fileInput || !previewContainer) {
            return;
        }
        
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
                removeBtn.type = 'button'; // Prevent form submission
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
        
        // Submit the form with the updated file input
        if (form) {
            form.addEventListener('submit', function(e) {
                // The file input is already updated, so just let the form submit
            });
        }
    });
</script>
