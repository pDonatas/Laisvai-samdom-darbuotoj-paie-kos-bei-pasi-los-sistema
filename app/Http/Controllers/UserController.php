<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    /**
     * @codeCoverageIgnore
     */
    public function __construct() {
        $this->middleware('auth');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    /**
     * @codeCoverageIgnore
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    /**
     * @codeCoverageIgnore
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    /**
     * @codeCoverageIgnore
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|\Illuminate\Http\Response
     */
    /**
     * @codeCoverageIgnore
     */
    public function show($id)
    {
        $user = User::findOrFail($id);
        return view('user.profile', compact('user'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|\Illuminate\Http\Response
     */
    /**
     * @codeCoverageIgnore
     */
    public function edit($id)
    {
        return view('user.edit', [
            'user' => User::find($id)
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\RedirectResponse
     */
    /**
     * @codeCoverageIgnore
     */
    public function update(Request $request, $id)
    {
        $user = User::findOrFail($id);

        if ($request->get('password') !== null && $request->get('new_password') !== null && $request->get('confirm_password') !== null) {

            if (!Hash::check($request->get('password'), $user->password)) {
                return redirect()->back()->with('error', __('user.password_incorrect'));
            }

            if ($request->get('new_password') !== $request->get('confirm_password')) {
                return redirect()->back()->with('error', __('user.passwords_not_match'));
            }

            $user->update([
                'password' => Hash::make($request->get('new_password'))
            ]);
        }

        if ($request->file('photo') !== null) {
            $file = $request->file('photo');
            $destinationPath = 'assets/img/users';
            $file->move($destinationPath,$file->getClientOriginalName());
            $user->update([
                'photo' => '/'.$destinationPath.'/'.$file->getClientOriginalName()
            ]);
        }


        $user->update([
            'name' => $request->get('name'),
            'email' => $request->get('email')
        ]);

        return redirect()->back()->with('success', __('user.profile_updated'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    /**
     * @codeCoverageIgnore
     */
    public function destroy($id)
    {
        //
    }

    /**
     * Rodomas puslapis slaptažodžio keitimui
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    /**
     * @codeCoverageIgnore
     */
    public function password_change(){
        return view('user.change_password');
    }

    /**
     * Išsaugojamas pakeistas slaptažodis
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    /**
     * @codeCoverageIgnore
     */
    public function store_password(Request $request)
    {
        $user = Auth::user();
        if (Hash::check($request->get('password'), $user->getAuthPassword())) {
            $user->update([
                'password' => Hash::make($request->get('new_password'))
            ]);

            return view('user.change_password', [
                'success' => true
            ]);
        }else{
            return view('user.change_password', [
                'danger' => 1
            ]);
        }
    }
}
