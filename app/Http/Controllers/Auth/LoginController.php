<?php

namespace App\Http\Controllers\Auth;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{

    // public function __construct(){
    //     $this->middleware(['guest']);
    // }

    public function index(){
        return view('auth.login', [
            'name' => 'Login Page'
        ]);
    }


    public function store(Request $request){
        $this->validate($request, [
            'email' => 'required',
            'password' => 'required'
        ]);

        if(!Auth::attempt($request->only(['email', 'password']), $request->remember)){
            return back()->with('failed', 'Email or password does not match!');
        }

        return redirect('/');
    }
}