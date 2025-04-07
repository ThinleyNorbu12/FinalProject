<?php

// namespace App\Http\Middleware;

// use Closure;
// use Illuminate\Http\Request;
// use Illuminate\Support\Facades\Auth; -->

// class CarOwnerAuth
// {
//     public function handle(Request $request, Closure $next)
//     {
//         // Check if the user is authenticated as a car owner
//         if (!Auth::guard('carowner')->check()) {
//             return redirect()->route('carowner.login')
//                 ->with('error', 'You need to register or login as a car owner first.');
//         }

//         return $next($request);
//     }
// }


namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;

class CarOwnerAuth
{
    public function handle($request, Closure $next)
    {
        if (!Auth::check()) {
            return redirect()->route('carowner.login')->with('error', 'Please login first.');
        }

        // You can add custom role/guard checks here if needed
        return $next($request);
    }
}
