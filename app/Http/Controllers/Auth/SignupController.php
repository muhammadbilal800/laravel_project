<?php

namespace App\Http\Controllers\Auth;

use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;

class SignupController extends Controller
{
    public function index(){
        return view('auth.signup',[
            "name"=>"Registeration Page"
        ]);
    }

    public function store(Request $request){
        $this->validate($request, [
            "name" => "required|max:255",
            "email" => "required|email|max:255",
            "password" => "required|confirmed|max:255",
        ]);

        User::create([
            "name" => $request->name,
            "email" => $request->email,
            "password" => Hash::make($request->password),
        ]);

        return back()->with('success', 'Signup Success');
    }
}