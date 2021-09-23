<?php declare(strict_types=1);

namespace App\Http\Controllers\API;

use App\Http\Helpers;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class SearchController extends BaseController
{
    protected Helpers $helpers;

    public function __construct(Helpers $helpers)
    {
        $this->helpers = $helpers;
    }

    public function search(Request $request): JsonResponse
    {
        $args = $request->input('search');
        $results = $this->helpers->search($args);

        return $this->return([
            'query' => $args,
            'posts' => $results
        ]);
    }
}
