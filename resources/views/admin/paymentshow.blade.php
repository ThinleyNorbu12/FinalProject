@extends('layouts.admin')

@section('title', 'Payment Details')

@push('styles')
     <link rel="stylesheet" href="{{ asset('assets/css/admin/paymentshow.css') }}">
@endpush

@section('content')
<div class="dashboard-content">
    <!-- Page Header -->
    <div class="dashboard-header-section">
        <h1>Payment Details</h1>
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
                <li class="breadcrumb-item"><a href="{{ route('admin.payments.index') }}">Payments</a></li>
                <li class="breadcrumb-item active" aria-current="page">Payments Details</li>
            </ol>
        </nav>
    </div>

    <!-- Payment Details Card -->
    <div class="card mb-4">
        <div class="card-header d-flex justify-content-between align-items-center">
            <h3>Payment #{{ $payment->reference_number }}</h3>
            <div>
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
            </div>
        </div>
        <div class="card-body">
            <div class="row">
                <div class="col-md-6">
                    <h4>Payment Information</h4>
                    <table class="table">
                        <tr>
                            <th>ID:</th>
                            <td>{{ $payment->id }}</td>
                        </tr>
                        <tr>
                            <th>Reference Number:</th>
                            <td>{{ $payment->reference_number }}</td>
                        </tr>
                        <tr>
                            <th>Amount:</th>
                            <td>{{ number_format($payment->amount, 2) }} {{ $payment->currency }}</td>
                        </tr>
                        <tr>
                            <th>Payment Method:</th>
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
                        </tr>
                        <tr>
                            <th>Status:</th>
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
                        </tr>
                        <tr>
                            <th>Payment Date:</th>
                            <td>{{ $payment->payment_date->format('F d, Y H:i:s') }}</td>
                        </tr>
                        @if($payment->description)
                        <tr>
                            <th>Description:</th>
                            <td>{{ $payment->description }}</td>
                        </tr>
                        @endif
                    </table>
                </div>
                <div class="col-md-6">
                    <h4>Customer Information</h4>
                    <table class="table">
                        @if($payment->customer)
                        <tr>
                            <th>Name:</th>
                            <td>{{ $payment->customer->name }}</td>
                        </tr>
                        <tr>
                            <th>Email:</th>
                            <td>{{ $payment->customer->email }}</td>
                        </tr>
                        <tr>
                            <th>Phone:</th>
                            <td>{{ $payment->customer->phone ?? 'N/A' }}</td>
                        </tr>
                        @else
                        <tr>
                            <td colspan="2" class="text-center">No customer information available</td>
                        </tr>
                        @endif
                    </table>
                </div>
            </div>
            
            @if($payment->order)
            <div class="row mt-4">
                <div class="col-12">
                    <h4>Order Details</h4>
                    <table class="table">
                        <tr>
                            <th>Order ID:</th>
                            <td>{{ $payment->order->id }}</td>
                        </tr>
                        <tr>
                            <th>Order Number:</th>
                            <td>{{ $payment->order->order_number }}</td>
                        </tr>
                        <tr>
                            <th>Order Date:</th>
                            <td>{{ $payment->order->created_at->format('F d, Y H:i:s') }}</td>
                        </tr>
                        <tr>
                            <th>Status:</th>
                            <td>{{ $payment->order->status }}</td>
                        </tr>
                    </table>
                    
                    <h5>Order Items</h5>
                    <div class="table-responsive">
                        <table class="table table-bordered table-striped">
                            <thead>
                                <tr>
                                    <th>Item</th>
                                    <th>Quantity</th>
                                    <th>Unit Price</th>
                                    <th>Total</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($payment->order->items as $item)
                                <tr>
                                    <td>{{ $item->product->name }}</td>
                                    <td>{{ $item->quantity }}</td>
                                    <td>{{ number_format($item->unit_price, 2) }} {{ $payment->currency }}</td>
                                    <td>{{ number_format($item->quantity * $item->unit_price, 2) }} {{ $payment->currency }}</td>
                                </tr>
                                @endforeach
                            </tbody>
                            <tfoot>
                                <tr>
                                    <th colspan="3" class="text-end">Subtotal:</th>
                                    <td>{{ number_format($payment->order->subtotal, 2) }} {{ $payment->currency }}</td>
                                </tr>
                                @if($payment->order->discount_amount > 0)
                                <tr>
                                    <th colspan="3" class="text-end">Discount:</th>
                                    <td>-{{ number_format($payment->order->discount_amount, 2) }} {{ $payment->currency }}</td>
                                </tr>
                                @endif
                                @if($payment->order->tax_amount > 0)
                                <tr>
                                    <th colspan="3" class="text-end">Tax:</th>
                                    <td>{{ number_format($payment->order->tax_amount, 2) }} {{ $payment->currency }}</td>
                                </tr>
                                @endif
                                @if($payment->order->shipping_amount > 0)
                                <tr>
                                    <th colspan="3" class="text-end">Shipping:</th>
                                    <td>{{ number_format($payment->order->shipping_amount, 2) }} {{ $payment->currency }}</td>
                                </tr>
                                @endif
                                <tr>
                                    <th colspan="3" class="text-end">Total:</th>
                                    <td><strong>{{ number_format($payment->order->total, 2) }} {{ $payment->currency }}</strong></td>
                                </tr>
                            </tfoot>
                        </table>
                    </div>
                </div>
            </div>
            @endif

            <!-- Payment Method Specific Details -->
            @if($payment->payment_method == 'qr_code')
            <div class="row mt-4">
                <div class="col-12">
                    <h4>QR Code Payment Details</h4>
                </div>
                <div class="col-md-6">
                    <table class="table">
                        <tr>
                            <th>Status:</th>
                            <td>
                                @if($payment->qrPayment)
                                    @switch($payment->qrPayment->verification_status)
                                        @case('pending')
                                            <span class="badge bg-warning">Pending</span>
                                            @break
                                        @case('confirmed')
                                            <span class="badge bg-success">Confirmed</span>
                                            @break
                                        @case('rejected')
                                            <span class="badge bg-danger">Rejected</span>
                                            @break
                                        @default
                                            <span class="badge bg-secondary">{{ $payment->qrPayment->verification_status }}</span>
                                    @endswitch
                                @else
                                    <span class="badge bg-secondary">N/A</span>
                                @endif
                            </td>
                        </tr>
                        @if($payment->qrPayment && $payment->qrPayment->verified_by)
                            <tr>
                                <th>Verified By:</th>
                                <td>{{ $payment->qrPayment->verified_by }}</td>
                            </tr>
                            <tr>
                                <th>Verification Date:</th>
                                <td>{{ $payment->qrPayment->verified_at ? $payment->qrPayment->verified_at->format('F d, Y H:i:s') : 'N/A' }}</td>
                            </tr>
                        @endif
                    </table>
                </div>
                <div class="col-md-6">
                    @if($payment->qrPayment && $payment->qrPayment->screenshot_path)
                    <div class="card">
                        <div class="card-header">
                            <h5>Payment Screenshot</h5>
                        </div>
                        <div class="card-body text-center">
                            <img src="{{ asset('qr_payments/' . basename($payment->qrPayment->screenshot_path)) }}" alt="QR Payment Screenshot" class="img-fluid">
                        </div>
                    </div>
                    @else
                        <div class="alert alert-info">No screenshot uploaded for this payment.</div>
                    @endif
                </div>
                @if($payment->status == 'pending_verification')
                <div class="col-12 mt-4">
                    <div class="verification-actions">
                        <h4>Verify Payment</h4>
                        <form action="{{ route('admin.payments.verify-qr', $payment->id) }}" method="POST">
                            @csrf
                            <div class="mb-3">
                                <label for="verification_status" class="form-label">Verification Decision:</label>
                                <select name="verification_status" id="verification_status" class="form-control" required>
                                    <option value="">-- Select --</option>
                                    <option value="confirmed">Confirm Payment</option>
                                    <option value="rejected">Reject Payment</option>
                                </select>
                            </div>
                            <div class="mb-3">
                                <label for="admin_notes" class="form-label">Notes:</label>
                                <textarea name="admin_notes" id="admin_notes" class="form-control" rows="3"></textarea>
                            </div>
                            <button type="submit" class="btn btn-primary">Submit Decision</button>
                        </form>
                    </div>
                </div>
                @endif
            </div>
            @endif

            @if($payment->payment_method == 'bank_transfer')
            <div class="row mt-4">
                <div class="col-12">
                    <h4>Bank Transfer Details</h4>
                </div>
                <div class="col-md-6">
                    <table class="table">
                        <tr>
                            <th>Bank Name:</th>
                            <td>{{ $payment->bankTransfer->bank_name ?? 'N/A' }}</td>
                        </tr>
                        <tr>
                            <th>Reference Number:</th>
                            <td>{{ $payment->bankTransfer->reference_number ?? 'N/A' }}</td>
                        </tr>
                        <tr>
                            <th>Transfer Date:</th>
                            <td>{{ $payment->bankTransfer->transfer_date ? $payment->bankTransfer->transfer_date->format('F d, Y') : 'N/A' }}</td>
                        </tr>
                        <tr>
                            <th>Status:</th>
                            <td>
                                @switch($payment->bankTransfer->status)
                                    @case('pending')
                                        <span class="badge bg-warning">Pending</span>
                                        @break
                                    @case('verified')
                                        <span class="badge bg-success">Verified</span>
                                        @break
                                    @case('rejected')
                                        <span class="badge bg-danger">Rejected</span>
                                        @break
                                    @default
                                        <span class="badge bg-secondary">{{ $payment->bankTransfer->status }}</span>
                                @endswitch
                            </td>
                        </tr>
                    </table>
                </div>
                <div class="col-md-6">
                    @if($payment->bankTransfer->receipt_path)
                    <div class="card">
                        <div class="card-header">
                            <h5>Payment Receipt</h5>
                        </div>
                        <div class="card-body text-center">
                            <img src="{{ asset('storage/' . $payment->bankTransfer->receipt_path) }}" alt="Bank Transfer Receipt" class="img-fluid">
                        </div>
                    </div>
                    @endif
                </div>
                @if($payment->status == 'pending_verification')
                <div class="col-12 mt-4">
                    <div class="verification-actions">
                        <h4>Verify Bank Transfer</h4>
                        <form action="{{ route('admin.payments.verify-bank-transfer', $payment->id) }}" method="POST">
                            @csrf
                            <div class="mb-3">
                                <label for="verification_status" class="form-label">Verification Decision:</label>
                                <select name="verification_status" id="verification_status" class="form-control" required>
                                    <option value="">-- Select --</option>
                                    <option value="confirmed">Confirm Payment</option>
                                    <option value="rejected">Reject Payment</option>
                                </select>
                            </div>
                            <div class="mb-3">
                                <label for="admin_notes" class="form-label">Notes:</label>
                                <textarea name="admin_notes" id="admin_notes" class="form-control" rows="3"></textarea>
                            </div>
                            <button type="submit" class="btn btn-primary">Submit Decision</button>
                        </form>
                    </div>
                </div>
                @endif
            </div>
            @endif

            @if($payment->payment_method == 'card')
            <div class="row mt-4">
                <div class="col-12">
                    <h4>Card Payment Details</h4>
                    <table class="table">
                        <tr>
                            <th>Card Type:</th>
                            <td>{{ $payment->cardPayment->card_type ?? 'N/A' }}</td>
                        </tr>
                        <tr>
                            <th>Last 4 Digits:</th>
                            <td>{{ $payment->cardPayment->last_four ?? 'N/A' }}</td>
                        </tr>
                        <tr>
                            <th>Transaction ID:</th>
                            <td>{{ $payment->cardPayment->transaction_id ?? 'N/A' }}</td>
                        </tr>
                        <tr>
                            <th>Gateway:</th>
                            <td>{{ $payment->cardPayment->gateway ?? 'N/A' }}</td>
                        </tr>
                    </table>
                </div>
            </div>
            @endif

            @if($payment->payment_method == 'pay_later')
            <div class="row mt-4">
                <div class="col-12">
                    <h4>Pay Later Details</h4>
                </div>
                <div class="col-md-6">
                    <table class="table">
                        <tr>
                            <th>Due Date:</th>
                            <td>{{ $payment->payLaterPayment->due_date ? $payment->payLaterPayment->due_date->format('F d, Y') : 'N/A' }}</td>
                        </tr>
                        <tr>
                            <th>Status:</th>
                            <td>
                                @switch($payment->payLaterPayment->status)
                                    @case('pending')
                                        <span class="badge bg-warning">Pending</span>
                                        @break
                                    @case('paid')
                                        <span class="badge bg-success">Paid</span>
                                        @break
                                    @case('overdue')
                                        <span class="badge bg-danger">Overdue</span>
                                        @break
                                    @case('cancelled')
                                        <span class="badge bg-secondary">Cancelled</span>
                                        @break
                                    @default
                                        <span class="badge bg-secondary">{{ $payment->payLaterPayment->status }}</span>
                                @endswitch
                            </td>
                        </tr>
                        @if($payment->payLaterPayment->status == 'paid')
                        <tr>
                            <th>Collection Date:</th>
                            <td>{{ $payment->payLaterPayment->collection_date ? $payment->payLaterPayment->collection_date->format('F d, Y H:i:s') : 'N/A' }}</td>
                        </tr>
                        <tr>
                            <th>Collected By:</th>
                            <td>{{ $payment->payLaterPayment->collected_by_admin ?? 'N/A' }}</td>
                        </tr>
                        <tr>
                            <th>Collection Method:</th>
                            <td>
                                @switch($payment->payLaterPayment->collection_method)
                                    @case('cash')
                                        <span class="badge bg-success">Cash</span>
                                        @break
                                    @case('card')
                                        <span class="badge bg-primary">Card</span>
                                        @break
                                    @case('bank_transfer')
                                        <span class="badge bg-info">Bank Transfer</span>
                                        @break
                                    @case('qr_code')
                                        <span class="badge bg-warning">QR Code</span>
                                        @break
                                    @default
                                        <span class="badge bg-secondary">{{ $payment->payLaterPayment->collection_method ?? 'N/A' }}</span>
                                @endswitch
                            </td>
                        </tr>
                        @endif
                        @if($payment->payLaterPayment->notes)
                        <tr>
                            <th>Notes:</th>
                            <td>{{ $payment->payLaterPayment->notes }}</td>
                        </tr>
                        @endif
                        <!-- Add bank code information if available -->
                        @if(!empty($payment->payLaterPayment->bank_code))
                        <tr>
                            <th>Bank Used:</th>
                            <td>
                                @switch($payment->payLaterPayment->bank_code)
                                    @case('bob')
                                        Bank of Bhutan
                                        @break
                                    @case('bnb')
                                        Bhutan National Bank
                                        @break
                                    @case('tbank')
                                        T-Bank
                                        @break
                                    @case('dpnb')
                                        Druk PNB
                                        @break
                                    @case('bdbl')
                                        BDBL
                                        @break
                                    @default
                                        {{ strtoupper($payment->payLaterPayment->bank_code) }}
                                @endswitch
                            </td>
                        </tr>
                        @endif
                    </table>
                </div>
                <div class="col-md-6">
                    @php
                        // Check for screenshot in multiple ways
                        $screenshotExists = false;
                        $screenshotPath = '';
                        
                        // First try the stored path if available
                        if (!empty($payment->payLaterPayment->screenshot_image_path) && 
                            file_exists(public_path($payment->payLaterPayment->screenshot_image_path))) {
                            $screenshotExists = true;
                            $screenshotPath = $payment->payLaterPayment->screenshot_image_path;
                        } 
                        // Then try reference number-based paths
                        else {
                            $possibleExtensions = ['jpg', 'jpeg', 'png'];
                            foreach ($possibleExtensions as $ext) {
                                $testPath = 'pay_later_payments/' . $payment->reference_number . '.' . $ext;
                                if (file_exists(public_path($testPath))) {
                                    $screenshotExists = true;
                                    $screenshotPath = $testPath;
                                    break;
                                }
                            }
                        }
                    @endphp
                    
                    @if($screenshotExists)
                        <div class="card">
                            <div class="card-header">
                                <h5>QR Payment Screenshot</h5>
                            </div>
                            <div class="card-body text-center">
                                <img src="{{ asset($screenshotPath) }}"
                                    alt="Pay Later QR Payment Screenshot" 
                                    class="img-fluid" 
                                    style="max-height: 400px; cursor: pointer;" 
                                    onclick="openImageModal(this.src)">
                                <p class="text-muted small mt-2">
                                    Customer paid via QR Code using {{ ucfirst($payment->payLaterPayment->bank_code ?? 'bank app') }}
                                </p>
                            </div>
                        </div>
                    @elseif($payment->payLaterPayment->status != 'paid')
                        <div class="collection-actions">
                            <h4>Collect Payment</h4>
                            <form action="{{ route('admin.payments.collect-pay-later', $payment->id) }}" method="POST" enctype="multipart/form-data">
                                @csrf
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
                                <div class="mb-3 qr-screenshot" style="display: none;">
                                    <label for="screenshot" class="form-label">Payment Screenshot:</label>
                                    <input type="file" name="screenshot" id="screenshot" class="form-control" accept="image/*">
                                    <small class="form-text text-muted">Upload screenshot of the QR payment if available</small>
                                </div>
                                <div class="mb-3">
                                    <label for="notes" class="form-label">Notes:</label>
                                    <textarea name="notes" id="notes" class="form-control" rows="3"></textarea>
                                </div>
                                <button type="submit" class="btn btn-primary">Record Payment</button>
                            </form>
                        </div>
                    @else
                        <div class="alert alert-info">
                            <h4>Payment Completed</h4>
                            <p>This pay later payment has been collected successfully, but no screenshot is available.</p>
                            @if($payment->payLaterPayment->collection_method)
                                <p><strong>Collection Method:</strong> {{ ucfirst(str_replace('_', ' ', $payment->payLaterPayment->collection_method)) }}</p>
                            @endif
                        </div>
                    @endif
                </div>
            </div>
            @endif
        </div>
    </div>
</div>

<!-- Image Modal for viewing large screenshots -->
<div class="modal fade" id="imageModal" tabindex="-1" aria-labelledby="imageModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="imageModalLabel">Payment Screenshot</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body text-center">
                <img id="modalImage" src="" class="img-fluid" alt="Payment Screenshot">
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Show/hide screenshot upload field based on payment method
        const collectionMethodSelect = document.getElementById('collection_method');
        const qrScreenshotDiv = document.querySelector('.qr-screenshot');
        
        if (collectionMethodSelect && qrScreenshotDiv) {
            collectionMethodSelect.addEventListener('change', function() {
                if (this.value === 'qr_code') {
                    qrScreenshotDiv.style.display = 'block';
                } else {
                    qrScreenshotDiv.style.display = 'none';
                }
            });
        }
        
        // Image modal functionality for payment screenshots
        const paymentImages = document.querySelectorAll('.card-body img');
        
        paymentImages.forEach(function(image) {
            image.style.cursor = 'pointer';
            
            image.addEventListener('click', function() {
                openImageModal(this.src);
            });
        });
        
        // Form validation for verification forms
        const verificationForms = document.querySelectorAll('form[action*="verify"]');
        
        verificationForms.forEach(function(form) {
            form.addEventListener('submit', function(event) {
                const statusSelect = this.querySelector('select[name="verification_status"]');
                
                if (!statusSelect.value) {
                    event.preventDefault();
                    alert('Please select a verification status');
                    return false;
                }
                
                // Confirm rejection to prevent accidental rejections
                if (statusSelect.value === 'rejected') {
                    if (!confirm('Are you sure you want to reject this payment?')) {
                        event.preventDefault();
                        return false;
                    }
                }
                
                return true;
            });
        });

        // Add form submission debugging
        const forms = document.querySelectorAll('form');
        forms.forEach(function(form) {
            form.addEventListener('submit', function(e) {
                const formData = new FormData(this);
                console.log('Form data being submitted:');
                for (let [key, value] of formData.entries()) {
                    console.log(key, value);
                }
            });
        });
    });

    // Function to open image modal
    function openImageModal(imageSrc) {
        const modal = document.getElementById('imageModal');
        const modalImage = document.getElementById('modalImage');
        
        modalImage.src = imageSrc;
        
        // Initialize and show the modal
        const bsModal = new bootstrap.Modal(modal);
        bsModal.show();
    }

    // Make the function globally available
    window.openImageModal = openImageModal;
</script>
@endpush