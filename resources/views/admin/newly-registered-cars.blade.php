@extends('layouts.app')

@section('content')

<link rel="stylesheet" href="{{ asset('assets/css/admin/newly-registered-cars.css') }}">
    <div class="container">
        <h1>Car Registration Request</h1>

        @if($cars->isEmpty())
            <p>No cars found.</p>
        @else
            <table class="table">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Maker</th>
                        <th>Model</th>
                        <th>Vehicle Type</th>
                        <th>Price per Day</th>
                        <th>Registration Number</th>
                        <th>Status</th>
                        <th>Car Image</th> <!-- Image Column -->
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($cars as $car)
                        <tr>
                            <td>{{ $car->id }}</td>
                            <td>{{ $car->maker }}</td>
                            <td>{{ $car->model }}</td>
                            <td>{{ $car->vehicle_type }}</td>
                            <td>{{ $car->price }}</td>
                            <td>{{ $car->registration_no }}</td>
                            <td>{{ $car->status }}</td>
                            <td>
                                <!-- Display Car Image -->
                                @if($car->car_image)
                                    <img src="{{ asset($car->car_image) }}" alt="Car Image" style="width: 100px; height: auto;">
                                @else
                                    <p>No image</p>
                                @endif
                            </td>
                            <td>
                                @if(strtolower($car->status) === 'rejected')
                                    <span class="text-danger">Rejected</span>
                                @else
                                    <a href="{{ route('car-admin.view-car', $car->id) }}" class="btn btn-info">View</a>
                                @endif
                            </td>                            
                        </tr>
                    @endforeach
                </tbody>
            </table>
        @endif
    </div>
@endsection
