@props(['href' => null, 'type' => 'button'])

@if ($href)
    <a href="{{ $href }}"
        {{ $attributes->merge(['class' => 'cta-button-transparent px-6 py-2 rounded-full font-semibold transition hover:bg-[var(--orangish)] hover:text-white inline-block']) }}>
        {{ $slot }}
    </a>
@else
    <button type="{{ $type }}"
        {{ $attributes->merge(['class' => 'cta-button-transparent px-6 py-3 rounded-full font-semibold transition hover:bg-[var(--orangish)] hover:text-white']) }}>
        {{ $slot }}
    </button>
@endif
