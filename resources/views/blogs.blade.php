@extends('layouts.app')
@section('title', 'Blogs Page')
@section('content')
    <h1>Welcome to {{ $name }}</h1>
    <x-blogs.blog-listing>
        @if ($age)
            <h1>Hallo, my name is {{ $name }} and i am {{ $age }} years old.</h1>
        @else
            <h1>Hallo, my name is {{ $name }}.</h1>
        @endif
    </x-blogs.blog-listing>
    <div class="max-w-lg m-auto py-12 px-4">
        @if (count($posts))
            <h2>You have total of {{ count($posts) }} {{ Str::plural('post', count($posts)) }}</h2>
            @foreach ($posts as $item)
                <div class="bg-gray-200 p-3 rounded-lg mb-3">
                    @if($item->image) <img class="mb-3" src="{{ asset('/storage/'. $item->image) }}" alt=""> @endif
                    <h1 class="mb-2">{{ $item->title }}</h1>        
                    <p>{{ $item->content }}</p>
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