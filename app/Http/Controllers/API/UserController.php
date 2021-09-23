<?php declare(strict_types=1);

namespace App\Http\Controllers\API;

use App\Http\Requests\UserRequest;
use App\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Hash;
use Symfony\Component\HttpFoundation\Response;

class UserController extends BaseController
{
    public function show(User $user): JsonResponse
    {
        return $this->return(compact('user'));
    }

    public function update(UserRequest $request, User $user): JsonResponse
    {
        if ($request->get('password') !== null && $request->get('new_password') !== null && $request->get('confirm_password') !== null) {
            if (!Hash::check($request->get('password'), $user->password)) {
                return $this->return([
                    'error' =>  __('user.password_incorrect')
                ], Response::HTTP_UNPROCESSABLE_ENTITY);
            }

            if ($request->get('new_password') !== $request->get('confirm_password')) {
                return $this->return([
                    'error' =>  __('user.passwords_not_match')
                ], Response::HTTP_UNPROCESSABLE_ENTITY);
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


        $user->update([
            'name' => $request->get('name'),
            'email' => $request->get('email')
        ]);

        return $this->return(responseCode: Response::HTTP_ACCEPTED);
    }

    public function destroy(User $user): JsonResponse
    {
        $user->delete();

        return $this->return();
    }
}
