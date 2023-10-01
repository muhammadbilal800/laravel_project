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

        @if (count($posts))
            <h2>You have total of {{ count($posts) }} {{ Str::plural('post', count($posts)) }}</h2>
            @foreach ($posts as $item)
                <div class="bg-gray-200 p-3 rounded-lg mb-3 relative">
                    @if($item->image) <img class="mb-3" src="{{ asset('/storage/'. $item->image) }}" alt=""> @endif
                    <h1 class="mb-2">{{ $item->title }}</h1>        
                    <p>{{ $item->content }}</p>
                    <form action="{{ route('post.delete', $item->slug) }}" class="absolute -top-4 right-3" method="post">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="bg-red-500 py-1 px-2 text-[10px] rounded-lg">Delete</button>
                    </form>
                    @if ($item->user->id == Auth()->user()->id)
                      <a class="text-blue-600 underline" href="{{ route('post.update',$item->slug) }}">Edit</a>  
                    @endif
                </div>
            @endforeach
        @else
            <p>No data exist!</p>
        @endif

        @if($posts->hasPages())
            <div class="bg-gray-100 p-3 rounded-lg">
                {{ $posts->links() }}
            </div>
        @endif
    </div>
@endsection