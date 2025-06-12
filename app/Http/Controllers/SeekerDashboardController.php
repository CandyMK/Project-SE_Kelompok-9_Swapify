<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Service;
use App\Models\Category;
use App\Models\Conversation;
use Illuminate\Http\Request;

class SeekerDashboardController extends Controller
{
    public function index()
    {
        $user = auth()->user();
    
        // Get categories
        $categories = Category::query()
            ->limit(5)
            ->get();

        // Get liked services with reviews data
        $likedServices = auth()->user()->likedServices()
            ->where('services.user_id', '!=', auth()->id())  // exclude services owned by self
            ->with(['user' => function($query) {
                $query->withCount('reviews')
                    ->withAvg('reviews', 'rating');
            }])
            ->withCount('reviews')
            ->withAvg('reviews', 'rating')
            ->paginate(6);
       
        // Get recommended services with their services if no liked services
        $recommendedServices = collect();

        if ($likedServices->isEmpty()) {
            $topUsers = User::where('id', '!=', $user->id)
                ->withCount('reviews')
                ->withAvg('reviews', 'rating')
                ->orderByDesc('reviews_avg_rating')
                ->take(5)
                ->get();

            $topUserIds = $topUsers->pluck('id');

            $recommendedServices = Service::whereIn('user_id', $topUserIds)
                ->where('user_id', '!=', $user->id)
                ->with(['user' => function ($query) {
                    $query->withCount('reviews')->withAvg('reviews', 'rating');
                }])
                ->withCount('reviews')
                ->withAvg('reviews', 'rating')
                ->take(6)
                ->get();
        }

        // Services offered by the user
        $offeredServices = $user->servicesAsProvider()
            ->with(['requester', 'category'])
            ->latest()
            ->get()
            ->map(function ($service) use ($user) {
                $conversationId = null;
                if ($service->requester) {
                    $conversation = Conversation::betweenUsers($user->id, $service->requester->id);
                    $conversationId = $conversation ? $conversation->id : null;
                }
                $service->conversationId = $conversationId;
                return $service;
            });
        
        // Services requested by the user
        $requestedServices = $user->servicesAsRequester()
            ->with(['provider', 'category'])
            ->latest()
            ->get()
            ->map(function ($service) use ($user) {
                $conversationId = null;
                if ($service->provider) {
                    $conversation = Conversation::betweenUsers($user->id, $service->requester->id);
                    $conversationId = $conversation ? $conversation->id : null;
                }
                $service->conversationId = $conversationId;
                return $service;
            });
            
        return view('dashboard.seeker-dashboard', compact(
            'likedServices',
            'recommendedServices',
            'categories',
            'offeredServices',
            'requestedServices'
        ));
    }
}