<?php

namespace App\Models;

use App\Models\User;
use App\Models\Review;
use App\Models\Service;
use App\Models\Category;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Service extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'requested_by',
        'title',
        'description',
        'category_id',
        'delivery_time',
        'status',
        'is_active',
        'is_dealed',
        'provider_confirmed',
        'requester_confirmed',
        'deal_with'
    ];

    protected $casts = [
        'is_dealed' => 'boolean',
        'is_active' => 'boolean',
        'provider_confirmed' => 'boolean',
        'requester_confirmed' => 'boolean',
    ];

    protected $with = ['provider', 'requester', 'category'];

    // Relasi dengan category
    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // Relasi ke user yang menawarkan jasa
    public function provider()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    // Relasi ke user yang meminta jasa
    public function requester()
    {
        return $this->belongsTo(User::class, 'requested_by');
    }

    public function reviews()
    {
        return $this->hasMany(Review::class);
    }

    public function likes()
    {
        return $this->belongsToMany(User::class, 'service_likes')
                ->withPivot('is_like');
    }

    public function isLikedBy(User $user)
    {
        return $this->likes()
            ->where('user_id', $user->id)
            ->where('is_like', true)
            ->exists();
    }

    public function show(Service $service)
    {
        $service->load(['provider.reviews.reviewer', 'category', 'requester']);
        
        return view('services.show', compact('service'));
    }

    public function scopeActive($query)
    {
        return $query->where('is_active', true)
                    ->where('status', 'available');
    }
}
