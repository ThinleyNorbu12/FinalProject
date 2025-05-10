@extends('layouts.app')

@section('content')
<div class="container py-4">
    <div class="row justify-content-center">
        <div class="col-md-10">
            <div class="card shadow">
                <div class="card-header bg-primary text-white">
                    <h3 class="mb-0">Payment Details</h3>
                </div>
                <div class="card-body">
                    <div class="row mb-4">
                        <div class="col-md-12">
                            <div class="alert alert-info">
                                <h5 class="alert-heading"><i class="fas fa-info-circle me-2"></i>Bank Transfer Information</h5>
                                <p class="mb-0">Please transfer the total amount to the following account:</p>
                            </div>
                            
                            <div class="card mb-4 border-primary">
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-md-6">
                                            <h5 class="card-title">Account Details</h5>
                                            <table class="table table-borderless">
                                                <tr>
                                                    <th>Account Name:</th>
                                                    <td>Bob in Bhutan</td>
                                                </tr>
                                                <tr>
                                                    <th>Account Number:</th>
                                                    <td><span class="fw-bold fs-5">207404884</span></td>
                                                </tr>
                                            </table>
                                        </div>
                                        <div class="col-md-6">
                                            <h5 class="card-title">Booking Information</h5>
                                            <table class="table table-borderless">
                                                <tr>
                                                    <th>Booking ID:</th>
                                                    <td>#{{ $booking->id }}</td>
                                                </tr>
                                                <tr>
                                                    <th>Total Amount:</th>
                                                    <td class="fw-bold">Nu. {{ number_format($booking->total_amount, 2) }}</td>
                                                </tr>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            
                            <div class="alert alert-warning">
                                <h5 class="alert-heading"><i class="fas fa-exclamation-triangle me-2"></i>Important Instructions</h5>
                                <ol class="mb-0">
                                    <li>Please include your Booking ID (#{{ $booking->id }}) as reference when making the transfer.</li>
                                    <li>After completing the transfer, submit the proof of payment below.</li>
                                    <li>Your booking will be confirmed once the payment is verified.</li>
                                </ol>
                            </div>
                        </div>
                    </div>
                    
                    <form action="{{ route('payment.process', $booking->id) }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        
                        <div class="row mb-3">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="transaction_id" class="form-label">Transaction ID/Reference Number <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control @error('transaction_id') is-invalid @enderror" id="transaction_id" name="transaction_id" required>
                                    @error('transaction_id')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="payment_date" class="form-label">Payment Date <span class="text-danger">*</span></label>
                                    <input type="date" class="form-control @error('payment_date') is-invalid @enderror" id="payment_date" name="payment_date" required value="{{ date('Y-m-d') }}">
                                    @error('payment_date')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>
                        
                        <div class="mb-3">
                            <label for="payment_proof" class="form-label">Upload Payment Proof <span class="text-danger">*</span></label>
                            <input type="file" class="form-control @error('payment_proof') is-invalid @enderror" id="payment_proof" name="payment_proof" required>
                            <div class="form-text">Please upload a screenshot or photo of your payment confirmation (JPEG, PNG or PDF, max 2MB)</div>
                            @error('payment_proof')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        
                        <div class="mb-4">
                            <div class="form-check">
                                <input class="form-check-input @error('terms') is-invalid @enderror" type="checkbox" id="terms" name="terms" required>
                                <label class="form-check-label" for="terms">
                                    I agree to the <a href="#" data-bs-toggle="modal" data-bs-target="#termsModal">terms and conditions</a>
                                </label>
                                @error('terms')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        
                        <div class="d-flex justify-content-between">
                            <a href="{{ route('booking.summary', $booking->id) }}" class="btn btn-secondary">
                                <i class="fas fa-arrow-left me-2"></i>Back
                            </a>
                            <button type="submit" class="btn btn-success">
                                <i class="fas fa-check-circle me-2"></i>Submit Payment Proof
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Terms and Conditions Modal -->
<div class="modal fade" id="termsModal" tabindex="-1" aria-labelledby="termsModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="termsModalLabel">Terms and Conditions</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <h6>Payment Terms</h6>
                <p>1. By submitting payment proof, you confirm that you have transferred the full amount to the specified account.</p>
                <p>2. Your booking will only be confirmed after payment verification.</p>
                <p>3. If payment cannot be verified, your booking request may be canceled.</p>
                
                <h6>Cancellation Policy</h6>
                <p>1. Cancellations made more than 48 hours before pickup: Full refund minus processing fee.</p>
                <p>2. Cancellations made within 48 hours of pickup: 50% refund.</p>
                <p>3. No-shows: No refund will be provided.</p>
                
                <h6>Additional Terms</h6>
                <p>1. The driver must present a valid driving license at the time of pickup.</p>
                <p>2. The vehicle must be returned in the same condition as provided.</p>
                <p>3. Any damages will be charged accordingly.</p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-primary" data-bs-dismiss="modal">I Understand</button>
            </div>
        </div>
    </div>
</div>
@endsection