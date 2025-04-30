<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class PaymentController extends Controller
{
    // Show the payment form
    public function show()
    {
        return view('payment');
    }

    // Handle the payment submission
    public function process(Request $request)
    {
        // You can add validation and payment logic here
        $request->validate([
            'card_number' => 'required',
            'expiry_date' => 'required',
            'cvv' => 'required',
        ]);

        // For now, just simulate success
        return redirect()->route('payment.page')->with('success', 'Payment successful!');
    }
}
