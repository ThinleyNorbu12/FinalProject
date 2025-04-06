<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CarOwnerController;
use Illuminate\Support\Facades\Mail;
use App\Http\Controllers\CarOwner\AuthController;

Route::get('/', function () {
    return view('home');

});


// go to the Car owner dashboard owner have to register and login
Route::get('/carowner/register', [CarOwnerController::class, 'showRegisterForm'])->name('carowner.register');
Route::post('/carowner/register', [CarOwnerController::class, 'register'])->name('carowner.register.submit');
Route::get('/carowner/login', [CarOwnerController::class, 'showLoginForm'])->name('carowner.login');
Route::post('/carowner/login', [CarOwnerController::class, 'login'])->name('carowner.login.submit');
Route::get('/carowner/dashboard', [CarOwnerController::class, 'dashboard'])->name('carowner.dashboard')->middleware('carowner.auth');
Route::post('/carowner/logout', [CarOwnerController::class, 'logout'])->name('carowner.logout');
Route::get('/carowner/verify/{token}', [CarOwnerController::class, 'verify'])->name('carowner.verify');
    //  Reset Password Route
    Auth::routes(['reset' => true]);

    //  register the car owner
Route::post('/carowner/register', [CarOwnerController::class, 'register'])->name('carowner.register');

// this is for the laravel loign and register  
// Auth::routes();
// Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
// Car Owner routes
// Route::prefix('carowner')->name('carowner.')->group(function () {
//     // Public routes
//     Route::get('/register', [CarOwnerController::class, 'showRegisterForm'])->name('register');
//     Route::post('/register', [CarOwnerController::class, 'register'])->name('register.submit');
//     Route::get('/login', [CarOwnerController::class, 'showLoginForm'])->name('login');
//     Route::post('/login', [CarOwnerController::class, 'login'])->name('login.submit');
//     Route::get('/verify/{token}', [CarOwnerController::class, 'verify'])->name('verify');
//     Route::post('/set-password', [CarOwnerController::class, 'setPassword'])->name('set.password');
    
//     // Protected routes
//     Route::middleware('carowner.auth')->group(function () {
//         Route::get('/dashboard', [CarOwnerController::class, 'dashboard'])->name('dashboard');
//         Route::post('/logout', [CarOwnerController::class, 'logout'])->name('logout');
//     });
// });

// // Laravel Auth routes for password reset
// Auth::routes(['reset' => true]);