@extends('layouts.app')

@section('content')
    <div class="container">
        {{-- Car Image
        @if($car->car_image)
            <div class="mb-3">
                <img src="{{ asset($car->car_image) }}" alt="Car Image" style="width: 200px; height: auto;">
            </div>
        @else
            <p>No image available</p>
        @endif --}}
         {{-- Car Images --}}
         @if($car->images && count($car->images))
         <div class="mb-3 d-flex flex-wrap gap-2">
             @foreach($car->images as $image)
                 <div>
                     <img src="{{ asset($image->image_path) }}" alt="Car Image" style="width: 200px; height: auto;">
                 </div>
             @endforeach
         </div>
         @else
         <p>No images available</p>
         @endif
    

        {{-- Car Information --}}
        <div class="car-details">
            <p><strong>Car Maker:</strong> {{ $car->maker }}</p>
            <p><strong>Model:</strong> {{ $car->model }}</p>
            <p><strong>Vehicle Type:</strong> {{ $car->vehicle_type }}</p>
            <p><strong>Condition:</strong> {{ $car->car_condition }}</p>
            <p><strong>Mileage:</strong> {{ $car->mileage }} km</p>
            <p><strong>Price per Day:</strong> ${{ $car->price }} per day</p>
            <p><strong>Registration Number:</strong> {{ $car->registration_no }}</p>
            <p><strong>Status:</strong> {{ $car->status }}</p>
            <p><strong>Description:</strong> {{ $car->description }}</p>
        </div>

        <hr>

        {{-- Booking Form --}}
        <h3>Book this Car</h3>
        {{-- <form action="{{ route('submit.booking', $car->id) }}" method="POST"> --}}
            @csrf
            <div class="mb-3">
                <label for="name" class="form-label">Full Name:</label>
                <input type="text" class="form-control" name="name" required>
            </div>

            <div class="mb-3">
                <label for="email" class="form-label">Email Address:</label>
                <input type="email" class="form-control" name="email" required>
            </div>

            <div class="mb-3">
                <label for="pickup_date" class="form-label">Pickup Date:</label>
                <input type="date" class="form-control" name="pickup_date" required>
            </div>

            <div class="mb-3">
                <label for="return_date" class="form-label">Return Date:</label>
                <input type="date" class="form-control" name="return_date" required>
            </div>

            <button type="submit" class="btn btn-primary">Confirm Booking</button>
        </form>
    </div>
@endsection
