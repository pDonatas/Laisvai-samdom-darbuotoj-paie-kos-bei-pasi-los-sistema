<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Bookmark extends Model
{
    public $timestamps = false;
    public $guarded = [];

    public function bookmark($object)
    {
        if($this->isBookmarked($object)) {
            return $this->bookmarks()->where([
                ['bookmarks.model_type', get_class($object)],
                ['bookmarks.model_id', $object->id]
            ])->delete();
        }

        return $this->bookmarks()->create(['model_type' => get_class($object), 'model_id' => $object->id]);
    }
    public function isBookmarked($object)
    {
        return $this->bookmarks()->where([
            ['bookmarks.model_type', get_class($object)],
            ['bookmarks.model_id', $object->id]
        ])->exists();
    }
}
