

<!-- Updated payment.blade.php with CSRF token and form -->
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="<?php echo e(csrf_token()); ?>">
    <title>Payment - Car Rental System</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <!-- Your existing CSS here -->
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
            
            <?php if(session('error')): ?>
                <div class="alert alert-danger">
                    <?php echo e(session('error')); ?>

                </div>
            <?php endif; ?>
            
            <?php if(session('success')): ?>
                <div class="alert alert-success">
                    <?php echo e(session('success')); ?>

                </div>
            <?php endif; ?>
            
            <div class="payment-header">
                <h2>SELECT PAYMENT METHOD</h2>
            </div>
            
            <div class="payment-body">
                <a href="<?php echo e(route('booking.summary', ['bookingId' => $booking->id])); ?>" class="back-link mb-4">
                    <i class="fas fa-arrow-left me-2"></i> Back to booking
                </a>
                
                <!-- Payment summary section -->
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
                                <span><i class="fas fa-door-open"></i> <?php echo e($booking->car->number_of_doors); ?> doors</span>
                            </div>
                            
                            <!-- Vehicle Features -->
                            <div class="vehicle-features mt-2">
                                <?php if($booking->car->air_conditioning === 'Yes'): ?>
                                    <span class="badge bg-success"><i class="fas fa-snowflake me-1"></i>AC</span>
                                <?php endif; ?>
                                <?php if($booking->car->backup_camera === 'Yes'): ?>
                                    <span class="badge bg-success"><i class="fas fa-video me-1"></i>Backup Camera</span>
                                <?php endif; ?>
                                <?php if($booking->car->bluetooth === 'Yes'): ?>
                                    <span class="badge bg-success"><i class="fas fa-bluetooth me-1"></i>Bluetooth</span>
                                <?php endif; ?>
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
                        $dailyRate = $booking->car->rate_per_day ?? $booking->car->price ?? 0;
                        $insuranceFee = 200;
                        $serviceFee = 100;
                        $totalPrice = ($dailyRate * $days) + $insuranceFee + $serviceFee;
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

                    <!-- Vehicle Information -->
                    <div class="summary-item">
                        <span>Vehicle</span>
                        <span><?php echo e($booking->car->maker); ?> <?php echo e($booking->car->model); ?> (<?php echo e($booking->car->registration_no); ?>)</span>
                    </div>

                    <?php if($booking->car->mileage_limit): ?>
                    <div class="summary-item">
                        <span>Daily Mileage Limit</span>
                        <span><?php echo e(number_format($booking->car->mileage_limit)); ?> km/day</span>
                    </div>
                    <?php endif; ?>

                    <hr>

                    <!-- Pricing Breakdown -->
                    <div class="summary-item">
                        <span>Rental Fee (<?php echo e($days); ?> day<?php echo e($days > 1 ? 's' : ''); ?> × BTN <?php echo e(number_format($dailyRate, 2)); ?>)</span>
                        <span>BTN <?php echo e(number_format($dailyRate * $days, 2)); ?></span>
                    </div>

                    <div class="summary-item">
                        <span>Insurance Fee</span>
                        <span>BTN <?php echo e(number_format($insuranceFee, 2)); ?></span>
                    </div>

                    <div class="summary-item">
                        <span>Service Fee</span>
                        <span>BTN <?php echo e(number_format($serviceFee, 2)); ?></span>
                    </div>

                    <?php if($booking->car->price_per_km && $booking->car->mileage_limit): ?>
                    <div class="summary-item text-muted">
                        <span><small>Excess Mileage Fee</small></span>
                        <span><small>BTN <?php echo e(number_format($booking->car->price_per_km, 2)); ?>/km</small></span>
                    </div>
                    <?php endif; ?>

                    <hr>

                    <div class="summary-item mb-0">
                        <span class="fw-bold">Total Amount</span>
                        <span class="total-amount">BTN <?php echo e(number_format($totalPrice, 2)); ?></span>
                    </div>
                    
                    <!-- PAYMENT OPTIONS -->
                    <h4 class="mb-3 mt-4">Choose Payment Method</h4>
                    
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
                            
                            <!-- Hidden form for QR payment submission -->
                            <form id="qrPaymentForm" action="<?php echo e(route('booking.payment.qr', ['bookingId' => $booking->id])); ?>" method="POST" enctype="multipart/form-data" style="display: none;">
                                <?php echo csrf_field(); ?>
                                <input type="hidden" name="bank_code" id="selected_bank_code">
                                <input type="hidden" name="total_amount" value="<?php echo e($totalPrice); ?>">
                                <input type="file" name="screenshot" id="screenshot_file">
                            </form>
                            
                            <div class="bank-selector">
                                <div class="bank-option" data-bank="bob" data-qr="../assets/images/bobQRcode.jpg">
                                    <img src="../assets/images/mbob.png" alt="Bank of Bhutan">
                                    <div>BOB</div>
                                </div>
                                <div class="bank-option" data-bank="bnb" data-qr="../assets/images/bnbQRcode.jpg">
                                    <img src="../assets/images/bnb.png" alt="Bhutan National Bank">
                                    <div>BNB</div>
                                </div>
                                <div class="bank-option" data-bank="tbank" data-qr="../assets/images/tbankQRcode.jpg">
                                    <img src="../assets/images/Tbank.jpg" alt="T-Bank">
                                    <div>T-Bank</div>
                                </div>
                                <div class="bank-option" data-bank="dpnb" data-qr="../assets/images/dpnbQRcode.jpg">
                                    <img src="../assets/images/drukpnb.png" alt="Druk PNB">
                                    <div>DPNB</div>
                                </div>
                                <div class="bank-option" data-bank="bdbl" data-qr="../assets/images/bdblQRcode.jpg">
                                    <img src="../assets/images/bdbl.jpg" alt="BDBL">
                                    <div>BDBL</div>
                                </div>
                            </div>
                            
                            <!-- Bank instructions -->
                            <div class="bank-instructions hidden" id="bob-instructions">
                                <h6>Payment Instructions for Bank of Bhutan</h6>
                                <ol>
                                    <li>Open your mBOB app</li>
                                    <li>Go to Payments > Scan QR</li>
                                    <li>Scan the QR code shown here</li>
                                    <li>Enter amount: BTN <?php echo e(number_format($totalPrice, 2)); ?></li>
                                    <li>Confirm payment using your PIN/password</li>
                                    <li>Take a screenshot of the confirmation</li>
                                    <li>Upload the screenshot below</li>
                                </ol>
                            </div>
                            
                            <div class="bank-instructions hidden" id="bnb-instructions">
                                <h6>Payment Instructions for Bhutan National Bank</h6>
                                <ol>
                                    <li>Open your BNB mPAY app</li>
                                    <li>Select "Scan & Pay" option</li>
                                    <li>Scan the QR code shown here</li>
                                    <li>Enter amount: BTN <?php echo e(number_format($totalPrice, 2)); ?></li>
                                    <li>Enter your mPIN to authorize payment</li>
                                    <li>Take a screenshot of the payment receipt</li>
                                    <li>Upload the screenshot below</li>
                                </ol>
                            </div>
                            
                            <div class="bank-instructions hidden" id="tbank-instructions">
                                <h6>Payment Instructions for T-Bank</h6>
                                <ol>
                                    <li>Log in to your T-Bank mobile app</li>
                                    <li>Tap on "Payments" > "QR Payments"</li>
                                    <li>Scan the QR code shown here</li>
                                    <li>Verify recipient details</li>
                                    <li>Enter amount: BTN <?php echo e(number_format($totalPrice, 2)); ?></li>
                                    <li>Confirm payment with your secure PIN</li>
                                    <li>Take a screenshot of the transaction receipt</li>
                                    <li>Upload the screenshot below</li>
                                </ol>
                            </div>
                            
                            <div class="bank-instructions hidden" id="dpnb-instructions">
                                <h6>Payment Instructions for Druk PNB</h6>
                                <ol>
                                    <li>Open the Druk PNB mobile banking app</li>
                                    <li>Select "QR Payments" from the main menu</li>
                                    <li>Scan the QR code shown here</li>
                                    <li>Enter amount: BTN <?php echo e(number_format($totalPrice, 2)); ?></li>
                                    <li>Verify recipient information</li>
                                    <li>Confirm using your MPIN</li>
                                    <li>Take a screenshot of the success page</li>
                                    <li>Upload the screenshot below</li>
                                </ol>
                            </div>
                            
                            <div class="bank-instructions hidden" id="bdbl-instructions">
                                <h6>Payment Instructions for BDBL</h6>
                                <ol>
                                    <li>Login to your BDBL mobile banking app</li>
                                    <li>Tap on "QR Code Payment"</li>
                                    <li>Scan the QR code shown here</li>
                                    <li>Check recipient name: "Car Rental System"</li>
                                    <li>Enter amount: BTN <?php echo e(number_format($totalPrice, 2)); ?></li>
                                    <li>Enter your security PIN to complete payment</li>
                                    <li>Take a screenshot of the payment confirmation</li>
                                    <li>Upload the screenshot below</li>
                                </ol>
                            </div>
                            
                            <div class="qr-code-container hidden" id="qrContainer">
                                <div class="qr-wrapper">
                                    <img src="../assets/images/bobQRcode.jpg" alt="QR Code" class="qr-code-image" id="bankQrCode">
                                </div>
                                
                                <div class="qr-details text-center">
                                    <p class="name">Car Rental System</p>
                                    <p class="amount">Amount: <strong>BTN <?php echo e(number_format($totalPrice, 2)); ?></strong></p>
                                    <p class="booking-ref">Booking: <strong>#<?php echo e($booking->id); ?></strong></p>
                                </div>
                                
                                <label class="upload-btn mt-4">
                                    <i class="fas fa-upload"></i>
                                    <span>Upload Payment Screenshot</span>
                                    <input type="file" id="payment_screenshot" style="display: none;" accept="image/*" required>
                                </label>
                                
                                <div id="screenshot-preview" class="mt-3 hidden">
                                    <img id="preview-image" src="" alt="Screenshot Preview" style="max-width: 200px; max-height: 200px;">
                                    <p class="text-success mt-2"><i class="fas fa-check-circle"></i> Screenshot uploaded successfully</p>
                                </div>
                            </div>
                            
                            <p class="text-center mt-3 text-muted" id="qrPrompt">Please select a bank to display the QR code</p>
                            
                            <div class="text-center mt-3">
                                <button type="button" class="payment-btn" id="confirmQrBtn" disabled>Confirm Payment</button>
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
                            
                                <?php echo csrf_field(); ?>
                                <input type="hidden" name="total_amount" value="<?php echo e($totalPrice); ?>">
                                
                                <div class="mb-3">
                                    <label class="form-label">Bank Code</label>
                                    <select class="bank-dropdown form-control" name="bank_code" required>
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
                                    <input type="text" class="account-input form-control" name="account_number" placeholder="Enter Account Number" required>
                                </div>
                                
                                <div class="mb-3">
                                    <label class="form-label">Account Holder Name</label>
                                    <input type="text" class="form-control" name="account_holder" placeholder="Enter Account Holder Name" required>
                                </div>
                                
                                <div class="text-center mt-4">
                                    <button type="button" class="otp-btn" id="sendOtpBtn">Send OTP</button>
                                </div>
                                
                                <div class="mt-4 hidden" id="otpSection">
                                    <label class="form-label">Enter OTP</label>
                                    <div class="d-flex gap-2 justify-content-center">
                                        <input type="text" maxlength="1" class="form-control text-center otp-input" style="width: 50px;">
                                        <input type="text" maxlength="1" class="form-control text-center otp-input" style="width: 50px;">
                                        <input type="text" maxlength="1" class="form-control text-center otp-input" style="width: 50px;">
                                        <input type="text" maxlength="1" class="form-control text-center otp-input" style="width: 50px;">
                                        <input type="text" maxlength="1" class="form-control text-center otp-input" style="width: 50px;">
                                        <input type="text" maxlength="1" class="form-control text-center otp-input" style="width: 50px;">
                                    </div>
                                    <input type="hidden" name="otp_code" id="otpCode">
                                    
                                    <div class="text-center mt-4">
                                        <button type="submit" class="payment-btn">Verify & Pay</button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                    
                    <!-- Option 3: Pay Later -->
                    <div class="payment-option" id="option3">
                        <div class="payment-option-header">
                            <div class="payment-option-icon">
                                <i class="fas fa-hourglass-half"></i>
                            </div>
                            <h5 class="payment-option-title">Pay at Pickup</h5>
                        </div>
                        <div class="payment-option-body">
                            <p>Select this option if you prefer to pay in cash at the time of pickup.</p>
                            
                            <div class="alert alert-warning">
                                <i class="fas fa-info-circle me-2"></i>
                                Please note that choosing "Pay at Pickup" option means you will need to pay the full amount of <strong>BTN <?php echo e(number_format($totalPrice, 2)); ?></strong> when you meet for the car handover.
                            </div>
                            
                            <?php if($booking->car->mileage_limit): ?>
                            <div class="alert alert-info">
                                <i class="fas fa-road me-2"></i>
                                <strong>Mileage Limit:</strong> <?php echo e(number_format($booking->car->mileage_limit)); ?> km per day. 
                                <?php if($booking->car->price_per_km): ?>
                                    Excess mileage will be charged at BTN <?php echo e(number_format($booking->car->price_per_km, 2)); ?> per km.
                                <?php endif; ?>
                            </div>
                            <?php endif; ?>
                            
                            <!-- Hidden form for Pay Later submission -->
                            <form id="payLaterForm" method="POST" action="<?php echo e(route('booking.payment.payLater', ['bookingId' => $booking->id])); ?>" style="display: none;">
                                <?php echo csrf_field(); ?>
                                <input type="hidden" name="total_amount" value="<?php echo e($totalPrice); ?>">
                                <input type="hidden" name="notes" value="Customer opted to pay at pickup - Total: BTN <?php echo e(number_format($totalPrice, 2)); ?>">
                            </form>
                            
                            <div class="text-center mt-4">
                                <button type="button" class="btn btn-primary payment-btn" id="confirmPayLaterBtn">Confirm Pay at Pickup</button>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="footer-actions mt-4 d-flex justify-content-between">
                    <a href="<?php echo e(route('booking.summary', ['bookingId' => $booking->id])); ?>" class="btn btn-secondary cancel-btn">Cancel</a>
                    <div class="text-muted">
                        <small>Booking ID: #<?php echo e($booking->id); ?></small>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Add CSRF token meta tag for Ajax requests -->
<meta name="csrf-token" content="<?php echo e(csrf_token()); ?>">



<?php $__env->startSection('styles'); ?>
<style>
    .payment-options {
        display: flex;
        flex-direction: column;
        gap: 1rem;
    }
    
    .payment-option {
        border: 1px solid #ddd;
        border-radius: 8px;
        overflow: hidden;
        cursor: pointer;
        transition: all 0.3s;
    }
    
    .payment-option:hover {
        border-color: #007bff;
        box-shadow: 0 0 10px rgba(0,123,255,0.1);
    }
    
    .payment-option.active {
        border-color: #007bff;
        box-shadow: 0 0 15px rgba(0,123,255,0.2);
    }
    
    .payment-option-header {
        display: flex;
        align-items: center;
        padding: 15px;
        background-color: #f8f9fa;
        border-bottom: 1px solid #ddd;
    }
    
    .payment-option-icon {
        width: 40px;
        height: 40px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 20px;
        background-color: #e9ecef;
        border-radius: 50%;
        margin-right: 15px;
    }
    
    .payment-option-title {
        margin: 0;
        font-size: 18px;
    }
    
    .payment-option-body {
        padding: 15px;
    }
    
    .bank-options {
        display: flex;
        flex-wrap: wrap;
        gap: 10px;
        margin-top: 15px;
    }
    
    .bank-option {
        display: flex;
        flex-direction: column;
        align-items: center;
        padding: 10px;
        border: 1px solid #ddd;
        border-radius: 8px;
        cursor: pointer;
        transition: all 0.2s;
        width: calc(20% - 10px);
    }
    
    .bank-option:hover {
        border-color: #007bff;
    }
    
    .bank-option.active {
        border-color: #007bff;
        background-color: #f0f7ff;
    }
    
    .bank-option span {
        margin-top: 5px;
        font-size: 12px;
        text-align: center;
    }
    
    .qr-code-wrapper {
        max-width: 250px;
        margin: 0 auto;
        padding: 15px;
        border: 1px dashed #ddd;
        border-radius: 8px;
    }
    
    .hidden {
        display: none;
    }
    
    .otp-inputs {
        display: flex;
        justify-content: center;
        gap: 10px;
        margin-top: 20px;
    }
    
    .otp-inputs input {
        width: 50px;
        height: 50px;
        text-align: center;
        font-size: 20px;
        border: 1px solid #ddd;
        border-radius: 8px;
    }
    
    .footer-actions {
        margin-top: 30px;
    }
</style>


<?php $__env->startSection('scripts'); ?>
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
    
    // QR code mapping for different banks
    const bankQRcodes = {
        'bob': '../assets/images/bobQRcode.jpg',
        'bnb': '../assets/images/bdblQRcode.jpg',
        'tbank': '../assets/images/bdblQRcode.jpg',
        'dpnb': '../assets/images/DrukpnbQRcode.jpg',
        'bdbl': '../assets/images/bdblQRcode.jpg'
    };
    
    // Track selected bank
    let selectedBank = null;
    
    // Bank option selection for QR codes
    const bankOptions = document.querySelectorAll('.bank-option');
    const bankInstructions = document.querySelectorAll('.bank-instructions');
    
    bankOptions.forEach(bank => {
        bank.addEventListener('click', function() {
            const bankCode = this.getAttribute('data-bank');
            selectedBank = bankCode; // Store selected bank code
            
            // Update the hidden input in the form
            document.getElementById('selected_bank_code').value = bankCode;
            
            // Remove active class from all bank options
            bankOptions.forEach(b => b.classList.remove('active'));
            
            // Hide all bank instructions
            bankInstructions.forEach(instruction => {
                if (instruction) instruction.classList.add('hidden');
            });
            
            // Add active class to clicked bank option
            this.classList.add('active');
            
            // Show specific bank instructions if they exist
            const instructionElement = document.getElementById(`${bankCode}-instructions`);
            if (instructionElement) instructionElement.classList.remove('hidden');
            
            // Update QR code image
            document.getElementById('bankQrCode').src = bankQRcodes[bankCode];
            
            // Show QR code container
            document.getElementById('qrContainer').classList.remove('hidden');
            
            // Hide prompt text
            document.getElementById('qrPrompt').classList.add('hidden');
            
            // Keep confirm button disabled until screenshot is uploaded
            checkEnableConfirmButton();
        });
    });
    
    // File upload handling for the visible file input
    const paymentScreenshot = document.getElementById('payment_screenshot');
    if (paymentScreenshot) {
        paymentScreenshot.addEventListener('change', function() {
            if (this.files && this.files[0]) {
                // Copy the file to the hidden form input
                const hiddenFileInput = document.getElementById('screenshot_file');
                
                // Create a new DataTransfer object
                const dataTransfer = new DataTransfer();
                dataTransfer.items.add(this.files[0]);
                
                // Set the files property of the hidden file input
                hiddenFileInput.files = dataTransfer.files;
                
                alert('Screenshot uploaded successfully! Click "Confirm Payment" to complete your transaction.');
                
                // Enable confirm button if both bank and file are selected
                checkEnableConfirmButton();
            }
        });
    }
    
    // Function to check if confirm button should be enabled
    function checkEnableConfirmButton() {
        const screenshotFile = document.getElementById('screenshot_file');
        const confirmBtn = document.getElementById('confirmQrBtn');
        
        if (screenshotFile && confirmBtn) {
            if (selectedBank && screenshotFile.files[0]) {
                confirmBtn.removeAttribute('disabled');
            } else {
                confirmBtn.setAttribute('disabled', 'disabled');
            }
        }
    }
    
    // Add confirm button click handler for QR Payment
    const confirmQrBtn = document.getElementById('confirmQrBtn');
    if (confirmQrBtn) {
        confirmQrBtn.addEventListener('click', function() {
            if (!selectedBank) {
                alert('Please select a bank');
                return;
            }
            
            const screenshotFile = document.getElementById('screenshot_file').files[0];
            if (!screenshotFile) {
                alert('Please upload a payment screenshot');
                return;
            }
            
            // Validate file before submission
            if (screenshotFile.size > 2 * 1024 * 1024) {
                alert('File size must be less than 2MB');
                return;
            }
            
            if (!['image/jpeg', 'image/png', 'image/jpg'].includes(screenshotFile.type)) {
                alert('Only JPEG and PNG files are allowed');
                return;
            }
            
            // Show loading state
            confirmQrBtn.setAttribute('disabled', 'disabled');
            confirmQrBtn.textContent = 'Processing...';
            
            // Create form data for AJAX submission
            const formData = new FormData();
            formData.append('bank_code', selectedBank);
            formData.append('screenshot', screenshotFile);
            formData.append('_token', document.querySelector('meta[name="csrf-token"]').content);
            
            // Get the form action URL
            const formAction = document.getElementById('qrPaymentForm').getAttribute('action');
            
            // Send AJAX request
            fetch(formAction, {
                method: 'POST',
                body: formData,
                headers: {
                    'X-Requested-With': 'XMLHttpRequest' // This makes Laravel detect it as an AJAX request
                }
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    // Show success message
                    alert(data.message);
                    // Redirect to the summary page
                    window.location.href = data.redirect;
                } else {
                    // Show error message
                    alert(data.message || 'An error occurred while processing your payment. Please try again.');
                    confirmQrBtn.removeAttribute('disabled');
                    confirmQrBtn.textContent = 'Confirm Payment';
                }
            })
            .catch(error => {
                console.error('Error details:', error);
                alert('An error occurred while processing your payment. Please try again.');
                confirmQrBtn.removeAttribute('disabled');
                confirmQrBtn.textContent = 'Confirm Payment';
            });
        });
    }
    
    // Pay Later functionality
    const payLaterConfirmBtn = document.querySelector('#option3 .payment-btn');
    if (payLaterConfirmBtn) {
        payLaterConfirmBtn.addEventListener('click', function() {
            // Show loading state
            payLaterConfirmBtn.setAttribute('disabled', 'disabled');
            payLaterConfirmBtn.textContent = 'Processing...';
            
            // Get the form
            const payLaterForm = document.getElementById('payLaterForm');
            
            // Get the URL from the window location if needed
            const bookingId = urlParams.get('bookingId') || window.location.pathname.split('/').filter(Boolean).pop();
            
            // Use fetch to submit the form via AJAX
            fetch(payLaterForm.action, {
                method: 'POST',
                body: new FormData(payLaterForm),
                headers: {
                    'X-Requested-With': 'XMLHttpRequest',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                }
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    // Show success message
                    alert(data.message || 'Pay Later option confirmed!');
                    // Redirect to the summary page
                    window.location.href = data.redirect;
                } else {
                    // Show error message
                    alert(data.message || 'An error occurred while processing your request. Please try again.');
                    payLaterConfirmBtn.removeAttribute('disabled');
                    payLaterConfirmBtn.textContent = 'Confirm Pay Later';
                }
            })
            .catch(error => {
                console.error('Error details:', error);
                alert('An error occurred while processing your request. Please try again.');
                payLaterConfirmBtn.removeAttribute('disabled');
                payLaterConfirmBtn.textContent = 'Confirm Pay Later';
            });
        });
    }
    
    // Handle Next button for multi-step payment process
    const nextBtn = document.getElementById('nextBtn');
    if (nextBtn) {
        nextBtn.addEventListener('click', function() {
            // Get the selected payment option
            const selectedOption = document.querySelector('.payment-option.active');
            
            if (!selectedOption) {
                alert('Please select a payment option');
                return;
            }
            
            // Get the option ID
            const optionId = selectedOption.id;
            
            // Perform action based on selected option
            if (optionId === 'option3') {
                // Trigger the Pay Later confirmation
                const payLaterBtn = document.querySelector('#option3 .payment-btn');
                if (payLaterBtn) {
                    payLaterBtn.click();
                }
            } else if (optionId === 'option1') {
                // For QR payment, scroll to QR section
                const qrContainer = document.getElementById('qrContainer');
                if (qrContainer && !qrContainer.classList.contains('hidden')) {
                    // QR code is already displayed, check if screenshot is uploaded
                    const confirmQrBtn = document.getElementById('confirmQrBtn');
                    if (confirmQrBtn && !confirmQrBtn.hasAttribute('disabled')) {
                        confirmQrBtn.click();
                    } else {
                        alert('Please complete the QR payment process');
                    }
                } else {
                    alert('Please select a bank for QR payment');
                }
            }
        });
    }
});
</script>
<?php /**PATH C:\Users\Thinley Norbu\Documents\GitHub\FinalProject\resources\views/payment.blade.php ENDPATH**/ ?>