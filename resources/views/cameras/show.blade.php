<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ $camera->name }}
            </h2>
            <div class="flex space-x-4">
                @if($prevCamera)
                    <a href="{{ route('cameras.show', $prevCamera) }}" class="inline-flex items-center px-4 py-2 bg-gray-200 border border-transparent rounded-md font-semibold text-xs text-gray-700 uppercase hover:bg-gray-300 focus:outline-none focus:bg-gray-300 active:bg-gray-300 transition">
                        ← Previous Camera
                    </a>
                @endif
                
                @if($nextCamera)
                    <a href="{{ route('cameras.show', $nextCamera) }}" class="inline-flex items-center px-4 py-2 bg-gray-200 border border-transparent rounded-md font-semibold text-xs text-gray-700 uppercase hover:bg-gray-300 focus:outline-none focus:bg-gray-300 active:bg-gray-300 transition">
                        Next Camera →
                    </a>
                @endif
            </div>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-0">
                    <div class="p-6 bg-white border-b border-gray-200">
                        <div class="relative h-80 bg-gray-200 mb-4">
                            @if($camera->image)
                                <img src="{{ asset('storage/' . $camera->image) }}" alt="{{ $camera->name }}" class="w-full h-full object-cover">
                            @else
                                <div class="flex items-center justify-center w-full h-full bg-gray-100 text-gray-500">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-20 w-20" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 9a2 2 0 012-2h.93a2 2 0 001.664-.89l.812-1.22A2 2 0 0110.07 4h3.86a2 2 0 011.664.89l.812 1.22A2 2 0 0018.07 7H19a2 2 0 012 2v9a2 2 0 01-2 2H5a2 2 0 01-2-2V9z" />
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 13a3 3 0 11-6 0 3 3 0 016 0z" />
                                    </svg>
                                </div>
                            @endif
                        </div>

                        <h1 class="text-2xl font-bold text-gray-900 mb-2">{{ $camera->name }}</h1>
                        <p class="text-gray-600 mb-6">{{ $camera->description }}</p>
                        
                        <div class="bg-gray-50 p-4 rounded-lg mb-6">
                            <h2 class="text-lg font-semibold text-gray-800 mb-3">Pricing</h2>
                            <div class="grid grid-cols-3 gap-4 text-sm">
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
                            </div>
                        </div>
                        
                        <div class="bg-gray-50 p-4 rounded-lg mb-6">
                            <h2 class="text-lg font-semibold text-gray-800 mb-3">Pickup & Return Information</h2>
                            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 text-sm">
                                <div>
                                    <p class="text-gray-500">Pickup Location</p>
                                    <p class="font-semibold text-gray-800">{{ $camera->details->pickup_location }}</p>
                                </div>
                                <div>
                                    <p class="text-gray-500">Pickup Time</p>
                                    <p class="font-semibold text-gray-800">{{ \Carbon\Carbon::parse($camera->details->return_time)->format('h:i A') }}</p>
                                </div>
                                <div>
                                    <p class="text-gray-500">Delivery Available</p>
                                    <p class="font-semibold text-gray-800">{{ $camera->details->delivery_available ? 'Yes' : 'No' }}</p>
                                </div>
                            </div>
                        </div>
                        
                        @auth
                            @if(auth()->user()->role === 'client')
                                <div class="mt-6">
                                    <a href="{{ route('client.bookings.create', $camera) }}" class="block w-full text-center bg-blue-600 hover:bg-blue-700 text-white font-semibold py-3 px-4 rounded">
                                        Book This Camera
                                    </a>
                                </div>
                            @endif
                        @else
                            <div class="mt-6">
                                <a href="{{ route('login') }}" class="block w-full text-center bg-gray-600 hover:bg-gray-700 text-white font-semibold py-3 px-4 rounded">
                                    Login to Book
                                </a>
                            </div>
                        @endauth
                    </div>
                    
                    <div class="p-6 bg-white border-b border-gray-200">
                        <h2 class="text-xl font-semibold text-gray-800 mb-4">Availability Calendar</h2>
                        <x-calendar :bookings="$camera->bookings->where('status', '!=', 'cancelled')" :cameraId="$camera->id" />
                        
                        <div class="mt-8">
                            <h2 class="text-xl font-semibold text-gray-800 mb-4">Terms & Conditions</h2>
                            <div class="bg-gray-50 p-4 rounded-lg prose max-w-none">
                                {!! nl2br(e($camera->details->terms_conditions)) !!}
                            </div>
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
                    <h3 class="text-xl font-semibold text-gray-900 mb-4">Terms & Conditions</h3>
                    <div class="prose max-w-none">
                        {!! nl2br(e($camera->details->terms_conditions)) !!}
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    @push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Store camera details for calculation
            const rentalPrice = {{ $camera->rental_price }};
            const bookingDeposit = {{ $camera->booking_deposit }};
            const securityDeposit = {{ $camera->security_deposit }};
            
            // Hidden input to store booking data for validation
            const bookings = @json($camera->bookings->where('status', '!=', 'cancelled'));
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
            
            // Add event listeners if the booking form exists
            if (startDateInput && endDateInput) {
                startDateInput.addEventListener('change', calculateTotals);
                endDateInput.addEventListener('change', calculateTotals);
                
                if (bookingForm) {
                    bookingForm.addEventListener('submit', function(e) {
                        if (!validateDates()) {
                            e.preventDefault();
                        }
                    });
                }
                
                // Initial calculation
                calculateTotals();
            }
        });
    </script>
    @endpush
</x-app-layout>