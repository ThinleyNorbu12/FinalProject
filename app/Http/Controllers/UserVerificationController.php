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

// public function index()
//     {
//         // Get all customers with their driving licenses using eager loading
//         $customers = Customer::with(['drivingLicense' => function($query) {
//             $query->select('id', 'customer_id', 'license_no', 'status');
//         }])
//         ->orderBy('created_at', 'desc')
//         ->paginate(10);
            
//         // Count by status
//         $pendingCount = DrivingLicense::where('status', 'Pending')->count();
//         $verifiedCount = DrivingLicense::where('status', 'Verified')->count();
//         $rejectedCount = DrivingLicense::where('status', 'Rejected')->count();
        
//         // Count customers without licenses (incomplete)
//         $totalCustomers = Customer::count();
//         $withLicenses = DrivingLicense::distinct('customer_id')->count('customer_id');
//         $incompleteCount = $totalCustomers - $withLicenses;

//         return view('admin.verify-users', compact(
//             'customers', 
//             'pendingCount', 
//             'verifiedCount', 
//             'rejectedCount',
//             'incompleteCount'
//         ));
//     }

//     /**
//      * Show the details of a specific user for verification.
//      *
//      * @param  int  $id
//      * @return \Illuminate\Http\Response
//      */
//     public function show($id)
//     {
//         $customer = Customer::with('drivingLicense')->findOrFail($id);

//         if (!$customer->hasCompleteVerificationInfo()) {
//             return redirect()->route('admin.verify-users')
//                 ->with('error', 'This user has not submitted their license information yet.');
//         }

//         return view('admin.user-verification-details', compact('customer'));
//     }

//     /**
//      * Update the verification status of a user.
//      *
//      * @param  \Illuminate\Http\Request  $request
//      * @param  int  $id
//      * @return \Illuminate\Http\Response
//      */
//     public function updateStatus(Request $request, $id)
//     {
//         $request->validate([
//             'status' => 'required|in:Verified,Rejected',
//             'rejection_reason' => 'required_if:status,Rejected',
//         ]);

//         $customer = Customer::findOrFail($id);
        
//         if (!$customer->hasCompleteVerificationInfo()) {
//             return redirect()->route('admin.verify-users')
//                 ->with('error', 'No license record found for this user.');
//         }
        
//         $license = $customer->drivingLicense;
//         $license->status = $request->status;
        
//         if ($request->status == 'Rejected') {
//             $license->rejection_reason = $request->rejection_reason;
//         }

//         $license->save();

//         // Create notification for the user
//         AdminNotification::create([
//             'customer_id' => $customer->id,
//             'title' => 'Driving License Verification ' . $request->status,
//             'message' => $request->status == 'Verified' 
//                 ? 'Your driving license has been verified successfully.' 
//                 : 'Your driving license verification was rejected. Reason: ' . $request->rejection_reason,
//             'is_read' => false,
//             'type' => 'license_verification'
//         ]);
        
//         return redirect()->route('admin.verify-users')
//             ->with('success', "User verification status has been updated to {$request->status}.");
//     }
    
//     /**
//      * Filter users by verification status.
//      *
//      * @param  \Illuminate\Http\Request  $request
//      * @return \Illuminate\Http\Response
//      */
//     public function filter(Request $request)
//     {
//         $status = $request->status;
        
//         $customersQuery = Customer::with('drivingLicense');
        
//         if ($status == 'Pending' || $status == 'Verified' || $status == 'Rejected') {
//             $customersQuery->whereHas('drivingLicense', function($query) use ($status) {
//                 $query->where('status', $status);
//             });
//         } elseif ($status == 'Incomplete') {
//             $customersQuery->whereDoesntHave('drivingLicense');
//         }
        
//         $customers = $customersQuery->orderBy('created_at', 'desc')->paginate(10);
        
//         // Count by status
//         $pendingCount = DrivingLicense::where('status', 'Pending')->count();
//         $verifiedCount = DrivingLicense::where('status', 'Verified')->count();
//         $rejectedCount = DrivingLicense::where('status', 'Rejected')->count();
        
//         // Count customers without licenses (incomplete)
//         $totalCustomers = Customer::count();
//         $withLicenses = DrivingLicense::distinct('customer_id')->count('customer_id');
//         $incompleteCount = $totalCustomers - $withLicenses;
        
//         return view('admin.verify-users', compact(
//             'customers', 
//             'pendingCount', 
//             'verifiedCount', 
//             'rejectedCount',
//             'incompleteCount',
//             'status'
//         ));
//     }

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
            'status' => 'required|in:Verified,Rejected,Pending',
            'rejection_reason' => 'required_if:status,Rejected',
        ]);

        try {
            $customer = Customer::findOrFail($id);
            
            if (!$customer->drivingLicense) {
                return redirect()->route('admin.verify-users')
                    ->with('error', 'No license record found for this user.');
            }
            
            $license = $customer->drivingLicense;
            $license->status = $request->status;
            
            if ($request->status == 'Rejected') {
                $license->rejection_reason = $request->rejection_reason;
            } else {
                // Clear rejection reason if status is not rejected
                $license->rejection_reason = null;
            }

            $license->save();

            // Create notification for the user
            $this->createNotification($customer, $request->status, $request->rejection_reason);
            
            $message = $request->status == 'Pending' 
                ? "User verification status has been reset to Pending."
                : "User verification status has been updated to {$request->status}.";
            
            return redirect()->route('admin.verify-users')
                ->with('success', $message);

        } catch (\Exception $e) {
            return redirect()->back()
                ->with('error', 'An error occurred while updating the verification status. Please try again.');
        }
    }
    
    /**
     * Handle alternative document verification.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function alternativeVerification(Request $request, $id)
    {
        $request->validate([
            'id_proof_type' => 'required|string|max:255',
            'id_proof_number' => 'required|string|max:255',
            'remarks' => 'nullable|string|max:1000',
            'is_verified' => 'required|accepted',
        ]);

        try {
            $customer = Customer::findOrFail($id);
            
            if (!$customer->drivingLicense) {
                return redirect()->route('admin.verify-users')
                    ->with('error', 'No license record found for this user.');
            }
            
            $license = $customer->drivingLicense;
            $license->status = 'Verified';
            $license->rejection_reason = null; // Clear any previous rejection reason
            
            $license->save();

            // Create notification for the user
            $this->createNotification($customer, 'Verified', null, true);
            
            return redirect()->route('admin.verify-users')
                ->with('success', 'User has been verified using alternative document verification.');

        } catch (\Exception $e) {
            return redirect()->back()
                ->with('error', 'An error occurred while processing alternative verification. Please try again.');
        }
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

    /**
     * Create notification for the customer.
     *
     * @param  \App\Models\Customer  $customer
     * @param  string  $status
     * @param  string|null  $rejectionReason
     * @param  bool  $isAlternative
     * @return void
     */
    private function createNotification($customer, $status, $rejectionReason = null, $isAlternative = false)
    {
        try {
            $title = 'Driving License Verification ' . $status;
            
            if ($status == 'Verified') {
                $message = $isAlternative 
                    ? 'Your driving license has been verified successfully using alternative document verification.' 
                    : 'Your driving license has been verified successfully.';
            } elseif ($status == 'Rejected') {
                $message = 'Your driving license verification was rejected. Reason: ' . $rejectionReason;
            } else { // Pending
                $message = 'Your driving license verification status has been reset to pending. You may need to resubmit your documents.';
            }

            AdminNotification::create([
                'customer_id' => $customer->id,
                'title' => $title,
                'message' => $message,
                'is_read' => false,
                'type' => 'license_verification'
            ]);
        } catch (\Exception $e) {
            // Log the error but don't fail the main operation
            \Log::error('Failed to create notification: ' . $e->getMessage());
        }
    }



}