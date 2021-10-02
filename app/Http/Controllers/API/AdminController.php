<?php declare(strict_types=1);

namespace App\Http\Controllers\API;

use App\User;
use Illuminate\Http\JsonResponse;

class AdminController extends BaseController
{
    public function index(): JsonResponse
    {
        $verified = User::where('type', '>', 0)->get();
        $waiting = User::where('type', 0)->get();

        return $this->return([
            'verified' => $verified,
            'waiting' => $waiting
        ]);
    }

    public function verifyUser(int $id): JsonResponse
    {
        $user = User::find($id);
        $user->type = 1;
        $user->save();

        return $this->return();
    }
}
