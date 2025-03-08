<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Book Camera') }}: {{ $camera->name }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    @if(session('error'))
                        <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative mb-4" role="alert">
                            <span class="block sm:inline">{{ session('error') }}</span>
                        </div>
                    @endif
                    
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <div class="relative h-64 bg-gray-200 mb-4">
                                @if($camera->image)
                                    <img src="{{ asset('storage/' . $camera->image) }}" alt="{{ $camera->name }}" class="w-full h-full object-cover">
                                @else
                                    <div class="flex items-center justify-center w-full h-full bg-gray-100 text-gray-500">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-12 w-12" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 9a2 2 0 012-2h.93a2 2 0 001.664-.89l.812-1.22A2 2 0 0110.07 4h3.86a2 2 0 011.664.89l.812 1.22A2 2 0 0018.07 7H19a2 2 0 012 2v9a2 2 0 01-2 2H5a2 2 0 01-2-2V9z" />
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 13a3 3 0 11-6 0 3 3 0 016 0z" />
                                        </svg>
                                    </div>
                                @endif
                            </div>
                            
                            <h3 class="text-lg font-semibold text-gray-900 mb-2">{{ $camera->name }}</h3>
                            <p class="text-gray-600 mb-4">{{ $camera->description }}</p>
                            
                            <!-- Camera Info -->
                            <div class="bg-gray-50 p-4 rounded-lg mb-6">
                                <h4 class="text-md font-medium text-gray-800 mb-3">Camera Details</h4>
                                
                                <div class="grid grid-cols-2 gap-4 text-sm">
                                    <div>
                                        <p class="text-gray-500">Rental Price</p>
                                        <p class="font-semibold text-gray-800">${{ $camera->rental_price }}/day</p>
                                    </div>
                                    <div>
                                        <p class="text-gray-500">Booking Deposit</p>
                                        <p class="font-semibold text-gray-800">${{ $camera->booking_deposit }}</p>
                                    </div>
                                    <div>
                                        <p class="text-gray-500">Security Deposit</p>
                                        <p class="font-semibold text-gray-800">${{ $camera->security_deposit }}</p>
                                    </div>
                                    <div>
                                        <p class="text-gray-500">Pickup Location</p>
                                        <p class="font-semibold text-gray-800">{{ $camera->details->pickup_location }}</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                        <div>
                            <h3 class="text-lg font-semibold text-gray-900 mb-4">Book This Camera</h3>
                            
                            <form id="booking_form" method="POST" action="{{ route('client.bookings.store', $camera) }}" class="space-y-4">
                                @csrf
                                
                                <div class="mb-4">
                                    <label for="start_date" class="block text-sm font-medium text-gray-700 mb-1">Start Date</label>
                                    <input type="date" id="start_date" name="start_date" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 sm:text-sm" min="{{ date('Y-m-d') }}" value="{{ old('start_date') }}" required>
                                    @error('start_date')
                                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>
                                
                                <div class="mb-4">
                                    <label for="end_date" class="block text-sm font-medium text-gray-700 mb-1">End Date</label>
                                    <input type="date" id="end_date" name="end_date" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 sm:text-sm" min="{{ date('Y-m-d') }}" value="{{ old('end_date') }}" required>
                                    @error('end_date')
                                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>
                                
                                @error('date_conflict')
                                    <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative mb-4" role="alert">
                                        <span class="block sm:inline">{{ $message }}</span>
                                    </div>
                                @enderror
                                
                                <div class="bg-gray-50 p-4 rounded-lg my-4">
                                    <h4 class="text-md font-medium text-gray-800 mb-2">Booking Summary</h4>
                                    
                                    <div class="grid grid-cols-2 gap-4 text-sm mb-2">
                                        <div>
                                            <p class="text-gray-500">Total Days</p>
                                            <p class="font-semibold text-gray-800" id="total_days">-</p>
                                        </div>
                                        <div>
                                            <p class="text-gray-500">Estimated Total</p>
                                            <p class="font-semibold text-gray-800" id="estimated_total">-</p>
                                        </div>
                                    </div>
                                    
                                    <div class="text-xs text-gray-500">
                                        <p>Total includes rental fee, booking deposit, and security deposit.</p>
                                        <p>Security deposit is refundable upon return of equipment in good condition.</p>
                                    </div>
                                </div>
                                
                                <div class="flex items-start mb-4">
                                    <div class="flex items-center h-5">
                                        <input id="agree_terms" name="agree_terms" type="checkbox" class="focus:ring-blue-500 h-4 w-4 text-blue-600 border-gray-300 rounded" required>
                                    </div>
                                    <div class="ml-3 text-sm">
                                        <label for="agree_terms" class="font-medium text-gray-700">I agree to the terms and conditions</label>
                                        <p class="text-gray-500">By booking this camera, you agree to the rental terms and conditions.</p>
                                    </div>
                                </div>
                                
                                <div class="flex justify-between">
                                    <a href="{{ route('cameras.show', $camera) }}" class="inline-flex justify-center py-2 px-4 border border-gray-300 shadow-sm text-sm font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                                        Cancel
                                    </a>
                                    <button type="submit" class="inline-flex justify-center py-2 px-4 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                                        Proceed to Payment
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <div id="camera_bookings" style="display: none;">{{ json_encode($camera->bookings->where('status', '!=', 'cancelled')) }}</div>
    
    @push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Store camera details for calculation
            const rentalPrice = {{ $camera->rental_price }};
            const bookingDeposit = {{ $camera->booking_deposit }};
            const securityDeposit = {{ $camera->security_deposit }};
            
            // Hidden input to store booking data for validation
            const bookings = JSON.parse(document.getElementById('camera_bookings').textContent);
            const bookingForm = document.getElementById('booking_form');
            const startDateInput = document.getElementById('start_date');
            const endDateInput = document.getElementById('end_date');
            const totalDaysSpan = document.getElementById('total_days');
            const estimatedTotalSpan = document.getElementById('estimated_total');
            
            // Function to calculate the total days and price
            function calculateTotals() {
                if (startDateInput.value && endDateInput.value) {
                    const startDate = new Date(startDateInput.value);
                    const endDate = new Date(endDateInput.value);
                    
                    // Check if end date is after start date
                    if (endDate >= startDate) {
                        // Calculate difference in days (inclusive of start and end dates)
                        const diffTime = Math.abs(endDate - startDate);
                        const diffDays = Math.ceil(diffTime / (1000 * 60 * 60 * 24)) + 1;
                        
                        totalDaysSpan.textContent = diffDays;
                        
                        // Calculate total price
                        const totalPrice = (rentalPrice * diffDays) + bookingDeposit + securityDeposit;
                        estimatedTotalSpan.textContent = '$' + totalPrice.toFixed(2);
                    } else {
                        totalDaysSpan.textContent = '-';
                        estimatedTotalSpan.textContent = '-';
                    }
                } else {
                    totalDaysSpan.textContent = '-';
                    estimatedTotalSpan.textContent = '-';
                }
            }
            
            // Function to check if a date is already booked
            function isDateBooked(date) {
                return bookings.some(booking => {
                    const startDate = new Date(booking.start_date);
                    const endDate = new Date(booking.end_date);
                    return date >= startDate && date <= endDate;
                });
            }
            
            // Function to validate the booking dates
            function validateDates() {
                if (startDateInput.value && endDateInput.value) {
                    const startDate = new Date(startDateInput.value);
                    const endDate = new Date(endDateInput.value);
                    
                    if (endDate < startDate) {
                        alert('End date must be after start date');
                        return false;
                    }
                    
                    // Check each date in the range
                    let currentDate = new Date(startDate);
                    while (currentDate <= endDate) {
                        if (isDateBooked(currentDate)) {
                            alert('One or more of your selected dates are already booked');
                            return false;
                        }
                        currentDate.setDate(currentDate.getDate() + 1);
                    }
                }
                return true;
            }
            
            // Add event listeners
            startDateInput.addEventListener('change', calculateTotals);
            endDateInput.addEventListener('change', calculateTotals);
            
            // Validate form on submit
            bookingForm.addEventListener('submit', function(e) {
                if (!validateDates()) {
                    e.preventDefault();
                }
            });
            
            // Initial calculation
            calculateTotals();
        });
    </script>
    @endpush
</x-app-layout>