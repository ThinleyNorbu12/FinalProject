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
                    <div><strong>Current Mileage:</strong> {{ number_format($car->current_mileage ?? 0) }} km</div>
                    <div><strong>Rate:</strong> BTN {{ number_format($car->rate_per_day ?? 0, 2) }}/day</div>
                </div>
                
                @if($car->price_per_km || $car->mileage_limit)
                <div class="car-info-row">
                    @if($car->mileage_limit)
                        <div><strong>Daily Limit:</strong> {{ number_format($car->mileage_limit) }} km/day</div>
                    @endif
                    @if($car->price_per_km)
                        <div><strong>Extra KM Rate:</strong> BTN {{ number_format($car->price_per_km, 2) }}/km</div>
                    @endif
                    @if($car->pricing_active !== null)
                        <div><strong>Status:</strong> 
                            <span class="badge {{ $car->pricing_active ? 'bg-success' : 'bg-warning' }}">
                                {{ $car->pricing_active ? 'Active' : 'Inactive' }}
                            </span>
                        </div>
                    @endif
                </div>
                @endif
                
                <div class="mt-3">
                    <div class="car-spec">
                        <i class="fas fa-door-open me-2"></i>
                        <span>{{ $car->number_of_doors ?? 'N/A' }} {{ ($car->number_of_doors ?? 0) == 1 ? 'Door' : 'Doors' }}</span>
                    </div>
                    <div class="car-spec">
                        <i class="fas fa-users me-2"></i>
                        <span>{{ $car->number_of_seats ?? 'N/A' }} {{ ($car->number_of_seats ?? 0) == 1 ? 'Seat' : 'Seats' }}</span>
                    </div>
                    <div class="car-spec">
                        <i class="fas fa-cogs me-2"></i>
                        <span>{{ ucfirst($car->transmission_type ?? 'Unknown') }}</span>
                    </div>
                    <div class="car-spec">
                        <i class="fas fa-suitcase-rolling me-2"></i>
                        <span>{{ $car->large_bags_capacity ?? 0 }} Large {{ ($car->large_bags_capacity ?? 0) == 1 ? 'Bag' : 'Bags' }}</span>
                    </div>
                    <div class="car-spec">
                        <i class="fas fa-suitcase me-2"></i>
                        <span>{{ $car->small_bags_capacity ?? 0 }} Small {{ ($car->small_bags_capacity ?? 0) == 1 ? 'Bag' : 'Bags' }}</span>
                    </div>
                    <div class="car-spec">
                        <i class="fas fa-gas-pump me-2"></i>
                        <span>{{ ucfirst($car->fuel_type ?? 'Unknown') }}</span>
                    </div>
                    <div class="car-spec">
                        <i class="fas fa-snowflake me-2"></i>
                        <span>
                            @php
                                $hasAC = false;
                                if (is_bool($car->air_conditioning)) {
                                    $hasAC = $car->air_conditioning;
                                } elseif (is_string($car->air_conditioning)) {
                                    $hasAC = strtolower($car->air_conditioning) === 'yes' || $car->air_conditioning === '1';
                                } else {
                                    $hasAC = (bool) $car->air_conditioning;
                                }
                            @endphp
                            {{ $hasAC ? 'Air Conditioning' : 'No AC' }}
                        </span>
                    </div>
                    <div class="car-spec">
                        <i class="fas fa-video me-2"></i>
                        <span>
                            @php
                                $hasCamera = false;
                                if (is_bool($car->backup_camera)) {
                                    $hasCamera = $car->backup_camera;
                                } elseif (is_string($car->backup_camera)) {
                                    $hasCamera = strtolower($car->backup_camera) === 'yes' || $car->backup_camera === '1';
                                } else {
                                    $hasCamera = (bool) $car->backup_camera;
                                }
                            @endphp
                            {{ $hasCamera ? 'Rear-View Camera' : 'No Rear-View Camera' }}
                        </span>
                    </div>
                    <div class="car-spec">
                        <i class="fas fa-music me-2"></i>
                        <span>
                            @php
                                $hasBluetooth = false;
                                if (is_bool($car->bluetooth)) {
                                    $hasBluetooth = $car->bluetooth;
                                } elseif (is_string($car->bluetooth)) {
                                    $hasBluetooth = strtolower($car->bluetooth) === 'yes' || $car->bluetooth === '1';
                                } else {
                                    $hasBluetooth = (bool) $car->bluetooth;
                                }
                            @endphp
                            {{ $hasBluetooth ? 'Bluetooth Enabled' : 'No Bluetooth' }}
                        </span>
                    </div>
                </div>
                
                @if($car->description)
                    <div class="mt-3">
                        <p><strong>Description:</strong> {{ $car->description }}</p>
                    </div>
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
    // Initialize carousel if it exists
    const carCarousel = document.getElementById('carImageCarousel');
    if (carCarousel) {
        new bootstrap.Carousel(carCarousel, {
            interval: 3000,
            ride: 'carousel'
        });
    }
    
    // Get current date and format it properly
    const today = new Date();
    const year = today.getFullYear();
    const month = String(today.getMonth() + 1).padStart(2, '0');
    const day = String(today.getDate()).padStart(2, '0');
    const formattedToday = `${year}-${month}-${day}`;
    
    // Get form elements
    const pickupDateInput = document.getElementById('pickup_date');
    const returnDateInput = document.getElementById('return_date');
    const pickupTimeInput = document.getElementById('pickup_time');
    const returnTimeInput = document.getElementById('return_time');
    const bookingForm = document.querySelector('form[action*="car.booking.submit"]');
    
    // Set minimum dates and default values
    if (pickupDateInput) {
        pickupDateInput.min = formattedToday;
        pickupDateInput.max = `${year + 1}-${month}-${day}`;
    }
    
    if (returnDateInput) {
        returnDateInput.min = formattedToday;
        returnDateInput.max = `${year + 1}-${month}-${day}`;
    }
    
    // Set default time values
    if (pickupTimeInput && !pickupTimeInput.value) {
        pickupTimeInput.value = '09:00';
    }
    if (returnTimeInput && !returnTimeInput.value) {
        returnTimeInput.value = '18:00';
    }
    
    // Utility functions
    function showAlert(message, type = 'warning') {
        // Remove existing alerts
        const existingAlerts = document.querySelectorAll('.booking-alert');
        existingAlerts.forEach(alert => alert.remove());
        
        // Create new alert
        const alertDiv = document.createElement('div');
        alertDiv.className = `alert alert-${type} booking-alert mt-2`;
        alertDiv.innerHTML = `<i class="fas fa-exclamation-triangle me-1"></i>${message}`;
        
        // Insert after the booking form title
        const bookingTitle = document.querySelector('.booking-section h4');
        if (bookingTitle) {
            bookingTitle.insertAdjacentElement('afterend', alertDiv);
            
            // Auto-remove after 5 seconds
            setTimeout(() => {
                if (alertDiv.parentNode) {
                    alertDiv.remove();
                }
            }, 5000);
        }
    }
    
    function validatePickupDate() {
        if (!pickupDateInput || !pickupDateInput.value) return false;
        
        const pickupDate = new Date(pickupDateInput.value);
        const todayDate = new Date();
        
        // Reset time for accurate comparison
        pickupDate.setHours(0, 0, 0, 0);
        todayDate.setHours(0, 0, 0, 0);
        
        if (pickupDate < todayDate) {
            showAlert('Pickup date cannot be in the past. Please select today or a future date.');
            pickupDateInput.value = formattedToday;
            pickupDateInput.focus();
            return false;
        }
        
        return true;
    }
    
    function validateReturnDate() {
        if (!returnDateInput || !returnDateInput.value || !pickupDateInput || !pickupDateInput.value) {
            return false;
        }
        
        const pickupDate = new Date(pickupDateInput.value);
        const returnDate = new Date(returnDateInput.value);
        const todayDate = new Date();
        
        // Reset time for accurate comparison
        pickupDate.setHours(0, 0, 0, 0);
        returnDate.setHours(0, 0, 0, 0);
        todayDate.setHours(0, 0, 0, 0);
        
        if (returnDate < todayDate) {
            showAlert('Return date cannot be in the past. Please select today or a future date.');
            returnDateInput.value = pickupDateInput.value;
            returnDateInput.focus();
            return false;
        }
        
        if (returnDate < pickupDate) {
            showAlert('Return date cannot be before pickup date.');
            returnDateInput.value = pickupDateInput.value;
            returnDateInput.focus();
            return false;
        }
        
        return true;
    }
    
    function validateDateTime() {
        if (!pickupDateInput.value || !returnDateInput.value || !pickupTimeInput.value || !returnTimeInput.value) {
            return false;
        }
        
        // Create datetime objects for comparison
        const pickupDateTime = new Date(`${pickupDateInput.value}T${pickupTimeInput.value}`);
        const returnDateTime = new Date(`${returnDateInput.value}T${returnTimeInput.value}`);
        const now = new Date();
        
        // Check if pickup is in the past (for today's bookings)
        if (pickupDateInput.value === formattedToday && pickupDateTime <= now) {
            showAlert('Pickup time cannot be in the past for today\'s bookings.');
            
            // Set a reasonable future time
            const futureTime = new Date(now.getTime() + 2 * 60 * 60 * 1000); // 2 hours from now
            const hours = String(futureTime.getHours()).padStart(2, '0');
            const minutes = String(futureTime.getMinutes()).padStart(2, '0');
            pickupTimeInput.value = `${hours}:${minutes}`;
            pickupTimeInput.focus();
            return false;
        }
        
        // Check if return datetime is after pickup datetime
        if (returnDateTime <= pickupDateTime) {
            showAlert('Return date and time must be after pickup date and time.');
            
            // Auto-adjust return time
            const minReturnTime = new Date(pickupDateTime.getTime() + 60 * 60 * 1000); // 1 hour minimum
            
            // If same day, just add 1 hour to pickup time
            if (pickupDateInput.value === returnDateInput.value) {
                const newHours = String(minReturnTime.getHours()).padStart(2, '0');
                const newMinutes = String(minReturnTime.getMinutes()).padStart(2, '0');
                returnTimeInput.value = `${newHours}:${newMinutes}`;
            } else {
                // Different day, set to same time as pickup
                returnTimeInput.value = pickupTimeInput.value;
            }
            
            returnTimeInput.focus();
            return false;
        }
        
        return true;
    }
    
    function updateReturnDateConstraints() {
        if (pickupDateInput && returnDateInput && pickupDateInput.value) {
            returnDateInput.min = pickupDateInput.value;
            
            // If return date is before pickup date, update it
            if (returnDateInput.value && returnDateInput.value < pickupDateInput.value) {
                returnDateInput.value = pickupDateInput.value;
            }
        }
    }
    
    function clearValidationErrors() {
        // Remove Bootstrap validation classes
        const inputs = bookingForm.querySelectorAll('.form-control');
        inputs.forEach(input => {
            input.classList.remove('is-invalid', 'is-valid');
        });
        
        // Remove custom alerts
        const alerts = document.querySelectorAll('.booking-alert');
        alerts.forEach(alert => alert.remove());
    }
    
    // Event listeners
    if (pickupDateInput) {
        pickupDateInput.addEventListener('change', function() {
            clearValidationErrors();
            if (this.value) {
                if (validatePickupDate()) {
                    updateReturnDateConstraints();
                    validateDateTime();
                }
            }
        });
        
        pickupDateInput.addEventListener('blur', function() {
            if (this.value) {
                validatePickupDate();
            }
        });
    }
    
    if (returnDateInput) {
        returnDateInput.addEventListener('change', function() {
            clearValidationErrors();
            if (this.value) {
                if (validateReturnDate()) {
                    validateDateTime();
                }
            }
        });
        
        returnDateInput.addEventListener('blur', function() {
            if (this.value) {
                validateReturnDate();
            }
        });
    }
    
    if (pickupTimeInput) {
        pickupTimeInput.addEventListener('change', function() {
            clearValidationErrors();
            if (this.value) {
                validateDateTime();
            }
        });
    }
    
    if (returnTimeInput) {
        returnTimeInput.addEventListener('change', function() {
            clearValidationErrors();
            if (this.value) {
                validateDateTime();
            }
        });
    }
    
    // Form submission validation
    if (bookingForm) {
        bookingForm.addEventListener('submit', function(e) {
            clearValidationErrors();
            
            let isValid = true;
            const errors = [];
            
            // Check all required fields
            const requiredFields = [
                { element: pickupDateInput, name: 'Pickup Date' },
                { element: returnDateInput, name: 'Return Date' },
                { element: pickupTimeInput, name: 'Pickup Time' },
                { element: returnTimeInput, name: 'Return Time' },
                { element: document.querySelector('[name="pickup_location"]'), name: 'Pickup Location' },
                { element: document.querySelector('[name="drop_location"]'), name: 'Drop Location' }
            ];
            
            // Check for empty required fields
            requiredFields.forEach(field => {
                if (!field.element || !field.element.value.trim()) {
                    errors.push(`${field.name} is required`);
                    if (field.element) {
                        field.element.classList.add('is-invalid');
                    }
                    isValid = false;
                }
            });
            
            // Validate dates and times if all fields are filled
            if (isValid) {
                if (!validatePickupDate()) {
                    isValid = false;
                }
                
                if (!validateReturnDate()) {
                    isValid = false;
                }
                
                if (!validateDateTime()) {
                    isValid = false;
                }
            }
            
            // Show errors if any
            if (!isValid) {
                e.preventDefault();
                
                if (errors.length > 0) {
                    showAlert(`Please fix the following errors:<br>• ${errors.join('<br>• ')}`, 'danger');
                }
                
                // Focus on first invalid field
                const firstInvalid = bookingForm.querySelector('.is-invalid');
                if (firstInvalid) {
                    firstInvalid.focus();
                    firstInvalid.scrollIntoView({ behavior: 'smooth', block: 'center' });
                }
                
                return false;
            }
            
            // Show loading state
            const submitBtn = bookingForm.querySelector('button[type="submit"]');
            if (submitBtn) {
                submitBtn.disabled = true;
                submitBtn.innerHTML = '<i class="fas fa-spinner fa-spin me-1"></i>Processing...';
                
                // Re-enable button after 10 seconds as fallback
                setTimeout(() => {
                    submitBtn.disabled = false;
                    submitBtn.innerHTML = 'Book';
                }, 10000);
            }
            
            return true;
        });
        
        // Remove validation errors when user starts typing
        const formInputs = bookingForm.querySelectorAll('input[required]');
        formInputs.forEach(input => {
            input.addEventListener('input', function() {
                this.classList.remove('is-invalid');
                
                // Clear alerts if user starts fixing issues
                const alerts = document.querySelectorAll('.booking-alert');
                if (alerts.length > 0) {
                    setTimeout(() => {
                        alerts.forEach(alert => alert.remove());
                    }, 1000);
                }
            });
        });
    }
    
    // Initialize validation on page load if values are already set
    setTimeout(() => {
        if (pickupDateInput && pickupDateInput.value) {
            validatePickupDate();
            updateReturnDateConstraints();
        }
        if (returnDateInput && returnDateInput.value) {
            validateReturnDate();
        }
        if (pickupTimeInput && pickupTimeInput.value && returnTimeInput && returnTimeInput.value) {
            validateDateTime();
        }
    }, 100);
    
    // Handle browser back/forward navigation
    window.addEventListener('pageshow', function(event) {
        if (event.persisted) {
            // Page loaded from cache, revalidate
            clearValidationErrors();
            
            // Re-enable submit button if it was disabled
            const submitBtn = bookingForm?.querySelector('button[type="submit"]');
            if (submitBtn && submitBtn.disabled) {
                submitBtn.disabled = false;
                submitBtn.innerHTML = 'Book';
            }
        }
    });
});
</script>
@endsection