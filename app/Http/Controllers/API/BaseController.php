<?php declare(strict_types=1);

namespace App\Http\Controllers\API;


use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;
use Symfony\Component\HttpFoundation\Response;

class BaseController extends Controller
{
    public function return(array $content = [], int $responseCode = Response::HTTP_OK): JsonResponse
    {
        return new JsonResponse($content, $responseCode);
    }
}
