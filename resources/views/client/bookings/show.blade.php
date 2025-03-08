<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Booking Details') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    <div class="flex justify-between items-start mb-6">
                        <div>
                            <h3 class="text-2xl font-semibold text-gray-900 mb-1">Booking #{{ $booking->id }}</h3>
                            <p class="text-gray-600">Created on {{ $booking->created_at->format('M d, Y') }}</p>
                        </div>
                        <span class="px-3 py-1 text-xs font-semibold rounded-full 
                            {{ $booking->status === 'confirmed' ? 'bg-green-100 text-green-800' : 
                               ($booking->status === 'pending' ? 'bg-yellow-100 text-yellow-800' : 'bg-red-100 text-red-800') }}">
                            {{ ucfirst($booking->status) }}
                        </span>
                    </div>
                    
                    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
                        <div class="lg:col-span-2">
                            <div class="bg-gray-50 p-5 rounded-lg mb-6">
                                <h4 class="font-medium text-gray-900 mb-4">Camera Details</h4>
                                
                                <div class="flex items-start">
                                    <div class="flex-shrink-0 w-24 h-24 bg-gray-200 rounded overflow-hidden mr-4">
                                        @if($booking->camera->image)
                                            <img src="{{ asset('storage/' . $booking->camera->image) }}" alt="{{ $booking->camera->name }}" class="w-full h-full object-cover">
                                        @else
                                            <div class="flex items-center justify-center w-full h-full bg-gray-100 text-gray-500">
                                                <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 9a2 2 0 012-2h.93a2 2 0 001.664-.89l.812-1.22A2 2 0 0110.07 4h3.86a2 2 0 011.664.89l.812 1.22A2 2 0 0018.07 7H19a2 2 0 012 2v9a2 2 0 01-2 2H5a2 2 0 01-2-2V9z" />
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 13a3 3 0 11-6 0 3 3 0 016 0z" />
                                                </svg>
                                            </div>
                                        @endif
                                    </div>
                                    
                                    <div>
                                        <h5 class="text-lg font-semibold text-gray-900 mb-2">{{ $booking->camera->name }}</h5>
                                        <p class="text-gray-600 text-sm mb-2">{{ Str::limit($booking->camera->description, 150) }}</p>
                                        <p class="text-sm text-blue-600 font-medium">${{ number_format($booking->camera->rental_price, 2) }} per day</p>
                                    </div>
                                </div>
                            </div>
                            
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                                <div class="bg-gray-50 p-5 rounded-lg">
                                    <h4 class="font-medium text-gray-900 mb-4">Booking Information</h4>
                                    
                                    <div class="space-y-3">
                                        <div>
                                            <p class="text-sm text-gray-500">Booking Status</p>
                                            <p class="font-medium text-gray-900">{{ ucfirst($booking->status) }}</p>
                                        </div>
                                        <div>
                                            <p class="text-sm text-gray-500">Start Date</p>
                                            <p class="font-medium text-gray-900">{{ \Carbon\Carbon::parse($booking->start_date)->format('M d, Y') }}</p>
                                        </div>
                                        <div>
                                            <p class="text-sm text-gray-500">End Date</p>
                                            <p class="font-medium text-gray-900">{{ \Carbon\Carbon::parse($booking->end_date)->format('M d, Y') }}</p>
                                        </div>
                                        <div>
                                            <p class="text-sm text-gray-500">Total Days</p>
                                            <p class="font-medium text-gray-900">{{ $booking->total_days }} days</p>
                                        </div>
                                    </div>
                                </div>
                                
                                <div class="bg-gray-50 p-5 rounded-lg">
                                    <h4 class="font-medium text-gray-900 mb-4">Pickup & Return</h4>
                                    
                                    <div class="space-y-3">
                                        <div>
                                            <p class="text-sm text-gray-500">Pickup Location</p>
                                            <p class="font-medium text-gray-900">{{ $booking->camera->details->pickup_location }}</p>
                                        </div>
                                        <div>
                                            <p class="text-sm text-gray-500">Pickup Time</p>
                                            <p class="font-medium text-gray-900">{{ \Carbon\Carbon::parse($booking->camera->details->pickup_time)->format('h:i A') }}</p>
                                        </div>
                                        <div>
                                            <p class="text-sm text-gray-500">Return Time</p>
                                            <p class="font-medium text-gray-900">{{ \Carbon\Carbon::parse($booking->camera->details->return_time)->format('h:i A') }}</p>
                                        </div>
                                        <div>
                                            <p class="text-sm text-gray-500">Delivery Available</p>
                                            <p class="font-medium text-gray-900">{{ $booking->camera->details->delivery_available ? 'Yes' : 'No' }}</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            
                            @if($booking->payment_receipt)
                                <div class="bg-gray-50 p-5 rounded-lg mb-6">
                                    <h4 class="font-medium text-gray-900 mb-4">Payment Receipt</h4>
                                    
                                    <div class="aspect-w-16 aspect-h-9 bg-gray-200 rounded overflow-hidden">
                                        <img src="{{ asset('storage/' . $booking->payment_receipt) }}" alt="Payment Receipt" class="object-contain">
                                    </div>
                                </div>
                            @endif
                        </div>
                        
                        <div>
                            <div class="bg-gray-50 p-5 rounded-lg mb-6">
                                <h4 class="font-medium text-gray-900 mb-4">Price Breakdown</h4>
                                
                                <div class="space-y-2 pb-4 border-b border-gray-200">
                                    <div class="flex justify-between">
                                        <span class="text-gray-600">Rental Fee ({{ $booking->total_days }} days)</span>
                                        <span class="font-medium">${{ number_format($booking->camera->rental_price * $booking->total_days, 2) }}</span>
                                    </div>
                                    <div class="flex justify-between">
                                        <span class="text-gray-600">Booking Deposit</span>
                                        <span class="font-medium">${{ number_format($booking->camera->booking_deposit, 2) }}</span>
                                    </div>
                                    <div class="flex justify-between">
                                        <span class="text-gray-600">Security Deposit</span>
                                        <span class="font-medium">${{ number_format($booking->camera->security_deposit, 2) }}</span>
                                    </div>
                                </div>
                                
                                <div class="pt-4">
                                    <div class="flex justify-between font-semibold">
                                        <span>Total Amount</span>
                                        <span>${{ number_format($booking->total_price, 2) }}</span>
                                    </div>
                                </div>
                            </div>
                            
                            <div class="bg-gray-50 p-5 rounded-lg mb-6">
                                <h4 class="font-medium text-gray-900 mb-4">Actions</h4>
                                
                                <div class="space-y-3">
                                    @if($booking->status === 'pending')
                                        <a href="{{ route('client.bookings.payment', $booking) }}" class="block w-full text-center px-4 py-2 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                                            Complete Payment
                                        </a>
                                        
                                        <form method="POST" action="{{ route('client.bookings.cancel', $booking) }}" class="block w-full" onsubmit="return confirm('Are you sure you want to cancel this booking?');">
                                            @csrf
                                            @method('PATCH')
                                            <button type="submit" class="w-full text-center px-4 py-2 border border-gray-300 rounded-md shadow-sm text-sm font-medium text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                                                Cancel Booking
                                            </button>
                                        </form>
                                    @endif
                                    
                                    <a href="{{ route('client.bookings.index') }}" class="block w-full text-center px-4 py-2 border border-gray-300 rounded-md shadow-sm text-sm font-medium text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                                        Back to My Bookings
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>