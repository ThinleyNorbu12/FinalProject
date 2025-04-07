<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CarOwnerController;
use Illuminate\Support\Facades\Mail;
use App\Http\Controllers\CarOwner\AuthController;
use App\Http\Controllers\VerificationController;
Route::get('/', function () {
    return view('home');

});


// // go to the Car owner dashboard owner have to register and login
// Route::get('/carowner/register', [CarOwnerController::class, 'showRegisterForm'])->name('carowner.register');
// // Route::post('/carowner/register', [CarOwnerController::class, 'register'])->name('carowner.register.submit');
// Route::get('/carowner/login', [CarOwnerController::class, 'showLoginForm'])->name('carowner.login');
// // Route::post('/carowner/login', [CarOwnerController::class, 'login'])->name('carowner.login.submit');
// Route::post('/carowner/login', [Authcontroller::class, 'login'])->name('carowner.login.submit');
// Route::get('/carowner/dashboard', [CarOwnerController::class, 'dashboard'])->name('carowner.dashboard')->middleware('carowner.auth');
// Route::post('/carowner/logout', [CarOwnerController::class, 'logout'])->name('carowner.logout');
// Route::get('/carowner/verify/{token}', [CarOwnerController::class, 'verify'])->name('carowner.verify');
// //  register the car owner
//  Route::post('/carowner/register', [CarOwnerController::class, 'register'])->name('carowner.register');

// //  Reset Password Route
//     Auth::routes(['reset' => true]);


// Car Owner Registration Routes
Route::get('/carowner/register', [CarOwnerController::class, 'showRegisterForm'])->name('carowner.register');
Route::post('/carowner/register', [CarOwnerController::class, 'register'])->name('carowner.register.submit');

// Car Owner Login Routes
Route::get('/carowner/login', [AuthController::class, 'showLoginForm'])->name('carowner.login');
Route::post('/carowner/login', [AuthController::class, 'login'])->name('carowner.login.submit');

// Dashboard (Protected - Only accessible if logged in)
Route::get('/carowner/dashboard', [CarOwnerController::class, 'dashboard'])
    ->name('carowner.dashboard')
    ->middleware('carowner.auth');

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
