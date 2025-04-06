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
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CarOwnerAuth
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        if (!Auth::guard('carowner')->check()) {
            return redirect()->route('carowner.login');
        }

        return $next($request);
    }
}