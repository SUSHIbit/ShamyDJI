<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('My Bookings') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    @if($bookings->count() > 0)
                        <div class="mb-6">
                            <ul class="grid grid-cols-1 gap-6">
                                @foreach($bookings as $booking)
                                    <li class="bg-gray-50 rounded-lg shadow-sm overflow-hidden">
                                        <div class="p-5">
                                            <div class="flex items-center justify-between mb-4">
                                                <h3 class="text-lg font-semibold text-gray-900">{{ $booking->camera->name }}</h3>
                                                <span class="px-3 py-1 text-xs font-semibold rounded-full 
                                                    {{ $booking->status === 'confirmed' ? 'bg-green-100 text-green-800' : 
                                                       ($booking->status === 'pending' ? 'bg-yellow-100 text-yellow-800' : 'bg-red-100 text-red-800') }}">
                                                    {{ ucfirst($booking->status) }}
                                                </span>
                                            </div>
                                            
                                            <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-4">
                                                <div>
                                                    <p class="text-sm text-gray-500">Booking Reference</p>
                                                    <p class="font-medium text-gray-900">#{{ $booking->id }}</p>
                                                </div>
                                                <div>
                                                    <p class="text-sm text-gray-500">Rental Period</p>
                                                    <p class="font-medium text-gray-900">
                                                        {{ \Carbon\Carbon::parse($booking->start_date)->format('M d, Y') }} - 
                                                        {{ \Carbon\Carbon::parse($booking->end_date)->format('M d, Y') }}
                                                    </p>
                                                </div>
                                                <div>
                                                    <p class="text-sm text-gray-500">Total Amount</p>
                                                    <p class="font-medium text-gray-900">${{ number_format($booking->total_price, 2) }}</p>
                                                </div>
                                            </div>
                                            
                                            <div class="flex justify-between items-center">
                                                <div class="text-sm text-gray-500">
                                                    Created on {{ $booking->created_at->format('M d, Y') }}
                                                </div>
                                                <div class="flex space-x-3">
                                                    @if($booking->status === 'pending')
                                                        <a href="{{ route('client.bookings.payment', $booking) }}" class="inline-flex items-center px-3 py-1 border border-transparent text-sm leading-5 font-medium rounded-md text-white bg-blue-600 hover:bg-blue-500 focus:outline-none focus:border-blue-700 focus:shadow-outline-blue active:bg-blue-700 transition ease-in-out duration-150">
                                                            Complete Payment
                                                        </a>
                                                        <form method="POST" action="{{ route('client.bookings.cancel', $booking) }}" onsubmit="return confirm('Are you sure you want to cancel this booking?');">
                                                            @csrf
                                                            @method('PATCH')
                                                            <button type="submit" class="inline-flex items-center px-3 py-1 border border-gray-300 text-sm leading-5 font-medium rounded-md text-gray-700 bg-white hover:text-gray-500 focus:outline-none focus:border-blue-300 focus:shadow-outline-blue active:text-gray-800 active:bg-gray-50 transition ease-in-out duration-150">
                                                                Cancel
                                                            </button>
                                                        </form>
                                                    @else
                                                        <a href="{{ route('client.bookings.show', $booking) }}" class="inline-flex items-center px-3 py-1 border border-gray-300 text-sm leading-5 font-medium rounded-md text-gray-700 bg-white hover:text-gray-500 focus:outline-none focus:border-blue-300 focus:shadow-outline-blue active:text-gray-800 active:bg-gray-50 transition ease-in-out duration-150">
                                                            View Details
                                                        </a>
                                                    @endif
                                                </div>
                                            </div>
                                        </div>
                                    </li>
                                @endforeach
                            </ul>
                        </div>
                        
                        <div>
                            {{ $bookings->links() }}
                        </div>
                    @else
                        <div class="text-center py-12">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-12 w-12 mx-auto text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                            </svg>
                            <h3 class="mt-2 text-xl font-medium text-gray-900">No bookings found</h3>
                            <p class="mt-1 text-sm text-gray-500">You haven't made any bookings yet.</p>
                            <div class="mt-6">
                                <a href="{{ route('cameras.index') }}" class="inline-flex items-center px-4 py-2 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                                    Browse Cameras
                                </a>
                            </div>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</x-app-layout>