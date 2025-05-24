@extends('layouts.admin')

@section('title', 'Reject Vehicle Registration')

@section('breadcrumbs')
    <li class="breadcrumb-item">
        <a href="{{ route('car-admin.new-registration-cars') }}">Car Registration</a>
    </li>
    <li class="breadcrumb-item active">Reject Vehicle</li>
@endsection

@section('page-header')
    <div class="d-flex justify-content-between align-items-center">
        <h1 class="page-title">
            <i class="fas fa-times-circle me-2"></i>
            Reject Vehicle Registration
        </h1>
    </div>
@endsection

@section('content')
<div class="container mt-4">
    <div class="row justify-content-center">
        <div class="col-md-8">
            {{-- Vehicle Details Card --}}
            <div class="card shadow mb-4">
                <div class="card-header bg-danger text-white">
                    <h5 class="card-title mb-0"><i class="fas fa-car me-2"></i>Vehicle Information</h5>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6">
                            <p><strong>Maker:</strong> {{ $car->maker }}</p>
                            <p><strong>Model:</strong> {{ $car->model }}</p>
                        </div>
                        <div class="col-md-6">
                            <p><strong>Registration #:</strong> <code>{{ $car->registration_no }}</code></p>
                            <p><strong>Submitted By:</strong> {{ optional($car->owner)->name ?? 'Unknown Owner' }}</p>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Rejection Form Card --}}
            <div class="card shadow">
                <div class="card-header bg-danger text-white">
                    <h5 class="card-title mb-0"><i class="fas fa-comment-dots me-2"></i>Rejection Details</h5>
                </div>
                <div class="card-body">
                    <form action="{{ route('car-admin.rejectCar', $car->id) }}" method="POST" id="rejectionForm">
                        @csrf

                        <div class="mb-4">
                            <label for="rejection_reason" class="form-label fw-bold">
                                Reason for Rejection <span class="text-danger">*</span>
                            </label>
                            <textarea name="rejection_reason" 
                                    id="rejection_reason" 
                                    class="form-control @error('rejection_reason') is-invalid @enderror" 
                                    rows="5"
                                    placeholder="Provide detailed reason for rejection..."
                                    required
                                    minlength="10"></textarea>
                            
                            @error('rejection_reason')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @else
                                <div class="form-text">Minimum 10 characters required</div>
                            @enderror
                        </div>

                        <div class="d-flex justify-content-between align-items-center">
                            <a href="{{ url()->previous() }}" class="btn btn-outline-secondary">
                                <i class="fas fa-arrow-left me-2"></i>
                                Back to Details
                            </a>
                            
                            <button type="button" 
                                    class="btn btn-danger" 
                                    onclick="confirmRejection()">
                                <i class="fas fa-times-circle me-2"></i>
                                Confirm Rejection
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
function confirmRejection() {
    const reason = document.getElementById('rejection_reason').value;
    const form = document.getElementById('rejectionForm');
    
    // Client-side validation
    if (reason.length < 10) {
        alert('Please provide at least 10 characters for the rejection reason.');
        return;
    }

    if (confirm('Are you absolutely sure you want to reject this registration?\n\nThis action cannot be undone.')) {
        form.submit();
    }
}

// Bootstrap validation
(function () {
  'use strict'
  const forms = document.querySelectorAll('#rejectionForm')
  Array.from(forms).forEach(form => {
    form.addEventListener('submit', event => {
      if (!form.checkValidity()) {
        event.preventDefault()
        event.stopPropagation()
      }
      form.classList.add('was-validated')
    }, false)
  })
})()
</script>
@endpush