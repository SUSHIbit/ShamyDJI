<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Booking;
use App\Models\Camera;
use Carbon\Carbon;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        // Get statistics for dashboard
        $totalCameras = Camera::count();
        
        $activeBookings = Booking::where('status', 'confirmed')
            ->where('end_date', '>=', Carbon::today())
            ->count();
            
        $monthlyRevenue = Booking::where('status', 'confirmed')
            ->whereMonth('created_at', Carbon::now()->month)
            ->whereYear('created_at', Carbon::now()->year)
            ->sum('total_price');
            
        $recentBookings = Booking::with(['user', 'camera'])
            ->orderBy('created_at', 'desc')
            ->take(5)
            ->get();
            
        return view('admin.dashboard', compact(
            'totalCameras',
            'activeBookings',
            'monthlyRevenue',
            'recentBookings'
        ));
    }
}
