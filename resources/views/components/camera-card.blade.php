@props(['camera'])

<div class="bg-white rounded-lg shadow-md overflow-hidden">
    <div class="relative h-48 bg-gray-200">
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
    
    <div class="p-4">
        <h3 class="font-bold text-xl mb-2">{{ $camera->name }}</h3>
        
        <p class="text-gray-600 text-sm mb-4 line-clamp-2">{{ $camera->description }}</p>
        
        <div class="flex justify-between items-center text-sm text-gray-600 mb-4">
            <div>${{ $camera->rental_price }}/day</div>
            @if($camera->is_active)
                <div class="text-green-600">Available</div>
            @else
                <div class="text-red-600">Unavailable</div>
            @endif
        </div>
        
        <a href="{{ route('cameras.show', $camera) }}" class="block w-full text-center bg-blue-600 hover:bg-blue-700 text-white font-semibold py-2 px-4 rounded">
            View Details
        </a>
    </div>
</div>