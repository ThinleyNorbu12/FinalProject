<?php

namespace App\Http\Controllers;

use App\Models\AdminCar;
use App\Models\AdminCarImage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class CarController extends Controller
{
    /**
     * Display a listing of the cars
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $cars = AdminCar::with('carImages')->get();
        return view('admin.cars', compact('cars'));
    }

    /**
     * Show the form for creating a new car
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.cars.create');
    }

    /**
     * Store a newly created car in storage
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
{
    try {
        // Validation
        $validator = \Illuminate\Support\Facades\Validator::make($request->all(), [
            'maker' => 'required|string|max:255',
            'model' => 'required|string|max:255',
            'vehicle_type' => 'required|string|max:50',
            'car_condition' => 'required|string|max:50',
            'mileage' => 'required|numeric|min:0',
            'price' => 'required|numeric|min:0',
            'registration_no' => 'required|string|max:50|unique:admin_cars_tbl',
            'status' => 'required|string|max:50',
            'description' => 'nullable|string',
            'number_of_doors' => 'required|integer|min:1',
            'number_of_seats' => 'required|integer|min:1',
            'transmission_type' => 'required|string|max:50',
            'fuel_type' => 'required|string|max:50',
            'large_bags_capacity' => 'nullable|integer|min:0',
            'small_bags_capacity' => 'nullable|integer|min:0',
            'air_conditioning' => 'nullable|string|max:3',
            'backup_camera' => 'nullable|string|max:3',
            'bluetooth' => 'nullable|string|max:3',
            'car_images' => 'required|array|min:1',
            'car_images.*' => 'image|mimes:avif,jpeg,png,jpg,gif,webp|max:2048',
        ]);
        
        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput()
                ->with('error', 'Please fix the following errors:');
        }

        // Create the car record
        $car = new AdminCar();
        $car->maker = $request->maker;
        $car->model = $request->model;
        $car->vehicle_type = $request->vehicle_type;
        $car->car_condition = $request->car_condition;
        $car->mileage = $request->mileage;
        $car->price = $request->price;
        $car->registration_no = $request->registration_no;
        $car->status = $request->status;
        $car->description = $request->description;
        $car->admin_id = Auth::guard('admin')->id();
        $car->number_of_doors = $request->number_of_doors;
        $car->number_of_seats = $request->number_of_seats;
        $car->transmission_type = $request->transmission_type;
        $car->large_bags_capacity = $request->large_bags_capacity;
        $car->small_bags_capacity = $request->small_bags_capacity;
        $car->fuel_type = $request->fuel_type;
        $car->air_conditioning = $request->air_conditioning ?? 'No';
        $car->backup_camera = $request->backup_camera ?? 'No';
        $car->bluetooth = $request->bluetooth ?? 'No';

        // Handle primary image upload
        if ($request->hasFile('car_images') && count($request->car_images) > 0) {
            $primaryImage = $request->file('car_images')[0];
            $primaryImageName = uniqid() . '_' . Str::random(10) . '.' . $primaryImage->getClientOriginalExtension();
            
            // Store in the specific path you want
            $destinationPath = public_path('admincar_images');
            
            // Create directory if it doesn't exist
            if (!file_exists($destinationPath)) {
                mkdir($destinationPath, 0755, true);
            }
            
            $primaryImage->move($destinationPath, $primaryImageName);
            $car->car_image = $primaryImageName;
        }

        // IMPORTANT: Save the car to database
        $car->save();

        // Handle additional images (save after car is saved to get the ID)
        if ($request->hasFile('car_images') && count($request->car_images) > 1) {
            foreach ($request->file('car_images') as $index => $image) {
                if ($index === 0) continue; // Skip primary image

                $imageName = uniqid() . '_' . Str::random(10) . '.' . $image->getClientOriginalExtension();
                $destinationPath = public_path('admincar_images');
                $image->move($destinationPath, $imageName);

                AdminCarImage::create([
                    'car_id' => $car->id,
                    'image_path' => $imageName,
                    'is_primary' => false
                ]);
            }
        }

        return redirect()->route('cars.index')->with('success', 'Car added successfully!');

    } catch (\Exception $e) {
        \Log::error('Failed to add car: ' . $e->getMessage());
        
        return redirect()->back()
            ->with('error', 'An error occurred while adding the car. Please try again.')
            ->withInput();
    }
}  


    /**
     * Display the specified car details
     * 
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $car = AdminCar::with('carImages')->findOrFail($id);
        return view('admin.car-view-details', compact('car'));
    }

    /**
     * Show the form for editing the specified car
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $car = AdminCar::with('carImages')->findOrFail($id);
        return view('admin.car-edit', compact('car'));
    }

    
    // public function edit($id)
    // {
    //     $car = AdminCar::with('additionalImages')->findOrFail($id);
    //     return view('admin.car-edit', compact('car'));
    // }

    /**
     * Update the specified car in storage
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
{
    try {
        $validated = $request->validate([
            'maker' => 'required|string|max:255',
            'model' => 'required|string|max:255',
            'vehicle_type' => 'required|string|max:50',
            'car_condition' => 'required|string|max:50',
            'mileage' => 'required|numeric|min:0',
            'price' => 'required|numeric|min:0',
            'registration_no' => 'required|string|max:50|unique:admin_cars_tbl,registration_no,' . $id,
            'status' => 'required|string|max:50',
            'description' => 'nullable|string',
            'number_of_doors' => 'required|integer|min:1',
            'number_of_seats' => 'required|integer|min:1',
            'transmission_type' => 'required|string|max:50',
            'fuel_type' => 'required|string|max:50',
            'large_bags_capacity' => 'nullable|integer|min:0',
            'small_bags_capacity' => 'nullable|integer|min:0',
            'air_conditioning' => 'nullable|string|max:3',
            'backup_camera' => 'nullable|string|max:3',
            'bluetooth' => 'nullable|string|max:3',
            'car_images' => 'nullable|array',
            'car_images.*' => 'image|mimes:avif,jpeg,png,jpg,gif,webp|max:2048',
        ], [
            'registration_no.required' => 'Registration number is required.',
            'registration_no.unique' => 'This registration number is already in use.',
            'car_images.*.max' => 'Each image must not exceed 2MB in size.',
        ]);

        $car = AdminCar::findOrFail($id);

        // Update car details
        $car->maker = $request->maker;
        $car->model = $request->model;
        $car->vehicle_type = $request->vehicle_type;
        $car->car_condition = $request->car_condition;
        $car->mileage = $request->mileage;
        $car->price = $request->price;
        $car->registration_no = $request->registration_no;
        $car->status = $request->status;
        $car->description = $request->description;
        $car->number_of_doors = $request->number_of_doors;
        $car->number_of_seats = $request->number_of_seats;
        $car->transmission_type = $request->transmission_type;
        $car->large_bags_capacity = $request->large_bags_capacity;
        $car->small_bags_capacity = $request->small_bags_capacity;
        $car->fuel_type = $request->fuel_type;
        $car->air_conditioning = $request->air_conditioning ?? 'No';
        $car->backup_camera = $request->backup_camera ?? 'No';
        $car->bluetooth = $request->bluetooth ?? 'No';

        // Handle new images if provided
        if ($request->hasFile('car_images') && count($request->file('car_images')) > 0) {
            // Create directory if it doesn't exist
            $adminCarPath = public_path('admincar_images');
            if (!file_exists($adminCarPath)) {
                mkdir($adminCarPath, 0755, true);
            }

            // Delete old primary image
            if ($car->car_image) {
                $oldPath = public_path('admincar_images/' . $car->car_image);
                if (file_exists($oldPath)) {
                    unlink($oldPath);
                }
            }

            // Save new primary image
            $primaryImage = $request->file('car_images')[0];
            $primaryImageName = uniqid() . '_' . Str::random(10) . '.' . $primaryImage->getClientOriginalExtension();
            $primaryImage->move($adminCarPath, $primaryImageName);
            $car->car_image = $primaryImageName;

            // Handle additional new images (store in same admincar_images folder)
            if (count($request->file('car_images')) > 1) {
                // Delete old additional images
                AdminCarImage::where('car_id', $car->id)->each(function($carImage) {
                    $oldImagePath = public_path('admincar_images/' . $carImage->image_path);
                    if (file_exists($oldImagePath)) {
                        unlink($oldImagePath);
                    }
                    $carImage->delete();
                });

                // Save new additional images
                for ($i = 1; $i < count($request->file('car_images')); $i++) {
                    $image = $request->file('car_images')[$i];
                    $imageName = uniqid() . '_' . Str::random(10) . '.' . $image->getClientOriginalExtension();
                    $image->move($adminCarPath, $imageName);

                    // Create car image record
                    AdminCarImage::create([
                        'car_id' => $car->id,
                        'image_path' => $imageName,
                        'is_primary' => false
                    ]);
                }
            }
        }

        $car->save();

        return redirect()->route('cars.index')->with('success', 'Car updated successfully!');

    } catch (\Exception $e) {
        \Log::error('Failed to update car: ' . $e->getMessage());
        
        return redirect()->back()
            ->with('error', 'An error occurred while updating the car. Please try again.')
            ->withInput();
    }
}
public function deleteImage(Request $request)
{
    try {
        \Log::info('Delete image request received:', $request->all());
        
        $request->validate([
            'car_id' => 'required|integer',
            'image_type' => 'required|in:primary,additional',
            'image_name' => 'required|string',
            'image_id' => 'nullable|integer'
        ]);

        $carId = $request->car_id;
        $imageType = $request->image_type;
        $imageName = $request->image_name;
        $imageId = $request->image_id;

        $imageDeleted = false;
        $imagePath = public_path('admincar_images/' . $imageName);

        if ($imageType === 'primary') {
            // Delete primary image
            $car = \DB::table('admin_cars_tbl')->where('id', $carId)->first();
            
            if ($car && $car->car_image === $imageName) {
                if (file_exists($imagePath)) {
                    unlink($imagePath);
                }
                
                \DB::table('admin_cars_tbl')->where('id', $carId)->update(['car_image' => null]);
                $imageDeleted = true;
            }
            
        } elseif ($imageType === 'additional' && $imageId) {
            // Delete additional image
            $additionalImage = \DB::table('car_additional_images')->where('id', $imageId)->first();
            
            if ($additionalImage && $additionalImage->image_path === $imageName) {
                if (file_exists($imagePath)) {
                    unlink($imagePath);
                }
                
                \DB::table('car_additional_images')->where('id', $imageId)->delete();
                $imageDeleted = true;
            }
        }

        if ($imageDeleted) {
            return response()->json([
                'success' => true,
                'message' => 'Image deleted successfully!'
            ]);
        } else {
            return response()->json([
                'success' => false,
                'message' => 'Image not found or could not be deleted.'
            ], 404);
        }

    } catch (\Exception $e) {
        \Log::error('Error deleting image:', [
            'message' => $e->getMessage(),
            'request_data' => $request->all()
        ]);
        
        return response()->json([
            'success' => false,
            'message' => 'An error occurred while deleting the image: ' . $e->getMessage()
        ], 500);
    }
}

    /**
     * Remove the specified car from storage
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
        $validated = $request->validate([
            'id' => 'required|exists:admin_cars_tbl,id'
        ]);

        $car = AdminCar::findOrFail($request->id);
        
        // Delete the primary image
        if ($car->car_image) {
            Storage::delete('public/car_images/' . $car->car_image);
        }
        
        // Delete additional images
        foreach ($car->carImages as $carImage) {
            Storage::delete('public/car_images/' . $carImage->image_path);
            $carImage->delete();
        }
        
        // Delete the car record
        $car->delete();
        
        return redirect()->route('cars.index')->with('success', 'Car deleted successfully!');
    }

    /**
     * Get car details for AJAX requests
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function getCarDetails(Request $request)
    {
        $car = AdminCar::with('carImages')->findOrFail($request->id);
        return response()->json($car);
    }

    /**
     * Delete a specific car image
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function deleteCarImage(Request $request)
    {
        $validated = $request->validate([
            'image_id' => 'required|exists:admin_car_images,id'
        ]);

        $carImage = AdminCarImage::findOrFail($request->image_id);
        
        // Delete the image file
        Storage::delete('public/car_images/' . $carImage->image_path);
        
        // Delete the record
        $carImage->delete();
        
        return response()->json(['success' => true]);
    }
}