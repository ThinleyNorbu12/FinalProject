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

    // Basic Statistics (keep existing code)
    $totalAdminCars = DB::table('admin_cars_tbl')->count();
    $totalOwnerCars = DB::table('car_details_tbl')->count();
    $totalBookings = DB::table('car_bookings')
        ->whereBetween('created_at', [$startDate, $endDate])
        ->count();
    $totalInspections = DB::table('inspection_requests')
        ->whereBetween('created_at', [$startDate, $endDate])
        ->count();

    // UPDATED: Revenue Analysis from Payments Table
    $revenueData = DB::table('payments as p')
        ->join('car_bookings as cb', 'p.booking_id', '=', 'cb.id')
        ->whereBetween('p.payment_date', [$startDate, $endDate])
        ->where('p.status', 'completed') // or 'success' depending on your status values
        ->selectRaw('
            COUNT(*) as total_bookings,
            SUM(p.amount) as total_revenue,
            AVG(p.amount) as average_booking_value,
            COUNT(DISTINCT p.payment_method) as payment_methods_used
        ')
        ->first();

    // Payment Method Analysis
    $paymentMethodAnalysis = DB::table('payments')
        ->whereBetween('payment_date', [$startDate, $endDate])
        ->where('status', 'completed')
        ->select('payment_method', DB::raw('count(*) as count'), DB::raw('sum(amount) as total_amount'))
        ->groupBy('payment_method')
        ->get();

    // Currency-wise Revenue (if you support multiple currencies)
    $currencyRevenue = DB::table('payments')
        ->whereBetween('payment_date', [$startDate, $endDate])
        ->where('status', 'completed')
        ->select('currency', DB::raw('sum(amount) as total_amount'), DB::raw('count(*) as count'))
        ->groupBy('currency')
        ->get();

    // Payment Status Distribution
    $paymentStatus = DB::table('payments')
        ->whereBetween('payment_date', [$startDate, $endDate])
        ->select('status', DB::raw('count(*) as count'), DB::raw('sum(amount) as amount'))
        ->groupBy('status')
        ->get();

    // Monthly Revenue Trends
    $monthlyRevenue = DB::table('payments')
        ->whereYear('payment_date', Carbon::now()->year)
        ->where('status', 'completed')
        ->selectRaw('
            MONTH(payment_date) as month, 
            YEAR(payment_date) as year, 
            sum(amount) as total_revenue,
            count(*) as transaction_count
        ')
        ->groupBy('year', 'month')
        ->orderBy('year', 'asc')
        ->orderBy('month', 'asc')
        ->get();

    // Daily Revenue for Current Month
    $dailyRevenue = DB::table('payments')
        ->whereMonth('payment_date', Carbon::now()->month)
        ->whereYear('payment_date', Carbon::now()->year)
        ->where('status', 'completed')
        ->selectRaw('
            DAY(payment_date) as day,
            sum(amount) as daily_revenue,
            count(*) as daily_transactions
        ')
        ->groupBy('day')
        ->orderBy('day', 'asc')
        ->get();

    // Recent Payments
    $recentPayments = DB::table('payments as p')
        ->join('car_bookings as cb', 'p.booking_id', '=', 'cb.id')
        ->join('admin_cars_tbl as act', 'cb.car_id', '=', 'act.id')
        ->select(
            'p.id',
            'p.reference_number',
            'p.amount',
            'p.currency',
            'p.payment_method',
            'p.status',
            'p.payment_date',
            'cb.pickup_datetime',
            'cb.dropoff_datetime',
            'cb.pickup_location',
            'cb.dropoff_location',
            'cb.status as booking_status',
            'act.maker',
            'act.model',
            'act.registration_no'
        )
        ->orderBy('p.payment_date', 'desc')
        ->limit(10)
        ->get();

    // Failed Payments Analysis
    $failedPayments = DB::table('payments')
        ->whereBetween('payment_date', [$startDate, $endDate])
        ->where('status', 'failed')
        ->selectRaw('
            count(*) as failed_count,
            sum(amount) as lost_revenue
        ')
        ->first();

    // Car Status Distribution (from your original code)
    $adminCarStatus = DB::table('admin_cars_tbl')
        ->select('status', DB::raw('count(*) as count'))
        ->groupBy('status')
        ->get();

    $ownerCarStatus = DB::table('car_details_tbl')
        ->select('status', DB::raw('count(*) as count'))
        ->groupBy('status')
        ->get();

    // Most Popular Car Makes/Models (from your original code)
    $popularCars = DB::table('car_bookings as cb')
        ->join('admin_cars_tbl as act', 'cb.car_id', '=', 'act.id')
        ->whereBetween('cb.created_at', [$startDate, $endDate])
        ->select('act.maker', 'act.model', DB::raw('count(*) as booking_count'))
        ->groupBy('act.maker', 'act.model')
        ->orderBy('booking_count', 'desc')
        ->limit(10)
        ->get();

    // Booking Status Distribution (from your original code)
    $bookingStatus = DB::table('car_bookings')
        ->whereBetween('created_at', [$startDate, $endDate])
        ->select('status', DB::raw('count(*) as count'))
        ->groupBy('status')
        ->get();

    // Inspection Status Analysis (from your original code)
    $inspectionStatus = DB::table('inspection_requests')
        ->whereBetween('created_at', [$startDate, $endDate])
        ->select('status', DB::raw('count(*) as count'))
        ->groupBy('status')
        ->get();

    // Monthly Booking Trends (from your original code)
    $monthlyBookings = DB::table('car_bookings')
        ->selectRaw('MONTH(created_at) as month, YEAR(created_at) as year, count(*) as count')
        ->whereYear('created_at', Carbon::now()->year)
        ->groupBy('year', 'month')
        ->orderBy('year', 'asc')
        ->orderBy('month', 'asc')
        ->get();

    // Car Type Analysis (from your original code)
    $carTypeAnalysis = DB::table('admin_cars_tbl')
        ->select('vehicle_type', DB::raw('count(*) as count'), DB::raw('avg(price) as avg_price'))
        ->groupBy('vehicle_type')
        ->get();

    // Recent Bookings (from your original code)
    $recentBookings = DB::table('car_bookings as cb')
        ->join('admin_cars_tbl as act', 'cb.car_id', '=', 'act.id')
        ->select('cb.*', 'act.maker', 'act.model', 'act.registration_no')
        ->orderBy('cb.created_at', 'desc')
        ->limit(10)
        ->get();

    // Recent Inspections (from your original code)
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
        'paymentMethodAnalysis',
        'currencyRevenue',
        'paymentStatus',
        'monthlyRevenue',
        'dailyRevenue',
        'recentPayments',
        'failedPayments',
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

// Additional method for detailed payment analytics
public function paymentAnalytics()
{
    $startDate = request('start_date', Carbon::now()->startOfMonth()->toDateString());
    $endDate = request('end_date', Carbon::now()->endOfMonth()->toDateString());

    // Comprehensive Payment Analytics
    $paymentAnalytics = [
        // Total Revenue Stats
        'total_revenue' => DB::table('payments')
            ->whereBetween('payment_date', [$startDate, $endDate])
            ->where('status', 'completed')
            ->sum('amount'),

        'total_transactions' => DB::table('payments')
            ->whereBetween('payment_date', [$startDate, $endDate])
            ->where('status', 'completed')
            ->count(),

        // Success Rate
        'success_rate' => $this->calculatePaymentSuccessRate($startDate, $endDate),

        // Average Transaction Value
        'avg_transaction_value' => DB::table('payments')
            ->whereBetween('payment_date', [$startDate, $endDate])
            ->where('status', 'completed')
            ->avg('amount'),

        // Revenue by Hour (for peak time analysis)
        'hourly_revenue' => DB::table('payments')
            ->whereBetween('payment_date', [$startDate, $endDate])
            ->where('status', 'completed')
            ->selectRaw('HOUR(payment_date) as hour, sum(amount) as revenue')
            ->groupBy('hour')
            ->orderBy('hour')
            ->get(),

        // Top Customers by Payment Volume
        'top_customers' => DB::table('payments')
            ->whereBetween('payment_date', [$startDate, $endDate])
            ->where('status', 'completed')
            ->select('customer_id', DB::raw('sum(amount) as total_spent'), DB::raw('count(*) as transactions'))
            ->groupBy('customer_id')
            ->orderBy('total_spent', 'desc')
            ->limit(10)
            ->get(),
    ];

    return view('admin.reports.payment-analytics', compact('paymentAnalytics', 'startDate', 'endDate'));
}

// Helper method to calculate payment success rate
private function calculatePaymentSuccessRate($startDate, $endDate)
{
    $totalAttempts = DB::table('payments')
        ->whereBetween('payment_date', [$startDate, $endDate])
        ->count();

    $successfulPayments = DB::table('payments')
        ->whereBetween('payment_date', [$startDate, $endDate])
        ->where('status', 'completed')
        ->count();

    return $totalAttempts > 0 ? round(($successfulPayments / $totalAttempts) * 100, 2) : 0;
}

// Method to get refund analytics if needed
public function refundAnalytics()
{
    $startDate = request('start_date', Carbon::now()->startOfMonth()->toDateString());
    $endDate = request('end_date', Carbon::now()->endOfMonth()->toDateString());

    $refunds = DB::table('payments')
        ->whereBetween('payment_date', [$startDate, $endDate])
        ->where('status', 'refunded')
        ->selectRaw('
            count(*) as total_refunds,
            sum(amount) as total_refund_amount,
            avg(amount) as avg_refund_amount
        ')
        ->first();

    return $refunds;
}
}