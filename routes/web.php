<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CarOwnerController;
use Illuminate\Support\Facades\Mail;
use App\Http\Controllers\CarOwner\AuthController;  // Aliased
use App\Http\Controllers\VerificationController;
use App\Http\Controllers\HomeController;



// under this all are for car owner 
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


Route::get('/carowner/dashboard', function () {
    return view('CarOwner.dashboard');
})->name('carowner.dashboard');



Route::middleware('auth:carowner')->group(function () {
    // Rent Car page (form)
    Route::get('CarOwner/rent-car', [CarOwnerController::class, 'showRentCarForm'])->name('carowner.rentCar');
    
    // Post request to store car details
    Route::post('CarOwner/rent-car', [CarOwnerController::class, 'storeRentCar'])->name('carowner.storeRentCar');
});

