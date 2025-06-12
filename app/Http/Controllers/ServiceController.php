<?php

namespace App\Http\Controllers;

use Log;
use App\Models\User;
use App\Models\Service;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ServiceController extends Controller
{
    // Tampilkan daftar layanan
    public function index()
    {
        $user = Auth::user();
        // Layanan yang Anda tawarkan (di mana Anda adalah providernya)
        $offeredServices = Service::where('user_id', auth()->id())
            ->with(['requester', 'category'])
            ->latest()
            ->get();

        // Layanan yang Anda request (di mana Anda adalah requesternya)
        $requestedServices = Service::where('requested_by', auth()->id())
            ->with(['provider', 'category'])
            ->latest()
            ->get();

        // Layanan rekomendasi untuk pengguna lain (yang belum di-request oleh siapa pun)
        $recommendedServices = Service::where('user_id', '!=', $user->id)
            ->whereNull('requested_by') 
            ->where('status', 'available') 
            ->where('is_active', true)
            ->with(['provider.reviews', 'category']) 
            ->latest()
            ->get();

        // dd($recommendedServices->toArray());

        // Layanan yang disukai oleh user yang sedang login
        $likedServices = $user->likedServices()->with(['user.reviews', 'category', 'requester'])->latest()->get();
        
        $categories = Category::all();

        return view('services.index', compact('offeredServices', 'requestedServices', 'recommendedServices', 'likedServices', 'categories'));
    }

    // Tampilkan form untuk membuat layanan baru
    public function create()
    {
        $categories = Category::all();
        return view('services.create', compact('categories'));
    }

    // Store a new service (offered by the current user)
    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required',
            'category_id' => 'required|exists:categories,id',
            'delivery_time' => 'required|integer|min:1',
        ]);

        Service::create([
            'user_id' => auth()->id(),
            'title' => $validated['title'],
            'description' => $validated['description'],
            'category_id' => $validated['category_id'],
            'delivery_time' => $validated['delivery_time'],
            'status' => 'available', // New services are available by default
            'is_active' => true,
        ]);

        return redirect()->route('services.index')
            ->with('success', 'Service created successfully!');
    }

    // A user requests a service from another user
    public function requestDeal(Service $service)
    {
        $user = auth()->user();

        if ($user->id === $service->user_id) {
            return back()->with('error', 'You cannot request your own service.');
        }

        if ($service->requested_by !== null) {
            return back()->with('error', 'This service has already been requested by another user.');
        }

        if ($service->status !== 'available' || !$service->is_active) {
            return back()->with('error', 'This service is not currently available for requests.');
        }

        $service->update([
            'requested_by' => $user->id,
            'status' => 'pending'
        ]);

        return back()->with('success', 'Service request sent successfully. Waiting for the provider to accept.');
    }

    // Provider accepts a deal request
    public function acceptDeal(Service $service)
    {
        if (auth()->id() !== $service->user_id) {
            return back()->with('error', 'You are not authorized to accept this deal.');
        }

        if ($service->status !== 'pending' || $service->requested_by === null) {
            return back()->with('error', 'There is no pending request to accept.');
        }

        $service->update([
            'is_dealed' => true,
            'status' => 'on-going', 
            'deal_with' => $service->requested_by, 
            'provider_confirmed' => false,
            'requester_confirmed' => false,
        ]);

        return back()->with('success', 'Deal accepted! The service is now on-going.');
    }

    // Provider rejects a pending request
    public function rejectRequest(Service $service)
    {
        if ($service->user_id !== auth()->id()) {
            abort(403, 'Unauthorized action.');
        }

        if ($service->status !== 'pending' || $service->requested_by === null) {
            return redirect()->back()->with('error', 'Cannot reject this request. It is not in a pending state or has no active request.');
        }
        
        $service->update([
            'status' => 'available',
            'requested_by' => null,  
            'is_dealed' => false,  
            'deal_with' => null,
            'provider_confirmed' => false,
            'requester_confirmed' => false,
        ]);

        return redirect()->back()->with('success', 'Request rejected successfully. Service is now available.');
    }

    // Requester cancels their request
    public function cancelRequest(Service $service)
    {
        $userId = auth()->id();

        if ($service->requested_by !== $userId) {
            abort(403, 'You are not authorized to cancel this request.');
        }

        if (in_array($service->status, ['completed', 'cancelled', 'rejected'])) {
            return redirect()->back()->with('error', 'This request has already been finalized.');
        }
        
        $updateData = [];
        if ($service->is_dealed) {
            $updateData['status'] = 'cancelled';
        } else {
            $updateData['status'] = 'available'; 
            $updateData['requested_by'] = null;
            $updateData['deal_with'] = null;
        }

        $service->update($updateData);

        return redirect()->back()->with('success', 'Your service request has been cancelled.');
    }

    // Both provider and requester confirm trade completion
    public function confirmTrade(Service $service)
    {
        $userId = auth()->id();

        if (!$service->is_dealed || in_array($service->status, ['completed', 'cancelled', 'rejected'])) {
            return back()->with('error', 'This trade is not active or has already been finalized.');
        }

        if (!in_array($userId, [$service->user_id, $service->deal_with])) {
            return back()->with('error', 'You are not a party to this trade.');
        }

        if ($userId === $service->user_id) { 
            $service->update(['provider_confirmed' => true]);
        } elseif ($userId === $service->deal_with) { 
            $service->update(['requester_confirmed' => true]);
        }

        // If both parties have confirmed, mark the service as completed
        if ($service->provider_confirmed && $service->requester_confirmed) {
            $service->update(['status' => 'completed']);
            return back()->with('success', 'Trade successfully completed by both parties!');
        }

        return back()->with('success', 'Your confirmation has been recorded. Waiting for the other party.');
    }

    // Provider marks the service as complete (can be used as an override or final step)
    public function complete(Service $service)
    {
        if ($service->user_id != auth()->id()) {
            abort(403, 'Unauthorized action.');
        }

        if (in_array($service->status, ['completed', 'cancelled', 'rejected'])) {
            return back()->with('error', 'This service has already been finalized.');
        }

        $service->update([
            'status' => 'completed',
            'is_dealed' => true, 
            'provider_confirmed' => true, 
            'requester_confirmed' => true, 
        ]);

        return back()->with('success', 'Service marked as completed!');
    }


    // Tampilkan detail layanan
    public function show(Service $service)
    {
        $authId = Auth::id();

        $service->load(['provider.reviews.reviewer', 'requester', 'category']);
        $hasUserReviewed = $service->reviews->where('reviewer_id', $authId)->isNotEmpty();
        
        return view('services.show', compact('service', 'hasUserReviewed'));
    }

    // Tampilkan form edit
    public function edit(Service $service)
    {
        if ($service->user_id != auth()->id()) {
            abort(403);
        }

        $categories = Category::all();
        return view('services.edit-offer', compact('service', 'categories'));
    }

    // Update layanan
    public function update(Request $request, Service $service)
    {
        // Authorization
        if ($service->user_id != auth()->id()) {
            abort(403);
        }

        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'category_id' => 'required|exists:categories,id',
            'description' => 'required|string',
            'delivery_time' => 'required|integer|min:1',
            'is_active' => 'required|boolean'
        ]);

        $service->update($validated);

        return redirect()->route('services.index')
            ->with('success', 'Service updated successfully');
    }

    // Hapus layanan
    public function destroy(Service $service)
    {
        // Authorization
        if ($service->user_id != auth()->id()) {
            abort(403);
        }

        $service->delete();

        return redirect()->route('services.index')
            ->with('success', 'Service deleted successfully');
    }

    public function like(Service $service)
    {

        auth()->user()->likedServices()->syncWithoutDetaching([$service->id => ['is_like' => true]]);
        return response()->json(['success' => true]);
    }

    public function unlike(Service $service)
    {
        auth()->user()->likedServices()->detach($service->id);
        return response()->json(['success' => true]);
    }
}
