<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Complete Your Booking Payment') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <h3 class="text-lg font-semibold text-gray-800 mb-4">Booking Summary</h3>
                            
                            <div class="bg-gray-50 p-4 rounded-lg mb-6">
                                <div class="mb-4">
                                    <p class="text-sm text-gray-500">Camera</p>
                                    <p class="font-medium text-gray-900">{{ $booking->camera->name }}</p>
                                </div>
                                
                                <div class="mb-4 grid grid-cols-2 gap-4">
                                    <div>
                                        <p class="text-sm text-gray-500">Start Date</p>
                                        <p class="font-medium text-gray-900">{{ \Carbon\Carbon::parse($booking->start_date)->format('M d, Y') }}</p>
                                    </div>
                                    <div>
                                        <p class="text-sm text-gray-500">End Date</p>
                                        <p class="font-medium text-gray-900">{{ \Carbon\Carbon::parse($booking->end_date)->format('M d, Y') }}</p>
                                    </div>
                                </div>
                                
                                <div class="mb-4">
                                    <p class="text-sm text-gray-500">Total Rental Days</p>
                                    <p class="font-medium text-gray-900">{{ $booking->total_days }} days</p>
                                </div>
                            </div>
                            
                            <h3 class="text-lg font-semibold text-gray-800 mb-4">Price Breakdown</h3>
                            
                            <div class="bg-gray-50 p-4 rounded-lg mb-6">
                                <div class="flex justify-between py-2 border-b">
                                    <span class="text-gray-600">Rental Fee</span>
                                    <span class="font-medium">${{ number_format($booking->camera->rental_price * $booking->total_days, 2) }}</span>
                                </div>
                                <div class="flex justify-between py-2 border-b">
                                    <span class="text-gray-600">Booking Deposit</span>
                                    <span class="font-medium">${{ number_format($booking->camera->booking_deposit, 2) }}</span>
                                </div>
                                <div class="flex justify-between py-2 border-b">
                                    <span class="text-gray-600">Security Deposit</span>
                                    <span class="font-medium">${{ number_format($booking->camera->security_deposit, 2) }}</span>
                                </div>
                                <div class="flex justify-between py-2 font-semibold">
                                    <span>Total Amount</span>
                                    <span>${{ number_format($booking->total_price, 2) }}</span>
                                </div>
                            </div>
                            
                            <h3 class="text-lg font-semibold text-gray-800 mb-4">Pickup Information</h3>
                            
                            <div class="bg-gray-50 p-4 rounded-lg mb-6">
                                <div class="mb-3">
                                    <p class="text-sm text-gray-500">Location</p>
                                    <p class="font-medium text-gray-900">{{ $booking->camera->details->pickup_location }}</p>
                                </div>
                                
                                <div class="grid grid-cols-2 gap-4">
                                    <div>
                                        <p class="text-sm text-gray-500">Pickup Time</p>
                                        <p class="font-medium text-gray-900">{{ \Carbon\Carbon::parse($booking->camera->details->pickup_time)->format('h:i A') }}</p>
                                    </div>
                                    <div>
                                        <p class="text-sm text-gray-500">Return Time</p>
                                        <p class="font-medium text-gray-900">{{ \Carbon\Carbon::parse($booking->camera->details->return_time)->format('h:i A') }}</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                        <div>
                            <h3 class="text-lg font-semibold text-gray-800 mb-4">Payment Instructions</h3>
                            
                            <div class="bg-gray-50 p-4 rounded-lg mb-6">
                                <p class="mb-4">Please transfer the total amount to the following account:</p>
                                
                                <div class="mb-6 bg-white p-4 rounded border">
                                    <p class="mb-2"><span class="font-medium">Account Name:</span> Camera Rental Services</p>
                                    <p class="mb-2"><span class="font-medium">Account Number:</span> 1234-5678-9012-3456</p>
                                    <p class="mb-2"><span class="font-medium">Bank:</span> Example Bank</p>
                                    <p class="mb-2"><span class="font-medium">Reference:</span> Booking #{{ $booking->id }}</p>
                                </div>
                                
                                <p class="mb-4 text-center">OR</p>
                                
                                <div class="mb-4 text-center">
                                    <p class="mb-2 font-medium">Scan this QR code to pay:</p>
                                    <div class="bg-white p-4 inline-block rounded border">
                                        <!-- Placeholder for QR Code - in a real app, generate a unique QR code -->
                                        <div class="w-48 h-48 mx-auto bg-gray-200 flex items-center justify-center">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-20 w-20 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v1m6 11h2m-6 0h-2v4m0-11v3m0 0h.01M12 12h4.01M16 20h4M4 12h4m12 0h.01M5 8h2a1 1 0 001-1V5a1 1 0 00-1-1H5a1 1 0 00-1 1v2a1 1 0 001 1zm12 0h2a1 1 0 001-1V5a1 1 0 00-1-1h-2a1 1 0 00-1 1v2a1 1 0 001 1zM5 20h2a1 1 0 001-1v-2a1 1 0 00-1-1H5a1 1 0 00-1 1v2a1 1 0 001 1z" />
                                            </svg>
                                        </div>
                                    </div>
                                </div>
                                
                                <p class="text-sm text-gray-600 mb-4">After completing the payment, please upload the payment receipt below to confirm your booking.</p>
                            </div>
                            
                            <h3 class="text-lg font-semibold text-gray-800 mb-4">Upload Payment Receipt</h3>
                            
                            <form method="POST" action="{{ route('client.bookings.confirm', $booking) }}" enctype="multipart/form-data" class="bg-gray-50 p-4 rounded-lg">
                                @csrf
                                
                                <div class="mb-4">
                                    <label for="payment_receipt" class="block text-sm font-medium text-gray-700 mb-2">Payment Receipt</label>
                                    <input type="file" name="payment_receipt" id="payment_receipt" accept="image/*" class="w-full text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-md file:border-0 file:text-sm file:font-semibold file:bg-blue-50 file:text-blue-700 hover:file:bg-blue-100" required>
                                    <p class="mt-1 text-sm text-gray-500">Upload a screenshot or photo of your payment receipt.</p>
                                    @error('payment_receipt')
                                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>
                                
                                <div class="mb-4">
                                    <div class="flex items-start">
                                        <div class="flex items-center h-5">
                                            <input id="confirm_details" name="confirm_details" type="checkbox" value="1" class="focus:ring-blue-500 h-4 w-4 text-blue-600 border-gray-300 rounded" required>
                                        </div>
                                        <div class="ml-3 text-sm">
                                            <label for="confirm_details" class="font-medium text-gray-700">I confirm that all the booking details are correct</label>
                                        </div>
                                    </div>
                                </div>
                                
                                <div class="flex items-center justify-between">
                                    <a href="{{ route('client.bookings.index') }}" class="text-sm text-gray-600 hover:text-gray-900">Cancel Payment</a>
                                    <button type="submit" class="inline-flex items-center px-4 py-2 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                                        Confirm Payment
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <div class="py-6">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    <h3 class="text-lg font-semibold text-gray-800 mb-4">Terms & Conditions</h3>
                    <div class="prose max-w-none">
                        {!! nl2br(e($booking->camera->details->terms_conditions)) !!}
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>