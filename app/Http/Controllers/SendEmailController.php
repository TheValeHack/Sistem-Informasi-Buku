<?php

namespace App\Http\Controllers;

use App\Jobs\SendMailJob;
use App\Mail\SendEmail;
use Illuminate\Http\Request;
use Mail;

class SendEmailController extends Controller
{
    public function index(){
        return view('emails.create');
    }
    public function store(Request $request){
        $content = [
            'name' => $request->name,
            'subject' => $request->subject,
            'email' => $request->email,
            'body' => $request->body
        ];
        dispatch(new SendMailJob($content));

        return redirect()->route('email.create')->with('success', 'Email berhasil dikirim');
    }
}
