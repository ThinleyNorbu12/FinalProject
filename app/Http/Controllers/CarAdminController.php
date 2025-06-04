<?php
namespace App\Http\Controllers;

use App\Models\CarDetail; // Ensure you have the correct model namespace
use App\Models\InspectionRequest; // Ensure the InspectionRequest model is imported
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use App\Mail\CarInspectionRequested;
use App\Mail\CarRejected;
use Illuminate\Support\Facades\Log;
use App\Mail\InspectionConfirmedMail;
use App\Models\InspectionDecision;
use App\Mail\InspectionDecisionMail;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;
use App\Models\CarBooking;





class CarAdminController extends Controller
{
    public function showRegisteredCars()
    {
        // Fetch all registered cars without filtering by car_owner_id
        $cars = CarDetail::all();

        return view('admin.newly-registered-cars', compact('cars'));
    }

    // Optionally, if you have a method to view a single car:
    public function viewCar($id)
    {
        $car = CarDetail::findOrFail($id);
        return view('admin.view-car', compact('car'));
    }

    public function show($id)
    {
        $car = CarDetail::with('owner')->findOrFail($id);
        return view('admin.view-car', compact('car'));
    }

    // public function requestInspection(CarDetail $car)
    // {
    //     return view('admin.request-inspection', compact('car'));
    // }

    public function requestInspection(CarDetail $car)
    {
        return view('admin.request-inspection', compact('car'));
    }



    // Method to handle the inspection request submission
    
    // public function submitInspectionRequest(Request $request, $carId)
    // {
    //     // Validate input data
    //     $request->validate([
    //         'date' => 'required|date',
    //         'time' => 'required',
    //         'location' => 'required|string|max:255',
    //         'details' => 'nullable|string',
    //     ]);

    //     // Find the car and eager load its 'owner' relationship
    //     $car = CarDetail::with('owner')->findOrFail($carId);

    //     // Create a new inspection request
    //     $inspectionRequest = InspectionRequest::create([
    //         'car_id' => $carId,
    //         'inspection_date' => $request->date,
    //         'inspection_time' => $request->time,
    //         'location' => $request->location,
    //         'details' => $request->details,
    //         'status' => 'booked',
    //     ]);

    //     // Eager load the 'car' and 'owner' relationships for the inspection request
    //     $inspectionRequest->load('car.owner');

    //     // Send an email to the car owner if the owner and email exist
    //     if ($car->owner && $car->owner->email) {
    //         Mail::to($car->owner->email)->send(new CarInspectionRequested($inspectionRequest));
    //     }

    //     // Redirect back with a success message
    //     return back()->with('success', 'Inspection request submitted and email sent to the car owner.');
    // }

    public function submitInspectionRequest(Request $request, $carId)
{
    // Validate input data
    $request->validate([
        'date' => 'required|date',
        'time' => 'required',
        'location' => 'required|string|max:255',
        'details' => 'nullable|string',
    ]);
    
    // Find the car and eager load its 'owner' relationship
    $car = CarDetail::with('owner')->findOrFail($carId);
    
    // Create a new inspection request
    $inspectionRequest = InspectionRequest::create([
        'car_id' => $carId,
        'inspection_date' => $request->date,
        'inspection_time' => $request->time,
        'location' => $request->location,
        'details' => $request->details,
        'status' => 'booked',
    ]);
    
    // Eager load the 'car' and 'owner' relationships for the inspection request
    $inspectionRequest->load('car.owner');
    
    // Send an email to the car owner if the owner and email exist
    if ($car->owner && $car->owner->email) {
        Mail::to($car->owner->email)->send(new CarInspectionRequested($inspectionRequest));
    }
    
    // Format the date for display (convert from Y-m-d to d/m/Y)
    $formattedDate = date('d/m/Y', strtotime($request->date));
    
    // Create the detailed success message
    $successMessage = "Inspection request submitted and email sent to the car owner\n\n" .
                     "**Maker:** " . $car->maker . "\n" .
                     "**Model:** " . $car->model . "\n" .
                     "**Registration #:** `" . $car->registration_no . "`\n" .
                     "**Owner Information**\n" .
                     "**Name:** " . ($car->owner ? $car->owner->name : 'N/A') . "\n" .
                     "**Email:** " . ($car->owner ? $car->owner->email : 'N/A') . "\n" .
                     "Inspection date: " . $formattedDate . "\n" .
                     "Time: " . $request->time . "\n" .
                     "Location: " . $request->location;
    
    // Redirect to the newly registered cars page with success message
    return redirect()->route('car-admin.new-registration-cars')->with('success', $successMessage);
}

    public function showRejectForm(CarDetail $car)
    {
        return view('admin.reject-car', compact('car'));
    }

    
    public function rejectCar(Request $request, CarDetail $car)
    {
        // Validate the rejection reason
        $request->validate([
            'rejection_reason' => 'required|string|max:255',
        ]);

        // Update the car
        $car->update([
            'status' => 'rejected',
            'rejection_reason' => $request->input('rejection_reason'),
        ]);

        // 🔁 Refresh the model to get updated data (important!)
        $car->refresh();

        // Send email to the car owner if email exists
        if ($car->owner && $car->owner->email) {
            Mail::to($car->owner->email)->send(new CarRejected($car));
        }

        return redirect()->route('car-admin.new-registration-cars')->with('success', 'Car has been rejected with a reason, and email has been sent to the car owner.');
    }
     
    public function getAvailableTimes(Request $request)
    {
        try {
            $timeSlots = [
                '09:00 AM - 10:00 AM',
                '10:30 AM - 11:30 AM',
                '11:30 AM - 12:30 AM',
                '02:00 PM - 03:00 PM',
                '03:15 PM - 04:15 PM',
                '04:30 PM - 05:30 PM'
            ];

            $selectedDate = $request->input('date');

            if (!$selectedDate) {
                return response()->json(['error' => 'No date provided'], 400);
            }

            $bookedSlots = InspectionRequest::where('inspection_date', $selectedDate)
                                ->pluck('inspection_time')
                                ->toArray();

            $availableSlots = array_values(array_diff($timeSlots, $bookedSlots));

            return response()->json($availableSlots);
            
        } catch (\Exception $e) {
            \Log::error('getAvailableTimes error: ' . $e->getMessage());
            return response()->json(['error' => 'Server error'], 500);
        }
    }
// 21/4/2025
    // resources/views/car-admin/menage-inspection-requests.blade.php
    // public function showInspectionRequests()
    // {
    //     $inspectionRequests = InspectionRequest::with('car.owner')->latest()->get();
    //     return view('admin.menage-inspection-requests', compact('inspectionRequests'));
    // }

    //     // to only show inspection requests that were responded to by the car owner 
    public function showInspectionRequests()
    {
        $inspectionRequests = InspectionRequest::where(function ($query) {
            $query->where('status', 'canceled')  // Canceled by admin or owner
                ->orWhere('request_new_date_sent', true)  // Owner requested new date
                ->orWhere('is_confirmed_by_admin', true)  // Admin confirmed schedule
                ->orWhere('is_confirmed_by_owner', true)  // Owner confirmed
                ->orWhere('request_accepted', true);      // Accepted by admin
        })  
        ->with(['car.owner'])  // Eager load car and owner details
        ->latest()  // Show most recent first
        ->get();
        
        return view('admin.menage-inspection-requests', compact('inspectionRequests'));
    }



    // this is confirm and  sendMail is to notify to the carowner 
    // Confirm the date and time
    public function confirm($id)
    {
        $request = InspectionRequest::findOrFail($id);

        if (!$request->is_confirmed_by_admin) {
            // Send email to car owner
            $carOwner = $request->car->owner;
            if ($carOwner) {
                \Mail::to($carOwner->email)->send(new \App\Mail\InspectionConfirmedMail($request));
            }

            // Update status and confirmation flag
            $request->status = 'booked';
            $request->is_confirmed_by_admin = true;
            $request->save();

            return redirect()->back()->with('success', 'Inspection confirmed and email sent.');
        }

        return redirect()->back()->with('info', 'This inspection has already been confirmed.');
    }


    // public function showInspectionApprovals()
    // {
    //     $inspectionRequests = InspectionRequest::with(['car', 'car.owner'])
    //         ->where('is_confirmed_by_admin', true)
    //         ->where('status', '!=', 'canceled')
    //         ->whereDoesntHave('decision') // Only show requests without a decision
    //         ->get();

    //     return view('admin.inspection-approval', compact('inspectionRequests'));
    // }

    // public function processInspectionApproval(Request $request)
    // {
    //     $request->validate([
    //         'car_id' => 'required|exists:car_details_tbl,id', // Updated table name here
    //         'decision' => 'required|in:approved,rejected',
    //     ]);

    //     // Find inspection request
    //     $inspectionRequest = InspectionRequest::where('car_id', $request->car_id)
    //         ->where('is_confirmed_by_admin', true)
    //         ->where('status', '!=', 'canceled')
    //         ->firstOrFail();

    //     // Save decision
    //     InspectionDecision::create([
    //         'inspection_request_id' => $inspectionRequest->id,
    //         'decision' => $request->decision,
    //         'admin_id' => auth()->id(),
    //         'remarks' => null,
    //     ]);

    //     // Send mail to car owner
    //     if ($inspectionRequest->car && $inspectionRequest->car->owner) {
    //         Mail::to($inspectionRequest->car->owner->email)
    //             ->send(new InspectionDecisionMail($inspectionRequest, $request->decision));
    //     }

    //     return redirect()->route('car-admin.approve-inspected-cars')
    //         ->with('status', 'Car has been ' . $request->decision . ' successfully and the owner has been notified.');
    // }

    public function showInspectionApprovals()
    {
        $inspectionRequests = InspectionRequest::with(['car', 'car.owner'])
            ->where('is_confirmed_by_admin', true)
            ->where('status', '!=', 'canceled')
            ->whereDoesntHave('decision') // Only show requests without a decision
            ->get();

        return view('admin.inspection-approval', compact('inspectionRequests'));
    }

    /**
     * Process the approval or rejection of an inspection request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    // public function processInspectionApproval(Request $request)
    // {
    //     $request->validate([
    //         'car_id' => 'required|exists:car_details_tbl,id',
    //         'decision' => 'required|in:approved,rejected',
    //     ]);

    //     // Find inspection request
    //     $inspectionRequest = InspectionRequest::where('car_id', $request->car_id)
    //         ->where('is_confirmed_by_admin', true)
    //         ->where('status', '!=', 'canceled')
    //         ->firstOrFail();

    //     // Check if a decision already exists
    //     $existingDecision = InspectionDecision::where('inspection_request_id', $inspectionRequest->id)->first();
        
    //     if ($existingDecision) {
    //         // Update the existing decision instead of creating a new one
    //         $existingDecision->update([
    //             'decision' => $request->decision,
    //             'admin_id' => auth()->id(),
    //             'updated_at' => now()
    //         ]);
            
    //         $message = 'Decision has been updated successfully and the owner has been notified.';
    //     } else {
    //         // Create a new decision
    //         InspectionDecision::create([
    //             'inspection_request_id' => $inspectionRequest->id,
    //             'decision' => $request->decision,
    //             'admin_id' => auth()->id(),
    //             'remarks' => null,
    //         ]);
            
    //         $message = 'Car has been ' . $request->decision . ' successfully and the owner has been notified.';
    //     }

    //     // Send mail to car owner
    //     if ($inspectionRequest->car && $inspectionRequest->car->owner) {
    //         Mail::to($inspectionRequest->car->owner->email)
    //             ->send(new InspectionDecisionMail($inspectionRequest, $request->decision));
    //     }

    //     return redirect()->route('car-admin.approve-inspected-cars')
    //         ->with('status', $message);
    // }

    public function processInspectionApproval(Request $request)
{
    $request->validate([
        'car_id' => 'required|exists:car_details_tbl,id',
        'decision' => 'required|in:approved,rejected',
        'rejection_reason' => 'nullable|string',
    ]);

    // Find inspection request
    $inspectionRequest = InspectionRequest::where('car_id', $request->car_id)
        ->where('is_confirmed_by_admin', true)
        ->where('status', '!=', 'canceled')
        ->firstOrFail();

    // Check if a decision already exists
    $existingDecision = InspectionDecision::where('inspection_request_id', $inspectionRequest->id)->first();
    
    if ($existingDecision) {
        $existingDecision->update([
            'decision' => $request->decision,
            'admin_id' => auth()->id(),
            'rejection_reason' => $request->rejection_reason, // Use dedicated field
            'updated_at' => now()
        ]);
        
        $message = 'Decision has been updated successfully and the owner has been notified.';
    } else {
        // Create a new decision
            InspectionDecision::create([
            'inspection_request_id' => $inspectionRequest->id,
            'decision' => $request->decision,
            'admin_id' => auth()->id(),
            'rejection_reason' => $request->rejection_reason, // Use dedicated field
        ]);
        
        $message = 'Car has been ' . $request->decision . ' successfully and the owner has been notified.';
    }

    // Send mail to car owner
    if ($inspectionRequest->car && $inspectionRequest->car->owner) {
        Mail::to($inspectionRequest->car->owner->email)
            ->send(new InspectionDecisionMail($inspectionRequest, $request->decision, $request->rejection_reason));
    }

    return redirect()->route('car-admin.approve-inspected-cars')
        ->with('status', $message);
}





    public function profile()
{
    return view('admin.profile');
}

/**
 * Update admin profile information
 */
public function updateProfile(Request $request)
{
    $admin = Auth::guard('admin')->user();
    
    $request->validate([
        'name' => 'required|string|max:255',
        'email' => [
            'required',
            'email',
            'max:255',
            Rule::unique('admins')->ignore($admin->id)
        ],
    ]);

    try {
        $admin->update([
            'name' => $request->name,
            'email' => $request->email,
        ]);

        return redirect()->back()->with('success', 'Profile updated successfully!');
    } catch (\Exception $e) {
        return redirect()->back()->withErrors(['error' => 'Failed to update profile. Please try again.']);
    }
}

/**
 * Update admin password
 */
public function updatePassword(Request $request)
{
    $admin = Auth::guard('admin')->user();
    
    $request->validate([
        'current_password' => 'required',
        'new_password' => [
            'required',
            'string',
            'min:8',
            'confirmed',
            'regex:/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d).*$/' // At least one lowercase, uppercase, and number
        ],
    ], [
        'new_password.regex' => 'Password must contain at least one lowercase letter, one uppercase letter, and one number.',
        'new_password.confirmed' => 'Password confirmation does not match.',
    ]);

    // Verify current password
    if (!Hash::check($request->current_password, $admin->password)) {
        return redirect()->back()->withErrors(['current_password' => 'Current password is incorrect.']);
    }

    // Check if new password is different from current password
    if (Hash::check($request->new_password, $admin->password)) {
        return redirect()->back()->withErrors(['new_password' => 'New password must be different from current password.']);
    }

    try {
        $admin->update([
            'password' => Hash::make($request->new_password)
        ]);

        return redirect()->back()->with('success', 'Password changed successfully!');
    } catch (\Exception $e) {
        return redirect()->back()->withErrors(['error' => 'Failed to change password. Please try again.']);
    }
}

/**
 * Update admin profile picture
 */
public function updateProfilePicture(Request $request)
{
    $admin = Auth::guard('admin')->user();
    
    $request->validate([
        'profile_picture' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048', // 2MB Max
    ]);

    try {
        if ($request->hasFile('profile_picture')) {
            $file = $request->file('profile_picture');
            
            // Generate unique filename
            $filename = 'profile_' . $admin->id . '_' . time() . '.' . $file->getClientOriginalExtension();
            
            // Store the file in public/assets/images/profiles directory
            $path = $file->move(public_path('assets/images/profiles'), $filename);
            
            // Delete old profile picture if it exists and is not the default
            if ($admin->profile_picture && $admin->profile_picture !== 'thinley.jpg') {
                $oldImagePath = public_path('assets/images/profiles/' . $admin->profile_picture);
                if (file_exists($oldImagePath)) {
                    unlink($oldImagePath);
                }
            }
            
            // Update admin record with new profile picture filename
            $admin->update([
                'profile_picture' => $filename
            ]);

            return redirect()->back()->with('success', 'Profile picture updated successfully!');
        }
    } catch (\Exception $e) {
        return redirect()->back()->withErrors(['error' => 'Failed to update profile picture. Please try again.']);
    }

    return redirect()->back()->withErrors(['error' => 'No file was uploaded.']);
}

/**
 * Get admin profile data for API (optional)
 */
public function getProfileData()
{
    $admin = Auth::guard('admin')->user();
    
    return response()->json([
        'id' => $admin->id,
        'name' => $admin->name,
        'email' => $admin->email,
        'profile_picture' => $admin->profile_picture ?? 'thinley.jpg',
        'created_at' => $admin->created_at->format('M Y'),
        'updated_at' => $admin->updated_at->format('M d, Y'),
    ]);
}





public function showAddPriceForm()
{
    // Get all cars to select from
    $cars = CarDetail::all();
    
    return view('admin.add-price', compact('cars'));
}

/**
 * Store car pricing information
 */
public function storeCarPricing(Request $request)
{
    $request->validate([
        'car_id' => 'required|exists:car_details_tbl,id',
        'rate_per_day' => 'required|numeric|min:0',
        'mileage_limit' => 'required|numeric|min:0',
        'price_per_km' => 'required|numeric|min:0',
        'current_mileage' => 'required|numeric|min:0',
    ]);

    try {
        // Create a new car booking record with pricing information
        CarBooking::create([
            'car_id' => $request->car_id,
            'customer_id' => null, // No customer for pricing setup
            'pickup_location' => null,
            'dropoff_location' => null,
            'pickup_datetime' => null,
            'dropoff_datetime' => null,
            'status' => 'pricing_setup', // Custom status for pricing records
            'payment_method' => null,
            'transaction_id' => null,
            'rate_per_day' => $request->rate_per_day,
            'price_per_km' => $request->price_per_km,
            'mileage_limit' => $request->mileage_limit,
            'current_mileage' => $request->current_mileage,
        ]);

        return redirect()->route('car-admin.add-price')
            ->with('success', 'Car pricing information added successfully!');
            
    } catch (\Exception $e) {
        return redirect()->back()
            ->with('error', 'Failed to add pricing information. Please try again.')
            ->withInput();
    }
}


}
