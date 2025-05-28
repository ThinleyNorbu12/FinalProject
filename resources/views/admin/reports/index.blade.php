@extends('layouts.admin')

@section('title', 'Reports & Analytics')

@section('breadcrumbs')
    <li class="breadcrumb-item active">Reports & Analytics</li>
@endsection

@section('content')
<div class="dashboard-content">
    <div class="dashboard-header">
        <h1><i class="fas fa-chart-bar"></i> Reports & Analytics</h1>
        <div class="header-actions">
            <form method="GET" action="{{ route('admin.reports.index') }}" class="date-filter-form">
                <div class="date-inputs">
                    <input type="date" name="start_date" value="{{ $startDate }}" class="form-control">
                    <span>to</span>
                    <input type="date" name="end_date" value="{{ $endDate }}" class="form-control">
                    <button type="submit" class="btn btn-primary">Filter</button>
                </div>
            </form>
        </div>
    </div>

    <!-- Summary Cards -->
    <div class="report-summary">
        <div class="summary-card">
            <div class="card-icon bg-primary">
                <i class="fas fa-car"></i>
            </div>
            <div class="card-content">
                <h3>{{ $totalAdminCars }}</h3>
                <p>Admin Cars</p>
            </div>
        </div>
        
        <div class="summary-card">
            <div class="card-icon bg-success">
                <i class="fas fa-users"></i>
            </div>
            <div class="card-content">
                <h3>{{ $totalOwnerCars }}</h3>
                <p>Owner Cars</p>
            </div>
        </div>
        
        <div class="summary-card">
            <div class="card-icon bg-warning">
                <i class="fas fa-calendar-check"></i>
            </div>
            <div class="card-content">
                <h3>{{ $totalBookings }}</h3>
                <p>Total Bookings</p>
            </div>
        </div>
        
        <div class="summary-card">
            <div class="card-icon bg-info">
                <i class="fas fa-clipboard-check"></i>
            </div>
            <div class="card-content">
                <h3>{{ $totalInspections }}</h3>
                <p>Inspections</p>
            </div>
        </div>
    </div>

    <!-- Revenue Summary -->
    <div class="report-row">
        {{-- Updated Revenue Summary Card --}}
        {{-- Updated Revenue Summary Card --}}
        <div class="report-card">
            <div class="card-header">
                <h3><i class="fas fa-money-bill-wave"></i> Revenue Summary</h3>
            </div>
            <div class="card-body">
                <div class="revenue-stats">
                    <div class="stat-item">
                        <span class="label">Total Revenue:</span>
                        <span class="value">BTN {{ number_format($revenueData->total_revenue ?? 0, 2) }}</span>
                    </div>
                    <div class="stat-item">
                        <span class="label">Completed Payments:</span>
                        <span class="value">{{ $revenueData->total_bookings ?? 0 }}</span>
                    </div>
                    <div class="stat-item">
                        <span class="label">Average Transaction Value:</span>
                        <span class="value">BTN {{ number_format($revenueData->average_booking_value ?? 0, 2) }}</span>
                    </div>
                    <div class="stat-item">
                        <span class="label">Payment Methods Used:</span>
                        <span class="value">{{ $revenueData->payment_methods_used ?? 0 }}</span>
                    </div>
                </div>
            </div>
        </div>

        {{-- Additional Payment Method Analysis Card --}}
        <div class="report-card">
            <div class="card-header">
                <h3><i class="fas fa-credit-card"></i> Payment Methods Analysis</h3>
            </div>
            <div class="card-body">
                <div class="payment-methods">
                    @foreach($paymentMethodAnalysis as $method)
                    <div class="method-item">
                        <div class="method-info">
                            <span class="method-name">{{ ucfirst($method->payment_method) }}</span>
                            <span class="method-count">{{ $method->count }} transactions</span>
                        </div>
                        <div class="method-amount">
                            BTN {{ number_format($method->total_amount, 2) }}
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>
        </div>

        {{-- Payment Status Distribution --}}
        <div class="report-card">
            <div class="card-header">
                <h3><i class="fas fa-chart-pie"></i> Payment Status Distribution</h3>
            </div>
            <div class="card-body">
                <div class="status-distribution">
                    @foreach($paymentStatus as $status)
                    <div class="status-item">
                        <div class="status-info">
                            <span class="status-name badge 
                                @if($status->status === 'completed') badge-success
                                @elseif($status->status === 'failed') badge-danger
                                @elseif($status->status === 'pending') badge-warning
                                @else badge-secondary
                                @endif">
                                {{ ucfirst($status->status) }}
                            </span>
                            <span class="status-count">{{ $status->count }} payments</span>
                        </div>
                        <div class="status-amount">
                            BTN {{ number_format($status->amount, 2) }}
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>
        </div>

        {{-- Failed Payments Alert --}}
        @if($failedPayments && $failedPayments->failed_count > 0)
        <div class="report-card alert-card">
            <div class="card-header">
                <h3><i class="fas fa-exclamation-triangle text-warning"></i> Failed Payments Alert</h3>
            </div>
            <div class="card-body">
                <div class="alert alert-warning">
                    <p><strong>{{ $failedPayments->failed_count }}</strong> failed payments resulted in potential lost revenue of <strong>BTN {{ number_format($failedPayments->lost_revenue, 2) }}</strong></p>
                </div>
            </div>
        </div>
        @endif

        {{-- Recent Payments Table --}}
        <div class="report-card">
            <div class="card-header">
                <h3><i class="fas fa-list"></i> Recent Payments</h3>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <th>Reference No.</th>
                                <th>Vehicle</th>
                                <th>Amount</th>
                                <th>Payment Method</th>
                                <th>Pickup Date</th>
                                <th>Location</th>
                                <th>Status</th>
                                <th>Payment Date</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($recentPayments as $payment)
                            <tr>
                                <td>{{ $payment->reference_number }}</td>
                                <td>{{ $payment->maker }} {{ $payment->model }} <br><small class="text-muted">({{ $payment->registration_no }})</small></td>
                                <td>{{ $payment->currency }} {{ number_format($payment->amount, 2) }}</td>
                                <td>{{ ucfirst($payment->payment_method) }}</td>
                                <td>{{ \Carbon\Carbon::parse($payment->pickup_datetime)->format('M d, Y H:i') }}</td>
                                <td>
                                    <small>
                                        <strong>From:</strong> {{ $payment->pickup_location }}<br>
                                        <strong>To:</strong> {{ $payment->dropoff_location }}
                                    </small>
                                </td>
                                <td>
                                    <span class="badge 
                                        @if($payment->status === 'completed') badge-success
                                        @elseif($payment->status === 'failed') badge-danger
                                        @elseif($payment->status === 'pending') badge-warning
                                        @else badge-secondary
                                        @endif">
                                        {{ ucfirst($payment->status) }}
                                    </span>
                                    <br>
                                    <small class="text-muted">Booking: {{ ucfirst($payment->booking_status) }}</small>
                                </td>
                                <td>{{ \Carbon\Carbon::parse($payment->payment_date)->format('M d, Y H:i') }}</td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <!-- Car Status Distribution -->
        <div class="report-card">
            <div class="card-header">
                <h3><i class="fas fa-chart-pie"></i> Car Status Distribution</h3>
            </div>
            <div class="card-body">
                <div class="status-charts">
                    <div class="chart-section">
                        <h4>Admin Cars</h4>
                        <div class="status-list">
                            @foreach($adminCarStatus as $status)
                            <div class="status-item">
                                <span class="status-label">{{ ucfirst($status->status) }}:</span>
                                <span class="status-count">{{ $status->count }}</span>
                            </div>
                            @endforeach
                        </div>
                    </div>
                    <div class="chart-section">
                        <h4>Owner Cars</h4>
                        <div class="status-list">
                            @foreach($ownerCarStatus as $status)
                            <div class="status-item">
                                <span class="status-label">{{ ucfirst($status->status) }}:</span>
                                <span class="status-count">{{ $status->count }}</span>
                            </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Popular Cars and Booking Status -->
    <div class="report-row">
        <div class="report-card">
            <div class="card-header">
                <h3><i class="fas fa-trophy"></i> Most Popular Cars</h3>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="report-table">
                        <thead>
                            <tr>
                                <th>Make</th>
                                <th>Model</th>
                                <th>Bookings</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($popularCars as $car)
                            <tr>
                                <td>{{ $car->maker }}</td>
                                <td>{{ $car->model }}</td>
                                <td>{{ $car->booking_count }}</td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="3" class="text-center">No booking data available</td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <div class="report-card">
            <div class="card-header">
                <h3><i class="fas fa-list"></i> Booking Status</h3>
            </div>
            <div class="card-body">
                <div class="status-list">
                    @foreach($bookingStatus as $status)
                    <div class="status-item">
                        <span class="status-label">{{ ucfirst($status->status) }}:</span>
                        <span class="status-count">{{ $status->count }}</span>
                        <div class="status-bar">
                            <div class="status-fill" style="width: {{ ($status->count / $totalBookings) * 100 }}%"></div>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>

    <!-- Car Type Analysis -->
    <div class="report-row">
        <div class="report-card full-width">
            <div class="card-header">
                <h3><i class="fas fa-car-side"></i> Car Type Analysis</h3>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="report-table">
                        <thead>
                            <tr>
                                <th>Vehicle Type</th>
                                <th>Total Cars</th>
                                <th>Average Price</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($carTypeAnalysis as $type)
                            <tr>
                                <td>{{ ucfirst($type->vehicle_type) }}</td>
                                <td>{{ $type->count }}</td>
                                <td>BTN  {{ number_format($type->avg_price, 2) }}</td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <!-- Recent Activity -->
    <div class="report-row">
        <div class="report-card">
            <div class="card-header">
                <h3><i class="fas fa-clock"></i> Recent Bookings</h3>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="report-table">
                        <thead>
                            <tr>
                                <th>Car</th>
                                <th>Status</th>
                                <th>Date</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($recentBookings as $booking)
                            <tr>
                                <td>{{ $booking->maker }} {{ $booking->model }}</td>
                                <td>
                                    <span class="status-badge status-{{ $booking->status }}">
                                        {{ ucfirst($booking->status) }}
                                    </span>
                                </td>
                                <td>{{ \Carbon\Carbon::parse($booking->created_at)->format('M d, Y') }}</td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="3" class="text-center">No recent bookings</td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <div class="report-card">
            <div class="card-header">
                <h3><i class="fas fa-search"></i> Recent Inspections</h3>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="report-table">
                        <thead>
                            <tr>
                                <th>Car</th>
                                <th>Status</th>
                                <th>Date</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($recentInspections as $inspection)
                            <tr>
                                <td>{{ $inspection->maker }} {{ $inspection->model }}</td>
                                <td>
                                    <span class="status-badge status-{{ $inspection->status }}">
                                        {{ ucfirst($inspection->status) }}
                                    </span>
                                </td>
                                <td>{{ \Carbon\Carbon::parse($inspection->created_at)->format('M d, Y') }}</td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="3" class="text-center">No recent inspections</td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
/* Main Content Container - Added to fix positioning */
.main-content {
    margin-left: 0;
    padding: 1rem 2rem;
    max-width: 100%;
    width: 100%;
}

/* Dashboard Header */
.dashboard-header {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-bottom: 2rem;
    padding: 0;
    width: 100%;
}

.dashboard-header h1 {
    margin: 0;
    font-size: 1.75rem;
    color: #333;
}

/* Date Filter Form */
.date-filter-form {
    margin-left: auto;
}

.date-filter-form .date-inputs {
    display: flex;
    align-items: center;
    gap: 0.5rem;
    flex-wrap: wrap;
    justify-content: flex-end;
}

.date-inputs input {
    padding: 0.5rem;
    border: 1px solid #ddd;
    border-radius: 4px;
    min-width: 120px;
}

.date-inputs span {
    color: #666;
    font-weight: 500;
}

/* Summary Cards */
.report-summary {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
    gap: 1.5rem;
    margin-bottom: 2rem;
    width: 100%;
}

.summary-card {
    background: white;
    border-radius: 8px;
    padding: 1.5rem;
    display: flex;
    align-items: center;
    box-shadow: 0 2px 4px rgba(0,0,0,0.1);
    border: 1px solid #e9ecef;
    width: 100%;
}

.card-icon {
    width: 60px;
    height: 60px;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    margin-right: 1rem;
    color: white;
    font-size: 1.5rem;
    flex-shrink: 0;
}

.bg-primary { background-color: #007bff; }
.bg-success { background-color: #28a745; }
.bg-warning { background-color: #ffc107; }
.bg-info { background-color: #17a2b8; }

.card-content h3 {
    margin: 0;
    font-size: 2rem;
    font-weight: bold;
    color: #333;
}

.card-content p {
    margin: 0;
    color: #666;
    font-size: 0.9rem;
}

/* Report Cards Grid */
.report-row {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(350px, 1fr));
    gap: 1.5rem;
    margin-bottom: 2rem;
    width: 100%;
}

.report-card {
    background: white;
    border-radius: 8px;
    box-shadow: 0 2px 4px rgba(0,0,0,0.1);
    border: 1px solid #e9ecef;
    overflow: hidden;
    width: 100%;
}

.report-card.full-width {
    grid-column: 1 / -1;
}

.report-card.alert-card {
    border-left: 4px solid #ffc107;
}

.card-header {
    background: #f8f9fa;
    padding: 1rem 1.5rem;
    border-bottom: 1px solid #dee2e6;
}

.card-header h3 {
    margin: 0;
    font-size: 1.25rem;
    color: #495057;
    font-weight: 600;
}

.card-body {
    padding: 1.5rem;
}

/* Revenue Stats */
.revenue-stats {
    display: flex;
    flex-direction: column;
    gap: 1rem;
}

.stat-item {
    display: flex;
    justify-content: space-between;
    align-items: center;
    padding: 0.75rem 0;
    border-bottom: 1px solid #eee;
}

.stat-item:last-child {
    border-bottom: none;
}

.stat-item .label {
    color: #666;
    font-weight: 500;
}

.stat-item .value {
    font-weight: bold;
    color: #28a745;
    font-size: 1.1rem;
}

/* Payment Methods & Status */
.payment-methods,
.status-distribution {
    display: flex;
    flex-direction: column;
    gap: 1rem;
}

.method-item,
.status-item {
    display: flex;
    justify-content: space-between;
    align-items: center;
    padding: 0.75rem;
    background: #f8f9fa;
    border-radius: 6px;
    border: 1px solid #e9ecef;
}

.method-info,
.status-info {
    display: flex;
    flex-direction: column;
    gap: 0.25rem;
}

.method-name,
.status-name {
    font-weight: 600;
    color: #333;
}

.method-count,
.status-count {
    font-size: 0.85rem;
    color: #666;
}

.method-amount,
.status-amount {
    font-weight: bold;
    color: #28a745;
    font-size: 1.1rem;
}

/* Car Status Charts */
.status-charts {
    display: grid;
    grid-template-columns: 1fr 1fr;
    gap: 2rem;
}

.chart-section h4 {
    margin: 0 0 1rem 0;
    color: #495057;
    font-size: 1.1rem;
    border-bottom: 2px solid #007bff;
    padding-bottom: 0.5rem;
}

.status-list {
    display: flex;
    flex-direction: column;
    gap: 0.75rem;
}

.status-list .status-item {
    display: flex;
    justify-content: space-between;
    align-items: center;
    padding: 0.75rem 0;
    position: relative;
    background: none;
    border: none;
    border-bottom: 1px solid #eee;
}

.status-label {
    color: #666;
    font-weight: 500;
}

.status-list .status-count {
    font-weight: bold;
    background: #007bff;
    color: white;
    padding: 0.25rem 0.75rem;
    border-radius: 20px;
    min-width: 40px;
    text-align: center;
    font-size: 0.9rem;
}

.status-bar {
    position: absolute;
    bottom: 0;
    left: 0;
    right: 0;
    height: 3px;
    background: #e9ecef;
    border-radius: 2px;
}

.status-fill {
    height: 100%;
    background: #007bff;
    border-radius: 2px;
    transition: width 0.3s ease;
}

/* Container and Layout Fixes */
.container,
.container-fluid {
    padding-left: 1rem;
    padding-right: 1rem;
    margin-left: 0;
    margin-right: 0;
    max-width: 100%;
}

/* Tables */
.table-responsive {
    overflow-x: auto;
}

.report-table,
.table {
    width: 100%;
    border-collapse: collapse;
    margin: 0;
}

.report-table th,
.report-table td,
.table th,
.table td {
    padding: 0.75rem;
    text-align: left;
    border-bottom: 1px solid #dee2e6;
    vertical-align: top;
}

.report-table th,
.table th {
    background: #f8f9fa;
    font-weight: 600;
    color: #495057;
    font-size: 0.9rem;
}

.table-striped tbody tr:nth-of-type(odd) {
    background-color: #f8f9fa;
}

/* Status Badges */
.status-badge,
.badge {
    padding: 0.35rem 0.65rem;
    border-radius: 4px;
    font-size: 0.75rem;
    font-weight: 600;
    text-transform: uppercase;
    letter-spacing: 0.5px;
    display: inline-block;
}

.status-pending,
.badge-warning { 
    background: #fff3cd; 
    color: #856404; 
}

.status-confirmed,
.badge-success { 
    background: #d4edda; 
    color: #155724; 
}

.status-completed,
.badge-info { 
    background: #d1ecf1; 
    color: #0c5460; 
}

.status-cancelled,
.badge-danger { 
    background: #f8d7da; 
    color: #721c24; 
}

.badge-secondary {
    background: #e2e3e5;
    color: #383d41;
}

/* Alert Styling */
.alert {
    padding: 0.75rem 1.25rem;
    margin-bottom: 1rem;
    border: 1px solid transparent;
    border-radius: 0.375rem;
}

.alert-warning {
    color: #856404;
    background-color: #fff3cd;
    border-color: #ffeaa7;
}

/* Text Utilities */
.text-center {
    text-align: center !important;
}

.text-muted {
    color: #6c757d !important;
}

.text-warning {
    color: #ffc107 !important;
}

/* Responsive Design */
@media (max-width: 1200px) {
    .report-row {
        grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
    }
    
    .report-summary {
        grid-template-columns: repeat(auto-fit, minmax(220px, 1fr));
    }
    
    .main-content {
        padding: 1rem 1.5rem;
    }
}

@media (max-width: 992px) {
    .status-charts {
        grid-template-columns: 1fr;
        gap: 1.5rem;
    }
    
    .report-row {
        grid-template-columns: repeat(auto-fit, minmax(280px, 1fr));
    }
    
    .main-content {
        padding: 1rem;
    }
}

@media (max-width: 768px) {
    .dashboard-header {
        flex-direction: column;
        gap: 1rem;
        align-items: stretch;
    }
    
    .date-filter-form .date-inputs {
        justify-content: center;
    }
    
    .report-row {
        grid-template-columns: 1fr;
    }
    
    .report-summary {
        grid-template-columns: 1fr;
    }
    
    .date-inputs {
        flex-direction: column;
        align-items: stretch;
        gap: 0.75rem;
    }
    
    .date-inputs input {
        width: 100%;
        min-width: auto;
    }
    
    .summary-card {
        padding: 1rem;
    }
    
    .card-content h3 {
        font-size: 1.5rem;
    }
    
    .stat-item,
    .method-item,
    .status-item {
        flex-direction: column;
        align-items: flex-start;
        gap: 0.5rem;
    }
    
    .card-body {
        padding: 1rem;
    }
    
    .main-content {
        padding: 0.75rem;
    }
}

@media (max-width: 576px) {
    .card-icon {
        width: 50px;
        height: 50px;
        font-size: 1.25rem;
    }
    
    .card-content h3 {
        font-size: 1.25rem;
    }
    
    .report-table th,
    .report-table td,
    .table th,
    .table td {
        padding: 0.5rem;
        font-size: 0.85rem;
    }
    
    .summary-card {
        flex-direction: column;
        text-align: center;
        gap: 1rem;
    }
    
    .card-icon {
        margin-right: 0;
    }
    
    .main-content {
        padding: 0.5rem;
    }
}
</style>
@endsection