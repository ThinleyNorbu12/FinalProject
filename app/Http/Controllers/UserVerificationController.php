<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Customer;
use App\Models\DrivingLicense;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class UserVerificationController extends Controller
{
    /**
     * Display a listing of all user licenses for verification.
     */
    public function index(Request $request)
    {
        $query = DrivingLicense::with('customer');
        
        // Apply filters if provided
        if ($request->has('status') && $request->status) {
            $query->where('status', $request->status);
        }
        
        if ($request->has('search') && $request->search) {
            $search = $request->search;
            $query->whereHas('customer', function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('email', 'like', "%{$search}%")
                  ->orWhere('cid_no', 'like', "%{$search}%");
            })
            ->orWhere('license_no', 'like', "%{$search}%");
        }
        
        // Order by most recent first
        $query->orderByRaw("FIELD(status, 'Pending', 'Rejected', 'Verified')")
              ->orderBy('created_at', 'desc');
        
        $licenses = $query->paginate(10);
        
        return view('admin.verify-users.index', compact('licenses'));
    }

    /**
     * Display detailed information about a specific license.
     */
    public function show($id)
    {
        $license = DrivingLicense::findOrFail($id);
        $customer = $license->customer;
        
        return view('admin.verify-users.show', compact('license', 'customer'));
    }

    /**
     * Verify a user's license.
     */
    public function verifyLicense(Request $request)
    {
        try {
            DB::beginTransaction();
            
            $license = DrivingLicense::findOrFail($request->license_id);
            $license->status = 'Verified';
            $license->verified_by = Auth::guard('admin')->id();
            $license->verified_at = now();
            $license->save();
            
            // You could also log this action in an admin_activity_logs table
            // AdminActivityLog::create([
            //     'admin_id' => Auth::guard('admin')->id(),
            //     'action' => 'Verified license',
            //     'description' => 'Verified license #' . $license->license_no . ' for customer ' . $license->customer->name,
            //     'model_type' => 'DrivingLicense',
            //     'model_id' => $license->id
            // ]);
            
            DB::commit();
            
            // Optionally, send notification to customer
            // Notification::send($license->customer, new LicenseVerified($license));
            
            return response()->json([
                'success' => true,
                'message' => 'License successfully verified!'
            ]);
        } catch (\Exception $e) {
            DB::rollBack();
            
            return response()->json([
                'success' => false,
                'message' => 'Error verifying license: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Reject a user's license.
     */
    public function rejectLicense(Request $request)
    {
        $request->validate([
            'license_id' => 'required|exists:driving_licenses,id',
            'rejection_reason' => 'required|string|max:500'
        ]);
        
        try {
            DB::beginTransaction();
            
            $license = DrivingLicense::findOrFail($request->license_id);
            $license->status = 'Rejected';
            $license->rejection_reason = $request->rejection_reason;
            $license->rejected_by = Auth::guard('admin')->id();
            $license->rejected_at = now();
            $license->save();
            
            // You could also log this action
            // AdminActivityLog::create([
            //     'admin_id' => Auth::guard('admin')->id(),
            //     'action' => 'Rejected license',
            //     'description' => 'Rejected license #' . $license->license_no . ' for customer ' . $license->customer->name,
            //     'model_type' => 'DrivingLicense',
            //     'model_id' => $license->id
            // ]);
            
            DB::commit();
            
            // Optionally, send notification to customer
            // Notification::send($license->customer, new LicenseRejected($license));
            
            return redirect()->route('admin.verify-users')
                             ->with('success', 'License has been rejected.');
        } catch (\Exception $e) {
            DB::rollBack();
            
            return redirect()->back()
                             ->with('error', 'Error rejecting license: ' . $e->getMessage());
        }
    }
}