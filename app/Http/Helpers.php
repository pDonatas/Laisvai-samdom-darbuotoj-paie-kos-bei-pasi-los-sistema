<?php


namespace App\Http;

use App\Http\Services\RatingsService;
use Illuminate\Support\Facades\DB;

class Helpers
{
    public function search($arguments){
        $query = "";
        $arg = explode(',', $arguments);
        foreach ($arg as $ar) {
            if ($query != "") $query .= " UNION ";
            $query .= "SELECT * FROM `posts` WHERE `title` LIKE '%$ar%'";
        }
        return DB::select(DB::raw($query));
    }

    public function getRating($id){
        return RatingsService::overall($id);
    }
}
