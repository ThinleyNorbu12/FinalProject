@extends('layouts.admin')

@section('title', 'Car Management Reports')
@section('breadcrumbs')
    <li class="breadcrumb-item">
        <li class="breadcrumb-item active">Car Management Reports</li>
    </li>
   
@endsection
@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                <h4 class="mb-sm-0">Car Management Reports</h4>
            </div>
        </div>
    </div>

    <!-- Summary Cards -->
    <div class="row">
        <div class="col-xl-3 col-md-6">
            <div class="card">
                <div class="card-body">
                    <div class="d-flex">
                        <div class="flex-1">
                            <p class="text-truncate font-size-14 mb-2">Total Registered Cars</p>
                            <h4 class="mb-2">{{ number_format($totalRegisteredCars) }}</h4>
                        </div>
                        <div class="avatar-sm">
                            <span class="avatar-title bg-light text-primary rounded-3">
                                <i class="fas fa-car font-size-24"></i>
                            </span>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-3 col-md-6">
            <div class="card">
                <div class="card-body">
                    <div class="d-flex">
                        <div class="flex-1">
                            <p class="text-truncate font-size-14 mb-2">Total Inspection Requests</p>
                            <h4 class="mb-2">{{ number_format($totalInspectionRequests) }}</h4>
                        </div>
                        <div class="avatar-sm">
                            <span class="avatar-title bg-light text-info rounded-3">
                                <i class="fas fa-clipboard-check font-size-24"></i>
                            </span>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-3 col-md-6">
            <div class="card">
                <div class="card-body">
                    <div class="d-flex">
                        <div class="flex-1">
                            <p class="text-truncate font-size-14 mb-2">Pending Approvals</p>
                            <h4 class="mb-2">{{ number_format($pendingApprovals) }}</h4>
                        </div>
                        <div class="avatar-sm">
                            <span class="avatar-title bg-light text-warning rounded-3">
                                <i class="fas fa-clock font-size-24"></i>
                            </span>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-3 col-md-6">
            <div class="card">
                <div class="card-body">
                    <div class="d-flex">
                        <div class="flex-1">
                            <p class="text-truncate font-size-14 mb-2">Approval Rate</p>
                            <h4 class="mb-2">{{ $approvalRate }}%</h4>
                        </div>
                        <div class="avatar-sm">
                            <span class="avatar-title bg-light text-success rounded-3">
                                <i class="fas fa-check-circle font-size-24"></i>
                            </span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Charts Row -->
    <div class="row">
        <div class="col-xl-6">
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title mb-0">Cars by Status</h4>
                </div>
                <div class="card-body">
                    <canvas id="carStatusChart" height="300"></canvas>
                </div>
            </div>
        </div>

        <div class="col-xl-6">
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title mb-0">Inspection Decisions</h4>
                </div>
                <div class="card-body">
                    <canvas id="inspectionDecisionsChart" height="300"></canvas>
                </div>
            </div>
        </div>
    </div>

    <!-- Data Tables Row -->
    <div class="row">
        <div class="col-xl-6">
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title mb-0">Cars by Vehicle Type</h4>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-bordered table-striped">
                            <thead>
                                <tr>
                                    <th>Vehicle Type</th>
                                    <th>Count</th>
                                    <th>Percentage</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($carsByType as $type)
                                <tr>
                                    <td>{{ ucfirst($type->vehicle_type ?: 'Not Specified') }}</td>
                                    <td>{{ number_format($type->count) }}</td>
                                    <td>{{ $totalRegisteredCars > 0 ? round(($type->count / $totalRegisteredCars) * 100, 1) : 0 }}%</td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-6">
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title mb-0">Top Car Makers</h4>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-bordered table-striped">
                            <thead>
                                <tr>
                                    <th>Maker</th>
                                    <th>Count</th>
                                    <th>Percentage</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($carsByMaker->take(10) as $maker)
                                <tr>
                                    <td>{{ ucfirst($maker->maker ?: 'Not Specified') }}</td>
                                    <td>{{ number_format($maker->count) }}</td>
                                    <td>{{ $totalRegisteredCars > 0 ? round(($maker->count / $totalRegisteredCars) * 100, 1) : 0 }}%</td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Monthly Trends -->
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title mb-0">Monthly Trends (Last 12 Months)</h4>
                </div>
                <div class="card-body">
                    <canvas id="monthlyTrendsChart" height="400"></canvas>
                </div>
            </div>
        </div>
    </div>

    <!-- Detailed Inspection Data -->
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title mb-0">Recent Inspection Details</h4>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-bordered table-striped" id="inspectionDetailsTable">
                            <thead>
                                <tr>
                                    <th>Request ID</th>
                                    <th>Car Details</th>
                                    <th>Registration No</th>
                                    <th>Inspection Date</th>
                                    <th>Request Status</th>
                                    <th>Decision</th>
                                    <th>Remarks</th>
                                    <th>Created Date</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($detailedInspections as $inspection)
                                <tr>
                                    <td>#{{ $inspection->request_id }}</td>
                                    <td>{{ $inspection->maker }} {{ $inspection->model }}</td>
                                    <td>{{ $inspection->registration_no ?: 'N/A' }}</td>
                                    <td>{{ $inspection->inspection_date ? \Carbon\Carbon::parse($inspection->inspection_date)->format('Y-m-d') : 'N/A' }}</td>
                                    <td>
                                        <span class="badge 
                                            @if($inspection->request_status == 'pending') badge-warning
                                            @elseif($inspection->request_status == 'completed') badge-success
                                            @elseif($inspection->request_status == 'cancelled') badge-danger
                                            @else badge-secondary
                                            @endif">
                                            {{ ucfirst($inspection->request_status ?: 'Unknown') }}
                                        </span>
                                    </td>
                                    <td>
                                        @if($inspection->decision)
                                            <span class="badge 
                                                @if($inspection->decision == 'approved') badge-success
                                                @elseif($inspection->decision == 'rejected') badge-danger
                                                @else badge-warning
                                                @endif">
                                                {{ ucfirst($inspection->decision) }}
                                            </span>
                                        @else
                                            <span class="badge badge-secondary">Pending</span>
                                        @endif
                                    </td>
                                    <td>{{ $inspection->remarks ?: 'N/A' }}</td>
                                    <td>{{ \Carbon\Carbon::parse($inspection->created_at)->format('Y-m-d H:i') }}</td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Chart.js Scripts -->
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Car Status Chart
    const carStatusCtx = document.getElementById('carStatusChart').getContext('2d');
    const carStatusData = @json($carsByStatus);
    
    new Chart(carStatusCtx, {
        type: 'doughnut',
        data: {
            labels: carStatusData.map(item => item.status || 'Unknown'),
            datasets: [{
                data: carStatusData.map(item => item.count),
                backgroundColor: [
                    '#28a745', '#ffc107', '#dc3545', '#17a2b8', '#6f42c1'
                ]
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false
        }
    });

    // Inspection Decisions Chart
    const inspectionDecisionsCtx = document.getElementById('inspectionDecisionsChart').getContext('2d');
    const inspectionDecisionsData = @json($inspectionDecisions);
    
    new Chart(inspectionDecisionsCtx, {
        type: 'pie',
        data: {
            labels: inspectionDecisionsData.map(item => item.decision || 'Unknown'),
            datasets: [{
                data: inspectionDecisionsData.map(item => item.count),
                backgroundColor: [
                    '#28a745', '#dc3545', '#ffc107', '#17a2b8'
                ]
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false
        }
    });

    // Monthly Trends Chart
    const monthlyTrendsCtx = document.getElementById('monthlyTrendsChart').getContext('2d');
    const monthlyRegistrations = @json($monthlyRegistrations);
    const monthlyInspections = @json($monthlyInspections);
    
    new Chart(monthlyTrendsCtx, {
        type: 'line',
        data: {
            labels: monthlyRegistrations.map(item => `${item.year}-${String(item.month).padStart(2, '0')}`),
            datasets: [{
                label: 'Car Registrations',
                data: monthlyRegistrations.map(item => item.count),
                borderColor: '#007bff',
                backgroundColor: 'rgba(0, 123, 255, 0.1)',
                tension: 0.4
            }, {
                label: 'Inspection Requests',
                data: monthlyInspections.map(item => item.count),
                borderColor: '#28a745',
                backgroundColor: 'rgba(40, 167, 69, 0.1)',
                tension: 0.4
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            scales: {
                y: {
                    beginAtZero: true
                }
            }
        }
    });
});
</script>

<!-- DataTables for detailed inspection table -->
<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.11.5/css/dataTables.bootstrap4.min.css">
<script type="text/javascript" src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.min.js"></script>
<script type="text/javascript" src="https://cdn.datatables.net/1.11.5/js/dataTables.bootstrap4.min.js"></script>

<script>
$(document).ready(function() {
    $('#inspectionDetailsTable').DataTable({
        "pageLength": 25,
        "order": [[ 7, "desc" ]], // Sort by created date descending
        "responsive": true
    });
});
</script>
@endsection