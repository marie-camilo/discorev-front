<section class="py-5 section-partners-component">
    <div class="container">
        <div class="text-center mb-5">
            <div class="section-badge badge-orange">
                {{ $badge ?? 'Entreprises partenaires' }}
            </div>
            <h2 class="display-4 fw-bold mb-3">{{ $title ?? 'Title' }}</h2>
        </div>

        {{-- g-4 pour un meilleur espacement dans la grille --}}
        <div class="row justify-content-center g-4 mb-5">
            @foreach ($companies as $company)
                {{-- Chaque carte est dans une colonne responsive (3 cartes par ligne sur grand écran) --}}
                <div class="col-12 col-sm-6 col-lg-4 d-flex justify-content-center">
                    @php
                        // La méthode getPartnerList() fournit déjà le slug pour la redirection
                        $slug = $company->slug;
                        $link = route('entreprise.show', ['slug' => $slug]);
                    @endphp

                    {{-- Structure de la carte adaptée de company-card-featured --}}
                    <a href="{{ $link }}" class="company-list-card">
                        <div class="card-logo">
                            <img src="{{ asset($company->logo) }}"
                                 alt="Logo {{ $company->companyName }}"
                                 onerror="this.onerror=null; this.src='https://placehold.co/60x60/05383d/ffffff?text=Logo';"
                            />
                        </div>
                        <div class="card-info">
                            <h3>{{ $company->companyName }}</h3>
                            <p>{{ $company->sectorName }} - {{ $company->location }}</p>
                            <span class="view-link">Voir la page complète →</span>
                        </div>
                    </a>
                </div>
            @endforeach
        </div>

        <div class="text-center">
            <a href="{{ $buttonLink ?? route('companies.index') }}" class="btn-modern btn-highlight">
                {{ $buttonText ?? 'Voir plus d’entreprises' }}
            </a>
        </div>
    </div>
</section>

<style>
    .company-list-card {
        display: flex;
        align-items: center;
        gap: 1.75rem;
        padding: 2rem;
        width: 100%;
        max-width: 600px;

        background: #fff;
        border-radius: 20px;
        border: 1px solid rgba(0, 0, 0, 0.05);

        box-shadow: 0 8px 20px rgba(0,0,0,0.04);
        transition: all 0.25s ease;

        text-decoration: none;
        color: var(--text-primary);
    }

    .company-list-card:hover {
        transform: translateY(-8px);
        box-shadow: 0 14px 28px rgba(0,0,0,0.08);
        border-color: rgba(56,118,124,0.25);
    }

    .company-list-card .card-logo img {
        width: 100px;
        height: 100px;
        object-fit: contain;
        padding: 0;
        background: transparent;
        border: none;
    }

    /* Infos */
    .company-list-card .card-info h3 {
        font-size: 1.35rem;
        font-weight: 600;
        margin-bottom: 0.4rem;
    }

    .company-list-card .card-info p {
        font-size: 1rem;
        margin: 0;
        color: var(--text-secondary);
    }

    .company-list-card .view-link {
        display: inline-block;
        margin-top: 0.9rem;
        font-size: 0.9rem;
        font-weight: 600;

        padding: 0.45rem 1rem;
        border-radius: 12px;

        background: rgba(56,118,124,0.08);
        color: var(--indigo);
        transition: all .25s ease;
    }

    .company-list-card:hover .view-link {
        background: rgba(56,118,124,0.18);
        color: var(--aquamarine);
    }

    @media(max-width: 768px) {
        .company-list-card {
            padding: 1.5rem;
            gap: 1.2rem;
        }

        .company-list-card .card-logo img {
            width: 80px;
            height: 80px;
        }
    }

</style>
