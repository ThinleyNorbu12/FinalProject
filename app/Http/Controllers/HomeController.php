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
}
