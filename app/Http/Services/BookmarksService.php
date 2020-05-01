<?php

namespace App\Http\Services;

use App\Bookmark;
use Illuminate\Support\Facades\Auth;

class BookmarksService
{
    public static function isBookmarked($post){
        $rates = Bookmark::where('user_id', Auth::id())->where('post', $post)->get();
        if(Count($rates) == 0){
            return false;
        }
        return true;
    }
}
