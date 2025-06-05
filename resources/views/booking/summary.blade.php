@extends('layouts.app')

@section('content')
<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-md-10">
            <div class="card shadow">
                <div class="card-header bg-primary text-white">
                    <h4 class="mb-0">Booking Summary</h4>
                </div>
                
                <div class="card-body">
                    @if(session('success'))
                        <div class="alert alert-success alert-dismissible fade show" role="alert">
                            {{ session('success') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    @endif
                    
                    @if($booking)
                        <div class="row">
                            <!-- Booking Details -->
                            <div class="col-md-6">
                                <h5 class="border-bottom pb-2 mb-3">Booking Details</h5>
                                <p><strong>Booking ID:</strong> #{{ $booking->id }}</p>
                                <p><strong>Booking Date:</strong> {{ $booking->created_at->format('d M, Y h:i A') }}</p>
                                <p><strong>Status:</strong> 
                                    @if($booking->status === 'confirmed')
                                        <span class="badge bg-success">Confirmed</span>
                                    @elseif($booking->status === 'pending_verification')
                                        <span class="badge bg-info">Payment Under Verification</span>
                                    @elseif($booking->status === 'cancelled')
                                        <span class="badge bg-danger">Cancelled</span>
                                    @elseif($booking->status === 'completed')
                                        <span class="badge bg-primary">Completed</span>
                                    @else
                                        <span class="badge bg-warning text-dark">Pending</span>
                                    @endif
                                </p>

                                {{-- Show payment status if payment method is set --}}
                                @if($booking->payment_method)
                                    <p><strong>Payment Method:</strong> 
                                        @if($booking->payment_method === 'qr_code')
                                            QR Code Payment
                                        @elseif($booking->payment_method === 'bank_transfer')
                                            Bank Transfer
                                        @elseif($booking->payment_method === 'pay_later')
                                            Pay at Pickup
                                        @else
                                            {{ ucfirst(str_replace('_', ' ', $booking->payment_method)) }}
                                        @endif
                                    </p>
                                @endif

                                {{-- Show verification message for QR payments --}}
                                @if($booking->status === 'pending_verification' && $booking->payment_method === 'qr_code')
                                    <div class="alert alert-info">
                                        <i class="fas fa-clock me-2"></i>
                                        Your payment screenshot has been submitted and is being verified. We'll confirm your booking shortly.
                                    </div>
                                @endif
                                
                                <h5 class="border-bottom pb-2 mb-3 mt-4">Trip Details</h5>
                                <div class="row">
                                    <div class="col-md-6">
                                        <p><strong>Pick-up:</strong></p>
                                        <p>{{ $booking->pickup_location }}</p>
                                        <p>
                                            {{ $booking->pickup_datetime->setTimezone('Asia/Thimphu')->format('d M, Y h:i A') }}
                                        </p>
                                    </div>
                                    
                                    <div class="col-md-6">
                                        <p><strong>Drop-off:</strong></p>
                                        <p>{{ $booking->dropoff_location }}</p>
                                        <p>
                                            {{ $booking->dropoff_datetime->setTimezone('Asia/Thimphu')->format('d M, Y h:i A') }}
                                        </p>
                                    </div>                                    
                                </div>
                                
                                <div class="mt-4">
                                    @php
                                        $hours = $booking->pickup_datetime->diffInHours($booking->dropoff_datetime);
                                        $days = floor($hours / 24);
                                        $remainingHours = $hours % 24;
                                    @endphp
                                    <p><strong>Duration:</strong> 
                                        @if($days > 0)
                                            {{ $days }} day{{ $days > 1 ? 's' : '' }}
                                        @endif
                                        @if($remainingHours > 0)
                                            {{ $remainingHours }} hour{{ $remainingHours > 1 ? 's' : '' }}
                                        @endif
                                    </p>
                                </div>
                            </div>
                            
                            <!-- Vehicle Details -->
                            <div class="col-md-6">
                                @if($booking->car)
                                    <h5 class="border-bottom pb-2 mb-3">Vehicle Details</h5>
                                    <div class="car-details p-3 bg-light rounded">
                                        <div class="text-center mb-3">
                                            @if($booking->car->images && $booking->car->images->count())
                                                <!-- Carousel for Images -->
                                                <div id="carImageCarouselSummary" class="carousel slide" data-bs-ride="carousel">
                                                    <div class="carousel-inner">
                                                        @foreach($booking->car->images as $key => $image)
                                                            <div class="carousel-item {{ $key == 0 ? 'active' : '' }}">
                                                                <img src="{{ asset($image->image_path) }}" alt="{{ $booking->car->maker }} {{ $booking->car->model }}" class="d-block mx-auto" style="max-height: 150px;">
                                                            </div>
                                                        @endforeach
                                                    </div>
                                                    <button class="carousel-control-prev" type="button" data-bs-target="#carImageCarouselSummary" data-bs-slide="prev">
                                                        <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                                                        <span class="visually-hidden">Previous</span>
                                                    </button>
                                                    <button class="carousel-control-next" type="button" data-bs-target="#carImageCarouselSummary" data-bs-slide="next">
                                                        <span class="carousel-control-next-icon" aria-hidden="true"></span>
                                                        <span class="visually-hidden">Next</span>
                                                    </button>
                                                </div>
                                            @elseif($booking->car->car_image)
                                                <img src="{{ asset($booking->car->car_image) }}" alt="{{ $booking->car->maker }} {{ $booking->car->model }}" class="img-fluid" style="max-height: 150px;">
                                            @else
                                                <div class="bg-secondary text-white p-4 rounded">
                                                    <i class="fas fa-car fa-3x"></i>
                                                </div>
                                            @endif
                                        </div>
                                        
                                        <h5 class="mb-3">{{ $booking->car->maker }} {{ $booking->car->model }}</h5>
                                        
                                        <!-- Basic Vehicle Information -->
                                        <div class="row mb-2">
                                            <div class="col-6">
                                                <p class="mb-1"><i class="fas fa-cog me-2"></i><small>Transmission:</small><br>
                                                <strong>{{ ucfirst($booking->car->transmission_type) }}</strong></p>
                                            </div>
                                            <div class="col-6">
                                                <p class="mb-1"><i class="fas fa-gas-pump me-2"></i><small>Fuel Type:</small><br>
                                                <strong>{{ ucfirst($booking->car->fuel_type) }}</strong></p>
                                            </div>
                                        </div>
                                        
                                        <div class="row mb-2">
                                            <div class="col-6">
                                                <p class="mb-1"><i class="fas fa-users me-2"></i><small>Seats:</small><br>
                                                <strong>{{ $booking->car->number_of_seats }} passengers</strong></p>
                                            </div>
                                            <div class="col-6">
                                                <p class="mb-1"><i class="fas fa-door-open me-2"></i><small>Doors:</small><br>
                                                <strong>{{ $booking->car->number_of_doors }} doors</strong></p>
                                            </div>
                                        </div>
                                        
                                        <!-- Luggage Capacity -->
                                        <div class="row mb-2">
                                            <div class="col-6">
                                                <p class="mb-1"><i class="fas fa-suitcase me-2"></i><small>Large Bags:</small><br>
                                                <strong>{{ $booking->car->large_bags_capacity }}</strong></p>
                                            </div>
                                            <div class="col-6">
                                                <p class="mb-1"><i class="fas fa-briefcase me-2"></i><small>Small Bags:</small><br>
                                                <strong>{{ $booking->car->small_bags_capacity }}</strong></p>
                                            </div>
                                        </div>
                                        
                                        <!-- Vehicle Features -->
                                        <div class="mb-3">
                                            <p class="mb-2"><strong>Features:</strong></p>
                                            <div class="d-flex flex-wrap gap-1">
                                                @if($booking->car->air_conditioning === 'Yes')
                                                    <span class="badge bg-success"><i class="fas fa-snowflake me-1"></i>AC</span>
                                                @endif
                                                @if($booking->car->backup_camera === 'Yes')
                                                    <span class="badge bg-success"><i class="fas fa-video me-1"></i>Backup Camera</span>
                                                @endif
                                                @if($booking->car->bluetooth === 'Yes')
                                                    <span class="badge bg-success"><i class="fas fa-bluetooth me-1"></i>Bluetooth</span>
                                                @endif
                                                @if($booking->car->air_conditioning === 'No' && $booking->car->backup_camera === 'No' && $booking->car->bluetooth === 'No')
                                                    <span class="text-muted">Basic features</span>
                                                @endif
                                            </div>
                                        </div>
                                        
                                        <!-- Vehicle Condition & Registration -->
                                        <div class="row mb-2">
                                            <div class="col-6">
                                                <p class="mb-1"><i class="fas fa-star me-2"></i><small>Condition:</small><br>
                                                <strong>{{ ucfirst($booking->car->car_condition) }}</strong></p>
                                            </div>
                                            <div class="col-6">
                                                <p class="mb-1"><i class="fas fa-id-card me-2"></i><small>Registration:</small><br>
                                                <strong>{{ $booking->car->registration_no }}</strong></p>
                                            </div>
                                        </div>
                                        
                                        <!-- Mileage Information -->
                                        @if($booking->car->mileage_limit || $booking->car->current_mileage)
                                        <div class="row mb-2">
                                            @if($booking->car->mileage_limit)
                                            <div class="col-6">
                                                <p class="mb-1"><i class="fas fa-road me-2"></i><small>Daily Limit:</small><br>
                                                <strong>{{ number_format($booking->car->mileage_limit) }} km</strong></p>
                                            </div>
                                            @endif
                                            @if($booking->car->current_mileage)
                                            <div class="col-6">
                                                <p class="mb-1"><i class="fas fa-tachometer-alt me-2"></i><small>Current Mileage:</small><br>
                                                <strong>{{ number_format($booking->car->current_mileage) }} km</strong></p>
                                            </div>
                                            @endif
                                        </div>
                                        @endif
                                        
                                        <!-- Vehicle Type -->
                                        <div class="mb-3">
                                            <p class="mb-1"><i class="fas fa-car me-2"></i><small>Vehicle Type:</small><br>
                                            <strong>{{ ucfirst($booking->car->vehicle_type) }}</strong></p>
                                        </div>
                                        
                                        <!-- Pricing Information -->
                                        <div class="mt-3 pt-3 border-top">
                                            <h6>Rental Rates:</h6>
                                            @if($booking->car->rate_per_day)
                                                <h4 class="text-primary">BTN {{ number_format($booking->car->rate_per_day, 2) }}/day</h4>
                                            @elseif($booking->car->price)
                                                <h4 class="text-primary">BTN {{ number_format($booking->car->price, 2) }}/day</h4>
                                            @endif
                                            
                                            @if($booking->car->price_per_km)
                                                <p class="mb-0 text-muted"><small>BTN {{ number_format($booking->car->price_per_km, 2) }}/km for excess mileage</small></p>
                                            @endif
                                        </div>
                                    </div>
                                @else
                                    <div class="alert alert-warning">
                                        Vehicle details not available
                                    </div>
                                @endif
                            </div>
                        </div>
                        
                        <!-- Price Summary -->
                        @if($booking->car)
                        @php
                            $hours = $booking->pickup_datetime->diffInHours($booking->dropoff_datetime);
                            $days = ceil($hours / 24); // Round up to full days for pricing
                            $dailyRate = $booking->car->rate_per_day ?? $booking->car->price ?? 0;
                            $insuranceFee = 200;
                            $serviceFee = 100;
                            $totalPrice = ($dailyRate * $days) + $insuranceFee + $serviceFee;
                        @endphp

                        <div class="row mt-4">
                            <div class="col-12">
                                <div class="card bg-light">
                                    <div class="card-body">
                                        <h5>Price Summary</h5>
                                        <div class="row">
                                            <div class="col-md-8">
                                                <p>{{ $days }} day{{ $days > 1 ? 's' : '' }} x BTN {{ number_format($dailyRate, 2) }}</p>
                                                <p>Insurance</p>
                                                <p>Service Fee</p>
                                               @if($booking->car->mileage_limit)
                                                    <p class="text-muted">
                                                        <small class="fw-bold">Daily mileage limit: {{ number_format($booking->car->mileage_limit) }} km</small>
                                                    </p>
                                                @endif


                                            </div>
                                            <div class="col-md-4 text-end">
                                                <p>BTN {{ number_format($dailyRate * $days, 2) }}</p>
                                                <p>BTN {{ number_format($insuranceFee, 2) }}</p>
                                                <p>BTN {{ number_format($serviceFee, 2) }}</p>
                                                @if($booking->car->price_per_km && $booking->car->mileage_limit)
                                                    <p class="text-muted"><small>BTN {{ number_format($booking->car->price_per_km, 2) }}/km excess</small></p>
                                                @endif
                                            </div>
                                        </div>
                                        <hr>
                                        <div class="row">
                                            <div class="col-md-8">
                                                <h5>Total</h5>
                                            </div>
                                            <div class="col-md-4 text-end">
                                                <h5>BTN {{ number_format($totalPrice, 2) }}</h5>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        @endif

                        <!-- Back to Home and Print Booking Buttons -->
                        <div class="row mt-4">
                            <div class="col-12">
                                <div class="d-flex justify-content-between">
                                    @auth('customer')
                                        {{-- Only show Pay Now button if booking is still pending and no payment method set --}}
                                        @if($booking->status === 'pending' && !$booking->payment_method)
                                            @if(auth('customer')->user()->drivingLicense)
                                                <a href="{{ route('payment.page', ['bookingId' => $booking->id]) }}" class="btn btn-success">
                                                    <i class="fas fa-credit-card me-2"></i>Pay Now
                                                </a>
                                            @else
                                                <!-- Show verification prompt -->
                                                <div class="alert alert-warning w-100 text-center mb-0 me-3">
                                                    <div class="d-flex flex-column align-items-center">
                                                        <h5>Please upload your documents to get your profile verified!</h5>
                                                        <p class="mb-3">Your Profile is not verified.</p>
                                                        <a href="{{ route('customer.profile') }}" class="btn btn-primary">
                                                            <i class="fas fa-upload me-2"></i>Upload Driving License
                                                        </a>
                                                    </div>
                                                </div>
                                            @endif
                                        @elseif($booking->status === 'pending_verification')
                                            <div class="alert alert-success w-100 text-center mb-0 me-3">
                                                <i class="fas fa-check-circle me-2"></i>
                                                Payment submitted successfully! Your booking will be confirmed once payment is verified.
                                            </div>
                                        @elseif($booking->status === 'confirmed')
                                            <div class="alert alert-success w-100 text-center mb-0 me-3">
                                                <i class="fas fa-check-circle me-2"></i>
                                                Your booking is confirmed! We'll contact you before the pickup time.
                                            </div>
                                        @endif
                                    @endauth
                                    
                                    <a href="#" class="btn btn-primary me-3" onclick="window.print()">
                                        <i class="fas fa-print me-2"></i>Print Booking
                                    </a>
                                    <a href="{{ route('home') }}" class="btn btn-primary">Browse Cars</a>
                                </div>
                            </div>
                        </div>

                    @else
                        <div class="alert alert-warning">
                            <h5>No booking information found!</h5>
                            <p>It seems like there's no booking information available. Please try booking a car first.</p>
                            <a href="{{ route('home') }}" class="btn btn-primary mt-3">Browse Cars</a>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        var carCarouselSummary = new bootstrap.Carousel(document.getElementById('carImageCarouselSummary'), {
            interval: 3000,
            ride: 'carousel'
        });
    });
</script>
@endsection