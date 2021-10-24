<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    /**
     * @codeCoverageIgnore
     */
    public function __construct()
    {
        $this->middleware(['auth', 'admin']);
    }

    /**
     * @codeCoverageIgnore
     */
    public function index(){
        $verified = User::where('type','>', 0)->get();
        $waiting = User::where('type', 0)->get();
        return view('admin.index',[
            'verified' => $verified,
            'waiting' => $waiting
        ]);
    }

    /**
     * @codeCoverageIgnore
     */
    public function verifyUser($id){
        $user = User::find($id);
        $user->type = 1;
        $user->save();
        return redirect()->back();
    }
}
