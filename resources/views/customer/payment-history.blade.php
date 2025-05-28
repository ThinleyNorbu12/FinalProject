@extends('layouts.app')
@section('content')
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Payment History - Car Rental</title>
    <!-- Link to the external CSS file -->
    <link rel="stylesheet" href="{{ asset('assets/css/customer/dashboard.css') }}">
<!-- Bootstrap CSS -->
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
<!-- Font Awesome -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

<style>
    .payment-history-container {
        background-color: #fff;
        border-radius: 10px;
        box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
        padding: 25px;
        margin-bottom: 30px;
    }
    
    .payment-history-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 20px;
        border-bottom: 1px solid #eee;
        padding-bottom: 15px;
    }
    
    .payment-history-header h2 {
        font-size: 24px;
        margin: 0;
    }
    
    .payment-filters {
        display: flex;
        gap: 15px;
        margin-bottom: 20px;
    }
    
    .payment-filters select {
        padding: 8px 15px;
        border-radius: 5px;
        border: 1px solid #ddd;
    }
    
    .payment-table {
        width: 100%;
        border-collapse: collapse;
    }
    
    .payment-table th {
        background-color: #f8f9fa;
        padding: 12px 15px;
        text-align: left;
        font-weight: 600;
        color: #495057;
        border-bottom: 2px solid #dee2e6;
    }
    
    .payment-table td {
        padding: 12px 15px;
        border-bottom: 1px solid #eee;
        vertical-align: middle;
    }
    
    .payment-id {
        font-weight: 600;
        color: #2a3990;
    }
    
    .payment-date {
        color: #666;
        font-size: 0.9em;
    }
    
    .payment-amount {
        font-weight: 600;
    }
    
    .payment-status {
        padding: 5px 10px;
        border-radius: 20px;
        font-size: 0.85em;
        font-weight: 500;
        text-align: center;
        display: inline-block;
        min-width: 80px;
    }
    
    .status-paid {
        background-color: #d4edda;
        color: #155724;
    }
    
    .status-pending {
        background-color: #fff3cd;
        color: #856404;
    }
    
    .status-failed {
        background-color: #f8d7da;
        color: #721c24;
    }
    
    .status-refunded {
        background-color: #d1ecf1;
        color: #0c5460;
    }
    
    .payment-actions {
        display: flex;
        gap: 10px;
    }
    
    .btn-view-details {
        padding: 6px 12px;
        background-color: #e9ecef;
        color: #495057;
        border: none;
        border-radius: 4px;
        font-size: 0.85em;
        cursor: pointer;
        transition: all 0.2s;
    }
    
    .btn-view-details:hover {
        background-color: #dee2e6;
    }
    
    .btn-download-receipt {
        padding: 6px 12px;
        background-color: #2a3990;
        color: white;
        border: none;
        border-radius: 4px;
        font-size: 0.85em;
        cursor: pointer;
        transition: all 0.2s;
    }
    
    .btn-download-receipt:hover {
        background-color: #1e2a6b;
    }
    
    .payment-method-badge {
        padding: 4px 8px;
        border-radius: 4px;
        font-size: 0.8em;
        font-weight: 500;
        background-color: #f1f1f1;
        color: #333;
    }
    
    .payment-details-modal .modal-content {
        border-radius: 10px;
        overflow: hidden;
    }
    
    .payment-details-modal .modal-header {
        background-color: #2a3990;
        color: white;
        border-bottom: none;
    }
    
    .payment-details-modal .modal-title {
        font-weight: 600;
    }
    
    .payment-details-modal .modal-body {
        padding: 25px;
    }
    
    .payment-detail-row {
        margin-bottom: 15px;
        display: flex;
        flex-wrap: wrap;
    }
    
    .payment-detail-label {
        width: 40%;
        font-weight: 600;
        color: #495057;
    }
    
    .payment-detail-value {
        width: 60%;
    }
    
    .qr-screenshot {
        max-width: 100%;
        height: auto;
        border-radius: 6px;
        border: 1px solid #ddd;
        margin-top: 10px;
    }
    
    .pagination-container {
        margin-top: 20px;
        display: flex;
        justify-content: center;
    }
    
    .no-payments {
        text-align: center;
        padding: 30px;
        color: #666;
    }
    
    @media (max-width: 768px) {
        .payment-table {
            display: block;
            overflow-x: auto;
        }
        
        .payment-filters {
            flex-direction: column;
        }
        
        .payment-detail-label,
        .payment-detail-value {
            width: 100%;
        }
        
        .payment-detail-label {
            margin-bottom: 5px;
        }
    }
</style>
</head>
<body>
    <!-- Header -->
    <header class="main-header">
        <button class="header-menu-toggle" id="sidebarToggle">
            <i class="fas fa-bars"></i>
        </button>
    <div class="header-logo">
        <i class="fas fa-car"></i>
        <span style="font-size: 1.5rem !important; font-weight: 700 !important;">CAR RENTAL SYSTEM</span>
    </div>
    

    
    <div class="header-user">
        @if(Auth::guard('customer')->check())
            <span class="header-user-name">{{ Auth::guard('customer')->user()->name }}</span>
            <form method="POST" action="{{ route('customer.logout') }}" class="d-inline">
                @csrf
                <button type="submit" class="btn-logout">Logout</button>
            </form>
        @else
            <a href="{{ route('customer.login') }}" class="btn-logout">Login</a>
        @endif
    </div>        
</header>

<!-- Dashboard Container -->
<div class="dashboard-container">
    <!-- Sidebar -->
    <div class="sidebar" id="sidebar">
        <div class="sidebar-menu">
            <a href="{{ route('customer.dashboard') }}" class="sidebar-menu-item">
                <i class="fas fa-home"></i>
                <span>Dashboard</span>
            </a>
            
            <a href="{{ route('customer.browse-cars') }}" class="sidebar-menu-item">
                <i class="fas fa-car"></i>
                <span>Browse Cars</span>
            </a>
            
            <a href="{{ route('customer.my-reservations') }}" class="sidebar-menu-item ">
                <i class="fas fa-calendar-alt"></i>
                <span>My Reservations</span>
            </a>
            
            <div class="sidebar-divider"></div>
            
            <div class="sidebar-heading">My Account</div>
            
            <a href="{{ route('customer.profile') }}" class="sidebar-menu-item">
                <i class="fas fa-user"></i>
                <span>Profile</span>
            </a>
            
            <a href="{{ route('customer.rental-history') }}" class="sidebar-menu-item">
                <i class="fas fa-history"></i>
                <span>Rental History</span>
            </a>
            
            <a href="{{ route('customer.payment-history') }}" class="sidebar-menu-item active">
                <i class="fas fa-credit-card"></i>
                <span>Payment History</span>
            </a>

            <a href="{{ route('customer.paylater') }}" class="sidebar-menu-item">
                <i class="fas fa-money-bill-wave"></i>
                <span>Pay Later</span>
            </a>
            
            <a href="{{ route('customer.license') }}" class="sidebar-menu-item">
                <i class="fas fa-id-card"></i>
                <span>Driving License</span>
            </a>
            
            <div class="sidebar-divider"></div>
            
            <div class="sidebar-heading">Services</div>
            
            <a href="{{ route('customer.locations') }}" class="sidebar-menu-item ">
                <i class="fas fa-map-marked-alt"></i>
                <span>Locations</span>
             </a>
            
            <a href="{{ route('customer.insurance-options') }}" class="sidebar-menu-item ">
                <i class="fas fa-shield-alt"></i>
                <span>Insurance Options</span>
             </a>
            
            <a href="{{ route('customer.fuel-policy') }}" class="sidebar-menu-item ">
                <i class="fas fa-gas-pump"></i>
                <span>Fuel Policy</span>
            </a>
            
            
        </div>
    </div>
    
    <!-- Main Content -->
    <div class="main-content">
        <div class="payment-history-container">
            <div class="payment-history-header">
                <h2><i class="fas fa-credit-card"></i> Payment History</h2>
            </div>
            
            <div class="payment-filters">
                <select id="statusFilter">
                    <option value="all">All Statuses</option>
                    <option value="paid">Paid</option>
                    <option value="pending">Pending</option>
                    <option value="failed">Failed</option>
                    <option value="refunded">Refunded</option>
                </select>
                
                <select id="dateFilter">
                    <option value="all">All Time</option>
                    <option value="30days">Last 30 Days</option>
                    <option value="90days">Last 90 Days</option>
                    <option value="year">This Year</option>
                </select>
                
                <select id="methodFilter">
                    <option value="all">All Payment Methods</option>
                    <option value="card">Credit/Debit Card</option>
                    <option value="qr">QR Payment</option>
                    <option value="paylater">Pay Later</option>
                    <option value="cash">Cash</option>
                </select>
            </div>
            
            @if(count($paymentData) > 0)
            <div class="table-responsive">
                <table class="payment-table">
                    <thead>
                        <tr>
                            <th>Payment ID</th>
                            <th>Booking ID</th>
                            <th>Date</th>
                            <th>Amount</th>
                            <th>Method</th>
                            <th>Status</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($paymentData as $payment)
                        <tr>
                            <td class="payment-id">{{ $payment['reference_number'] }}</td>
                            <td>BK-{{ str_pad($payment['booking_id'], 6, '0', STR_PAD_LEFT) }}</td>
                            <td class="payment-date">{{ date('M d, Y', strtotime($payment['payment_date'])) }}</td>
                            <td class="payment-amount">{{ $payment['currency'] }} {{ number_format($payment['amount'], 2) }}</td>
                            <td>
                                @if(isset($payment['qr_payment']))
                                    <span class="payment-method-badge">QR Payment</span>
                                @elseif(isset($payment['pay_later']))
                                    <span class="payment-method-badge">Pay Later</span>
                                @else
                                    <span class="payment-method-badge">{{ ucfirst($payment['payment_method']) }}</span>
                                @endif
                            </td>
                            <td>
                                @php
                                    $statusClass = 'status-pending';
                                    if($payment['status'] == 'paid') {
                                        $statusClass = 'status-paid';
                                    } elseif($payment['status'] == 'failed') {
                                        $statusClass = 'status-failed';
                                    } elseif($payment['status'] == 'refunded') {
                                        $statusClass = 'status-refunded';
                                    }
                                @endphp
                                <span class="payment-status {{ $statusClass }}">{{ ucfirst($payment['status']) }}</span>
                            </td>
                            <td class="payment-actions">
                                <button 
                                    class="btn-view-details" 
                                    data-bs-toggle="modal" 
                                    data-bs-target="#paymentDetailsModal{{ $payment['id'] }}"
                                >
                                    View Details
                                </button>
                                @if($payment['status'] == 'paid')
                                <button class="btn-download-receipt">Receipt</button>
                                @endif
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            
            <div class="pagination-container">
                <!-- Pagination would go here - typically from Laravel's paginator -->
            </div>
            
            <!-- Payment Detail Modals -->
            @foreach($paymentData as $payment)
            <div class="modal payment-details-modal fade" id="paymentDetailsModal{{ $payment['id'] }}" tabindex="-1" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title">Payment Details</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <div class="payment-detail-row">
                                <div class="payment-detail-label">Payment ID:</div>
                                <div class="payment-detail-value">{{ $payment['reference_number'] }}</div>
                            </div>
                            
                            <div class="payment-detail-row">
                                <div class="payment-detail-label">Booking ID:</div>
                                <div class="payment-detail-value">BK-{{ str_pad($payment['booking_id'], 6, '0', STR_PAD_LEFT) }}</div>
                            </div>
                            
                            <div class="payment-detail-row">
                                <div class="payment-detail-label">Payment Date:</div>
                                <div class="payment-detail-value">{{ date('F d, Y H:i', strtotime($payment['payment_date'])) }}</div>
                            </div>
                            
                            <div class="payment-detail-row">
                                <div class="payment-detail-label">Amount:</div>
                                <div class="payment-detail-value">{{ $payment['currency'] }} {{ number_format($payment['amount'], 2) }}</div>
                            </div>
                            
                            <div class="payment-detail-row">
                                <div class="payment-detail-label">Payment Method:</div>
                                <div class="payment-detail-value">
                                    @if(isset($payment['qr_payment']))
                                        QR Payment ({{ $payment['qr_payment']->bank_code }})
                                    @elseif(isset($payment['pay_later']))
                                        Pay Later Payment
                                    @else
                                        {{ ucfirst($payment['payment_method']) }}
                                    @endif
                                </div>
                            </div>
                            
                            <div class="payment-detail-row">
                                <div class="payment-detail-label">Status:</div>
                                <div class="payment-detail-value">
                                    @php
                                        $statusClass = 'status-pending';
                                        if($payment['status'] == 'paid') {
                                            $statusClass = 'status-paid';
                                        } elseif($payment['status'] == 'failed') {
                                            $statusClass = 'status-failed';
                                        } elseif($payment['status'] == 'refunded') {
                                            $statusClass = 'status-refunded';
                                        }
                                    @endphp
                                    <span class="payment-status {{ $statusClass }}">{{ ucfirst($payment['status']) }}</span>
                                </div>
                            </div>
                            
                            @if(isset($payment['pay_later']))
                            <div class="payment-detail-row">
                                <div class="payment-detail-label">Collection Date:</div>
                                <div class="payment-detail-value">{{ date('F d, Y', strtotime($payment['pay_later']->collection_date)) }}</div>
                            </div>
                            
                            <div class="payment-detail-row">
                                <div class="payment-detail-label">Collection Method:</div>
                                <div class="payment-detail-value">{{ ucfirst($payment['pay_later']->collection_method) }}</div>
                            </div>
                            
                            @if($payment['pay_later']->notes)
                            <div class="payment-detail-row">
                                <div class="payment-detail-label">Notes:</div>
                                <div class="payment-detail-value">{{ $payment['pay_later']->notes }}</div>
                            </div>
                            @endif
                            @endif
                            
                            @if(isset($payment['qr_payment']))
                            <div class="payment-detail-row">
                                <div class="payment-detail-label">Bank:</div>
                                <div class="payment-detail-value">{{ $payment['qr_payment']->bank_code }}</div>
                            </div>
                            
                            <div class="payment-detail-row">
                                <div class="payment-detail-label">Verification Status:</div>
                                <div class="payment-detail-value">
                                    @if($payment['qr_payment']->verification_status == 'verified')
                                        <span class="payment-status status-paid">Verified</span>
                                    @else
                                        <span class="payment-status status-pending">Pending Verification</span>
                                    @endif
                                </div>
                            </div>
                            
                           @if(isset($payment['qr_payment']) && $payment['qr_payment']->screenshot_path)

                                <p><strong>QR Payment Screenshot:</strong></p>
                                <img src="{{ asset('qr_payments/' . $payment['qr_payment']->screenshot_path) }}" 
                                    alt="QR Payment Screenshot" 
                                    style="max-width: 300px; border: 1px solid #ccc; padding: 5px;">

                            @endif
                            @endif


                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                            @if($payment['status'] == 'paid')
                            <button type="button" class="btn btn-primary">Download Receipt</button>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
            @endforeach
            
            @else
            <div class="no-payments">
                <i class="fas fa-receipt fa-3x mb-3"></i>
                <h4>No payment history found</h4>
                <p>You haven't made any payments yet. Once you make a reservation, your payment history will appear here.</p>
            </div>
            @endif
        </div>
    </div>
</div>

<!-- Bootstrap JS Bundle with Popper -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>

<script>
    // Toggle sidebar
    document.addEventListener('DOMContentLoaded', function() {
        const sidebarToggle = document.getElementById('sidebarToggle');
        const sidebar = document.getElementById('sidebar');
        
        sidebarToggle.addEventListener('click', function() {
            sidebar.classList.toggle('expanded');
        });
        
        // Close sidebar when clicking outside on mobile
        document.addEventListener('click', function(event) {
            const isClickInsideSidebar = sidebar.contains(event.target);
            const isClickOnToggle = sidebarToggle.contains(event.target);
            
            if (!isClickInsideSidebar && !isClickOnToggle && window.innerWidth <= 576) {
                sidebar.classList.remove('expanded');
            }
        });
        
        // Resize handler
        window.addEventListener('resize', function() {
            if (window.innerWidth > 576) {
                sidebar.classList.remove('expanded');
            }
        });
        
        // Payment filters
        const statusFilter = document.getElementById('statusFilter');
        const dateFilter = document.getElementById('dateFilter');
        const methodFilter = document.getElementById('methodFilter');
        
        // Basic client-side filtering implementation
        // In a real application, this would likely be connected to server-side filtering
        const handleFilter = () => {
            const status = statusFilter.value;
            const date = dateFilter.value;
            const method = methodFilter.value;
            
            // This would typically be an AJAX call to reload filtered data
            console.log(`Filtering payments: Status=${status}, Date=${date}, Method=${method}`);
            
            // For demonstration purposes, we're just logging the filter values
            // In reality, this would trigger a new data fetch from the server
        };
        
        statusFilter.addEventListener('change', handleFilter);
        dateFilter.addEventListener('change', handleFilter);
        methodFilter.addEventListener('change', handleFilter);
    });
</script>
</body>
</html>
@endsection