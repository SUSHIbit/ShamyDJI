<?php

use App\Http\Controllers\HomeController;
use App\Http\Controllers\CameraController;
use App\Http\Controllers\Admin\DashboardController as AdminDashboardController;
use App\Http\Controllers\Admin\CameraController as AdminCameraController;
use App\Http\Controllers\Admin\BookingController as AdminBookingController;
use App\Http\Controllers\Client\DashboardController as ClientDashboardController;
use App\Http\Controllers\Client\BookingController as ClientBookingController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

// Public routes
Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/cameras', [CameraController::class, 'index'])->name('cameras.index');
Route::get('/cameras/{camera}', [CameraController::class, 'show'])->name('cameras.show');

// Auth routes (provided by Laravel Breeze)
require __DIR__.'/auth.php';

// Admin routes
Route::prefix('admin')->middleware(['auth', 'role:admin'])->group(function () {
    Route::get('/dashboard', [AdminDashboardController::class, 'index'])->name('admin.dashboard');
    
    // Camera management
    Route::resource('cameras', AdminCameraController::class, ['as' => 'admin']);
    
    // Booking management
    Route::get('/bookings', [AdminBookingController::class, 'index'])->name('admin.bookings.index');
    Route::get('/bookings/{booking}', [AdminBookingController::class, 'show'])->name('admin.bookings.show');
    Route::get('/bookings/by-camera/{camera}', [AdminBookingController::class, 'byCamera'])->name('admin.bookings.by-camera');
    Route::patch('/bookings/{booking}/status', [AdminBookingController::class, 'updateStatus'])->name('admin.bookings.updateStatus');
});

// Client routes
Route::prefix('client')->middleware(['auth', 'role:client'])->group(function () {
    Route::get('/dashboard', [ClientDashboardController::class, 'index'])->name('client.dashboard');
    
    // Booking process
    Route::get('/cameras/{camera}/book', [ClientBookingController::class, 'create'])->name('client.bookings.create');
    Route::post('/cameras/{camera}/book', [ClientBookingController::class, 'store'])->name('client.bookings.store');
    Route::get('/bookings/{booking}/payment', [ClientBookingController::class, 'payment'])->name('client.bookings.payment');
    Route::post('/bookings/{booking}/confirm', [ClientBookingController::class, 'confirm'])->name('client.bookings.confirm');
    
    // My bookings
    Route::get('/bookings', [ClientBookingController::class, 'index'])->name('client.bookings.index');
    Route::get('/bookings/{booking}', [ClientBookingController::class, 'show'])->name('client.bookings.show');
    Route::patch('/bookings/{booking}/cancel', [ClientBookingController::class, 'cancel'])->name('client.bookings.cancel');
});
