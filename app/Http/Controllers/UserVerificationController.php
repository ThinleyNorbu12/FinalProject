<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Customer;
use App\Models\DrivingLicense;
use Illuminate\Support\Facades\DB;
use App\Models\AdminNotification;

class UserVerificationController extends Controller
{
    /**
     * Display a listing of users pending verification
     */
    // public function index()
    // {
    //     // Get customers with their license information
    //     $users = Customer::leftJoin('driving_licenses', 'customers.id', '=', 'driving_licenses.customer_id')
    //         ->select(
    //             'customers.id',
    //             'customers.name',
    //             'customers.email',
    //             'customers.phone',
    //             'customers.created_at as registered_on',
    //             DB::raw('CASE 
    //                 WHEN driving_licenses.status = "Verified" THEN "Verified"
    //                 WHEN driving_licenses.status = "Rejected" THEN "Rejected"
    //                 WHEN driving_licenses.status = "Pending" THEN "Pending"
    //                 ELSE "Incomplete"
    //             END as verification_status')
    //         )
    //         ->orderBy('driving_licenses.created_at', 'desc')
    //         ->paginate(10);

    //     return view('admin.verify-users', compact('users'));
    // }

//     /**
//      * Show user details for verification
//      */
//     public function show($id)
//     {
//         $user = Customer::findOrFail($id);
//         $license = DrivingLicense::where('customer_id', $id)->first();

//         return view('admin.user-verification-details', compact('user', 'license'));
//     }

//     /**
//      * Update verification status
//      */
//     public function updateStatus(Request $request, $id)
//     {
//         $request->validate([
//             'status' => 'required|in:Verified,Rejected',
//             'rejection_reason' => 'required_if:status,Rejected',
//         ]);

//         $license = DrivingLicense::where('customer_id', $id)->first();
        
//         if (!$license) {
//             return redirect()->back()->with('error', 'No license information found for this user.');
//         }

//         $license->status = $request->status;
        
//         if ($request->status == 'Rejected') {
//             $license->rejection_reason = $request->rejection_reason;
//         }
        
//         $license->save();

//         // Notification logic can be added here
//         // You might want to notify the customer via email

//         return redirect()->route('admin.verify-users')->with('success', 'User verification status updated successfully');
//     }

//     /**
//      * Get verification count for admin dashboard
//      */
//     public function getPendingVerificationCount()
//     {
//         $count = DrivingLicense::where('status', 'Pending')->count();
//         return response()->json(['count' => $count]);
//     }
// }



public function index()
    {
        // Get all customers with their driving licenses using eager loading
        $customers = Customer::with(['drivingLicense' => function($query) {
            $query->select('id', 'customer_id', 'license_no', 'status');
        }])
        ->orderBy('created_at', 'desc')
        ->paginate(10);
            
        // Count by status
        $pendingCount = DrivingLicense::where('status', 'Pending')->count();
        $verifiedCount = DrivingLicense::where('status', 'Verified')->count();
        $rejectedCount = DrivingLicense::where('status', 'Rejected')->count();
        
        // Count customers without licenses (incomplete)
        $totalCustomers = Customer::count();
        $withLicenses = DrivingLicense::distinct('customer_id')->count('customer_id');
        $incompleteCount = $totalCustomers - $withLicenses;

        return view('admin.verify-users', compact(
            'customers', 
            'pendingCount', 
            'verifiedCount', 
            'rejectedCount',
            'incompleteCount'
        ));
    }

    /**
     * Show the details of a specific user for verification.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $customer = Customer::with('drivingLicense')->findOrFail($id);

        if (!$customer->hasCompleteVerificationInfo()) {
            return redirect()->route('admin.verify-users')
                ->with('error', 'This user has not submitted their license information yet.');
        }

        return view('admin.user-verification-details', compact('customer'));
    }

    /**
     * Update the verification status of a user.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function updateStatus(Request $request, $id)
    {
        $request->validate([
            'status' => 'required|in:Verified,Rejected',
            'rejection_reason' => 'required_if:status,Rejected',
        ]);

        $customer = Customer::findOrFail($id);
        
        if (!$customer->hasCompleteVerificationInfo()) {
            return redirect()->route('admin.verify-users')
                ->with('error', 'No license record found for this user.');
        }
        
        $license = $customer->drivingLicense;
        $license->status = $request->status;
        
        if ($request->status == 'Rejected') {
            $license->rejection_reason = $request->rejection_reason;
        }

        $license->save();

        // Create notification for the user
        AdminNotification::create([
            'customer_id' => $customer->id,
            'title' => 'Driving License Verification ' . $request->status,
            'message' => $request->status == 'Verified' 
                ? 'Your driving license has been verified successfully.' 
                : 'Your driving license verification was rejected. Reason: ' . $request->rejection_reason,
            'is_read' => false,
            'type' => 'license_verification'
        ]);
        
        return redirect()->route('admin.verify-users')
            ->with('success', "User verification status has been updated to {$request->status}.");
    }
    
    /**
     * Filter users by verification status.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function filter(Request $request)
    {
        $status = $request->status;
        
        $customersQuery = Customer::with('drivingLicense');
        
        if ($status == 'Pending' || $status == 'Verified' || $status == 'Rejected') {
            $customersQuery->whereHas('drivingLicense', function($query) use ($status) {
                $query->where('status', $status);
            });
        } elseif ($status == 'Incomplete') {
            $customersQuery->whereDoesntHave('drivingLicense');
        }
        
        $customers = $customersQuery->orderBy('created_at', 'desc')->paginate(10);
        
        // Count by status
        $pendingCount = DrivingLicense::where('status', 'Pending')->count();
        $verifiedCount = DrivingLicense::where('status', 'Verified')->count();
        $rejectedCount = DrivingLicense::where('status', 'Rejected')->count();
        
        // Count customers without licenses (incomplete)
        $totalCustomers = Customer::count();
        $withLicenses = DrivingLicense::distinct('customer_id')->count('customer_id');
        $incompleteCount = $totalCustomers - $withLicenses;
        
        return view('admin.verify-users', compact(
            'customers', 
            'pendingCount', 
            'verifiedCount', 
            'rejectedCount',
            'incompleteCount',
            'status'
        ));
    }
}