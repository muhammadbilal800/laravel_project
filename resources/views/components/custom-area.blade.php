@props(['myvalue'=>''])
<textarea cols="30" rows="7" {!! $attributes->merge(['class' => 'mb-3 w-full bg-gray-200 p-2']) !!}>{{ $myvalue }}</textarea>