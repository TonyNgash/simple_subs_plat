<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use App\Mail\SignUp;

class MailController extends Controller
{
    //
    public function sendMail(){
        $name = 'Ninyoz';
        Mail::to('maina@gmail.com')->send(new SignUp($name));

        return response()->json([
            'status' => 'success',
            'data'=> "email sent"
        ],201);
    }
}
