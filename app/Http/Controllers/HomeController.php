<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    /**
     * @codeCoverageIgnore
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    /**
     * @codeCoverageIgnore
     */
    public function index()
    {
        return view('home.index');
    }
    /**
     * @codeCoverageIgnore
     */
    public function FAQ()
    {
        return view('faq');
    }
    /**
     * @codeCoverageIgnore
     */
    public function TermsOfService()
    {
        return view('termsofservice');
    }
}
