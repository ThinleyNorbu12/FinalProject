<?php
namespace App\Http\Controllers;

use App\Models\CarDetail; // Ensure you have the correct model namespace
use App\Models\InspectionRequest; // Ensure the InspectionRequest model is imported
use Illuminate\Http\Request;

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

    // Method to show the request inspection form
    // public function requestInspection($id)
    // {
    //     $car = Car::findOrFail($id); // Find the car by ID
    //     return view('admin.request-inspection', compact('car'));
    // }
    public function requestInspection($carId)
    {
        // Find the car by its ID
        $car = Car::findOrFail($carId);

        // Add logic to mark the car for inspection
        $car->inspection_requested = true; // Assuming there's a column to track this
        $car->save();

        // Redirect back with a success message
        return redirect()->route('admin.car.show', $carId) // Adjust this route name to match your setup
                         ->with('success', 'Inspection has been requested for the car.');
    }

    // Method to handle the inspection request submission
    public function submitInspectionRequest(Request $request, $id)
    {
        // Handle the inspection request logic here
        return redirect()->back()->with('success', 'Inspection request submitted successfully!');
    }
}
