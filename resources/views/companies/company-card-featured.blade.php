<div class="section-entreprise">
    <h2>Découvrez {{ $entrepriseCardData->companyName }}</h2>

    {{--
        La Carte Entreprise (Mise en avant)
        Correction : Utilisation de la route dynamique 'entreprise.show'
        et passage du paramètre 'slug'.
    --}}

    @php
        // Assurez-vous que le slug est disponible, sinon utilisez une valeur par défaut
        $slug = $entrepriseCardData->slug ?? 'tech-innov-solutions';
    @endphp

    <a href="{{ route('entreprise.show', ['slug' => $slug]) }}" class="company-card">
        <div class="card-logo">
            <img src="{{ asset($entrepriseCardData->logo) }}" alt="Logo {{ $entrepriseCardData->companyName }}" />
        </div>
        <div class="card-info">
            <h3>{{ $entrepriseCardData->companyName }}</h3>
            <p>{{ $entrepriseCardData->sectorName }} - {{ $entrepriseCardData->location }}</p>
            <span class="view-link">Voir la page complète →</span>
        </div>
    </a>
</div>

<style>
    /* Styles pour .section-entreprise et .company-card */
    .section-entreprise {
        padding: 3rem 0;
        max-width: 1400px;
        margin: auto;
    }
    .section-entreprise h2 {
        font-size: 2rem;
        margin-bottom: 2rem;
        color: var(--indigo);
        font-weight: 700;
        padding-left: 15px; /* Ajuster au container */
        padding-right: 15px; /* Ajuster au container */
    }

    .company-card {
        display: flex;
        align-items: center;
        gap: 1.5rem;
        padding: 1.5rem;
        border: 1px solid #eee;
        border-radius: 12px;
        text-decoration: none;
        color: var(--indigo);
        transition: all 0.3s ease;
        max-width: 450px;
        margin: 2rem 15px 0 15px; /* Centrage et marges */
        background: white;
        box-shadow: 0 4px 12px rgba(5, 56, 61, 0.05);
    }
    /* ... (Insérez ici le reste de vos styles pour .company-card, .card-logo, .card-info, etc.) */
    .company-card:hover {
        transform: translateY(-4px);
        box-shadow: 0 8px 20px rgba(5, 56, 61, 0.1);
        border-color: var(--aquamarine);
    }
    .card-logo img {
        width: 80px;
        height: 80px;
        border-radius: 10px;
        object-fit: cover;
        border: 3px solid var(--wondrous-blue);
    }
    .card-info h3 {
        font-size: 1.25rem;
        margin-bottom: 0.25rem;
        font-weight: 700;
    }
    .card-info p {
        font-size: 0.9rem;
        color: var(--text-secondary);
        margin: 0;
    }
    .view-link {
        font-size: 0.85rem;
        color: var(--orangish);
        margin-top: 0.5rem;
        display: block;
    }
</style>
