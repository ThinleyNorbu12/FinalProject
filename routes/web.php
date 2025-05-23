<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CarOwnerController;
use Illuminate\Support\Facades\Mail;
use App\Http\Controllers\CarOwner\AuthController;
use App\Http\Controllers\VerificationController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\BookingController;
use App\Http\Controllers\PaymentController;
// homecontroller
// home.blade.php
Route::get('/', function () {
    return view('home');

});

// Route for displaying car details page
Route::get('/cars/{id}/details', [HomeController::class, 'getCarDetails'])->name('car.details');

// Route to search for cars
Route::get('/search-car', [HomeController::class, 'searchCar'])->name('search.car');

// Route to set the pickup and dropoff dates in search results page
Route::post('/set-dates', [HomeController::class, 'setDates'])->name('set.dates');

// Route to display available cars in search results
Route::get('/available-cars', [HomeController::class, 'showAvailableCars'])->name('available.cars');

// Route for booking form display
Route::get('/cars/{id}/book', [HomeController::class, 'book'])->name('book.car');

// Route to handle the booking form submission (for both logged-in and non-logged-in users)
Route::post('/car/{id}/book', [BookingController::class, 'submit'])
    ->name('car.booking.submit');

// Route for booking summary page (protected by middleware)
// Route for booking summary page (protected by middleware)
// Route::get('/booking/summary/{bookingId}', [BookingController::class, 'summary'])
//     ->name('booking.summary')
//     ->middleware('auth:customer');
// After (corrected)
Route::get('/booking/summary/{bookingId}', [BookingController::class, 'summary'])
    ->name('booking.summary')
    ->middleware('auth:customer');

// Route to show the payment form (payment page)
// Route::get('/payment/{bookingId}', [PaymentController::class, 'show'])->name('payment.page');
// Route to process the payment (POST request)
// routes/web.php

Route::get('/payment/{bookingId}', [PaymentController::class, 'show'])
    ->name('payment.page')
    ->middleware(['auth:customer', \App\Http\Middleware\CheckDrivingLicense::class]);

Route::post('/payment/{bookingId}', [PaymentController::class, 'process'])->name('payment.process');

// Payment routes
// Route::get('/booking/{bookingId}/payment', [PaymentController::class, 'show'])->name('booking.payment');
// Route::post('/booking/{bookingId}/payment/process', [PaymentController::class, 'process'])->name('booking.payment.process');
Route::get('/booking/{bookingId}/payment', [PaymentController::class, 'showPaymentPage'])->name('booking.payment.page');
Route::post('/booking/{bookingId}/payment/qr', [PaymentController::class, 'processQrPayment'])->name('booking.payment.qr');
Route::post('/booking/{bookingId}/payment/pay-later', [PaymentController::class, 'processPayLater'])->name('booking.payment.payLater');

Route::post('/admin/payments/pay-later/{paymentId}/collect', [PaymentController::class, 'markPayLaterAsCollected'])
    ->name('admin.payments.pay-later.collect');

    // car owner page
// to display all the register car of carowner
Route::get('/', [HomeController::class, 'index'])->name('home');

// Car Owner Registration Routes
Route::get('/carowner/register', [CarOwnerController::class, 'showRegisterForm'])->name('carowner.register');
Route::post('/carowner/register', [CarOwnerController::class, 'register'])->name('carowner.register.submit');

// Car Owner Login Routes
Route::get('/carowner/login', [AuthController::class, 'showLoginForm'])->name('carowner.login');
Route::post('/carowner/login', [AuthController::class, 'login'])->name('carowner.login.submit');

// Dashboard (Protected - Only accessible if logged in)
Route::get('/carowner/dashboard', [CarOwnerController::class, 'dashboard'])
    ->middleware('auth:carowner') // Ensure this is set to 'auth:carowner'
    ->name('carowner.dashboard');

// Car Owner Logout
Route::post('/carowner/logout', [CarOwnerController::class, 'logout'])->name('carowner.logout');


// Route for verifying the email
Route::get('verify-email/{token}', [VerificationController::class, 'verify'])->name('carowner.verify');

// Route for showing the password setup form
Route::get('set-password/{token}', [VerificationController::class, 'showPasswordForm'])->name('carowner.setPassword');

// Route for handling the password setup
Route::post('set-password/{token}', [VerificationController::class, 'setPassword'])->name('carowner.setPassword.post');

// 
Route::get('/carowner/set-password/{token}', [CarOwnerController::class, 'showSetPasswordForm'])
    ->name('carowner.set-password');

Route::post('/carowner/set-password/{token}', [CarOwnerController::class, 'setPassword'])
    ->name('carowner.set-password.submit');


// Password Reset Routes (if needed)
Auth::routes(['reset' => true]);


//  reset and forgot password
use App\Http\Controllers\Auth\ForgotPasswordController;
use App\Http\Controllers\Auth\ResetPasswordController;

Route::get('password/reset', [ForgotPasswordController::class, 'showLinkRequestForm'])->name('carowner.password.request');
Route::post('password/email', [ForgotPasswordController::class, 'sendResetLinkEmail'])->name('carowner.password.email');
Route::get('password/reset/{token}', [ResetPasswordController::class, 'showResetForm'])->name('carowner.password.reset');
Route::post('password/reset', [ResetPasswordController::class, 'reset'])->name('carowner.password.update');


// Route::get('/carowner/dashboard', function () {
//     return view('CarOwner.dashboard');
// })->name('carowner.dashboard');



Route::middleware('auth:carowner')->group(function () {
    // Rent Car page (form)
    Route::get('CarOwner/rent-car', [CarOwnerController::class, 'showRentCarForm'])->name('carowner.rentCar');
    
    // Post request to store car details
    Route::post('CarOwner/rent-car', [CarOwnerController::class, 'storeRentCar'])->name('carowner.storeRentCar');
});


// 2.view rented cars
Route::get('carowner/view-rented-car', [CarOwnerController::class, 'viewRentedCar'])
    ->middleware('auth:carowner')
    ->name('carowner.view.rented');
// resources/views/CarOwner/inspection-messages.blade.php
Route::get('carowner/car-inspection', [CarOwnerController::class, 'showInspectionMessages'])->name('carowner.car-inspection');

//  route for canceling the inspection request from admin
Route::post('/inspection-request/{id}/cancel', [CarOwnerController::class, 'cancel'])->name('inspection.cancel');

// Edit Inspection Date & Time
Route::get('/inspection-request/{id}/edit-datetime', [CarOwnerController::class, 'editDateTime'])->name('inspection.editdatetime');
//  Update Inspection Date & Time
Route::post('/inspection-request/{id}/update-datetime', [CarOwnerController::class, 'updateDateTime'])->name('inspection.updatedatetime');
//  Get Available Time Slots (AJAX)
Route::get('/inspection/available-slots', [CarOwnerController::class, 'getAvailableTimeSlots'])->name('inspection.available-slots');
// this will redirect to this page redirect-inpection-messagepage.blade
Route::get('/carowner/inspection-messages', [CarOwnerController::class, 'showInspectionMessages'])->name('CarOwner.inspection-messages');
// when caronwer is ok with the date and time that are set by the admin under carowner/inspection-messages.php
Route::post('/inspection/accept/{id}', [CarOwnerController::class, 'accept'])->name('inspection.accept');
// link to aproved car 
Route::get('carowner/approved-car', [CarOwnerController::class, 'showApprovedCars'])
    ->middleware('auth:carowner')
    ->name('carowner.approved');
// this is for car-approval-denied
    Route::get('carowner/car-approval-denied', [CarOwnerController::class, 'showRejectedCars'])
    ->middleware('auth:carowner')
    ->name('carowner.rejected');




// admin 
use App\Http\Controllers\Admin\Auth\AdminLoginController;
use App\Http\Controllers\Admin\Auth\AdminRegisterController;
use App\Http\Controllers\CarAdminController;
use App\Http\Controllers\UserVerificationController;
// Admin Routes
Route::prefix('admin')->name('admin.')->group(function () {

    // Admin Login Routes
    Route::get('login', [AdminLoginController::class, 'showLoginForm'])->name('login');
    Route::post('login', [AdminLoginController::class, 'login']);

    // Admin Register & Set Password Routes
    Route::get('register', [AdminRegisterController::class, 'showRegisterForm'])->name('register');
    Route::post('register', [AdminRegisterController::class, 'register']);
    Route::get('set-password/{token}', [AdminRegisterController::class, 'showSetPasswordForm'])->name('set-password');
    Route::post('set-password/{token}', [AdminRegisterController::class, 'setPassword'])->name('set-password.submit');

    // Admin Dashboard (Protected by Admin Middleware)
    Route::get('dashboard', function () {
        return view('admin.auth.dashboard');
    })->middleware('auth:admin')->name('dashboard');
    
    // Optional Admin Logout Route
    Route::post('logout', function () {
        Auth::guard('admin')->logout();
        return redirect()->route('admin.login');
    })->name('logout');
});

    // Newly Registered Cars Route
    Route::prefix('car-admin')->name('car-admin.')->middleware('auth:admin')->group(function () {
    Route::get('new-registration-cars', [CarAdminController::class, 'showRegisteredCars'])->name('new-registration-cars');

    // Route for viewing a specific car's details (if needed)
    Route::get('view-car/{id}', [CarAdminController::class, 'viewCar'])->name('view-car');

    // Route definition for Request for Inspection in CarAdminController

     Route::get('request-inspection/{car}', [CarAdminController::class, 'requestInspection'])->name('admin.requestInspection');
     // Optional: form submit handler
     Route::post('submit-inspection-request/{car}', [CarAdminController::class, 'submitInspectionRequest'])->name('admin.submitInspectionRequest');

     // Route for rejecting cars
     Route::get('reject-car/{car}', [CarAdminController::class, 'showRejectForm'])->name('showRejectForm');
     Route::post('reject-car/{car}', [CarAdminController::class, 'rejectCar'])->name('rejectCar');

    // route for set the date and time in request-inspection blade
    Route::get('/get-available-times', [CarAdminController::class, 'getAvailableTimes'])->name('getAvailableTimes');

   // ✅ Corrected route for inspection requests
   Route::get('/', [CarAdminController::class, 'showInspectionRequests'])->name('inspection-requests');

    //    "Ok" and "Send Mail"  under the Admin/menage-inspection-requests.blade
    // For confirming date and time (Ok button)
    Route::post('confirm-inspection/{id}', [CarAdminController::class, 'confirm'])->name('inspection.confirm');

    // For sending custom mail (Send Mail button)
    Route::post('send-inspection-mail/{id}', [CarAdminController::class, 'sendMail'])->name('inspection.sendMail');

    // this is under >APPROVE/REJECT INSPECTED CARS<
    // Display the approval page (GET)
    Route::get('/approve-inspected-cars', [CarAdminController::class, 'showInspectionApprovals'])->name('approve-inspected-cars');

    // Handle the approval or rejection form (POST)
    Route::post('/approve-inspected-cars', [CarAdminController::class, 'processInspectionApproval'])->name('inspection-approval');


});

// Customer profile routes
Route::middleware(['auth:customer'])->group(function () {
    Route::put('/profile/update', [CustomerProfileController::class, 'update'])
        ->name('customer.profile.update');
    
    Route::post('/profile/save-license', [CustomerProfileController::class, 'saveLicense'])
        ->name('customer.profile.save-license');
});

// Admin verification routes
// Route::middleware(['auth:admin'])->prefix('admin')->name('admin.')->group(function () {
//     // Verify users route
//     Route::get('/verify-users', [App\Http\Controllers\UserVerificationController::class, 'index'])
//         ->name('verify-users');
    
//     // Show user verification details
//     Route::get('/user-verification/{id}', [App\Http\Controllers\UserVerificationController::class, 'show'])
//         ->name('user-verification.show');
    
//     // Update user verification status
//     Route::put('/user-verification/{id}/update-status', [App\Http\Controllers\UserVerificationController::class, 'updateStatus'])
//         ->name('user-verification.update-status');
    
//     // API endpoint to get pending verification count for notifications
//     Route::get('/api/pending-verification-count', [App\Http\Controllers\UserVerificationController::class, 'getPendingVerificationCount'])
//         ->name('api.pending-verification-count');
// });
Route::middleware(['auth:admin'])->prefix('admin')->name('admin.')->group(function () {
    // ... other admin routes ...
    
    // User verification routes
    Route::get('/verify-users', [App\Http\Controllers\UserVerificationController::class, 'index'])
        ->name('verify-users');
    
    // User verification detail routes
    Route::get('/user-verification/{id}', [App\Http\Controllers\UserVerificationController::class, 'show'])
        ->name('user-verification.show');
    
    Route::put('/user-verification/{id}', [App\Http\Controllers\UserVerificationController::class, 'updateStatus'])
        ->name('user-verification.update');
});

// Admin Routes
Route::middleware(['auth:admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/booked-car', [BookingController::class, 'index'])->name('booked-car');
    Route::get('/booked-car/filter', [BookingController::class, 'filter'])->name('booked-car.filter');
    Route::get('/booked-car/{id}', [BookingController::class, 'showBookingDetails'])->name('booked-car.show');
    Route::put('/booked-car/{id}/update-status', [BookingController::class, 'updateStatus'])->name('booked-car.update-status');


    Route::get('/view-payments', [PaymentController::class, 'index'])->name('payments.index');
    // Show payment details
    Route::get('/payments/{id}', [PaymentController::class, 'showPayment'])->name('payments.show');
    // Update payment status
    Route::post('/payments/{id}/update-status', [PaymentController::class, 'updateStatus'])->name('payments.update-status');
    // Verify QR Payment
    Route::post('payments/{payment}/verify-qr', [PaymentController::class, 'verifyQrPayment'])->name('payments.verify-qr');
    
    // Collect Pay Later Payment
    Route::post('/payments/{id}/collect-pay-later', [PaymentController::class, 'collectPayLater'])->name('payments.collect-pay-later');
    // Verify Bank Transfer
    Route::post('payments/{payment}/verify-bank-transfer', [PaymentController::class, 'verifyBankTransfer'])->name('payments.verify-bank-transfer');

});

use App\Http\Controllers\CarController;
// add new cars by admin 
Route::middleware(['auth:admin'])->group(function () {
    // Main cars listing and management page
    Route::get('/admin/cars', [CarController::class, 'index'])->name('cars.index');
    
    // Create new car
    Route::get('/admin/cars/create', [CarController::class, 'create'])->name('cars.create');
    Route::post('/admin/cars', [CarController::class, 'store'])->name('cars.store');
    
    // Show car details
    Route::get('/admin/cars/{id}', [CarController::class, 'show'])->name('cars.show');
    
    // Edit car
    Route::get('/admin/cars/{id}/edit', [CarController::class, 'edit'])->name('cars.edit');
    Route::put('/admin/cars/{id}', [CarController::class, 'update'])->name('cars.update');
    
    // Delete car
    Route::delete('/admin/cars', [CarController::class, 'destroy'])->name('cars.destroy');
    
    // Ajax routes for car management
    Route::get('/admin/get-car-details', [CarController::class, 'getCarDetails'])->name('cars.getDetails');
    // Add this route to your routes/web.php
   Route::post('/admin/cars/delete-image', [CarController::class, 'deleteImage'])->name('cars.delete-image');
});


// profile
Route::middleware(['auth:admin'])->prefix('admin')->name('admin.')->group(function () {
    
    // Profile Routes
    Route::get('/profile', [CarAdminController::class, 'profile'])->name('profile');
    Route::put('/profile/update', [CarAdminController::class, 'updateProfile'])->name('profile.update');
    Route::post('/profile/picture', [CarAdminController::class, 'updateProfilePicture'])->name('profile.picture');
    Route::put('/password/update', [CarAdminController::class, 'updatePassword'])->name('password.update');
    
    // Optional: API endpoint for profile data
    Route::get('/profile/data', [CarAdminController::class, 'getProfileData'])->name('profile.data');
    
});





// customer web.php



use App\Http\Controllers\CustomerController;
use App\Http\Controllers\Customer\Auth\LoginController;
use App\Http\Controllers\Customer\Auth\RegisterController;
use App\Http\Controllers\Customer\Auth\ForgotPasswordController as CustomerForgotPasswordController;
use App\Http\Controllers\Customer\Auth\ResetPasswordController as CustomerResetPasswordController;
use App\Http\Controllers\CustomerProfileController;

// Customer dashboard (protected route)
Route::middleware('auth:customer')->get('/customer', [CustomerController::class, 'dashboard'])->name('customer.dashboard');

// Group all customer-related routes
Route::prefix('customer')->name('customer.')->group(function () {

    // Login routes
    Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
    Route::post('/login', [LoginController::class, 'login'])->name('login.submit');
    Route::post('/logout', [LoginController::class, 'logout'])->name('logout');

    // Register routes
    Route::get('/register', [RegisterController::class, 'showRegisterForm'])->name('register');
    Route::post('/register', [RegisterController::class, 'register'])->name('register.submit');

    // Password Reset routes
    Route::get('/password/reset', [CustomerForgotPasswordController::class, 'showLinkRequestForm'])->name('password.request');
    Route::post('/password/email', [CustomerForgotPasswordController::class, 'sendResetLinkEmail'])->name('password.email');
    Route::get('/password/reset/{token}', [CustomerResetPasswordController::class, 'showResetForm'])->name('password.reset');
    Route::post('/password/reset', [CustomerResetPasswordController::class, 'reset'])->name('password.update');

    // to set the password
    // To set the password (for new users)
    Route::get('password/set/{token}', [CustomerController::class, 'showSetPasswordForm'])->name('password.set');
    Route::post('password/set', [CustomerController::class, 'setPassword'])->name('password.save');

    // Profile route
    // Route::middleware('auth:customer')->get('/profile', [CustomerProfileController::class, 'profile'])->name('profile');
   
    // // Update profile route (PUT method)
    // Route::middleware('auth:customer')->put('/profile/update', [CustomerProfileController::class, 'update'])->name('profile.update');
    // // to save the Driving License Information 
    // Route::post('/profile/save-license', [CustomerProfileController::class, 'saveLicense'])->name('profile.save-license');
    // Profile routes
    Route::middleware('auth:customer')->group(function () {
        Route::get('/profile', [CustomerProfileController::class, 'profile'])->name('profile');
        Route::put('/profile/update', [CustomerProfileController::class, 'update'])->name('profile.update');
        Route::post('/profile/save-license', [CustomerProfileController::class, 'saveLicense'])->name('profile.save-license');
        Route::post('/profile/update-avatar', [CustomerProfileController::class, 'updateAvatar'])->name('profile.update-avatar');

        // Driving License route
        Route::get('/license', [App\Http\Controllers\CustomerProfileController::class, 'showLicenseForm'])->name('license');
    });

    // redirect to pay later page
    Route::get('/pay-later', [CustomerController::class, 'payLater'])->name('paylater');
    // process to payment
    Route::post('/paylater/process', [CustomerController::class, 'processPayment'])->name('paylater.process');
    //    cancel the payment 
    Route::post('/cancel-payment/{paymentId}', [CustomerController::class, 'cancelPayment'])->name('cancel-payment');


   
        // Add this new route for browsing cars
    Route::get('/browse-cars', [CustomerController::class, 'browseCars'])->name('browse-cars');
    // need to change this two route
    Route::get('/car-details/{id}', [CustomerController::class, 'carDetails'])->name('car-details');
    Route::get('/book-car/{id}', [CustomerController::class, 'bookCar'])->name('book-car');

    // rental history
    Route::get('/customer/rental-history', [CustomerController::class, 'rentalHistory'])->name('rental-history');
     // Payment History Route
    Route::get('/customer/payment-history', [CustomerController::class, 'paymentHistory'])->name('payment-history');

    Route::get('/customer/my-reservations', [CustomerController::class, 'myReservations'])->name('my-reservations');
    // For viewing reservation details
    Route::get('/customer/reservation-details/{id}', [CustomerController::class, 'reservationDetails'])->name('reservation-details');
    // For cancelling a reservation (POST method since it modifies data)
    Route::post('/customer/cancel-reservation/{id}', [CustomerController::class, 'cancelReservation'])->name('cancel-reservation');

    Route::get('/locations', [CustomerController::class, 'locations'])->name('locations');

    // Contact form submission route
    Route::post('/contact-submit', [CustomerController::class, 'contactSubmit'])->name('contact-submit');
    Route::get('/customer/fuel-policy', [CustomerController::class, 'fuelPolicy'])->name('fuel-policy');
    Route::get('/customer/insurance-options', [CustomerController::class, 'insuranceOptions'])->name('insurance-options');



});

