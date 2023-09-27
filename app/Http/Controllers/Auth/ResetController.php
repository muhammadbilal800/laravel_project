<?php

namespace App\Http\Controllers\Auth;

use App\Models\User;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Password;
use Illuminate\Auth\Events\PasswordReset;

class ResetController extends Controller
{
    public function index(){
        return view('auth.reset-password');
    }

    public function store(string $token){
        return view('auth.reset-password', ['token' => $token]);
    }

    public function token(Request $request){
        $this->validate($request,[
            'token' => 'required',
            'email' => 'required|email',
            'password' => 'required|min:6|confirmed',

            
        ]);
     
        $status = Password::reset(
            $request->only('email', 'password', 'password_confirmation', 'token'),
            function (User $user, string $password) {
                $user->forceFill([
                    'password' => Hash::make($password)
                ])->setRememberToken(Str::random(60));
                    
                $user->save();
     
                event(new PasswordReset($user));
            }
        );
     
        return $status === Password::PASSWORD_RESET
                    ? redirect()->route('login')->with('success', __($status))
                    : back()->withErrors(['email' => [__($status)]]);

    }
}