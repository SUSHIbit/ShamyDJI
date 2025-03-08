<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use App\Models\Camera;

class CameraController extends Controller
{
    public function index()
    {
        $cameras = Camera::orderBy('name')->paginate(10);
        return view('admin.cameras.index', compact('cameras'));
    }
    
    public function create()
    {
        return view('admin.cameras.create');
    }
    
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'image' => 'nullable|image|max:2048',
            'rental_price' => 'required|numeric|min:0',
            'booking_deposit' => 'required|numeric|min:0',
            'security_deposit' => 'required|numeric|min:0',
            'pickup_location' => 'required|string|max:255',
            'pickup_time' => 'required',
            'return_time' => 'required',
            'delivery_available' => 'boolean',
            'terms_conditions' => 'required|string',
            'is_active' => 'boolean',
        ]);
        
        // Create camera
        $camera = new Camera();
        $camera->name = $validated['name'];
        $camera->description = $validated['description'];
        $camera->rental_price = $validated['rental_price'];
        $camera->booking_deposit = $validated['booking_deposit'];
        $camera->security_deposit = $validated['security_deposit'];
        $camera->is_active = $request->has('is_active');
        
        // Handle image upload
        if ($request->hasFile('image')) {
            $path = $request->file('image')->store('cameras', 'public');
            $camera->image = $path;
        }
        
        $camera->save();
        
        // Create camera details
        $camera->details()->create([
            'pickup_location' => $validated['pickup_location'],
            'pickup_time' => $validated['pickup_time'],
            'return_time' => $validated['return_time'],
            'delivery_available' => $request->has('delivery_available'),
            'terms_conditions' => $validated['terms_conditions'],
        ]);
        
        return redirect()->route('admin.cameras.index')
            ->with('success', 'Camera added successfully');
    }
    
    public function edit(Camera $camera)
    {
        return view('admin.cameras.edit', compact('camera'));
    }
    
    public function update(Request $request, Camera $camera)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'image' => 'nullable|image|max:2048',
            'rental_price' => 'required|numeric|min:0',
            'booking_deposit' => 'required|numeric|min:0',
            'security_deposit' => 'required|numeric|min:0',
            'pickup_location' => 'required|string|max:255',
            'pickup_time' => 'required',
            'return_time' => 'required',
            'delivery_available' => 'boolean',
            'terms_conditions' => 'required|string',
            'is_active' => 'boolean',
        ]);
        
        // Update camera
        $camera->name = $validated['name'];
        $camera->description = $validated['description'];
        $camera->rental_price = $validated['rental_price'];
        $camera->booking_deposit = $validated['booking_deposit'];
        $camera->security_deposit = $validated['security_deposit'];
        $camera->is_active = $request->has('is_active');
        
        // Handle image upload
        if ($request->hasFile('image')) {
            // Delete old image if exists
            if ($camera->image) {
                Storage::disk('public')->delete($camera->image);
            }
            
            $path = $request->file('image')->store('cameras', 'public');
            $camera->image = $path;
        }
        
        $camera->save();
        
        // Update camera details
        $camera->details()->update([
            'pickup_location' => $validated['pickup_location'],
            'pickup_time' => $validated['pickup_time'],
            'return_time' => $validated['return_time'],
            'delivery_available' => $request->has('delivery_available'),
            'terms_conditions' => $validated['terms_conditions'],
        ]);
        
        return redirect()->route('admin.cameras.index')
            ->with('success', 'Camera updated successfully');
    }
    
    public function destroy(Camera $camera)
    {
        // Check if camera has active bookings
        if ($camera->bookings()->where('status', '!=', 'cancelled')->exists()) {
            return back()->with('error', 'Cannot delete camera with active bookings');
        }
        
        // Delete image if exists
        if ($camera->image) {
            Storage::disk('public')->delete($camera->image);
        }
        
        // Delete camera and related details (via cascade)
        $camera->delete();
        
        return redirect()->route('admin.cameras.index')
            ->with('success', 'Camera deleted successfully');
    }
}
