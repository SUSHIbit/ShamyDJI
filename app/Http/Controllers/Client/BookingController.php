<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreBookingRequest;
use App\Models\Booking;
use App\Models\Camera;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class BookingController extends Controller
{
    public function index()
    {
        $bookings = Booking::with('camera')
            ->where('user_id', auth()->id())
            ->orderBy('created_at', 'desc')
            ->paginate(10);
            
        return view('client.bookings.index', compact('bookings'));
    }
    
    public function create(Camera $camera)
    {
        return view('client.bookings.create', compact('camera'));
    }
    
    public function store(StoreBookingRequest $request, Camera $camera)
    {
        $validated = $request->validated();
        
        // Calculate total days
        $startDate = Carbon::parse($validated['start_date']);
        $endDate = Carbon::parse($validated['end_date']);
        $totalDays = $endDate->diffInDays($startDate) + 1; // Including both start and end date
        
        // Calculate total price
        $totalPrice = ($camera->rental_price * $totalDays) + $camera->booking_deposit + $camera->security_deposit;
        
        // Create booking
        $booking = new Booking();
        $booking->user_id = auth()->id();
        $booking->camera_id = $camera->id;
        $booking->start_date = $validated['start_date'];
        $booking->end_date = $validated['end_date'];
        $booking->total_days = $totalDays;
        $booking->total_price = $totalPrice;
        $booking->status = 'pending';
        $booking->save();
        
        return redirect()->route('client.bookings.payment', $booking)
            ->with('success', 'Booking created successfully. Please proceed with payment.');
    }
    
    public function payment(Booking $booking)
    {
        // Ensure the booking belongs to the authenticated user
        if ($booking->user_id !== auth()->id()) {
            abort(403);
        }
        
        return view('client.bookings.payment', compact('booking'));
    }
    
    public function confirm(Request $request, Booking $booking)
    {
        // Ensure the booking belongs to the authenticated user
        if ($booking->user_id !== auth()->id()) {
            abort(403);
        }
        
        $validated = $request->validate([
            'payment_receipt' => 'required|image|max:2048',
        ]);
        
        // Store receipt image
        $path = $request->file('payment_receipt')->store('receipts', 'public');
        
        // Update booking
        $booking->payment_receipt = $path;
        $booking->status = 'confirmed';
        $booking->save();
        
        return view('client.bookings.confirmation', compact('booking'))
            ->with('success', 'Payment received. Your booking is confirmed!');
    }
    
    public function show(Booking $booking)
    {
        // Ensure the booking belongs to the authenticated user
        if ($booking->user_id !== auth()->id()) {
            abort(403);
        }
        
        return view('client.bookings.show', compact('booking'));
    }
    
    public function cancel(Booking $booking)
    {
        // Ensure the booking belongs to the authenticated user
        if ($booking->user_id !== auth()->id()) {
            abort(403);
        }
        
        // Only allow cancellation if the booking is still pending
        if ($booking->status !== 'pending') {
            return back()->with('error', 'Only pending bookings can be cancelled');
        }
        
        $booking->status = 'cancelled';
        $booking->save();
        
        return redirect()->route('client.bookings.index')
            ->with('success', 'Booking cancelled successfully');
    }
}
