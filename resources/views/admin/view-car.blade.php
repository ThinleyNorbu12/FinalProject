@extends('layouts.admin')

@section('title', 'Car Details')

@section('breadcrumbs')
    <li class="breadcrumb-item">
        <a href="{{ route('car-admin.new-registration-cars') }}">Car Registration</a>
    </li>
    <li class="breadcrumb-item active">Car Details</li>
@endsection

@section('page-header')
    <div class="d-flex justify-content-between align-items-center">
        <div>
            <h1 class="page-title">Car Details</h1>
            <p class="page-subtitle">Review and manage car registration details</p>
        </div>
        <div class="page-actions">
            <a href="{{ route('car-admin.new-registration-cars') }}" class="btn btn-outline-secondary">
                <i class="fas fa-arrow-left me-2"></i>Back to List
            </a>
        </div>
    </div>
@endsection

@push('styles')
<link rel="stylesheet" href="{{ asset('assets/css/admin/view-car.css') }}">
@endpush

@section('content')
<div class="container-fluid">
    <div class="car-details-container">
        <!-- Car Image Section -->
        <div class="car-image-section">
            <div class="car-image-wrapper">
                @if($car->car_image)
                    <img src="{{ asset($car->car_image) }}" alt="Car Image" class="car-image">
                @else
                    <div class="no-image-placeholder">
                        <i class="fas fa-car fa-3x mb-3"></i>
                        <p class="mb-0">No image available</p>
                    </div>
                @endif
            </div>
        </div>

        <!-- Car Information Section -->
        <div class="car-info-section">
            <div class="info-grid">
                <div class="info-card">
                    <div class="info-label">Car Maker</div>
                    <p class="info-value">{{ $car->maker }}</p>
                </div>

                <div class="info-card">
                    <div class="info-label">Model</div>
                    <p class="info-value">{{ $car->model }}</p>
                </div>

                <div class="info-card">
                    <div class="info-label">Vehicle Type</div>
                    <p class="info-value">{{ $car->vehicle_type }}</p>
                </div>

                <div class="info-card">
                    <div class="info-label">Condition</div>
                    <p class="info-value">{{ $car->car_condition }}</p>
                </div>

                {{-- <div class="info-card">
                    <div class="info-label">Mileage</div>
                    <p class="info-value">{{ number_format($car->mileage) }} km</p>
                </div>

                <div class="info-card">
                    <div class="info-label">Price per Day</div>
                    <p class="info-value price-highlight">BTN {{ number_format($car->price, 2) }}</p>
                </div> --}}

                <div class="info-card">
                    <div class="info-label">Registration Number</div>
                    <p class="info-value">{{ $car->registration_no }}</p>
                </div>

                <div class="info-card">
                    <div class="info-label">Status</div>
                    <span class="status-badge status-{{ strtolower($car->status) }}">
                        <i class="fas fa-circle me-1" style="font-size: 0.5rem;"></i>
                        {{ $car->status }}
                    </span>
                </div>
            </div>

            @if($car->description)
                <div class="description-card">
                    <div class="info-label mb-2">Description</div>
                    <p class="description-text">{{ $car->description }}</p>
                </div>
            @endif
        </div>

        <!-- Action Buttons -->
        <div class="action-buttons">
            <form action="{{ route('car-admin.admin.requestInspection', ['car' => $car->id]) }}" method="GET" class="d-inline">
                <button type="submit" class="btn-action btn-primary-action">
                    <i class="fas fa-clipboard-check"></i>
                    Request Inspection
                </button>
            </form>

            <form action="{{ route('car-admin.showRejectForm', ['car' => $car->id]) }}" method="GET" class="d-inline">
                <button type="submit" class="btn-action btn-danger-action">
                    <i class="fas fa-times-circle"></i>
                    Reject Application
                </button>
            </form>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    // Add any additional JavaScript functionality here
    document.addEventListener('DOMContentLoaded', function() {
        // Add smooth scrolling or other interactions if needed
        console.log('Car details page loaded');
    });
</script>
@endpush