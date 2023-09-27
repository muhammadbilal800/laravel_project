@extends('layouts.app')
@section('title', 'Blogs Page')
@section('content')
    <div class="max-w-lg m-auto py-12 px-4">
        @if($post->image)
            <img src="{{ asset('/storage/'. $post->image) }}" alt="Post Image">
        @endif
        <h2>Posted By {{ $post->user->name }}</h2>
        <p>Posted: {{ $post->created_at->diffForHumans() }}</p>
        <h1 class="text-2xl font-semibold">{{ $post->title }}</h1>
        <article>
            {{ $post->content }}
        </article>
    </div>
@endsection