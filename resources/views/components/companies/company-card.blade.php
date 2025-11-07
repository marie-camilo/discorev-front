@props([
    'name',
    'image',
    'description',
    'offers' => null,
    'url' => '#'
])

<style>
    .company-card-modern {
        background: white;
        border-radius: 1rem;
        overflow: hidden;
        box-shadow: var(--shadow-soft);
        transition: all 0.3s ease;
        height: 100%;
        position: relative;
        text-decoration: none;
        display: block;
    }

    .company-card-modern:hover {
        transform: translateY(-6px);
        box-shadow: var(--shadow-hover);
    }

    .company-card-image {
        width: 100%;
        height: 200px;
        object-fit: cover;
    }

    .company-card-body {
        padding: 1.5rem;
        display: flex;
        flex-direction: column;
        flex-grow: 1;
    }

    .company-card-title {
        font-size: 1.3rem;
        font-weight: 700;
        color: var(--indigo);
        margin-bottom: 0.75rem;
    }

    .company-card-desc {
        color: var(--text-secondary);
        margin-bottom: 1rem;
        flex-grow: 1;
        font-size: 0.95rem;
    }

    .company-card-modern:hover .company-card-arrow {
        transform: translateX(6px);
    }
</style>

@props(['name', 'description', 'link', 'image'])

<div class="col-12 col-sm-6 col-md-4 col-lg-3 d-flex justify-content-center">
    <a href="{{ $link }}" target="_blank" class="company-card-modern" style="width: 300px; text-decoration: none;">
        <img src="{{ asset($image) }}" alt="{{ $name }}" class="company-card-image">
        <div class="company-card-body">
            <h3 class="company-card-title">{{ $name }}</h3>
            <p class="company-card-desc">{{ $description }}</p>
        </div>
    </a>
</div>

