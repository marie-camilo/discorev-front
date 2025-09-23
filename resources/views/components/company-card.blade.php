@props([
    'name',
    'image',
    'description',
    'offers' => null,
    'url' => '#'
])

<style>
    .company-modern-card {
        position: relative;
        display: flex;
        flex-direction: column;
        background: #fff;
        border-radius: 16px;
        overflow: hidden;
        box-shadow: 0 4px 10px rgba(0,0,0,0.08);
        transition: transform 0.3s ease, box-shadow 0.3s ease;
        height: 100%;
        text-decoration: none;
    }

    .company-modern-card:hover {
        transform: translateY(-4px);
        box-shadow: 0 12px 20px rgba(0,0,0,0.12);
    }

    .company-modern-card * {
        text-decoration: none;
    }

    .company-modern-img {
        width: 100%;
        height: 180px;
        object-fit: cover;
    }

    .company-modern-body {
        padding: 20px;
        flex: 1;
        display: flex;
        flex-direction: column;
    }

    .company-modern-title {
        font-size: 1.2rem;
        font-weight: 700;
        color: var(--indigo);
        margin-bottom: 10px;
    }

    .company-modern-desc {
        color: var(--black);
        opacity: 0.7;
        margin-bottom: 12px;
        flex-grow: 1;
    }

    .company-modern-offers {
        color: var(--orangish);
        font-weight: 600;
        margin-top: auto;
    }

    .company-modern-arrow {
        position: absolute;
        bottom: 16px;
        right: 16px;
        width: 40px;
        height: 40px;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        transition: transform 0.3s ease;
        background: var(--aquamarine);
    }

    .company-modern-card:hover .company-modern-arrow {
        transform: translateX(4px);
    }

    .company-modern-arrow span.material-symbols-outlined {
        font-size: 20px;
        color: white !important;
    }
</style>

<a href="{{ $url }}" class="company-modern-card">
    <img src="{{ $image }}" alt="{{ $name }}" class="company-modern-img">

    <div class="company-modern-body">
        <h3 class="company-modern-title">{{ $name }}</h3>
        <p class="company-modern-desc">{{ $description }}</p>

        @if($offers)
            <div class="company-modern-offers">{{ $offers }}</div>
        @endif
    </div>

    <div class="company-modern-arrow">
        <span class="material-symbols-outlined">arrow_forward</span>
    </div>
</a>
