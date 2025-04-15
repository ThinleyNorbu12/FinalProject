@extends('layouts.app')

@section('content')
    <div class="container">
        <h1>Reject Car</h1>
        <p>Car: {{ $car->maker }} {{ $car->model }}</p>
        <p>Registration No: {{ $car->registration_no }}</p>

        {{-- Rejection Form --}}
        <form action="{{ route('car-admin.rejectCar', $car->id) }}" method="POST">
            @csrf
            <div class="form-group">
                <label for="rejection_reason">Reason for Rejection</label>
                <textarea name="rejection_reason" id="rejection_reason" rows="4" class="form-control" required></textarea>
            </div>
            <button type="submit" class="btn btn-danger mt-3">Submit Rejection</button>
        </form>
    </div>
@endsection
