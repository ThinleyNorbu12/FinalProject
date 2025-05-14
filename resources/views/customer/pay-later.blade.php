<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pay Later - Car Rental Dashboard</title>
    <!-- Link to the external CSS file -->
    <link rel="stylesheet" href="{{ asset('assets/css/customer/dashboard.css') }}">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" rel="stylesheet">
    <style>
        .badge {
            padding: 6px 10px;
            border-radius: 12px;
            font-size: 12px;
            font-weight: 500;
            display: inline-block;
            text-align: center;
        }

        .badge-overdue {
            background-color: #FFE1E1;
            color: #F44336;
        }

        .badge-pending {
            background-color: #FFF4E5;
            color: #FF9800;
        }

        .badge-upcoming {
            background-color: #E3F2FD;
            color: #2196F3;
        }

        .badge-paid {
            background-color: #E8F5E9;
            color: #4CAF50;
        }

        /* Payment summary */
        .payment-summary {
            background-color: #F8F9FA;
            border-radius: 8px;
            padding: 20px;
            margin-top: 30px;
        }

        .payment-summary h4 {
            margin-top: 0;
            margin-bottom: 15px;
            font-size: 18px;
        }

        .summary-item {
            display: flex;
            justify-content: space-between;
            margin-bottom: 10px;
            color: #555;
        }

        .summary-total {
            display: flex;
            justify-content: space-between;
            margin-top: 15px;
            padding-top: 15px;
            border-top: 1px solid #DEE2E6;
            font-weight: bold;
            font-size: 16px;
        }

        /* Car info styling */
        .car-info {
            display: flex;
            align-items: center;
        }

        .car-thumbnail {
            width: 80px;
            height: 60px;
            margin-right: 15px;
            border-radius: 4px;
            overflow: hidden;
        }

        .car-thumbnail img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }

        .car-model {
            font-weight: 600;
            margin-bottom: 4px;
        }

        .car-details {
            color: #6C757D;
            font-size: 13px;
        }

        /* Payment buttons */
        .btn-pay {
            background-color: #007BFF;
            color: white;
            border: none;
            border-radius: 4px;
            padding: 8px 15px;
            cursor: pointer;
            font-size: 14px;
            transition: background-color 0.2s;
        }

        .btn-pay:hover {
            background-color: #0069D9;
        }

        .payment-complete {
            color: #4CAF50;
            font-weight: 500;
        }

        /* No payments message */
        .no-payments {
            text-align: center;
            padding: 40px 20px;
            background-color: #F8F9FA;
            border-radius: 8px;
            margin-top: 20px;
        }

        .no-payments i {
            font-size: 48px;
            color: #4CAF50;
            margin-bottom: 15px;
        }

        .no-payments p {
            font-size: 18px;
            color: #555;
        }

        /* Payment modal styling */
        .modal {
            display: none;
            position: fixed;
            z-index: 1000;
            left: 0;
            top: 0;
            width: 100%;
            height: 100%;
            overflow: auto;
            background-color: rgba(0, 0, 0, 0.5);
        }

        .modal-content {
            background-color: white;
            margin: 10% auto;
            padding: 0;
            width: 90%;
            max-width: 500px;
            border-radius: 8px;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.2);
        }

        .modal-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 15px 20px;
            border-bottom: 1px solid #DEE2E6;
        }

        .modal-header h3 {
            margin: 0;
            font-size: 20px;
        }

        .modal-close {
            font-size: 28px;
            font-weight: bold;
            cursor: pointer;
        }

        .payment-details {
            padding: 20px;
            border-bottom: 1px solid #DEE2E6;
        }

        .payment-detail-item {
            display: flex;
            justify-content: space-between;
            margin-bottom: 10px;
        }

        .payment-detail-item:last-child {
            margin-bottom: 0;
        }

        .payment-methods {
            padding: 20px;
        }

        .payment-methods h4 {
            margin-top: 0;
            margin-bottom: 15px;
            font-size: 16px;
        }

        .payment-method {
            display: flex;
            align-items: center;
            padding: 15px;
            border: 1px solid #DEE2E6;
            border-radius: 6px;
            margin-bottom: 10px;
            cursor: pointer;
            transition: border-color 0.2s;
        }

        .payment-method:hover {
            border-color: #007BFF;
        }

        .payment-method.selected {
            border-color: #007BFF;
            background-color: #F0F7FF;
        }

        .payment-method-icon {
            width: 40px;
            height: 40px;
            background-color: #F8F9FA;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            margin-right: 15px;
        }

        .payment-method-icon i {
            font-size: 18px;
            color: #555;
        }

        .payment-method-name {
            font-weight: 600;
            margin-bottom: 4px;
        }

        .payment-method-info {
            color: #6C757D;
            font-size: 13px;
        }

        .payment-action {
            padding: 20px;
            text-align: right;
            border-top: 1px solid #DEE2E6;
        }

        .btn-confirm-payment {
            background-color: #28A745;
            color: white;
            border: none;
            border-radius: 4px;
            padding: 10px 20px;
            cursor: pointer;
            font-size: 16px;
            transition: background-color 0.2s;
        }

        .btn-confirm-payment:hover {
            background-color: #218838;
        }

        /* Pending payments table */
        .pending-payments-table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }

        .pending-payments-table th,
        .pending-payments-table td {
            padding: 15px;
            text-align: left;
            border-bottom: 1px solid #DEE2E6;
        }

        .pending-payments-table th {
            background-color: #F8F9FA;
            font-weight: 600;
            color: #495057;
        }

        .pending-payments-table tbody tr:hover {
            background-color: #F8F9FA;
        }

        /* Responsive adjustments */
        @media (max-width: 992px) {
            .pending-payments-table {
                display: block;
                overflow-x: auto;
            }
        }

        @media (max-width: 576px) {
            .payment-summary {
                padding: 15px;
            }
            
            .modal-content {
                margin: 20% auto;
                width: 95%;
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
            <span>CarRental</span>
        </div>
        
        <div class="header-search">
            <input type="text" placeholder="Search for cars...">
            <button><i class="fas fa-search"></i></button>
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
                <a href="#" class="sidebar-menu-item active">
                    <i class="fas fa-home"></i>
                    <span>Dashboard</span>
                </a>
                
                <a href="#" class="sidebar-menu-item">
                    <i class="fas fa-car"></i>
                    <span>Browse Cars</span>
                </a>
                
                <a href="#" class="sidebar-menu-item">
                    <i class="fas fa-calendar-alt"></i>
                    <span>My Reservations</span>
                </a>
                
                <div class="sidebar-divider"></div>
                
                <div class="sidebar-heading">My Account</div>
                
                <a href="{{ route('customer.profile') }}" class="sidebar-menu-item">
                    <i class="fas fa-user"></i>
                    <span>Profile</span>
                </a>
                
                <a href="#" class="sidebar-menu-item">
                    <i class="fas fa-history"></i>
                    <span>Rental History</span>
                </a>
                
                <a href="#" class="sidebar-menu-item">
                    <i class="fas fa-credit-card"></i>
                    <span>Payment Methods</span>
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
                
                <a href="#" class="sidebar-menu-item">
                    <i class="fas fa-map-marked-alt"></i>
                    <span>Locations</span>
                </a>
                
                <a href="#" class="sidebar-menu-item">
                    <i class="fas fa-shield-alt"></i>
                    <span>Insurance Options</span>
                </a>
                
                <a href="#" class="sidebar-menu-item">
                    <i class="fas fa-gas-pump"></i>
                    <span>Fuel Policy</span>
                </a>
                
                <div class="sidebar-divider"></div>
                
                <div class="sidebar-heading">Help</div>
                
                <a href="#" class="sidebar-menu-item">
                    <i class="fas fa-headset"></i>
                    <span>Support</span>
                </a>
                
                <a href="#" class="sidebar-menu-item">
                    <i class="fas fa-question-circle"></i>
                    <span>FAQ</span>
                </a>
                
                <a href="#" class="sidebar-menu-item">
                    <i class="fas fa-exclamation-circle"></i>
                    <span>Report Issue</span>
                </a>
            </div>
        </div>
        
        <!-- Main Content -->
        <div class="main-content">
            <div class="page-title">
                <h2>Pay Later</h2>
                <p>Manage your deferred payments for car rentals</p>
            </div>
            
            <!-- Pay Later Content -->
            <div class="pay-later-container">
                <h3>Pending Payments</h3>
                
                @if(count($pendingPayments) > 0 && $pendingPayments->isNotEmpty())
                <!-- Initialize totals at the beginning -->
                @php
                $totalPending = 0;
                
                // Pre-calculate all pending payments
                foreach($pendingPayments as $payment) {
                    if($payment->pay_later_status != 'paid') {
                        $totalPending += $payment->amount;
                    }
                }
                @endphp
                
                <!-- Pending Payments Table -->
                <table class="pending-payments-table">
                    <thead>
                        <tr>
                            <th>Car</th>
                            <th>Rental Period</th>
                            <th>Payment Due</th>
                            <th>Amount</th>
                            <th>Status</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($pendingPayments as $payment)
                            @php
                            // Get booking details
                            $booking = DB::table('car_bookings')
                                ->where('id', $payment->booking_id)
                                ->first();
                            
                            // Get car details from car_details_tbl instead of cars
                            $car = DB::table('car_details_tbl')
                                ->where('id', $booking->car_id)
                                ->first();
                            
                            // Calculate status based on rental end date
                            $today = \Carbon\Carbon::now();
                            $rentalEndDate = \Carbon\Carbon::parse($booking->dropoff_datetime);
                            
                            // Set payment due date to be today's date until rental end date
                            $paymentDueDate = $today->lte($rentalEndDate) ? $today : $rentalEndDate;
                            
                            if($payment->pay_later_status == 'paid') {
                                $status = 'paid';
                            } elseif($today->gt($rentalEndDate)) {
                                $status = 'overdue';
                            } elseif($today->diffInDays($rentalEndDate) <= 7) {
                                $status = 'pending';
                            } else {
                                $status = 'upcoming';
                            }
                            @endphp
                            
                            <tr>
                                <td>
                                    <div class="car-info">
                                        <div class="car-thumbnail">
                                        @if($car->car_image)
                                                <img src="{{ asset($car->car_image) }}" alt="Car Image" style="width: 100px; height: auto;">
                                            @else
                                                <p>No image</p>
                                            @endif
                                        </div>
                                        <div>
                                            <div class="car-model">{{ $car->maker ?? 'Unknown' }} {{ $car->model ?? 'Car' }}</div>
                                            <div class="car-details">{{ $car->vehicle_type ?? 'Vehicle' }} • {{ $car->registration_no ?? 'N/A' }} • {{ $booking->id }}</div>
                                        </div>
                                    </div>
                                </td>
                                <td>
                                    {{ \Carbon\Carbon::parse($booking->pickup_datetime)->format('M d') }} - 
                                    {{ \Carbon\Carbon::parse($booking->dropoff_datetime)->format('M d, Y') }}
                                </td>
                                <td>{{ $paymentDueDate->format('M d, Y') }}</td>
                                <td>{{ $payment->currency }} {{ number_format($payment->amount, 2) }}</td>
                                <td>
                                    @if($status == 'overdue')
                                        <span class="badge badge-overdue">Overdue</span>
                                    @elseif($status == 'pending')
                                        <span class="badge badge-pending">Pending</span>
                                    @elseif($status == 'upcoming')
                                        <span class="badge badge-upcoming">Upcoming</span>
                                    @else
                                        <span class="badge badge-paid">Paid</span>
                                    @endif
                                </td>
                                <td>
                                    @if($status != 'paid')
                                        <button class="btn-pay" onclick="openPaymentModal('{{ $car->maker ?? 'Unknown' }} {{ $car->model ?? 'Car' }}', '{{ $booking->id }}', '{{ $payment->amount }}', '{{ $payment->id }}')">Pay Now</button>
                                        <form action="{{ route('customer.cancel-payment', $payment->id) }}" method="POST" onsubmit="return confirm('Are you sure you want to cancel this payment?');">
                                            @csrf
                                            <button type="submit" class="btn btn-danger">Cancel Payment</button>
                                        </form>
                                    
                                        @else
                                        <button class="btn-pay" disabled>Completed</button>
                                    @endif
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
                
                <!-- Payment Summary -->
                <div class="payment-summary">
                    <h4>Payment Summary</h4>
                    <div class="summary-item">
                        <div>Pending Payments:</div>
                        <div>{{ $pendingPayments->first()->currency ?? '$' }} {{ number_format($totalPending, 2) }}</div>
                    </div>
                    <div class="summary-total">
                        <div>Total Amount:</div>
                        <div>{{ $pendingPayments->first()->currency ?? '$' }} {{ number_format($totalPending, 2) }}</div>
                    </div>
                </div>
                @else
                <div class="no-payments">
                    <i class="fas fa-check-circle"></i>
                    <p>You don't have any pending payments at the moment.</p>
                </div>
                @endif
            </div>

            <!-- Payment Modal -->
<div id="paymentModal" class="modal">
    <div class="modal-content">
        <div class="modal-header">
            <h3>Make Payment</h3>
            <span class="modal-close" onclick="closePaymentModal()">&times;</span>
        </div>
        
        <form action="{{ route('customer.paylater.process') }}" method="POST" id="paymentForm" enctype="multipart/form-data">
            @csrf
            <input type="hidden" name="payment_id" id="paymentId">
            <input type="hidden" name="bank_code" id="selected_bank_code">
            <input type="hidden" name="payment_method" id="selectedPaymentMethod" value="qr_code">
            
            <div class="payment-details">
                <div class="payment-detail-item">
                    <div>Car:</div>
                    <div id="modalCarName"></div>
                </div>
                <div class="payment-detail-item">
                    <div>Rental ID:</div>
                    <div id="modalRentalId"></div>
                </div>
                <div class="payment-detail-item">
                    <div>Amount Due:</div>
                    <div id="modalAmount"></div>
                </div>
            </div>
            
            <div class="payment-methods">
                <h4>Select Payment Method</h4>
                
                <!-- Payment Method Options -->
                <div class="payment-method selected" onclick="selectPaymentMethod(this, 'qr_code')">
                    <input type="radio" name="payment_method_radio" value="qr_code" checked style="display: none;">
                    <div class="payment-method-icon">
                        <i class="fas fa-qrcode"></i>
                    </div>
                    <div class="payment-method-details">
                        <div class="payment-method-name">QR Code Payment</div>
                        <div class="payment-method-info">Scan QR with your banking app</div>
                    </div>
                </div>
                
                <div class="payment-method" onclick="selectPaymentMethod(this, 'bank_otp')">
                    <input type="radio" name="payment_method_radio" value="bank_otp" style="display: none;">
                    <div class="payment-method-icon">
                        <i class="fas fa-university"></i>
                    </div>
                    <div class="payment-method-details">
                        <div class="payment-method-name">Bank Transfer with OTP</div>
                        <div class="payment-method-info">Direct bank payment with verification</div>
                    </div>
                </div>
            </div>
            
            <!-- QR Code Payment Section -->
            <div id="qrCodeSection" class="payment-method-section">
                <div class="payment-option-body">
                    <p>Choose your bank below and follow the instructions to complete your payment.</p>
                    
                    <div class="bank-selector">
                        <div class="bank-option" data-bank="bob" onclick="selectBank('bob')">
                            <img src="../assets/images/mbob.png" alt="Bank of Bhutan">
                            <div>BOB</div>
                        </div>
                        <div class="bank-option" data-bank="bnb" onclick="selectBank('bnb')">
                            <img src="../assets/images/bnb.png" alt="Bhutan National Bank">
                            <div>BNB</div>
                        </div>
                        <div class="bank-option" data-bank="tbank" onclick="selectBank('tbank')">
                            <img src="../assets/images/Tbank.jpg" alt="T-Bank">
                            <div>T-Bank</div>
                        </div>
                        <div class="bank-option" data-bank="dpnb" onclick="selectBank('dpnb')">
                            <img src="../assets/images/drukpnb.png" alt="Druk PNB">
                            <div>DPNB</div>
                        </div>
                        <div class="bank-option" data-bank="bdbl" onclick="selectBank('bdbl')">
                            <img src="../assets/images/bdbl.jpg" alt="BDBL">
                            <div>BDBL</div>
                        </div>
                    </div>
                    
                    <!-- Bank Instructions Container -->
                    <div id="bankInstructionsContainer">
                        <!-- Bank instructions will be displayed here -->
                        <!-- BOB Instructions -->
                        <div class="bank-instructions hidden" id="bob-instructions">
                            <h6>Payment Instructions for Bank of Bhutan</h6>
                            <ol>
                                <li>Open your mBOB app</li>
                                <li>Go to Payments > Scan QR</li>
                                <li>Scan the QR code shown here</li>
                                <li>Enter amount as shown above</li>
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
                                <li>Enter amount as shown above</li>
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
                                <li>Enter amount as shown above</li>
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
                                <li>Enter amount as shown above</li>
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
                                <li>Enter amount as shown above</li>
                                <li>Enter your security PIN to complete payment</li>
                                <li>Take a screenshot of the payment confirmation</li>
                                <li>Upload the screenshot below</li>
                            </ol>
                        </div>
                    </div>
                    
                    <div class="qr-code-container hidden" id="qrContainer">
                        <div class="qr-wrapper">
                            <img src="../assets/images/bobQRcode.jpg" alt="QR Code" class="qr-code-image" id="bankQrCode">
                        </div>
                        
                        <div class="qr-details">
                            <p class="name">Car Rental System</p>
                            <p class="amount">Amount: <strong id="qrAmountDisplay"></strong></p>
                        </div>
                        
                        <label class="upload-btn mt-4">
                            <i class="fas fa-upload"></i>
                            <span>Upload Payment Screenshot</span>
                            <input type="file" name="screenshot" id="payment_screenshot" style="display: none;" accept="image/*">
                        </label>
                    </div>
                    
                    <p class="text-center mt-3 text-muted" id="qrPrompt">Please select a bank to display the QR code</p>
                </div>
            </div>
            
            <!-- Bank Transfer with OTP Section -->
            <div id="bankOtpSection" class="payment-method-section hidden">
                <div class="payment-option-body">
                    <div class="mb-3">
                        <label class="form-label">Bank Code</label>
                        <select class="bank-dropdown" name="bank_code_otp">
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
                        <input type="text" name="account_number" class="account-input" placeholder="Enter Account Number">
                    </div>
                                     
                    <div class="text-center mt-4">
                        <button type="button" class="otp-btn" onclick="sendOtp()">Send OTP</button>
                    </div>
                    
                    <div class="mt-4 hidden" id="otpSection">
                        <label class="form-label">Enter OTP</label>
                        <div class="d-flex gap-2 otp-inputs">
                            <input type="text" name="otp[]" maxlength="1" class="form-control text-center">
                            <input type="text" name="otp[]" maxlength="1" class="form-control text-center">
                            <input type="text" name="otp[]" maxlength="1" class="form-control text-center">
                            <input type="text" name="otp[]" maxlength="1" class="form-control text-center">
                            <input type="text" name="otp[]" maxlength="1" class="form-control text-center">
                            <input type="text" name="otp[]" maxlength="1" class="form-control text-center">
                        </div>
                    </div>
                </div>
            </div>
            
            <div class="payment-action">
                <button type="submit" class="btn-confirm-payment">Confirm Payment</button>
            </div>
        </form>
    </div>
</div>

<script>
// Function to open payment modal
function openPaymentModal(carName, rentalId, amount, paymentId) {
    document.getElementById('modalCarName').textContent = carName;
    document.getElementById('modalRentalId').textContent = rentalId;
    document.getElementById('modalAmount').textContent = formatCurrency(amount);
    document.getElementById('qrAmountDisplay').textContent = 'Nu. ' + formatCurrency(amount);
    document.getElementById('paymentId').value = paymentId;
    
    document.getElementById('paymentModal').style.display = 'block';
}

// Function to close payment modal
function closePaymentModal() {
    document.getElementById('paymentModal').style.display = 'none';
    resetPaymentForm();
}

// Function to format currency
function formatCurrency(amount) {
    return parseFloat(amount).toFixed(2).replace(/\d(?=(\d{3})+\.)/g, '$&,');
}

// Function to select payment method
function selectPaymentMethod(element, methodType) {
    // Remove selected class from all payment methods
    document.querySelectorAll('.payment-method').forEach(function(el) {
        el.classList.remove('selected');
    });
    
    // Add selected class to clicked element
    element.classList.add('selected');
    
    // Update hidden input value
    document.getElementById('selectedPaymentMethod').value = methodType;
    
    // Show/Hide corresponding payment sections
    if (methodType === 'qr_code') {
        document.getElementById('qrCodeSection').classList.remove('hidden');
        document.getElementById('bankOtpSection').classList.add('hidden');
    } else if (methodType === 'bank_otp') {
        document.getElementById('qrCodeSection').classList.add('hidden');
        document.getElementById('bankOtpSection').classList.remove('hidden');
    }
}

// Function to select bank for QR code payment
function selectBank(bankCode) {
    // Remove selected class from all bank options
    document.querySelectorAll('.bank-option').forEach(function(el) {
        el.classList.remove('selected');
    });
    
    // Add selected class to clicked bank option
    document.querySelector('.bank-option[data-bank="' + bankCode + '"]').classList.add('selected');
    
    // Update hidden input value
    document.getElementById('selected_bank_code').value = bankCode;
    
    // Hide all bank instructions
    document.querySelectorAll('.bank-instructions').forEach(function(el) {
        el.classList.add('hidden');
    });
    
    // Show instructions for selected bank
    document.getElementById(bankCode + '-instructions').classList.remove('hidden');
    
    // Show QR code container and update QR image
    document.getElementById('qrContainer').classList.remove('hidden');
    document.getElementById('qrPrompt').classList.add('hidden');
    
    // Update QR code image based on selected bank
    document.getElementById('bankQrCode').src = '../assets/images/' + bankCode + 'QRcode.jpg';
}

// Function to send OTP
function sendOtp() {
    const accountInput = document.querySelector('.account-input').value;
    const phoneInput = document.querySelector('.phone-input').value;
    const bankDropdown = document.querySelector('.bank-dropdown').value;
    
    if (!accountInput || !phoneInput || !bankDropdown) {
        alert('Please fill in all fields');
        return;
    }
    
    // Show OTP section
    document.getElementById('otpSection').classList.remove('hidden');
    
    // Focus on first OTP input
    document.querySelector('.otp-inputs input:first-child').focus();
    
    // Disable send OTP button
    document.querySelector('.otp-btn').disabled = true;
    document.querySelector('.otp-btn').textContent = 'OTP Sent';
    
    // In a real app, you would make an AJAX call to send OTP
    // For demo purposes, we're just showing the OTP section
}

// Function to handle OTP input auto-focus
document.addEventListener('DOMContentLoaded', function() {
    const otpInputs = document.querySelectorAll('.otp-inputs input');
    otpInputs.forEach(function(input, index) {
        input.addEventListener('input', function() {
            if (this.value.length === this.maxLength && index < otpInputs.length - 1) {
                otpInputs[index + 1].focus();
            }
        });
        
        input.addEventListener('keydown', function(e) {
            if (e.key === 'Backspace' && !this.value && index > 0) {
                otpInputs[index - 1].focus();
            }
        });
    });
    
    // Handle file input change
    document.getElementById('payment_screenshot').addEventListener('change', function() {
        if (this.files.length > 0) {
            document.querySelector('.upload-btn span').textContent = 'Screenshot Uploaded';
        }
    });
});

// Function to reset payment form
function resetPaymentForm() {
    document.getElementById('paymentForm').reset();
    document.querySelectorAll('.bank-instructions, #qrContainer').forEach(function(el) {
        el.classList.add('hidden');
    });
    document.getElementById('qrPrompt').classList.remove('hidden');
    document.getElementById('otpSection').classList.add('hidden');
    document.querySelector('.upload-btn span').textContent = 'Upload Payment Screenshot';
    
    // Reset payment method selection
    selectPaymentMethod(document.querySelector('.payment-method'), 'qr_code');
}
</script>

<style>
    /* Modal Styles */
    .modal {
        display: none;
        position: fixed;
        z-index: 1000;
        left: 0;
        top: 0;
        width: 100%;
        height: 100%;
        background-color: rgba(0, 0, 0, 0.5);
        overflow: auto;
    }

    .modal-content {
        background-color: #fff;
        margin: 5% auto;
        padding: 0;
        width: 90%;
        max-width: 600px;
        border-radius: 10px;
        box-shadow: 0 5px 15px rgba(0, 0, 0, 0.3);
        animation: modalFadeIn 0.3s;
    }

    .modal-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        padding: 15px 20px;
        background-color: #f8f9fa;
        border-top-left-radius: 10px;
        border-top-right-radius: 10px;
        border-bottom: 1px solid #e9ecef;
    }

    .modal-header h3 {
        margin: 0;
        font-size: 1.25rem;
        color: #333;
    }

    .modal-close {
        font-size: 24px;
        font-weight: bold;
        cursor: pointer;
        color: #aaa;
    }

    .modal-close:hover {
        color: #333;
    }

    .payment-details {
        padding: 20px;
        background-color: #f8f9fa;
        border-bottom: 1px solid #e9ecef;
    }

    .payment-detail-item {
        display: flex;
        justify-content: space-between;
        margin-bottom: 10px;
        font-size: 0.95rem;
    }

    .payment-detail-item:last-child {
        margin-bottom: 0;
        font-weight: bold;
    }

    /* Payment Method Selector */
    .payment-methods {
        padding: 20px;
        border-bottom: 1px solid #e9ecef;
    }

    .payment-methods h4 {
        margin-top: 0;
        margin-bottom: 15px;
        font-size: 1.1rem;
        color: #333;
    }

    .payment-method {
        display: flex;
        align-items: center;
        padding: 12px 15px;
        margin-bottom: 10px;
        border: 1px solid #ddd;
        border-radius: 8px;
        cursor: pointer;
        transition: all 0.2s;
    }

    .payment-method:hover {
        background-color: #f8f9fa;
    }

    .payment-method.selected {
        border-color: #4CAF50;
        background-color: rgba(76, 175, 80, 0.05);
    }

    .payment-method-icon {
        width: 40px;
        height: 40px;
        border-radius: 50%;
        background-color: #f8f9fa;
        display: flex;
        align-items: center;
        justify-content: center;
        margin-right: 15px;
    }

    .payment-method-icon i {
        font-size: 18px;
        color: #555;
    }

    .payment-method-details {
        flex: 1;
    }

    .payment-method-name {
        font-weight: bold;
        color: #333;
        margin-bottom: 3px;
    }

    .payment-method-info {
        font-size: 0.85rem;
        color: #777;
    }

    /* Payment Method Section */
    .payment-method-section {
        padding: 20px;
        border-bottom: 1px solid #e9ecef;
    }

    .payment-method-section.hidden {
        display: none;
    }

    /* Bank Selector */
    .bank-selector {
        display: flex;
        flex-wrap: wrap;
        gap: 10px;
        margin-bottom: 20px;
    }

    .bank-option {
        width: calc(20% - 10px);
        text-align: center;
        padding: 10px;
        border: 1px solid #ddd;
        border-radius: 8px;
        cursor: pointer;
        transition: all 0.2s;
    }

    .bank-option img {
        width: 60px;
        height: 45px;
        object-fit: contain;
        margin-bottom: 5px;
    }

    .bank-option.selected {
        border-color: #4CAF50;
        background-color: rgba(76, 175, 80, 0.05);
    }

    /* QR Code Container */
    .qr-code-container {
        display: flex;
        flex-direction: column;
        align-items: center;
        padding: 20px 0;
    }

    .qr-wrapper {
        width: 200px;
        height: 200px;
        padding: 10px;
        border: 1px solid #ddd;
        border-radius: 8px;
        background-color: white;
        margin-bottom: 15px;
    }

    .qr-code-image {
        width: 100%;
        height: 100%;
        object-fit: contain;
    }

    .qr-details {
        text-align: center;
        margin-bottom: 15px;
    }

    .qr-details .name {
        font-weight: bold;
        margin-bottom: 5px;
    }

    .qr-details .amount {
        color: #333;
    }

    /* Bank Instructions */
    .bank-instructions {
        margin: 20px 0;
        padding: 15px;
        background-color: #f8f9fa;
        border-radius: 8px;
        border-left: 4px solid #4CAF50;
    }

    .bank-instructions h6 {
        margin-top: 0;
        margin-bottom: 10px;
        color: #333;
    }

    .bank-instructions ol {
        padding-left: 20px;
        margin-bottom: 0;
    }

    .bank-instructions li {
        margin-bottom: 5px;
    }

    .bank-instructions li:last-child {
        margin-bottom: 0;
    }

    /* Form Elements */
    .form-label {
        display: block;
        margin-bottom: 5px;
        font-weight: 500;
        color: #333;
    }

    .bank-dropdown,
    .account-input,
    .phone-input {
        width: 100%;
        padding: 10px 12px;
        border: 1px solid #ced4da;
        border-radius: 6px;
        font-size: 0.95rem;
        margin-bottom: 10px;
    }

    .otp-inputs {
        display: flex;
        gap: 10px;
        justify-content: center;
    }

    .otp-inputs input {
        width: 45px;
        height: 45px;
        text-align: center;
        font-size: 1.2rem;
        border: 1px solid #ced4da;
        border-radius: 6px;
    }

    /* Buttons */
    .upload-btn {
        display: inline-flex;
        align-items: center;
        gap: 8px;
        background-color: #f8f9fa;
        border: 1px dashed #ced4da;
        padding: 10px 15px;
        border-radius: 6px;
        cursor: pointer;
        transition: all 0.2s;
    }

    .upload-btn:hover {
        background-color: #e9ecef;
    }

    .otp-btn {
        padding: 8px 20px;
        background-color: #6c757d;
        color: white;
        border: none;
        border-radius: 6px;
        cursor: pointer;
        transition: all 0.2s;
    }

    .otp-btn:hover {
        background-color: #5a6268;
    }

    .otp-btn:disabled {
        background-color: #adb5bd;
        cursor: not-allowed;
    }

    .payment-action {
        padding: 20px;
        text-align: center;
    }

    .btn-confirm-payment {
        padding: 12px 30px;
        background-color: #4CAF50;
        color: white;
        border: none;
        border-radius: 6px;
        font-size: 1rem;
        font-weight: 500;
        cursor: pointer;
        transition: all 0.2s;
    }

    .btn-confirm-payment:hover {
        background-color: #45a049;
    }

    .hidden {
        display: none;
    }
    
    .btn-cancel-payment {
        background-color: #f44336;
        color: white;
        border: none;
        flex: 1;
        margin-left: 10px;
    }

    .btn-confirm-payment:hover {
        background-color: #45a049;
    }

    .btn-cancel-payment:hover {
        background-color: #d32f2f;
    }

    /* Animation */
    @keyframes modalFadeIn {
        from {opacity: 0; transform: translateY(-20px);}
        to {opacity: 1; transform: translateY(0);}
    }

    /* Responsive Adjustments */
    @media (max-width: 768px) {
        .bank-option {
            width: calc(33.333% - 10px);
        }
        
        .modal-content {
            width: 95%;
            margin: 5% auto;
        }
    }

    @media (max-width: 576px) {
        .bank-option {
            width: calc(50% - 5px);
        }
        
        .otp-inputs input {
            width: 35px;
            height: 35px;
        }
    }
</style>