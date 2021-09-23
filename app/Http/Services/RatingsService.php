<?php


namespace App\Http\Services;


use App\Post;
use App\Rating;

class RatingsService
{
    public static function overall($id)
    {
        $ratings = Rating::where("post", $id)->get();
        $count = 0;
        $sum = 0;
        foreach($ratings as $rating){
            $sum += $rating->vote;
            $count++;
        }
        if($count == 0) return 0;
        return $sum/$count;
    }

    public static function voted($user, $post)
    {
        $rates = Rating::where('user', $user)->where('post', $post)->get();
        if(Count($rates) == 0){
            return false;
        }
        return true;
    }

    public function exists($post)
    {
        $post = Post::find($post);
        if($post) return true;
        else return false;
    }

    public function removeAll($id)
    {
        Rating::where('post', $id)->delete();
    }
}
