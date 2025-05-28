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
        <div class="report-card">
            <div class="card-header">
                <h3><i class="fas fa-dollar-sign"></i> Revenue Summary</h3>
            </div>
            <div class="card-body">
                <div class="revenue-stats">
                    <div class="stat-item">
                        <span class="label">Total Revenue:</span>
                        <span class="value">BTN {{ number_format($revenueData->total_revenue ?? 0, 2) }}</span>
                    </div>
                    <div class="stat-item">
                        <span class="label">Completed Bookings:</span>
                        <span class="value">{{ $revenueData->total_bookings ?? 0 }}</span>
                    </div>
                    <div class="stat-item">
                        <span class="label">Average Booking Value:</span>
                        <span class="value">BTN {{ number_format($revenueData->average_booking_value ?? 0, 2) }}</span>
                    </div>
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
.dashboard-header {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-bottom: 2rem;
}

.date-filter-form .date-inputs {
    display: flex;
    align-items: center;
    gap: 0.5rem;
}

.date-inputs input {
    padding: 0.5rem;
    border: 1px solid #ddd;
    border-radius: 4px;
}

.report-summary {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
    gap: 1.5rem;
    margin-bottom: 2rem;
}

.summary-card {
    background: white;
    border-radius: 8px;
    padding: 1.5rem;
    display: flex;
    align-items: center;
    box-shadow: 0 2px 4px rgba(0,0,0,0.1);
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
}

.bg-primary { background-color: #007bff; }
.bg-success { background-color: #28a745; }
.bg-warning { background-color: #ffc107; }
.bg-info { background-color: #17a2b8; }

.card-content h3 {
    margin: 0;
    font-size: 2rem;
    font-weight: bold;
}

.card-content p {
    margin: 0;
    color: #666;
}

.report-row {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(400px, 1fr));
    gap: 1.5rem;
    margin-bottom: 2rem;
}

.report-card {
    background: white;
    border-radius: 8px;
    box-shadow: 0 2px 4px rgba(0,0,0,0.1);
    overflow: hidden;
}

.report-card.full-width {
    grid-column: 1 / -1;
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
}

.card-body {
    padding: 1.5rem;
}

.revenue-stats {
    display: flex;
    flex-direction: column;
    gap: 1rem;
}

.stat-item {
    display: flex;
    justify-content: space-between;
    align-items: center;
    padding: 0.5rem 0;
    border-bottom: 1px solid #eee;
}

.stat-item:last-child {
    border-bottom: none;
}

.value {
    font-weight: bold;
    color: #28a745;
}

.status-charts {
    display: grid;
    grid-template-columns: 1fr 1fr;
    gap: 2rem;
}

.status-list {
    display: flex;
    flex-direction: column;
    gap: 0.5rem;
}

.status-item {
    display: flex;
    justify-content: space-between;
    align-items: center;
    padding: 0.5rem 0;
    position: relative;
}

.status-count {
    font-weight: bold;
    background: #e9ecef;
    padding: 0.25rem 0.5rem;
    border-radius: 4px;
    min-width: 30px;
    text-align: center;
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

.report-table {
    width: 100%;
    border-collapse: collapse;
}

.report-table th,
.report-table td {
    padding: 0.75rem;
    text-align: left;
    border-bottom: 1px solid #dee2e6;
}

.report-table th {
    background: #f8f9fa;
    font-weight: 600;
    color: #495057;
}

.status-badge {
    padding: 0.25rem 0.5rem;
    border-radius: 4px;
    font-size: 0.75rem;
    font-weight: 500;
    text-transform: uppercase;
}

.status-pending { background: #fff3cd; color: #856404; }
.status-confirmed { background: #d4edda; color: #155724; }
.status-completed { background: #d1ecf1; color: #0c5460; }
.status-cancelled { background: #f8d7da; color: #721c24; }

.text-center {
    text-align: center;
}

@media (max-width: 768px) {
    .report-row {
        grid-template-columns: 1fr;
    }
    
    .status-charts {
        grid-template-columns: 1fr;
        gap: 1rem;
    }
    
    .date-inputs {
        flex-direction: column;
        align-items: stretch;
    }
}
</style>
@endsection