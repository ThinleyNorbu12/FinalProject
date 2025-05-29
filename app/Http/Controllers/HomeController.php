<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\CarDetail;
use Illuminate\Support\Facades\DB;
use App\Models\AdminCar;
class HomeController extends Controller
{
    
    // public function index()
    // {
    //     $cars = CarDetail::whereHas('inspectionDecision', function($query) {
    //         $query->where('decision', 'approved');
    //     })->latest()->get();

    //     return view('home', compact('cars'));
    // public function index()
    // {
    //     // Get approved cars that don't have confirmed bookings
    //     $cars = CarDetail::whereHas('inspectionDecision', function($query) {
    //         $query->where('decision', 'approved');
    //     })
    //     ->whereDoesntHave('bookings', function($query) {
    //         $query->where('status', 'confirmed');
    //     })
    //     ->latest()
    //     ->get();

    //     return view('home', compact('cars'));
    // }

    //   public function indexAlternative()
    // {
    //     $cars = DB::table('car_details_tbl')
    //         ->whereExists(function ($query) {
    //             $query->select(DB::raw(1))
    //                   ->from('inspection_decisions') // Replace with your actual table name
    //                   ->whereColumn('inspection_decisions.car_id', 'car_details_tbl.id')
    //                   ->where('inspection_decisions.decision', 'approved');
    //         })
    //         ->whereNotExists(function ($query) {
    //             $query->select(DB::raw(1))
    //                   ->from('car_bookings')
    //                   ->whereColumn('car_bookings.car_id', 'car_details_tbl.id')
    //                   ->where('car_bookings.status', 'confirmed');
    //         })
    //         ->orderBy('created_at', 'desc')
    //         ->get();

    //     return view('home', compact('cars'));
    // }

    public function index()
{
    // Get approved cars that don't have confirmed bookings
    $approvedCars = CarDetail::whereHas('inspectionDecision', function($query) {
        $query->where('decision', 'approved');
    })
    ->whereDoesntHave('bookings', function($query) {
        $query->where('status', 'confirmed');
    })
    ->latest()
    ->get()
    ->map(function($car) {
        $car->source = 'regular';
        return $car;
    });

    // Get available admin cars (assuming they don't need approval)
    $adminCars = AdminCar::where('status', 'available')
        ->latest()
        ->get()
        ->map(function($car) {
            $car->source = 'admin';
            return $car;
        });

    // Combine both collections
    $cars = $approvedCars->concat($adminCars);

    return view('home', compact('cars'));
}

// Alternative approach - if you want to pass them separately
public function indexAlternative()
{
    // Get approved cars that don't have confirmed bookings
    $cars = CarDetail::whereHas('inspectionDecision', function($query) {
        $query->where('decision', 'approved');
    })
    ->whereDoesntHave('bookings', function($query) {
        $query->where('status', 'confirmed');
    })
    ->latest()
    ->get();

    // Get available admin cars
    $adminCars = AdminCar::where('status', 'available')
        ->latest()
        ->get();

    return view('home', compact('cars', 'adminCars'));
}


    // }

    // Add this to your CarController.php or relevant controller

    /**
     * Get car details for modal display
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    // public function getCarDetails($id)
    // {
    //     $car = DB::table('car_details_tbl')->where('id', $id)->first();
        
    //     if (!$car) {
    //         return response()->json([
    //             'success' => false,
    //             'message' => 'Car not found'
    //         ], 404);
    //     }
        
    //     // Format the details for the modal
    //     $details = [
    //         'title' => $car->maker . ' ' . $car->model,
    //         'doors' => $car->number_of_doors . ' Doors',
    //         'seats' => $car->number_of_seats . ' Seats',
    //         'ac' => $car->air_conditioning ? 'Air Conditioning' : 'No Air Conditioning',
    //         'transmission' => ucfirst($car->transmission_type),
    //         'largeBags' => $car->large_bags_capacity . ' Large Bags',
    //         'smallBags' => $car->small_bags_capacity . ' Small Bags',
    //         'mpg' => $car->mileage . ' mpg',
    //         'bluetooth' => $car->bluetooth ? 'Bluetooth' : 'No Bluetooth',
    //         'camera' => $car->backup_camera ? 'Backup Camera' : 'No Backup Camera',
    //         'fuelType' => ucfirst($car->fuel_type)
    //     ];
        
    //     return response()->json([
    //         'success' => true,
    //         'details' => $details
    //     ]);
    // }

    //   public function getCarDetails($id)
    // {
    //     $car = DB::table('car_details_tbl')->where('id', $id)->first();
        
    //     if (!$car) {
    //         return response()->json([
    //             'success' => false,
    //             'message' => 'Car not found'
    //         ], 404);
    //     }
        
    //     // Format the details for the modal
    //     $details = [
    //         'title' => $car->maker . ' ' . $car->model,
    //         'doors' => $car->number_of_doors . ' Doors',
    //         'seats' => $car->number_of_seats . ' Seats',
    //         'ac' => $car->air_conditioning ? 'Air Conditioning' : 'No Air Conditioning',
    //         'transmission' => ucfirst($car->transmission_type),
    //         'largeBags' => $car->large_bags_capacity . ' Large Bags',
    //         'smallBags' => $car->small_bags_capacity . ' Small Bags',
    //         'mpg' => $car->mileage . ' mpg',
    //         'bluetooth' => $car->bluetooth ? 'Bluetooth' : 'No Bluetooth',
    //         'camera' => $car->backup_camera ? 'Backup Camera' : 'No Backup Camera',
    //         'fuelType' => ucfirst($car->fuel_type)
    //     ];
        
    //     return response()->json([
    //         'success' => true,
    //         'details' => $details
    //     ]);
    // }
    public function getCarDetails($id)
{
    // First check if it's from regular cars table
    $car = DB::table('car_details_tbl')->where('id', $id)->first();
    $isAdminCar = false;
    
    // If not found, check admin cars table
    if (!$car) {
        $car = DB::table('admin_cars_tbl')->where('id', $id)->first();
        $isAdminCar = true;
    }
    
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
        'fuelType' => ucfirst($car->fuel_type),
        'source' => $isAdminCar ? 'admin' : 'regular'
    ];
    
    return response()->json([
        'success' => true,
        'details' => $details
    ]);
}

    // public function searchCar(Request $request)
    // {
    //     $pickupDate = $request->pickup_date;
    //     $dropoffDate = $request->dropoff_date;

    //     $availableCarsQuery = DB::table('car_details_tbl');

    //     if ($pickupDate && $dropoffDate) {
    //         $availableCarsQuery->whereNotIn('id', function($query) use ($pickupDate, $dropoffDate) {
    //             $query->select('car_id')
    //                 ->from('car_bookings')
    //                 ->where(function ($q) use ($pickupDate, $dropoffDate) {
    //                     $q->where('pickup_date', '<=', $dropoffDate)
    //                     ->where('dropoff_date', '>=', $pickupDate);
    //                 });
    //         });
    //     }

    //     $availableCars = $availableCarsQuery->get();

    //     return view('search_results', compact('availableCars'));
    // }

    // public function searchCar(Request $request)
    // {
    //     $pickupDate = $request->pickup_date;
    //     $dropoffDate = $request->dropoff_date;

    //     $availableCarsQuery = DB::table('car_details_tbl')
    //         ->whereExists(function ($query) {
    //             $query->select(DB::raw(1))
    //                   ->from('inspection_decisions') // Replace with your actual table name
    //                   ->whereColumn('inspection_decisions.car_id', 'car_details_tbl.id')
    //                   ->where('inspection_decisions.decision', 'approved');
    //         });

    //     if ($pickupDate && $dropoffDate) {
    //         $availableCarsQuery->whereNotIn('id', function($query) use ($pickupDate, $dropoffDate) {
    //             $query->select('car_id')
    //                 ->from('car_bookings')
    //                 ->where(function ($q) use ($pickupDate, $dropoffDate) {
    //                     $q->where('pickup_date', '<=', $dropoffDate)
    //                     ->where('dropoff_date', '>=', $pickupDate);
    //                 })
    //                 ->where('status', 'confirmed'); // Only exclude confirmed bookings
    //         });
    //     } else {
    //         // If no dates provided, exclude cars with confirmed bookings
    //         $availableCarsQuery->whereNotExists(function($query) {
    //             $query->select(DB::raw(1))
    //                 ->from('car_bookings')
    //                 ->whereColumn('car_bookings.car_id', 'car_details_tbl.id')
    //                 ->where('car_bookings.status', 'confirmed');
    //         });
    //     }

    //     $availableCars = $availableCarsQuery->get();

    //     return view('search_results', compact('availableCars'));
    // }
    
//     public function searchCar(Request $request)
// {
//     $pickupDate = $request->pickup_date;
//     $dropoffDate = $request->dropoff_date;

//     // Build the query for available cars
//     $availableCarsQuery = DB::table('car_details_tbl')
//         ->whereExists(function ($query) {
//             $query->select(DB::raw(1))
//                   ->from('inspection_decisions')
//                   ->join('inspection_requests', 'inspection_decisions.inspection_request_id', '=', 'inspection_requests.id')
//                   ->whereColumn('inspection_requests.car_id', 'car_details_tbl.id')
//                   ->where('inspection_decisions.decision', 'approved');
//         });

//     if ($pickupDate && $dropoffDate) {
//         // Exclude cars that have overlapping bookings that are confirmed OR completed
//         $availableCarsQuery->whereNotIn('id', function($query) use ($pickupDate, $dropoffDate) {
//             $query->select('car_id')
//                 ->from('car_bookings')
//                 ->where(function ($q) use ($pickupDate, $dropoffDate) {
//                     // If using datetime fields, convert dates to datetime for comparison
//                     $q->where('pickup_datetime', '<=', $dropoffDate . ' 23:59:59')
//                       ->where('dropoff_datetime', '>=', $pickupDate . ' 00:00:00');
//                 })
//                 ->whereIn('status', ['confirmed', 'completed']); // Exclude both confirmed and completed bookings
//         });
//     } else {
//         // If no dates provided, exclude cars with confirmed or completed bookings
//         $availableCarsQuery->whereNotExists(function($query) {
//             $query->select(DB::raw(1))
//                 ->from('car_bookings')
//                 ->whereColumn('car_bookings.car_id', 'car_details_tbl.id')
//                 ->whereIn('car_bookings.status', ['confirmed', 'completed']);
//         });
//     }

//     $availableCars = $availableCarsQuery->get();

//     return view('search_results', compact('availableCars'));
// }

public function searchCar(Request $request)
{
    $pickupDate = $request->pickup_date;
    $dropoffDate = $request->dropoff_date;

    // Query for approved cars from car_details_tbl
    $approvedCarsQuery = DB::table('car_details_tbl')
        ->select([
            'id',
            'maker',
            'model',
            'vehicle_type',
            'car_condition',
            'mileage',
            'price',
            'registration_no',
            'status',
            'description',
            'car_image',
            'car_owner_id',
            'number_of_doors',
            'number_of_seats',
            'transmission_type',
            'large_bags_capacity',
            'small_bags_capacity',
            'fuel_type',
            'air_conditioning',
            'backup_camera',
            'bluetooth',
            'created_at',
            'updated_at',
            DB::raw("'regular' as car_source") // Add source identifier
        ])
        ->whereExists(function ($query) {
            $query->select(DB::raw(1))
                  ->from('inspection_decisions')
                  ->join('inspection_requests', 'inspection_decisions.inspection_request_id', '=', 'inspection_requests.id')
                  ->whereColumn('inspection_requests.car_id', 'car_details_tbl.id')
                  ->where('inspection_decisions.decision', 'approved');
        });

    // Query for all cars from admin_cars_tbl
    $adminCarsQuery = DB::table('admin_cars_tbl')
        ->select([
            'id',
            'maker',
            'model',
            'vehicle_type',
            'car_condition',
            'mileage',
            'price',
            'registration_no',
            'status',
            'description',
            'car_image',
            'admin_id as car_owner_id', // Map admin_id to car_owner_id for consistency
            'number_of_doors',
            'number_of_seats',
            'transmission_type',
            'large_bags_capacity',
            'small_bags_capacity',
            'fuel_type',
            'air_conditioning',
            'backup_camera',
            'bluetooth',
            'created_at',
            'updated_at',
            DB::raw("'admin' as car_source") // Add source identifier
        ])
        ->where('status', 'active'); // Only include active admin cars

    // Apply date filtering if provided
    if ($pickupDate && $dropoffDate) {
        // Filter approved cars
        $approvedCarsQuery->whereNotIn('id', function($query) use ($pickupDate, $dropoffDate) {
            $query->select('car_id')
                ->from('car_bookings')
                ->where(function ($q) use ($pickupDate, $dropoffDate) {
                    $q->where('pickup_datetime', '<=', $dropoffDate . ' 23:59:59')
                      ->where('dropoff_datetime', '>=', $pickupDate . ' 00:00:00');
                })
                ->whereIn('status', ['confirmed', 'completed']);
        });

        // For admin cars, we'll assume they use a separate booking system or identifier
        // You might need to adjust this based on your actual booking table structure
        $adminCarsQuery->whereNotIn('id', function($query) use ($pickupDate, $dropoffDate) {
            $query->select('car_id')
                ->from('car_bookings')
                ->where(function ($q) use ($pickupDate, $dropoffDate) {
                    $q->where('pickup_datetime', '<=', $dropoffDate . ' 23:59:59')
                      ->where('dropoff_datetime', '>=', $pickupDate . ' 00:00:00');
                })
                ->whereIn('status', ['confirmed', 'completed']);
        });
    } else {
        // Filter approved cars without dates
        $approvedCarsQuery->whereNotExists(function($query) {
            $query->select(DB::raw(1))
                ->from('car_bookings')
                ->whereColumn('car_bookings.car_id', 'car_details_tbl.id')
                ->whereIn('car_bookings.status', ['confirmed', 'completed']);
        });

        // Filter admin cars without dates
        $adminCarsQuery->whereNotExists(function($query) {
            $query->select(DB::raw(1))
                ->from('car_bookings')
                ->whereColumn('car_bookings.car_id', 'admin_cars_tbl.id')
                ->whereIn('car_bookings.status', ['confirmed', 'completed']);
        });
    }

    // Get the results
    $approvedCars = $approvedCarsQuery->get();
    $adminCars = $adminCarsQuery->get();

    // Combine both collections
    $availableCars = $approvedCars->concat($adminCars);

    // Add additional properties for display
    $availableCars = $availableCars->map(function($car) {
        // Determine display type based on source and booking history
        if ($car->car_source === 'admin') {
            $car->display_type = 'admin';
        } else {
            // Check if car has completed bookings
            $hasCompletedBooking = DB::table('car_bookings')
                ->where('car_id', $car->id)
                ->where('status', 'completed')
                ->exists();
            
            $car->display_type = $hasCompletedBooking ? 'completed' : 'approved';
        }
        
        return $car;
    });

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
    // public function showAvailableCars(Request $request)
    // {
    //     // Fetch cars from the database (or perform your own logic)
    //     $availableCars = CarDetail::all(); // Example, replace with your actual query

    //     // Pass the available cars and the dates from the query parameters to the view
    //     return view('search_results', [
    //         'availableCars' => $availableCars,
    //         'pickupDate' => $request->pickup_date,  // Pass the pickup date
    //         'dropoffDate' => $request->dropoff_date,  // Pass the dropoff date
    //     ]);
    // }
    //  public function showAvailableCars(Request $request)
    // {
    //     // Fetch cars that are approved and don't have confirmed bookings
    //     $availableCars = CarDetail::whereHas('inspectionDecision', function($query) {
    //         $query->where('decision', 'approved');
    //     })
    //     ->whereDoesntHave('bookings', function($query) {
    //         $query->where('status', 'confirmed');
    //     })
    //     ->get();

    //     // Pass the available cars and the dates from the query parameters to the view
    //     return view('search_results', [
    //         'availableCars' => $availableCars,
    //         'pickupDate' => $request->pickup_date,  // Pass the pickup date
    //         'dropoffDate' => $request->dropoff_date,  // Pass the dropoff date
    //     ]);
    // }
    public function showAvailableCars(Request $request)
{
    // Fetch regular approved cars
    $regularCars = CarDetail::whereHas('inspectionDecision', function($query) {
        $query->where('decision', 'approved');
    })
    ->whereDoesntHave('bookings', function($query) {
        $query->where('status', 'confirmed');
    })
    ->get()
    ->map(function($car) {
        $car->source = 'regular';
        return $car;
    });

    // Fetch admin cars
    $adminCars = AdminCar::where('status', 'available')
        ->get()
        ->map(function($car) {
            $car->source = 'admin';
            return $car;
        });

    // Combine both collections
    $availableCars = $regularCars->concat($adminCars);

    // Pass the available cars and the dates from the query parameters to the view
    return view('search_results', [
        'availableCars' => $availableCars,
        'pickupDate' => $request->pickup_date,
        'dropoffDate' => $request->dropoff_date,
    ]);
}


    // when i click on Book Now buotton in home.blade.php

    // public function book($id)
    // {
    //     $car = CarDetail::findOrFail($id);
    //     return view('cars.book', compact('car')); // Make sure this view exists
    // }
    // public function book($id)
    // {
    //     $car = CarDetail::findOrFail($id);
        
    //     // Check if car has confirmed booking before allowing booking
    //     $hasConfirmedBooking = DB::table('car_bookings')
    //         ->where('car_id', $id)
    //         ->where('status', 'confirmed')
    //         ->exists();
            
    //     if ($hasConfirmedBooking) {
    //         return redirect()->back()->with('error', 'This car is currently not available for booking.');
    //     }
        
    //     return view('cars.book', compact('car')); // Make sure this view exists
    // }
    public function book($id)
{
    $car = CarDetail::findOrFail($id);
    
    // Check if car has confirmed booking before allowing booking
    $hasConfirmedBooking = DB::table('car_bookings')
        ->where('car_id', $id)
        ->where('status', 'confirmed')
        ->exists();
        
    if ($hasConfirmedBooking) {
        return redirect()->back()->with('error', 'This car is currently not available for booking.');
    }
    
    // Add source identifier for the view
    $car->source = 'regular';
    
    return view('cars.book', compact('car'));
}

public function bookAdminCar($id)
{
    $car = AdminCar::findOrFail($id);
    
    // Check if admin car is available
    if ($car->status !== 'available') {
        return redirect()->back()->with('error', 'This car is currently not available for booking.');
    }
    
    // Add source identifier for the view
    $car->source = 'admin';
    
    return view('cars.book', compact('car'));
}


    public function show($id)
{
    $car = CarDetail::with('images')->findOrFail($id);
    return view('cars.book', compact('car'));
}





}
