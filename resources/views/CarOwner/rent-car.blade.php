@extends('layouts.app')

@section('content')
    <h1>Rent a Car</h1>
    <link rel="stylesheet" href="{{ asset('assets/css/carowner/rent-car.css') }}">
    
    <style>
        /* Drag & Drop File Upload Area */
        .file-upload-container {
            border: 2px dashed #ccc;
            border-radius: 8px;
            padding: 20px;
            text-align: center;
            margin-bottom: 20px;
            transition: border 0.3s ease;
            background-color: #f8f9fa;
        }
        
        .file-upload-container.active {
            border-color: #0d6efd;
            background-color: #e8f0fe;
        }
        
        .file-upload-container h3 {
            margin-bottom: 15px;
        }
        
        .file-upload-input {
            display: none;
        }
        
        .browse-btn {
            background-color: #0d6efd;
            color: white;
            padding: 8px 16px;
            border-radius: 4px;
            cursor: pointer;
            display: inline-block;
            margin: 10px 0;
        }
        
        /* Image Preview */
        .image-preview-container {
            display: flex;
            flex-wrap: wrap;
            gap: 10px;
            margin-top: 15px;
        }
        
        .image-preview {
            position: relative;
            width: 150px;
            height: 100px;
            border-radius: 4px;
            overflow: hidden;
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
        }
        
        .image-preview img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }
        
        .image-preview .remove-btn {
            position: absolute;
            top: 5px;
            right: 5px;
            background: rgba(0,0,0,0.5);
            color: white;
            border: none;
            border-radius: 50%;
            width: 20px;
            height: 20px;
            font-size: 12px;
            cursor: pointer;
            display: flex;
            align-items: center;
            justify-content: center;
        }
    </style>
    
    <form action="{{ route('carowner.storeRentCar') }}" method="POST" enctype="multipart/form-data" id="carForm">
        @csrf

        @if(session('success'))
            <p style="color: green;">{{ session('success') }}</p>
        @endif

        <label for="maker">Maker:</label>
        <input type="text" name="maker" id="maker" value="{{ old('maker') }}">
        @error('maker')
            <span style="color: red;">{{ $message }}</span>
        @enderror
        <br>

        <label for="model">Model:</label>
        <input type="text" name="model" id="model" value="{{ old('model') }}">
        @error('model')
            <span style="color: red;">{{ $message }}</span>
        @enderror
        <br>

        <label for="vehicle_type">Vehicle Type:</label>
        <select name="vehicle_type" id="vehicle_type">
            <option value="">Select a vehicle type</option>
            <option value="Sedan" {{ old('vehicle_type') == 'Sedan' ? 'selected' : '' }}>Sedan</option>
            <option value="SUV" {{ old('vehicle_type') == 'SUV' ? 'selected' : '' }}>SUV</option>
            <option value="Hatchback" {{ old('vehicle_type') == 'Hatchback' ? 'selected' : '' }}>Hatchback</option>
            <option value="Pickup" {{ old('vehicle_type') == 'Pickup' ? 'selected' : '' }}>Pickup</option>
        </select>
        @error('vehicle_type')
            <span style="color: red;">{{ $message }}</span>
        @enderror
        <br>

        <label for="car_condition">Condition:</label>
        <select name="car_condition" id="car_condition">
            <option value="">Select condition</option>
            <option value="New" {{ old('car_condition') == 'New' ? 'selected' : '' }}>New</option>
            <option value="Used" {{ old('car_condition') == 'Used' ? 'selected' : '' }}>Used</option>
        </select>
        @error('car_condition')
            <span style="color: red;">{{ $message }}</span>
        @enderror
        <br>

        <label for="mileage">Mileage (in km):</label>
        <input type="number" name="mileage" id="mileage" value="{{ old('mileage') }}">
        @error('mileage')
            <span style="color: red;">{{ $message }}</span>
        @enderror
        <br>

        <label for="price">Price per Day:</label>
        <input type="number" name="price" id="price" value="{{ old('price') }}">
        @error('price')
            <span style="color: red;">{{ $message }}</span>
        @enderror
        <br>

        <label for="registration_no">Registration Number:</label>
        <input type="text" name="registration_no" id="registration_no" value="{{ old('registration_no') }}">
        @error('registration_no')
            <span style="color: red;">{{ $message }}</span>
        @enderror
        <br>

        <label for="status">Status:</label>
        <select name="status" id="status">
            <option value="">Select status</option>
            <option value="available" {{ old('status') == 'available' ? 'selected' : '' }}>Available</option>
            <option value="rented" {{ old('status') == 'rented' ? 'selected' : '' }}>Rented</option>
            <option value="maintenance" {{ old('status') == 'maintenance' ? 'selected' : '' }}>Under Maintenance</option>
        </select>
        @error('status')
            <span style="color: red;">{{ $message }}</span>
        @enderror
        <br>

        {{-- NEW FEATURES START HERE --}}

        <h3>Car Features</h3>

        <label for="number_of_doors">Number of Doors:</label>
        <input type="number" name="number_of_doors" id="number_of_doors" value="{{ old('number_of_doors') }}">
        @error('number_of_doors')
            <span style="color: red;">{{ $message }}</span>
        @enderror
        <br>

        <label for="number_of_seats">Number of Seats:</label>
        <input type="number" name="number_of_seats" id="number_of_seats" value="{{ old('number_of_seats') }}">
        @error('number_of_seats')
            <span style="color: red;">{{ $message }}</span>
        @enderror
        <br>

        <label for="transmission_type">Transmission Type:</label>
        <select name="transmission_type" id="transmission_type">
            <option value="">Select transmission</option>
            <option value="Automatic" {{ old('transmission_type') == 'Automatic' ? 'selected' : '' }}>Automatic</option>
            <option value="Manual" {{ old('transmission_type') == 'Manual' ? 'selected' : '' }}>Manual</option>
        </select>
        @error('transmission_type')
            <span style="color: red;">{{ $message }}</span>
        @enderror
        <br>

        <label for="large_bags_capacity">Large Bags Capacity:</label>
        <input type="number" name="large_bags_capacity" id="large_bags_capacity" value="{{ old('large_bags_capacity') }}">
        @error('large_bags_capacity')
            <span style="color: red;">{{ $message }}</span>
        @enderror
        <br>

        <label for="small_bags_capacity">Small Bags Capacity:</label>
        <input type="number" name="small_bags_capacity" id="small_bags_capacity" value="{{ old('small_bags_capacity') }}">
        @error('small_bags_capacity')
            <span style="color: red;">{{ $message }}</span>
        @enderror
        <br>

         <!-- Fuel Type Field Added -->
         <label for="fuel_type">Fuel Type:</label>
         <select name="fuel_type" id="fuel_type">
             <option value="">Select fuel type</option>
             <option value="Petrol" {{ old('fuel_type') == 'Petrol' ? 'selected' : '' }}>Petrol</option>
             <option value="Diesel" {{ old('fuel_type') == 'Diesel' ? 'selected' : '' }}>Diesel</option>
             <option value="Electric" {{ old('fuel_type') == 'Electric' ? 'selected' : '' }}>Electric</option>
             <option value="Hybrid" {{ old('fuel_type') == 'Hybrid' ? 'selected' : '' }}>Hybrid</option>
         </select>
         @error('fuel_type')
             <span style="color: red;">{{ $message }}</span>
         @enderror
         <br>
         
        <!-- Air Conditioning -->
        <label for="air_conditioning">Air Conditioning:</label><br>
        <input type="radio" name="air_conditioning" value="Yes" 
            {{ old('air_conditioning') == 'Yes' ? 'checked' : '' }}> Yes
        <input type="radio" name="air_conditioning" value="No" 
            {{ old('air_conditioning') == 'No' ? 'checked' : '' }}> No
        @error('air_conditioning')
            <span style="color: red;">{{ $message }}</span>
        @enderror
        <br><br>

        <!-- Backup Camera -->
        <label for="backup_camera">Backup Camera:</label><br>
        <input type="radio" name="backup_camera" value="Yes" 
            {{ old('backup_camera') == 'Yes' ? 'checked' : '' }}> Yes
        <input type="radio" name="backup_camera" value="No" 
            {{ old('backup_camera') == 'No' ? 'checked' : '' }}> No
        @error('backup_camera')
            <span style="color: red;">{{ $message }}</span>
        @enderror
        <br><br>

        <!-- Bluetooth -->
        <label for="bluetooth">Bluetooth:</label><br>
        <input type="radio" name="bluetooth" value="Yes" 
            {{ old('bluetooth') == 'Yes' ? 'checked' : '' }}> Yes
        <input type="radio" name="bluetooth" value="No" 
            {{ old('bluetooth') == 'No' ? 'checked' : '' }}> No
        @error('bluetooth')
            <span style="color: red;">{{ $message }}</span>
        @enderror
        <br><br>

        {{-- NEW FEATURES END HERE --}}

        <label for="description">Description:</label>
        <textarea name="description" id="description">{{ old('description') }}</textarea>
        @error('description')
            <span style="color: red;">{{ $message }}</span>
        @enderror
        <br>

        <!-- Drag & Drop Image Upload -->
        <div class="file-upload-section">
            <label>Car Images:</label>
            <div class="file-upload-container" id="dropZone">
                <h3>Drop car images here</h3>
                <p>or</p>
                <label for="car_images" class="browse-btn">Browse Files</label>
                <input type="file" name="car_images[]" id="car_images" class="file-upload-input" multiple accept="image/*">
                <p class="small-text">Supported formats: JPEG, PNG, JPG, WEBP, GIF (max 2MB each)</p>
                
                <!-- Hidden input to store selected files -->
                <div id="selectedFiles" class="image-preview-container">
                    <!-- Image previews will be inserted here -->
                </div>
            </div>
            
            @error('car_images')
                <span style="color: red;">{{ $message }}</span>
            @enderror
            @if($errors->has('car_images.*'))
                @foreach($errors->get('car_images.*') as $messages)
                    @foreach($messages as $message)
                        <span style="color: red;">{{ $message }}</span><br>
                    @endforeach
                @endforeach
            @endif
        </div>

        <button type="submit">Submit</button>
    </form>

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
            form.addEventListener('submit', function(e) {
                // The file input is already updated, so just let the form submit
            });
        });
    </script>
@endsection