@extends('layouts.app')
@section('title', 'Registration Page')
@section('content')
    <h1>Welcome to {{ $name }}</h1>

    <form action="/signup/create" method="post" class="max-w-[300px] m-auto flex flex-col">
        @csrf

        @if (session('success'))
            <p class="bg-green-600/10 text-green-600 py-5 text-center">{{ session('success') }}</p>
        @endif

        <x-input-field name="name" value="{{ old('name') }}" type="text" placeholder="Enter Name" />
        @error('name')
            <x-alerts.error :message="$message" />
        @enderror

        <x-input-field type="email" value="{{ old('email') }}" name="email" placeholder="Email Address" />
        @error('email')
            <x-alerts.error :message="$message" />
        @enderror

        {{-- <textarea name="" id="" cols="30" rows="10">{{ old('') }}</textarea> --}}


        <x-input-field type="password" name="password" placeholder="Password" />
        @error('password')
            <x-alerts.error :message="$message" />
        @enderror

        <x-input-field type="password" name="password_confirmation" placeholder="Confirm Password" />
        @error('password_confirmation')
            <x-alerts.error :message="$message" />
        @enderror

        {{ \Carbon\Carbon::now() }}
        
        <button type="submit">Signup</button>
    </form>
@endsection