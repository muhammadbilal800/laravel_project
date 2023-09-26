@extends('layouts.app')
@section('title', 'Home Page')
@section('content')
    {{ count($names) }}
    @foreach ($names as $key => $name)
        @if ($loop->first == "Ahmer")
            <h3>{{ $loop->index + 1 }} - {{ $key + 1 }} - {{ $name }} - Halo</h3>
        @else
            <h3>{{ $loop->index + 1 }} - {{ $key + 1 }} - {{ $name }}</h3>
        @endif
    @endforeach

    @foreach ($students as $student)
        {{ $student }}
    @endforeach

    
    {{ date('D d-m-y H:i:s A') }}
@endsection