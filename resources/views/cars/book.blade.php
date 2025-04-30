<!-- Link to the external CSS file -->
<link rel="stylesheet" href="{{ asset('assets/css/cars/book.css') }}">
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>


@extends('layouts.app')

@section('content')
<div class="container py-4">
    <div class="row">
        <div class="col-lg-10 col-md-12 mx-auto">
            <!-- Car Title -->
            <h3 class="text-center mb-3">{{ $car->maker }} {{ $car->model }}</h3>

            <!-- Image Section -->
            @if($car->images && count($car->images))
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
            @endif

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
                    <div><strong>Price:</strong> Nu {{ number_format($car->price) }}/day</div>
                </div>
                <div class="mt-3">
                    <div class="car-spec"><i class="spec-icon">🚗</i><span>{{ $car->number_of_doors }} Doors</span></div>
                    <div class="car-spec"><i class="spec-icon">👥</i><span>{{ $car->number_of_seats }} Seats</span></div>
                    <div class="car-spec"><i class="spec-icon">⚙️</i><span>{{ ucfirst($car->transmission_type) }}</span></div>
                    <div class="car-spec"><i class="spec-icon">🧳</i><span>{{ $car->large_bags_capacity }} Large Bags</span></div>
                    <div class="car-spec"><i class="spec-icon">🎒</i><span>{{ $car->small_bags_capacity }} Small Bags</span></div>
                    <div class="car-spec"><i class="spec-icon">⛽</i><span>{{ $car->fuel_type }}</span></div>
                    <div class="car-spec"><i class="spec-icon">❄️</i><span>{{ $car->air_conditioning ? 'Air Conditioning' : 'No AC' }}</span></div>
                    <div class="car-spec"><i class="spec-icon">🎥</i><span>{{ $car->backup_camera ? 'Backup Camera' : 'No Backup Camera' }}</span></div>
                    <div class="car-spec"><i class="spec-icon">🔊</i><span>{{ $car->bluetooth ? 'Bluetooth Enabled' : 'No Bluetooth' }}</span></div>
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
                                    <input type="date" class="form-control" name="pickup_date" required>
                                </div>
                                <div class="col-md-6">
                                    <label for="return_date" class="form-label">Return Date:</label>
                                    <input type="date" class="form-control" name="return_date" required>
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
                            <div class="booking-timeline mb-3">
                                <div class="timeline-car">🚗</div>
                                <div class="timeline-line"></div>
                            </div>
                            <div class="text-muted small mb-3">Note: Time will be rounded off to the hour</div>
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
    });
</script>
@endsection
