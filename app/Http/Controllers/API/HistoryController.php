<?php declare(strict_types=1);

namespace App\Http\Controllers\API;

use App\History;
use Illuminate\Http\JsonResponse;

class HistoryController extends BaseController
{
    public function index(): JsonResponse
    {
        $history = History::currentUser()->orderBy('id', 'DESC')->get();

        return $this->return(compact('history'));
    }
}
