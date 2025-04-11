<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AdminMiddleware
{
    public function handle(Request $request, Closure $next)
    {
        // Check if the user is authenticated and is an admin
        if (Auth::check() && Auth::user()->role === 'admin') {
            return $next($request); // Allow the request to proceed if the user is an admin
        }

        // Redirect to login page or another page if the user is not an admin
        return redirect('/login'); // Or you can redirect to any other page you prefer
    }
}