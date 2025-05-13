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
            object-fit: contain;
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
        .bank-instructions {
            margin-top: 15px;
            padding: 15px;
            background-color: #f8f9fa;
            border-radius: 5px;
            border-left: 4px solid #28a745;
        }
        .bank-instructions h6 {
            margin-bottom: 10px;
            color: #343a40;
        }
        .bank-instructions ol {
            padding-left: 20px;
            margin-bottom: 0;
        }
        .bank-instructions li {
            margin-bottom: 5px;
        }
        .qr-wrapper {
            position: relative;
            width: 250px;
            margin: 0 auto;
        }
        .qr-code-image {
            width: 100%;
            border-radius: 8px;
            border: 1px solid #dee2e6;
        }
        .qr-details {
            text-align: center;
            margin-top: 15px;
            padding: 10px;
            background-color: #f8f9fa;
            border-radius: 5px;
        }
        .qr-details p {
            margin-bottom: 5px;
        }
        .qr-details .name {
            font-weight: bold;
            font-size: 16px;
        }
        .qr-details .phone {
            color: #6c757d;
        }
        .vehicle-info {
            display: flex;
            align-items: center;
            margin-bottom: 15px;
        }
        .vehicle-image {
            width: 80px;
            height: 60px;
            background-color: #f8f9fa;
            border-radius: 5px;
            margin-right: 15px;
            display: flex;
            align-items: center;
            justify-content: center;
            overflow: hidden;
        }
        .vehicle-image img {
            max-width: 100%;
            max-height: 100%;
            object-fit: cover;
        }
        .vehicle-details {
            flex: 1;
        }
        .vehicle-specs {
            display: flex;
            gap: 10px;
            margin-top: 5px;
        }
        .vehicle-specs span {
            font-size: 12px;
            color: #6c757d;
            display: flex;
            align-items: center;
        }
        .vehicle-specs span i {
            margin-right: 3px;
        }
        .location-details {
            background-color: #fff;
            border-left: 3px solid #28a745;
            padding: 10px;
            margin-bottom: 15px;
            border-radius: 0 5px 5px 0;
        }
        .badge {
            padding: 5px 10px;
            border-radius: 10px;
            font-size: 12px;
            font-weight: 500;
        }
        .badge-success {
            background-color: #d4edda;
            color: #155724;
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
                <a href="<?php echo e(route('booking.summary', ['bookingId' => $booking->id])); ?>" class="back-link mb-4">
                    <i class="fas fa-arrow-left me-2"></i> Back to booking
                </a>
                
                <div class="payment-summary">
                    <h4 class="mb-4">Booking Summary</h4>
                    
                    <!-- Vehicle Info -->
                    <div class="vehicle-info">
                        <div class="vehicle-image">
                            <?php if($booking->car->images && $booking->car->images->count()): ?>
                                <img src="<?php echo e(asset($booking->car->images->first()->image_path)); ?>" alt="<?php echo e($booking->car->maker); ?> <?php echo e($booking->car->model); ?>">
                            <?php elseif($booking->car->car_image): ?>
                                <img src="<?php echo e(asset($booking->car->car_image)); ?>" alt="<?php echo e($booking->car->maker); ?> <?php echo e($booking->car->model); ?>">
                            <?php else: ?>
                                <i class="fas fa-car"></i>
                            <?php endif; ?>
                        </div>
                        <div class="vehicle-details">
                            <h5 class="mb-0"><?php echo e($booking->car->maker); ?> <?php echo e($booking->car->model); ?></h5>
                            <div class="vehicle-specs">
                                <span><i class="fas fa-cog"></i> <?php echo e($booking->car->transmission_type); ?></span>
                                <span><i class="fas fa-gas-pump"></i> <?php echo e($booking->car->fuel_type); ?></span>
                                <span><i class="fas fa-users"></i> <?php echo e($booking->car->number_of_seats); ?> seats</span>
                            </div>
                        </div>
                        <span class="badge <?php echo e($booking->status === 'confirmed' ? 'badge-success' : 'badge-warning'); ?>">
                            <?php echo e(ucfirst($booking->status)); ?>

                        </span>
                    </div>
                    
                    <div class="row mb-3">
                        <div class="col-md-6">
                            <div class="location-details">
                                <small class="text-muted">PICK-UP</small>
                                <p class="mb-1"><strong><?php echo e($booking->pickup_location); ?></strong></p>
                                <p class="mb-0"><?php echo e($booking->pickup_datetime->setTimezone('Asia/Thimphu')->format('M d, Y h:i A')); ?></p>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="location-details">
                                <small class="text-muted">DROP-OFF</small>
                                <p class="mb-1"><strong><?php echo e($booking->dropoff_location); ?></strong></p>
                                <p class="mb-0"><?php echo e($booking->dropoff_datetime->setTimezone('Asia/Thimphu')->format('M d, Y h:i A')); ?></p>
                            </div>
                        </div>
                    </div>
                    
                    <?php
                        $hours = $booking->pickup_datetime->diffInHours($booking->dropoff_datetime);
                        $days = ceil($hours / 24); // Round up to full days for pricing
                        $dailyRate = $booking->car->price;
                        $insuranceFee = 200;
                        $serviceFee = 100;
                        $securityDeposit = $dailyRate; // Typically 1 day's rent as deposit
                        $totalPrice = ($dailyRate * $days) + $insuranceFee + $serviceFee + $securityDeposit;
                    ?>
                    
                    <div class="summary-item">
                        <span>Booking ID</span>
                        <span id="bookingId">#<?php echo e($booking->id); ?></span>
                    </div>
                    
                    <div class="summary-item">
                        <span>Duration</span>
                        <span>
                            <?php if($days > 0): ?>
                                <?php echo e($days); ?> day<?php echo e($days > 1 ? 's' : ''); ?>

                            <?php endif; ?>
                            <?php if($hours % 24 > 0): ?>
                                <?php echo e($hours % 24); ?> hour<?php echo e($hours % 24 > 1 ? 's' : ''); ?>

                            <?php endif; ?>
                        </span>
                    </div>
                    
                    <hr>
                    
                    <div class="summary-item">
                        <span>Rental Fee (<?php echo e($days); ?> day<?php echo e($days > 1 ? 's' : ''); ?> × Nu. <?php echo e(number_format($dailyRate, 2)); ?>)</span>
                        <span>Nu. <?php echo e(number_format($dailyRate * $days, 2)); ?></span>
                    </div>
                    
                    <div class="summary-item">
                        <span>Insurance Fee</span>
                        <span>Nu. <?php echo e(number_format($insuranceFee, 2)); ?></span>
                    </div>
                    
                    <div class="summary-item">
                        <span>Service Fee</span>
                        <span>Nu. <?php echo e(number_format($serviceFee, 2)); ?></span>
                    </div>
                    
                    <div class="summary-item">
                        <span>Security Deposit</span>
                        <span>Nu. <?php echo e(number_format($securityDeposit, 2)); ?></span>
                    </div>
                    
                    <hr>
                    
                    <div class="summary-item mb-0">
                        <span class="fw-bold">Total Amount</span>
                        <span class="total-amount">Nu. <?php echo e(number_format($totalPrice, 2)); ?></span>
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
                        <p>Choose your bank below and follow the instructions to complete your payment.</p>
                        
                        <div class="bank-selector">
                            <div class="bank-option" data-bank="bob">
                                <img src="../assets/images/mbob.png" alt="Bank of Bhutan">
                                <div>BOB</div>
                            </div>
                            <div class="bank-option" data-bank="bnb">
                                <img src="../assets/images/bnb.png" alt="Bhutan National Bank">
                                <div>BNB</div>
                            </div>
                            <div class="bank-option" data-bank="tbank">
                                <img src="../assets/images/Tbank.jpg" alt="T-Bank">
                                <div>T-Bank</div>
                            </div>
                            <div class="bank-option" data-bank="dpnb">
                                <img src="../assets/images/drukpnb.png" alt="Druk PNB">
                                <div>DPNB</div>
                            </div>
                            <div class="bank-option" data-bank="bdbl">
                                <img src="../assets/images/bdbl.jpg" alt="BDBL">
                                <div>BDBL</div>
                            </div>
                        </div>
                        
                        <!-- BOB Instructions -->
                        <div class="bank-instructions hidden" id="bob-instructions">
                            <h6>Payment Instructions for Bank of Bhutan</h6>
                            <ol>
                                <li>Open your mBOB app</li>
                                <li>Go to Payments > Scan QR</li>
                                <li>Scan the QR code shown here</li>
                                <li>Enter amount: Nu. 15,300.00</li>
                                <li>Confirm payment using your PIN/password</li>
                                <li>Take a screenshot of the confirmation</li>
                                <li>Upload the screenshot below</li>
                            </ol>
                        </div>
                        
                        <!-- BNB Instructions -->
                        <div class="bank-instructions hidden" id="bnb-instructions">
                            <h6>Payment Instructions for Bhutan National Bank</h6>
                            <ol>
                                <li>Open your BNB mPAY app</li>
                                <li>Select "Scan & Pay" option</li>
                                <li>Scan the QR code shown here</li>
                                <li>Enter amount: Nu. 15,300.00</li>
                                <li>Enter your mPIN to authorize payment</li>
                                <li>Take a screenshot of the payment receipt</li>
                                <li>Upload the screenshot below</li>
                            </ol>
                        </div>
                        
                        <!-- T-Bank Instructions -->
                        <div class="bank-instructions hidden" id="tbank-instructions">
                            <h6>Payment Instructions for T-Bank</h6>
                            <ol>
                                <li>Log in to your T-Bank mobile app</li>
                                <li>Tap on "Payments" > "QR Payments"</li>
                                <li>Scan the QR code shown here</li>
                                <li>Verify recipient details</li>
                                <li>Enter amount: Nu. 15,300.00</li>
                                <li>Confirm payment with your secure PIN</li>
                                <li>Take a screenshot of the transaction receipt</li>
                                <li>Upload the screenshot below</li>
                            </ol>
                        </div>
                        
                        <!-- DPNB Instructions -->
                        <div class="bank-instructions hidden" id="dpnb-instructions">
                            <h6>Payment Instructions for Druk PNB</h6>
                            <ol>
                                <li>Open the Druk PNB mobile banking app</li>
                                <li>Select "QR Payments" from the main menu</li>
                                <li>Scan the QR code shown here</li>
                                <li>Enter amount: Nu. 15,300.00</li>
                                <li>Verify recipient information</li>
                                <li>Confirm using your MPIN</li>
                                <li>Take a screenshot of the success page</li>
                                <li>Upload the screenshot below</li>
                            </ol>
                        </div>
                        
                        <!-- BDBL Instructions -->
                        <div class="bank-instructions hidden" id="bdbl-instructions">
                            <h6>Payment Instructions for BDBL</h6>
                            <ol>
                                <li>Login to your BDBL mobile banking app</li>
                                <li>Tap on "QR Code Payment"</li>
                                <li>Scan the QR code shown here</li>
                                <li>Check recipient name: "THINLEY NORBU"</li>
                                <li>Enter amount: Nu. 15,300.00</li>
                                <li>Enter your security PIN to complete payment</li>
                                <li>Take a screenshot of the payment confirmation</li>
                                <li>Upload the screenshot below</li>
                            </ol>
                        </div>
                        
                        <div class="qr-code-container hidden" id="qrContainer">
                            <div class="qr-wrapper">
                                <img src="../assets/images/bobQRcode.jpg" alt="QR Code" class="qr-code-image" id="bankQrCode">
                            </div>
                            
                            <div class="qr-details">
                                <p class="name">Car Rental System</p>
                                <p class="amount">Amount: <strong>Nu. 15,300.00</strong></p>
                            </div>
                            
                            <label class="upload-btn mt-4">
                                <i class="fas fa-upload"></i>
                                <span>Upload Payment Screenshot</span>
                                <input type="file" style="display: none;" accept="image/*">
                            </label>
                        </div>
                        
                        <p class="text-center mt-3 text-muted" id="qrPrompt">Please select a bank to display the QR code</p>
                        
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
            
            // Bank logos mapping - Updated with actual image paths
            const bankLogos = {
                'bob': '../assets/images/mbob.png',
                'bnb': '../assets/images/bnb.png',
                'tbank': '../assets/images/Tbank.jpg',
                'dpnb': '../assets/images/drukpnb.png',
                'bdbl': '../assets/images/bdbl.jpg'
            };
            
            // QR code mapping for different banks - for now we're using the BOB QR for all
            const bankQRcodes = {
                'bob': '../assets/images/bobQRcode.jpg',
                'bnb': '../assets/images/bdblQRcode.jpg',
                'tbank': '../assets/images/bdblQRcode.jpg',
                'dpnb': '../assets/images/DrukpnbQRcode.jpg',
                'bdbl': '../assets/images/bdblQRcode.jpg'
            };
            // Bank option selection for QR codes
            const bankOptions = document.querySelectorAll('.bank-option');
            const bankInstructions = document.querySelectorAll('.bank-instructions');
            
            bankOptions.forEach(bank => {
                bank.addEventListener('click', function() {
                    const bankCode = this.getAttribute('data-bank');
                    
                    // Remove active class from all bank options
                    bankOptions.forEach(b => b.classList.remove('active'));
                    
                    // Hide all bank instructions
                    bankInstructions.forEach(instruction => instruction.classList.add('hidden'));
                    
                    // Add active class to clicked bank option
                    this.classList.add('active');
                    
                    // Show specific bank instructions
                    document.getElementById(`${bankCode}-instructions`).classList.remove('hidden');
                    
                    // Update QR code image
                    document.getElementById('bankQrCode').src = bankQRcodes[bankCode];
                    
                    // Show QR code container
                    document.getElementById('qrContainer').classList.remove('hidden');
                    
                    // Hide prompt text
                    document.getElementById('qrPrompt').classList.add('hidden');
                    
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
            
            // File upload preview
            const fileInput = document.querySelector('input[type="file"]');
            fileInput.addEventListener('change', function() {
                if (this.files && this.files[0]) {
                    alert('Screenshot uploaded successfully! Click "Confirm Payment" to complete your transaction.');
                }
            });
        });
    </script>
</body>
</html><?php /**PATH C:\Users\Sangay Ngedup\Documents\GitHub\FinalProject\resources\views/payment.blade.php ENDPATH**/ ?>