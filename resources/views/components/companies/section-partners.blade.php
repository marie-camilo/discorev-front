<section class="py-5">
    <div class="container">
        <div class="text-center mb-5">
            <div class="section-badge badge-orange">
                {{ $badge ?? 'Entreprises partenaires' }}
            </div>
            <h2 class="display-4 fw-bold mb-3">{{ $title ?? 'Title' }}</h2>
        </div>

        <div class="row justify-content-center g-2 mb-5">
            @foreach ($companies as $company)
                <x-companies.company-card
                    :name="$company['name']"
                    :description="$company['description']"
                    :link="$company['link']"
                    :image="$company['image']"
                />
            @endforeach
        </div>

        <div class="text-center">
            <a href="{{ $buttonLink ?? route('companies.index') }}" class="btn-modern btn-highlight">
                {{ $buttonText ?? 'Voir plus d’entreprises' }}
            </a>
        </div>
    </div>
</section>
