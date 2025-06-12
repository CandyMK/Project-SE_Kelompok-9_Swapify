<x-app-layout>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    <div class="flex justify-between items-center mb-6">
                        <a href="{{ route('seeker-dashboard') }}" class="back-btn">
                            ← Back
                        </a>
                        <h2 class="text-2xl font-bold">Your Services</h2>
                        <a href="{{ route('services.create') }}" class="btn-primary">
                            + Add New Service
                        </a>
                    </div>

                    <!-- Offered Services Section -->
                    <div class="mb-8">
                        <h3 class="text-xl font-semibold mb-4">Services You Offer</h3>
                        <div class="space-y-4">
                            <!-- Di bagian "Services You Offer" -->
                            @forelse ($offeredServices as $service)
                            <div class="border rounded-lg p-4 mb-4">
                                <div class="flex justify-between items-start">
                                    <div class="flex-1">
                                        <h3 class="font-bold text-lg">{{ $service->title }}</h3>
                                        <p class="text-gray-600 dark:text-gray-400 mb-2">
                                            {{ $service->category->name }} • 
                                            Delivery: {{ $service->delivery_time }} days •
                                            Status: <span class="font-semibold {{ $service->is_active ? 'text-green-600' : 'text-gray-500' }}">
                                                {{ $service->is_active ? 'Active' : 'Inactive' }}
                                            </span>
                                        </p>
                                        <div class="prose dark:prose-invert max-w-none">
                                            <p class="text-gray-700 dark:text-gray-300">
                                                {{ $service->description }}
                                            </p>
                                        </div>
                                    </div>

                                    <div class="flex flex-col space-y-2 ml-4">
                                        <!-- Tombol Edit -->
                                        <a href="{{ route('services.edit', $service) }}" class="btn-edit">
                                            Edit
                                        </a>
                                        
                                        <!-- Tombol Delete -->
                                        <form action="{{ route('services.destroy', $service) }}" method="POST">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn-danger" 
                                                onclick="return confirm('Are you sure?')">
                                                Delete
                                            </button>
                                        </form>
                                        
                                        <!-- Tombol Status -->
                                        @if($service->is_active)
                                            <form action="{{ route('services.update', $service) }}" method="POST">
                                                @csrf
                                                @method('PUT')
                                                <input type="hidden" name="is_active" value="0">
                                                <button type="submit" class="btn-warning">
                                                    Deactivate
                                                </button>
                                            </form>
                                        @else
                                            <form action="{{ route('services.update', $service) }}" method="POST">
                                                @csrf
                                                @method('PUT')
                                                <input type="hidden" name="is_active" value="1">
                                                <button type="submit" class="btn-success">
                                                    Activate
                                                </button>
                                            </form>
                                        @endif
                                        
                                        <!-- Jika ada request -->
                                        @if($service->requested_by)
                                            <div class="pt-2 mt-2 border-t">
                                                <p class="text-sm text-gray-500">Requested by: {{ $service->requester->username }}</p>
                                                
                                                @if (!$service->is_dealed)
                                                    <form action="{{ route('services.acceptDeal', $service) }}" method="POST">
                                                        @csrf
                                                        <button type="submit" class="btn-primary text-sm">
                                                            Accept Deal
                                                        </button>
                                                    </form>
                                                @elseif ($service->is_dealed && !($service->provider_confirmed && $service->requester_confirmed))
                                                    <form action="{{ route('services.confirmTrade', $service) }}" method="POST">
                                                        @csrf
                                                        <button type="submit" class="btn-success text-sm">
                                                            Confirm Trade
                                                        </button>
                                                    </form>
                                                @endif

                                                @if($service->requested_by && $service->status === 'pending')
                                                    <form action="{{ route('services.rejectRequest', $service) }}" method="POST">
                                                        @csrf
                                                        @method('PATCH')
                                                        <button type="submit" class="btn-danger text-sm">
                                                            Reject Deal
                                                        </button>
                                                    </form>
                                                @endif
                                            </div>
                                        @endif
                                    </div>
                                </div>
                            </div>
                            @empty
                            <div class="text-center py-4">
                                <p class="text-gray-500">You haven't offered any services yet.</p>
                            </div>
                            @endforelse
                        </div>
                    </div>

                    <!-- Requested Services Section -->
                    <div class="mb-8">
                        <h3 class="text-xl font-semibold mb-4">Services You've Requested</h3>
                        
                        @forelse ($requestedServices as $service)
                        <div class="border rounded-lg p-4 mb-4 shadow-sm">
                            <div class="flex justify-between items-start">
                                <div class="flex-1">
                                    <div class="flex items-center justify-between">
                                        <h3 class="font-bold text-lg">{{ $service->title }}</h3>
                                        <span class="px-3 py-1 rounded-full text-sm 
                                            {{ $service->status === 'completed' ? 'bg-green-100 text-green-800' : 
                                            ($service->status === 'cancelled' ? 'bg-red-100 text-red-800' : 
                                            'bg-yellow-100 text-yellow-800') }}">
                                            {{ ucfirst($service->status) }}
                                        </span>
                                    </div>
                                    
                                    <p class="text-gray-600 dark:text-gray-400 mt-1">
                                        <span class="font-medium">Provider:</span> 
                                        {{ $service->provider->username }}
                                    </p>
                                    
                                    <p class="text-gray-600 dark:text-gray-400">
                                        <span class="font-medium">Category:</span> 
                                        {{ $service->category->name }}
                                    </p>
                                    
                                    <div class="mt-3 bg-gray-50 dark:bg-gray-700 p-3 rounded-lg">
                                        <h4 class="font-medium mb-1">Service Details:</h4>
                                        <p class="text-gray-700 dark:text-gray-300">{{ $service->description }}</p>
                                    </div>
                                </div>
                                
                                <div class="ml-4 flex flex-col space-y-2">
                                    <a href="{{ route('chat', ['key' => $service->conversationId]) }}" class="btn-secondary">
                                        Message
                                    </a>
                                </div>
                            </div>
                            
                            <div class="mt-3 pt-3 border-t flex justify-between items-center">
                                <span class="text-sm text-gray-500">
                                    Requested {{ $service->created_at->diffForHumans() }}
                                </span>
                                <span class="text-sm font-medium">
                                    Delivery Time: {{ $service->delivery_time }} days
                                </span>
                            </div>
                        </div>
                        @empty
                        <div class="text-center py-8 border rounded-lg bg-gray-50 dark:bg-gray-700">
                            <p class="text-gray-500 dark:text-gray-400">You haven't requested any services yet.</p>
                        </div>
                        @endforelse
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>