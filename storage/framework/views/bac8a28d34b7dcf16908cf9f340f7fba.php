


<?php $__env->startSection('content'); ?>
<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card shadow">
                <div class="card-header bg-primary text-white">
                    <h4 class="mb-0">DrukPay Payment Gateway</h4>
                </div>
                
                <div class="card-body">
                    <?php if(session('error')): ?>
                        <div class="alert alert-danger alert-dismissible fade show" role="alert">
                            <?php echo e(session('error')); ?>

                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    <?php endif; ?>

                    <div class="mb-4">
                        <h5>Booking Summary</h5>
                        <div class="d-flex justify-content-between">
                            <div>
                                <p class="mb-1"><strong>Car:</strong> <?php echo e($booking->car->maker); ?> <?php echo e($booking->car->model); ?></p>
                                <p class="mb-1"><strong>Duration:</strong> <?php echo e(\Carbon\Carbon::parse($booking->pickup_date)->diffInDays(\Carbon\Carbon::parse($booking->dropoff_date)) + 1); ?> days</p>
                                <p class="mb-1"><strong>Pick-up:</strong> <?php echo e(\Carbon\Carbon::parse($booking->pickup_date)->format('M d, Y')); ?></p>
                            </div>
                            <?php
                                $days = \Carbon\Carbon::parse($booking->pickup_date)->diffInDays(\Carbon\Carbon::parse($booking->dropoff_date)) + 1;
                                $dailyRate = $booking->car->price;
                                $insuranceFee = 200;
                                $serviceFee = 100;
                                $totalPrice = ($dailyRate * $days) + $insuranceFee + $serviceFee;
                            ?>
                            <div class="text-end">
                                <h5>Total: Nu. <?php echo e(number_format($totalPrice, 2)); ?></h5>
                            </div>
                        </div>
                        <hr>
                    </div>

                    <!-- DrukPay Gateway Interface -->
                    <div class="drukpay-container mb-4">
                        <div class="text-center mb-4">
                            <img src="<?php echo e(asset('images/drukpay-logo.png')); ?>" alt="DrukPay Logo" class="img-fluid" style="max-height: 60px;" onerror="this.src='/api/placeholder/240/60'; this.alt='DrukPay'">
                            <h5 class="mt-3">Select Your Bank</h5>
                            <p class="text-muted">Choose your bank to proceed with payment</p>
                        </div>

                        <form action="<?php echo e(route('payment.process', ['bookingId' => $booking->id])); ?>" method="POST">
                            <?php echo csrf_field(); ?>
                            
                            <!-- Bank Selection -->
                            <div class="row mb-4 justify-content-center">
                                <div class="col-md-10">
                                    <div class="bank-selection">
                                        <!-- Bank of Bhutan -->
                                        <div class="bank-option mb-3">
                                            <input type="radio" class="btn-check" name="bank_option" id="bob" value="bob" autocomplete="off" checked>
                                            <label class="btn btn-outline-primary w-100 d-flex align-items-center p-3" for="bob">
                                                <img src="<?php echo e(asset('images/bob-logo.png')); ?>" alt="BOB Logo" class="bank-logo me-3" onerror="this.src='/api/placeholder/40/40'; this.alt='BOB'">
                                                <div class="text-start">
                                                    <strong>Bank of Bhutan</strong>
                                                    <small class="d-block text-muted">Internet Banking / mBOB</small>
                                                </div>
                                            </label>
                                        </div>
                                        
                                        <!-- Bhutan National Bank -->
                                        <div class="bank-option mb-3">
                                            <input type="radio" class="btn-check" name="bank_option" id="bnbl" value="bnbl" autocomplete="off">
                                            <label class="btn btn-outline-primary w-100 d-flex align-items-center p-3" for="bnbl">
                                                <img src="<?php echo e(asset('images/bnbl-logo.png')); ?>" alt="BNBL Logo" class="bank-logo me-3" onerror="this.src='/api/placeholder/40/40'; this.alt='BNBL'">
                                                <div class="text-start">
                                                    <strong>Bhutan National Bank</strong>
                                                    <small class="d-block text-muted">Internet Banking / mBNB</small>
                                                </div>
                                            </label>
                                        </div>
                                        
                                        <!-- T-Bank -->
                                        <div class="bank-option mb-3">
                                            <input type="radio" class="btn-check" name="bank_option" id="tbank" value="tbank" autocomplete="off">
                                            <label class="btn btn-outline-primary w-100 d-flex align-items-center p-3" for="tbank">
                                                <img src="<?php echo e(asset('images/tbank-logo.png')); ?>" alt="T-Bank Logo" class="bank-logo me-3" onerror="this.src='/api/placeholder/40/40'; this.alt='TBank'">
                                                <div class="text-start">
                                                    <strong>T-Bank</strong>
                                                    <small class="d-block text-muted">Internet Banking / mTBank</small>
                                                </div>
                                            </label>
                                        </div>
                                        
                                        <!-- BDBL -->
                                        <div class="bank-option mb-3">
                                            <input type="radio" class="btn-check" name="bank_option" id="bdbl" value="bdbl" autocomplete="off">
                                            <label class="btn btn-outline-primary w-100 d-flex align-items-center p-3" for="bdbl">
                                                <img src="<?php echo e(asset('images/bdbl-logo.png')); ?>" alt="BDBL Logo" class="bank-logo me-3" onerror="this.src='/api/placeholder/40/40'; this.alt='BDBL'">
                                                <div class="text-start">
                                                    <strong>Bhutan Development Bank</strong>
                                                    <small class="d-block text-muted">Internet Banking</small>
                                                </div>
                                            </label>
                                        </div>
                                        
                                        <!-- Druk PNB -->
                                        <div class="bank-option mb-3">
                                            <input type="radio" class="btn-check" name="bank_option" id="drukpnb" value="drukpnb" autocomplete="off">
                                            <label class="btn btn-outline-primary w-100 d-flex align-items-center p-3" for="drukpnb">
                                                <img src="<?php echo e(asset('images/drukpnb-logo.png')); ?>" alt="Druk PNB Logo" class="bank-logo me-3" onerror="this.src='/api/placeholder/40/40'; this.alt='DrukPNB'">
                                                <div class="text-start">
                                                    <strong>Druk PNB</strong>
                                                    <small class="d-block text-muted">Internet Banking</small>
                                                </div>
                                            </label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            
                            <!-- Dynamic Login Section -->
                            <div id="bob_login" class="bank-login-section">
                                <div class="card mb-4">
                                    <div class="card-header bg-light">
                                        <h5 class="mb-0">Bank of Bhutan Login</h5>
                                    </div>
                                    <div class="card-body">
                                        <div class="mb-3">
                                            <label for="username" class="form-label">Username/CIF</label>
                                            <input type="text" class="form-control" id="username" name="username" required>
                                        </div>
                                        <div class="mb-3">
                                            <label for="password" class="form-label">Password</label>
                                            <input type="password" class="form-control" id="password" name="password" required>
                                        </div>
                                        <div class="text-center">
                                            <p class="text-muted small">You will be redirected to Bank of Bhutan's secure payment page</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            
                            <div id="bnbl_login" class="bank-login-section" style="display: none;">
                                <div class="card mb-4">
                                    <div class="card-header bg-light">
                                        <h5 class="mb-0">Bhutan National Bank Login</h5>
                                    </div>
                                    <div class="card-body">
                                        <div class="mb-3">
                                            <label for="bnbl_username" class="form-label">Username</label>
                                            <input type="text" class="form-control" id="bnbl_username" name="bnbl_username">
                                        </div>
                                        <div class="mb-3">
                                            <label for="bnbl_password" class="form-label">Password</label>
                                            <input type="password" class="form-control" id="bnbl_password" name="bnbl_password">
                                        </div>
                                        <div class="text-center">
                                            <p class="text-muted small">You will be redirected to BNBL's secure payment page</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            
                            <div id="tbank_login" class="bank-login-section" style="display: none;">
                                <div class="card mb-4">
                                    <div class="card-header bg-light">
                                        <h5 class="mb-0">T-Bank Login</h5>
                                    </div>
                                    <div class="card-body">
                                        <div class="mb-3">
                                            <label for="tbank_username" class="form-label">User ID</label>
                                            <input type="text" class="form-control" id="tbank_username" name="tbank_username">
                                        </div>
                                        <div class="mb-3">
                                            <label for="tbank_password" class="form-label">Password</label>
                                            <input type="password" class="form-control" id="tbank_password" name="tbank_password">
                                        </div>
                                        <div class="text-center">
                                            <p class="text-muted small">You will be redirected to T-Bank's secure payment page</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            
                            <div id="bdbl_login" class="bank-login-section" style="display: none;">
                                <div class="card mb-4">
                                    <div class="card-header bg-light">
                                        <h5 class="mb-0">BDBL Login</h5>
                                    </div>
                                    <div class="card-body">
                                        <div class="mb-3">
                                            <label for="bdbl_username" class="form-label">Username</label>
                                            <input type="text" class="form-control" id="bdbl_username" name="bdbl_username">
                                        </div>
                                        <div class="mb-3">
                                            <label for="bdbl_password" class="form-label">Password</label>
                                            <input type="password" class="form-control" id="bdbl_password" name="bdbl_password">
                                        </div>
                                        <div class="text-center">
                                            <p class="text-muted small">You will be redirected to BDBL's secure payment page</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            
                            <div id="drukpnb_login" class="bank-login-section" style="display: none;">
                                <div class="card mb-4">
                                    <div class="card-header bg-light">
                                        <h5 class="mb-0">Druk PNB Login</h5>
                                    </div>
                                    <div class="card-body">
                                        <div class="mb-3">
                                            <label for="drukpnb_username" class="form-label">User ID</label>
                                            <input type="text" class="form-control" id="drukpnb_username" name="drukpnb_username">
                                        </div>
                                        <div class="mb-3">
                                            <label for="drukpnb_password" class="form-label">Password</label>
                                            <input type="password" class="form-control" id="drukpnb_password" name="drukpnb_password">
                                        </div>
                                        <div class="text-center">
                                            <p class="text-muted small">You will be redirected to Druk PNB's secure payment page</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            
                            <!-- Payment Information -->
                            <div class="card mb-4">
                                <div class="card-header bg-light">
                                    <h5 class="mb-0">Payment Information</h5>
                                </div>
                                <div class="card-body">
                                    <div class="row mb-3">
                                        <div class="col-md-6">
                                            <p class="mb-1"><strong>Merchant:</strong> CarRental Bhutan</p>
                                            <p class="mb-1"><strong>Transaction ID:</strong> TR-<?php echo e($booking->id); ?>-<?php echo e(time()); ?></p>
                                        </div>
                                        <div class="col-md-6 text-md-end">
                                            <p class="mb-1"><strong>Amount:</strong> Nu. <?php echo e(number_format($totalPrice, 2)); ?></p>
                                            <p class="mb-1"><strong>Date:</strong> <?php echo e(now()->format('d/m/Y')); ?></p>
                                        </div>
                                    </div>
                                    
                                    <div class="alert alert-info">
                                        <div class="d-flex">
                                            <div class="me-3">
                                                <i class="fas fa-info-circle fa-2x"></i>
                                            </div>
                                            <div>
                                                <p class="mb-1"><strong>Note:</strong> After clicking "Proceed to Pay", you will be redirected to your bank's secure login page to complete your payment.</p>
                                                <p class="mb-0">The amount of Nu. <?php echo e(number_format($totalPrice, 2)); ?> will be debited from your account.</p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            
                            <!-- Terms and Conditions -->
                            <div class="mb-4">
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" id="terms" name="terms" required>
                                    <label class="form-check-label" for="terms">
                                        I agree to the <a href="#">Terms and Conditions</a> and <a href="#">Privacy Policy</a>
                                    </label>
                                </div>
                            </div>
                            
                            <!-- Buttons -->
                            <div class="d-flex justify-content-between align-items-center">
                                <a href="<?php echo e(route('booking.summary', ['bookingId' => $booking->id])); ?>" class="btn btn-outline-secondary">
                                    <i class="fas fa-arrow-left me-2"></i>Back to Summary
                                </a>
                                <button type="submit" class="btn btn-success" id="payButton">
                                    <i class="fas fa-lock me-2"></i>Proceed to Pay - Nu. <?php echo e(number_format($totalPrice, 2)); ?>

                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            
            <!-- Security Notice -->
            <div class="mt-4">
                <div class="row justify-content-center">
                    <div class="col-md-8">
                        <div class="card border-0 bg-light">
                            <div class="card-body">
                                <div class="d-flex align-items-center mb-3">
                                    <div class="me-3">
                                        <i class="fas fa-shield-alt fa-2x text-success"></i>
                                    </div>
                                    <div>
                                        <h5 class="mb-0">Secure Payment</h5>
                                        <p class="mb-0 text-muted">Your transaction is secure with DrukPay</p>
                                    </div>
                                </div>
                                <div class="row text-center">
                                    <div class="col-4">
                                        <i class="fas fa-lock text-primary"></i>
                                        <p class="small mb-0">SSL Encrypted</p>
                                    </div>
                                    <div class="col-4">
                                        <i class="fas fa-user-shield text-primary"></i>
                                        <p class="small mb-0">Data Protection</p>
                                    </div>
                                    <div class="col-4">
                                        <i class="fas fa-university text-primary"></i>
                                        <p class="small mb-0">Bank Level Security</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('scripts'); ?>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Bank selection toggle
        const bankOptions = document.querySelectorAll('input[name="bank_option"]');
        const bankLoginSections = document.querySelectorAll('.bank-login-section');
        
        function hideAllBankLogins() {
            bankLoginSections.forEach(section => {
                section.style.display = 'none';
            });
        }
        
        function updateRequiredFields(bankCode) {
            // Reset all required fields
            document.querySelectorAll('.bank-login-section input').forEach(input => {
                input.required = false;
            });
            
            // Set required fields for selected bank
            if (bankCode) {
                const activeSection = document.getElementById(bankCode + '_login');
                if (activeSection) {
                    activeSection.querySelectorAll('input').forEach(input => {
                        input.required = true;
                    });
                }
            }
        }
        
        bankOptions.forEach(option => {
            option.addEventListener('change', function() {
                if (this.checked) {
                    hideAllBankLogins();
                    const bankCode = this.value;
                    const loginSection = document.getElementById(bankCode + '_login');
                    if (loginSection) {
                        loginSection.style.display = 'block';
                    }
                    updateRequiredFields(bankCode);
                }
            });
        });
        
        // Initialize required fields based on default selected bank
        updateRequiredFields('bob');
        
        // Form submission
        const paymentForm = document.querySelector('form');
        const payButton = document.getElementById('payButton');
        
        paymentForm.addEventListener('submit', function(e) {
            // For demonstration purposes only
            const termsCheckbox = document.getElementById('terms');
            if (!termsCheckbox.checked) {
                e.preventDefault();
                alert('Please agree to the Terms and Conditions to proceed.');
                return;
            }
            
            // Disable button to prevent double submission
            payButton.disabled = true;
            payButton.innerHTML = '<span class="spinner-border spinner-border-sm me-2" role="status" aria-hidden="true"></span>Processing...';
            
            // Form will submit normally to the server
        });
    });
</script>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('styles'); ?>
<style>
    .bank-logo {
        width: 40px;
        height: 40px;
        object-fit: contain;
    }
    
    .bank-option .btn {
        text-align: left;
        transition: all 0.3s ease;
    }
    
    .bank-option .btn:hover {
        background-color: rgba(13, 110, 253, 0.05);
    }
    
    .btn-check:checked + .btn {
        background-color: rgba(13, 110, 253, 0.1);
        border-color: #0d6efd;
    }
    
    .card-header {
        font-weight: 500;
    }
    
    .form-label {
        font-weight: 500;
    }
</style>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\Sangay Ngedup\Documents\GitHub\FinalProject\resources\views/payment.blade.php ENDPATH**/ ?>