<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CarOwnerController;
use Illuminate\Support\Facades\Mail;
use App\Http\Controllers\CarOwner\AuthController;

Route::get('/', function () {
    return view('home');

});

// login and register 
    Route::get('/car-owner', [AuthController::class, 'showLogin'])->name('carowner.login');
    Route::get('/car-owner/register', [AuthController::class, 'showRegister'])->name('carowner.register');
    Route::post('/car-owner/login', [AuthController::class, 'login'])->name('carowner.login.submit');
    Route::post('/car-owner/register', [AuthController::class, 'register'])->name('carowner.register.submit');
    Route::get('/car-owner/dashboard', [AuthController::class, 'dashboard'])->middleware('auth')->name('carowner.dashboard');
    Route::post('/car-owner/logout', [AuthController::class, 'logout'])->name('carowner.logout');

    //  Reset Password Route
    Auth::routes(['reset' => true]);

    //  registerSubmit
    Route::post('/carowner/register', [CarOwnerController::class, 'registerSubmit'])->name('carowner.register.submit');

// this is for the laravel loign and register  
// Auth::routes();
// Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
