<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class ReportController extends Controller
{
    public function index()
    {
        // Get date range for filtering (default to current month)
        $startDate = request('start_date', Carbon::now()->startOfMonth()->toDateString());
        $endDate = request('end_date', Carbon::now()->endOfMonth()->toDateString());

        // Basic Statistics
        $totalAdminCars = DB::table('admin_cars_tbl')->count();
        $totalOwnerCars = DB::table('car_details_tbl')->count();
        $totalBookings = DB::table('car_bookings')
            ->whereBetween('created_at', [$startDate, $endDate])
            ->count();
        $totalInspections = DB::table('inspection_requests')
            ->whereBetween('created_at', [$startDate, $endDate])
            ->count();

        // Revenue Analysis
        $revenueData = DB::table('car_bookings as cb')
            ->join('admin_cars_tbl as act', 'cb.car_id', '=', 'act.id')
            ->whereBetween('cb.created_at', [$startDate, $endDate])
            ->where('cb.status', 'completed')
            ->selectRaw('
                COUNT(*) as total_bookings,
                SUM(act.price) as total_revenue,
                AVG(act.price) as average_booking_value
            ')
            ->first();

        // Car Status Distribution
        $adminCarStatus = DB::table('admin_cars_tbl')
            ->select('status', DB::raw('count(*) as count'))
            ->groupBy('status')
            ->get();

        $ownerCarStatus = DB::table('car_details_tbl')
            ->select('status', DB::raw('count(*) as count'))
            ->groupBy('status')
            ->get();

        // Most Popular Car Makes/Models
        $popularCars = DB::table('car_bookings as cb')
            ->join('admin_cars_tbl as act', 'cb.car_id', '=', 'act.id')
            ->whereBetween('cb.created_at', [$startDate, $endDate])
            ->select('act.maker', 'act.model', DB::raw('count(*) as booking_count'))
            ->groupBy('act.maker', 'act.model')
            ->orderBy('booking_count', 'desc')
            ->limit(10)
            ->get();

        // Booking Status Distribution
        $bookingStatus = DB::table('car_bookings')
            ->whereBetween('created_at', [$startDate, $endDate])
            ->select('status', DB::raw('count(*) as count'))
            ->groupBy('status')
            ->get();

        // Inspection Status Analysis
        $inspectionStatus = DB::table('inspection_requests')
            ->whereBetween('created_at', [$startDate, $endDate])
            ->select('status', DB::raw('count(*) as count'))
            ->groupBy('status')
            ->get();

        // Monthly Booking Trends
        $monthlyBookings = DB::table('car_bookings')
            ->selectRaw('MONTH(created_at) as month, YEAR(created_at) as year, count(*) as count')
            ->whereYear('created_at', Carbon::now()->year)
            ->groupBy('year', 'month')
            ->orderBy('year', 'asc')
            ->orderBy('month', 'asc')
            ->get();

        // Car Type Analysis
        $carTypeAnalysis = DB::table('admin_cars_tbl')
            ->select('vehicle_type', DB::raw('count(*) as count'), DB::raw('avg(price) as avg_price'))
            ->groupBy('vehicle_type')
            ->get();

        // Recent Activity
        $recentBookings = DB::table('car_bookings as cb')
            ->join('admin_cars_tbl as act', 'cb.car_id', '=', 'act.id')
            ->select('cb.*', 'act.maker', 'act.model', 'act.registration_no')
            ->orderBy('cb.created_at', 'desc')
            ->limit(10)
            ->get();

        $recentInspections = DB::table('inspection_requests as ir')
            ->join('car_details_tbl as cdt', 'ir.car_id', '=', 'cdt.id')
            ->select('ir.*', 'cdt.maker', 'cdt.model', 'cdt.registration_no')
            ->orderBy('ir.created_at', 'desc')
            ->limit(10)
            ->get();

        return view('admin.reports.index', compact(
            'totalAdminCars',
            'totalOwnerCars', 
            'totalBookings',
            'totalInspections',
            'revenueData',
            'adminCarStatus',
            'ownerCarStatus',
            'popularCars',
            'bookingStatus',
            'inspectionStatus',
            'monthlyBookings',
            'carTypeAnalysis',
            'recentBookings',
            'recentInspections',
            'startDate',
            'endDate'
        ));
    }

    public function export(Request $request)
    {
        // This method can be used to export reports to PDF or Excel
        // Implementation depends on your preferred export library
        return response()->json(['message' => 'Export functionality to be implemented']);
    }
}