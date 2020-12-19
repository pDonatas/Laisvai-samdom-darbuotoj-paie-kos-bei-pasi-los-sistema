<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    // Set mass-assignable fields
    protected $fillable = ['title', 'content', 'category', 'slug', 'user_id', 'price', 'img'];

    public function getRouteKeyName()
    {
        return 'slug';
    }
}
