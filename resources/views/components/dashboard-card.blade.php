@props(['icon', 'title', 'count' => null, 'subtitle' => null, 'link' => '#', 'color' => 'dark'])

<a href="{{ $link }}" class="text-decoration-none text-dark bg-light-subtle">
    <div class="card shadow-sm border-1 border-color-dark-50 h-100 hover-shadow p-4 text-center">
        <div class="d-flex justify-content-between align-items-center">
            <span
                class="material-symbols-outlined text-{{ $color }} p-2 fs-1 mb-2 bg-{{ $color }} bg-opacity-25 rounded">{{ $icon }}</span>
            <span class="material-symbols-outlined align-middle fw-bold text-dark text-opacity-50"
                style="font-size: 18px;">arrow_outward
            </span>
        </div>

        <h6 class="fw-bold">{{ $title }}</h6>

        @if ($count)
            <h4 class="fw-bold text-{{ $color }}">{{ $count }}</h4>
        @endif

        @if ($subtitle)
            <p class="text-muted small">{{ $subtitle }}</p>
        @endif

    </div>
</a>
