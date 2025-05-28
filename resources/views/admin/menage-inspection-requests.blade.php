@extends('layouts.admin')

@section('title', 'Rescheduled Inspection Requests')

@section('breadcrumbs')
    <li class="breadcrumb-item active">Inspection Requests</li>
@endsection

@section('page-header')
    <div class="d-flex justify-content-between align-items-center">
        <div>
            <h1 class="page-title">Inspection Requests</h1>
            <p class="page-subtitle">Manage and confirm rescheduled inspection appointments</p>
        </div>
    </div>
@endsection

@push('styles')
    <link rel="stylesheet" href="{{ asset('assets/css/admin/menage-inspection-requests.css') }}">
@endpush

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            @if($inspectionRequests->count() > 0)
                <div class="table-responsive">
                    <table class="table table-bordered align-middle text-center">
                        <thead class="table-dark">
                            <tr>
                                <th>Sl. No</th>
                                <th>Car</th>
                                <th>Reg. No.</th>
                                <th>Owner Email</th>
                                <th>Date</th>
                                <th>Time</th>
                                <th>Location</th>
                                <th>CarOwner Response</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($inspectionRequests as $request)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>
                                        <strong>{{ $request->car->maker ?? 'N/A' }}</strong>
                                        <br>
                                        <small class="text-muted">{{ $request->car->model ?? '' }}</small>
                                    </td>
                                    <td>
                                        <span class="badge bg-light text-dark">
                                            {{ $request->car->registration_no ?? 'N/A' }}
                                        </span>
                                    </td>
                                    <td>
                                        <a href="mailto:{{ $request->car->owner->email ?? '' }}" 
                                           class="text-decoration-none">
                                            {{ $request->car->owner->email ?? 'N/A' }}
                                        </a>
                                    </td>
                                    <td>
                                        <i class="fas fa-calendar-alt me-1"></i>
                                        {{ \Carbon\Carbon::parse($request->inspection_date)->format('M d, Y') }}
                                    </td>
                                    <td>
                                        <i class="fas fa-clock me-1"></i>
                                        {{ $request->inspection_time }}
                                    </td>
                                    <td>
                                        <i class="fas fa-map-marker-alt me-1"></i>
                                        {{ $request->location }}
                                    </td>
                                    <td>
                                        @if($request->request_accepted)
                                            <span class="badge bg-success">
                                                <i class="fas fa-check me-1"></i>Accepted
                                            </span>
                                        @elseif($request->status === 'canceled')
                                            <span class="badge bg-danger">
                                                <i class="fas fa-times me-1"></i>Cancelled
                                            </span>
                                        @elseif($request->request_new_date_sent)
                                            <span class="badge bg-warning text-dark">
                                                <i class="fas fa-clock me-1"></i>Requested New Date
                                            </span>
                                        @else
                                            <span class="badge bg-secondary">
                                                <i class="fas fa-hourglass-half me-1"></i>Pending
                                            </span>
                                        @endif
                                    </td>                           
                                    
                                    <td>
                                        @if($request->status !== 'canceled')
                                            @if(!$request->is_confirmed_by_admin)
                                                <form action="{{ route('car-admin.inspection.confirm', $request->id) }}" 
                                                      method="POST" 
                                                      class="d-inline" 
                                                      onsubmit="return disableButton(this)">
                                                    @csrf
                                                    <button type="submit" 
                                                            class="btn btn-success btn-sm" 
                                                            id="btn-{{ $request->id }}"
                                                            title="Confirm Inspection">
                                                        <i class="bi bi-check-circle me-1"></i>Confirm
                                                    </button>
                                                </form>
                                            @else
                                                <button class="btn btn-secondary btn-sm" 
                                                        disabled
                                                        title="Already Confirmed">
                                                    <i class="bi bi-check2-circle me-1"></i>Booked
                                                </button>
                                            @endif
                                        @else
                                            <span class="text-muted">
                                                <i class="fas fa-ban"></i> Cancelled
                                            </span>
                                        @endif
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                {{-- Pagination if needed --}}
                @if(method_exists($inspectionRequests, 'links'))
                    <div class="d-flex justify-content-center mt-4">
                        {{ $inspectionRequests->links() }}
                    </div>
                @endif
            @else
                <div class="text-center py-5">
                    <div class="mb-4">
                        <i class="fas fa-clipboard-list fa-4x text-muted"></i>
                    </div>
                    <div class="alert alert-info d-inline-block">
                        <h5 class="mb-2">
                            <i class="fas fa-info-circle me-2"></i>No Rescheduled Requests
                        </h5>
                        <p class="mb-0">No inspection responses found from car owners.</p>
                    </div>
                    <div class="mt-3">
                        <a href="{{ route('car-admin.inspection-requests') }}" 
                           class="btn btn-primary">
                            <i class="fas fa-arrow-left me-2"></i>View All Inspection Requests
                        </a>
                    </div>
                </div>
            @endif
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function () {
        // Initialize tooltips if Bootstrap tooltips are available
        if (typeof bootstrap !== 'undefined' && bootstrap.Tooltip) {
            var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
            var tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {
                return new bootstrap.Tooltip(tooltipTriggerEl);
            });
        }
    });
    
    function disableButton(form) {
        const btn = form.querySelector('button[type="submit"]');
        const originalText = btn.innerHTML;
        
        // Disable button and show loading state
        btn.disabled = true;
        btn.innerHTML = '<span class="spinner-border spinner-border-sm me-2" role="status" aria-hidden="true"></span>Processing...';
        
        // Simulate processing time (you can remove this setTimeout in production)
        setTimeout(() => {
            btn.innerHTML = '<i class="bi bi-check2-circle me-1"></i>Done';
            btn.classList.remove('btn-success');
            btn.classList.add('btn-secondary');
            
            // Show success message
            const row = btn.closest('tr');
            row.style.backgroundColor = '#d4edda';
            
            setTimeout(() => {
                row.style.backgroundColor = '';
            }, 2000);
        }, 1000);
        
        return true;
    }
    
    // Add smooth animations for table rows
    document.querySelectorAll('.table tbody tr').forEach(row => {
        row.addEventListener('mouseenter', function() {
            this.style.transform = 'translateY(-2px)';
        });
        
        row.addEventListener('mouseleave', function() {
            this.style.transform = 'translateY(0)';
        });
    });
</script>
@endpush