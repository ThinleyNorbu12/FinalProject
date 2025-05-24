<!-- resources/views/admin/payments/index.blade.php -->
@extends('layouts.admin')

@section('title', 'Payment Management')

@section('content')
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
            <form action="{{ route('admin.payments.index') }}" method="GET" class="filter-form">
                <div class="filter-group">
                    <div class="filter-item">
                        <input type="text" name="search" class="form-control" placeholder="Search reference, customer..." value="{{ request('search') }}">
                    </div>
                    <div class="filter-item">
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
                    </div>
                    <div class="filter-item">
                        <select name="payment_method" class="form-control">
                            <option value="">All Methods</option>
                            <option value="qr_code" {{ request('payment_method') == 'qr_code' ? 'selected' : '' }}>QR Code</option>
                            <option value="bank_transfer" {{ request('payment_method') == 'bank_transfer' ? 'selected' : '' }}>Bank Transfer</option>
                            <option value="pay_later" {{ request('payment_method') == 'pay_later' ? 'selected' : '' }}>Pay Later</option>
                            <option value="card" {{ request('payment_method') == 'card' ? 'selected' : '' }}>Card</option>
                        </select>
                    </div>
                    <div class="filter-item">
                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-search"></i> Filter
                        </button>
                    </div>
                    <div class="filter-item">
                        <a href="{{ route('admin.payments.index') }}" class="btn btn-secondary">
                            <i class="fas fa-times"></i> Clear
                        </a>
                    </div>
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
                            <a href="{{ route('admin.payments.show', $payment->id) }}" class="btn btn-sm btn-info" title="View Details">
                                <i class="fas fa-eye"></i>
                            </a>
                            
                            @if($payment->payment_method == 'qr_code' && $payment->status == 'pending_verification')
                            <a href="#" class="btn btn-sm btn-success" data-bs-toggle="modal" data-bs-target="#verifyModal{{ $payment->id }}" title="Verify Payment">
                                <i class="fas fa-check"></i>
                            </a>
                            @endif
                            
                            @if($payment->payment_method == 'pay_later' && $payment->payLaterPayment && $payment->payLaterPayment->status != 'paid')
                            <a href="#" class="btn btn-sm btn-primary" data-bs-toggle="modal" data-bs-target="#collectModal{{ $payment->id }}" title="Collect Payment">
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

<!-- Verification Modals -->
@foreach($payments as $payment)
    @if($payment->payment_method == 'qr_code' && $payment->status == 'pending_verification')
    <div class="modal fade" id="verifyModal{{ $payment->id }}" tabindex="-1" aria-labelledby="verifyModalLabel{{ $payment->id }}" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="verifyModalLabel{{ $payment->id }}">Verify QR Payment</h5>
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
                                <img src="{{ asset('storage/' . $payment->qrPayment->screenshot_path) }}" alt="QR Payment Screenshot" class="img-fluid" style="max-height: 300px;">
                            </div>
                        </div>
                        @endif
                        
                        <div class="mb-3">
                            <label for="verification_status{{ $payment->id }}" class="form-label">Verification Decision:</label>
                            <select name="verification_status" id="verification_status{{ $payment->id }}" class="form-control" required>
                                <option value="">-- Select --</option>
                                <option value="confirmed">Confirm Payment</option>
                                <option value="rejected">Reject Payment</option>
                            </select>
                        </div>
                        
                        <div class="mb-3">
                            <label for="admin_notes{{ $payment->id }}" class="form-label">Admin Notes (Optional):</label>
                            <textarea name="admin_notes" id="admin_notes{{ $payment->id }}" class="form-control" rows="3" placeholder="Add any notes about this verification..."></textarea>
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
    <div class="modal fade" id="collectModal{{ $payment->id }}" tabindex="-1" aria-labelledby="collectModalLabel{{ $payment->id }}" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="collectModalLabel{{ $payment->id }}">Collect Pay Later Payment</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form action="{{ route('admin.payments.collect-pay-later', $payment->id) }}" method="POST">
                    @csrf
                    <div class="modal-body">
                        <p><strong>Reference:</strong> {{ $payment->reference_number }}</p>
                        <p><strong>Amount Due:</strong> {{ number_format($payment->amount, 2) }} {{ $payment->currency }}</p>
                        <p><strong>Customer:</strong> {{ $payment->customer ? $payment->customer->name : 'Unknown' }}</p>
                        
                        <div class="mb-3">
                            <label for="collection_method{{ $payment->id }}" class="form-label">Collection Method:</label>
                            <select name="collection_method" id="collection_method{{ $payment->id }}" class="form-control" required>
                                <option value="">-- Select Method --</option>
                                <option value="cash">Cash</option>
                                <option value="card">Card</option>
                                <option value="bank_transfer">Bank Transfer</option>
                                <option value="qr_code">QR Code</option>
                            </select>
                        </div>
                        
                        <div class="mb-3">
                            <label for="collection_amount{{ $payment->id }}" class="form-label">Amount Collected:</label>
                            <input type="number" name="collection_amount" id="collection_amount{{ $payment->id }}" 
                                   class="form-control" step="0.01" value="{{ $payment->amount }}" required>
                        </div>
                        
                        <div class="mb-3">
                            <label for="notes{{ $payment->id }}" class="form-label">Notes:</label>
                            <textarea name="notes" id="notes{{ $payment->id }}" class="form-control" rows="3" placeholder="Add any notes about this collection..."></textarea>
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

@push('styles')
<style>
.payments-stats {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
    gap: 1.5rem;
    margin-bottom: 2rem;
}

.payments-stats .card {
    background: #fff;
    border-radius: 10px;
    box-shadow: 0 2px 10px rgba(0,0,0,0.1);
    overflow: hidden;
    transition: transform 0.3s ease;
}

.payments-stats .card:hover {
    transform: translateY(-5px);
}

.card-inner {
    display: flex;
    align-items: center;
    padding: 1.5rem;
}

.card-icon {
    width: 60px;
    height: 60px;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    margin-right: 1rem;
    font-size: 1.5rem;
    color: white;
}

.card-icon.bg-primary { background-color: #007bff; }
.card-icon.bg-success { background-color: #28a745; }
.card-icon.bg-warning { background-color: #ffc107; }
.card-icon.bg-danger { background-color: #dc3545; }

.card-content h3 {
    margin: 0 0 0.5rem 0;
    font-size: 1rem;
    font-weight: 600;
    color: #666;
}

.card-content .count {
    margin: 0;
    font-size: 2rem;
    font-weight: 700;
    color: #333;
}

.panel {
    background: #fff;
    border-radius: 10px;
    box-shadow: 0 2px 10px rgba(0,0,0,0.1);
    overflow: hidden;
}

.panel-header {
    padding: 1.5rem;
    border-bottom: 1px solid #eee;
    display: flex;
    justify-content: between;
    align-items: center;
    flex-wrap: wrap;
    gap: 1rem;
}

.panel-header h2 {
    margin: 0;
    font-size: 1.25rem;
    font-weight: 600;
}

.filter-form {
    width: 100%;
}

.filter-group {
    display: flex;
    gap: 0.5rem;
    align-items: center;
    flex-wrap: wrap;
}

.filter-item {
    display: flex;
    align-items: center;
}

.filter-item .form-control {
    min-width: 150px;
    height: 38px;
}

.filter-item .btn {
    height: 38px;
    display: flex;
    align-items: center;
    gap: 0.5rem;
}

.panel-content {
    padding: 0;
}

.table th {
    background-color: #f8f9fa;
    font-weight: 600;
    border-bottom: 2px solid #dee2e6;
}

.pagination-container {
    padding: 1rem 1.5rem;
    border-top: 1px solid #eee;
}

.modal-body img {
    border-radius: 8px;
    border: 1px solid #ddd;
}

@media (max-width: 768px) {
    .panel-header {
        flex-direction: column;
        align-items: stretch;
    }
    
    .filter-group {
        flex-direction: column;
        align-items: stretch;
    }
    
    .filter-item {
        width: 100%;
        margin-bottom: 0.5rem;
    }
    
    .filter-item .form-control,
    .filter-item .btn {
        width: 100%;
        min-width: auto;
    }
}
</style>
@endpush

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Auto-refresh payment status every 30 seconds
    setInterval(function() {
        // Only refresh if no modals are open
        if (!document.querySelector('.modal.show')) {
            location.reload();
        }
    }, 30000);
    
    // Form validation for verification modals
    document.querySelectorAll('form[action*="verify-qr"]').forEach(function(form) {
        form.addEventListener('submit', function(e) {
            const select = form.querySelector('select[name="verification_status"]');
            if (!select.value) {
                e.preventDefault();
                alert('Please select a verification decision.');
                select.focus();
            }
        });
    });
    
    // Form validation for collection modals
    document.querySelectorAll('form[action*="collect-pay-later"]').forEach(function(form) {
        form.addEventListener('submit', function(e) {
            const method = form.querySelector('select[name="collection_method"]');
            const amount = form.querySelector('input[name="collection_amount"]');
            
            if (!method.value) {
                e.preventDefault();
                alert('Please select a collection method.');
                method.focus();
                return;
            }
            
            if (!amount.value || parseFloat(amount.value) <= 0) {
                e.preventDefault();
                alert('Please enter a valid collection amount.');
                amount.focus();
                return;
            }
        });
    });
});
</script>
@endpush