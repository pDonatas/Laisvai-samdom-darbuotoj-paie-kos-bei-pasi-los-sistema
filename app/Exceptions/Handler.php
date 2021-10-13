<?php

namespace App\Exceptions;

use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Illuminate\Http\JsonResponse;
use Illuminate\Validation\ValidationException;
use Symfony\Component\HttpFoundation\Response;
use Throwable;

class Handler extends ExceptionHandler
{
    /**
     * A list of the exception types that are not reported.
     *
     * @var array
     */
    protected $dontReport = [
        //
    ];

    /**
     * A list of the inputs that are never flashed for validation exceptions.
     *
     * @var array
     */
    protected $dontFlash = [
        'password',
        'password_confirmation',
    ];

    /**
     * Report or log an exception.
     *
     * @param  \Throwable  $exception
     * @return void
     *
     * @throws \Exception
     */
    public function report(Throwable $exception)
    {
        parent::report($exception);
    }

    /**
     * Render an exception into an HTTP response.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Throwable  $exception
     * @return \Symfony\Component\HttpFoundation\Response
     *
     * @throws \Throwable
     */
    public function render($request, Throwable $exception)
    {
        return parent::render($request, $exception);
    }

    public function register()
    {
        $this->renderable(function (InvalidTokenException $e) {
            return new JsonResponse([
                'error' => $e->getMessage()
            ], Response::HTTP_UNAUTHORIZED);
        });

        $this->renderable(function (InvalidUserException|InvalidAPIResponseException $e) {
            return new JsonResponse([
                'error' => $e->getMessage()
            ], Response::HTTP_BAD_REQUEST);
        });
    }

    protected function invalidJson($request, ValidationException $exception): JsonResponse
    {
        return response()->json([
            'message' => $exception->getMessage(),
            'errors' => $exception->errors(),
        ], Response::HTTP_BAD_REQUEST); //parent method return 422
    }
}
