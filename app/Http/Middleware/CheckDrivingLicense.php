<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class CheckDrivingLicense
{
    public function handle(Request $request, Closure $next)
    {
        $customer = auth('customer')->user();
        
        if (!$customer->hasValidDrivingLicense()) {
            return redirect()->route('booking.summary', ['bookingId' => $request->route('bookingId')])
                ->with('error', 'Please upload your driving license before making payment.');
        }

        return $next($request);
    }
}
