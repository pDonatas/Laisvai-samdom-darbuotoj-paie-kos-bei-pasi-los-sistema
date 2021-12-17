<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Rating extends Model
{
    protected $fillable = ['vote', 'comment', 'user', 'post'];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user');
    }
}
