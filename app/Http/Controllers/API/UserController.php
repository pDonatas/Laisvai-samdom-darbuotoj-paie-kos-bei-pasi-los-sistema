<?php declare(strict_types=1);

namespace App\Http\Controllers\API;

use App\Exceptions\InvalidUserException;
use App\Http\Requests\UserRequest;
use App\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Symfony\Component\HttpFoundation\Response;

class UserController extends BaseController
{
    public function index(): JsonResponse
    {
        return $this->return(User::all()->toArray());
    }

    public function show(User $user): JsonResponse
    {
        return $this->return(compact('user'));
    }

    public function update(UserRequest $request, User $user): JsonResponse
    {
        if (Auth::user()->type == 0 && $user !== Auth::user()) {
            return $this->return(['errors' => 'You do not have access to this route'], Response::HTTP_FORBIDDEN);
        }

        $user->update($request->toArray());

        if ($request->request->get('password') !== null && $request->request->get('new_password') !== null && $request->request->get('confirm_password') !== null) {
            if (!Hash::check($request->get('password'), $user->password)) {
                return $this->return([
                    'error' =>  __('user.password_incorrect')
                ], Response::HTTP_BAD_REQUEST);
            }

            if ($request->get('new_password') !== $request->get('confirm_password')) {
                return $this->return([
                    'error' =>  __('user.passwords_not_match')
                ], Response::HTTP_BAD_REQUEST);
            }

            $user->update([
                'password' => Hash::make($request->get('new_password'))
            ]);
        }

        if ($request->file('photo') !== null) {
            $file = $request->file('photo');
            $destinationPath = 'assets/img/users';
            $file->move($destinationPath, $file->getClientOriginalName());
            $user->update([
                'photo' => '/'.$destinationPath.'/'.$file->getClientOriginalName()
            ]);
        }

        return $this->return($user->toArray(), responseCode: Response::HTTP_ACCEPTED);
    }

    public function destroy($id): JsonResponse
    {
        if (Auth::user()->type == 0) {
            return $this->return(['errors' => 'You do not have access to this route'], Response::HTTP_FORBIDDEN);
        }

        $user = User::find($id);

        if (!$user) {
            return $this->return(['errors' => 'User does not exist'], Response::HTTP_BAD_REQUEST);
        }

        $user->delete();

        return $this->return(responseCode: Response::HTTP_NO_CONTENT);
    }

    public function store(UserRequest $request): JsonResponse
    {
        if (Auth::user()->type == 0) {
            return $this->return(['errors' => 'You do not have access to this route'], Response::HTTP_NOT_ACCEPTABLE);
        }

        $user = User::where('email', $request->get('email'))->first();

        if ($user) {
            throw new InvalidUserException("This user already exists");
        }

        $user = User::create($request->toArray());
        $user->update([
            'password' => Hash::make($request->get('password'))
        ]);

        return $this->return(compact('user'), Response::HTTP_CREATED);
    }

    public function profile(): JsonResponse
    {
        return \response()->json(Auth::user());
    }
}
