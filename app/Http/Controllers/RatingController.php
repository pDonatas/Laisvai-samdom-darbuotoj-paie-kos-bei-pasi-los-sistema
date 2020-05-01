<?php

namespace App\Http\Controllers;

use App\Http\Services\RatingsService;
use App\Rating;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

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
                $comment = $request->input('comment');
                $rating = new Rating();
                $rating->vote = $vote;
                $rating->user = Auth::id();
                $rating->comment = $comment;
                $rating->post = $post;

                $rating->save();
            }
        }
        return redirect()->back();
    }

    public static function show($post){
        if(!Session::has('sort'))
            Session::put('sort', '1');

        $sort = Session::get('sort');
        //Pagal balsus
        if($sort == 0){
            $rts = Rating::where('post', $post)->orderBy('vote')->get();
        }else if($sort == 1){ //Data
            $rts = Rating::where('post', $post)->orderBy('created_at')->get();
        }

        return view('ratings.show', [
            'ratings' => $rts
        ]);
    }

    public function sort(Request $request){
        $data = $request->input("sort");
        Session::forget("sort");
        Session::put("sort", $data);
        return redirect()->back();
    }
}
