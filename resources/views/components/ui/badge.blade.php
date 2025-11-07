@props(['color' => 'orange'])

@php
    $classes = match($color) {
        'blue' => 'badge-blue',
        'teal' => 'badge-teal',
        default => 'badge-orange',
    };
@endphp

<div {{ $attributes->merge(['class' => "section-badge $classes"]) }}>
    {{ $slot }}
</div>
