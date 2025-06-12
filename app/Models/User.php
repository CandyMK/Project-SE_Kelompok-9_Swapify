<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use App\Models\User;
use App\Models\Review;
use App\Models\Project;
use App\Models\Service;
use App\Models\ServiceLike;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'full_name',
        'username',
        'email',
        'password',
        'role',
        'photo',     
        'phone',     
        'bio',      
        'portfolio', 
        'location',  
        'instagram', 
        'facebook',  
        'twitter',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function servicesAsProvider()
    {
        return $this->hasMany(Service::class, 'user_id'); // Jasa yang ditawarkan
    }

    public function servicesAsRequester()
    {
        return $this->hasMany(Service::class, 'requested_by'); // Jasa yang diminta
    }

    // Tambahkan relasi serviceLikes ke model User
    public function serviceLikes()
    {
        return $this->hasMany(ServiceLike::class);
    }

    public function likedServices()
    {
        return $this->belongsToMany(Service::class, 'service_likes')
                    ->withPivot('is_like')
                    ->withTimestamps();
    }

    public function services()
    {
        return $this->hasMany(Service::class, 'user_id');
    }

    public function receivedReviews()
    {
        return $this->hasMany(Review::class, 'user_id');
    }

    public function givenReviews()
    {
        return $this->hasMany(Review::class, 'reviewer_id');
    }

    public function reviews(): HasMany
    {
        return $this->hasMany(Review::class);
    }

}