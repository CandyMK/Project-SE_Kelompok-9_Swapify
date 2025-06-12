{{-- <x-app-layout>
    <div class="max-w-4xl mx-auto py-12 px-6">
        <h1 class="text-3xl font-bold mb-4">{{ $service->title }}</h1>

        <p>Requester ID: {{ $service->requested_by }}</p>
        <p>Logged in user ID: {{ auth()->id() }}</p>
        <p>User is requester? {{ auth()->id() === $service->requested_by ? 'Yes' : 'No' }}</p>


        <div class="mb-6">
            <p><strong>Category:</strong> {{ $service->category->name }}</p>
            <p><strong>Delivery Time:</strong> {{ $service->delivery_time }} days</p>
            <p><strong>Status:</strong> 
                <span class="{{ $service->status === 'active' ? 'text-green-600' : 'text-gray-600' }}">
                    {{ ucfirst($service->status) }}
                </span>
            </p>
            <p class="mt-4">{{ $service->description }}</p>
        </div>

        <hr class="my-6">

        <div>
            <h2 class="text-2xl font-semibold mb-2">Provider Info</h2>
            <p><strong>Full Name:</strong> {{ $service->provider->full_name ?? 'N/A' }}</p>
            <p><strong>Username:</strong> {{ $service->provider->username ?? 'N/A' }}</p>
        </div>

        <hr class="my-6">

        <div>
            <h2 class="text-2xl font-semibold mb-4">Reviews</h2>
            @if(optional($service->provider)->reviews && $service->provider->reviews->count() > 0)
                <ul class="space-y-4">
                    @foreach ($service->provider->reviews as $review)
                        <li class="border rounded p-4 shadow">
                            <p><strong>Reviewer:</strong> {{ $review->reviewer->full_name ?? $review->reviewer->username ?? 'Unknown' }}</p>
                            <p><strong>Rating:</strong> {{ $review->rating }} / 5</p>
                            <p class="mt-2">{{ $review->comment }}</p>
                        </li>
                    @endforeach
                </ul>
            @else
                <p class="text-gray-500">No reviews yet.</p>
            @endif
        </div>

        @php
            $authId = auth()->id();
            $isProvider = $authId === $service->user_id;
            $isRequester = $authId === $service->requested_by;
            $isDealOffered = $service->deal_with !== null;

            $canRequestDeal = !$service->is_dealed && !$isDealOffered && $isRequester;
            $canAcceptDeal = !$service->is_dealed && $isProvider && $service->deal_with === $authId;
        @endphp --}}

        {{-- Deal Button --}}
        {{-- @if ($canRequestDeal)
            <form method="POST" action="{{ route('services.requestDeal', $service) }}" class="mt-6">
                @csrf
                <button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700 transition">
                    Request Deal
                </button>
            </form>
        @endif

        
        @php
            $canCancelRequest = auth()->id() === $service->requested_by 
                                && !in_array($service->status, ['completed', 'cancelled']);
        @endphp

        @if ($canCancelRequest)
            <form method="POST" action="{{ route('services.cancelRequest', $service) }}" class="mt-4">
                @csrf
                @method('PATCH')
                <button type="submit" class="px-4 py-2 bg-red-600 text-white rounded hover:bg-red-700 transition">
                    Cancel Request
                </button>
            </form>
        @endif --}}

        {{-- Accept Deal Button --}}
        {{-- @if ($canAcceptDeal)
            <form method="POST" action="{{ route('services.acceptDeal', $service) }}" class="mt-4">
                @csrf
                <button type="submit" class="px-4 py-2 bg-yellow-600 text-white rounded hover:bg-yellow-700 transition">
                    Accept Deal
                </button>
            </form>
        @endif --}}

        {{-- Confirm Button --}}
        {{-- @php
            $canConfirm = $service->is_dealed &&
                        in_array(auth()->id(), [$service->user_id, $service->deal_with]) &&
                        !($service->provider_confirmed && $service->requester_confirmed);
        @endphp

        @if ($canConfirm)
            <form method="POST" action="{{ route('services.confirmTrade', $service) }}" class="mt-4">
                @csrf
                <button type="submit"
                    class="px-4 py-2 bg-green-600 text-white rounded hover:bg-green-700 transition">
                        Confirm Done
                </button>
            </form>

            <p class="mt-2 text-sm text-gray-600">
                {{ $service->provider_confirmed ? 'Provider ✅' : 'Provider ❌' }} | 
                {{ $service->requester_confirmed ? 'Requester ✅' : 'Requester ❌' }}
            </p>
        @endif

    </div>
</x-app-layout> --}}

<x-app-layout>
    <div class="max-w-4xl mx-auto py-12 px-6">
        <h1 class="text-3xl font-bold mb-4">{{ $service->title }}</h1>

        <div class="mb-6">
            <p><strong>Category:</strong> {{ $service->category->name }}</p>
            <p><strong>Delivery Time:</strong> {{ $service->delivery_time }} days</p>
            <p><strong>Status:</strong>
                <span class="{{ $service->status === 'completed' ? 'text-green-600' : ($service->status === 'cancelled' || $service->status === 'rejected' ? 'text-red-600' : 'text-yellow-600') }}">
                    {{ ucfirst($service->status) }}
                </span>
            </p>
            <p class="mt-4">{{ $service->description }}</p>
        </div>

        <hr class="my-6">

        <div>
            <h2 class="text-2xl font-semibold mb-2">Provider Info</h2>
            <p><strong>Full Name:</strong> {{ $service->provider->full_name ?? 'N/A' }}</p>
            <p><strong>Username:</strong> {{ $service->provider->username ?? 'N/A' }}</p>
        </div>

        <hr class="my-6">

        <div>
            <h2 class="text-2xl font-semibold mb-4">Reviews</h2>
            @if(optional($service->provider)->reviews && $service->provider->reviews->count() > 0)
                <ul class="space-y-4">
                    @foreach ($service->provider->reviews as $review)
                        <li class="border rounded p-4 shadow">
                            <p><strong>Reviewer:</strong> {{ $review->reviewer->full_name ?? $review->reviewer->username ?? 'Unknown' }}</p>
                            <p><strong>Rating:</strong> {{ $review->rating }} / 5</p>
                            <p class="mt-2">{{ $review->comment }}</p>
                        </li>
                    @endforeach
                </ul>
            @else
                <p class="text-gray-500">No reviews yet.</p>
            @endif
        </div>

        @auth {{-- Ensure user is logged in to see these actions --}}
            @php
                $authId = auth()->id();
                $isProvider = $authId === $service->user_id;
                $isRequester = $authId === $service->requested_by;
                $isUserInvolved = $isProvider || $isRequester; // True if current user is either provider or requester
                $isDealActive = $service->is_dealed && $service->status === 'on-going';

                // Conditions for 'Request Deal' button
                $showRequestDealButton = !$isProvider && $service->status === 'available' && $service->requested_by === null;

                // Conditions for Provider actions (Accept/Reject)
                $showAcceptRejectButtons = $isProvider && $service->status === 'pending' && $service->requested_by !== null && !$service->is_dealed;

                // Condition for Requester to cancel their own request (if not yet dealt or if on-going but not confirmed)
                $showCancelRequestButton = $isRequester && in_array($service->status, ['pending', 'on-going']) && !$service->is_dealed;

                // Condition for Confirm/Finish Deal button
                $showFinishDealButton = $isDealActive && ($isProvider || $isRequester); // Show if deal is active and user is involved

            @endphp

            <div class="mt-8 space-y-4">
                {{-- Message if already requested by someone else --}}
                @if($service->requested_by !== null && !$isUserInvolved)
                    <p class="text-yellow-600">This service has a pending/active request from another user.</p>
                @endif

                {{-- Request Deal Button (for other users when service is available) --}}
                @if ($showRequestDealButton)
                    <form method="POST" action="{{ route('services.requestDeal', $service) }}">
                        @csrf
                        <button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700 transition">
                            Request Deal
                        </button>
                    </form>
                @endif

                {{-- Provider Actions: Accept/Reject Deal --}}
                @if ($showAcceptRejectButtons)
                    <p class="text-gray-500">Service requested by: {{ $service->requester->username }}</p>
                    <form method="POST" action="{{ route('services.acceptDeal', $service) }}" class="inline-block mr-2">
                        @csrf
                        <button type="submit" class="px-4 py-2 bg-green-600 text-white rounded hover:bg-green-700 transition">
                            Accept Deal
                        </button>
                    </form>
                    <form method="POST" action="{{ route('services.rejectRequest', $service) }}" class="inline-block">
                        @csrf
                        @method('PATCH')
                        <button type="submit" class="px-4 py-2 bg-red-600 text-white rounded hover:bg-red-700 transition" onclick="return confirm('Are you sure you want to reject this request?')">
                            Reject Deal
                        </button>
                    </form>
                @endif

                {{-- Requester Action: Cancel Request (for the current user who requested it) --}}
                @if ($showCancelRequestButton)
                    <form method="POST" action="{{ route('services.cancelRequest', $service) }}">
                        @csrf
                        @method('PATCH')
                        <button type="submit" class="px-4 py-2 bg-red-600 text-white rounded hover:bg-red-700 transition" onclick="return confirm('Are you sure you want to cancel your request?')">
                            Cancel My Request
                        </button>
                    </form>
                @endif

                {{-- Confirm/Finish Deal Button (for both provider and requester once deal is active) --}}
                @if ($showFinishDealButton)
                    {{-- Hanya tampilkan tombol jika user belum konfirmasi --}}
                    @if (($isProvider && !$service->provider_confirmed) || ($isRequester && !$service->requester_confirmed))
                        <form method="POST" action="{{ route('services.confirmTrade', $service) }}">
                            @csrf
                            {{-- Tidak perlu @method('PATCH') di sini karena route adalah POST --}}
                            <button type="submit" class="px-4 py-2 bg-indigo-600 text-white rounded hover:bg-indigo-700 transition">
                                Finish Deal
                            </button>
                        </form>
                    @endif
                    <p class="mt-2 text-sm text-gray-600">
                        Confirmation Status:
                        {{ $service->provider_confirmed ? 'Provider Confirmed ✅' : 'Provider Awaiting Confirmation ❌' }} |
                        {{ $service->is_dealed && $service->requester_confirmed ? 'Requester Confirmed ✅' : 'Requester Awaiting Confirmation ❌' }}
                    </p>
                @endif

                @if($service->status === 'completed' && $isUserInvolved && !$hasUserReviewed)
                    <a href="{{ route('services.review.create', $service) }}" class="btn-primary mt-2">
                        Rate & Review
                    </a>
                @elseif ($service->status === 'completed' && $isUserInvolved && $hasUserReviewed)
                    <p class="text-green-600 font-semibold">You have already reviewed this service. Thank you!</p>
                @endif

                {{-- Message if service is completed or cancelled --}}
                @if ($service->status === 'completed')
                    <p class="text-green-600 font-semibold">This service has been successfully completed!</p>
                @elseif ($service->status === 'cancelled')
                    <p class="text-red-600 font-semibold">This service request has been cancelled.</p>
                @elseif ($service->status === 'rejected')
                    <p class="text-red-600 font-semibold">This service request was rejected by the provider.</p>
                @endif
            </div>
        @else
            <p class="mt-8 text-gray-500">Log in to request this service.</p>
        @endauth
    </div>
</x-app-layout>