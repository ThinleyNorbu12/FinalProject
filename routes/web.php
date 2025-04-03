<?php

use Illuminate\Support\Facades\Route;
// use App\Http\Controllers\CarOwnerController;
use Illuminate\Support\Facades\Mail;

Route::get('/', function () {
    return view('home');

// Create a Registration Form
Route::get('/car_owner_register', [CarOwnerController::class, 'showRegisterForm'])->name('car_owner_register');
Route::get('/car-owner/set-password', [CarOwnerController::class, 'showSetPassword']);


//  Create Password Setup Route
Route::get('/set-password', function (Request $request) {
    return view('set_password', ['token' => $request->query('token')]);
});
Route::post('/set-password', [CarOwnerController::class, 'setPassword']);


// Steps to Test Email in Laravel
Route::get('/test-email', function () {
    Mail::raw('Testing email', function($message) {
        $message->to('11514004750@rim.edu.bt')  // Change to your email address
                ->subject('Test Email from Laravel');
    });
    return 'Email sent!';
});

});
