<?php

namespace App\Http\Controllers\Admin\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Admin;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;
use App\Mail\AdminSetPasswordMail;

class AdminRegisterController extends Controller
{
    public function showRegisterForm()
    {
        return view('admin.auth.register');
    }

    public function register(Request $request)
    {
        $request->validate([
            'name'  => 'required|string|max:255',
            'email' => 'required|email|unique:admins,email',
        ]);

        $admin = Admin::create([
            'name' => $request->name,
            'email' => $request->email,
            // Password will be set later
        ]);

        $token = Str::random(64);

        DB::table('admin_password_resets')->insert([
            'email' => $admin->email,
            'token' => $token,
            'created_at' => now(),
        ]);

        Mail::to($admin->email)->send(new AdminSetPasswordMail($token));

        return redirect()->route('admin.login')->with('success', 'Registration successful! Please check your email to set your password.');
    }

    public function showSetPasswordForm($token)
    {
        return view('admin.auth.set-password', ['token' => $token]);
    }

    public function setPassword(Request $request, $token)
    {
        $request->validate([
            'password' => 'required|min:6|confirmed',
        ]);

        $reset = DB::table('admin_password_resets')->where('token', $token)->first();

        if (!$reset) {
            return redirect()->route('admin.login')->withErrors(['token' => 'Invalid or expired token.']);
        }

        $admin = Admin::where('email', $reset->email)->first();

        if (!$admin) {
            return redirect()->route('admin.login')->withErrors(['email' => 'Admin not found.']);
        }

        $admin->password = Hash::make($request->password);
        $admin->save();

        DB::table('admin_password_resets')->where('email', $reset->email)->delete();

        return redirect()->route('admin.login')->with('status', 'Password set successfully! You can now login.');
    }
}
