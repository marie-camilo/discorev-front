@extends('layouts.app')

@section('title', 'Tarifs recruteurs – Discorev')

@section('content')
    <style>
        .pricing-hero {
            padding-top: 3rem;
            padding-bottom: 4rem;
        }

        @media (min-width: 992px) {
            .pricing-hero {
                padding-top: 4rem;
            }
        }

        .feature-badge {
            background: rgba(249, 137, 72, 0.15);
            color: var(--orangish);
            border: 1px solid rgba(249, 137, 72, 0.3);
            padding: 8px 16px;
            border-radius: 20px;
            display: inline-flex;
            align-items: center;
            font-size: 0.875rem;
            font-weight: 500;
            margin-bottom: 1.5rem;
        }

        .contact-card {
            background: var(--white);
            border: 1px solid var(--wondrous-blue);
            border-radius: 16px;
            padding: 2rem;
        }
    </style>

    <section class="pricing-hero">
        <div class="container">
            <div class="text-center">
                <div class="feature-badge">
                    <svg width="16" height="16" fill="currentColor" viewBox="0 0 20 20" class="me-2">
                        <path fill-rule="evenodd" d="M11.3 1.046A1 1 0 0112 2v5h4a1 1 0 01.82 1.573l-7 10A1 1 0 018 18v-5H4a1 1 0 01-.82-1.573l7-10a1 1 0 011.12-.38z" clip-rule="evenodd"></path>
                    </svg>
                    Tarification simple et transparente
                </div>

                <h1 class="display-3 fw-bold mb-4">
                    <span class="gradient-text">Nos offres</span><br>
                    <span class="gradient-text-orange">recruteur</span>
                </h1>

                <p class="fs-5 mb-0 mx-auto" style="max-width: 600px; color: var(--black);">
                    Des formules adaptées à tous les besoins, de la découverte à la marque employeur.
                    <br class="d-none d-md-block">
                    <span class="fs-6" style="color: var(--aquamarine);">
                        Choisissez l'offre qui correspond parfaitement à vos ambitions.
                    </span>
                </p>
            </div>
        </div>
    </section>

    <section class="py-5">
        <div class="container">
            <div class="row g-4 justify-content-center mb-5">
                <div class="col-md-6 col-lg-3">
                    <x-pricing-card
                        title="Freemium"
                        price="0€"
                        :features="[
                        '3 annonces offertes',
                        'Profil & page auto-personnalisés',
                        'Dépôt d\'annonces'
                    ]"
                        button-text="Commencer"
                        :button-url="route('register')"
                    />
                </div>

                <div class="col-md-6 col-lg-3">
                    <x-pricing-card
                        title="Connect 2"
                        price="29€"
                        period="/mois"
                        :features="[
                        '2 annonces / mois',
                        'Profil & page auto-personnalisés',
                        'Dépôt d\'annonces'
                    ]"
                        :button-url="route('register')"
                    />
                </div>

                <div class="col-md-6 col-lg-3">
                    <x-pricing-card
                        title="Connect 4"
                        price="39€"
                        period="/mois"
                        :features="[
                        '4 annonces / mois',
                        'Profil & page auto-personnalisés',
                        'Dépôt d\'annonces'
                    ]"
                        :button-url="route('register')"
                    />
                </div>

                <div class="col-md-6 col-lg-3">
                    <x-pricing-card
                        title="Connect +"
                        price="79€"
                        period="/mois"
                        :features="[
                        'Annonces illimitées (réactivation 30j)',
                        'Profil & page auto-personnalisés',
                        'Dépôt d\'annonces'
                    ]"
                        :button-url="route('register')"
                        :is-highlighted="true"
                    />
                </div>
            </div>

            <div class="row justify-content-center">
                <div class="col-lg-8">
                    <x-pricing-card
                        title="Premium - Marque Employeur"
                        price="1890€"
                        period="/an"
                        :features="[
                        'Payable en 4 fois - Acompte de 472,5€',
                        'Annonces illimitées',
                        'Page employeur sur mesure & copywriting',
                        'Contenu média : 3 interviews, 10 photos',
                        'Audit de marque employeur',
                        'Accès prioritaire aux nouvelles features - CVthèque'
                    ]"
                        button-text="Contacter l'équipe"
                        :button-url="route('register')"
                        :is-premium="true"
                    />
                </div>
            </div>

            <div class="row justify-content-center mt-5">
                <div class="col-lg-6">
                    <div class="contact-card text-center">
                        <h3 class="fw-bold mb-3" style="color: var(--indigo);">Des questions sur nos offres ?</h3>
                        <p class="text-muted mb-4">
                            Notre équipe est là pour vous accompagner dans le choix de la formule la plus adaptée à vos besoins.
                        </p>
                        <div class="d-flex flex-column flex-sm-row gap-3 justify-content-center">
                            <a href="mailto:contact@discorev.com" class="btn btn-primary d-inline-flex align-items-center">
                                <svg width="16" height="16" fill="currentColor" viewBox="0 0 20 20" class="me-2">
                                    <path d="M2.003 5.884L10 9.882l7.997-3.998A2 2 0 0016 4H4a2 2 0 00-1.997 1.884z"></path>
                                    <path d="M18 8.118l-8 4-8-4V14a2 2 0 002 2h12a2 2 0 002-2V8.118z"></path>
                                </svg>
                                Nous contacter
                            </a>
                            <a href="tel:+33123456789" class="btn btn-outline-secondary d-inline-flex align-items-center">
                                <svg width="16" height="16" fill="currentColor" viewBox="0 0 20 20" class="me-2">
                                    <path d="M2 3a1 1 0 011-1h2.153a1 1 0 01.986.836l.74 4.435a1 1 0 01-.54 1.06l-1.548.773a11.037 11.037 0 006.105 6.105l.774-1.548a1 1 0 011.059-.54l4.435.74a1 1 0 01.836.986V17a1 1 0 01-1 1h-2C7.82 18 2 12.18 2 5V3z"></path>
                                </svg>
                                01 23 45 67 89
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
