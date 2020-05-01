<?php


namespace App\Http\Services;


use App\Post;
use App\Rating;
use App\Tag;

class TagsService
{

    public function SaveTags($id, $input)
    {
        $tags = explode(",", $input);
        foreach($tags as $tag){
            $t = new Tag();
            $t->post = $id;
            $t->tag = $tag;
            $t->save();
        }
    }

    public static function hasTags($id){
        $tags = Tag::where("post", $id)->get();
        if(Count($tags) == 0) return false;
        return true;
    }

    public static function showTags($id){
        $tags = Tag::where("post", $id)->get();
        $string = '';
        foreach($tags as $tag){
            $string.= $tag->tag;
            $string .= ',';
        }
        return substr($string, 0,-1);
    }

    public function UpdateTags($id, $input)
    {
        //Šalinam senus tagus:
        Tag::where('post', $id)->delete();
        //Pridedam naujus tagus
        $tags = explode(",", $input);
        foreach($tags as $tag){
            $t = new Tag();
            $t->post = $id;
            $t->tag = $tag;
            $t->save();
        }
    }

    public function RemoveAll($id)
    {
        Tag::where('post', $id)->delete();
    }
}
