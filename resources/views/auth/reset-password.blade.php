@extends('layouts.app')
@section('title', 'Forgot Password')
@section('content')
    <div class="max-w-lg m-auto py-12 px-4">
        <h1>Reset Password</h1>
        <p>You will receive an email after submiting your email!</p>

        <form action="{{ route('password.update') }}" method="post" class="flex flex-col">
            @csrf

            <input type="hidden" name="token" value="{{ $token }}">

            <x-input-field type="email" name="email" placeholder="Email Address" />
            @error('email')
                <x-alerts.error :message="$message" />
            @enderror

            <x-input-field type="password" name="password" placeholder="New Password" />
            @error('password')
                <x-alerts.error :message="$message" />
            @enderror

            <x-input-field type="password" name="password_confirmation" placeholder="Confirm New Password" />
            @error('password_confirmation')
                <x-alerts.error :message="$message" />
            @enderror
            
            <button type="submit">Reset Now</button>
        </form>
    </div>
@endsection