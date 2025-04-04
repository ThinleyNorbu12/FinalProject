<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CarOwnerController;
use Illuminate\Support\Facades\Mail;
use App\Http\Controllers\CarOwner\AuthController;

Route::get('/', function () {
    return view('home');

});

// login and register 
    // Route::get('/car-owner', [AuthController::class, 'showLogin'])->name('carowner.login');
    // Route::get('/car-owner/register', [AuthController::class, 'showRegister'])->name('carowner.register');
    // Route::post('/car-owner/login', [AuthController::class, 'login'])->name('carowner.login.submit');
    // Route::post('/car-owner/register', [AuthController::class, 'register'])->name('carowner.register.submit');
    // Route::get('/car-owner/dashboard', [AuthController::class, 'dashboard'])->middleware('auth')->name('carowner.dashboard');
    // Route::post('/car-owner/logout', [AuthController::class, 'logout'])->name('carowner.logout');
// Routes file (routes/web.php)
Route::get('/carowner/register', [CarOwnerController::class, 'showRegisterForm'])->name('carowner.register');
Route::post('/carowner/register', [CarOwnerController::class, 'register'])->name('carowner.register.submit');
Route::get('/carowner/login', [CarOwnerController::class, 'showLoginForm'])->name('carowner.login');
Route::post('/carowner/login', [CarOwnerController::class, 'login'])->name('carowner.login.submit');
Route::get('/carowner/dashboard', [CarOwnerController::class, 'dashboard'])->name('carowner.dashboard')->middleware('carowner.auth');
Route::post('/carowner/logout', [CarOwnerController::class, 'logout'])->name('carowner.logout');
Route::get('/carowner/verify/{token}', [CarOwnerController::class, 'verify'])->name('carowner.verify');
    //  Reset Password Route
    Auth::routes(['reset' => true]);

    //  registerSubmit
    Route::post('/carowner/register', [CarOwnerController::class, 'registerSubmit'])->name('carowner.register.submit');

// this is for the laravel loign and register  
// Auth::routes();
// Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
