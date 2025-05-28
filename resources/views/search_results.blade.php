@extends('layouts.app')

@section('head')
<style>
    /* Search Results Specific Styles */
    .search-results-container {
        padding: 80px 20px 40px;
        max-width: 1200px;
        margin: 0 auto;
    }

    .search-info {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        color: white;
        padding: 25px;
        border-radius: 12px;
        margin-bottom: 30px;
        box-shadow: 0 8px 25px rgba(0,0,0,0.1);
    }

    .search-info h2 {
        margin: 0 0 15px 0;
        font-size: 1.8rem;
        font-weight: 600;
    }

    .search-params {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
        gap: 15px;
        margin-top: 15px;
    }

    .search-param {
        background: rgba(255,255,255,0.2);
        padding: 12px;
        border-radius: 8px;
        backdrop-filter: blur(10px);
    }

    .search-param strong {
        display: block;
        font-size: 0.9rem;
        margin-bottom: 5px;
        opacity: 0.9;
    }

    .search-param span {
        font-size: 1.1rem;
        font-weight: 500;
    }

    /* Car Grid Styles */
    .cars-grid {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(350px, 1fr));
        gap: 25px;
        margin-top: 30px;
    }

    .car-card {
        background: white;
        border-radius: 16px;
        overflow: hidden;
        box-shadow: 0 10px 30px rgba(0,0,0,0.1);
        transition: all 0.3s ease;
        position: relative;
    }

    .car-card:hover {
        transform: translateY(-8px);
        box-shadow: 0 20px 40px rgba(0,0,0,0.15);
    }

    .car-image-container {
        position: relative;
        height: 220px;
        overflow: hidden;
    }

    .car-image {
        width: 100%;
        height: 100%;
        object-fit: cover;
        transition: transform 0.3s ease;
    }

    .car-card:hover .car-image {
        transform: scale(1.05);
    }

    .car-status-badge {
        position: absolute;
        top: 15px;
        right: 15px;
        padding: 6px 12px;
        border-radius: 20px;
        font-size: 0.8rem;
        font-weight: 600;
        text-transform: uppercase;
        letter-spacing: 0.5px;
    }

    .badge-approved {
        background: linear-gradient(135deg, #48bb78, #38a169);
        color: white;
    }

    .badge-completed {
        background: linear-gradient(135deg, #4299e1, #3182ce);
        color: white;
    }

    .badge-admin {
        background: linear-gradient(135deg, #ed8936, #dd6b20);
        color: white;
    }

    .car-info {
        padding: 25px;
    }

    .car-title {
        font-size: 1.3rem;
        font-weight: 700;
        color: #2d3748;
        margin-bottom: 8px;
    }

    .car-price {
        font-size: 1.5rem;
        font-weight: 700;
        color: #667eea;
        margin-bottom: 15px;
    }

    /* Car Features Grid */
    .car-features {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 12px;
        margin: 20px 0;
    }

    .feature-item {
        display: flex;
        align-items: center;
        gap: 8px;
        padding: 8px 12px;
        background: #f7fafc;
        border-radius: 8px;
        font-size: 0.9rem;
        color: #4a5568;
    }

    .feature-icon {
        color: #667eea;
        font-size: 1rem;
    }

    /* Action Buttons */
    .car-actions {
        display: flex;
        gap: 12px;
        margin-top: 20px;
    }

    .btn {
        flex: 1;
        padding: 12px 20px;
        border: none;
        border-radius: 8px;
        font-weight: 600;
        text-decoration: none;
        text-align: center;
        transition: all 0.3s ease;
        cursor: pointer;
        font-size: 0.9rem;
    }

    .btn-details {
        background: linear-gradient(135deg, #a0aec0, #718096);
        color: white;
    }

    .btn-details:hover {
        background: linear-gradient(135deg, #718096, #4a5568);
        transform: translateY(-2px);
    }

    .btn-book {
        background: linear-gradient(135deg, #667eea, #764ba2);
        color: white;
    }

    .btn-book:hover {
        background: linear-gradient(135deg, #5a67d8, #553c9a);
        transform: translateY(-2px);
    }

    /* No Results Styles */
    .no-results {
        text-align: center;
        padding: 60px 20px;
        background: white;
        border-radius: 16px;
        box-shadow: 0 10px 30px rgba(0,0,0,0.1);
    }

    .no-results-icon {
        font-size: 4rem;
        color: #cbd5e0;
        margin-bottom: 20px;
    }

    .no-results h3 {
        font-size: 1.5rem;
        color: #4a5568;
        margin-bottom: 15px;
    }

    .no-results p {
        color: #718096;
        font-size: 1.1rem;
        margin-bottom: 25px;
    }

    .btn-search-again {
        background: linear-gradient(135deg, #667eea, #764ba2);
        color: white;
        padding: 12px 30px;
        border-radius: 8px;
        text-decoration: none;
        font-weight: 600;
        display: inline-block;
        transition: all 0.3s ease;
    }

    .btn-search-again:hover {
        transform: translateY(-2px);
        box-shadow: 0 8px 20px rgba(102, 126, 234, 0.3);
    }

    /* Section Headers */
    .section-header {
        margin: 40px 0 25px;
        padding-bottom: 15px;
        border-bottom: 3px solid #e2e8f0;
    }

    .section-title {
        font-size: 1.5rem;
        font-weight: 700;
        color: #2d3748;
        margin-bottom: 5px;
    }

    .section-subtitle {
        color: #718096;
        font-size: 1rem;
    }

    /* Responsive Design */
    @media (max-width: 768px) {
        .search-results-container {
            padding: 80px 15px 30px;
        }

        .cars-grid {
            grid-template-columns: 1fr;
        }

        .search-params {
            grid-template-columns: 1fr;
        }

        .car-features {
            grid-template-columns: 1fr;
        }

        .car-actions {
            flex-direction: column;
        }

        .search-info h2 {
            font-size: 1.4rem;
        }
    }

    /* Placeholder image styling */
    .car-placeholder {
        width: 100%;
        height: 220px;
        background: linear-gradient(135deg, #bdc3c7 0%, #95a5a6 100%);
        display: flex;
        align-items: center;
        justify-content: center;
        color: white;
        font-size: 3rem;
    }
</style>
@endsection

@section('content')
<div class="search-results-container">
    <!-- Search Information Panel -->
    <div class="search-info">
        <h2><i class="fas fa-search"></i> Search Results</h2>
        @if(request()->has('pickup_location') || request()->has('pickup_date'))
            <div class="search-params">
                @if(request('pickup_location'))
                    <div class="search-param">
                        <strong><i class="fas fa-map-marker-alt"></i> Pickup Location</strong>
                        <span>{{ request('pickup_location') }}</span>
                    </div>
                @endif
                @if(request('pickup_date'))
                    <div class="search-param">
                        <strong><i class="fas fa-calendar-alt"></i> Pickup Date</strong>
                        <span>{{ \Carbon\Carbon::parse(request('pickup_date'))->format('M d, Y') }}</span>
                    </div>
                @endif
                @if(request('pickup_time'))
                    <div class="search-param">
                        <strong><i class="fas fa-clock"></i> Pickup Time</strong>
                        <span>{{ \Carbon\Carbon::createFromTime(...explode(':', request('pickup_time')))->format('h:i A') }}</span>
                    </div>
                @endif
                @if(request('dropoff_date'))
                    <div class="search-param">
                        <strong><i class="fas fa-calendar-check"></i> Return Date</strong>
                        <span>{{ \Carbon\Carbon::parse(request('dropoff_date'))->format('M d, Y') }}</span>
                    </div>
                @endif
                @if(request('dropoff_time'))
                    <div class="search-param">
                        <strong><i class="fas fa-clock"></i> Return Time</strong>
                        <span>{{ \Carbon\Carbon::createFromTime(...explode(':', request('dropoff_time')))->format('h:i A') }}</span>
                    </div>
                @endif
            </div>
        @endif
    </div>

    @php
        // Separate cars by type
        $approvedCars = collect();
        $completedBookingCars = collect();
        $adminCars = collect();

        if(isset($availableCars) && $availableCars->count()) {
            foreach($availableCars as $car) {
                // Check if it's an admin car (you might need to adjust this logic)
                if(isset($car->car_type) && $car->car_type === 'admin') {
                    $car->display_type = 'admin';
                    $adminCars->push($car);
                } else {
                    // Check if car has completed bookings
                    $hasCompletedBooking = DB::table('car_bookings')
                        ->where('car_id', $car->id)
                        ->where('status', 'completed')
                        ->exists();
                    
                    if($hasCompletedBooking) {
                        $car->display_type = 'completed';
                        $completedBookingCars->push($car);
                    } else {
                        $car->display_type = 'approved';
                        $approvedCars->push($car);
                    }
                }
            }
        }

        $totalCars = $approvedCars->count() + $completedBookingCars->count() + $adminCars->count();
    @endphp

    @if($totalCars > 0)
        <!-- Results Summary -->
        <div style="background: white; padding: 20px; border-radius: 12px; margin-bottom: 30px; box-shadow: 0 4px 15px rgba(0,0,0,0.1);">
            <h3 style="margin: 0; color: #2d3748;">
                <i class="fas fa-car"></i> Found {{ $totalCars }} Available {{ Str::plural('Car', $totalCars) }}
            </h3>
            <p style="margin: 8px 0 0; color: #718096;">
                {{ $approvedCars->count() }} approved cars, 
                {{ $completedBookingCars->count() }} cars with completed bookings,
                {{ $adminCars->count() }} premium cars
            </p>
        </div>

        <!-- Approved Cars Section -->
        @if($approvedCars->count() > 0)
            <div class="section-header">
                <h3 class="section-title">
                    <i class="fas fa-check-circle" style="color: #48bb78;"></i> 
                    Approved Cars ({{ $approvedCars->count() }})
                </h3>
                <p class="section-subtitle">Recently inspected and approved vehicles</p>
            </div>
            
            <div class="cars-grid">
                @foreach($approvedCars as $car)
                    {{-- @include('partials.car-card', ['car' => $car, 'badgeType' => 'approved']) --}}
                @endforeach
            </div>
        @endif

        <!-- Cars with Completed Bookings Section -->
        @if($completedBookingCars->count() > 0)
            <div class="section-header">
                <h3 class="section-title">
                    <i class="fas fa-star" style="color: #4299e1;"></i> 
                    Proven Reliable Cars ({{ $completedBookingCars->count() }})
                </h3>
                <p class="section-subtitle">Cars with successful rental history</p>
            </div>
            
            <div class="cars-grid">
                @foreach($completedBookingCars as $car)
                    {{-- @include('partials.car-card', ['car' => $car, 'badgeType' => 'completed']) --}}
                @endforeach
            </div>
        @endif

        <!-- Admin/Premium Cars Section -->
        @if($adminCars->count() > 0)
            <div class="section-header">
                <h3 class="section-title">
                    <i class="fas fa-crown" style="color: #ed8936;"></i> 
                    Premium Fleet ({{ $adminCars->count() }})
                </h3>
                <p class="section-subtitle">Premium vehicles from our exclusive collection</p>
            </div>
            
            <div class="cars-grid">
                @foreach($adminCars as $car)
                    {{-- @include('partials.car-card', ['car' => $car, 'badgeType' => 'admin']) --}}
                @endforeach
            </div>
        @endif

    @else
        <!-- No Results Found -->
        <div class="no-results">
            <div class="no-results-icon">
                <i class="fas fa-search"></i>
            </div>
            <h3>No Cars Found</h3>
            <p>We couldn't find any available cars matching your search criteria. Try adjusting your search parameters or dates.</p>
            <a href="{{ url('/') }}" class="btn-search-again">
                <i class="fas fa-redo"></i> Search Again
            </a>
        </div>
    @endif
</div>

<!-- Car Details Modal (from your existing code) -->
<div id="carDetailsModal" class="car-details-modal">
    <div class="modal-content">
        <span class="close-modal">&times;</span>
        <h2 id="modalCarTitle">Car Details</h2>
        <div class="car-specs-container">
            <div class="car-specs-row">
                <div class="car-spec">
                    <i class="fas fa-door-open spec-icon"></i>
                    <span id="doors">4 Doors</span>
                </div>
                <div class="car-spec">
                    <i class="fas fa-users spec-icon"></i>
                    <span id="seats">7 Seats</span>
                </div>
            </div>
            <div class="car-specs-row">
                <div class="car-spec">
                    <i class="fas fa-snowflake spec-icon"></i>
                    <span id="ac">Air Conditioning</span>
                </div>
                <div class="car-spec">
                    <i class="fas fa-cogs spec-icon"></i>
                    <span id="transmission">Automatic</span>
                </div>
            </div>
            <div class="car-specs-row">
                <div class="car-spec">
                    <i class="fas fa-suitcase spec-icon"></i>
                    <span id="largeBags">2 Large Bags</span>
                </div>
                <div class="car-spec">
                    <i class="fas fa-briefcase spec-icon"></i>
                    <span id="smallBags">2 Small Bags</span>
                </div>
            </div>
            <div class="car-specs-row">
                <div class="car-spec">
                    <i class="fas fa-tachometer-alt spec-icon"></i>
                    <span id="mpg">16-21 mpg</span>
                </div>
                <div class="car-spec">
                    <i class="fab fa-bluetooth spec-icon"></i>
                    <span id="bluetooth">Bluetooth</span>
                </div>
            </div>
            <div class="car-specs-row">
                <div class="car-spec">
                    <i class="fas fa-video spec-icon"></i>
                    <span id="camera">Backup Camera</span>
                </div>
                <div class="car-spec">
                    <i class="fas fa-gas-pump spec-icon"></i>
                    <span id="fuelType">Gasoline</span>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Car Details Modal functionality
    const detailButtons = document.querySelectorAll('.btn-details');
    const carDetailsModal = document.getElementById('carDetailsModal');
    const closeModal = document.querySelector('.close-modal');

    detailButtons.forEach(button => {
        button.addEventListener('click', function(e) {
            e.preventDefault();
            const carId = this.getAttribute('data-car-id');
            const carSource = this.getAttribute('data-car-source') || 'regular';
            
            // Show loading state
            document.getElementById('modalCarTitle').textContent = "Loading...";
            carDetailsModal.style.display = 'block';
            
            // Fetch car details
            fetchCarDetails(carId, carSource);
        });
    });

    if (closeModal) {
        closeModal.addEventListener('click', function() {
            carDetailsModal.style.display = 'none';
        });
    }

    // Close modal when clicking outside
    window.addEventListener('click', function(event) {
        if (event.target === carDetailsModal) {
            carDetailsModal.style.display = 'none';
        }
    });

    function fetchCarDetails(carId, carSource = 'regular') {
        const endpoint = carSource === 'admin' ? `/admin-cars/${carId}/details` : `/cars/${carId}/details`;
        
        fetch(endpoint)
            .then(response => {
                if (!response.ok) {
                    throw new Error('Network response was not ok');
                }
                return response.json();
            })
            .then(data => {
                if (data.success) {
                    showCarDetails(data.details);
                } else {
                    throw new Error(data.message || 'Error fetching car details');
                }
            })
            .catch(error => {
                console.error('Error:', error);
                document.getElementById('modalCarTitle').textContent = "Error loading details";
            });
    }

    function showCarDetails(carData) {
        document.getElementById('modalCarTitle').textContent = carData.title;
        document.getElementById('doors').textContent = carData.doors;
        document.getElementById('seats').textContent = carData.seats;
        document.getElementById('ac').textContent = carData.ac;
        document.getElementById('transmission').textContent = carData.transmission;
        document.getElementById('largeBags').textContent = carData.largeBags;
        document.getElementById('smallBags').textContent = carData.smallBags;
        document.getElementById('mpg').textContent = carData.mpg;
        document.getElementById('bluetooth').textContent = carData.bluetooth;
        document.getElementById('camera').textContent = carData.camera;
        document.getElementById('fuelType').textContent = carData.fuelType;
    }
});
</script>

<!-- Modal Styles (from your existing code) -->
<style>
.car-details-modal {
    display: none;
    position: fixed;
    z-index: 1000;
    left: 0;
    top: 0;
    width: 100%;
    height: 100%;
    overflow: auto;
    background-color: rgba(0,0,0,0.5);
}

.car-details-modal .modal-content {
    background-color: #f8f8f8;
    margin: 10% auto;
    padding: 20px;
    border-radius: 8px;
    width: 80%;
    max-width: 600px;
    box-shadow: 0 5px 15px rgba(0,0,0,0.3);
}

.close-modal {
    color: #aaa;
    float: right;
    font-size: 28px;
    font-weight: bold;
    cursor: pointer;
}

.close-modal:hover,
.close-modal:focus {
    color: black;
    text-decoration: none;
    cursor: pointer;
}

.car-specs-container {
    display: flex;
    flex-direction: column;
    gap: 15px;
    margin-top: 20px;
    background-color: #f0f0f0;
    padding: 15px;
    border-radius: 5px;
}

.car-specs-row {
    display: flex;
    justify-content: space-between;
}

.car-spec {
    display: flex;
    align-items: center;
    gap: 10px;
    width: 48%;
    background-color: white;
    padding: 10px;
    border-radius: 5px;
    box-shadow: 0 2px 4px rgba(0,0,0,0.1);
}

.spec-icon {
    font-style: normal;
    font-size: 18px;
}

#modalCarTitle {
    text-align: center;
    margin-bottom: 20px;
}
</style>
@endsection