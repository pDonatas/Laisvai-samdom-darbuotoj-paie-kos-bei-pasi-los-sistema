<?php

namespace App\Http\Controllers;

use App\Bookmark;
use App\Http\Services\BookmarksService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class BookmarkController extends Controller
{
    /**
     * @codeCoverageIgnore
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * @codeCoverageIgnore
     */
    public function bookmark($post){
        $bs = new BookmarksService();
        if($bs->isBookmarked($post)){
            $bookmark = Bookmark::where('user_id', Auth::id())->where('post', $post)->get();
            $bookmark[0]->delete();
        }else{
            $bookmark = new Bookmark();
            $bookmark->post = $post;
            $bookmark->user_id = Auth::id();
            $bookmark->save();
        }
        return redirect()->back();
    }
}
