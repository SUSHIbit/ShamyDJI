<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Camera;

class HomeController extends Controller
{
    public function index()
    {
        // Get a few featured cameras for the homepage
        $featuredCameras = Camera::where('is_active', true)
            ->take(3)
            ->get();
            
        return view('home', compact('featuredCameras'));
    }
}
