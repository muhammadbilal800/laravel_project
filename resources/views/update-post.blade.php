@extends('layouts.app')
@section('title', 'Create Posts')
@section('content')
    <div class="max-w-lg m-auto py-6 px-4">
        <h1>Update Post: <b>{{ $post->title }}</b></h1>
        @if(session('success'))
            <p class="text-center py-4 px-4 bg-green-600/10 text-green-600 mb-4">{{ session('success') }}</p>
        @endif
        <form action="{{ route('post.update.now', $post->slug) }}" method="post" enctype="multipart/form-data">
            @csrf
            @method('PATCH')
            <x-input-field type="text" name="title" value="{{ $post->title }}" placeholder="Title" />
            @error('title')
                <x-alerts.error :message="$message" />
            @enderror

            <x-input-field type="text" name="slug" value="{{ $post->slug }}" placeholder="Slug" />
            @error('slug')
                <x-alerts.error :message="$message" />
            @enderror
            <x-custom-area myvalue="{{ $post->content }}" name="content" value="{{ $post->content }}" placeholder="Write here..." />
            @error('content')
                <x-alerts.error :message="$message" />
            @enderror
            
            <x-input-field type="file" name="image" accept="image/*" />
            @error('image')
                <x-alerts.error :message="$message" />
            @enderror
            
            <button class="py-2 px-4 bg-indigo-600 rounded-lg text-white font-semibold">Update</button>
        </form>
    </div>
@endsection
