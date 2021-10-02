<?php

namespace App\Http\Middleware;

use App\Exceptions\InvalidTokenException;
use App\Http\Controllers\API\BaseController;
use App\Http\Services\Auth\TokenService;
use App\User;
use Closure;
use Illuminate\Http\JsonResponse;
use Symfony\Component\HttpFoundation\Response;

class JWT extends BaseController
{
    protected TokenService $tokenService;

    public function __construct(TokenService $tokenService)
    {
        $this->tokenService = $tokenService;
    }

    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        if ($request->bearerToken() && $this->tokenService->decryptToken($request->bearerToken())) {
            $user = User::where('token', $request->bearerToken())->first();
            if (!$user) {
                throw new InvalidTokenException("Provided token is not valid");
            }

            \Auth::login($user);

            return $next($request);
        }

        return $this->return(['error' => 'This route requires JWT token'], Response::HTTP_UNAUTHORIZED);
    }
}
