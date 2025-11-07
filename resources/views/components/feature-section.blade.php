@props(['features' => []])

<section class="feature-section">
    <div class="container">
        <div class="text-center mb-5">
            <h2 class="display-4 fw-bold mb-3">Valorisez votre entreprise</h2>
            <p class="fs-5 mx-auto" style="color: var(--text-secondary); max-width: 800px">
                Développez votre visibilité, valorisez votre culture et renforcez votre attractivité auprès de vos clients, partenaires et futurs collaborateurs.
            </p>
            <div class="text-center mb-5">
                <a href="{{ $buttonLink ?? route('recruiters.tarifs') }}" class="btn-modern btn-highlight">
                    {{ $buttonText ?? 'Je valorise mon entreprise' }}
                </a>
            </div>
        </div>

        <div class="container pt-5 features-container">
            @foreach($features as $index => $feature)
                <div class="feature-block {{ $index === count($features)-1 ? 'mb-3' : '' }}">
                    <div class="row align-items-center {{ $feature['reverse'] ?? false ? 'flex-lg-row-reverse' : '' }}">
                        <div class="col-lg-6 mb-4 mb-lg-0">
                            <div class="feature-image-container">
                                <div class="feature-image-bg {{ $feature['badgeColor'] ?? 'blue' }}"></div>
                                <img src="{{ asset($feature['image']) }}" alt="{{ $feature['title'] }}" class="feature-image">
                            </div>
                        </div>
                        <div class="col-lg-6">
                            @if(!empty($feature['badge']))
                                <div class="section-badge badge-{{ $feature['badgeColor'] ?? 'blue' }} mb-3 d-inline-flex align-items-center justify-content-center">
                                    @if(!empty($feature['icon']))
                                        <span class="material-symbols-outlined" style="font-size: 16px;">{{ $feature['icon'] }}</span>
                                    @endif
                                    {!! $feature['badge'] !!}
                                </div>
                            @endif

                            <h3 class="display-6 fw-bold mb-4">{!! $feature['title'] !!}</h3>
                            <p class="fs-5 mb-4" style="color: var(--text-secondary); line-height: 1.6;">
                                {!! $feature['description'] !!}
                            </p>

                            @if(!empty($feature['buttonText']) && !empty($feature['buttonLink']))
                                <a href="{{ $feature['buttonLink'] }}" class="btn-modern btn-primary-modern">
                                    {{ $feature['buttonText'] }}
                                </a>
                            @endif
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</section>

<style>
    .feature-section {
        background: #F9FAFB;
        padding: 5rem 0;
    }

    .features-container .feature-block:first-child {
        margin-top: 3rem;
    }

    .features-container .feature-block:last-child {
        margin-bottom: 2rem;
    }

    .feature-block {
        margin-bottom: 5rem;
    }

    .feature-image-container {
        position: relative;
    }

    .feature-image-bg {
        position: absolute;
        inset: 0;
        border-radius: 1.5rem;
        transform: rotate(-3deg);
        z-index: 1;
    }

    .feature-image-bg.blue {
        background: var(--gradient-primary);
    }

    .feature-image-bg.orange {
        background: var(--gradient-secondary);
        transform: rotate(3deg);
    }

    .feature-image-bg.teal {
        background: var(--gradient-tertiary);
        transform: rotate(-2deg);
    }

    .feature-image {
        position: relative;
        width: 100%;
        border-radius: 1.5rem;
        box-shadow: var(--shadow-hover);
        z-index: 2;
    }

    @media (max-width: 768px) {
        .feature-section {
            padding: 3.5rem 0;
        }

        .feature-block {
            margin-bottom: 3.5rem;
        }
    }
</style>
