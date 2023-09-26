<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index(){
        return view('admin.dashboard', [
            'posts' => Post::latest()->with(['user'])->get()
        ]);
    }

    public function search(Request $request){
        return view('admin.dashboard', [
            'posts' => Post::where('title', 'LIKE', '%'.$request->search.'%')
            ->orWhere('content', 'LIKE', '%'.$request->search.'%')->get()
        ]);
    }
}