@php
    $media = collect($medias)->firstWhere('mediaType', $type);
@endphp

<img src="{{ $media ? url($media['filePath']) : asset($fallback ?? 'images/placeholder.png') }}"
    alt="{{ $alt ?? 'media' }}" class="{{ $class ?? 'img-fluid' }}">
