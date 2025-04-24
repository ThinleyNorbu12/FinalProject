<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class CustomerController extends Controller
{
    /**
     * Show the customer dashboard.
     */
    public function dashboard()
    {
        return view('customer.dashboard');
    }
}
