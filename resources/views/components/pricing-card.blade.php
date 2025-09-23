@props([
    'title',
    'price',
    'features' => [],
    'buttonText' => 'Souscrire',
    'buttonUrl' => '#',
    'isHighlighted' => false,
    'isPremium' => false,
    'period' => null
])

<style>
    .modern-card {
        background: white;
        border-radius: 16px;
        box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1);
        transition: all 0.3s ease;
        position: relative;
        overflow: hidden;
    }

    .modern-card:hover {
        transform: translateY(-8px);
        box-shadow: 0 20px 25px -5px rgba(0, 0, 0, 0.1),
        0 10px 10px -5px rgba(0, 0, 0, 0.04);
    }

    .modern-card.highlighted {
        border: 2px solid var(--orangish);
        box-shadow: 0 10px 15px -3px rgba(249, 137, 72, 0.2);
    }

    .modern-card.premium {
        background: white;
        border: 2px solid var(--aquamarine);
    }

    .popular-badge {
        position: absolute;
        top: -12px;
        left: 50%;
        transform: translateX(-50%);
        background: linear-gradient(135deg, var(--orangish), var(--larch-bolete));
        color: var(--sand);
        padding: 4px 16px;
        border-radius: 20px;
        font-size: 0.875rem;
        font-weight: 600;
        z-index: 10;
    }

    .price-gradient {
        background: linear-gradient(135deg, var(--orangish), var(--larch-bolete));
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
        background-clip: text;
        font-size: 3rem;
        font-weight: 800;
    }

    .feature-check {
        width: 20px;
        height: 20px;
        background: linear-gradient(135deg, #89b910, #3a9605);
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        margin-right: 12px;
        flex-shrink: 0;
    }

    .btn-modern {
        border-radius: 12px;
        font-weight: 600;
        padding: 12px 24px;
        transition: all 0.3s ease;
        text-decoration: none;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        width: 100%;
    }

    .btn-primary-gradient {
        background: linear-gradient(135deg, var(--indigo), var(--aquamarine));
        color: var(--sand);
        border: none;
    }

    .btn-primary-gradient:hover {
        transform: translateY(-2px);
        box-shadow: 0 10px 15px -3px rgba(8, 56, 61, 0.3);
        color: var(--sand);
    }

    .btn-highlight {
        background: linear-gradient(135deg, var(--orangish), var(--larch-bolete));
        color: var(--sand);
        border: none;
    }

    .btn-highlight:hover {
        transform: translateY(-2px);
        box-shadow: 0 10px 15px -3px rgba(249, 137, 72, 0.3);
        color: var(--sand);
    }

    .btn-outline-modern {
        background: transparent;
        border: 2px solid var(--aquamarine);
        color: var(--aquamarine);
    }

    .btn-outline-modern:hover {
        background: var(--aquamarine);
        color: var(--sand);
        transform: translateY(-2px);
    }

    .modern-card:hover .decorative-element {
        transform: scale(1.5);
    }
</style>

<div class="position-relative h-100">
    @if($isHighlighted)
        <div class="popular-badge">Populaire</div>
    @endif

    <div class="modern-card h-100 p-4 d-flex flex-column
                @if($isPremium) premium @elseif($isHighlighted) highlighted @endif">

        <div class="decorative-element"></div>

        <div class="text-center mb-4 position-relative" style="z-index: 2;">
            <h3 class="fw-bold mb-3" style="color: var(--indigo); font-size: 1.5rem;">
                {{ $title }}
            </h3>

            <div class="d-flex align-items-baseline justify-content-center mb-2">
                <span class="price-gradient">{{ $price }}</span>
                @if($period)
                    <span class="ms-2" style="color: var(--black);">{{ $period }}</span>
                @endif
            </div>
        </div>

        <div class="flex-grow-1 mb-4">
            <ul class="list-unstyled">
                @foreach($features as $feature)
                    <li class="d-flex align-items-start mb-3">
                        <div class="feature-check">
                            <svg width="12" height="12" fill="white" viewBox="0 0 20 20">
                                <path fill-rule="evenodd"
                                      d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z"
                                      clip-rule="evenodd"></path>
                            </svg>
                        </div>
                        <span style="color: var(--black); opacity: 0.7;">{{ $feature }}</span>
                    </li>
                @endforeach
            </ul>
        </div>

        <div class="mt-auto">
            @if($isPremium)
                <a href="{{ $buttonUrl }}" class="btn-modern btn-primary-gradient">
                    {{ $buttonText }}
                    <svg class="ms-2" width="16" height="16" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd"
                              d="M10.293 3.293a1 1 0 011.414 0l6 6a1 1 0 010 1.414l-6 6a1 1 0 01-1.414-1.414L14.586 11H3a1 1 0 110-2h11.586l-4.293-4.293a1 1 0 010-1.414z"
                              clip-rule="evenodd"></path>
                    </svg>
                </a>
            @elseif($isHighlighted)
                <a href="{{ $buttonUrl }}" class="btn-modern btn-highlight">
                    {{ $buttonText }}
                    <svg class="ms-2" width="16" height="16" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd"
                              d="M10.293 3.293a1 1 0 011.414 0l6 6a1 1 0 010 1.414l-6 6a1 1 0 01-1.414-1.414L14.586 11H3a1 1 0 110-2h11.586l-4.293-4.293a1 1 0 010-1.414z"
                              clip-rule="evenodd"></path>
                    </svg>
                </a>
            @else
                <a href="{{ $buttonUrl }}" class="btn-modern btn-outline-modern">
                    {{ $buttonText }}
                </a>
            @endif
        </div>
    </div>
</div>
