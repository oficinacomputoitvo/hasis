<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Mail;
use App\Mail\SendMail;

class MailController extends Controller
{

    /**
     * Write code on Method
     *
     * @return response()
     */

    public function send($view="", $title="", $body=[],$to="")
    {
        $to = empty($to)?config('app.emailadmin'):$to;
    
        $mailData = [
            'view'=>$view,
            'title' => $title,
            'body' => $body
        ];
        Mail::to($to)->send(new SendMail($mailData));
    }

}