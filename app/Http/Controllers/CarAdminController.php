<?php
namespace App\Http\Controllers;

use App\Models\CarDetail; // Ensure you have the correct model namespace
use App\Models\InspectionRequest; // Ensure the InspectionRequest model is imported
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use App\Mail\CarInspectionRequested;
use App\Mail\CarRejected;
use Illuminate\Support\Facades\Log;





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

        // Redirect back with a success message
        return back()->with('success', 'Inspection request submitted and email sent to the car owner.');
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
            '9:00 - 10:00 AM',
            '10:30 - 11:30 AM',
            '11:30 - 12:30 AM',
            '02:00 - 03:00 PM',
            '03:15 - 04:15 PM',
            '04:30 - 05:30 PM'
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

    


}
