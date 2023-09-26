@extends('layouts.app')
@section('title', 'Dashboard')
@section('content')
    <div class="max-w-3xl m-auto py-6 px-4">
        <h1>All Posts</h1>
        <form action="{{ route('dashboard.search') }}" method="get" class="w-full flex items-center">
            <x-input-field type="search" name="search" placeholder="Search" />
            <button type="submit" class="bg-black text-white py-2 px-6 inline-block ml-3">Search</button>
        </form>
        @if (count($posts))
            <table class="w-full">
                <tr>
                    <th class="text-start p-2">Title</th>
                    <th class="text-start">Content</th>
                    <th class="text-start">User</th>
                    <th class="text-end p-2">Posted</th>
                </tr>
                @foreach ($posts as $post)
                    <tr>
                        <td class="text-start p-2">{{ $post->title }}</td>
                        <td class="text-start">{{ $post->content }}</td>
                        <td class="text-start">{{ $post->user->name }}</td>
                        <td class="text-end p-2">{{ $post->created_at->diffForHumans() }} {{ $post->created_at->format('d/m/y H:i:s A') }}</td>
                    </tr>
                @endforeach
            </table>
        @else
            <p class="text-center py-3">No posts data found!</p>
        @endif
    </div>
@endsection