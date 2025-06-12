<?php

namespace App\Http\Controllers;

use App\Models\Review;
use App\Models\Service;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ReviewController extends Controller
{
    public function create(Service $service)
    {
        // Pastikan user hanya bisa review jika dia terlibat (provider/requester) dan layanan sudah selesai
        $userId = Auth::id();
        if (!in_array($userId, [$service->user_id, $service->requested_by]) || $service->status !== 'completed') {
            abort(403, 'Unauthorized to review this service');
        }

        return view('services.review', compact('service'));
    }

    public function store(Request $request, Service $service)
    {
        $request->validate([
            'rating' => 'required|integer|min:1|max:5',
            'comment' => 'nullable|string|max:1000',
        ]);

        Review::create([
            'user_id' => $service->user_id,       
            'reviewer_id' => auth()->id(),   
            'service_id' => $service->id,  
            'rating' => $request->rating,
            'comment' => $request->comment,
        ]);

        return redirect()->route('services.show', $service)->with('success', 'Review submitted successfully!');
    }
}
