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
        public function dashboard()
    {
        // Fetch the authenticated car owner
        $carOwner = Auth::guard('carowner')->user();

        // If no car owner is logged in, redirect to login page
        if (!$carOwner) {
            return redirect()->route('carowner.login');
        }

        // Pass the car owner to the view
        return view('CarOwner.dashboard', compact('carOwner'));
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
    public function storeRentCar(Request $request)
    {
        // Validation logic
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
            'car_image' => 'nullable|image|mimes:jpeg,webp,png,jpg,gif|max:2048',
        ], [
            'registration_no.unique' => 'This registration number is already registered.',
        ]);
        
    
        // Store car information in database (CarDetail model)
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
    
        // Initialize $imagePath variable
        $imagePath = null;
    
        // Handle image upload
        if ($request->hasFile('car_image')) {
            $file = $request->file('car_image');
            $filename = time() . '.' . $file->getClientOriginalExtension();
            $file->move(public_path('uploads/cars'), $filename); // Store in the 'uploads/cars' directory
            $imagePath = 'uploads/cars/' . $filename; // Store the path in the DB
        }
    
        // Assign the image path to the car record
        $car->car_image = $imagePath;
    
        // Assign the car to the logged-in car owner using the correct column: car_owner_id
        $car->car_owner_id = auth()->guard('carowner')->id(); // Use car_owner_id to link to the owner
    
        // Save the car record to the database
        $car->save();
    
        // Redirect with a success message
        return redirect()->route('carowner.rentCar')->with('success', 'Car registered successfully!');
    }
    

}
