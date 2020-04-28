<?php

namespace App\Http\Controllers;

use App\Http\Helpers;
use App\Post;
use Illuminate\Http\Request;

class SearchController extends Controller
{
    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function search(Request $request)
    {
        $helpers = new Helpers();
        $args = $request->input('search');
        $results = $helpers->search($args);

        return view('search.results', [
            'query' => $args,
            'posts' => $results
        ]);
    }
}
