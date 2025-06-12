<x-app-layout>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    <div class="flex justify-between items-center mb-6">
                        <h2 class="text-2xl font-bold">Services in {{ $category->name }}</h2>
                        <a href="{{ route('categories.index') }}" class="btn-secondary">
                            Back to Categories
                        </a>
                    </div>

                    <form method="GET" action="{{ route('categories.show', $category) }}" class="mb-6">
                        <div class="flex items-center gap-2">
                            <input type="text" name="search" placeholder="Search services..." 
                                value="{{ request('search') }}"
                                class="w-full px-4 py-2 border rounded-md focus:ring focus:ring-blue-200">
                            <button type="submit" class="btn-primary px-4 py-2">Search</button>
                        </div>
                    </form>
                    
                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                        @forelse($services as $service)
                            <div class="border rounded-lg p-4 hover:shadow-md transition">
                                <div class="flex items-center mb-3">
                                    <img src="{{ $service->user->photo ? asset('storage/profile-photos/'.$service->user->photo) : asset('storage/profile-photos/default_photo.jpg') }}" 
                                         alt="{{ $service->user->full_name }}" 
                                         class="w-14 h-14 rounded-full mr-3">
                                    <div>
                                        <p class="provider-name">{{ $service->user->full_name }}</p>
                                        <p class="font-medium">{{ $service->user->username }}</p>
                                        <div class="flex items-center text-sm text-yellow-500">
                                            @for($i = 1; $i <= 5; $i++)
                                                @if($i <= round($service->reviews_avg_rating))
                                                    ★
                                                @else
                                                    ☆
                                                @endif
                                            @endfor
                                            <span class="text-gray-600 ml-1">
                                                ({{ $service->reviews_count }} reviews)
                                            </span>
                                        </div>
                                    </div>
                                </div>
                                
                                <h3 class="font-bold text-lg">{{ $service->title }}</h3>
                                <p class="text-gray-600 dark:text-gray-400 my-2">
                                    {{ Str::limit($service->description, 100) }}
                                </p>
                                <div class="flex justify-between items-center mt-4">
                                    <span class="text-sm font-medium">
                                        Delivery: {{ $service->delivery_time }} days
                                    </span>
                                    <a href="{{ route('services.show', $service) }}" 
                                       class="btn-primary px-3 py-1 text-sm">
                                        View Details
                                    </a>
                                </div>
                            </div>
                        @empty
                            <div class="col-span-3 text-center py-8">
                                <p class="text-gray-500">No services available in this category yet.</p>
                            </div>
                        @endforelse
                    </div>

                    @if($services->hasPages())
                        <div class="mt-6">
                            {{ $services->links() }}
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</x-app-layout>