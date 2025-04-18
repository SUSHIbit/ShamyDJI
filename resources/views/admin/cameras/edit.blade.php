<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Edit Camera') }}: {{ $camera->name }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    <form method="POST" action="{{ route('admin.cameras.update', $camera) }}" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')
                        
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div>
                                <h3 class="text-lg font-medium text-gray-900 mb-4">Camera Details</h3>
                                
                                <div class="mb-4">
                                    <label for="name" class="block text-sm font-medium text-gray-700">Camera Name</label>
                                    <input type="text" name="name" id="name" value="{{ old('name', $camera->name) }}" class="mt-1 focus:ring-blue-500 focus:border-blue-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md" required>
                                    @error('name')
                                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>
                                
                                <div class="mb-4">
                                    <label for="description" class="block text-sm font-medium text-gray-700">Description</label>
                                    <textarea name="description" id="description" rows="4" class="mt-1 focus:ring-blue-500 focus:border-blue-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md">{{ old('description', $camera->description) }}</textarea>
                                    @error('description')
                                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>
                                
                                <div class="mb-4">
                                    <label for="image" class="block text-sm font-medium text-gray-700">Camera Image</label>
                                    
                                    @if($camera->image)
                                        <div class="mt-2 mb-4">
                                            <div class="w-32 h-32 bg-gray-100 rounded overflow-hidden">
                                                <img src="{{ asset('storage/' . $camera->image) }}" alt="{{ $camera->name }}" class="w-full h-full object-cover">
                                            </div>
                                            <p class="mt-1 text-sm text-gray-500">Current image. Upload a new one to replace it.</p>
                                        </div>
                                    @endif
                                    
                                    <input type="file" name="image" id="image" class="mt-1 block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-md file:border-0 file:text-sm file:font-semibold file:bg-blue-50 file:text-blue-700 hover:file:bg-blue-100">
                                    @error('image')
                                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>
                                
                                <div class="mb-4">
                                    <label for="rental_price" class="block text-sm font-medium text-gray-700">Rental Price (per day)</label>
                                    <div class="mt-1 relative rounded-md shadow-sm">
                                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                            <span class="text-gray-500 sm:text-sm">$</span>
                                        </div>
                                        <input type="number" name="rental_price" id="rental_price" value="{{ old('rental_price', $camera->rental_price) }}" class="focus:ring-blue-500 focus:border-blue-500 block w-full pl-7 pr-12 sm:text-sm border-gray-300 rounded-md" placeholder="0.00" step="0.01" min="0" required>
                                    </div>
                                    @error('rental_price')
                                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>
                                
                                <div class="grid grid-cols-2 gap-4">
                                    <div class="mb-4">
                                        <label for="booking_deposit" class="block text-sm font-medium text-gray-700">Booking Deposit</label>
                                        <div class="mt-1 relative rounded-md shadow-sm">
                                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                                <span class="text-gray-500 sm:text-sm">$</span>
                                            </div>
                                            <input type="number" name="booking_deposit" id="booking_deposit" value="{{ old('booking_deposit', $camera->booking_deposit) }}" class="focus:ring-blue-500 focus:border-blue-500 block w-full pl-7 pr-12 sm:text-sm border-gray-300 rounded-md" placeholder="0.00" step="0.01" min="0" required>
                                        </div>
                                        @error('booking_deposit')
                                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                        @enderror
                                    </div>
                                    
                                    <div class="mb-4">
                                        <label for="security_deposit" class="block text-sm font-medium text-gray-700">Security Deposit</label>
                                        <div class="mt-1 relative rounded-md shadow-sm">
                                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                                <span class="text-gray-500 sm:text-sm">$</span>
                                            </div>
                                            <input type="number" name="security_deposit" id="security_deposit" value="{{ old('security_deposit', $camera->security_deposit) }}" class="focus:ring-blue-500 focus:border-blue-500 block w-full pl-7 pr-12 sm:text-sm border-gray-300 rounded-md" placeholder="0.00" step="0.01" min="0" required>
                                        </div>
                                        @error('security_deposit')
                                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                            
                            <div>
                                <h3 class="text-lg font-medium text-gray-900 mb-4">Rental Details</h3>
                                
                                <div class="mb-4">
                                    <label for="pickup_location" class="block text-sm font-medium text-gray-700">Pickup Location</label>
                                    <input type="text" name="pickup_location" id="pickup_location" value="{{ old('pickup_location', $camera->details->pickup_location) }}" class="mt-1 focus:ring-blue-500 focus:border-blue-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md" required>
                                    @error('pickup_location')
                                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>
                                
                                <div class="grid grid-cols-2 gap-4">
                                    <div class="mb-4">
                                        <label for="pickup_time" class="block text-sm font-medium text-gray-700">Pickup Time</label>
                                        <input type="time" name="pickup_time" id="pickup_time" value="{{ old('pickup_time', $camera->details->pickup_time) }}" class="mt-1 focus:ring-blue-500 focus:border-blue-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md" required>
                                        @error('pickup_time')
                                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                        @enderror
                                    </div>
                                    
                                    <div class="mb-4">
                                        <label for="return_time" class="block text-sm font-medium text-gray-700">Return Time</label>
                                        <input type="time" name="return_time" id="return_time" value="{{ old('return_time', $camera->details->return_time) }}" class="mt-1 focus:ring-blue-500 focus:border-blue-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md" required>
                                        @error('return_time')
                                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                        @enderror
                                    </div>
                                </div>
                                
                                <div class="mb-4">
                                    <div class="flex items-start">
                                        <div class="flex items-center h-5">
                                            <input id="delivery_available" name="delivery_available" type="checkbox" value="1" {{ old('delivery_available', $camera->details->delivery_available) ? 'checked' : '' }} class="focus:ring-blue-500 h-4 w-4 text-blue-600 border-gray-300 rounded">
                                        </div>
                                        <div class="ml-3 text-sm">
                                            <label for="delivery_available" class="font-medium text-gray-700">Delivery Available</label>
                                            <p class="text-gray-500">Check if you offer delivery service for this camera.</p>
                                        </div>
                                    </div>
                                    @error('delivery_available')
                                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>
                                
                                <div class="mb-4">
                                    <label for="terms_conditions" class="block text-sm font-medium text-gray-700">Terms & Conditions</label>
                                    <textarea name="terms_conditions" id="terms_conditions" rows="8" class="mt-1 focus:ring-blue-500 focus:border-blue-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md" required>{{ old('terms_conditions', $camera->details->terms_conditions) }}</textarea>
                                    @error('terms_conditions')
                                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>
                                
                                <div class="mb-4">
                                    <div class="flex items-start">
                                        <div class="flex items-center h-5">
                                            <input id="is_active" name="is_active" type="checkbox" value="1" {{ old('is_active', $camera->is_active) ? 'checked' : '' }} class="focus:ring-blue-500 h-4 w-4 text-blue-600 border-gray-300 rounded">
                                        </div>
                                        <div class="ml-3 text-sm">
                                            <label for="is_active" class="font-medium text-gray-700">Make Available for Booking</label>
                                            <p class="text-gray-500">Uncheck if you want to hide this camera from clients.</p>
                                        </div>
                                    </div>
                                    @error('is_active')
                                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>
                        </div>
                        
                        <div class="mt-6 flex justify-end space-x-3">
                            <a href="{{ route('admin.cameras.index') }}" class="inline-flex items-center px-4 py-2 border border-gray-300 rounded-md shadow-sm text-sm font-medium text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                                Cancel
                            </a>
                            <button type="submit" class="inline-flex items-center px-4 py-2 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                                Update Camera
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>