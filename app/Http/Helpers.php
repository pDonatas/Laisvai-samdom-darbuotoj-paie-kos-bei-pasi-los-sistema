<?php


namespace App\Http;


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
}
