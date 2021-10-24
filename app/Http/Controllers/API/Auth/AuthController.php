<?php declare(strict_types=1);

namespace App\Http\Controllers\API\Auth;

use App\Exceptions\InvalidUserException;
use App\Http\Controllers\API\BaseController;
use App\Http\Requests\LoginRequest;
use App\Http\Requests\UserRequest;
use App\Http\Services\Auth\TokenService;
use App\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class AuthController extends BaseController
{
    protected TokenService $tokenService;

    /**
     * @codeCoverageIgnore
     */
    public function __construct(TokenService $tokenService)
    {
        $this->tokenService = $tokenService;
    }

    public function login(LoginRequest $request): JsonResponse
    {
        $user = User::where('email', $request->get('email'))->first();

        if (!$user) {
            return $this->return(['error' => 'Either username and/or password is not correct'], Response::HTTP_NOT_FOUND);
        }

        if (Hash::check($request->get('password'), $user->password)) {
            $token = $this->tokenService->encryptToken(json_encode(['expire' => strtotime('+2 days')]));

            $user->update([
                'token' => $token
            ]);

            Auth::login($user);

            return $this->return([
                'token' => $token
            ]);
        }

        return $this->return([
            'error' => [
                'username' => 'Email or password is not correct'
            ]
        ], Response::HTTP_BAD_REQUEST);
    }

    public function register(UserRequest $request): JsonResponse
    {
        $user = User::where('email', $request->get('email'))->first();

        $user = User::create($request->toArray());
        $user->update([
            'password' => Hash::make($request->get('password'))
        ]);

        return $this->return(
            compact('user'),
            Response::HTTP_CREATED
        );
    }

    public function logout(): JsonResponse
    {
        $user = Auth::user();
        $user->update([
            'token' => null
        ]);

        Auth::logout();

        return $this->return(['success' => 'User logged out successfully']);
    }
}
