<div class="col-md-4 mb-4">
    <div class="card h-100 shadow-sm border-0 text-center p-4">
        <span class="material-symbols-outlined text-success fs-1 mb-3">{{ $icon }}</span>
        <h6 class="fw-bold">{{ $title }}</h6>
        <p class="text-muted small">{{ $description }}</p>
        <a href="{{ $link ?? '#' }}" class="btn btn-outline-success btn-sm w-100">Accéder</a>
    </div>
</div>
