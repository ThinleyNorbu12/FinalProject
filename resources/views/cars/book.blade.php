<!-- Link to the external CSS file -->
<link rel="stylesheet" href="{{ asset('assets/css/cars/book.css') }}">
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/pikaday/css/pikaday.css">
<script src="https://cdn.jsdelivr.net/npm/moment/moment.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/pikaday/pikaday.js"></script>


@extends('layouts.app')

@section('content')
<div class="container py-4">
    <div class="row">
        <div class="col-lg-10 col-md-12 mx-auto">
            <!-- Car Title -->
            <h3 class="text-center mb-3">{{ $car->maker }} {{ $car->model }}</h3>

            <!-- Image Section -->
            <!-- @if($car->images && count($car->images))
                <div class="carousel-container mb-4">
                    <div id="carImageCarousel" class="carousel slide" data-bs-ride="carousel">
                        <div class="carousel-inner">
                            @foreach($car->images as $key => $image)
                                <div class="carousel-item {{ $key == 0 ? 'active' : '' }}">
                                    <img src="{{ asset($image->image_path) }}" class="d-block mx-auto" alt="Car Image">
                                </div>
                            @endforeach
                        </div>
                        <button class="carousel-control-prev" type="button" data-bs-target="#carImageCarousel" data-bs-slide="prev">
                            <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                            <span class="visually-hidden">Previous</span>
                        </button>
                        <button class="carousel-control-next" type="button" data-bs-target="#carImageCarousel" data-bs-slide="next">
                            <span class="carousel-control-next-icon" aria-hidden="true"></span>
                            <span class="visually-hidden">Next</span>
                        </button>
                        <div class="carousel-indicators">
                            @foreach($car->images as $key => $image)
                                <button type="button" data-bs-target="#carImageCarousel" data-bs-slide-to="{{ $key }}"
                                    class="{{ $key == 0 ? 'active' : '' }}" aria-current="{{ $key == 0 ? 'true' : 'false' }}"
                                    aria-label="Slide {{ $key + 1 }}"></button>
                            @endforeach
                        </div>
                    </div>
                </div>
            @elseif($car->car_image)
                <div class="mb-4 text-center">
                    <img src="{{ asset($car->car_image) }}" alt="Car Image" style="max-width: 100%; max-height: 300px;" class="img-fluid rounded">
                </div>
            @else
                <div class="alert alert-info mb-4">No image available for this car</div>
            @endif -->

            <!-- Image Section -->
            <!-- Image Section -->
<!-- Image Section -->
            @if($car->car_image)
                <div class="mb-4 text-center">
                    @php
                        // Check if car_image already contains the full path or just filename
                        $isFullPath = str_contains($car->car_image, '/');
                        
                        if ($isFullPath) {
                            // car_image already contains full path like 'uploads/cars/filename.webp'
                            $imagePathUploads = $car->car_image;
                            $imagePathAdmin = str_replace('uploads/cars/', 'admincar_images/', $car->car_image);
                        } else {
                            // car_image contains only filename
                            $imagePathUploads = 'uploads/cars/' . $car->car_image;
                            $imagePathAdmin = 'admincar_images/' . $car->car_image;
                        }
                        
                        // Check if files exist
                        $imageExistsInUploads = file_exists(public_path($imagePathUploads));
                        $imageExistsInAdmin = file_exists(public_path($imagePathAdmin));
                    @endphp
                    
                    {{-- Debug information (remove in production) --}}
                    <!-- @if(config('app.debug'))
                        <div class="alert alert-warning small">
                            <strong>Debug Info:</strong><br>
                            Image name: {{ $car->car_image }}<br>
                            Uploads path: {{ public_path($imagePathUploads) }}<br>
                            Admin path: {{ public_path($imagePathAdmin) }}<br>
                            Uploads exists: {{ $imageExistsInUploads ? 'Yes' : 'No' }}<br>
                            Admin exists: {{ $imageExistsInAdmin ? 'Yes' : 'No' }}
                        </div>
                    @endif -->
                    
                    @if($imageExistsInUploads)
                        <img src="{{ asset($imagePathUploads) }}" 
                            alt="{{ $car->maker ?? 'Car' }} {{ $car->model ?? 'Image' }}" 
                            style="max-width: 100%; max-height: 300px; object-fit: cover;" 
                            class="img-fluid rounded"
                            onerror="console.log('Image failed to load: {{ asset($imagePathUploads) }}'); this.style.display='none'; this.nextElementSibling.style.display='flex';">
                        
                    @elseif($imageExistsInAdmin)
                        <img src="{{ asset($imagePathAdmin) }}" 
                            alt="{{ $car->maker ?? 'Car' }} {{ $car->model ?? 'Image' }}" 
                            style="max-width: 100%; max-height: 300px; object-fit: cover;" 
                            class="img-fluid rounded"
                            onerror="console.log('Image failed to load: {{ asset($imagePathAdmin) }}'); this.style.display='none'; this.nextElementSibling.style.display='flex';">
                        
                    @else
                        {{-- Show this if no file exists --}}
                        <div class="alert alert-warning mb-2">
                            <small>Image file not found in either directory</small>
                        </div>
                    @endif
                    
                    {{-- Fallback placeholder (always present but hidden unless needed) --}}
                    <div style="max-width: 100%; max-height: 300px; min-height: 200px; background: linear-gradient(135deg, #bdc3c7 0%, #95a5a6 100%); display: {{ ($imageExistsInUploads || $imageExistsInAdmin) ? 'none' : 'flex' }}; align-items: center; justify-content: center; color: white; font-size: 2rem;" 
                        class="img-fluid rounded">
                        <div class="text-center">
                            <i class="fas fa-car mb-2"></i>
                            <div style="font-size: 0.8rem;">No Image Available</div>
                        </div>
                    </div>
                </div>
            @else
                <div class="alert alert-info mb-4">
                    <i class="fas fa-info-circle me-2"></i>No image specified for this car
                </div>
            @endif

            {{-- Alternative simplified version if the above doesn't work --}}
            {{-- 
            @if($car->car_image)
                <div class="mb-4 text-center">
                    <img src="{{ asset('uploads/cars/' . $car->car_image) }}" 
                        alt="{{ $car->maker ?? 'Car' }} {{ $car->model ?? 'Image' }}" 
                        style="max-width: 100%; max-height: 300px; object-fit: cover;" 
                        class="img-fluid rounded"
                        onerror="this.onerror=null; this.src='{{ asset('admincar_images/' . $car->car_image) }}';">
                </div>
            @else
                <div class="alert alert-info mb-4">No image available for this car</div>
            @endif
            --}}

            <!-- Car Information -->
            <div class="car-details-card mb-4">
                <div class="car-info-row">
                    <div><strong>Brand:</strong> {{ $car->maker }}</div>
                    <div><strong>Body Type:</strong> {{ $car->vehicle_type }}</div>
                    <div><strong>Condition:</strong> {{ $car->car_condition }}</div>
                </div>
                <div class="car-info-row">
                    <div><strong>Registration:</strong> {{ $car->registration_no }}</div>
                    <div><strong>Mileage:</strong> {{ number_format($car->mileage) }} km</div>
                    <div><strong>Price:</strong> BTN {{ number_format($car->price) }}/day</div>
                </div>
                <div class="mt-3">
                    <div class="car-spec"><i class="fas fa-door-open me-2"></i><span>{{ $car->number_of_doors }} Doors</span></div>
                    <div class="car-spec"><i class="fas fa-users me-2"></i><span>{{ $car->number_of_seats }} Seats</span></div>
                    <div class="car-spec"><i class="fas fa-cogs me-2"></i><span>{{ ucfirst($car->transmission_type) }}</span></div>
                    <div class="car-spec"><i class="fas fa-suitcase-rolling me-2"></i><span>{{ $car->large_bags_capacity }} Large Bags</span></div>
                    <div class="car-spec"><i class="fas fa-suitcase me-2"></i><span>{{ $car->small_bags_capacity }} Small Bags</span></div>
                    <div class="car-spec"><i class="fas fa-gas-pump me-2"></i><span>{{ $car->fuel_type }}</span></div>
                    <div class="car-spec"><i class="fas fa-snowflake me-2"></i><span>{{ $car->air_conditioning ? 'Air Conditioning' : 'No AC' }}</span></div>
                    <div class="car-spec"><i class="fas fa-video me-2"></i><span>{{ $car->backup_camera ? 'Backup Camera' : 'No Backup Camera' }}</span></div>
                    <div class="car-spec"><i class="fas fa-music me-2"></i><span>{{ $car->bluetooth ? 'Bluetooth Enabled' : 'No Bluetooth' }}</span></div>
                </div>
                @if($car->description)
                    <div class="mt-3"><p><strong>Description:</strong> {{ $car->description }}</p></div>
                @endif
            </div>

            <!-- Booking Form -->
            <div class="booking-section mb-4">
                <h4>Book this Car</h4>

                @if(Auth::guard('customer')->check())
                    <form action="{{ route('car.booking.submit', $car->id) }}" method="POST">
                        @csrf
                        <div class="booking-inputs">
                            <div class="row mb-3">
                                <div class="col-md-6">
                                    <label for="pickup_date" class="form-label">Pickup Date:</label>
                                    <input type="date" class="form-control" name="pickup_date" id="pickup_date" required>
                                    <div class="mt-2">
                                        <label for="pickup_time" class="form-label">Pickup Time:</label>
                                        <input type="time" class="form-control" name="pickup_time" id="pickup_time" required>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <label for="return_date" class="form-label">Return Date:</label>
                                    <input type="date" class="form-control" name="return_date" id="return_date" required>
                                    <div class="mt-2">
                                        <label for="return_time" class="form-label">Return Time:</label>
                                        <input type="time" class="form-control" name="return_time" id="return_time" required>
                                    </div>
                                </div>
                            </div>
                            <div class="row mb-3">
                                <div class="col-md-6">
                                    <label for="pickup_location" class="form-label">Pickup Location:</label>
                                    <input type="text" class="form-control" name="pickup_location" required>
                                </div>
                                <div class="col-md-6">
                                    <label for="drop_location" class="form-label">Drop Location:</label>
                                    <input type="text" class="form-control" name="drop_location" required>
                                </div>
                            </div>
                            {{-- <div class="booking-timeline mb-3">
                                <div class="timeline-car">🚗</div>
                                <div class="timeline-line"></div>
                            </div>
                            <div class="text-muted small mb-3">Note: Time will be rounded off to the hour</div> --}}
                            <div class="d-flex gap-2">
                                <button type="submit" class="btn btn-primary">Book</button>
                                <a href="{{ route('home') }}" class="btn btn-secondary">Cancel</a>
                            </div>                        
                        </div>
                    </form>
                @else
                    <div class="alert alert-warning">You must be logged in to book a car.</div>
                    <a href="{{ route('customer.login', ['redirectTo' => url()->full()]) }}" class="btn btn-primary">Login to Book</a>
                    <a href="{{ route('home') }}" class="btn btn-secondary">Cancel</a>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        var carCarousel = new bootstrap.Carousel(document.getElementById('carImageCarousel'), {
            interval: 3000,
            ride: 'carousel'
        });
        
        // Set minimum date for date inputs (today)
        const today = new Date();
        const formattedToday = today.toISOString().split('T')[0]; // YYYY-MM-DD format
        
        const pickupDateInput = document.getElementById('pickup_date');
        const returnDateInput = document.getElementById('return_date');
        const pickupTimeInput = document.getElementById('pickup_time');
        const returnTimeInput = document.getElementById('return_time');
        
        let pickupDatepicker, returnDatepicker, pickupTextInput, returnTextInput;
        
        // Set default time values (9:00 AM for pickup, 6:00 PM for return)
        if (pickupTimeInput) {
            pickupTimeInput.value = '09:00';
        }
        
        if (returnTimeInput) {
            returnTimeInput.value = '18:00';
        }
        
        // Time validation and sync logic
        if (pickupDateInput && returnDateInput && pickupTimeInput && returnTimeInput) {
            // Handle the case when pickup and return dates are the same
            function validateTimes() {
                if (pickupDateInput.value && returnDateInput.value && 
                    pickupDateInput.value === returnDateInput.value) {
                    // If same day, ensure return time is after pickup time
                    const pickupTime = pickupTimeInput.value;
                    const returnTime = returnTimeInput.value;
                    
                    if (returnTime <= pickupTime) {
                        // If return time is earlier or same as pickup time, set it to pickup time + 1 hour
                        const [hours, minutes] = pickupTime.split(':').map(Number);
                        let newHours = hours + 1;
                        if (newHours > 23) newHours = 23;
                        returnTimeInput.value = `${String(newHours).padStart(2, '0')}:${String(minutes).padStart(2, '0')}`;
                    }
                }
            }
            
            pickupTimeInput.addEventListener('change', validateTimes);
            returnTimeInput.addEventListener('change', validateTimes);
        }
        
        // Function to format date as DD/MM/YYYY
        function formatDateToDMY(date) {
            const d = new Date(date);
            const day = String(d.getDate()).padStart(2, '0');
            const month = String(d.getMonth() + 1).padStart(2, '0');
            const year = d.getFullYear();
            return `${day}/${month}/${year}`;
        }
        
        // Create custom date inputs that display DD/MM/YYYY
        if (pickupDateInput) {
            // Set min date
            pickupDateInput.min = formattedToday;
            
            // Create a wrapper around the date input
            const pickupWrapper = document.createElement('div');
            pickupWrapper.className = 'date-input-wrapper';
            pickupDateInput.parentNode.insertBefore(pickupWrapper, pickupDateInput);
            
            // Create a text input for DD/MM/YYYY display
            pickupTextInput = document.createElement('input');
            pickupTextInput.type = 'text';
            pickupTextInput.className = 'form-control';
            pickupTextInput.placeholder = 'DD/MM/YYYY';
            pickupTextInput.required = true;
            
            // Move the date input out of view but keep it in the DOM for form submission
            pickupDateInput.style.position = 'absolute';
            pickupDateInput.style.opacity = '0';
            pickupDateInput.style.height = '0';
            pickupDateInput.style.width = '0';
            pickupDateInput.style.overflow = 'hidden';
            
            // Add the text input to the wrapper
            pickupWrapper.appendChild(pickupTextInput);
            pickupWrapper.appendChild(pickupDateInput);
            
            // Initialize datepicker
            pickupDatepicker = new Pikaday({
                field: pickupTextInput,
                format: 'DD/MM/YYYY',
                minDate: today,
                onSelect: function(date) {
                    // Update the hidden date input with YYYY-MM-DD format
                    pickupDateInput.value = date.toISOString().split('T')[0];
                    pickupDateInput.dispatchEvent(new Event('change'));
                    
                    // Update return date if needed
                    if (returnDatepicker) {
                        // Force return date to be at least the pickup date
                        const returnCurrentDate = returnDatepicker.getDate();
                        if (!returnCurrentDate || returnCurrentDate < date) {
                            returnDatepicker.setDate(date);
                            returnDateInput.value = pickupDateInput.value;
                            
                            // Validate times when dates are the same
                            validateTimes();
                        }
                        // Set the minimum selectable date for return
                        returnDatepicker.setMinDate(date);
                    }
                }
            });
        }
        
        if (returnDateInput) {
            // Set min date
            returnDateInput.min = formattedToday;
            
            // Create a wrapper around the date input
            const returnWrapper = document.createElement('div');
            returnWrapper.className = 'date-input-wrapper';
            returnDateInput.parentNode.insertBefore(returnWrapper, returnDateInput);
            
            // Create a text input for DD/MM/YYYY display
            returnTextInput = document.createElement('input');
            returnTextInput.type = 'text';
            returnTextInput.className = 'form-control';
            returnTextInput.placeholder = 'DD/MM/YYYY';
            returnTextInput.required = true;
            
            // Move the date input out of view but keep it in the DOM for form submission
            returnDateInput.style.position = 'absolute';
            returnDateInput.style.opacity = '0';
            returnDateInput.style.height = '0';
            returnDateInput.style.width = '0';
            returnDateInput.style.overflow = 'hidden';
            
            // Add the text input to the wrapper
            returnWrapper.appendChild(returnTextInput);
            returnWrapper.appendChild(returnDateInput);
            
            // Initialize datepicker
            returnDatepicker = new Pikaday({
                field: returnTextInput,
                format: 'DD/MM/YYYY',
                minDate: pickupDateInput.value ? new Date(pickupDateInput.value) : today,
                onSelect: function(date) {
                    // Update the hidden date input with YYYY-MM-DD format
                    returnDateInput.value = date.toISOString().split('T')[0];
                    returnDateInput.dispatchEvent(new Event('change'));
                    
                    // Ensure return date is not before pickup date
                    if (pickupDateInput.value) {
                        const pickupDate = new Date(pickupDateInput.value);
                        if (date < pickupDate) {
                            // Reset to pickup date if user somehow selects earlier date
                            returnDatepicker.setDate(pickupDate);
                            returnDateInput.value = pickupDateInput.value;
                        }
                    }
                    
                    // Check if dates are the same to validate times
                    validateTimes();
                }
            });
        }
    });
</script>
@endsection