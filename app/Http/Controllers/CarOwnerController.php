<?php

namespace App\Http\Controllers;

use App\Models\CarOwner;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;
use App\Mail\CarOwnerVerification;
use App\Models\CarDetail;
use App\Models\InspectionRequest;
use Illuminate\Support\Facades\DB;
use App\Models\Admin; 
use App\Mail\InspectionAcceptedNotification;
use App\Models\CarImage;




class CarOwnerController extends Controller
{
    // Show the registration form
    public function showRegisterForm()
    {
        return view('CarOwner.register');
    }
    public function register(Request $request)
    {
        // Validate the input
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:car_owners',
            'phone' => 'required|string|max:20',
            'address' => 'required|string|max:255',
        ], [
            'email.unique' => 'Oops! This email is already registered. Please use a different one.', // Friendly tone message
        ]);
    
        // Generate a unique verification token
        $verificationToken = Str::random(64);
    
        // Create the car owner in the database
        $carOwner = CarOwner::create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'phone' => $validated['phone'],
            'address' => $validated['address'],
            'verification_token' => $verificationToken,
        ]);
    
        // Generate the verification URL
        $verificationUrl = route('carowner.verify', ['token' => $verificationToken]);
    
        // Send the verification email
        Mail::to($carOwner->email)->send(new \App\Mail\CarOwnerVerification($carOwner, $verificationUrl));
    
        // Return success message
        return redirect()->route('carowner.login')
            ->with('success', 'Registration successful! Please check your email to verify your account and set up your password.');
    }
    
    // Show the dashboard
    //     public function dashboard()
    // {
    //     // Fetch the authenticated car owner
    //     $carOwner = Auth::guard('carowner')->user();

    //     // If no car owner is logged in, redirect to login page
    //     if (!$carOwner) {
    //         return redirect()->route('carowner.login');
    //     }

    //     // Pass the car owner to the view
    //     return view('CarOwner.dashboard', compact('carOwner'));
    // }

    // public function dashboard()
    // {
    //     $carOwnerId = auth('carowner')->id();

    //     $pendingInspectionCount = DB::table('inspection_requests')
    //         ->join('car_details_tbl', 'inspection_requests.car_id', '=', 'car_details_tbl.id')
    //         ->where('car_details_tbl.car_owner_id', $carOwnerId)
    //         ->where('inspection_requests.status', 'pending')
    //         ->count();

    //     return view('CarOwner.dashboard', compact('pendingInspectionCount'));
    // }
 public function dashboard()
{
    $carOwnerId = auth('carowner')->id();

    // Get total cars count for this car owner
    $totalCarsCount = DB::table('car_details_tbl')
        ->where('car_owner_id', $carOwnerId)
        ->count();

    // Get approved cars count (cars with approved inspection decisions)
    $approvedCarsCount = DB::table('car_details_tbl')
        ->join('inspection_requests', 'car_details_tbl.id', '=', 'inspection_requests.car_id')
        ->join('inspection_decisions', 'inspection_requests.id', '=', 'inspection_decisions.inspection_request_id')
        ->where('car_details_tbl.car_owner_id', $carOwnerId)
        ->where('inspection_decisions.decision', 'approved')
        ->count();

    // Get rejected cars count (cars with rejected inspection decisions)
    $rejectedCarsCount = DB::table('car_details_tbl')
        ->join('inspection_requests', 'car_details_tbl.id', '=', 'inspection_requests.car_id')
        ->join('inspection_decisions', 'inspection_requests.id', '=', 'inspection_decisions.inspection_request_id')
        ->where('car_details_tbl.car_owner_id', $carOwnerId)
        ->where('inspection_decisions.decision', 'rejected')
        ->count();

    // Get pending cars count (cars that have inspection requests but no decisions yet)
    $pendingCarsCount = DB::table('car_details_tbl')
        ->join('inspection_requests', 'car_details_tbl.id', '=', 'inspection_requests.car_id')
        ->leftJoin('inspection_decisions', 'inspection_requests.id', '=', 'inspection_decisions.inspection_request_id')
        ->where('car_details_tbl.car_owner_id', $carOwnerId)
        ->whereNull('inspection_decisions.id') // No decision made yet
        ->count();

    // Get recent activities (last 10 activities)
    $recentActivities = collect();
    
    // Get recent approvals
    $recentApprovals = DB::table('car_details_tbl')
        ->join('inspection_requests', 'car_details_tbl.id', '=', 'inspection_requests.car_id')
        ->join('inspection_decisions', 'inspection_requests.id', '=', 'inspection_decisions.inspection_request_id')
        ->where('car_details_tbl.car_owner_id', $carOwnerId)
        ->where('inspection_decisions.decision', 'approved')
        ->select(
            'car_details_tbl.maker',
            'car_details_tbl.model',
            'inspection_decisions.created_at',
            DB::raw("'approved' as activity_type")
        )
        ->get();
    
    // Get recent rejections
    $recentRejections = DB::table('car_details_tbl')
        ->join('inspection_requests', 'car_details_tbl.id', '=', 'inspection_requests.car_id')
        ->join('inspection_decisions', 'inspection_requests.id', '=', 'inspection_decisions.inspection_request_id')
        ->where('car_details_tbl.car_owner_id', $carOwnerId)
        ->where('inspection_decisions.decision', 'rejected')
        ->select(
            'car_details_tbl.maker',
            'car_details_tbl.model',
            'inspection_decisions.created_at',
            DB::raw("'rejected' as activity_type")
        )
        ->get();
    
    // Get recent car registrations
    $recentRegistrations = DB::table('car_details_tbl')
        ->where('car_owner_id', $carOwnerId)
        ->select(
            'maker',
            'model',
            'created_at',
            DB::raw("'registered' as activity_type")
        )
        ->get();
    
    // Combine all activities and convert created_at to Carbon instances
    $recentActivities = $recentApprovals
        ->concat($recentRejections)
        ->concat($recentRegistrations)
        ->map(function ($activity) {
            $activity->created_at = \Carbon\Carbon::parse($activity->created_at);
            return $activity;
        })
        ->sortByDesc('created_at')
        ->take(10);
    
    // Get monthly earnings data (assuming you have a bookings/rentals table)
    $currentMonth = now()->format('Y-m');
    $monthlyEarnings = 0; // Default value
    $activeRentals = 0;
    $avgDailyRate = 0;
    
    // If you have a bookings table, uncomment and modify these queries:
    /*
    $monthlyEarnings = DB::table('bookings')
        ->join('car_details_tbl', 'bookings.car_id', '=', 'car_details_tbl.id')
        ->where('car_details_tbl.car_owner_id', $carOwnerId)
        ->whereRaw('DATE_FORMAT(bookings.created_at, "%Y-%m") = ?', [$currentMonth])
        ->where('bookings.status', 'completed')
        ->sum('bookings.total_amount');
    
    $activeRentals = DB::table('bookings')
        ->join('car_details_tbl', 'bookings.car_id', '=', 'car_details_tbl.id')
        ->where('car_details_tbl.car_owner_id', $carOwnerId)
        ->where('bookings.status', 'active')
        ->count();
    
    $avgDailyRate = DB::table('bookings')
        ->join('car_details_tbl', 'bookings.car_id', '=', 'car_details_tbl.id')
        ->where('car_details_tbl.car_owner_id', $carOwnerId)
        ->where('bookings.status', 'completed')
        ->avg('bookings.daily_rate');
    */
    
    // Calculate progress percentage for monthly goal
    $monthlyGoal = 3000; // You can make this configurable
    $progressPercentage = $monthlyGoal > 0 ? min(($monthlyEarnings / $monthlyGoal) * 100, 100) : 0;
    
    // Mock customer rating (you'll need to implement this based on your reviews system)
    $customerRating = 4.8;

    return view('CarOwner.dashboard', compact(
        'totalCarsCount',
        'approvedCarsCount', 
        'pendingCarsCount',
        'rejectedCarsCount',
        'recentActivities',
        'monthlyEarnings',
        'monthlyGoal',
        'progressPercentage',
        'activeRentals',
        'avgDailyRate',
        'customerRating'
    ));
}
    // Handle logout
    public function logout(Request $request)
    {
        Auth::guard('carowner')->logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect()->route('carowner.login');
    }

    public function sendVerificationEmail(CarOwner $carOwner)
    {
        // Generate verification token
        $token = Str::random(64);
        $carOwner->verification_token = $token;
        $carOwner->save();

        // Generate the verification URL
        $verificationUrl = route('carowner.setPassword', ['token' => $token]);

        // Send email
        Mail::to($carOwner->email)->send(new CarOwnerVerification($carOwner, $verificationUrl));

        return response()->json(['message' => 'Verification email sent']);
    }

    // Show the set password form
    public function showSetPasswordForm($token)
    {
        $carOwner = CarOwner::where('password_set_token', $token)->first();

        if (!$carOwner) {
            return redirect()->route('carowner.login')->with('error', 'Invalid or expired token.');
        }

        return view('CarOwner.set-password', compact('token'));
    }


    // Set the password
    public function setPassword(Request $request, $token)
    {
        // Validate the password
        $request->validate([
            'password' => 'required|string|min:8|confirmed',
        ]);

        // Find the car owner by the verification token
        $carOwner = CarOwner::where('password_set_token', $token)->first();

        if (!$carOwner) {
            return redirect()->route('carowner.login')->with('error', 'Invalid or expired token.');
        }

        // Set the password and save
        $carOwner->password = Hash::make($request->password);
        $carOwner->password_set_token = null; // Remove verification token
        $carOwner->save();

        // Log the car owner in
        Auth::guard('carowner')->login($carOwner);

        // Redirect to the dashboard
        return redirect()->route('carowner.dashboard')->with('success', 'Your password has been set successfully.');
    }

    public function showRentCarForm()
    {
        return view('CarOwner.rent-car');  // This renders the rent car form view
    }

    // when car owner rent a car
    // public function storeRentCar(Request $request)
    // {
    //     // Validation logic
    //     $request->validate([
    //         'maker' => 'required|string|max:255',
    //         'model' => 'required|string|max:255',
    //         'vehicle_type' => 'required|string',
    //         'car_condition' => 'required|string',
    //         'mileage' => 'required|numeric',
    //         'price' => 'required|numeric',
    //         'registration_no' => 'required|string|unique:car_details_tbl,registration_no',
    //         'status' => 'required|string',
    //         'description' => 'nullable|string',
    //         'car_image' => 'nullable|image|mimes:jpeg,webp,png,jpg,gif|max:2048',
    //     ], [
    //         'registration_no.unique' => 'This registration number is already registered.',
    //     ]);
        
    
    //     // Store car information in database (CarDetail model)
    //     $car = new CarDetail();
    //     $car->maker = $request->maker;
    //     $car->model = $request->model;
    //     $car->vehicle_type = $request->vehicle_type;
    //     $car->car_condition = $request->car_condition;
    //     $car->mileage = $request->mileage;
    //     $car->price = $request->price;
    //     $car->registration_no = $request->registration_no;
    //     $car->status = $request->status;
    //     $car->description = $request->description;
    
    //     // Initialize $imagePath variable
    //     $imagePath = null;
    
    //     // Handle image upload
    //     if ($request->hasFile('car_image')) {
    //         $file = $request->file('car_image');
    //         $filename = time() . '.' . $file->getClientOriginalExtension();
    //         $file->move(public_path('uploads/cars'), $filename); // Store in the 'uploads/cars' directory
    //         $imagePath = 'uploads/cars/' . $filename; // Store the path in the DB
    //     }
    
    //     // Assign the image path to the car record
    //     $car->car_image = $imagePath;
    
    //     // Assign the car to the logged-in car owner using the correct column: car_owner_id
    //     $car->car_owner_id = auth()->guard('carowner')->id(); // Use car_owner_id to link to the owner
    
    //     // Save the car record to the database
    //     $car->save();
    
    //     // Redirect with a success message
    //     return redirect()->route('carowner.rentCar')->with('success', 'Car registered successfully!');
    // }

    //     public function storeRentCar(Request $request)
    // {
    //     // Validation logic
    //     $request->validate([
    //         'maker' => 'required|string|max:255',
    //         'model' => 'required|string|max:255',
    //         'vehicle_type' => 'required|string',
    //         'car_condition' => 'required|string',
    //         'mileage' => 'required|numeric',
    //         'price' => 'required|numeric',
    //         'registration_no' => 'required|string|unique:car_details_tbl,registration_no',
    //         'status' => 'required|string',
    //         'description' => 'nullable|string',
    //         'car_image' => 'required|image|mimes:jpeg,webp,png,jpg,gif|max:2048',
    //         'number_of_doors' => 'nullable|integer',
    //         'number_of_seats' => 'nullable|integer',
    //         'transmission_type' => 'required|string|in:Automatic,Manual', // Make it required with specific valid values
    //         'large_bags_capacity' => 'nullable|integer',
    //         'small_bags_capacity' => 'nullable|integer',
    //         'fuel_type' => 'required|string', 
    //         'air_conditioning' => 'required|string|in:Yes,No',
    //         'backup_camera' => 'required|string|in:Yes,No',
    //         'bluetooth' => 'required|string|in:Yes,No',
    //     ], [
    //         'registration_no.unique' => 'This registration number is already registered.',
    //         'transmission_type.required' => 'Transmission type is required.', // Custom error message
    //         'transmission_type.in' => 'The transmission type must be either Automatic or Manual.', // Custom message for invalid values
    //     ]);

    //     // Store car information in the database (CarDetail model)
    //     $car = new CarDetail();
    //     $car->maker = $request->maker;
    //     $car->model = $request->model;
    //     $car->vehicle_type = $request->vehicle_type;
    //     $car->car_condition = $request->car_condition;
    //     $car->mileage = $request->mileage;
    //     $car->price = $request->price;
    //     $car->registration_no = $request->registration_no;
    //     $car->status = $request->status;
    //     $car->description = $request->description;

    //     // Handle new fields
    //     $car->number_of_doors = $request->number_of_doors;
    //     $car->number_of_seats = $request->number_of_seats;
    //     $car->transmission_type = $request->transmission_type;
    //     $car->large_bags_capacity = $request->large_bags_capacity;
    //     $car->small_bags_capacity = $request->small_bags_capacity;
    //     $car->fuel_type = $request->fuel_type;
    //     $car->air_conditioning = $request->air_conditioning;
    //     $car->backup_camera = $request->backup_camera;
    //     $car->bluetooth = $request->bluetooth;

    //     // Initialize $imagePath variable
    //     $imagePath = null;

    //     // Handle image upload
    //     if ($request->hasFile('car_image')) {
    //         $file = $request->file('car_image');
    //         $filename = time() . '.' . $file->getClientOriginalExtension();
    //         $file->move(public_path('uploads/cars'), $filename); // Store in the 'uploads/cars' directory
    //         $imagePath = 'uploads/cars/' . $filename; // Store the path in the DB
    //     }

    //     // Assign the image path to the car record
    //     $car->car_image = $imagePath;

    //     // Assign the car to the logged-in car owner using the correct column: car_owner_id
    //     $car->car_owner_id = auth()->guard('carowner')->id(); // Use car_owner_id to link to the owner

    //     // Save the car record to the database
    //     $car->save();

    //     // Redirect with a success message
    //     return redirect()->route('carowner.rentCar')->with('success', 'Car registered successfully!');
    // }

    public function storeRentCar(Request $request)
    {
        // Validate the input fields
        $request->validate([
            'maker' => 'required|string|max:255',
            'model' => 'required|string|max:255',
            'vehicle_type' => 'required|string',
            'car_condition' => 'required|string',
            'mileage' => 'required|numeric',
            'price' => 'required|numeric',
            'registration_no' => 'required|string|unique:car_details_tbl,registration_no',
            'status' => 'required|string',
            'description' => 'nullable|string',
            'car_images' => 'required|array|min:1', // Ensure at least one image is uploaded
            'car_images.*' => 'image|mimes:jpeg,webp,png,jpg,gif|max:2048', // Validate image formats and size
            'number_of_doors' => 'nullable|integer',
            'number_of_seats' => 'nullable|integer',
            'transmission_type' => 'required|string|in:Automatic,Manual',
            'large_bags_capacity' => 'nullable|integer',
            'small_bags_capacity' => 'nullable|integer',
            'fuel_type' => 'required|string',
            'air_conditioning' => 'required|string|in:Yes,No',
            'backup_camera' => 'required|string|in:Yes,No',
            'bluetooth' => 'required|string|in:Yes,No',
        ], [
            'registration_no.unique' => 'This registration number is already registered.',
            'transmission_type.required' => 'Transmission type is required.',
            'transmission_type.in' => 'The transmission type must be either Automatic or Manual.',
            'car_images.required' => 'Please upload at least one car image.',
            'car_images.*.image' => 'All uploaded files must be images.',
            'car_images.*.mimes' => 'Only jpeg, webp, png, jpg, and gif formats are allowed.',
            'car_images.*.max' => 'Image size should not exceed 2MB.',
        ]);
    
        // Create new CarDetail instance
        $car = new CarDetail();
        $car->maker = $request->maker;
        $car->model = $request->model;
        $car->vehicle_type = $request->vehicle_type;
        $car->car_condition = $request->car_condition;
        $car->mileage = $request->mileage;
        $car->price = $request->price;
        $car->registration_no = $request->registration_no;
        $car->status = $request->status;
        $car->description = $request->description;
    
        // Optional fields
        $car->number_of_doors = $request->number_of_doors;
        $car->number_of_seats = $request->number_of_seats;
        $car->transmission_type = $request->transmission_type;
        $car->large_bags_capacity = $request->large_bags_capacity;
        $car->small_bags_capacity = $request->small_bags_capacity;
        $car->fuel_type = $request->fuel_type;
        $car->air_conditioning = $request->air_conditioning;
        $car->backup_camera = $request->backup_camera;
        $car->bluetooth = $request->bluetooth;
    
        // Assign to authenticated car owner
        $car->car_owner_id = auth()->guard('carowner')->id();
    
        // Save the car record first to get the ID
        $car->save();
    
        // Handle multiple image uploads
        if ($request->hasFile('car_images')) {
            $imagesPaths = []; // Array to store image paths
            
            foreach ($request->file('car_images') as $image) {
                // Generate unique file name for each image
                $filename = time() . '_' . uniqid() . '.' . $image->getClientOriginalExtension();
                $image->move(public_path('uploads/cars'), $filename);
                $imagePath = 'uploads/cars/' . $filename;
                
                // Add image path to the array
                $imagesPaths[] = $imagePath;
                
                // Create a new car image record in the database
                $carImage = new CarImage(); // Assuming you have a CarImage model
                $carImage->car_id = $car->id;
                $carImage->image_path = $imagePath;
                $carImage->save();
            }
            
            // Set the primary image (first image in the array) for the car
            if (!empty($imagesPaths)) {
                $car->car_image = $imagesPaths[0]; // Set the first image as the car's primary image
                $car->save(); // Save the updated car record
            }
        }
    
        // Redirect with a success message
        return redirect()->route('carowner.dashboard')->with('success', 'Car registered successfully!');
    }
    

    // 2.view rented car 
    

    public function viewRentedCar()
    {
        $carowner = Auth::guard('carowner')->user();
    
        // Fetch both rented and pending cars
        $rentedCars = $carowner->cars()->whereIn('status', ['pending', 'rented'])->get();
    
        if ($rentedCars->isEmpty()) {
            return view('CarOwner.view-rented-car')->with('message', 'No rented or pending cars found.');
        }
    
        return view('CarOwner.view-rented-car', compact('rentedCars'));
    }

// car inspection send by admin
    // public function showInspectionMessages()
    // {
    //     $carOwner = Auth::guard('carowner')->user();

    //     // Use the car_detail relationship to get inspections for cars owned by this car owner
    //     $inspectionRequests = InspectionRequest::whereHas('car', function ($query) use ($carOwner) {
    //         $query->where('car_owner_id', $carOwner->id);
    //     })->latest()->get();

    //     return view('CarOwner.inspection-messages', compact('inspectionRequests'));
    // }
    
    public function showInspectionMessages()
{
    $carOwner = Auth::guard('carowner')->user();
    
    // Add this check
    if (!$carOwner) {
        return redirect()->route('carowner.login')->with('error', 'Please login to continue.');
    }
    
    $inspectionRequests = InspectionRequest::whereHas('car', function ($query) use ($carOwner) {
        $query->where('car_owner_id', $carOwner->id);
    })->latest()->get();
    
    return view('CarOwner.inspection-messages', compact('inspectionRequests'));
}


    // inspection cancel by carowner when admin send inspection request to car owner
    public function cancel($id)
{
    // Find the inspection request
    $request = InspectionRequest::findOrFail($id);

    // Check if the request is already canceled
    if ($request->status === 'canceled') {
        return redirect()->back()->with('info', 'This request is already canceled.');
    }

    // Update the status to 'canceled'
    $request->status = 'canceled';
    $request->save();

    return redirect()->back()->with('success', 'Inspection request canceled successfully.');
}

    public function inspectionMessages()
{
    $user = Auth::guard('carowner')->user(); // Make sure to use the correct guard

    if (!$user) {
        return redirect()->route('carowner.login')->with('error', 'You need to be logged in as a Car Owner.');
    }

    // Get inspection requests for the logged-in car owner
    $inspectionRequests = InspectionRequest::where('car_id', $user->id)->get();

    // Check if there are any inspection requests
    if ($inspectionRequests->isEmpty()) {
        return view('CarOwner.inspection-messages', compact('inspectionRequests'))->with('message', 'No inspection requests found.');
    }

    // return view('CarOwner.inspection_requests.redirect-inpection-messagepage', compact('inspectionRequests'));
}


    // public function editdatetime($id)
    // {
    //     $request = InspectionRequest::findOrFail($id);

    //     $allSlots = [
    //         '09:00 AM - 10:00 AM',
    //         '10:30 AM - 11:30 AM',
    //         '11:30 AM - 12:30 AM',
    //         '02:00 PM - 03:00 PM',
    //         '03:15 PM - 04:15 PM',
    //         '04:30 PM - 05:30 PM'
    //     ];

    //     // Get all times already taken for the same inspection date (excluding current one)
    //     $takenSlots = \App\Models\InspectionRequest::where('inspection_date', $request->inspection_date)
    //         ->where('id', '!=', $request->id)
    //         ->pluck('inspection_time')
    //         ->toArray();

    //     // Remove taken slots but keep the current one in case it's in the list
    //     $availableSlots = array_filter($allSlots, function ($slot) use ($takenSlots, $request) {
    //         return $slot == $request->inspection_time || !in_array($slot, $takenSlots);
    //     });

    //     return view('CarOwner.inspection_requests.editdatetime', [
    //         'request' => $request,
    //         'timeSlots' => $availableSlots,
    //     ]);
    // }

    public function editdatetime($id)
{
    $request = InspectionRequest::findOrFail($id);

    // Check if the user already made a request
    if ($request->request_new_date_sent) {
        return redirect()->back()->with('success', 'You have already requested for a new date.');
    }

    // Mark that a request has been sent
    $request->request_new_date_sent = true;
    $request->save();

    $allSlots = [
        '09:00 AM - 10:00 AM',
        '10:30 AM - 11:30 AM',
        '11:30 AM - 12:30 AM',
        '02:00 PM - 03:00 PM',
        '03:15 PM - 04:15 PM',
        '04:30 PM - 05:30 PM'
    ];

    $takenSlots = \App\Models\InspectionRequest::where('inspection_date', $request->inspection_date)
        ->where('id', '!=', $request->id)
        ->pluck('inspection_time')
        ->toArray();

    $availableSlots = array_filter($allSlots, function ($slot) use ($takenSlots, $request) {
        return $slot == $request->inspection_time || !in_array($slot, $takenSlots);
    });

    return view('CarOwner.inspection_requests.editdatetime', [
        'request' => $request,
        'timeSlots' => $availableSlots,
    ]);
}


    // public function updateDateTime(Request $request, $id)
    // {
    //     $request->validate([
    //         'inspection_date' => 'required|date|after_or_equal:today',
    //         'inspection_time' => 'required|string',
    //     ]);

    //     $inspection = InspectionRequest::findOrFail($id);
    //     $inspection->inspection_date = $request->inspection_date;
    //     $inspection->inspection_time = $request->inspection_time;
    //     $inspection->save();

    //     return redirect()->route('CarOwner.inspection-messages')->with('success', 'Inspection schedule updated successfully.');
    // }
    public function updateDateTime(Request $request, $id)
    {
        $request->validate([
            'inspection_date' => 'required|date|after_or_equal:today',
            'inspection_time' => 'required|string',
        ]);

        $inspection = InspectionRequest::findOrFail($id);

        // Check if anything actually changed
        if (
            $inspection->inspection_date !== $request->inspection_date ||
            $inspection->inspection_time !== $request->inspection_time
        ) {
            $inspection->inspection_date = $request->inspection_date;
            $inspection->inspection_time = $request->inspection_time;

            // ✅ Set both flags
            $inspection->request_new_date_sent = true;
            $inspection->date_time_updated = true;

            $inspection->save();

            return redirect()->route('CarOwner.inspection-messages')->with('success', 'Inspection schedule updated successfully.');
        }

        return redirect()->route('CarOwner.inspection-messages')->with('info', 'No changes were made.');
    }


    public function getAvailableTimeSlots(Request $request)
    {
        $date = $request->input('date');
        $id = $request->input('id'); // Current request ID (for edit mode)

        $allSlots = [
            '09:00 AM - 10:00 AM',
            '10:30 AM - 11:30 AM',
            '11:30 AM - 12:30 AM',
            '02:00 PM - 03:00 PM',
            '03:15 PM - 04:15 PM',
            '04:30 PM - 05:30 PM'
        ];

        $takenSlots = \App\Models\InspectionRequest::where('inspection_date', $date)
            ->when($id, fn($q) => $q->where('id', '!=', $id))
            ->pluck('inspection_time')
            ->toArray();

        $availableSlots = array_filter($allSlots, fn($slot) => !in_array($slot, $takenSlots));

        return response()->json(array_values($availableSlots));
    }


    public function accept($id)
    {
        // Find the inspection request
        $request = InspectionRequest::findOrFail($id);

        // Update the status
        $request->request_accepted = true;
        $request->save();

        // Get all admins
        $admins = Admin::all();

        // Loop through each admin and send an email
        foreach ($admins as $admin) {
            Mail::to($admin->email)->send(new InspectionAcceptedNotification($request, $admin->name));
        }

        return redirect()->back()->with('success', 'You have accepted the inspection date and time. Admins have been notified.');
    }

    // for approved car 
    public function showApprovedCars()
{
    $approvedCars = DB::table('car_details_tbl')
        ->join('inspection_requests', 'car_details_tbl.id', '=', 'inspection_requests.car_id')
        ->join('inspection_decisions', 'inspection_requests.id', '=', 'inspection_decisions.inspection_request_id')
        ->where('inspection_decisions.decision', 'approved')
        ->where('car_details_tbl.car_owner_id', auth('carowner')->id())
        ->select('car_details_tbl.*')
        ->get();

    return view('CarOwner.approved-cars', compact('approvedCars'));
}

public function showRejectedCars()
{
    $rejectedCars = DB::table('car_details_tbl')
        ->join('inspection_requests', 'car_details_tbl.id', '=', 'inspection_requests.car_id')
        ->join('inspection_decisions', 'inspection_requests.id', '=', 'inspection_decisions.inspection_request_id')
        ->where('inspection_decisions.decision', 'rejected')
        ->where('car_details_tbl.car_owner_id', auth('carowner')->id())
        ->select('car_details_tbl.*')
        ->get();

    return view('CarOwner.rejected-cars', compact('rejectedCars'));
}








    

}
    