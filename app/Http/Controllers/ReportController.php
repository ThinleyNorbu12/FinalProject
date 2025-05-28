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




    public function carManagementReports()
{
    // Get total registered cars
    $totalRegisteredCars = DB::table('car_details_tbl')->count();
    
    // Get cars by status
    $carsByStatus = DB::table('car_details_tbl')
        ->select('status', DB::raw('count(*) as count'))
        ->groupBy('status')
        ->get();
    
    // Get cars by vehicle type
    $carsByType = DB::table('car_details_tbl')
        ->select('vehicle_type', DB::raw('count(*) as count'))
        ->groupBy('vehicle_type')
        ->get();
    
    // Get cars by maker
    $carsByMaker = DB::table('car_details_tbl')
        ->select('maker', DB::raw('count(*) as count'))
        ->groupBy('maker')
        ->orderBy('count', 'desc')
        ->get();
    
    // Get total inspection requests
    $totalInspectionRequests = DB::table('inspection_requests')->count();
    
    // Get inspection requests by status
    $inspectionsByStatus = DB::table('inspection_requests')
        ->select('status', DB::raw('count(*) as count'))
        ->groupBy('status')
        ->get();
    
    // Get inspection decisions (approved/rejected)
    $inspectionDecisions = DB::table('inspection_decisions')
        ->select('decision', DB::raw('count(*) as count'))
        ->groupBy('decision')
        ->get();
    
    // Get detailed inspection data with car details
    $detailedInspections = DB::table('inspection_requests as ir')
        ->leftJoin('car_details_tbl as cd', 'ir.car_id', '=', 'cd.id')
        ->leftJoin('inspection_decisions as id', 'ir.id', '=', 'id.inspection_request_id')
        ->select(
            'ir.id as request_id',
            'cd.maker',
            'cd.model',
            'cd.registration_no',
            'ir.inspection_date',
            'ir.status as request_status',
            'id.decision',
            'id.remarks',
            'ir.created_at'
        )
        ->orderBy('ir.created_at', 'desc')
        ->get();
    
    // Monthly registration trends (last 12 months)
    $monthlyRegistrations = DB::table('car_details_tbl')
        ->select(
            DB::raw('YEAR(created_at) as year'),
            DB::raw('MONTH(created_at) as month'),
            DB::raw('COUNT(*) as count')
        )
        ->where('created_at', '>=', now()->subMonths(12))
        ->groupBy('year', 'month')
        ->orderBy('year', 'desc')
        ->orderBy('month', 'desc')
        ->get();
    
    // Monthly inspection trends (last 12 months)
    $monthlyInspections = DB::table('inspection_requests')
        ->select(
            DB::raw('YEAR(created_at) as year'),
            DB::raw('MONTH(created_at) as month'),
            DB::raw('COUNT(*) as count')
        )
        ->where('created_at', '>=', now()->subMonths(12))
        ->groupBy('year', 'month')
        ->orderBy('year', 'desc')
        ->orderBy('month', 'desc')
        ->get();
    
    // Get pending approvals count
    $pendingApprovals = DB::table('inspection_requests')
        ->where('status', 'completed')
        ->where('is_confirmed_by_admin', 0)
        ->count();
    
    // Calculate approval rate
    $totalDecisions = DB::table('inspection_decisions')->count();
    $approvedDecisions = DB::table('inspection_decisions')
        ->where('decision', 'approved')
        ->count();
    
    $approvalRate = $totalDecisions > 0 ? round(($approvedDecisions / $totalDecisions) * 100, 2) : 0;
    
    return view('admin.car-management-reports', compact(
        'totalRegisteredCars',
        'carsByStatus',
        'carsByType',
        'carsByMaker',
        'totalInspectionRequests',
        'inspectionsByStatus',
        'inspectionDecisions',
        'detailedInspections',
        'monthlyRegistrations',
        'monthlyInspections',
        'pendingApprovals',
        'approvalRate'
    ));
}
}