@extends('layouts.app')

@section('title', 'Tarifs recruteurs – Discorev')

@section('content')
    <section class="pricing-section py-5" style="background-color: var(--sand);">
        <div class="container">
            <div class="text-center mb-5">
                <h1 class="fw-bold mb-3" style="color: var(--indigo);">
                    Nos offres <span style="color: var(--orangish);">recruteur</span>
                </h1>
                <p class="fs-5 text-muted">
                    Des formules adaptées à tous les besoins, de la découverte à la marque employeur.
                </p>
            </div>

            <div class="row g-4 justify-content-center">
                <div class="col-md-4 col-lg-3">
                    <div class="pricing-card p-4 h-100 text-center">
                        <h3 class="fw-semibold mb-2" style="color: var(--indigo);">Freemium</h3>
                        <p class="display-6 fw-bold mb-3" style="color: var(--orangish);">0€</p>
                        <ul class="list-unstyled text-muted mb-4">
                            <li>3 annonces offertes</li>
                            <li>Mise en ligne : 48h</li>
                            <li>Profil & page auto-personnalisés</li>
                            <li>Dépôt d’annonces</li>
                        </ul>
                        <a href="{{ route('register') }}" class="cta-button-transparent">Commencer</a>
                    </div>
                </div>

                <div class="col-md-4 col-lg-3">
                    <div class="pricing-card p-4 h-100 text-center">
                        <h3 class="fw-semibold mb-2" style="color: var(--indigo);">Connect 2</h3>
                        <p class="display-6 fw-bold mb-3" style="color: var(--orangish);">29€</p>
                        <ul class="list-unstyled text-muted mb-4">
                            <li>2 annonces / mois</li>
                            <li>Mise en ligne : 48h</li>
                            <li>Profil & page auto-personnalisés</li>
                            <li>Dépôt d’annonces</li>
                        </ul>
                        <a href="{{ route('register') }}" class="cta-button-transparent">Souscrire</a>
                    </div>
                </div>

                <div class="col-md-4 col-lg-3">
                    <div class="pricing-card p-4 h-100 text-center">
                        <h3 class="fw-semibold mb-2" style="color: var(--indigo);">Connect 4</h3>
                        <p class="display-6 fw-bold mb-3" style="color: var(--orangish);">39€</p>
                        <ul class="list-unstyled text-muted mb-4">
                            <li>4 annonces / mois</li>
                            <li>Mise en ligne : 48h</li>
                            <li>Profil & page auto-personnalisés</li>
                            <li>Dépôt d’annonces</li>
                        </ul>
                        <a href="{{ route('register') }}" class="cta-button-transparent">Souscrire</a>
                    </div>
                </div>

                <div class="col-md-6 col-lg-4">
                    <div class="pricing-card p-4 h-100 text-center highlight">
                        <h3 class="fw-semibold mb-2" style="color: var(--indigo);">Connect +</h3>
                        <p class="display-6 fw-bold mb-3" style="color: var(--orangish);">79€</p>
                        <ul class="list-unstyled text-muted mb-4">
                            <li>Annonces illimitées (réactivation 30j)</li>
                            <li>Mise en ligne : 48h</li>
                            <li>Profil & page auto-personnalisés</li>
                            <li>Dépôt d’annonces</li>
                        </ul>
                        <a href="{{ route('register') }}" class="cta-button-transparent">Souscrire</a>
                    </div>
                </div>

                <!-- Premium -->
                <div class="col-md-6 col-lg-6">
                    <div class="pricing-card p-4 h-100 text-center premium">
                        <h3 class="fw-semibold mb-2" style="color: var(--indigo);">Premium - Marque Employeur</h3>
                        <p class="display-6 fw-bold mb-3" style="color: var(--orangish);">1890€ / an</p>
                        <ul class="list-unstyled text-muted mb-4">
                            <li>Payable en 4 fois (acompte 472,5€)</li>
                            <li>Annonces illimitées (réactivation 30j)</li>
                            <li>Page employeur sur mesure & copywriting</li>
                            <li>Contenu média : 3 interviews, 10 photos</li>
                            <li>Audit de marque employeur</li>
                            <li>Accès prioritaire aux nouvelles features (CVthèque)</li>
                        </ul>
                        <x-button href="{{ route('register') }}">Contacter l’équipe</x-button>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
