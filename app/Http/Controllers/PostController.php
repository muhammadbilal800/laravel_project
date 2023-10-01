<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PostController extends Controller
{
    public function index(){
        return view('create-post',[
            'posts' => Auth::user()->posts()->paginate(50)
        ]);
    }

    public function store(Request $request){
        $this->validate($request, [
            'title' => 'required|max:255|unique:posts,title',
            'content' => 'required',
            'image' => 'nullable|image|mimes:jpg,jpeg,png,webp:max:1024'
        ]);
        $image = null;

        // Risky
        // Post::create($request->all());

        if($request->hasFile('image')){
            // Check if image exist
            // dd($request->image);
            // dd($request->image->storeAs('post_images', $request->image->getClientOriginalName()));
            $image = $request->image->storeAs('post_images', str_replace(' ','-', strtolower($request->image->getClientOriginalName())), 'public_disk');
        }

        Post::create([
            'title' => $request->title,
            'slug' => str_replace(' ', '-', strtolower($request->title)),
            // 'user_id' => Auth::user()->id,
            'image' => $image,
            'user_id' => auth()->user()->id,
            'content' => $request->content
        ]);

        return back()->with('success', 'Post has been created!');
    }


    public function show(Post $post){
        return view('read-post', [
            'post' => $post
        ]);
    }

    public function destroy(Post $post){
        $this->authorize('delete', $post);
        $post->delete();
        return back();
    }


    public function update(Post $post){
        return view('update-post',[
            'post' =>$post
        ]);
    }

    public function update_post(Request $request,Post $post){
            $this->validate($request,[
                'title' => 'required',
                'slug'=> 'required',
                'content' =>'required',
                'image'=> 'nullable|image|mimes:jpg,webp,jpeg,png:max:1024'
            ]);

            $image=null;

            if(request()->hasFile('image')){
                $image=$request->image->storeAs('post_images',str_replace('','-',strtolower($request->image->getClientOriginalName())),'public_disk');
            }
            
        $array = [
            'title' => $request->title,
            'slug' => str_replace(' ', '-', strtolower($request->slug)),
            'user_id' => auth()->user()->id,
            'image' => $image,
            'content' => $request->content
        ];
        $post->update($array);
        return redirect()->route('create.post')->with('success', 'Post has been updated!');
    }
}
