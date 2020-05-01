<?php

namespace App\Http\Controllers;

use App\Http\Services\RatingsService;
use App\Rating;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class RatingController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function vote(Request $request, $post){
        $rs = new RatingsService();
        if($rs->exists($post)) {
            if (!$rs->voted(Auth::id(), $post)) {
                $vote = $request->input('vote');
                $rating = new Rating();
                $rating->vote = $vote;
                $rating->user = Auth::id();
                $rating->post = $post;

                $rating->save();
            }
        }
        return redirect()->back();
    }
}
