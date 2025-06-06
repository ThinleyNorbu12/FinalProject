@extends('layouts.carowner')

@section('title', 'Edit Inspection Date & Time')

@section('breadcrumbs')
    <li class="breadcrumb-item">
        <a href="{{ route('carowner.car-inspection') }}">Inspection Requests</a>
    </li>
    <li class="breadcrumb-item active">Edit Date/Time</li>
@endsection
@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title mb-0">
                        <i class="fas fa-edit me-2"></i>
                        Edit Inspection Date & Time
                    </h4>
                </div>
                <div class="card-body">
                    @if ($errors->any())
                        <div class="alert alert-danger alert-dismissible fade show" role="alert">
                            <i class="fas fa-exclamation-circle me-2"></i>
                            <strong>Please fix the following errors:</strong>
                            <ul class="mb-0 mt-2">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                        </div>
                    @endif

                    <!-- Current Inspection Details -->
                    <div class="row mb-4">
                        <div class="col-12">
                            <div class="alert alert-info">
                                <i class="fas fa-info-circle me-2"></i>
                                <strong>Current Inspection Details:</strong>
                                <div class="mt-2">
                                    <div class="row">
                                        <div class="col-md-6">
                                            <strong>Date:</strong> {{ \Carbon\Carbon::parse($request->inspection_date)->format('F j, Y') }}
                                        </div>
                                        <div class="col-md-6">
                                            <strong>Time:</strong> {{ $request->inspection_time }}
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <form method="POST" action="{{ route('inspection.updatedatetime', $request->id) }}" id="inspectionForm">
                        @csrf
                        
                        <div class="row g-3">
                            <div class="col-md-6">
                                <label for="inspection_date" class="form-label">
                                    <i class="fas fa-calendar me-2"></i>
                                    Inspection Date <span class="text-danger">*</span>
                                </label>
                                <input type="date" 
                                       name="inspection_date" 
                                       id="inspection_date" 
                                       class="form-control @error('inspection_date') is-invalid @enderror" 
                                       value="{{ $request->inspection_date }}" 
                                       min="{{ date('Y-m-d') }}"
                                       required>
                                @error('inspection_date')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                                <div class="form-text">
                                    <i class="fas fa-info-circle me-1"></i>
                                    Please select a date from today onwards
                                </div>
                            </div>

                            <div class="col-md-6">
                                <label for="inspection_time" class="form-label">
                                    <i class="fas fa-clock me-2"></i>
                                    Inspection Time <span class="text-danger">*</span>
                                </label>
                                <select name="inspection_time" 
                                        id="inspection_time" 
                                        class="form-select @error('inspection_time') is-invalid @enderror" 
                                        required>
                                    <option selected disabled>Select Time Slot</option>
                                    @foreach($timeSlots as $slot)
                                        <option value="{{ $slot }}" {{ $slot == $request->inspection_time ? 'selected' : '' }}>
                                            {{ $slot }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('inspection_time')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                                <div class="form-text">
                                    <i class="fas fa-info-circle me-1"></i>
                                    Available time slots will update based on selected date
                                </div>
                                
                                <!-- Loading indicator -->
                                <div id="loading" class="text-center mt-2" style="display: none;">
                                    <div class="spinner-border spinner-border-sm text-primary" role="status">
                                        <span class="visually-hidden">Loading...</span>
                                    </div>
                                    <span class="ms-2 text-muted">Loading available slots...</span>
                                </div>
                            </div>
                        </div>

                        <!-- Action Buttons -->
                        <div class="row mt-4">
                            <div class="col-12">
                                <div class="d-flex justify-content-end gap-3">
                                    <button type="button" class="btn btn-secondary" onclick="history.back()">
                                        <i class="fas fa-arrow-left me-2"></i>
                                        Cancel
                                    </button>
                                    <button type="submit" class="btn btn-primary" id="submitBtn">
                                        <i class="fas fa-save me-2"></i>
                                        Update Inspection
                                    </button>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('styles')
<style>
    .card {
        box-shadow: 0 0 20px rgba(0,0,0,0.1);
        border: none;
        border-radius: 12px;
    }

    .card-header {
        background: linear-gradient(135deg, #28a745 0%, #20c997 100%);
        color: white;
        border-radius: 12px 12px 0 0 !important;
        padding: 20px;
    }

    .form-label {
        font-weight: 500;
        color: #495057;
        margin-bottom: 8px;
    }

    .form-control, .form-select {
        border-radius: 8px;
        border: 1px solid #dee2e6;
        padding: 12px 16px;
        transition: all 0.2s ease;
    }

    .form-control:focus, .form-select:focus {
        border-color: #28a745;
        box-shadow: 0 0 0 0.2rem rgba(40, 167, 69, 0.25);
    }

    .btn {
        border-radius: 8px;
        padding: 12px 24px;
        font-weight: 500;
        transition: all 0.2s ease;
    }

    .btn:hover {
        transform: translateY(-2px);
        box-shadow: 0 4px 12px rgba(0,0,0,0.15);
    }

    .alert {
        border-radius: 8px;
        border: none;
    }

    .form-text {
        font-size: 0.875em;
        color: #6c757d;
    }

    #loading {
        animation: fadeIn 0.3s ease;
    }

    @keyframes fadeIn {
        from { opacity: 0; }
        to { opacity: 1; }
    }

    .text-danger {
        font-size: 0.875em;
    }

    .alert-info {
        background-color: #e7f3ff;
        border-left: 4px solid #0dcaf0;
    }

    .alert-danger {
        background-color: #f8d7da;
        border-left: 4px solid #dc3545;
    }
</style>
@endpush

@push('scripts')
<script>
$(document).ready(function() {
    const dateInput = $('#inspection_date');
    const timeSelect = $('#inspection_time');
    const loadingIndicator = $('#loading');
    const submitBtn = $('#submitBtn');
    
    // Handle date change
    dateInput.on('change', function() {
        const date = $(this).val();
        const id = {{ $request->id }};
        
        if (!date) return;
        
        // Show loading indicator
        loadingIndicator.show();
        timeSelect.prop('disabled', true);
        
        // Clear current options
        timeSelect.empty().append('<option disabled selected>Loading...</option>');
        
        $.ajax({
            url: '{{ route('inspection.available-slots') }}',
            method: 'GET',
            data: { 
                date: date, 
                id: id 
            },
            success: function(slots) {
                timeSelect.empty();
                
                if (slots && slots.length > 0) {
                    timeSelect.append('<option disabled selected>Select Time Slot</option>');
                    slots.forEach(function(slot) {
                        timeSelect.append(`<option value="${slot}">${slot}</option>`);
                    });
                } else {
                    timeSelect.append('<option disabled selected>No slots available for this date</option>');
                }
                
                // Show success animation
                timeSelect.addClass('border-success');
                setTimeout(() => {
                    timeSelect.removeClass('border-success');
                }, 2000);
            },
            error: function(xhr, status, error) {
                console.error('Error loading time slots:', error);
                timeSelect.empty().append('<option disabled selected>Error loading slots</option>');
                
                // Show error notification
                showNotification('Failed to load available time slots. Please try again.', 'error');
            },
            complete: function() {
                loadingIndicator.hide();
                timeSelect.prop('disabled', false);
            }
        });
    });
    
    // Form validation
    $('#inspectionForm').on('submit', function(e) {
        const date = dateInput.val();
        const time = timeSelect.val();
        
        if (!date || !time) {
            e.preventDefault();
            showNotification('Please select both date and time for the inspection.', 'warning');
            return false;
        }
        
        // Show loading state on submit button
        submitBtn.prop('disabled', true).html('<i class="fas fa-spinner fa-spin me-2"></i>Updating...');
    });
    
    // Utility function to show notifications
    function showNotification(message, type = 'info') {
        const alertClass = type === 'error' ? 'alert-danger' : 
                          type === 'warning' ? 'alert-warning' : 
                          type === 'success' ? 'alert-success' : 'alert-info';
        
        const icon = type === 'error' ? 'fas fa-exclamation-circle' : 
                    type === 'warning' ? 'fas fa-exclamation-triangle' : 
                    type === 'success' ? 'fas fa-check-circle' : 'fas fa-info-circle';
        
        const notification = $(`
            <div class="alert ${alertClass} alert-dismissible fade show" role="alert">
                <i class="${icon} me-2"></i>
                ${message}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        `);
        
        // Remove existing notifications
        $('.alert:not(.alert-info)').fadeOut(300, function() {
            $(this).remove();
        });
        
        // Add new notification
        $('.card-body').prepend(notification);
        
        // Auto-dismiss after 5 seconds
        setTimeout(() => {
            notification.fadeOut(300, function() {
                $(this).remove();
            });
        }, 5000);
    }
    
    // Add date validation
    const today = new Date().toISOString().split('T')[0];
    dateInput.attr('min', today);
    
    // Highlight current values
    if (dateInput.val() && timeSelect.val()) {
        dateInput.addClass('border-primary');
        timeSelect.addClass('border-primary');
    }
});
</script>
@endpush