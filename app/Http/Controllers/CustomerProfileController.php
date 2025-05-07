<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;
use App\Models\DrivingLicense;


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
        
        $user->save();

        return redirect()->back()->with('success', 'Profile updated successfully!');
    }

    public function saveLicense(Request $request)
    {
        $request->validate([
            'license_number' => 'required|string|max:255',
            'license_dzongkhag' => 'required|string|max:255',
            'license_issue_date' => 'required|date_format:d/m/Y',
            'license_expiry_date' => 'required|date_format:d/m/Y|after:license_issue_date',
            'license_front' => 'required|image|mimes:jpeg,png,jpg|max:2048',
            'license_back' => 'required|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        $customer = Auth::guard('customer')->user();

        // Handle file uploads
        $frontPath = $this->uploadLicenseImage($request->file('license_front'));
        $backPath = $this->uploadLicenseImage($request->file('license_back'));

        // Create or update license
        DrivingLicense::updateOrCreate(
            ['customer_id' => $customer->id],
            [
                'license_no' => $request->license_number,
                'issuing_dzongkhag' => $request->license_dzongkhag,
                'issue_date' => \Carbon\Carbon::createFromFormat('d/m/Y', $request->license_issue_date),
                'expiry_date' => \Carbon\Carbon::createFromFormat('d/m/Y', $request->license_expiry_date),
                'license_front_image' => $frontPath,
                'license_back_image' => $backPath,
            ]
        );

        return back()->with('success', 'License information saved successfully!');
    }

    // private function uploadLicenseImage($file)
    // {
    //     $fileName = time() . '_' . uniqid() . '.' . $file->getClientOriginalExtension();
    //     $file->move(public_path('licenses'), $fileName);
    //     return 'licenses/' . $fileName;
    // }
    private function uploadLicenseImage($file)
    {
        $fileName = time() . '_' . uniqid() . '.' . $file->getClientOriginalExtension();
        $file->move(public_path('licenses'), $fileName);
        // Return only the filename without the 'licenses/' prefix since we add it in asset() function
        return $fileName;
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



   

    
}