<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CarOwnerController;
use Illuminate\Support\Facades\Mail;
use App\Http\Controllers\CarOwner\AuthController;
use App\Http\Controllers\VerificationController;
use App\Http\Controllers\HomeController;
Route::get('/', function () {
    return view('home');

});
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






// admin 
use App\Http\Controllers\Admin\Auth\AdminLoginController;
use App\Http\Controllers\Admin\Auth\AdminRegisterController;
use App\Http\Controllers\CarAdminController;
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




});
