<x-app-layout>
    @push('styles')
        @vite(['resources/css/seeker-dashboard.css']) {{-- Pakai styling dashboard --}}
    @endpush

    <div class="seeker-dashboard">
        <div class="section-header mb-6">
            <h2 class="text-2xl font-bold">All Categories</h2>
            <a href="{{ route('seeker-dashboard') }}" class="back-btn">
                ← Back
            </a>
        </div>

        <div class="category-grid">
            @forelse($categories as $category)
                <a href="{{ route('categories.services', $category) }}" class="category-card">
                    <img src="{{ asset('storage/'.$category->image) }}" 
                        alt="{{ $category->name }}"
                        class="w-full h-32 object-cover rounded-t-lg">
                    <div class="p-4">
                        <h3 class="font-bold text-lg">{{ $category->name }}</h3>
                        <p class="text-gray-600 text-sm mt-1">{{ $category->description }}</p>
                        <div class="mt-2 text-xs text-gray-500">
                            {{ $category->services()->count() }} services available
                        </div>
                    </div>
                </a>
            @empty
                <p class="no-results">No categories available</p>
            @endforelse
        </div>
    </div>
    
    @push('scripts')
        @vite(['resources/js/seeker-dashboard.js']) {{-- Optional jika dipakai --}}
    @endpush
</x-app-layout>
