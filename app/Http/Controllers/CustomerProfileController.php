<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;
use App\Models\DrivingLicense;
use Carbon\Carbon;
use App\Notifications\LicenseVerificationNotification;
use App\Models\AdminNotification; 
use App\Mail\LicenseVerificationNotification as LicenseVerificationMail;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\File;




class CustomerProfileController extends Controller
{
    public function profile()
    {
        return view('customer.profile');
    }

    public function update(Request $request)
    {
        // Validate the request data
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'phone' => 'nullable|string|max:20',
            'dob' => 'nullable|string',  // Form field name remains 'dob' for simplicity
            'address' => 'nullable|string|max:255',
            'gender' => 'nullable|in:Male,Female,Other', 
        ]);

        $user = Auth::guard('customer')->user();
        
        // Check if email is being changed and if it already exists
        if ($request->email !== $user->email) {
            $existingEmail = \App\Models\Customer::where('email', $request->email)
                ->where('id', '!=', $user->id)
                ->exists();
            
            if ($existingEmail) {
                return redirect()->back()
                    ->with('error', 'The email address is already taken by another account.')
                    ->withInput();
            }
        }

        // Format date if provided
        $dateOfBirth = $request->dob;
        if ($dateOfBirth) {
            try {
                // Convert DD/MM/YYYY to YYYY-MM-DD for database storage
                $dateOfBirth = \Carbon\Carbon::createFromFormat('d/m/Y', $dateOfBirth)->format('Y-m-d');
            } catch (\Exception $e) {
                // If date parsing fails, keep the original value
                $dateOfBirth = $user->date_of_birth;
            }
        }

        // Update the user information
        $user->name = $request->name;
        $user->email = $request->email;
        $user->phone = $request->phone;
        $user->date_of_birth = $dateOfBirth;  // Use the correct column name here
        $user->address = $request->address;
        $user->gender = $request->gender; 
        
        $user->save();

        return redirect()->back()->with('success', 'Profile updated successfully!');
    }
    // public function update(Request $request)
    // {
    //     $request->validate([
    //         'name' => 'required|string|max:255',
    //         'email' => 'required|email|max:255',
    //         'phone' => 'required|string|max:20',
    //         'dob' => 'nullable|string',
    //         'address' => 'nullable|string|max:255',
    //         'gender' => 'nullable|string|in:Male,Female,Other',
    //     ]);

    //     $user = Auth::guard('customer')->user();
        
    //     // Format date if provided
    //     $dob = null;
    //     if ($request->dob) {
    //         try {
    //             $dob = Carbon::createFromFormat('d/m/Y', $request->dob)->format('Y-m-d');
    //         } catch (\Exception $e) {
    //             $dob = $request->dob;
    //         }
    //     }
        
    //     $user->update([
    //         'name' => $request->name,
    //         'email' => $request->email,
    //         'phone' => $request->phone,
    //         'dob' => $dob,
    //         'address' => $request->address,
    //         'gender' => $request->gender,
    //     ]);

    //     return redirect()->back()->with('success', 'Profile updated successfully.');
    // }

    public function saveLicense(Request $request)
    {
        try {
            // Log request data to help with debugging
            \Log::info("License save request received", [
                'has_license_number' => $request->has('license_number'),
                'has_license_dzongkhag' => $request->has('license_dzongkhag'),
                'has_license_issue_date' => $request->has('license_issue_date'),
                'has_license_expiry_date' => $request->has('license_expiry_date'),
                'has_license_front' => $request->hasFile('license_front'),
                'has_license_back' => $request->hasFile('license_back'),
            ]);
    
            $request->validate([
                'license_number' => 'required|string|max:255',
                'license_dzongkhag' => 'required|string|max:255',
                'license_issue_date' => 'required|date_format:d/m/Y',
                'license_expiry_date' => 'required|date_format:d/m/Y|after:license_issue_date',
                'license_front' => 'required|image|mimes:jpeg,png,jpg|max:2048',
                'license_back' => 'required|image|mimes:jpeg,png,jpg|max:2048',
            ]);
    
            $customer = Auth::guard('customer')->user();
            
            // Log customer information
            \Log::info("Customer info:", [
                'id' => $customer->id,
                'name' => $customer->name,
                'email' => $customer->email
            ]);
    
            // Make sure licenses directory exists
            $licensesDir = public_path('licenses');
            if (!file_exists($licensesDir)) {
                mkdir($licensesDir, 0755, true);
                \Log::info("Created licenses directory: {$licensesDir}");
            }
    
            // Handle file uploads with detailed logging
            try {
                $frontPath = $this->uploadLicenseImage($request->file('license_front'));
                $backPath = $this->uploadLicenseImage($request->file('license_back'));
                
                \Log::info("File uploads successful", [
                    'front_path' => $frontPath,
                    'back_path' => $backPath
                ]);
            } catch (\Exception $e) {
                \Log::error("File upload failed: " . $e->getMessage());
                throw new \Exception("Failed to upload license images: " . $e->getMessage());
            }
    
            // Format dates with detailed logging
            try {
                $issueDate = \Carbon\Carbon::createFromFormat('d/m/Y', $request->license_issue_date)->format('Y-m-d');
                $expiryDate = \Carbon\Carbon::createFromFormat('d/m/Y', $request->license_expiry_date)->format('Y-m-d');
                
                \Log::info("Date formatting successful", [
                    'raw_issue_date' => $request->license_issue_date,
                    'formatted_issue_date' => $issueDate,
                    'raw_expiry_date' => $request->license_expiry_date,
                    'formatted_expiry_date' => $expiryDate
                ]);
            } catch (\Exception $e) {
                \Log::error("Date formatting failed: " . $e->getMessage());
                throw new \Exception("Failed to format dates: " . $e->getMessage());
            }
    
            $licenseData = [
                'license_no' => $request->license_number,
                'issuing_dzongkhag' => $request->license_dzongkhag,
                'issue_date' => $issueDate,
                'expiry_date' => $expiryDate,
                'license_front_image' => $frontPath,
                'license_back_image' => $backPath,
                'status' => 'Pending',
            ];
    
            \Log::info("Attempting to save license with data:", $licenseData);
    
            // Check if database has the status column
            try {
                $columns = \Schema::getColumnListing('driving_licenses');
                \Log::info("Table columns:", ['columns' => $columns]);
                
                if (!in_array('status', $columns)) {
                    \Log::error("Status column not found in driving_licenses table");
                    throw new \Exception("The 'status' column does not exist in the 'driving_licenses' table");
                }
            } catch (\Exception $e) {
                \Log::error("Error checking table schema: " . $e->getMessage());
                throw new \Exception("Error checking database schema: " . $e->getMessage());
            }
    
            // Try to create a record directly first to get detailed error
            try {
                // Create or update license
                $license = DrivingLicense::updateOrCreate(
                    ['customer_id' => $customer->id],
                    $licenseData
                );
    
                \Log::info("License saved successfully with ID: " . ($license->id ?? 'Unknown'));
            } catch (\Exception $e) {
                \Log::error("Database save error: " . $e->getMessage());
                \Log::error("SQL: " . \DB::getQueryLog()[count(\DB::getQueryLog())-1]['query'] ?? 'No query logged');
                throw new \Exception("Failed to save to database: " . $e->getMessage());
            }
    
            return back()->with('success', 'License information saved successfully!');
        } catch (\Exception $e) {
            \Log::error("Error saving license: " . $e->getMessage());
            \Log::error($e->getTraceAsString());
            
            return back()
                ->with('error', 'Failed to save license information: ' . $e->getMessage())
                ->withInput();
        }
    }

    
    private function uploadLicenseImage($file)
    {
        $fileName = time() . '_' . uniqid() . '.' . $file->getClientOriginalExtension();
        $file->move(public_path('licenses'), $fileName);
        // Include the 'licenses/' prefix when returning the path
        return 'licenses/' . $fileName;
    }
    // public function showLicenseForm()
    // {
    //     $customer = Auth::guard('customer')->user();
    //     $license = DrivingLicense::where('customer_id', $customer->id)->first();
        
    //     return view('customer.license', compact('license', 'customer'));
    // }
    
    public function showLicenseForm()
    {
        $customer = Auth::guard('customer')->user();
        $license = DrivingLicense::where('customer_id', $customer->id)->first();
        
        // Add debug information if license exists
        if ($license) {
            // Log information about license images
            \Log::info("License data for customer {$customer->id}:", [
                'front_path' => public_path('licenses/' . $license->license_front_image),
                'back_path' => public_path('licenses/' . $license->license_back_image),
                'front_exists' => !empty($license->license_front_image) && file_exists(public_path('licenses/' . $license->license_front_image)),
                'back_exists' => !empty($license->license_back_image) && file_exists(public_path('licenses/' . $license->license_back_image)),
            ]);
        }
        
        return view('customer.license', compact('license', 'customer'));
    }

    public function updateAvatar(Request $request)
    {
        try {
            Log::info('Avatar upload started', ['user_id' => Auth::guard('customer')->id()]);

            // Check if user is authenticated
            $customer = Auth::guard('customer')->user();
            if (!$customer) {
                Log::warning('Unauthenticated avatar upload attempt');
                return response()->json([
                    'success' => false,
                    'message' => 'You must be logged in to upload a profile picture.'
                ], 401);
            }

            // Check if request has file
            if (!$request->hasFile('avatar')) {
                Log::warning('No file in avatar upload request');
                return response()->json([
                    'success' => false,
                    'message' => 'No image file was uploaded.'
                ], 422);
            }

            // Validate the uploaded file
            $validator = Validator::make($request->all(), [
                'avatar' => [
                    'required',
                    'image',
                    'mimes:jpeg,png,jpg,gif',
                    'max:5120', // 5MB max file size
                    'dimensions:min_width=100,min_height=100,max_width=2000,max_height=2000'
                ],
            ]);

            if ($validator->fails()) {
                Log::warning('Avatar validation failed', $validator->errors()->toArray());
                return response()->json([
                    'success' => false,
                    'message' => $validator->errors()->first('avatar')
                ], 422);
            }

            $image = $request->file('avatar');
            
            // Check if file is valid
            if (!$image->isValid()) {
                Log::error('Invalid file uploaded');
                return response()->json([
                    'success' => false,
                    'message' => 'The uploaded file is corrupted or invalid.'
                ], 422);
            }

            // Define the upload directory
            $uploadDirectory = public_path('customerprofile');
            
            // Create directory if it doesn't exist
            if (!File::exists($uploadDirectory)) {
                File::makeDirectory($uploadDirectory, 0755, true);
                Log::info('Created customerprofile directory');
            }

            // Delete old profile image if it exists
            if ($customer->profile_image) {
                $oldImagePath = $uploadDirectory . '/' . $customer->profile_image;
                if (File::exists($oldImagePath)) {
                    File::delete($oldImagePath);
                    Log::info('Deleted old profile image', ['path' => $oldImagePath]);
                }
            }

            // Generate unique filename
            $imageName = 'profile_' . $customer->id . '_' . time() . '.' . $image->getClientOriginalExtension();
            
            // Move the uploaded file to the public directory
            $moved = $image->move($uploadDirectory, $imageName);
            
            if (!$moved) {
                Log::error('Failed to move uploaded image to public directory');
                return response()->json([
                    'success' => false,
                    'message' => 'Failed to save the uploaded image.'
                ], 500);
            }

            // Update customer's profile_image field
            $updated = $customer->update(['profile_image' => $imageName]);
            
            if (!$updated) {
                Log::error('Failed to update customer profile_image in database');
                return response()->json([
                    'success' => false,
                    'message' => 'Failed to update profile in database.'
                ], 500);
            }

            Log::info('Avatar uploaded successfully', [
                'user_id' => $customer->id,
                'filename' => $imageName
            ]);

            return response()->json([
                'success' => true,
                'message' => 'Profile picture updated successfully!',
                'image_url' => asset('customerprofile/' . $imageName)
            ]);

        } catch (\Exception $e) {
            Log::error('Avatar upload exception', [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString(),
                'user_id' => Auth::guard('customer')->id()
            ]);
            
            return response()->json([
                'success' => false,
                'message' => 'An unexpected error occurred. Please try again later.'
            ], 500);
        }
    }



   

    
}