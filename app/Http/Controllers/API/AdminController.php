<?php declare(strict_types=1);

namespace App\Http\Controllers\API;

use App\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class AdminController extends BaseController
{
    public function index(): JsonResponse
    {
        if (Auth::user()->type < 2) {
            return $this->return(['errors' => 'You do not have access to this route'], Response::HTTP_FORBIDDEN);
        }

        $verified = User::where('type', '>', 0)->get();
        $waiting = User::where('type', 0)->get();

        return $this->return([
            'verified' => $verified,
            'waiting' => $waiting
        ]);
    }

    public function verifyUser(int $id): JsonResponse
    {
        if (Auth::user()->type < 2) {
            return $this->return(['errors' => 'You do not have access to this route'], Response::HTTP_FORBIDDEN);
        }

        $user = User::find($id);

        if (!$user) {
            return $this->return(['errors' => 'User does not exist'], Response::HTTP_NOT_FOUND);
        }

        if ($user->type > 0) {
            return $this->return(['errors' => 'User is already verified'], Response::HTTP_NOT_ACCEPTABLE);
        }

        $user->type = 1;
        $user->save();

        return $this->return(['success' => 'User verified successfully']);
    }
}
