<?php

namespace App\Models;

use App\Models\User;
use App\Models\Service;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Review extends Model
{
    use HasFactory;

    protected $fillable = [
        'service_id',
        'user_id',
        'reviewer_id',
        'comment',
        'rating'
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id'); 
    }

    public function reviewer()
    {
        return $this->belongsTo(User::class, 'reviewer_id');
    }

    public function service()
    {
        return $this->belongsTo(Service::class);
    }
}
