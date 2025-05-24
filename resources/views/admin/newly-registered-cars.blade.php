@extends('layouts.admin')

@section('title', 'Car Registration')

@section('breadcrumbs')
    <li class="breadcrumb-item active">Car Registration</li>
@endsection

@section('page-header')
    <div class="d-flex justify-content-between align-items-center">
        <h1 class="page-title">
            <i class="fas fa-car me-2"></i>
            Car Registration Request
        </h1>
        <div class="page-actions">
            <!-- Add any action buttons here if needed -->
        </div>
    </div>
@endsection

@push('styles')
<link rel="stylesheet" href="{{ asset('assets/css/admin/newly-registered-cars.css') }}">
@endpush

@section('content')
<div class="container-fluid">
    @if($cars->isEmpty())
        <div class="card">
            <div class="card-body">
                <div class="empty-message">
                    <i class="fas fa-car fa-3x mb-3" style="color: #ccc;"></i>
                    <h4>No Car Registration Requests</h4>
                    <p class="mb-0">There are currently no car registration requests to review.</p>
                </div>
            </div>
        </div>
    @else
        <div class="card">
            <div class="card-header">
                <h5 class="card-title mb-0">
                    <i class="fas fa-list me-2"></i>
                    Registration Requests ({{ $cars->count() }})
                </h5>
            </div>
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-hover mb-0">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Maker</th>
                                <th>Model</th>
                                <th>Vehicle Type</th>
                                <th>Price per Day</th>
                                <th>Registration Number</th>
                                <th>Status</th>
                                <th>Car Image</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($cars as $car)
                                <tr>
                                    <td>
                                        <span class="fw-medium">#{{ $car->id }}</span>
                                    </td>
                                    <td>{{ $car->maker }}</td>
                                    <td>{{ $car->model }}</td>
                                    <td>
                                        <span class="badge bg-secondary">{{ $car->vehicle_type }}</span>
                                    </td>
                                    <td>
                                        <span class="fw-medium text-success">${{ number_format($car->price, 2) }}</span>
                                    </td>
                                    <td>
                                        <code>{{ $car->registration_no }}</code>
                                    </td>
                                    <td>
                                        <span class="status-{{ strtolower($car->status) }}">
                                            {{ ucfirst($car->status) }}
                                        </span>
                                    </td>
                                    <td>
                                        @if($car->car_image)
                                            <img src="{{ asset($car->car_image) }}" alt="Car Image" class="img-thumbnail">
                                        @else
                                            <span class="text-muted">
                                                <i class="fas fa-image"></i> No image
                                            </span>
                                        @endif
                                    </td>
                                    <td>
                                        @if(strtolower($car->status) === 'rejected')
                                            <span class="text-danger">
                                                <i class="fas fa-times-circle me-1"></i>
                                                Rejected
                                            </span>
                                        @else
                                            <a href="{{ route('car-admin.view-car', $car->id) }}" class="btn btn-info btn-sm">
                                                <i class="fas fa-eye"></i> View
                                            </a>
                                        @endif
                                    </td>                            
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        
        {{-- Pagination if needed --}}
        @if(method_exists($cars, 'links'))
            <div class="d-flex justify-content-center mt-4">
                {{ $cars->links() }}
            </div>
        @endif
    @endif
</div>
@endsection

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Add any page-specific JavaScript here
        
        // Example: Add confirmation for view actions
        document.querySelectorAll('.btn-info').forEach(button => {
            button.addEventListener('click', function(e) {
                // You can add confirmation dialog here if needed
                console.log('Viewing car details...');
            });
        });
        
        // Example: Auto-refresh every 30 seconds for real-time updates
        // setInterval(function() {
        //     window.location.reload();
        // }, 30000);
    });
</script>
@endpush