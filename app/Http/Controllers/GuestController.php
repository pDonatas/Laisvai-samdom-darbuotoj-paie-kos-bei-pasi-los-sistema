<?php

namespace App\Http\Controllers;

use App\Category;
use App\Post;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class GuestController extends Controller
{

    public function home(){
        $posts = Post::all();
        $categories = Category::all();

        if (!Session::has('user_locale')) {
            Session::put('user_locale', 'lt');
        }

        return view('home.index', [
            'posts' => $posts,
            'categories' => $categories
        ]);
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        return view('Contacts.contacts');
    }
    public function contactform(Request $request)
    {
        $headers = 	"From: Contact Form <contact@mydomain.com>" . "\r\n" .
            "Reply-To: ".$request->input('email') . "\r\n" .
            "MIME-Version: 1.0\r\n" .
            "Content-Type: text/html; charset=iso-8859-1\n";
        $to = 'contact@hyvor.com';
        $subject = 'Contacting you';

        mail($to, $subject,$request->input('message') , $headers);
        return viev('Contacts.contacts',['success'=>1]);

    }
    public function privacypolicy()
    {
        return view('PrivacyPolicy.PrivacyPolicy');
    }
}
