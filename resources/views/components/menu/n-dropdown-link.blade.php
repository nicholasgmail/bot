@props(['active'])

@php
    $classes = ($active ?? false)
                ? 'block px-4 py-2 leading-5 btn-brow__active'
                : 'block px-4 py-2 btn-brow leading-5 transition';
@endphp
<a {{ $attributes->merge(['class' => $classes]) }}>{{ $slot }}</a>
