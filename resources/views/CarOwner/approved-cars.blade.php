@extends('layouts.app') <!-- or your layout -->

@section('content')
    <div class="container">
        <h2>Approved Cars</h2>
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>Sl. No</th>
                    <th>Maker</th>
                    <th>Model</th>
                    <th>Vehicle Type</th>
                    <th>Condition</th>
                    <th>Price</th>
                    <th>Registration No</th>
                </tr>
            </thead>
            <tbody>
                @forelse($approvedCars as $car)
                    <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td>{{ $car->maker }}</td>
                        <td>{{ $car->model }}</td>
                        <td>{{ $car->vehicle_type }}</td>
                        <td>{{ $car->car_condition }}</td>
                        <td>{{ $car->price }}</td>
                        <td>{{ $car->registration_no }}</td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6">No approved cars found.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
@endsection
