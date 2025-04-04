<?php

namespace App\Http\Controllers\CarOwner;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function showLogin()
    {
        return view('CarOwner.login');
    }

    public function showRegister()
    {
        return view('CarOwner.register');
    }

    public function login(Request $request)
    {
        $credentials = $request->only('email', 'password');

        if (Auth::attempt($credentials)) {
            return redirect('/car-owner/dashboard');
        }

        return back()->with('error', 'Invalid credentials');
    }

    public function register(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:100',
            'email' => 'required|email|unique:users',
            'password' => 'required|confirmed|min:6'
        ]);

        User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password)
        ]);

        return redirect()->route('carowner.login')->with('success', 'Account created. Please log in.');
    }

    public function dashboard()
    {
        return view('CarOwner.dashboard');
    }

    public function logout()
    {
        Auth::logout();
        return redirect()->route('carowner.login');
    }
}

