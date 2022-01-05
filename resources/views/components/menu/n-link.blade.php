@props(['active'])

@php
    $classes = ($active ?? false)
                ? 'inline-flex items-center px-1 pt-1 leading-5 btn-link__active transition'
                : 'inline-flex items-center px-1 pt-1 border-b-2 border-transparent leading-5 btn-link transition';
@endphp

<a {{ $attributes->merge(['class' => $classes]) }}>
    {{ $slot }}
</a>
