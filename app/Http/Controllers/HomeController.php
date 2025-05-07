<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\CarDetail;
use Illuminate\Support\Facades\DB;

class HomeController extends Controller
{
    
    // public function index()
    // {
    //     $cars = CarDetail::latest()->get(); // Fetch the registered cars
    //     return view('home', compact('cars'));
    // }

    public function index()
    {
        $cars = CarDetail::whereHas('inspectionDecision', function($query) {
            $query->where('decision', 'approved');
        })->latest()->get();

        return view('home', compact('cars'));


    }

    // Add this to your CarController.php or relevant controller

    /**
     * Get car details for modal display
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function getCarDetails($id)
    {
        $car = DB::table('car_details_tbl')->where('id', $id)->first();
        
        if (!$car) {
            return response()->json([
                'success' => false,
                'message' => 'Car not found'
            ], 404);
        }
        
        // Format the details for the modal
        $details = [
            'title' => $car->maker . ' ' . $car->model,
            'doors' => $car->number_of_doors . ' Doors',
            'seats' => $car->number_of_seats . ' Seats',
            'ac' => $car->air_conditioning ? 'Air Conditioning' : 'No Air Conditioning',
            'transmission' => ucfirst($car->transmission_type),
            'largeBags' => $car->large_bags_capacity . ' Large Bags',
            'smallBags' => $car->small_bags_capacity . ' Small Bags',
            'mpg' => $car->mileage . ' mpg',
            'bluetooth' => $car->bluetooth ? 'Bluetooth' : 'No Bluetooth',
            'camera' => $car->backup_camera ? 'Backup Camera' : 'No Backup Camera',
            'fuelType' => ucfirst($car->fuel_type)
        ];
        
        return response()->json([
            'success' => true,
            'details' => $details
        ]);
    }

    public function searchCar(Request $request)
    {
        $pickupDate = $request->pickup_date;
        $dropoffDate = $request->dropoff_date;

        $availableCarsQuery = DB::table('car_details_tbl');

        if ($pickupDate && $dropoffDate) {
            $availableCarsQuery->whereNotIn('id', function($query) use ($pickupDate, $dropoffDate) {
                $query->select('car_id')
                    ->from('car_bookings')
                    ->where(function ($q) use ($pickupDate, $dropoffDate) {
                        $q->where('pickup_date', '<=', $dropoffDate)
                        ->where('dropoff_date', '>=', $pickupDate);
                    });
            });
        }

        $availableCars = $availableCarsQuery->get();

        return view('search_results', compact('availableCars'));
    }

// Method to set pickup and dropoff dates
    public function setDates(Request $request)
    {
        // Redirect to the available cars page with the pickup and dropoff dates as query parameters
        return redirect()->route('available.cars', [
            'pickup_date' => $request->pickup_date,
            'dropoff_date' => $request->dropoff_date,
        ]);
    }

    // Method to show available cars
    public function showAvailableCars(Request $request)
    {
        // Fetch cars from the database (or perform your own logic)
        $availableCars = CarDetail::all(); // Example, replace with your actual query

        // Pass the available cars and the dates from the query parameters to the view
        return view('search_results', [
            'availableCars' => $availableCars,
            'pickupDate' => $request->pickup_date,  // Pass the pickup date
            'dropoffDate' => $request->dropoff_date,  // Pass the dropoff date
        ]);
    }


    // when i click on Book Now buotton in home.blade.php

    public function book($id)
    {
        $car = CarDetail::findOrFail($id);
        return view('cars.book', compact('car')); // Make sure this view exists
    }


    public function show($id)
{
    $car = CarDetail::with('images')->findOrFail($id);
    return view('cars.book', compact('car'));
}





}
