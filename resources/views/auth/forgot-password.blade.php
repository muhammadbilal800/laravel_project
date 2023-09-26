@extends('layouts.app')
@section('title', 'Forgot Password')
@section('content')
    <div class="max-w-lg m-auto py-12 px-4">
        <h1>Forgot Password</h1>
        <p>You will receive an email after submiting your email!</p>

        <form action="{{ route('password.email') }}" method="post" class="flex flex-col">
            @csrf

            @if (session('success'))
                <p class="bg-green-600/10 mb-3 text-green-600 py-5 text-center">{{ session('success') }}</p>
            @endif

            <x-input-field type="email" name="email" placeholder="Email Address" />
            @error('email')
                <x-alerts.error :message="$message" />
            @enderror
            
            <button type="submit">Reset</button>
        </form>
    </div>
@endsection