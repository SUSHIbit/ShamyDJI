<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Client Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    <h3 class="text-lg font-medium text-gray-900 mb-4">Welcome, {{ auth()->user()->name }}!</h3>
                    <p class="text-gray-600 mb-6">
                        This is your dashboard where you can manage your camera bookings and view your booking history.
                    </p>
                    
                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                        <div class="bg-blue-50 rounded-lg p-6">
                            <h4 class="font-medium text-blue-700 mb-3">Quick Actions</h4>
                            <ul class="space-y-2">
                                <li>
                                    <a href="{{ route('cameras.index') }}" class="text-blue-600 hover:text-blue-800">
                                        Browse Available Cameras
                                    </a>
                                </li>
                                <li>
                                    <a href="{{ route('client.bookings.index') }}" class="text-blue-600 hover:text-blue-800">
                                        View All My Bookings
                                    </a>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @if(count($upcomingBookings) > 0 || count($pendingBookings) > 0)
    <div class="py-6">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    @if(count($pendingBookings) > 0)
                    <div class="mb-6">
                        <h3 class="text-lg font-medium text-gray-900 mb-3">Pending Bookings</h3>
                        <div class="bg-yellow-50 border border-yellow-200 rounded-md p-4 mb-4">
                            <div class="flex">
                                <div class="flex-shrink-0">
                                    <svg class="h-5 w-5 text-yellow-400" viewBox="0 0 20 20" fill="currentColor">
                                        <path fill-rule="evenodd" d="M8.257 3.099c.765-1.36 2.722-1.36 3.486 0l5.58 9.92c.75 1.334-.213 2.98-1.742 2.98H4.42c-1.53 0-2.493-1.646-1.743-2.98l5.58-9.92zM11 13a1 1 0 11-2 0 1 1 0 012 0zm-1-8a1 1 0 00-1 1v3a1 1 0 002 0V6a1 1 0 00-1-1z" clip-rule="evenodd" />
                                    </svg>
                                </div>
                                <div class="ml-3">
                                    <h3 class="text-sm font-medium text-yellow-800">
                                        You have {{ count($pendingBookings) }} pending booking(s)
                                    </h3>
                                    <div class="mt-2 text-sm text-yellow-700">
                                        <p>
                                            Complete the payment process to confirm your bookings.
                                        </p>
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                        <div class="grid grid-cols-1 gap-4">
                            @foreach($pendingBookings as $booking)
                                <div class="border border-gray-200 rounded-lg p-4">
                                    <div class="flex justify-between items-start">
                                        <div>
                                            <h4 class="font-medium text-gray-900">{{ $booking->camera->name }}</h4>
                                            <p class="text-sm text-gray-500">
                                                {{ \Carbon\Carbon::parse($booking->start_date)->format('M d, Y') }} - 
                                                {{ \Carbon\Carbon::parse($booking->end_date)->format('M d, Y') }}
                                            </p>
                                            <p class="text-sm font-medium text-gray-900 mt-1">
                                                Total: ${{ number_format($booking->total_price, 2) }}
                                            </p>
                                        </div>
                                        <div>
                                            <a href="{{ route('client.bookings.payment', $booking) }}" class="inline-flex items-center px-4 py-2 bg-blue-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-blue-700">
                                                Complete Payment
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                    @endif
                    
                    @if(count($upcomingBookings) > 0)
                    <div>
                        <h3 class="text-lg font-medium text-gray-900 mb-3">Upcoming Bookings</h3>
                        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
                            @foreach($upcomingBookings as $booking)
                                <div class="border border-gray-200 rounded-lg p-4">
                                    <h4 class="font-medium text-gray-900">{{ $booking->camera->name }}</h4>
                                    <div class="mt-2 text-sm">
                                        <p class="text-gray-500">Dates:</p>
                                        <p class="font-medium text-gray-900">
                                            {{ \Carbon\Carbon::parse($booking->start_date)->format('M d, Y') }} - 
                                            {{ \Carbon\Carbon::parse($booking->end_date)->format('M d, Y') }}
                                        </p>
                                    </div>
                                    <div class="mt-2 text-sm">
                                        <p class="text-gray-500">Pickup Location:</p>
                                        <p class="font-medium text-gray-900">
                                            {{ $booking->camera->details->pickup_location }}
                                        </p>
                                    </div>
                                    <div class="mt-4">
                                        <a href="{{ route('client.bookings.show', $booking) }}" class="text-blue-600 hover:text-blue-800 text-sm font-medium">
                                            View Details →
                                        </a>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
    @endif
    
    @if(count($pastBookings) > 0)
    <div class="py-6">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    <div class="flex justify-between items-center mb-4">
                        <h3 class="text-lg font-medium text-gray-900">Recent Bookings</h3>
                        <a href="{{ route('client.bookings.index') }}" class="text-sm text-blue-600 hover:text-blue-800">
                            View All
                        </a>
                    </div>
                    
                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-200">
                            <thead class="bg-gray-50">
                                <tr>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Camera
                                    </th>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Dates
                                    </th>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Amount
                                    </th>
                                    <th scope="col" class="relative px-6 py-3">
                                        <span class="sr-only">Actions</span>
                                    </th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200">
                                @foreach($pastBookings as $booking)
                                    <tr>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <div class="text-sm font-medium text-gray-900">{{ $booking->camera->name }}</div>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <div class="text-sm text-gray-900">
                                                {{ \Carbon\Carbon::parse($booking->start_date)->format('M d, Y') }} - 
                                                {{ \Carbon\Carbon::parse($booking->end_date)->format('M d, Y') }}
                                            </div>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <div class="text-sm text-gray-900">${{ number_format($booking->total_price, 2) }}</div>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                            <a href="{{ route('client.bookings.show', $booking) }}" class="text-blue-600 hover:text-blue-900">
                                                Details
                                            </a>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @endif
</x-app-layout>