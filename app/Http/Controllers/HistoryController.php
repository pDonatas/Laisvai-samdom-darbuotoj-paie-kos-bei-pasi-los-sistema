<?php

namespace App\Http\Controllers;

use App\History;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class HistoryController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index(){
        $history = History::where('user', Auth::id())->orderBy('id', 'DESC')->get();
        return view('history.index', compact('history'));
    }
}
