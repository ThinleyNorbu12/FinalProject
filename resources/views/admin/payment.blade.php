<!-- resources/views/admin/payments/index.blade.php -->
@extends('layouts.app')

@section('content')
<link rel="stylesheet" href="{{ asset('assets/css/admin/adminsidebar.css') }}">
<div class="dashboard-sidebar">
    <div class="sidebar-header">
        <div class="logo">
            <img src="{{ asset('assets/images/logo.png') }}" alt="Logo">
            <h2>Admin Portal</h2>
        </div>
        <button id="sidebar-toggle" class="sidebar-toggle">
            <i class="fas fa-bars"></i>
        </button>
    </div>
    
    <div class="admin-profile">
        @if(Auth::guard('admin')->check())
            <div class="profile-avatar">
                <img src="{{ asset('assets/images/thinley.jpg') }}" alt="Admin Avatar">
            </div>
            <div class="profile-info">
                <h3>{{ Auth::guard('admin')->user()->name }}</h3>
                <span>Administrator</span>
            </div>
        @endif
    </div>
    
    <nav class="sidebar-nav">
        <ul>
            <li>
                <a href="{{ route('admin.dashboard') }}" class="sidebar-menu-item">
                    <i class="fas fa-tachometer-alt"></i>
                    <span>Dashboard</span>
                </a>
            </li>
    
            <div class="sidebar-divider"></div>
    
            <div class="sidebar-heading">Car Owner</div>
    
            <li>
                <a href="{{ route('car-admin.new-registration-cars') }}" class="sidebar-menu-item">
                    <i class="fas fa-car"></i>
                    <span>Car Registration</span>
                </a>
            </li>
            <li>
                <a href="{{ route('car-admin.inspection-requests') }}" class="sidebar-menu-item ">
                    <i class="fas fa-clipboard-check"></i>
                    <span>Inspection Requests</span>
                </a>
            </li>
            <li>
                <a href="{{ route('car-admin.approve-inspected-cars') }}" class="sidebar-menu-item ">
                    <i class="fas fa-check-circle"></i>
                    <span>Approve Inspections</span>
                </a>
            </li>
    
            <div class="sidebar-divider"></div>
    
            <div class="sidebar-heading">Customer</div>
    
            <li>
                <a href="{{ route('admin.verify-users') }}" class="sidebar-menu-item">
                    <i class="fas fa-id-card"></i>
                    <span>Verify Users</span>
                </a>
            </li>
            <li>
                <a href="{{ route('admin.payments.index') }}" class="sidebar-menu-item active">
                    <i class="fas fa-credit-card"></i>
                    <span>Payments</span>
                </a>
            </li>
            <li>
                <a href="{{ url('admin/update-car-registration') }}" class="sidebar-menu-item">
                    <i class="fas fa-edit"></i>
                    <span>Update Registration</span>
                </a>
            </li>
            <li>
                <a href="{{ url('admin/car-information-update') }}" class="sidebar-menu-item">
                    <i class="fas fa-info-circle"></i>
                    <span>Car Information</span>
                </a>
            </li>
            <li>
                <a href="{{ url('admin/booked-car') }}" class="sidebar-menu-item">
                    <i class="fas fa-calendar-check"></i>
                    <span>Booked Cars</span>
                </a>
            </li>
    
            <li>
                <a href="#" class="sidebar-menu-item" onclick="document.getElementById('logout-form').submit();">
                    <i class="fas fa-sign-out-alt"></i>
                    <span>Logout</span>
                </a>
                <form method="POST" action="{{ route('admin.logout') }}" id="logout-form">
                    @csrf
                </form>
            </li>
        </ul>
    </nav>        
</div>
<style>
        /* Payment Management Main Layout Styles */
    .dashboard-content {
    padding: 1.5rem;
    width: 100%;
    transition: all 0.3s ease;
    }

    /* Responsive layout with sidebar */
    @media (min-width: 992px) {
    .dashboard-content {
        margin-left: 250px; /* Adjust this to match your sidebar width */
    }
    
    body.sidebar-collapsed .dashboard-content {
        margin-left: 70px; /* Adjust for collapsed sidebar width */
    }
    }

    /* Header Section */
    .dashboard-header-section {
    margin-bottom: 1.5rem;
    padding-bottom: 1rem;
    border-bottom: 1px solid #e0e0e0;
    }

    .dashboard-header-section h1 {
    margin-bottom: 0.5rem;
    font-size: 1.8rem;
    font-weight: 600;
    color: #333;
    }

    .breadcrumb {
    background: transparent;
    padding: 0;
    margin-bottom: 0;
    }

    .breadcrumb-item a {
    color: #007bff;
    text-decoration: none;
    }

    .breadcrumb-item.active {
    color: #6c757d;
    }

    /* Stat Cards */
    .dashboard-cards {
    display: grid;
    grid-template-columns: repeat(auto-fill, minmax(240px, 1fr));
    gap: 1rem;
    margin-bottom: 1.5rem;
    }

    .card {
    border-radius: 8px;
    box-shadow: 0 2px 10px rgba(0, 0, 0, 0.05);
    border: none;
    transition: transform 0.2s, box-shadow 0.2s;
    }

    .card:hover {
    transform: translateY(-3px);
    box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
    }

    .card-inner {
    display: flex;
    align-items: center;
    padding: 1.25rem;
    }

    .card-icon {
    display: flex;
    align-items: center;
    justify-content: center;
    width: 50px;
    height: 50px;
    border-radius: 10px;
    margin-right: 1rem;
    color: white;
    }

    .bg-primary {
    background-color: #007bff;
    }

    .bg-success {
    background-color: #28a745;
    }

    .bg-warning {
    background-color: #ffc107;
    }

    .bg-danger {
    background-color: #dc3545;
    }

    .card-content h3 {
    font-size: 0.9rem;
    margin-bottom: 0.25rem;
    color: #6c757d;
    }

    .card-content .count {
    font-size: 1.5rem;
    font-weight: 600;
    margin: 0;
    color: #333;
    }

    /* Panel Styles */
    .panel {
    background-color: #fff;
    border-radius: 8px;
    box-shadow: 0 2px 10px rgba(0, 0, 0, 0.05);
    margin-bottom: 1.5rem;
    }

    .panel-header {
    display: flex;
    justify-content: space-between;
    align-items: center;
    padding: 1rem 1.5rem;
    border-bottom: 1px solid #e0e0e0;
    flex-wrap: wrap;
    gap: 1rem;
    }

    .panel-header h2 {
    font-size: 1.2rem;
    font-weight: 600;
    margin: 0;
    }

    .panel-actions {
    display: flex;
    gap: 0.5rem;
    }

    .panel-content {
    padding: 1.5rem;
    }

    /* Form Elements */
    .form-inline {
    display: flex;
    flex-wrap: wrap;
    gap: 0.5rem;
    }

    .input-group {
    display: flex;
    flex-wrap: wrap;
    gap: 0.5rem;
    }

    .form-control {
    border-radius: 4px;
    border: 1px solid #ced4da;
    padding: 0.375rem 0.75rem;
    }

    .btn {
    border-radius: 4px;
    padding: 0.375rem 0.75rem;
    font-weight: 500;
    }

    .btn-primary {
    background-color: #007bff;
    border-color: #007bff;
    color: white;
    }

    .btn-sm {
    padding: 0.25rem 0.5rem;
    font-size: 0.875rem;
    }

    /* Table Styles */
    .table-responsive {
    overflow-x: auto;
    -webkit-overflow-scrolling: touch;
    }

    .table {
    width: 100%;
    margin-bottom: 0;
    color: #212529;
    border-collapse: collapse;
    }

    .table th {
    padding: 0.75rem;
    vertical-align: top;
    border-top: 1px solid #dee2e6;
    background-color: #f8f9fa;
    font-weight: 600;
    }

    .table td {
    padding: 0.75rem;
    vertical-align: middle;
    border-top: 1px solid #dee2e6;
    }

    .table-hover tbody tr:hover {
    background-color: rgba(0, 123, 255, 0.05);
    }

    .badge {
    display: inline-block;
    padding: 0.25em 0.6em;
    font-size: 75%;
    font-weight: 500;
    line-height: 1;
    text-align: center;
    white-space: nowrap;
    vertical-align: baseline;
    border-radius: 0.25rem;
    color: white;
    }

    /* Pagination */
    .pagination-container {
    margin-top: 1.5rem;
    display: flex;
    justify-content: center;
    }

    .pagination {
    display: flex;
    padding-left: 0;
    list-style: none;
    border-radius: 0.25rem;
    }

    .pagination .page-item .page-link {
    position: relative;
    display: block;
    padding: 0.5rem 0.75rem;
    margin-left: -1px;
    line-height: 1.25;
    color: #007bff;
    background-color: #fff;
    border: 1px solid #dee2e6;
    }

    .pagination .page-item.active .page-link {
    z-index: 3;
    color: #fff;
    background-color: #007bff;
    border-color: #007bff;
    }

    /* Modal Styles */
    .modal-content {
    border-radius: 8px;
    border: none;
    box-shadow: 0 5px 20px rgba(0, 0, 0, 0.1);
    }

    .modal-header {
    border-bottom: 1px solid #e0e0e0;
    padding: 1rem 1.5rem;
    }

    .modal-body {
    padding: 1.5rem;
    }

    .modal-footer {
    border-top: 1px solid #e0e0e0;
    padding: 1rem 1.5rem;
    }

    .img-fluid {
    max-width: 100%;
    height: auto;
    border-radius: 4px;
    }

    /* Additional Responsive Adjustments */
    @media (max-width: 991.98px) {
    .dashboard-content {
        margin-left: 0;
        padding: 1rem;
    }
    
    .dashboard-header-section h1 {
        font-size: 1.5rem;
    }
    
    .panel-header {
        flex-direction: column;
        align-items: flex-start;
    }
    
    .panel-actions {
        width: 100%;
        margin-top: 0.5rem;
    }
    
    .form-inline, 
    .input-group {
        width: 100%;
    }
    
    .form-control, 
    .btn {
        width: 100%;
    }
    }

    @media (max-width: 767.98px) {
    .dashboard-cards {
        grid-template-columns: 1fr;
    }
    
    .table th, 
    .table td {
        padding: 0.5rem;
    }
    
    .dashboard-header-section {
        margin-bottom: 1rem;
    }
    
    .panel-content {
        padding: 1rem;
    }
    }

    /* For mobile screens */
    @media (max-width: 575.98px) {
    .card-inner {
        flex-direction: column;
        text-align: center;
    }
    
    .card-icon {
        margin-right: 0;
        margin-bottom: 0.75rem;
    }
    }

    /* For sidebar toggle functionality */
    .sidebar-toggle-btn {
    display: none;
    }

    @media (max-width: 991.98px) {
    .sidebar-toggle-btn {
        display: block;
        position: fixed;
        top: 1rem;
        left: 1rem;
        z-index: 1030;
        padding: 0.25rem 0.5rem;
        background-color: #fff;
        border-radius: 4px;
        box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
    }
    }
</style>
@section('content')
<!-- Main Content -->
<div class="dashboard-content">
    <!-- Page Header -->
    <div class="dashboard-header-section">
        <h1>Payment Management</h1>
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
                <li class="breadcrumb-item active" aria-current="page">Payments</li>
            </ol>
        </nav>
    </div>

    <!-- Payments Stats Cards -->
    <div class="dashboard-cards payments-stats">
        <div class="card">
            <div class="card-inner">
                <div class="card-icon bg-primary">
                    <i class="fas fa-credit-card"></i>
                </div>
                <div class="card-content">
                    <h3>Total Payments</h3>
                    <p class="count">{{ $payments->total() }}</p>
                </div>
            </div>
        </div>

        <div class="card">
            <div class="card-inner">
                <div class="card-icon bg-success">
                    <i class="fas fa-check-circle"></i>
                </div>
                <div class="card-content">
                    <h3>Completed</h3>
                    <p class="count">{{ $payments->where('status', 'completed')->count() }}</p>
                </div>
            </div>
        </div>

        <div class="card">
            <div class="card-inner">
                <div class="card-icon bg-warning">
                    <i class="fas fa-clock"></i>
                </div>
                <div class="card-content">
                    <h3>Pending</h3>
                    <p class="count">{{ $payments->whereIn('status', ['pending', 'pending_verification', 'processing'])->count() }}</p>
                </div>
            </div>
        </div>

        <div class="card">
            <div class="card-inner">
                <div class="card-icon bg-danger">
                    <i class="fas fa-times-circle"></i>
                </div>
                <div class="card-content">
                    <h3>Failed/Cancelled</h3>
                    <p class="count">{{ $payments->whereIn('status', ['failed', 'cancelled'])->count() }}</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Payments Table Panel -->
    <div class="panel payments-panel">
        <div class="panel-header">
            <h2>All Payments</h2>
            <div class="panel-actions">
                <form action="{{ route('admin.payments.index') }}" method="GET" class="form-inline">
                    <div class="input-group">
                        <input type="text" name="search" class="form-control" placeholder="Search reference..." value="{{ request('search') }}">
                        <select name="status" class="form-control">
                            <option value="">All Statuses</option>
                            <option value="pending" {{ request('status') == 'pending' ? 'selected' : '' }}>Pending</option>
                            <option value="pending_verification" {{ request('status') == 'pending_verification' ? 'selected' : '' }}>Pending Verification</option>
                            <option value="processing" {{ request('status') == 'processing' ? 'selected' : '' }}>Processing</option>
                            <option value="completed" {{ request('status') == 'completed' ? 'selected' : '' }}>Completed</option>
                            <option value="failed" {{ request('status') == 'failed' ? 'selected' : '' }}>Failed</option>
                            <option value="refunded" {{ request('status') == 'refunded' ? 'selected' : '' }}>Refunded</option>
                            <option value="cancelled" {{ request('status') == 'cancelled' ? 'selected' : '' }}>Cancelled</option>
                        </select>
                        <button type="submit" class="btn btn-primary">Filter</button>
                    </div>
                </form>
            </div>
        </div>
        <div class="panel-content">
            <div class="table-responsive">
                <table class="table table-hover">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Reference</th>
                            <th>Customer</th>
                            <th>Method</th>
                            <th>Amount</th>
                            <th>Status</th>
                            <th>Date</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($payments as $payment)
                        <tr>
                            <td>{{ $payment->id }}</td>
                            <td>{{ $payment->reference_number }}</td>
                            <td>
                                @if($payment->customer)
                                    {{ $payment->customer->name }}
                                @else
                                    Unknown
                                @endif
                            </td>
                            <td>
                                @switch($payment->payment_method)
                                    @case('qr_code')
                                        <span class="badge bg-info">QR Code</span>
                                        @break
                                    @case('bank_transfer')
                                        <span class="badge bg-primary">Bank Transfer</span>
                                        @break
                                    @case('pay_later')
                                        <span class="badge bg-warning">Pay Later</span>
                                        @break
                                    @case('card')
                                        <span class="badge bg-success">Card</span>
                                        @break
                                    @default
                                        <span class="badge bg-secondary">{{ $payment->payment_method }}</span>
                                @endswitch
                            </td>
                            <td>{{ number_format($payment->amount, 2) }} {{ $payment->currency }}</td>
                            <td>
                                @switch($payment->status)
                                    @case('pending')
                                        <span class="badge bg-warning">Pending</span>
                                        @break
                                    @case('pending_verification')
                                        <span class="badge bg-info">Pending Verification</span>
                                        @break
                                    @case('processing')
                                        <span class="badge bg-primary">Processing</span>
                                        @break
                                    @case('completed')
                                        <span class="badge bg-success">Completed</span>
                                        @break
                                    @case('failed')
                                        <span class="badge bg-danger">Failed</span>
                                        @break
                                    @case('refunded')
                                        <span class="badge bg-secondary">Refunded</span>
                                        @break
                                    @case('cancelled')
                                        <span class="badge bg-danger">Cancelled</span>
                                        @break
                                    @default
                                        <span class="badge bg-secondary">{{ $payment->status }}</span>
                                @endswitch
                            </td>
                            <td>{{ $payment->payment_date->format('M d, Y H:i') }}</td>
                            <td>
                                <a href="{{ route('admin.payments.show', $payment->id) }}" class="btn btn-sm btn-info">
                                    <i class="fas fa-eye"></i>
                                </a>
                                
                                @if($payment->payment_method == 'qr_code' && $payment->status == 'pending_verification')
                                <a href="#" class="btn btn-sm btn-success" data-bs-toggle="modal" data-bs-target="#verifyModal{{ $payment->id }}">
                                    <i class="fas fa-check"></i>
                                </a>
                                @endif
                                
                                @if($payment->payment_method == 'pay_later' && $payment->payLaterPayment && $payment->payLaterPayment->status != 'paid')
                                <a href="#" class="btn btn-sm btn-primary" data-bs-toggle="modal" data-bs-target="#collectModal{{ $payment->id }}">
                                    <i class="fas fa-hand-holding-usd"></i>
                                </a>
                                @endif
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="8" class="text-center">No payments found</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            
            <!-- Pagination Links -->
            <div class="pagination-container">
                {{ $payments->links() }}
            </div>
        </div>
    </div>
</div>

<!-- Verification Modals -->
@foreach($payments as $payment)
    @if($payment->payment_method == 'qr_code' && $payment->status == 'pending_verification')
    <div class="modal fade" id="verifyModal{{ $payment->id }}" tabindex="-1" aria-labelledby="verifyModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="verifyModalLabel">Verify QR Payment</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form action="{{ route('admin.payments.verify-qr', $payment->id) }}" method="POST">
                    @csrf
                    <div class="modal-body">
                        <p><strong>Reference:</strong> {{ $payment->reference_number }}</p>
                        <p><strong>Amount:</strong> {{ number_format($payment->amount, 2) }} {{ $payment->currency }}</p>
                        
                        @if($payment->qrPayment && $payment->qrPayment->screenshot_path)
                        <div class="mb-3">
                            <label class="form-label">Payment Screenshot:</label>
                            <div>
                                <img src="{{ asset('storage/' . $payment->qrPayment->screenshot_path) }}" alt="QR Payment Screenshot" class="img-fluid">
                            </div>
                        </div>
                        @endif
                        
                        <div class="mb-3">
                            <label for="verification_status" class="form-label">Verification Decision:</label>
                            <select name="verification_status" id="verification_status" class="form-control" required>
                                <option value="">-- Select --</option>
                                <option value="confirmed">Confirm Payment</option>
                                <option value="rejected">Reject Payment</option>
                            </select>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary">Submit Decision</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    @endif
    
    @if($payment->payment_method == 'pay_later' && $payment->payLaterPayment && $payment->payLaterPayment->status != 'paid')
    <div class="modal fade" id="collectModal{{ $payment->id }}" tabindex="-1" aria-labelledby="collectModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="collectModalLabel">Collect Pay Later Payment</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form action="{{ route('admin.payments.collect-pay-later', $payment->id) }}" method="POST">
                    @csrf
                    <div class="modal-body">
                        <p><strong>Reference:</strong> {{ $payment->reference_number }}</p>
                        <p><strong>Amount Due:</strong> {{ number_format($payment->amount, 2) }} {{ $payment->currency }}</p>
                        
                        <div class="mb-3">
                            <label for="collection_method" class="form-label">Collection Method:</label>
                            <select name="collection_method" id="collection_method" class="form-control" required>
                                <option value="">-- Select Method --</option>
                                <option value="cash">Cash</option>
                                <option value="card">Card</option>
                                <option value="bank_transfer">Bank Transfer</option>
                                <option value="qr_code">QR Code</option>
                            </select>
                        </div>
                        
                        <div class="mb-3">
                            <label for="notes" class="form-label">Notes:</label>
                            <textarea name="notes" id="notes" class="form-control" rows="3"></textarea>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary">Record Payment</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    @endif
@endforeach
@endsection

@section('scripts')
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
@endsection