@props(['active', 'item'])

@php
    $classes = ($active ?? false)
                ? 'block w-full px-4 py-2 text-left leading-5 btn-brow__active'
                : 'block w-full px-4 py-2 text-left btn-brow leading-5 transition';
@endphp
<button {{ $attributes->merge(['class' => $classes]) }} wire:click.prevent="addNext({{$item}})">{{ $slot }}</button>

