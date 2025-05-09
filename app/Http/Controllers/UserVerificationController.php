<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Customer;
use App\Models\DrivingLicense;
use Illuminate\Support\Facades\DB;

class UserVerificationController extends Controller
{
    /**
     * Display a listing of users pending verification
     */
    public function index()
    {
        // Get customers with their license information
        $users = Customer::leftJoin('driving_licenses', 'customers.id', '=', 'driving_licenses.customer_id')
            ->select(
                'customers.id',
                'customers.name',
                'customers.email',
                'customers.phone',
                'customers.created_at as registered_on',
                DB::raw('CASE 
                    WHEN driving_licenses.status = "Verified" THEN "Verified"
                    WHEN driving_licenses.status = "Rejected" THEN "Rejected"
                    WHEN driving_licenses.status = "Pending" THEN "Pending"
                    ELSE "Incomplete"
                END as verification_status')
            )
            ->orderBy('driving_licenses.created_at', 'desc')
            ->paginate(10);

        return view('admin.verify-users', compact('users'));
    }

    /**
     * Show user details for verification
     */
    public function show($id)
    {
        $user = Customer::findOrFail($id);
        $license = DrivingLicense::where('customer_id', $id)->first();

        return view('admin.user-verification-details', compact('user', 'license'));
    }

    /**
     * Update verification status
     */
    public function updateStatus(Request $request, $id)
    {
        $request->validate([
            'status' => 'required|in:Verified,Rejected',
            'rejection_reason' => 'required_if:status,Rejected',
        ]);

        $license = DrivingLicense::where('customer_id', $id)->first();
        
        if (!$license) {
            return redirect()->back()->with('error', 'No license information found for this user.');
        }

        $license->status = $request->status;
        
        if ($request->status == 'Rejected') {
            $license->rejection_reason = $request->rejection_reason;
        }
        
        $license->save();

        // Notification logic can be added here
        // You might want to notify the customer via email

        return redirect()->route('admin.verify-users')->with('success', 'User verification status updated successfully');
    }

    /**
     * Get verification count for admin dashboard
     */
    public function getPendingVerificationCount()
    {
        $count = DrivingLicense::where('status', 'Pending')->count();
        return response()->json(['count' => $count]);
    }
}