@extends('layouts.app')

<!-- Font Awesome CDN -->
<link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" rel="stylesheet">

@section('content')
<section class="cars" style="padding: 20px;">
    <h2 style="text-align: center; margin-bottom: 20px;">Available Cars</h2>

    <!-- Styled Rental Details Summary -->
    <div style="display: flex; justify-content: space-between; align-items: center; border-bottom: 1px solid #ccc; padding: 15px 0; margin-bottom: 20px;">
        <div style="display: flex; gap: 50px;">
            <!-- Pickup Info -->
            <div>
                <div style="color: red; font-weight: bold;">Pick-Up</div>
                <div style="font-size: 14px;">Your Location or Branch Name</div>
                <div style="font-weight: bold;">
                    {{ \Carbon\Carbon::parse(request('pickup_date') . ' ' . request('pickup_time'))->format('D, M d, h:i A') }}
                </div>
            </div>

            <!-- Return Info -->
            <div>
                <div style="color: red; font-weight: bold;">Return</div>
                <div style="font-size: 14px;">Your Location or Branch Name</div>
                <div style="font-weight: bold;">
                    {{ \Carbon\Carbon::parse(request('dropoff_date') . ' ' . request('dropoff_time'))->format('D, M d, h:i A') }}
                </div>
            </div>
        </div>

        <!-- Modify Link -->
        <div>
            <a href="{{ url('/') }}" style="color: red; text-decoration: none; font-weight: bold;">
                <i class="fas fa-pencil-alt" style="margin-right: 5px;"></i>Modify Rental Details
            </a>
        </div>
    </div>

    <!-- Available Cars Listing -->
    <div class="car-container" style="display: flex; flex-wrap: wrap; gap: 20px; justify-content: center;">
        @if($availableCars->count())
            @foreach($availableCars as $car)
                <div class="car" 
                     data-price="{{ $car->price }}" 
                     data-mileage="{{ $car->mileage }}" 
                     data-seats="{{ $car->number_of_seats }}"
                     style="border: 1px solid #ccc; padding: 15px; width: 250px; border-radius: 10px; text-align: center;">
                    <a href="javascript:void(0)" class="car-image-link" data-car-id="{{ $car->id }}">
                        <img src="{{ asset($car->car_image) }}" alt="{{ $car->model }}" style="width: 100%; height: auto; border-radius: 5px;">
                    </a>
                    <h3 style="margin-top: 10px;">{{ $car->maker }} {{ $car->model }}</h3>
                    <p>{{ $car->price }}/day</p>
                </div>
            @endforeach
        @else
            <p style="text-align: center; font-size: 18px;">No cars available for the selected dates.</p>
        @endif
    </div>
</section>
@endsection
