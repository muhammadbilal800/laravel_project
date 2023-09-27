<?php

namespace App\Http\Controllers\Auth;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Password;

class ForgotController extends Controller
{
    public function index(){
        return view('auth.forgot-password',[
            "name" => "Forgot Password"
        ]);
    }

    public function store(Request $request){
        $this->validate($request,[
        "email" => "required|email"
        ]);


        $status = Password::sendResetLink(
            $request->only('email')
        );
     
        return $status === Password::RESET_LINK_SENT
                    ? back()->with(['success' => __($status)])
                    : back()->withErrors(['email' => __($status)]);
    }
      
}
