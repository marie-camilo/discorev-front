@props([
    'badge' => 'Badge',
    'title' => 'Titre',
    'description' => '',
    'showImage' => false,
    'showButtons' => false,
    'buttonText' => 'Découvrir',
    'buttonLink' => '#',
    'variant' => 'default',
    'textAlign' => 'center'
])


<section class="hero-modern py-6 {{ $variant === 'image-button' ? 'hero-with-image-button' : '' }}">
    <div class="hero-content flex-1 {{ $textAlign === 'center' ? 'text-center' : 'text-start' }}">
        @if($badge)
            <div class="section-badge badge-teal mb-3 d-inline-flex align-items-center justify-content-center">
                <span class="material-symbols-outlined" style="font-size: 16px;">trending_up</span>
                {!! $badge !!}
            </div>
        @endif

        <h1 class="display-3 fw-bold mb-4">{!! $title !!}</h1>

        @if($variant === 'default')
            <div class="search-bar-modern mb-4 d-flex justify-content-center">
                <form class="search-form-modern" role="search" style="max-width: 600px; width: 100%;">
                    <div class="search-input-group d-flex align-items-center">
                        <input type="text" class="form-control search-input-modern" placeholder="Job, secteur, mots-clés ...">
                        <button type="submit" class="btn-modern btn-highlight">Rechercher</button>
                    </div>
                </form>
            </div>
        @endif

        @if($description)
            <p class="fs-5 mb-4" style="color: var(--text-secondary); max-width: 700px; {{ $textAlign === 'center' ? 'margin-left:auto;margin-right:auto;' : '' }}">
                {!! $description !!}
            </p>
        @endif

        @if($showButtons && $variant === 'image-button')
            <div class="mt-3">
                <a href="{{ $buttonLink }}" class="btn-modern btn-highlight" style="display: inline-block; width: auto;">
                    {{ $buttonText }}
                </a>
            </div>
        @endif
    </div>
</section>

<style>
    .hero-modern {
        background: linear-gradient(135deg, #F9FAFB 0%, #FFFFFF 50%, #EFF6FF 100%);
        position: relative;
        overflow: hidden;
        padding: 6rem 0;
        text-align: center;
    }

    .hero-image-wrapper {
        position: relative;
        border-radius: 1.5rem;
        padding: 10px;
        background: white;
    }

    .hero-image-bg {
        position: absolute;
        inset: 0;
        background: var(--gradient-primary);
        border-radius: 1.5rem;
        transform: rotate(4deg);
        z-index: 2;
    }

    .hero-image-wrapper img {
        position: relative;
        z-index: 3;
        width: 100%;
        border-radius: 1.5rem;
        box-shadow: var(--shadow-hover);
    }

    .search-bar-modern .search-form-modern {
        width: 100%;
    }

    .search-bar-modern .search-input-group {
        display: flex;
        align-items: center;
        gap: 0.5rem;
    }

    .search-bar-modern input.search-input-modern {
        flex: 1;
        padding: 0.75rem 1rem;
        border-radius: 0.85rem;
        border: 1px solid #E5E7EB;
        font-size: 1rem;
        transition: all 0.3s ease;
        box-shadow: inset 0 1px 2px rgba(0,0,0,0.05);
    }

    .search-bar-modern input.search-input-modern:focus {
        outline: none;
        border-color: var(--aquamarine);
        box-shadow: 0 0 0 3px rgba(6,182,212,0.15);
    }

    .search-bar-modern button.btn-modern {
        padding: 0.75rem 1.5rem;
        border-radius: 0.85rem;
        font-weight: 600;
        font-size: 1rem;
        transition: all 0.3s ease;
    }

    @media (max-width: 768px) {
        .hero-modern {
            padding: 3.5rem 0;
        }

        .hero-image-wrapper {
            max-width: 70%;
            margin: 2rem auto 0 auto;
        }

        .search-bar-modern .search-input-group {
            flex-direction: column;
        }

        .search-bar-modern input.search-input-modern,
        .search-bar-modern button.btn-modern {
            width: 100%;
            max-width: 100%;
        }
    }
</style>
