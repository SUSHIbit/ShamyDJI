<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Booking;
use App\Models\Camera;
use Illuminate\Http\Request;

class BookingController extends Controller
{
    public function index()
    {
        $bookings = Booking::with(['user', 'camera'])
            ->orderBy('created_at', 'desc')
            ->paginate(15);
            
        return view('admin.bookings.index', compact('bookings'));
    }
    
    public function byCamera(Camera $camera)
    {
        $bookings = Booking::with('user')
            ->where('camera_id', $camera->id)
            ->orderBy('start_date')
            ->get();
            
        return view('admin.bookings.by-camera', compact('camera', 'bookings'));
    }
    
    public function show(Booking $booking)
    {
        return view('admin.bookings.show', compact('booking'));
    }
    
    public function updateStatus(Request $request, Booking $booking)
    {
        $validated = $request->validate([
            'status' => 'required|in:pending,confirmed,cancelled',
        ]);
        
        $booking->status = $validated['status'];
        $booking->save();
        
        return back()->with('success', 'Booking status updated successfully');
    }
}
