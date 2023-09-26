@extends('layouts.app')
@section('title', 'Login Page')
@section('content')
    <h1>Welcome to {{ $name }}</h1>

    <form action="{{ route('login.store') }}" method="post" class="max-w-[300px] m-auto flex flex-col">
        @csrf

        @if (session('success'))
            <p class="bg-green-600/10 mb-3 text-green-600 py-5 text-center">{{ session('success') }}</p>
        @endif

        @if (session('failed'))
            <p class="bg-red-600/10 text-red-600 py-5 text-center">{{ session('failed') }}</p>
        @endif

        <x-input-field type="email" name="email" placeholder="Email Address" />
        @error('email')
            <x-alerts.error :message="$message" />
        @enderror

        <x-input-field type="password" name="password" placeholder="Password" />
        @error('password')
            <x-alerts.error :message="$message" />
        @enderror

        <div class="flex items-center">
            <input type="checkbox" id="remember" name="remember">
            <label for="remember" class="ml-2">Remeber me</label>
        </div>
        
        <button type="submit">Login</button>
        <p class="text-sm">Don't remember your password? <a href="{{ route('password.request') }}" class="underline text-blue-500">Reset now</a></p>
    </form>
@endsection