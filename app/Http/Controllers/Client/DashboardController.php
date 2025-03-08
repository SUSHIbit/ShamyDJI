<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use App\Models\Booking;
use Carbon\Carbon;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        // Get user's upcoming bookings
        $upcomingBookings = Booking::with('camera')
            ->where('user_id', auth()->id())
            ->where('status', 'confirmed')
            ->where('start_date', '>=', Carbon::today())
            ->orderBy('start_date')
            ->take(3)
            ->get();
            
        // Get user's past bookings
        $pastBookings = Booking::with('camera')
            ->where('user_id', auth()->id())
            ->where('end_date', '<', Carbon::today())
            ->orderBy('end_date', 'desc')
            ->take(3)
            ->get();
            
        // Get user's pending bookings
        $pendingBookings = Booking::with('camera')
            ->where('user_id', auth()->id())
            ->where('status', 'pending')
            ->orderBy('created_at', 'desc')
            ->get();
            
        return view('client.dashboard', compact(
            'upcomingBookings',
            'pastBookings',
            'pendingBookings'
        ));
    }
}