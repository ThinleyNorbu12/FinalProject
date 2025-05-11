<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Car Rental Payment</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0/css/bootstrap.min.css">
    <style>
        body {
            background-color: #f8f9fa;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }
        .payment-container {
            max-width: 900px;
            margin: 30px auto;
            background: white;
            border-radius: 15px;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.1);
            overflow: hidden;
        }
        .payment-header {
            background: #343a40;
            color: white;
            padding: 20px 30px;
            text-align: center;
        }
        .payment-body {
            padding: 30px;
        }
        .payment-summary {
            background: #f8f9fa;
            border-radius: 10px;
            padding: 20px;
            margin-bottom: 30px;
        }
        .summary-item {
            display: flex;
            justify-content: space-between;
            margin-bottom: 10px;
        }
        .total-amount {
            font-size: 24px;
            font-weight: 700;
            color: #28a745;
        }
        .payment-option {
            border: 1px solid #dee2e6;
            border-radius: 10px;
            padding: 20px;
            margin-bottom: 20px;
            cursor: pointer;
            transition: all 0.3s;
        }
        .payment-option.active {
            border-color: #28a745;
            box-shadow: 0 0 0 3px rgba(40, 167, 69, 0.2);
        }
        .payment-option-header {
            display: flex;
            align-items: center;
            margin-bottom: 15px;
        }
        .payment-option-icon {
            font-size: 24px;
            margin-right: 15px;
            color: #343a40;
            width: 40px;
            text-align: center;
        }
        .payment-option-title {
            font-size: 18px;
            font-weight: 600;
            margin: 0;
        }
        .payment-option-body {
            padding-left: 55px;
            display: none;
        }
        .active .payment-option-body {
            display: block;
        }
        .payment-btn {
            background: #28a745;
            color: white;
            border: none;
            padding: 12px 25px;
            border-radius: 5px;
            font-weight: 600;
            transition: all 0.3s;
        }
        .payment-btn:hover {
            background: #218838;
        }
        .bank-dropdown {
            width: 100%;
            padding: 10px;
            border-radius: 5px;
            border: 1px solid #ced4da;
            margin-bottom: 15px;
        }
        .account-input {
            width: 100%;
            padding: 10px;
            border-radius: 5px;
            border: 1px solid #ced4da;
            margin-bottom: 15px;
        }
        .qr-code-container {
            display: flex;
            flex-direction: column;
            align-items: center;
            margin-top: 20px;
        }
        .qr-code {
            width: 200px;
            height: 200px;
            background-color: #f8f9fa;
            border: 1px solid #dee2e6;
            display: flex;
            align-items: center;
            justify-content: center;
            margin-bottom: 15px;
        }
        .upload-btn {
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 10px;
            background-color: #f8f9fa;
            border: 1px dashed #ced4da;
            padding: 15px;
            border-radius: 5px;
            cursor: pointer;
            margin-top: 15px;
            width: 100%;
        }
        .bank-selector {
            display: flex;
            flex-wrap: wrap;
            gap: 10px;
            margin-bottom: 20px;
        }
        .bank-option {
            border: 1px solid #dee2e6;
            border-radius: 5px;
            padding: 10px;
            text-align: center;
            cursor: pointer;
            width: calc(20% - 8px);
        }
        .bank-option.active {
            border-color: #28a745;
            background-color: rgba(40, 167, 69, 0.1);
        }
        .bank-option img {
            height: 40px;
            margin-bottom: 5px;
        }
        .back-link {
            color: #6c757d;
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            margin-bottom: 20px;
        }
        .phone-input {
            width: 100%;
            padding: 10px;
            border-radius: 5px;
            border: 1px solid #ced4da;
            margin-bottom: 15px;
        }
        .otp-btn {
            background: #343a40;
            color: white;
            border: none;
            padding: 10px 20px;
            border-radius: 5px;
            font-weight: 600;
            transition: all 0.3s;
        }
        .otp-btn:hover {
            background: #23272b;
        }
        .footer-actions {
            display: flex;
            justify-content: space-between;
            margin-top: 30px;
        }
        .cancel-btn {
            background: #6c757d;
            color: white;
            border: none;
            padding: 12px 25px;
            border-radius: 5px;
            font-weight: 600;
            transition: all 0.3s;
        }
        .cancel-btn:hover {
            background: #5a6268;
        }
        .hidden {
            display: none;
        }
        @media (max-width: 768px) {
            .bank-option {
                width: calc(50% - 5px);
            }
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="payment-container">
            <div class="payment-header">
                <h2>SELECT PAYMENT METHOD</h2>
            </div>
            <div class="payment-body">
                <a href="#" class="back-link mb-4">
                    <i class="fas fa-arrow-left me-2"></i> Back to booking
                </a>
                
                <div class="payment-summary">
                    <h4 class="mb-4">Booking Summary</h4>
                    
                    <div class="summary-item">
                        <span>Car Model</span>
                        <span>Toyota Prado</span>
                    </div>
                    
                    <div class="summary-item">
                        <span>Booking Dates</span>
                        <span id="bookingDates">May 12 - May 15, 2025</span>
                    </div>
                    
                    <div class="summary-item">
                        <span>Booking ID</span>
                        <span id="bookingId">#BK12345</span>
                    </div>
                    
                    <hr>
                    
                    <div class="summary-item">
                        <span>Rental Fee (4 days)</span>
                        <span>Nu. 12,000.00</span>
                    </div>
                    
                    <div class="summary-item">
                        <span>Security Deposit</span>
                        <span>Nu. 3,000.00</span>
                    </div>
                    
                    <hr>
                    
                    <div class="summary-item mb-0">
                        <span class="fw-bold">Total Amount</span>
                        <span class="total-amount">Nu. 15,000.00</span>
                    </div>
                </div>
                
                <!-- Payment Options -->
                <h4 class="mb-3">Choose Payment Method</h4>
                
                <!-- Option 1: QR Code Payment -->
                <div class="payment-option" id="option1">
                    <div class="payment-option-header">
                        <div class="payment-option-icon">
                            <i class="fas fa-qrcode"></i>
                        </div>
                        <h5 class="payment-option-title">QR Code Payment</h5>
                    </div>
                    <div class="payment-option-body">
                        <p>Scan the QR code below using your mobile banking app and upload the screenshot of payment confirmation.</p>
                        
                        <div class="bank-selector">
                            <div class="bank-option" data-bank="bob">
                                <img src="/api/placeholder/80/40" alt="Bank of Bhutan">
                                <div>BOB</div>
                            </div>
                            <div class="bank-option" data-bank="bnb">
                                <img src="/api/placeholder/80/40" alt="Bhutan National Bank">
                                <div>BNB</div>
                            </div>
                            <div class="bank-option" data-bank="tbank">
                                <img src="/api/placeholder/80/40" alt="T-Bank">
                                <div>T-Bank</div>
                            </div>
                            <div class="bank-option" data-bank="dpnb">
                                <img src="/api/placeholder/80/40" alt="Druk PNB">
                                <div>DPNB</div>
                            </div>
                            <div class="bank-option" data-bank="bdbl">
                                <img src="/api/placeholder/80/40" alt="BDBL">
                                <div>BDBL</div>
                            </div>
                        </div>
                        
                        <div class="qr-code-container hidden" id="qrContainer">
                            <div class="qr-code">
                                <i class="fas fa-qrcode fa-5x text-muted"></i>
                            </div>
                            <p class="text-center">Scan this QR code with your mobile banking app</p>
                            
                            <label class="upload-btn">
                                <i class="fas fa-upload"></i>
                                <span>Upload Payment Screenshot</span>
                                <input type="file" style="display: none;" accept="image/*">
                            </label>
                        </div>
                        
                        <p class="text-center mt-3 text-muted">Please select a bank to display the QR code</p>
                        
                        <div class="text-center mt-3">
                            <button class="payment-btn" id="confirmQrBtn" disabled>Confirm Payment</button>
                        </div>
                    </div>
                </div>
                
                <!-- Option 2: Bank Transfer with OTP -->
                <div class="payment-option" id="option2">
                    <div class="payment-option-header">
                        <div class="payment-option-icon">
                            <i class="fas fa-university"></i>
                        </div>
                        <h5 class="payment-option-title">Bank Transfer with OTP Verification</h5>
                    </div>
                    <div class="payment-option-body">
                        <div class="mb-3">
                            <label class="form-label">Bank Code</label>
                            <select class="bank-dropdown">
                                <option value="">Select Bank</option>
                                <option value="bob">BANK OF BHUTAN LIMITED</option>
                                <option value="bnb">BHUTAN NATIONAL BANK LIMITED</option>
                                <option value="tbank">T-BANK LIMITED</option>
                                <option value="dpnb">DRUK PNB BANK LIMITED</option>
                                <option value="bdbl">BHUTAN DEVELOPMENT BANK LIMITED</option>
                            </select>
                        </div>
                        
                        <div class="mb-3">
                            <label class="form-label">Bank Account Number</label>
                            <input type="text" class="account-input" placeholder="Enter Account Number">
                        </div>
                        
                        <div class="mb-3">
                            <label class="form-label">Mobile Number</label>
                            <input type="text" class="phone-input" placeholder="Enter Mobile Number">
                        </div>
                        
                        <div class="text-center mt-4">
                            <button class="otp-btn">Send OTP</button>
                        </div>
                        
                        <div class="mt-4 hidden" id="otpSection">
                            <label class="form-label">Enter OTP</label>
                            <div class="d-flex gap-2">
                                <input type="text" maxlength="1" class="form-control text-center">
                                <input type="text" maxlength="1" class="form-control text-center">
                                <input type="text" maxlength="1" class="form-control text-center">
                                <input type="text" maxlength="1" class="form-control text-center">
                                <input type="text" maxlength="1" class="form-control text-center">
                                <input type="text" maxlength="1" class="form-control text-center">
                            </div>
                            
                            <div class="text-center mt-4">
                                <button class="payment-btn">Verify & Pay</button>
                            </div>
                        </div>
                    </div>
                </div>
                
                <!-- Option 3: Pay Later -->
                <div class="payment-option" id="option3">
                    <div class="payment-option-header">
                        <div class="payment-option-icon">
                            <i class="fas fa-hourglass-half"></i>
                        </div>
                        <h5 class="payment-option-title">Pay Later</h5>
                    </div>
                    <div class="payment-option-body">
                        <p>Select this option if you prefer to pay in cash at the time of pickup.</p>
                        <div class="alert alert-warning">
                            <i class="fas fa-info-circle me-2"></i>
                            Please note that choosing "Pay Later" option means you will need to pay the full amount when you meet for the car handover.
                        </div>
                        
                        <div class="text-center mt-4">
                            <button class="payment-btn">Confirm Pay Later</button>
                        </div>
                    </div>
                </div>
                
                <div class="footer-actions">
                    <button class="cancel-btn">Cancel</button>
                    <button class="payment-btn" id="nextBtn">Next</button>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0/js/bootstrap.bundle.min.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Get booking ID from the URL if available
            const urlParams = new URLSearchParams(window.location.search);
            const bookingId = urlParams.get('bookingId');
            
            if (bookingId) {
                document.getElementById('bookingId').textContent = '#' + bookingId;
            }
            
            // Payment option selection
            const paymentOptions = document.querySelectorAll('.payment-option');
            paymentOptions.forEach(option => {
                option.addEventListener('click', function() {
                    // Remove active class from all options
                    paymentOptions.forEach(opt => opt.classList.remove('active'));
                    
                    // Add active class to clicked option
                    this.classList.add('active');
                    
                    // Enable next button
                    document.getElementById('nextBtn').removeAttribute('disabled');
                });
            });
            
            // Bank option selection for QR codes
            const bankOptions = document.querySelectorAll('.bank-option');
            bankOptions.forEach(bank => {
                bank.addEventListener('click', function() {
                    // Remove active class from all bank options
                    bankOptions.forEach(b => b.classList.remove('active'));
                    
                    // Add active class to clicked bank option
                    this.classList.add('active');
                    
                    // Show QR code container
                    document.getElementById('qrContainer').classList.remove('hidden');
                    
                    // Enable confirm button
                    document.getElementById('confirmQrBtn').removeAttribute('disabled');
                });
            });
            
            // OTP button click
            const otpBtn = document.querySelector('.otp-btn');
            otpBtn.addEventListener('click', function() {
                // Show OTP input section
                document.getElementById('otpSection').classList.remove('hidden');
            });
            
            // Auto focus next OTP input
            const otpInputs = document.querySelectorAll('#otpSection input');
            otpInputs.forEach((input, index) => {
                input.addEventListener('input', function() {
                    if (this.value && index < otpInputs.length - 1) {
                        otpInputs[index + 1].focus();
                    }
                });
                
                input.addEventListener('keydown', function(e) {
                    if (e.key === 'Backspace' && !this.value && index > 0) {
                        otpInputs[index - 1].focus();
                    }
                });
            });
        });
    </script>
</body>
</html>








<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Bank QR Code Payment Instructions</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0/css/bootstrap.min.css">
    <style>
        body {
            background-color: #f8f9fa;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }
        .payment-container {
            max-width: 900px;
            margin: 30px auto;
            background: white;
            border-radius: 15px;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.1);
            overflow: hidden;
        }
        .payment-header {
            background: #343a40;
            color: white;
            padding: 20px 30px;
            text-align: center;
        }
        .payment-body {
            padding: 30px;
        }
        .bank-tab-content {
            display: none;
            padding: 20px;
            border: 1px solid #dee2e6;
            border-top: none;
            border-radius: 0 0 10px 10px;
        }
        .bank-tab-content.active {
            display: block;
        }
        .instruction-step {
            margin-bottom: 20px;
            padding-left: 10px;
        }
        .instruction-step .step-number {
            display: inline-block;
            width: 30px;
            height: 30px;
            background: #343a40;
            color: white;
            border-radius: 50%;
            text-align: center;
            line-height: 30px;
            margin-right: 10px;
        }
        .qr-code-container {
            display: flex;
            flex-direction: column;
            align-items: center;
            margin: 20px 0;
            padding: 20px;
            border: 1px solid #dee2e6;
            border-radius: 10px;
            background-color: #f8f9fa;
        }
        .qr-code {
            width: 150px;
            height: 150px;
            border: 1px solid #dee2e6;
            display: flex;
            align-items: center;
            justify-content: center;
            margin-bottom: 15px;
            background-color: white;
        }
        .merchant-info {
            text-align: center;
            margin-bottom: 20px;
        }
        .merchant-id {
            font-weight: bold;
            font-size: 18px;
            margin-bottom: 5px;
        }
        .remark-note {
            color: #dc3545;
            font-size: 14px;
            margin-top: 5px;
        }
        .nav-tabs .nav-link {
            border: 1px solid #dee2e6;
            border-radius: 10px 10px 0 0;
            margin-right: 5px;
            color: #6c757d;
        }
        .nav-tabs .nav-link.active {
            background-color: #343a40;
            color: white;
            border-color: #343a40;
        }
        .bank-logo {
            height: 30px;
            margin-right: 10px;
        }
        .important-note {
            background-color: #fff3cd;
            border-left: 4px solid #ffc107;
            padding: 15px;
            margin-top: 20px;
            border-radius: 5px;
        }
        .otp-inputs {
            display: flex;
            gap: 8px;
            justify-content: center;
            margin: 20px 0;
        }
        .otp-inputs input {
            width: 40px;
            height: 45px;
            text-align: center;
            font-size: 18px;
            border: 1px solid #ced4da;
            border-radius: 5px;
        }
        .bank-option-grid {
            display: grid;
            grid-template-columns: repeat(5, 1fr);
            gap: 10px;
            margin: 20px 0;
        }
        .bank-option-grid > div {
            border: 1px solid #dee2e6;
            border-radius: 5px;
            padding: 10px;
            text-align: center;
            cursor: pointer;
            transition: all 0.2s;
        }
        .bank-option-grid > div:hover {
            border-color: #28a745;
            background-color: rgba(40, 167, 69, 0.05);
        }
        .bank-option-grid img {
            height: 35px;
            margin-bottom: 5px;
        }
        
        .alert-info {
            color: #0c5460;
            background-color: #d1ecf1;
            border-left: 4px solid #17a2b8;
            padding: 15px;
            border-radius: 5px;
        }
        
        .alert-warning {
            color: #856404;
            background-color: #fff3cd;
            border-left: 4px solid #ffc107;
            padding: 15px;
            border-radius: 5px;
        }
        
        @media (max-width: 768px) {
            .bank-option-grid {
                grid-template-columns: repeat(2, 1fr);
            }
            .nav-tabs {
                flex-wrap: nowrap;
                overflow-x: auto;
                white-space: nowrap;
            }
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="payment-container">
            <div class="payment-header">
                <h2>QR CODE PAYMENT INSTRUCTIONS</h2>
            </div>
            <div class="payment-body">
                <ul class="nav nav-tabs" id="bankTabs" role="tablist">
                    <li class="nav-item" role="presentation">
                        <button class="nav-link active" id="bob-tab" data-bs-toggle="tab" data-bs-target="#bob-content" type="button" role="tab">
                            <img src="/api/placeholder/60/30" alt="BOB" class="bank-logo">BOB
                        </button>
                    </li>
                    <li class="nav-item" role="presentation">
                        <button class="nav-link" id="bnb-tab" data-bs-toggle="tab" data-bs-target="#bnb-content" type="button" role="tab">
                            <img src="/api/placeholder/60/30" alt="BNB" class="bank-logo">BNB
                        </button>
                    </li>
                    <li class="nav-item" role="presentation">
                        <button class="nav-link" id="tbank-tab" data-bs-toggle="tab" data-bs-target="#tbank-content" type="button" role="tab">
                            <img src="/api/placeholder/60/30" alt="T-Bank" class="bank-logo">T-Bank
                        </button>
                    </li>
                    <li class="nav-item" role="presentation">
                        <button class="nav-link" id="dpnb-tab" data-bs-toggle="tab" data-bs-target="#dpnb-content" type="button" role="tab">
                            <img src="/api/placeholder/60/30" alt="DPNB" class="bank-logo">DPNB
                        </button>
                    </li>
                    <li class="nav-item" role="presentation">
                        <button class="nav-link" id="bdbl-tab" data-bs-toggle="tab" data-bs-target="#bdbl-content" type="button" role="tab">
                            <img src="/api/placeholder/60/30" alt="BDBL" class="bank-logo">BDBL
                        </button>
                    </li>
                    <li class="nav-item" role="presentation">
                        <button class="nav-link" id="bank-transfer-tab" data-bs-toggle="tab" data-bs-target="#bank-transfer-content" type="button" role="tab">
                            <i class="fas fa-university me-2"></i>Bank Transfer
                        </button>
                    </li>
                    <li class="nav-item" role="presentation">
                        <button class="nav-link" id="pay-later-tab" data-bs-toggle="tab" data-bs-target="#pay-later-content" type="button" role="tab">
                            <i class="fas fa-hourglass-half me-2"></i>Pay Later
                        </button>
                    </li>
                </ul>
                
                <div class="tab-content" id="bankTabsContent">
                    <!-- BOB Instructions -->
                    <div class="bank-tab-content active" id="bob-content">
                        <h4>Pay with mBOB Mobile Banking</h4>
                        
                        <div class="qr-code-container">
                            <div class="qr-code">
                                <i class="fas fa-qrcode fa-5x text-muted"></i>
                            </div>
                            
                            <div class="merchant-info">
                                <div class="merchant-id">Merchant ID: CARRENTAL123</div>
                                <div class="amount">Amount: Nu. 15,000.00</div>
                                <div class="remark-note">* Please include your booking ID (BK12345) in the remarks</div>
                            </div>
                        </div>
                        
                        <div class="instruction-step">
                            <span class="step-number">1</span>
                            <span>Open your mBOB app</span>
                        </div>
                        
                        <div class="instruction-step">
                            <span class="step-number">2</span>
                            <span>Go to Payments > Scan QR</span>
                        </div>
                        
                        <div class="instruction-step">
                            <span class="step-number">3</span>
                            <span>Scan the QR code shown above</span>
                        </div>
                        
                        <div class="instruction-step">
                            <span class="step-number">4</span>
                            <span>Enter amount: Nu. 15,000.00</span>
                        </div>
                        
                        <div class="instruction-step">
                            <span class="step-number">5</span>
                            <span>Enter "BK12345" in remarks</span>
                        </div>
                        
                        <div class="instruction-step">
                            <span class="step-number">6</span>
                            <span>Confirm payment using your PIN/password</span>
                        </div>
                        
                        <div class="instruction-step">
                            <span class="step-number">7</span>
                            <span>Take a screenshot of the confirmation</span>
                        </div>
                        
                        <div class="important-note">
                            <i class="fas fa-info-circle me-2"></i>
                            Important: After completing the payment, please upload the screenshot of your payment confirmation to proceed with your car rental booking.
                        </div>
                    </div>
                    
                    <!-- BNB Instructions -->
                    <div class="bank-tab-content" id="bnb-content">
                        <h4>Pay with BNB Mobile Banking</h4>
                        
                        <div class="qr-code-container">
                            <div class="qr-code">
                                <i class="fas fa-qrcode fa-5x text-muted"></i>
                            </div>
                            
                            <div class="merchant-info">
                                <div class="merchant-id">Merchant ID: CARRENTAL123</div>
                                <div class="amount">Amount: Nu. 15,000.00</div>
                                <div class="remark-note">* Please include your booking ID (BK12345) in the remarks</div>
                            </div>
                        </div>
                        
                        <div class="instruction-step">
                            <span class="step-number">1</span>
                            <span>Open your BNB Mobile Banking app</span>
                        </div>
                        
                        <div class="instruction-step">
                            <span class="step-number">2</span>
                            <span>Select "QR Payment" option</span>
                        </div>
                        
                        <div class="instruction-step">
                            <span class="step-number">3</span>
                            <span>Scan the QR code shown above</span>
                        </div>
                        
                        <div class="instruction-step">
                            <span class="step-number">4</span>
                            <span>Verify merchant details (CARRENTAL123)</span>
                        </div>
                        
                        <div class="instruction-step">
                            <span class="step-number">5</span>
                            <span>Enter amount: Nu. 15,000.00</span>
                        </div>
                        
                        <div class="instruction-step">
                            <span class="step-number">6</span>
                            <span>Add "BK12345" in the remarks field</span>
                        </div>
                        
                        <div class="instruction-step">
                            <span class="step-number">7</span>
                            <span>Confirm and authorize payment</span>
                        </div>
                        
                        <div class="instruction-step">
                            <span class="step-number">8</span>
                            <span>Take a screenshot of the payment confirmation</span>
                        </div>
                        
                        <div class="important-note">
                            <i class="fas fa-info-circle me-2"></i>
                            Important: After completing the payment, please upload the screenshot of your payment confirmation to proceed with your car rental booking.
                        </div>
                    </div>
                    
                    <!-- T-Bank Instructions -->
                    <div class="bank-tab-content" id="tbank-content">
                        <h4>Pay with T-Bank Mobile Banking</h4>
                        
                        <div class="qr-code-container">
                            <div class="qr-code">
                                <i class="fas fa-qrcode fa-5x text-muted"></i>
                            </div>
                            
                            <div class="merchant-info">
                                <div class="merchant-id">Merchant ID: CARRENTAL123</div>
                                <div class="amount">Amount: Nu. 15,000.00</div>
                                <div class="remark-note">* Please include your booking ID (BK12345) in the remarks</div>
                            </div>
                        </div>
                        
                        <div class="instruction-step">
                            <span class="step-number">1</span>
                            <span>Launch your T-Bank mobile app</span>
                        </div>
                        
                        <div class="instruction-step">
                            <span class="step-number">2</span>
                            <span>Navigate to "QR Payments"</span>
                        </div>
                        
                        <div class="instruction-step">
                            <span class="step-number">3</span>
                            <span>Scan the QR code displayed above</span>
                        </div>
                        
                        <div class="instruction-step">
                            <span class="step-number">4</span>
                            <span>Confirm merchant information</span>
                        </div>
                        
                        <div class="instruction-step">
                            <span class="step-number">5</span>
                            <span>Enter payment amount: Nu. 15,000.00</span>
                        </div>
                        
                        <div class="instruction-step">
                            <span class="step-number">6</span>
                            <span>Type "BK12345" in the remarks section</span>
                        </div>
                        
                        <div class="instruction-step">
                            <span class="step-number">7</span>
                            <span>Verify and submit payment</span>
                        </div>
                        
                        <div class="instruction-step">
                            <span class="step-number">8</span>
                            <span>Take a screenshot of your transaction receipt</span>
                        </div>
                        
                        <div class="important-note">
                            <i class="fas fa-info-circle me-2"></i>
                            Important: After completing the payment, please upload the screenshot of your payment confirmation to proceed with your car rental booking.
                        </div>
                    </div>
                    
                    <!-- DPNB Instructions -->
                    <div class="bank-tab-content" id="dpnb-content">
                        <h4>Pay with Druk PNB Mobile Banking</h4>
                        
                        <div class="qr-code-container">
                            <div class="qr-code">
                                <i class="fas fa-qrcode fa-5x text-muted"></i>
                            </div>
                            
                            <div class="merchant-info">
                                <div class="merchant-id">Merchant ID: CARRENTAL123</div>
                                <div class="amount">Amount: Nu. 15,000.00</div>
                                <div class="remark-note">* Please include your booking ID (BK12345) in the remarks</div>
                            </div>
                        </div>
                        
                        <div class="instruction-step">
                            <span class="step-number">1</span>
                            <span>Open Druk PNB mobile banking application</span>
                        </div>
                        
                        <div class="instruction-step">
                            <span class="step-number">2</span>
                            <span>Select "Scan & Pay" option</span>
                        </div>
                        
                        <div class="instruction-step">
                            <span class="step-number">3</span>
                            <span>Use camera to scan the QR code above</span>
                        </div>
                        
                        <div class="instruction-step">
                            <span class="step-number">4</span>
                            <span>Check merchant ID: CARRENTAL123</span>
                        </div>
                        
                        <div class="instruction-step">
                            <span class="step-number">5</span>
                            <span>Enter Nu. 15,000.00 as payment amount</span>
                        </div>
                        
                        <div class="instruction-step">
                            <span class="step-number">6</span>
                            <span>Add reference "BK12345" in remarks field</span>
                        </div>
                        
                        <div class="instruction-step">
                            <span class="step-number">7</span>
                            <span>Proceed to payment and enter your mPIN</span>
                        </div>
                        
                        <div class="instruction-step">
                            <span class="step-number">8</span>
                            <span>Capture screenshot of successful payment</span>
                        </div>
                        
                        <div class="important-note">
                            <i class="fas fa-info-circle me-2"></i>
                            Important: After completing the payment, please upload the screenshot of your payment confirmation to proceed with your car rental booking.
                        </div>
                    </div>
                    
                    <!-- BDBL Instructions -->
                    <div class="bank-tab-content" id="bdbl-content">
                        <h4>Pay with BDBL Mobile Banking</h4>
                        
                        <div class="qr-code-container">
                            <div class="qr-code">
                                <i class="fas fa-qrcode fa-5x text-muted"></i>
                            </div>
                            
                            <div class="merchant-info">
                                <div class="merchant-id">Merchant ID: CARRENTAL123</div>
                                <div class="amount">Amount: Nu. 15,000.00</div>
                                <div class="remark-note">* Please include your booking ID (BK12345) in the remarks</div>
                            </div>
                        </div>
                        
                        <div class="instruction-step">
                            <span class="step-number">1</span>
                            <span>Launch the BDBL mobile banking app</span>
                        </div>
                        
                        <div class="instruction-step">
                            <span class="step-number">2</span>
                            <span>Go to "QR Payments" section</span>
                        </div>
                        
                        <div class="instruction-step">
                            <span class="step-number">3</span>
                            <span>Select "Scan QR" option</span>
                        </div>
                        
                        <div class="instruction-step">
                            <span class="step-number">4</span>
                            <span>Scan the QR code displayed above</span>
                        </div>
                        
                        <div class="instruction-step">
                            <span class="step-number">5</span>
                            <span>Verify merchant details are correct</span>
                        </div>
                        
                        <div class="instruction-step">
                            <span class="step-number">6</span>
                            <span>Enter Nu. 15,000.00 as the payment amount</span>
                        </div>
                        
                        <div class="instruction-step">
                            <span class="step-number">7</span>
                            <span>Type "BK12345" in the remarks field</span>
                        </div>
                        
                        <div class="instruction-step">
                            <span class="step-number">8</span>
                            <span>Complete payment with your PIN</span>
                        </div>
                        
                        <div class="instruction-step">
                            <span class="step-number">9</span>
                            <span>Take a screenshot of the payment confirmation</span>
                        </div>
                        
                        <div class="important-note">
                            <i class="fas fa-info-circle me-2"></i>
                            Important: After completing the payment, please upload the screenshot of your payment confirmation to proceed with your car rental booking.
                        </div>
                    </div>
                    
                    <!-- Bank Transfer with OTP Instructions -->
                    <div class="bank-tab-content" id="bank-transfer-content">
                        <h4>Bank Transfer with OTP Verification</h4>
                        
                        <div class="alert alert-info mb-4">
                            <i class="fas fa-info-circle me-2"></i>
                            This payment method uses secure OTP verification to complete your bank transfer directly.
                        </div>
                        
                        <div class="instruction-step">
                            <span class="step-number">1</span>
                            <span>Select your bank from the dropdown menu</span>
                        </div>
                        
                        <div class="instruction-step">
                            <span class="step-number">2</span>
                            <span>Enter your bank account number</span>
                        </div>
                        
                        <div class="instruction-step">
                            <span class="step-number">3</span>
                            <span>Enter your registered mobile number</span>
                        </div>
                        
                        <div class="instruction-step">
                            <span class="step-number">4</span>
                            <span>Click "Send OTP" to receive a verification code</span>
                        </div>
                        
                        <div class="instruction-step">
                            <span class="step-number">5</span>
                            <span>Check your phone for an SMS with your 6-digit OTP</span>
                        </div>
                        
                        <div class="instruction-step">
                            <span class="step-number">6</span>
                            <span>Enter the 6-digit OTP in the verification field</span>
                        </div>
                        
                        <div class="instruction-step">
                            <span class="step-number">7</span>
                            <span>Click "Verify & Pay" to complete your payment</span>
                        </div>
                        
                        <div class="important-note">
                            <i class="fas fa-shield-alt me-2"></i>
                            Security Note: The OTP will be valid for 5 minutes only. If it expires, you'll need to request a new one.
                        </div>
                        
                        <div class="important-note mt-3">
                            <i class="fas fa-info-circle me-2"></i>
                            The total amount of Nu. 15,000.00 will be securely transferred from your account once verified.
                        </div>
                    </div>
                    
                    <!-- Pay Later Instructions -->
                    <div class="bank-tab-content" id="pay-later-content">
                        <h4>Pay Later Instructions</h4>
                        
                        <div class="alert alert-warning mb-4">
                            <i class="fas fa-exclamation-triangle me-2"></i>
                            By choosing the "Pay Later" option, you agree to pay the full amount at the time of car pickup.
                        </div>
                        
                        <div class="instruction-step">
                            <span class="step-number">1</span>
                            <span>Review your booking details carefully</span>
                        </div>
                        
                        <div class="instruction-step">
                            <span class="step-number">2</span>
                            <span>Click "Confirm Pay Later" to proceed with your booking</span>
                        </div>
                        
                        <div class="instruction-step">
                            <span class="step-number">3</span>
                            <span>You will receive a booking confirmation email with all details</span>
                        </div>
                        
                        <div class="instruction-step">
                            <span class="step-number">4</span>
                            <span>Prepare to pay the total amount of Nu. 15,000.00 at the time of car pickup</span>
                        </div>
                        
                        <div class="instruction-step">
                            <span class="step-number">5</span>
                            <span>Acceptable payment methods at pickup: Cash, Credit/Debit Card</span>
                        </div>
                        
                        <div class="important-note">
                            <i class="fas fa-info-circle me-2"></i>
                            Important: Please bring a valid ID and your booking confirmation when picking up the car. Failure to make payment at pickup will result in cancellation of your reservation.
                        </div>
                        
                        <div class="important-note mt-3">
                            <i class="fas fa-clock me-2"></i>
                            Note: If you prefer to pay in advance instead, you can return to the payment page anytime before your pickup date and use one of the online payment options.
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0/js/bootstrap.bundle.min.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Tab switching functionality
            const tabs = document.querySelectorAll('[data-bs-toggle="tab"]');
            tabs.forEach(tab => {
                tab.addEventListener('click', function(event) {
                    event.preventDefault();
                    
                    // Remove active class from all tabs and content
                    document.querySelectorAll('.nav-link').forEach(t => t.classList.remove('active'));
                    document.querySelectorAll('.bank-tab-content').forEach(c => c.classList.remove('active'));
                    
                    // Add active class to clicked tab
                    this.classList.add('active');
                    
                    // Show corresponding content
                    const target = this.getAttribute('data-bs-target');
                    document.querySelector(target).classList.add('active');
                });
            });
        });
    </script>
</body>
</html>