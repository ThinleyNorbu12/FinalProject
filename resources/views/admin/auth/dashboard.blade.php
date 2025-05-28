@extends('layouts.admin')

@section('title', 'Dashboard')

@section('breadcrumbs')
    <li class="breadcrumb-item active">Dashboard</li>
@endsection

@push('styles')
    <link rel="stylesheet" href="{{ asset('assets/css/admin/dashboard.css') }}">
@endpush

@section('content')
<!-- DYNAMIC CONTENT LOADER -->
<div id="dynamic-content">
    <!-- Dashboard Cards with Real Data -->
    <div class="dashboard-cards">
        <div class="card">
            <div class="card-inner">
                <div class="card-icon bg-primary">
                    <i class="fas fa-car"></i> 
                </div>
                <div class="card-content">
                    <h3>New Registrations</h3>
                    <p class="count">{{ $stats['new_registrations']['count'] }}</p>
                    <p class="trend {{ $stats['new_registrations']['trend']['direction'] }}">
                        <i class="fas fa-arrow-{{ $stats['new_registrations']['trend']['direction'] }}"></i> 
                        {{ $stats['new_registrations']['trend']['percentage'] }}% from last month
                    </p>
                </div>
            </div>
        </div>
    
        <div class="card">
            <div class="card-inner">
                <div class="card-icon bg-success">
                    <i class="fas fa-clipboard-check"></i>
                </div>
                <div class="card-content">
                    <h3>Pending Inspections</h3>
                    <p class="count">{{ $stats['pending_inspections']['count'] }}</p>
                    <p class="trend {{ $stats['pending_inspections']['trend']['direction'] }}">
                        <i class="fas fa-arrow-{{ $stats['pending_inspections']['trend']['direction'] }}"></i> 
                        {{ $stats['pending_inspections']['trend']['percentage'] }}% from last month
                    </p>
                </div>
            </div>
        </div>
        
        <div class="card">
            <div class="card-inner">
                <div class="card-icon bg-warning">
                    <i class="fas fa-credit-card"></i>
                </div>
                <div class="card-content">
                    <h3>Total Revenue</h3>
                    <p class="count">BTN {{ $stats['total_revenue']['amount'] }}</p>
                    <p class="trend {{ $stats['total_revenue']['trend']['direction'] }}">
                        <i class="fas fa-arrow-{{ $stats['total_revenue']['trend']['direction'] }}"></i> 
                        {{ $stats['total_revenue']['trend']['percentage'] }}% from last month
                    </p>
                </div>
            </div>
        </div>
        
        <div class="card">
            <div class="card-inner">
                <div class="card-icon bg-info">
                    <i class="fas fa-calendar-check"></i>
                </div>
                <div class="card-content">
                    <h3>Booked Cars</h3>
                    <p class="count">{{ $stats['booked_cars']['count'] }}</p>
                    <p class="trend {{ $stats['booked_cars']['trend']['direction'] }}">
                        <i class="fas fa-arrow-{{ $stats['booked_cars']['trend']['direction'] }}"></i> 
                        {{ $stats['booked_cars']['trend']['percentage'] }}% from last month
                    </p>
                </div>
            </div>
        </div>
    </div>

    <!-- Quick Actions -->
    <div class="quick-actions">
        <h2>Quick Actions</h2>
        <div class="action-buttons">
            <a href="{{ route('car-admin.new-registration-cars') }}" class="action-btn">
                <i class="fas fa-car"></i>
                <span>Car Registration Request</span>
            </a>
            <a href="{{ route('car-admin.inspection-requests') }}" class="action-btn">
                <i class="fas fa-clipboard-check"></i>
                <span>Manage Inspection Requests</span>
            </a>
            <a href="{{ route('car-admin.approve-inspected-cars') }}" class="action-btn">
                <i class="fas fa-check-circle"></i>
                <span>Approve/Reject Inspected Cars</span>
            </a>
            <a href="{{ url('admin/view-payments') }}" class="action-btn">
                <i class="fas fa-credit-card"></i>
                <span>View Payments</span>
            </a>
        </div>
    </div>

    <!-- Recent Activity & Stats Panel -->
    <div class="dashboard-panels">
        <!-- Recent Activity with Real Data -->
        <div class="panel recent-activity">
            <div class="panel-header">
                <h2>Recent Activity</h2>
                <!-- <a href="#" class="view-all">View All</a> -->
            </div>
            <div class="panel-content">
                <ul class="activity-list">
                    @forelse($recentActivities as $activity)
                        <li>
                            <div class="activity-icon {{ $activity['color'] }}">
                                <i class="{{ $activity['icon'] }}"></i>
                            </div>
                            <div class="activity-details">
                                <p>{{ $activity['message'] }}</p>
                                <span>{{ $activity['time'] }}</span>
                            </div>
                        </li>
                    @empty
                        <li>
                            <div class="activity-icon bg-secondary">
                                <i class="fas fa-info"></i>
                            </div>
                            <div class="activity-details">
                                <p>No recent activity</p>
                                <span>Start managing your car rental business!</span>
                            </div>
                        </li>
                    @endforelse
                </ul>
            </div>
        </div>

        <!-- Statistics with Real Data -->
        <div class="panel statistics">
            <div class="panel-header">
                <h2>Monthly Statistics</h2>
                <div class="panel-actions">
                    <select id="month-selector">
                        <option value="may">{{ Carbon\Carbon::now()->format('F Y') }}</option>
                        <option value="april">{{ Carbon\Carbon::now()->subMonth()->format('F Y') }}</option>
                        <option value="march">{{ Carbon\Carbon::now()->subMonths(2)->format('F Y') }}</option>
                    </select>
                </div>
            </div>
            <div class="panel-content">
                <div class="stat-container">
                    <div class="stat-item">
                        <h4>New Registrations</h4>
                        <div class="stat-progress">
                            <div class="progress-bar" style="width: {{ $monthlyStats['registrations']['percentage'] }}%"></div>
                            <span>{{ $monthlyStats['registrations']['percentage'] }}%</span>
                        </div>
                        <small>{{ $monthlyStats['registrations']['actual'] }}/{{ $monthlyStats['registrations']['target'] }} target</small>
                    </div>
                    <div class="stat-item">
                        <h4>Completed Inspections</h4>
                        <div class="stat-progress">
                            <div class="progress-bar" style="width: {{ $monthlyStats['inspections']['percentage'] }}%"></div>
                            <span>{{ $monthlyStats['inspections']['percentage'] }}%</span>
                        </div>
                        <small>{{ $monthlyStats['inspections']['actual'] }}/{{ $monthlyStats['inspections']['target'] }} target</small>
                    </div>
                    <div class="stat-item">
                        <h4>Approved Cars</h4>
                        <div class="stat-progress">
                            <div class="progress-bar" style="width: {{ $monthlyStats['approvals']['percentage'] }}%"></div>
                            <span>{{ $monthlyStats['approvals']['percentage'] }}%</span>
                        </div>
                        <small>{{ $monthlyStats['approvals']['actual'] }}/{{ $monthlyStats['approvals']['target'] }} target</small>
                    </div>
                    <div class="stat-item">
                        <h4>Total Revenue</h4>
                        <div class="stat-progress">
                            <div class="progress-bar" style="width: {{ $monthlyStats['revenue']['percentage'] }}%"></div>
                            <span>{{ $monthlyStats['revenue']['percentage'] }}%</span>
                        </div>
                        <small>BTN {{ number_format($monthlyStats['revenue']['actual'], 2) }}/BTN {{ number_format($monthlyStats['revenue']['target'], 2) }} target</small>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
    // Auto-refresh dashboard data every 5 minutes
    setInterval(function() {
        location.reload();
    }, 300000);
    
    // Month selector functionality (you can implement AJAX here)
    document.getElementById('month-selector').addEventListener('change', function() {
        // Implement month filtering functionality
        console.log('Month changed to:', this.value);
    });
</script>
@endpush

@endsection