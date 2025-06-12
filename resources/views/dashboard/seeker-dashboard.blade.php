{{-- <x-app-layout>
    @push('styles')
        @vite(['resources/css/seeker-dashboard.css'])
    @endpush

    <div class="seeker-dashboard">
        <!-- Greeting Section -->
        <div class="greeting">
            <h1>Hello, {{ Auth::user()->username }}!</h1>
            <p>Find the best service providers for your needs</p>
        </div>

        <!-- Recommendations Section -->
        <section class="recommendations mb-12">
            <h2 class="text-2xl font-semibold mb-6">Recommendations For You</h2>
            <div class="provider-grid">
                @forelse($recommendedServices as $service)
                    <div class="service-card">
                        <div class="service-content">
                            <div class="provider-info">
                                <img src="{{ $service->user->photo ? asset('storage/profile-photos/'.$service->user->photo) : asset('storage/profile-photos/default_photo.jpg') }}" 
                                    alt="{{ $service->user->full_name }}" class="provider-avatar">
                                <div>
                                    <p class="provider-name">{{ $service->user->full_name }}</p>
                                    <h3>{{ $service->title }}</h3>
                                    <div class="rating">
                                        <span class="stars">{{ str_repeat('★', round($service->user->reviews_avg_rating)) }}{{ str_repeat('☆', 5 - round($service->user->reviews_avg_rating)) }}</span>
                                        <span>{{ number_format($service->user->reviews_avg_rating, 1) }} ({{ $service->user->reviews_count }})</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                        <div class="service-actions">
                            <button class="like-btn {{ $service->isLikedBy(auth()->user()) ? 'liked' : '' }}" 
                                    data-service-id="{{ $service->id }}"
                                    data-liked="{{ $service->isLikedBy(auth()->user()) ? 'true' : 'false' }}">
                                <i class="{{ $service->isLikedBy(auth()->user()) ? 'fas' : 'far' }} fa-heart"></i>
                            </button>

                            <a href="{{ route('services.show', $service->id) }}" class="view-btn">
                                View Details
                            </a>

                            <a href="{{ route('chat', ['key' => $service->user->id]) }}" class="chat-btn">
                                <i class="far fa-comment-dots"></i> Chat
                            </a>
                        </div>
                    </div>
                @empty
                    <p class="text-gray-500">No recommended services available.</p>
                @endforelse
            </div>
        </section>

        <!-- Services You've Liked Section -->
        <section class="liked-services mb-12">
            <h2 class="text-2xl font-semibold mb-6">Services You've Liked</h2>
            <div class="service-grid">
                @forelse($likedServices as $service)
                    <div class="service-card">
                        <div class="service-content">
                            <div class="provider-info">
                                <img src="{{ $service->user->photo ? asset('storage/profile-photos/'.$service->user->photo) : asset('storage/profile-photos/default_photo.jpg') }}" 
                                    alt="{{ $service->user->full_name }}" class="provider-avatar">
                                <div>
                                    <p class="provider-name">{{ $service->user->full_name }}</p>
                                    <h3>{{ $service->title }}</h3>
                                    <div class="rating">
                                        <span class="stars">{{ str_repeat('★', round($service->user->reviews_avg_rating)) }}{{ str_repeat('☆', 5 - round($service->user->reviews_avg_rating)) }}</span>
                                        <span>{{ number_format($service->user->reviews_avg_rating, 1) }} ({{ $service->user->reviews_count }})</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                        <div class="service-actions">
                            <button class="like-btn {{ $service->isLikedBy(auth()->user()) ? 'liked' : '' }}" 
                                    data-service-id="{{ $service->id }}"
                                    data-liked="{{ $service->isLikedBy(auth()->user()) ? 'true' : 'false' }}">
                                <i class="{{ $service->isLikedBy(auth()->user()) ? 'fas' : 'far' }} fa-heart"></i>
                            </button>

                            <a href="{{ route('services.show', $service->id) }}" class="view-btn">
                                View Details
                            </a>

                            <a href="{{ route('chat') }}?recipient_id={{ $service->user->id }}" class="chat-btn">
                                <i class="far fa-comment-dots">Chat</i> 
                            </a>
                        </div>
                    </div>
                @empty
                    <div class="no-results">
                        <p>You haven't liked any services yet.</p>
                        <a href="{{ route('services.index') }}" class="explore-btn">
                            Explore Services
                        </a>
                    </div>
                @endforelse
            </div>
            
            @if($likedServices->hasPages())
                <div class="pagination-wrapper">
                    {{ $likedServices->links() }}
                </div>
            @endif
        </section>

        <!-- Categories Section -->
        <section class="categories">
            <div class="section-header">
                <h2>Categories</h2>
                <a href="{{ route('categories.index') }}" class="view-all">View All</a>
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

                        </div>
                    </a>
                @empty
                    <p class="no-results">No categories available</p>
                @endforelse
            </div>
        </section>

        <!-- Offered Services -->
        <div class="mb-8">
            <h2 class="text-xl font-semibold mb-4">Services You Offer</h2>
            @forelse($offeredServices as $service)
                <div class="bg-white rounded-lg shadow p-4 mb-4">
                    <h3 class="font-medium">{{ $service->title }}</h3>
                    @if($service->requester)
                        <p>Requested by: {{ $service->requester->full_name }} ({{ $service->requester->username }})</p>
                    @endif
                    <p>Status: {{ $service->status }}</p>
                </div>
            @empty
                <p class="text-gray-500">You haven't offered any services yet.</p>
            @endforelse
        </div>

        <!-- Requested Services -->
        <div class="mb-8">
            <h2 class="text-xl font-semibold mb-4">Services You've Requested</h2>
            @forelse($requestedServices as $service)
                <div class="bg-white rounded-lg shadow p-4 mb-4">
                    <h3 class="font-medium">{{ $service->title }}</h3>
                    <p>Offered by: {{ $service->provider->full_name }}</p>
                    <p>Status: {{ $service->status }}</p>
                </div>
            @empty
                <p class="text-gray-500">You haven't requested any services yet.</p>
            @endforelse
        </div>
    </div>

    @push('scripts')
        @vite(['resources/js/seeker-dashboard.js'])
    @endpush
</x-app-layout>
 --}}


<x-app-layout>
    @push('styles')
        @vite(['resources/css/seeker-dashboard.css'])
    @endpush

    <div class="seeker-dashboard">
        <div class="greeting">
            <h1>Hello, {{ Auth::user()->username }}!</h1>
            <p>Find the best service providers for your needs</p>
        </div>

        <section class="recommendations mb-12">
            <h2 class="text-2xl font-semibold mb-6">Recommendations For You</h2>
            <div class="provider-grid">
                @forelse($recommendedServices as $service)
                    <div class="service-card">
                        <div class="service-content">
                            <div class="provider-info">
                                <img src="{{ $service->user->photo ? asset('storage/profile-photos/'.$service->user->photo) : asset('storage/profile-photos/default_photo.jpg') }}"
                                    alt="{{ $service->user->full_name }}" class="provider-avatar">
                                <div>
                                    <p class="provider-name">{{ $service->user->full_name }}</p>
                                    <h3>{{ $service->title }}</h3>
                                    <div class="rating">
                                        {{-- Pastikan relasi 'reviews' dan 'reviews_avg_rating' ada di model User --}}
                                        <span class="stars">{{ str_repeat('★', round($service->user->reviews_avg_rating)) }}{{ str_repeat('☆', 5 - round($service->user->reviews_avg_rating)) }}</span>
                                        <span>{{ number_format($service->user->reviews_avg_rating, 1) }} ({{ $service->user->reviews_count }})</span>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="service-actions">
                            <button class="like-btn {{ $service->isLikedBy(auth()->user()) ? 'liked' : '' }}"
                                    data-service-id="{{ $service->id }}"
                                    data-liked="{{ $service->isLikedBy(auth()->user()) ? 'true' : 'false' }}">
                                <i class="{{ $service->isLikedBy(auth()->user()) ? 'fas' : 'far' }} fa-heart"></i>
                            </button>

                            {{-- Tombol View Details dan Chat selalu muncul untuk rekomendasi --}}
                            <a href="{{ route('services.show', $service->id) }}" class="view-btn">
                                View Details
                            </a>

                            <a href="javascript:void(0)"
                            onclick="setChatPartner({{ $service->user->id }}, '{{ $service->user->username }}')"
                            class="chat-btn">
                                <i class="far fa-comment-dots"></i> Chat
                            </a>
                        </div>
                    </div>
                @empty
                    <p class="text-gray-500">No recommended services available at the moment.</p>
                @endforelse
            </div>
        </section>

        <section class="liked-services mb-12">
            <h2 class="text-2xl font-semibold mb-6">Services You've Liked</h2>
            <div class="service-grid">
                @forelse($likedServices as $service)
                    <div class="service-card">
                        <div class="service-content">
                            <div class="provider-info">
                                <img src="{{ $service->user->photo ? asset('storage/profile-photos/'.$service->user->photo) : asset('storage/profile-photos/default_photo.jpg') }}"
                                    alt="{{ $service->user->full_name }}" class="provider-avatar">
                                <div>
                                    <p class="provider-name">{{ $service->user->full_name }}</p>
                                    <h3>{{ $service->title }}</h3>
                                    <div class="rating">
                                        <span class="stars">{{ str_repeat('★', round($service->user->reviews_avg_rating)) }}{{ str_repeat('☆', 5 - round($service->user->reviews_avg_rating)) }}</span>
                                        <span>{{ number_format($service->user->reviews_avg_rating, 1) }} ({{ $service->user->reviews_count }})</span>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="service-actions">
                            @if ($service->requested_by !== null)
                                {{-- Jika ada yang request, tampilkan status deal --}}
                                <a href="{{ route('services.show', $service->id) }}" class="view-btn">
                                    View Details
                                </a>
                                
                                @if ($service->status === 'pending')
                                    <span class="status-indicator pending-deal">Deal Pending</span>
                                @elseif ($service->status === 'on-going')
                                    <span class="status-indicator on-going-deal">Deal On-going</span>
                                @elseif ($service->status === 'completed')
                                    <span class="status-indicator completed-deal">Deal Completed</span>
                                @elseif ($service->status === 'cancelled')
                                    <span class="status-indicator cancelled-deal">Deal Cancelled</span>
                                @elseif ($service->status === 'rejected')
                                    <span class="status-indicator rejected-deal">Deal Rejected</span>
                                @else
                                    {{-- Fallback jika status tidak dikenal tapi requested_by tidak null --}}
                                    <span class="status-indicator unknown-status">Deal Status: {{ ucfirst($service->status) }}</span>
                                @endif
                            @else
                                {{-- Jika belum ada request, tampilkan tombol like, view, chat --}}
                                <button class="like-btn {{ $service->isLikedBy(auth()->user()) ? 'liked' : '' }}"
                                        data-service-id="{{ $service->id }}"
                                        data-liked="{{ $service->isLikedBy(auth()->user()) ? 'true' : 'false' }}">
                                    <i class="{{ $service->isLikedBy(auth()->user()) ? 'fas' : 'far' }} fa-heart"></i>
                                </button>

                                <a href="{{ route('services.show', $service->id) }}" class="view-btn">
                                    View Details
                                </a>

                                <a href="{{ route('chat', ['recipient_id' => $service->user->id]) }}" class="chat-btn">
                                    <i class="far fa-comment-dots"></i> Chat
                                </a>
                            @endif
                        </div>
                    </div>
                @empty
                    <div class="no-results">
                        <p>You haven't liked any services yet.</p>
                        <a href="{{ route('services.index') }}" class="explore-btn">
                            Explore Services
                        </a>
                    </div>
                @endforelse
            </div>

            @if($likedServices->hasPages())
                <div class="pagination-wrapper">
                    {{ $likedServices->links() }}
                </div>
            @endif
        </section>

        <section class="categories">
            <div class="section-header">
                <h2>Categories</h2>
                <a href="{{ route('categories.index') }}" class="view-all">View All</a>
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
                        </div>
                    </a>
                @empty
                    <p class="no-results">No categories available</p>
                @endforelse
            </div>
        </section>

        <div class="mb-8">
            <h2 class="text-xl font-semibold mb-4">Services You Offer</h2>
            @forelse($offeredServices as $service)
                <div class="bg-white rounded-lg shadow p-4 mb-4">
                    <h3 class="font-medium">{{ $service->title }}</h3>
                    @if($service->requester)
                        <p>Requested by: {{ $service->requester->full_name }} ({{ $service->requester->username }})</p>
                    @endif
                    <p>Status: {{ $service->status }}</p>
                </div>
            @empty
                <p class="text-gray-500">You haven't offered any services yet.</p>
            @endforelse
        </div>

        <div class="mb-8">
            <h2 class="text-xl font-semibold mb-4">Services You've Requested</h2>
            @forelse($requestedServices as $service)
                <div class="bg-white rounded-lg shadow p-4 mb-4">
                    <h3 class="font-medium">{{ $service->title }}</h3>
                    <p>Offered by: {{ $service->provider->full_name }}</p>
                    <p>Status: {{ $service->status }}</p>
                </div>
            @empty
                <p class="text-gray-500">You haven't requested any services yet.</p>
            @endforelse
        </div>
    </div>

    @push('scripts')
        @vite(['resources/js/seeker-dashboard.js'])
    @endpush
</x-app-layout>

