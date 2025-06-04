<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\CarDetail;
use Illuminate\Support\Facades\DB;

class RecordMileageController extends Controller
{
    public function index()
    {
        $cars = CarDetail::select('car_details_tbl.id', 'car_details_tbl.registration_no', 'car_details_tbl.maker', 'car_details_tbl.model', 'car_details_tbl.mileage', 'car_details_tbl.start_mileage', 'car_details_tbl.end_mileage', 'car_details_tbl.status')
                         ->join('inspection_requests', 'car_details_tbl.id', '=', 'inspection_requests.car_id')
                         ->join('inspection_decisions', 'inspection_requests.id', '=', 'inspection_decisions.inspection_request_id')
                         ->where('inspection_decisions.decision', 'approved')
                         ->orderBy('car_details_tbl.registration_no')
                         ->paginate(15);
        
        return view('admin.record-mileage.index', compact('cars'));
    }

    public function create()
    {
        $cars = CarDetail::select('car_details_tbl.id', 'car_details_tbl.registration_no', 'car_details_tbl.maker', 'car_details_tbl.model', 'car_details_tbl.mileage')
                         ->join('inspection_requests', 'car_details_tbl.id', '=', 'inspection_requests.car_id')
                         ->join('inspection_decisions', 'inspection_requests.id', '=', 'inspection_decisions.inspection_request_id')
                         ->where('inspection_decisions.decision', 'approved')
                         ->orderBy('car_details_tbl.registration_no')
                         ->get();
        
        return view('admin.record-mileage.create', compact('cars'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'car_id' => 'required|exists:car_details_tbl,id',
            'mileage_type' => 'required|in:current,start,end',
            'mileage_value' => 'required|numeric|min:0',
            'recording_date' => 'required|date|before_or_equal:today',
            'notes' => 'nullable|string|max:500'
        ]);

        $car = CarDetail::findOrFail($request->car_id);
        
        // Validation based on mileage type
        if ($request->mileage_type === 'current') {
            if ($car->start_mileage && $request->mileage_value < $car->start_mileage) {
                return back()->withErrors(['mileage_value' => 'Current mileage cannot be less than start mileage.']);
            }
        } elseif ($request->mileage_type === 'end') {
            if ($car->start_mileage && $request->mileage_value < $car->start_mileage) {
                return back()->withErrors(['mileage_value' => 'End mileage cannot be less than start mileage.']);
            }
            if ($car->mileage && $request->mileage_value < $car->mileage) {
                return back()->withErrors(['mileage_value' => 'End mileage cannot be less than current mileage.']);
            }
        }

        // Update the appropriate mileage field
        switch ($request->mileage_type) {
            case 'current':
                $car->mileage = $request->mileage_value;
                break;
            case 'start':
                $car->start_mileage = $request->mileage_value;
                break;
            case 'end':
                $car->end_mileage = $request->mileage_value;
                break;
        }

        $car->save();

        return redirect()->route('car-admin.record-mileage')
                        ->with('success', 'Mileage recorded successfully for ' . $car->registration_no);
    }

    public function edit($id)
    {
        $car = CarDetail::findOrFail($id);
        return view('admin.record-mileage.edit', compact('car'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'mileage' => 'nullable|numeric|min:0',
            'start_mileage' => 'nullable|numeric|min:0',
            'end_mileage' => 'nullable|numeric|min:0',
        ]);

        $car = CarDetail::findOrFail($id);
        
        // Validation logic
        if ($request->start_mileage && $request->mileage && $request->mileage < $request->start_mileage) {
            return back()->withErrors(['mileage' => 'Current mileage cannot be less than start mileage.']);
        }
        
        if ($request->start_mileage && $request->end_mileage && $request->end_mileage < $request->start_mileage) {
            return back()->withErrors(['end_mileage' => 'End mileage cannot be less than start mileage.']);
        }

        $car->update([
            'mileage' => $request->mileage,
            'start_mileage' => $request->start_mileage,
            'end_mileage' => $request->end_mileage,
        ]);

        return redirect()->route('car-admin.record-mileage')
                        ->with('success', 'Mileage updated successfully for ' . $car->registration_no);
    }

    public function search(Request $request)
    {
        $query = CarDetail::select('car_details_tbl.id', 'car_details_tbl.registration_no', 'car_details_tbl.maker', 'car_details_tbl.model', 'car_details_tbl.mileage', 'car_details_tbl.start_mileage', 'car_details_tbl.end_mileage', 'car_details_tbl.status')
                          ->join('inspection_requests', 'car_details_tbl.id', '=', 'inspection_requests.car_id')
                          ->join('inspection_decisions', 'inspection_requests.id', '=', 'inspection_decisions.inspection_request_id')
                          ->where('inspection_decisions.decision', 'approved');

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('car_details_tbl.registration_no', 'LIKE', "%{$search}%")
                  ->orWhere('car_details_tbl.maker', 'LIKE', "%{$search}%")
                  ->orWhere('car_details_tbl.model', 'LIKE', "%{$search}%");
            });
        }

        $cars = $query->orderBy('car_details_tbl.registration_no')->paginate(15);
        
        return view('admin.record-mileage.index', compact('cars'));
    }
}