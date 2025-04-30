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
                                <p><strong>Booking Date:</strong> {{ $booking->created_at->format('M d, Y') }}</p>
                                <p><strong>Status:</strong> 
                                    <span class="badge bg-success">Confirmed</span>
                                </p>
                                
                                <h5 class="border-bottom pb-2 mb-3 mt-4">Trip Details</h5>
                                <div class="row">
                                    <div class="col-md-6">
                                        <p><strong>Pick-up:</strong></p>
                                        <p>{{ $booking->pickup_location }}</p>
                                        <p>{{ \Carbon\Carbon::parse($booking->pickup_date)->format('M d, Y') }}</p>
                                    </div>
                                    <div class="col-md-6">
                                        <p><strong>Drop-off:</strong></p>
                                        <p>{{ $booking->dropoff_location }}</p>
                                        <p>{{ \Carbon\Carbon::parse($booking->dropoff_date)->format('M d, Y') }}</p>
                                    </div>
                                </div>
                                
                                <div class="mt-4">
                                    <p><strong>Duration:</strong> 
                                        {{ \Carbon\Carbon::parse($booking->pickup_date)->diffInDays(\Carbon\Carbon::parse($booking->dropoff_date)) + 1 }} days
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
                                        
                                        <h5 class="mb-2">{{ $booking->car->maker }} {{ $booking->car->model }}</h5>
                                        <p class="mb-1"><i class="fas fa-cog me-2"></i> {{ $booking->car->transmission_type }}</p>
                                        <p class="mb-1"><i class="fas fa-gas-pump me-2"></i> {{ $booking->car->fuel_type }}</p>
                                        <p class="mb-1"><i class="fas fa-users me-2"></i> {{ $booking->car->number_of_seats }} seats</p>
                                        
                                        <div class="mt-3 pt-3 border-top">
                                            <h6>Daily Rate:</h6>
                                            <h4>Nu. {{ number_format($booking->car->price, 2) }}/day</h4>
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
                        <!-- Price Summary -->
                        @if($booking->car)
                        @php
                            $days = \Carbon\Carbon::parse($booking->pickup_date)->diffInDays(\Carbon\Carbon::parse($booking->dropoff_date)) + 1;
                            $dailyRate = $booking->car->price;
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
                                                <p>{{ $days }} days x Nu. {{ number_format($dailyRate, 2) }}</p>
                                                <p>Insurance</p>
                                                <p>Service Fee</p>
                                            </div>
                                            <div class="col-md-4 text-end">
                                                <p>Nu. {{ number_format($dailyRate * $days, 2) }}</p>
                                                <p>Nu. {{ number_format($insuranceFee, 2) }}</p>
                                                <p>Nu. {{ number_format($serviceFee, 2) }}</p>
                                            </div>
                                        </div>
                                        <hr>
                                        <div class="row">
                                            <div class="col-md-8">
                                                <h5>Total</h5>
                                            </div>
                                            <div class="col-md-4 text-end">
                                                <h5>Nu. {{ number_format($totalPrice, 2) }}</h5>
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
                                    {{-- <a href="{{ route('home') }}" class="btn btn-secondary">
                                        <i class="fas fa-arrow-left me-2"></i>Back to Home
                                    </a> --}}
                                    {{-- <a href="{{ route('home') }}" class="btn btn-secondary">
                                        Continue <i class="fas fa-arrow-right ms-2"></i>
                                    </a> --}}
                                    
                                    <a href="{{ route('payment.page') }}" class="btn btn-success">
                                        <i class="fas fa-credit-card me-2"></i>Pay Now
                                    </a>                                    
                                    <a href="#" class="btn btn-primary" onclick="window.print()">
                                        <i class="fas fa-print me-2"></i>Print Booking
                                    </a>
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
