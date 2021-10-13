<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

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
}
