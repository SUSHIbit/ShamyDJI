<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Welcome to Camera Rental') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    <div class="mb-8">
                        <h1 class="text-3xl font-bold text-gray-900 mb-4">Professional Camera Rental Service</h1>
                        <p class="text-lg text-gray-600">
                            Browse our selection of high-quality cameras available for rent. Whether you're a professional photographer or enthusiast,
                            we have the perfect camera for your needs.
                        </p>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-8">
                        <div class="bg-gray-50 p-6 rounded-lg shadow-sm">
                            <h2 class="text-xl font-semibold text-gray-800 mb-2">How It Works</h2>
                            <ol class="list-decimal list-inside text-gray-600 space-y-2">
                                <li>Browse our camera collection</li>
                                <li>Check availability on the calendar</li>
                                <li>Create an account and log in</li>
                                <li>Book your desired camera for specific dates</li>
                                <li>Make the payment and upload your receipt</li>
                                <li>Pick up the camera and enjoy!</li>
                            </ol>
                        </div>
                        
                        <div class="bg-gray-50 p-6 rounded-lg shadow-sm">
                            <h2 class="text-xl font-semibold text-gray-800 mb-2">Why Choose Us</h2>
                            <ul class="list-disc list-inside text-gray-600 space-y-2">
                                <li>Professional-grade equipment</li>
                                <li>Flexible booking options</li>
                                <li>Transparent pricing with no hidden fees</li>
                                <li>Easy-to-use booking system</li>
                                <li>Convenient pickup locations</li>
                                <li>Technical support available</li>
                            </ul>
                        </div>
                    </div>
                    
                    <div class="text-center">
                        <a href="{{ route('cameras.index') }}" class="inline-flex items-center px-6 py-3 bg-blue-600 border border-transparent rounded-md font-semibold text-white hover:bg-blue-700 focus:outline-none focus:border-blue-700 focus:ring focus:ring-blue-200 active:bg-blue-600 transition">
                            Browse Available Cameras
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    @if($featuredCameras->count() > 0)
    <div class="py-6">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <h2 class="text-2xl font-bold text-gray-800 mb-6">Featured Cameras</h2>
            
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                @foreach($featuredCameras as $camera)
                    <x-camera-card :camera="$camera" />
                @endforeach
            </div>
        </div>
    </div>
    @endif
</x-app-layout>