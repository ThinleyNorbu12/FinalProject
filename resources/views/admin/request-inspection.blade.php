@extends('layouts.app') {{-- Update to your actual layout file if different --}}

@section('content')
<div class="container mt-4">
    <h2 class="mb-4">Request for Car Inspection</h2>

    {{-- Display success message --}}
    @if(session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    {{-- Car Information --}}
    <div class="card mb-4">
        <div class="card-header bg-primary text-white">
            Car Details
        </div>
        <div class="card-body">
            <p><strong>ID:</strong> {{ $car->id }}</p>
            <p><strong>Make:</strong> {{ $car->make }}</p>
            <p><strong>Model:</strong> {{ $car->model }}</p>
            <p><strong>Year:</strong> {{ $car->year }}</p>
            <p><strong>Color:</strong> {{ $car->color }}</p>
            {{-- Add any additional car info here --}}
        </div>
    </div>

    {{-- Inspection Request Form --}}
    <form action="{{ url('car-admin/submit-inspection-request/' . $car->id) }}" method="POST">
        @csrf

        <div class="form-group mb-3">
            <label for="preferred_date">Preferred Inspection Date</label>
            <input type="date" name="preferred_date" class="form-control" required>
        </div>

        <div class="form-group mb-3">
            <label for="notes">Additional Notes (optional)</label>
            <textarea name="notes" class="form-control" rows="4" placeholder="Enter any special instructions..."></textarea>
        </div>

        <button type="submit" class="btn btn-success">Submit Inspection Request</button>
    </form>
</div>
@endsection
