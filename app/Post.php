<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Post extends Model
{
    // Set mass-assignable fields
    protected $fillable = ['title', 'content', 'category', 'slug', 'user_id', 'price', 'img'];

    public function getRouteKeyName()
    {
        return 'slug';
    }

    public function order(): BelongsToMany
    {
        return $this->belongsToMany(Order::class);
    }

    public function ratings(): HasMany
    {
        return $this->hasMany(Rating::class, 'post');
    }
}
