<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Request;
use Redirect;
use App\Mail\ContactMail;
use Illuminate\Support\Facades\Mail;
class MailController extends Controller
{
     public function contact(Request $request) {
       
        $data = array(
            'sender'   =>  $request->sender,
            'title'   =>  $request->title,
            'body'   =>   $request->body
            
        );
        //dd($data);
        Mail::to('administrator@bands.com.ph')->send(new ContactMail($data));
        return Redirect::back()->with('success','Email sent successfully!');
    }
}
