<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class AdminDashboardController extends Controller
{
    public function dashboard()
    {
        // Get dashboard statistics
        $stats = $this->getDashboardStats();
        $recentActivities = $this->getRecentActivities();
        $monthlyStats = $this->getMonthlyStats();
        
        return view('admin.auth.dashboard', compact('stats', 'recentActivities', 'monthlyStats'));
    }
    
    private function getDashboardStats()
    {
        $currentMonth = Carbon::now()->startOfMonth();
        $lastMonth = Carbon::now()->subMonth()->startOfMonth();
        
        // New Registrations (cars added this month)
        $newRegistrationsThisMonth = DB::table('car_details_tbl')
            ->where('created_at', '>=', $currentMonth)
            ->count();
            
        $newRegistrationsLastMonth = DB::table('car_details_tbl')
            ->whereBetween('created_at', [$lastMonth, $currentMonth])
            ->count();
            
        $registrationsTrend = $this->calculateTrend($newRegistrationsThisMonth, $newRegistrationsLastMonth);
        
        // Pending Inspections
        $pendingInspections = DB::table('inspection_requests')
            ->where('status', 'pending')
            ->count();
            
        $pendingInspectionsLastMonth = DB::table('inspection_requests')
            ->where('status', 'pending')
            ->whereBetween('created_at', [$lastMonth, $currentMonth])
            ->count();
            
        $inspectionsTrend = $this->calculateTrend($pendingInspections, $pendingInspectionsLastMonth);
        
        // Total Revenue (this month)
        $totalRevenueThisMonth = DB::table('payments')
            ->where('status', 'completed')
            ->where('created_at', '>=', $currentMonth)
            ->sum('amount') ?: 0;
            
        $totalRevenueLastMonth = DB::table('payments')
            ->where('status', 'completed')
            ->whereBetween('created_at', [$lastMonth, $currentMonth])
            ->sum('amount') ?: 0;
            
        $revenueTrend = $this->calculateTrend($totalRevenueThisMonth, $totalRevenueLastMonth);
        
        // Booked Cars (active bookings)
        $bookedCarsThisMonth = DB::table('car_bookings')
            ->whereIn('status', ['confirmed', 'ongoing'])
            ->where('created_at', '>=', $currentMonth)
            ->count();
            
        $bookedCarsLastMonth = DB::table('car_bookings')
            ->whereIn('status', ['confirmed', 'ongoing'])
            ->whereBetween('created_at', [$lastMonth, $currentMonth])
            ->count();
            
        $bookingsTrend = $this->calculateTrend($bookedCarsThisMonth, $bookedCarsLastMonth);
        
        return [
            'new_registrations' => [
                'count' => $newRegistrationsThisMonth,
                'trend' => $registrationsTrend
            ],
            'pending_inspections' => [
                'count' => $pendingInspections,
                'trend' => $inspectionsTrend
            ],
            'total_revenue' => [
                'amount' => number_format($totalRevenueThisMonth, 2),
                'trend' => $revenueTrend
            ],
            'booked_cars' => [
                'count' => $bookedCarsThisMonth,
                'trend' => $bookingsTrend
            ]
        ];
    }
    
    private function getRecentActivities()
    {
        $activities = collect();
        
        // Recent car registrations
        $recentRegistrations = DB::table('car_details_tbl')
            ->select('maker', 'model', 'created_at')
            ->orderBy('created_at', 'desc')
            ->limit(3)
            ->get();
            
        foreach ($recentRegistrations as $reg) {
            $activities->push([
                'type' => 'registration',
                'icon' => 'fas fa-car',
                'color' => 'bg-primary',
                'message' => "New registration request for {$reg->maker} {$reg->model}",
                'time' => Carbon::parse($reg->created_at)->diffForHumans()
            ]);
        }
        
        // Recent inspection approvals/rejections
        $recentInspections = DB::table('inspection_requests')
            ->join('car_details_tbl', 'inspection_requests.car_id', '=', 'car_details_tbl.id')
            ->select('car_details_tbl.maker', 'car_details_tbl.model', 'inspection_requests.status', 'inspection_requests.updated_at')
            ->whereIn('inspection_requests.status', ['approved', 'rejected'])
            ->orderBy('inspection_requests.updated_at', 'desc')
            ->limit(3)
            ->get();
            
        foreach ($recentInspections as $inspection) {
            $color = $inspection->status === 'approved' ? 'bg-success' : 'bg-danger';
            $icon = $inspection->status === 'approved' ? 'fas fa-check' : 'fas fa-times';
            
            $activities->push([
                'type' => 'inspection',
                'icon' => $icon,
                'color' => $color,
                'message' => "Car inspection {$inspection->status} for {$inspection->maker} {$inspection->model}",
                'time' => Carbon::parse($inspection->updated_at)->diffForHumans()
            ]);
        }
        
        // Recent payments
        $recentPayments = DB::table('payments')
            ->join('car_bookings', 'payments.booking_id', '=', 'car_bookings.id')
            ->join('car_details_tbl', 'car_bookings.car_id', '=', 'car_details_tbl.id')
            ->select('car_details_tbl.maker', 'car_details_tbl.model', 'payments.amount', 'payments.created_at')
            ->where('payments.status', 'completed')
            ->orderBy('payments.created_at', 'desc')
            ->limit(2)
            ->get();
            
        foreach ($recentPayments as $payment) {
            $activities->push([
                'type' => 'payment',
                'icon' => 'fas fa-credit-card',
                'color' => 'bg-info',
                'message' => "Payment received for {$payment->maker} {$payment->model} - $" . number_format($payment->amount, 2),
                'time' => Carbon::parse($payment->created_at)->diffForHumans()
            ]);
        }
        
        // Sort by time and return latest 5
        return $activities->sortByDesc(function ($activity) {
            return $activity['time'];
        })->take(5)->values();
    }
    
    private function getMonthlyStats()
    {
        $currentMonth = Carbon::now()->startOfMonth();
        
        // Calculate monthly targets (you can adjust these based on your business goals)
        $monthlyTargets = [
            'registrations' => 50,
            'inspections' => 45,
            'approvals' => 40,
            'revenue' => 20000
        ];
        
        $actualRegistrations = DB::table('car_details_tbl')
            ->where('created_at', '>=', $currentMonth)
            ->count();
            
        $actualInspections = DB::table('inspection_requests')
            ->where('status', 'completed')
            ->where('updated_at', '>=', $currentMonth)
            ->count();
            
        $actualApprovals = DB::table('car_details_tbl')
            ->where('status', 'approved')
            ->where('updated_at', '>=', $currentMonth)
            ->count();
            
        $actualRevenue = DB::table('payments')
            ->where('status', 'completed')
            ->where('created_at', '>=', $currentMonth)
            ->sum('amount') ?: 0;
        
        return [
            'registrations' => [
                'percentage' => min(100, round(($actualRegistrations / $monthlyTargets['registrations']) * 100)),
                'actual' => $actualRegistrations,
                'target' => $monthlyTargets['registrations']
            ],
            'inspections' => [
                'percentage' => min(100, round(($actualInspections / $monthlyTargets['inspections']) * 100)),
                'actual' => $actualInspections,
                'target' => $monthlyTargets['inspections']
            ],
            'approvals' => [
                'percentage' => min(100, round(($actualApprovals / $monthlyTargets['approvals']) * 100)),
                'actual' => $actualApprovals,
                'target' => $monthlyTargets['approvals']
            ],
            'revenue' => [
                'percentage' => min(100, round(($actualRevenue / $monthlyTargets['revenue']) * 100)),
                'actual' => $actualRevenue,
                'target' => $monthlyTargets['revenue']
            ]
        ];
    }
    
    private function calculateTrend($current, $previous)
    {
        // Ensure we have numeric values
        $current = floatval($current);
        $previous = floatval($previous);
        
        if ($previous == 0) {
            return ['direction' => 'up', 'percentage' => $current > 0 ? 100 : 0];
        }
        
        $change = (($current - $previous) / $previous) * 100;
        
        return [
            'direction' => $change >= 0 ? 'up' : 'down',
            'percentage' => abs(round($change))
        ];
    }

}