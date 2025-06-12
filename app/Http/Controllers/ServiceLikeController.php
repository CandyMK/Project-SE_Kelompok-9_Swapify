<?php

namespace App\Http\Controllers;

use App\Models\Service;
use Illuminate\Http\Request;

class ServiceLikeController extends Controller
{
    public function like(Service $service)
    {
        $user = auth()->user();

        $like = ServiceLike::updateOrCreate(
            ['user_id' => $user->id, 'service_id' => $service->id],
            ['is_like' => true]
        );

        return back()->with('success', 'Service liked!');
    }

    public function dislike(Service $service)
    {
        $user = auth()->user();

        $dislike = ServiceLike::updateOrCreate(
            ['user_id' => $user->id, 'service_id' => $service->id],
            ['is_like' => false]
        );

        return back()->with('success', 'Service disliked!');
    }

    public function unlike(Service $service)
    {
        $user = auth()->user();

        ServiceLike::where([
            'user_id' => $user->id,
            'service_id' => $service->id,
        ])->delete();

        return back()->with('success', 'Like/dislike removed!');
    }
}
