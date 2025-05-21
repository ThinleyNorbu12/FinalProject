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
            // Note: We're not putting validation in the try block
            // since we want validation errors to be handled separately
        
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
            ],
            [
                'maker.required' => 'The car maker is required.',
                'model.required' => 'The car model is required.',
                'vehicle_type.required' => 'The vehicle type is required.',
                'car_condition.required' => 'The car condition is required.',
                'mileage.required' => 'The mileage is required.',
                'mileage.numeric' => 'The mileage must be a number.',
                'price.required' => 'The price is required.',
                'price.numeric' => 'The price must be a number.',
                'registration_no.required' => 'Registration number is required.',
                'registration_no.unique' => 'This registration number is already in use.',
                'number_of_doors.required' => 'Number of doors is required.',
                'number_of_seats.required' => 'Number of seats is required.',
                'transmission_type.required' => 'Transmission type is required.',
                'fuel_type.required' => 'Fuel type is required.',
                'car_images.required' => 'At least one car image is required.',
                'car_images.min' => 'At least one car image is required.',
                'car_images.*.image' => 'Uploaded files must be images.',
                'car_images.*.max' => 'Each image must not exceed 2MB in size.',
            ]);
            
            if ($validator->fails()) {
                return redirect()->back()
                    ->withErrors($validator)
                    ->withInput()
                    ->with('error', 'Please fix the following errors:');
            }
            
            $validated = $validator->validated();
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

            // Handle primary image
            if ($request->hasFile('car_images') && count($request->car_images) > 0) {
                $primaryImage = $request->file('car_images')[0];
                $primaryImageName = uniqid() . '_' . Str::random(10) . '.' . $primaryImage->getClientOriginalExtension();
                $primaryImage->storeAs('public/admincar_images', $primaryImageName);
                $car->car_image = $primaryImageName;
            }

            $car->save();

            // Handle additional images
            if ($request->hasFile('car_images')) {
                foreach ($request->file('car_images') as $index => $image) {
                    if ($index === 0) continue;

                    $imageName = uniqid() . '_' . Str::random(10) . '.' . $image->getClientOriginalExtension();
                    $image->storeAs('public/admincar_images', $imageName);

                    AdminCarImage::create([
                        'car_id' => $car->id,
                        'image_path' => $imageName,
                        'is_primary' => false
                    ]);
                }
            }

            return redirect()->route('cars.index')->with('success', 'Car added successfully!');
        } catch (\Illuminate\Database\QueryException $e) {
            // Handle database errors
            \Log::error('Database error while adding car: ' . $e->getMessage());
            
            // Check for foreign key constraint failures
            if (strpos($e->getMessage(), 'foreign key constraint fails') !== false) {
                return redirect()->back()
                    ->with('error', 'Failed to add car: One or more related records do not exist.')
                    ->withInput();
            }
            
            // Check for duplicate entry
            if (strpos($e->getMessage(), 'Duplicate entry') !== false) {
                return redirect()->back()
                    ->with('error', 'Failed to add car: A duplicate entry was detected. Please check registration number.')
                    ->withInput();
            }
            
            return redirect()->back()
                ->with('error', 'Database error occurred. Please contact support.')
                ->withInput();
                
        } catch (\Illuminate\Http\Exceptions\PostTooLargeException $e) {
            // Handle file upload size errors
            \Log::error('File too large: ' . $e->getMessage());
            return redirect()->back()
                ->with('error', 'Failed to add car: The uploaded files are too large. Maximum size is ' . 
                       ini_get('upload_max_filesize') . '.')
                ->withInput();
                
        } catch (\Illuminate\Http\Exceptions\ThrottleRequestsException $e) {
            // Handle throttling/rate limiting
            \Log::error('Request throttled: ' . $e->getMessage());
            return redirect()->back()
                ->with('error', 'Too many requests. Please try again after a few minutes.')
                ->withInput();
                
        } catch (\Exception $e) {
            // Log the error with stack trace for better debugging
            \Log::error('Failed to add car: ' . $e->getMessage(), [
                'file' => $e->getFile(),
                'line' => $e->getLine(),
                'trace' => $e->getTraceAsString()
            ]);
            
            // Return with more specific error message when possible
            $errorMessage = 'An unexpected error occurred. ';
            
            // Add some specific error handling for common issues
            if (strpos($e->getMessage(), 'permission denied') !== false) {
                $errorMessage .= 'Permission denied while saving files. ';
            } elseif (strpos($e->getMessage(), 'disk full') !== false) {
                $errorMessage .= 'Server storage is full. ';
            } elseif (strpos($e->getMessage(), 'timeout') !== false) {
                $errorMessage .= 'Server connection timed out. ';
            }
            
            $errorMessage .= 'Please try again or contact support.';
            
            return redirect()->back()
                ->with('error', $errorMessage)
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
        return view('admin.cars.show', compact('car'));
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
        return view('admin.cars.edit', compact('car'));
    }

    /**
     * Update the specified car in storage
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        $validated = $request->validate([
            'id' => 'required|exists:admin_cars_tbl,id',
            'maker' => 'required|string|max:255',
            'model' => 'required|string|max:255',
            'vehicle_type' => 'required|string|max:50',
            'car_condition' => 'required|string|max:50',
            'mileage' => 'required|numeric|min:0',
            'price' => 'required|numeric|min:0',
            'registration_no' => 'required|string|max:50|unique:admin_cars_tbl,registration_no,' . $request->id,
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

        $car = AdminCar::findOrFail($request->id);

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

        // Handle new primary image if provided
        if ($request->hasFile('car_images') && count($request->file('car_images')) > 0) {

            // Create directories if they don't exist
            $adminCarPath = public_path('admincar_images');
            $carImagesPath = public_path('car_images');
            if (!File::exists($adminCarPath)) File::makeDirectory($adminCarPath, 0755, true);
            if (!File::exists($carImagesPath)) File::makeDirectory($carImagesPath, 0755, true);

            // Delete old primary image
            if ($car->car_image) {
                $oldPath = public_path('admincar_images/' . $car->car_image);
                if (File::exists($oldPath)) {
                    File::delete($oldPath);
                }
            }

            // Save new primary image
            $primaryImage = $request->file('car_images')[0];
            $primaryImageName = time() . '_' . Str::random(10) . '.' . $primaryImage->getClientOriginalExtension();
            $primaryImage->move($adminCarPath, $primaryImageName);
            $car->car_image = $primaryImageName;

            // Handle additional new images
            if (count($request->file('car_images')) > 1) {
                for ($i = 1; $i < count($request->file('car_images')); $i++) {
                    $image = $request->file('car_images')[$i];
                    $imageName = time() . '_' . Str::random(10) . '.' . $image->getClientOriginalExtension();
                    $image->move($carImagesPath, $imageName);

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