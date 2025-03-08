<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Camera;

class CameraController extends Controller
{
    public function index()
    {
        $cameras = Camera::where('is_active', true)
            ->orderBy('name')
            ->paginate(9);
            
        return view('cameras.index', compact('cameras'));
    }
    
    public function show(Camera $camera)
    {
        // Get next and previous cameras for navigation
        $nextCamera = Camera::where('is_active', true)
            ->where('id', '>', $camera->id)
            ->orderBy('id')
            ->first();
            
        $prevCamera = Camera::where('is_active', true)
            ->where('id', '<', $camera->id)
            ->orderBy('id', 'desc')
            ->first();
            
        return view('cameras.show', compact('camera', 'nextCamera', 'prevCamera'));
    }
}