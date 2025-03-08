<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Booking Confirmed') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    <div class="text-center mb-8">
                        <div class="mx-auto flex items-center justify-center h-16 w-16 rounded-full bg-green-100 mb-4">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8 text-green-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                            </svg>
                        </div>
                        <h2 class="text-2xl font-bold text-gray-900 mb-2">Booking Successfully Confirmed!</h2>
                        <p class="text-gray-600">Your booking has been confirmed and is now ready. Please find the details below.</p>
                    </div>
                    
                    <div class="max-w-3xl mx-auto">
                        <div class="bg-gray-50 p-6 rounded-lg mb-6 border border-gray-200">
                            <div class="flex justify-between items-center mb-4">
                                <h3 class="text-lg font-semibold text-gray-800">Booking Information</h3>
                                <span class="px-3 py-1 text-xs font-semibold rounded-full bg-green-100 text-green-800">
                                    Confirmed
                                </span>
                            </div>
                            
                            <div class="mb-6">
                                <p class="text-sm text-gray-500 mb-1">Booking Reference</p>
                                <p class="font-semibold text-gray-900">#{{ $booking->id }}</p>
                            </div>
                            
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                <div>
                                    <div class="mb-4">
                                        <p class="text-sm text-gray-500 mb-1">Camera</p>
                                        <p class="font-semibold text-gray-900">{{ $booking->camera->name }}</p>
                                    </div>
                                    
                                    <div class="mb-4">
                                        <p class="text-sm text-gray-500 mb-1">Rental Period</p>
                                        <p class="font-semibold text-gray-900">
                                            {{ \Carbon\Carbon::parse($booking->start_date)->format('M d, Y') }} - 
                                            {{ \Carbon\Carbon::parse($booking->end_date)->format('M d, Y') }}
                                        </p>
                                    </div>
                                    
                                    <div>
                                        <p class="text-sm text-gray-500 mb-1">Total Rental Days</p>
                                        <p class="font-semibold text-gray-900">{{ $booking->total_days }} days</p>
                                    </div>
                                </div>
                                
                                <div>
                                    <div class="mb-4">
                                        <p class="text-sm text-gray-500 mb-1">Pickup Location</p>
                                        <p class="font-semibold text-gray-900">{{ $booking->camera->details->pickup_location }}</p>
                                    </div>
                                    
                                    <div class="grid grid-cols-2 gap-4">
                                        <div class="mb-4">
                                            <p class="text-sm text-gray-500 mb-1">Pickup Time</p>
                                            <p class="font-semibold text-gray-900">{{ \Carbon\Carbon::parse($booking->camera->details->pickup_time)->format('h:i A') }}</p>
                                        </div>
                                        
                                        <div class="mb-4">
                                            <p class="text-sm text-gray-500 mb-1">Return Time</p>
                                            <p class="font-semibold text-gray-900">{{ \Carbon\Carbon::parse($booking->camera->details->return_time)->format('h:i A') }}</p>
                                        </div>
                                    </div>
                                    
                                    <div>
                                        <p class="text-sm text-gray-500 mb-1">Total Amount Paid</p>
                                        <p class="font-semibold text-gray-900">${{ number_format($booking->total_price, 2) }}</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                        <div class="bg-yellow-50 p-4 rounded-lg mb-6 border border-yellow-200">
                            <div class="flex">
                                <div class="flex-shrink-0">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-yellow-400" viewBox="0 0 20 20" fill="currentColor">
                                        <path fill-rule="evenodd" d="M8.257 3.099c.765-1.36 2.722-1.36 3.486 0l5.58 9.92c.75 1.334-.213 2.98-1.742 2.98H4.42c-1.53 0-2.493-1.646-1.743-2.98l5.58-9.92zM11 13a1 1 0 11-2 0 1 1 0 012 0zm-1-8a1 1 0 00-1 1v3a1 1 0 002 0V6a1 1 0 00-1-1z" clip-rule="evenodd" />
                                    </svg>
                                </div>
                                <div class="ml-3">
                                    <h3 class="text-sm font-medium text-yellow-800">Important Information</h3>
                                    <div class="mt-2 text-sm text-yellow-700">
                                        <ul class="list-disc pl-5 space-y-1">
                                            <li>Please arrive at the pickup location on time.</li>
                                            <li>Don't forget to bring your ID and a copy of this booking confirmation.</li>
                                            <li>The security deposit will be refunded upon return of the equipment in good condition.</li>
                                            <li>Late returns will incur additional charges.</li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                        <div class="flex justify-between items-center mt-8">
                            <a href="{{ route('client.bookings.index') }}" class="inline-flex items-center px-4 py-2 border border-gray-300 rounded-md shadow-sm text-sm font-medium text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                                View All Bookings
                            </a>
                            
                            <a href="{{ route('client.bookings.show', $booking) }}" class="inline-flex items-center px-4 py-2 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                                Booking Details
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>