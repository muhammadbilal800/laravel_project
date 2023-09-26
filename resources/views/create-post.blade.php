@extends('layouts.app')
@section('title', 'Create Posts')
@section('content')
    <div class="max-w-lg m-auto py-6 px-4">
        <h1>Create Post Page</h1>
        @if(session('success'))
            <p class="text-center py-4 px-4 bg-green-600/10 text-green-600 mb-4">{{ session('success') }}</p>
        @endif
        <form action="{{ route('create.post') }}" method="post" enctype="multipart/form-data">
            @csrf
            <x-input-field type="text" name="title" placeholder="Title" />
            @error('title')
                <x-alerts.error :message="$message" />
            @enderror

            <x-custom-area name="content" placeholder="Write here..." />
            @error('content')
                <x-alerts.error :message="$message" />
            @enderror
            
            <x-input-field type="file" name="image" accept="image/*" />
            @error('image')
                <x-alerts.error :message="$message" />
            @enderror
            
            <button class="py-2 px-4 bg-indigo-600 rounded-lg text-white font-semibold">Post</button>
        </form>
    </div>
@endsection