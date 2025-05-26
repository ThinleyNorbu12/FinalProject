@extends('layouts.carowner')

@section('title', 'Rejected Cars')

@section('breadcrumbs')
    <li class="breadcrumb-item active">Rejected Cars</li>
@endsection

@section('page-header')
    <div class="d-flex justify-content-between align-items-center">
        <div>
            <h1 class="page-title">Rejected Cars</h1>
            <p class="page-description text-muted">View all cars that have been rejected during inspection</p>
        </div>
    </div>
@endsection

@section('content')
    <div class="row">
        <div class="col-12">
            <div class="card shadow-sm">
                <div class="card-header bg-danger text-white">
                    <h5 class="card-title mb-0">
                        <i class="fas fa-times-circle me-2"></i>Rejected Cars List
                    </h5>
                </div>
                <div class="card-body">
                    @if($rejectedCars->count() > 0)
                        <div class="table-responsive">
                            <table class="table table-striped table-hover">
                                <thead class="table-light">
                                    <tr>
                                        <th scope="col">Sl. No</th>
                                        <th scope="col">
                                            <i class="fas fa-industry me-1"></i>Maker
                                        </th>
                                        <th scope="col">
                                            <i class="fas fa-car me-1"></i>Model
                                        </th>
                                        <th scope="col">
                                            <i class="fas fa-tags me-1"></i>Vehicle Type
                                        </th>
                                        <th scope="col">
                                            <i class="fas fa-tools me-1"></i>Condition
                                        </th>
                                        <th scope="col">
                                            <i class="fas fa-dollar-sign me-1"></i>Price
                                        </th>
                                        <th scope="col">
                                            <i class="fas fa-id-card me-1"></i>Registration No
                                        </th>
                                        <th scope="col">
                                            <i class="fas fa-calendar me-1"></i>Rejected Date
                                        </th>
                                        <th scope="col">Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($rejectedCars as $car)
                                        <tr>
                                            <td>
                                                <span class="badge bg-secondary">{{ $loop->iteration }}</span>
                                            </td>
                                            <td>
                                                <strong>{{ $car->maker }}</strong>
                                            </td>
                                            <td>{{ $car->model }}</td>
                                            <td>
                                                <span class="badge bg-info">{{ $car->vehicle_type }}</span>
                                            </td>
                                            <td>
                                                <span class="badge bg-warning text-dark">{{ $car->car_condition }}</span>
                                            </td>
                                            <td>
                                                <strong class="text-success">${{ number_format($car->price, 2) }}</strong>
                                            </td>
                                            <td>
                                                <code>{{ $car->registration_no }}</code>
                                            </td>
                                            <td>
                                                @if(isset($car->updated_at))
                                                    <small class="text-muted">{{ $car->updated_at->format('M d, Y') }}</small>
                                                @else
                                                    <small class="text-muted">N/A</small>
                                                @endif
                                            </td>
                                            <td>
                                                <div class="btn-group" role="group">
                                                    <button type="button" class="btn btn-sm btn-outline-primary" 
                                                            data-bs-toggle="modal" 
                                                            data-bs-target="#viewCarModal{{ $car->id }}"
                                                            title="View Details">
                                                        <i class="fas fa-eye"></i>
                                                    </button>
                                                    @if(isset($car->rejection_reason))
                                                        <button type="button" class="btn btn-sm btn-outline-danger" 
                                                                data-bs-toggle="modal" 
                                                                data-bs-target="#reasonModal{{ $car->id }}"
                                                                title="View Rejection Reason">
                                                            <i class="fas fa-exclamation-triangle"></i>
                                                        </button>
                                                    @endif
                                                </div>
                                            </td>
                                        </tr>

                                        <!-- View Car Details Modal -->
                                        <div class="modal fade" id="viewCarModal{{ $car->id }}" tabindex="-1">
                                            <div class="modal-dialog modal-lg">
                                                <div class="modal-content">
                                                    <div class="modal-header bg-primary text-white">
                                                        <h5 class="modal-title">
                                                            <i class="fas fa-car me-2"></i>Car Details - {{ $car->maker }} {{ $car->model }}
                                                        </h5>
                                                        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                                                    </div>
                                                    <div class="modal-body">
                                                        <div class="row">
                                                            <div class="col-md-6">
                                                                <h6><i class="fas fa-info-circle text-primary me-2"></i>Basic Information</h6>
                                                                <table class="table table-sm">
                                                                    <tr><td><strong>Maker:</strong></td><td>{{ $car->maker }}</td></tr>
                                                                    <tr><td><strong>Model:</strong></td><td>{{ $car->model }}</td></tr>
                                                                    <tr><td><strong>Type:</strong></td><td>{{ $car->vehicle_type }}</td></tr>
                                                                    <tr><td><strong>Condition:</strong></td><td>{{ $car->car_condition }}</td></tr>
                                                                </table>
                                                            </div>
                                                            <div class="col-md-6">
                                                                <h6><i class="fas fa-dollar-sign text-success me-2"></i>Pricing & Registration</h6>
                                                                <table class="table table-sm">
                                                                    <tr><td><strong>Price:</strong></td><td>${{ number_format($car->price, 2) }}</td></tr>
                                                                    <tr><td><strong>Registration:</strong></td><td>{{ $car->registration_no }}</td></tr>
                                                                    <tr><td><strong>Status:</strong></td><td><span class="badge bg-danger">Rejected</span></td></tr>
                                                                </table>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="modal-footer">
                                                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <!-- Rejection Reason Modal -->
                                        @if(isset($car->rejection_reason))
                                            <div class="modal fade" id="reasonModal{{ $car->id }}" tabindex="-1">
                                                <div class="modal-dialog">
                                                    <div class="modal-content">
                                                        <div class="modal-header bg-danger text-white">
                                                            <h5 class="modal-title">
                                                                <i class="fas fa-exclamation-triangle me-2"></i>Rejection Reason
                                                            </h5>
                                                            <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                                                        </div>
                                                        <div class="modal-body">
                                                            <div class="alert alert-danger">
                                                                <h6><strong>Car:</strong> {{ $car->maker }} {{ $car->model }}</h6>
                                                                <hr>
                                                                <p class="mb-0">{{ $car->rejection_reason }}</p>
                                                            </div>
                                                        </div>
                                                        <div class="modal-footer">
                                                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        @endif
                                    @endforeach
                                </tbody>
                            </table>
                        </div>

                        @if(method_exists($rejectedCars, 'links'))
                            <div class="d-flex justify-content-center mt-4">
                                {{ $rejectedCars->links() }}
                            </div>
                        @endif
                    @else
                        <div class="text-center py-5">
                            <div class="empty-state">
                                <i class="fas fa-check-circle text-success" style="font-size: 4rem; opacity: 0.3;"></i>
                                <h4 class="mt-3 text-muted">No Rejected Cars</h4>
                                <p class="text-muted">Great news! You don't have any rejected cars at the moment.</p>
                                <a href="{{ route('carowner.car-inspection') }}" class="btn btn-primary">
                                    <i class="fas fa-plus me-2"></i>Submit New Car for Inspection
                                </a>
                            </div>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
@endsection

@push('styles')
<style>
    .page-title {
        font-size: 1.75rem;
        font-weight: 600;
        color: #2c3e50;
        margin-bottom: 0.25rem;
    }
    
    .page-description {
        font-size: 0.95rem;
        margin-bottom: 0;
    }
    
    .card {
        border: none;
        border-radius: 0.75rem;
    }
    
    .card-header {
        border-radius: 0.75rem 0.75rem 0 0 !important;
        border: none;
        padding: 1rem 1.5rem;
    }
    
    .table th {
        border-top: none;
        font-weight: 600;
        color: #495057;
        padding: 1rem 0.75rem;
    }
    
    .table td {
        padding: 1rem 0.75rem;
        vertical-align: middle;
    }
    
    .table-hover tbody tr:hover {
        background-color: #f8f9fa;
    }
    
    .badge {
        font-size: 0.75rem;
        padding: 0.375rem 0.75rem;
    }
    
    .btn-group .btn {
        margin-right: 0.25rem;
    }
    
    .btn-group .btn:last-child {
        margin-right: 0;
    }
    
    .empty-state {
        padding: 2rem;
    }
    
    code {
        background-color: #f8f9fa;
        color: #e83e8c;
        padding: 0.25rem 0.5rem;
        border-radius: 0.25rem;
        font-size: 0.875rem;
    }
</style>
@endpush

@push('scripts')
<script>
    $(document).ready(function() {
        // Initialize tooltips
        var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
        var tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {
            return new bootstrap.Tooltip(tooltipTriggerEl);
        });
        
        // Add animation to table rows
        $('.table tbody tr').hover(
            function() {
                $(this).addClass('table-active');
            },
            function() {
                $(this).removeClass('table-active');
            }
        );
    });
</script>
@endpush