// resources/views/client/bookings/create.blade.php
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
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 13a3 3 0 11-6 0 3 3 0 016 0z" />camera->details->pickup_time)->format('h:i A') }}</p>
                                </div>
                                <div>
                                    <p class="text-gray-500">Return Time</p>
                                    <p class="font-semibold text-gray-800">{{ \Carbon\Carbon::parse($ + totalPrice.toFixed(2);
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
            function isDateBooked(dateToCheck) {
                const checkDate = new Date(dateToCheck);
                checkDate.setHours(0, 0, 0, 0);
                
                return bookings.some(booking => {
                    const bookingStart = new Date(booking.start_date);
                    const bookingEnd = new Date(booking.end_date);
                    bookingStart.setHours(0, 0, 0, 0);
                    bookingEnd.setHours(0, 0, 0, 0);
                    
                    return checkDate >= bookingStart && checkDate <= bookingEnd;
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