<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class GuestController extends Controller
{

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
