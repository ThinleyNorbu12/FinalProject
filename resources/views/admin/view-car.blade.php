@extends('layouts.app')

@section('content')
    <div class="container">
        <h1>Car Details</h1>

        {{-- Car Image --}}
        @if($car->car_image)
            <div class="mb-3">
                <img src="{{ asset($car->car_image) }}" alt="Car Image" style="width: 200px; height: auto;">
            </div>
        @else
            <p>No image available</p>
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

        {{-- Car Owner Information
        <div class="car-owner-info mt-4">
            <h4>Registered By:</h4>
            @if($car->owner)
                <p><strong>Name:</strong> {{ $car->owner->name }}</p>
                <p><strong>Email:</strong> {{ $car->owner->email }}</p>
            @else
                <p>Unknown Owner</p>
            @endif
        </div> --}}

        {{-- Admin Actions --}}
        <div class="car-actions mt-4">
            <form action="{{ route('car-admin.admin.requestInspection', ['car' => $car->id]) }}" method="GET" class="d-inline">
                <button type="submit" class="btn btn-primary">Request for Inspection</button>
            </form>

            {{-- Reject Button that redirects to the rejection form --}}
            <form action="{{ route('car-admin.showRejectForm', ['car' => $car->id]) }}" method="GET" class="d-inline">
                <button type="submit" class="btn btn-danger">Reject</button>
            </form>
            
        </div>
    </div>
@endsection
