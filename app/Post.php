<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Post extends Model
{
    // Set mass-assignable fields
    protected $fillable = ['title', 'content', 'category', 'slug', 'user_id', 'price', 'img'];

    public function getRouteKeyName()
    {
        return 'slug';
    }

    public function order(): BelongsTo
    {
        return $this->belongsTo(Order::class);
    }
}
