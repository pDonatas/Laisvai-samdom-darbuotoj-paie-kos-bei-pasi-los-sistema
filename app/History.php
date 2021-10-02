<?php

namespace App;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Facades\Auth;

class History extends Model
{
    public static function scopeCurrentUser(Builder $query): Builder
    {
        return $query->where('user', Auth::id());
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
