<?php

namespace App\Models;

use App\Models\User;
use App\Models\Service;
use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    protected $fillable = [
        'name',
        'slug',
        'iamge',
        'description'
    ];

    // Relasi dengan provider
    public function providers()
    {
        return $this->belongsToMany(User::class, 'category_user')
                    ->where('role', 'provider')
                    ->withTimestamps();
    }

    // // Otomatis generate slug
    // public function setNameAttribute($value)
    // {
    //     $this->attributes['name'] = $value;
    //     $this->attributes['slug'] = Str::slug($value);
    // }

    public function services()
    {
        return $this->hasMany(Service::class);
    }
}