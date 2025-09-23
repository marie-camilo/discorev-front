@extends('layouts.app')

@section('title', 'Discorev')

@section('content')

    <section class="hero container-fluid py-5">
        <div class="row align-items-center justify-content-center">
            <div class="col-12 col-md-8 hero-left text-center text-md-start">
                <h1 class="mb-4 display-5 display-md-4 display-lg-3">
                    L'emploi social,<br>à portée de main.
                </h1>

                <h2 class="mb-4 fs-6 fs-sm-5 fs-md-4">
                    Construisez votre carrière dans le
                    <span class="highlight-blue">social</span> et accédez à des offres d’emploi
                    <span class="highlight-orange">proche</span> de chez vous avec ou sans expérience.
                </h2>

                <form class="search-bar-welcome d-flex flex-column flex-lg-row align-items-stretch gap-2 mb-4 w-100" role="search">
                    <div class="search-input-container d-flex flex-column flex-lg-row gap-2 w-100">
                        <!-- Champ Job -->
                        <div class="input-group flex-grow-1 flex-nowrap" style="min-width:0;">
                        <span class="input-group-text bg-white border-end-0">
                            <span class="material-symbols-outlined text-secondary">search</span>
                        </span>
                            <input type="text" class="form-control border-start-0"
                                   placeholder="Job, secteur, mots-clés ..." aria-label="Job, secteur, mots-clés">
                        </div>

                        <!-- Champ Lieu -->
                        <div class="input-group flex-grow-1 flex-nowrap" style="min-width:0;">
                        <span class="input-group-text bg-white border-end-0">
                            <span class="material-symbols-outlined text-secondary">location_on</span>
                        </span>
                            <input type="text" class="form-control border-start-0"
                                   placeholder="Lieu" aria-label="Lieu">
                        </div>
                    </div>

                    <!-- Bouton -->
                    <button type="submit"
                            class="cta-button-transparent btn btn-primary search-btn-small px-3 mt-2 mt-lg-0 flex-shrink-0">
                        Rechercher
                    </button>
                </form>

                <!-- Boutons CTA -->
                <div class="btn-container d-flex flex-column flex-sm-row gap-3 justify-content-center justify-content-md-start">
                    <a href="{{ route('login') }}" class="text-decoration-none">
                        <button class="cta-button-transparent d-flex align-items-center gap-2 w-100 w-sm-auto">
                            <span class="material-symbols-outlined">work</span> Je recrute
                        </button>
                    </a>

                    <a href="{{ route('login') }}" class="text-decoration-none">
                        <button class="cta-button-transparent d-flex align-items-center gap-2 w-100 w-sm-auto">
                            <span class="material-symbols-outlined">search</span> Je cherche un emploi
                        </button>
                    </a>
                </div>
            </div>

            <!-- Image -->
            <div class="welcome-img col-md-4 hero-right text-center mt-4 mt-md-0 d-none d-lg-block">
                <img src="{{ asset('img/accueil.png') }}" alt="Illustration" class="img-fluid hero-img-small">
            </div>
        </div>
    </section>


    <section class="explore-companies">
        <div class="container">
            <h2>Explorer les entreprises</h2>
            <h4>Découvrez des entreprises qui recrutent activement dans le secteur santé, social et médico-social.</h4>

            <div class="row gy-4 mt-4 mb-5">
                <div class="col-sm-6 col-md-6 col-lg-4 col-xl-3">
                    <a href="{{ route('companies.show', ['identifier' => 'le-petit-jean']) }}" class="company-card">
                        <img src="{{ asset('img/petit-jean.jpg') }}" alt="Entreprise 1">
                        <h3>Le Petit Jean</h3>
                        <p>Une équipe engagée pour un impact social fort.</p>
                        <div class="offers-text">+54 offres</div>
                        <div class="card-icon">
                            <span class="material-symbols-outlined text-white">arrow_forward</span>
                        </div>
                    </a>
                </div>

                <div class="col-sm-6 col-md-6 col-lg-4 col-xl-3">
                    <a href="{{ route('companies.show', ['identifier' => 'altidom']) }}" class="company-card">
                        <img src="{{ asset('img/altidom/altidom.webp') }}" alt="Entreprise 2">
                        <h3>Altidom</h3>
                        <p>Des services à domicile avec l’exigence du monde professionnel.</p>
                        <div class="offers-text">+10 offres</div>
                        <div class="card-icon">
                            <span class="material-symbols-outlined text-white">arrow_forward</span>
                        </div>
                    </a>
                </div>

                <div class="col-sm-6 col-md-6 col-lg-4 col-xl-3">
                    <a href="{{ route('companies.show', ['identifier' => 'azae']) }}" class="company-card">
                        <img src="{{ asset('img/azae.jpg') }}" alt="Entreprise 3">
                        <h3>Azaé</h3>
                        <p>Découvrez leurs opportunités et valeurs.</p>
                        <div class="offers-text">+54 offres</div>
                        <div class="card-icon">
                            <span class="material-symbols-outlined text-white">arrow_forward</span>
                        </div>
                    </a>
                </div>

                <div class="col-sm-6 col-md-6 col-lg-4 col-xl-3">
                    <a href="{{ route('companies.show', ['identifier' => 'azae']) }}" class="company-card">
                        <img src="{{ asset('img/peit-fils.jpg') }}" alt="Entreprise 4">
                        <h3>Petit Fils</h3>
                        <p>Rejoignez une entreprise qui partage vos valeurs.</p>
                        <div class="offers-text">+54 offres</div>
                        <div class="card-icon">
                            <span class="material-symbols-outlined text-white">arrow_forward</span>
                        </div>
                    </a>
                </div>

                <!-- Répétition des entreprises -->
                <div class="col-sm-6 col-md-6 col-lg-4 col-xl-3">
                    <div class="company-card">
                        <img src="{{ asset('img/azae.jpg') }}" alt="Entreprise 5">
                        <h3>Azaé</h3>
                        <p>Découvrez leurs opportunités et valeurs.</p>
                        <a class="cta-link" href="{{ route('companies.show', ['identifier' => 'azae']) }}">+54 offres</a>
                        <div class="card-icon"><span class="material-symbols-outlined text-white">arrow_forward</span>
                        </div>
                    </div>
                </div>

                <div class="col-sm-6 col-md-6 col-lg-4 col-xl-3">
                    <div class="company-card">
                        <img src="{{ asset('img/petit-jean.jpg') }}" alt="Entreprise 6">
                        <h3>Le Petit Jean</h3>
                        <p>Une équipe engagée pour un impact social fort.</p>
                        <a class="cta-link" href="{{ route('companies.show', ['identifier' => 'le-petit-jean']) }}">+18
                            offres</a>
                        <div class="card-icon"><span class="material-symbols-outlined text-white">arrow_forward</span>
                        </div>
                    </div>
                </div>

                <div class="col-sm-6 col-md-6 col-lg-4 col-xl-3">
                    <div class="company-card">
                        <img src="{{ asset('img/peit-fils.jpg') }}" alt="Entreprise 7">
                        <h3>Petit Fils</h3>
                        <p>Rejoignez une entreprise qui partage vos valeurs.</p>
                        <a class="cta-link" href="{{ route('companies.show', ['identifier' => 'petit']) }}">+32 offres</a>
                        <div class="card-icon"><span class="material-symbols-outlined text-white">arrow_forward</span>
                        </div>
                    </div>
                </div>

                <div class="col-sm-6 col-md-6 col-lg-4 col-xl-3">
                    <div class="company-card">
                        <img src="{{ asset('img/senior-compagnie.png') }}" alt="Entreprise 8">
                        <h3>Senior Compagnie</h3>
                        <p>Rejoignez une entreprise qui partage vos valeurs.</p>
                        <a class="cta-link" href="#">+142 offres</a>
                        <div class="card-icon"><span class="material-symbols-outlined text-white">arrow_forward</span>
                        </div>
                    </div>
                </div>
            </div>

            <div class="text-center mt-16 pt-4">
                <x-button href="{{ route('companies.index') }}">Voir plus d'entreprises</x-button>
            </div>
        </div>
    </section>


    <section class="find-job py-5">
        <div class="container container-fluid">
            <div class="mb-5">
                <h2>Trouvez votre job en toute simplicité</h2>
                <h4>Avec Discorev, tout devient plus clair.</h4>
            </div>

            <!-- Bloc 1 -->
            <div class="row align-items-center mb-5">
                <div class="col-lg-6 mb-4 mb-lg-0">
                    <img src="{{ asset('img/following.jpg') }}" alt="Suivi des candidatures" class="img-fluid rounded">
                </div>
                <div class="col-lg-6">
                    <h2>Suivez votre candidature en temps réel</h2>
                    <p>Ne restez plus dans le flou ! Postulez et suivez l’avancée de vos candidatures à chaque étape.
                        Vous êtes informé dès qu’il y a du nouveau.</p>
                    <x-button href="{{ route('job_offers.index') }}">Explorer les offres</x-button>
                </div>
            </div>

            <!-- Bloc 2 -->
            <div class="row align-items-center flex-lg-row-reverse mb-5">
                <div class="col-lg-6 mb-4 mb-lg-0">
                    <img src="{{ asset('img/paperwork.jpg') }}" alt="Offres transparentes" class="img-fluid rounded">
                </div>
                <div class="col-lg-6">
                    <h2>Des offres d’emploi sans surprise</h2>
                    <p>Fini les annonces vagues ! Salaire, conditions de travail, avantages… Vous avez toutes les infos pour choisir en toute confiance.</p>
                    <x-button href="{{ route('job_offers.index') }}">Chercher un job </x-button>
                </div>
            </div>

            <!-- Bloc 3 -->
            <div class="row align-items-center mb-5">
                <div class="col-lg-6 mb-4 mb-lg-0">
                    <img src="{{ asset('img/team.jpg') }}" alt="Recruteurs transparents" class="img-fluid rounded">
                </div>
                <div class="col-lg-6">
                    <h2>Des recruteurs à votre écoute</h2>
                    <p>Découvrez des entreprises qui recrutent activement et qui partagent leurs valeurs, leurs
                        processus et
                        leurs opportunités en toute transparence.</p>
                    <x-button href="{{ route('companies.index') }}">Découvrir les entreprises</x-button>

                </div>
            </div>
        </div>
    </section>

    <section class="competences py-5">
        <div class="container">
            <h2 class="mb-4 text-center">Trouver un job facilement avec Discorev</h2>
            <p class="mb-5 text-center">
                Notre plateforme vous aide à décrocher l'emploi qui correspond à votre profil,
                avec des outils et un accompagnement dédié.
            </p>

            <div class="row g-4">
                <!-- Offres ciblées -->
                <div class="col-12 col-sm-6 col-lg-3">
                    <div class="feature text-center text-sm-start h-100 p-3 overflow-hidden">
                        <div class="d-flex flex-column flex-sm-row justify-content-center justify-content-sm-start align-items-center mb-3">
                            <div class="icon-circle d-flex justify-content-center align-items-center me-0 me-sm-3 mb-2 mb-sm-0"
                                 style="background-color: var(--orangish); color: white;">
                                <span class="material-symbols-outlined text-white">search</span>
                            </div>
                            <h3 class="mb-0 text-break">Offres ciblées</h3>
                        </div>
                        <p class="mb-0 text-break">
                            Des opportunités adaptées à votre expérience et votre localisation.
                        </p>
                    </div>
                </div>

                <!-- Candidature rapide -->
                <div class="col-12 col-sm-6 col-lg-3">
                    <div class="feature text-center text-sm-start h-100 p-3 overflow-hidden">
                        <div class="d-flex flex-column flex-sm-row justify-content-center justify-content-sm-start align-items-center mb-3">
                            <div class="icon-circle d-flex justify-content-center align-items-center me-0 me-sm-3 mb-2 mb-sm-0"
                                 style="background-color: var(--aquamarine); color: white;">
                                <span class="material-symbols-outlined text-white">bolt</span>
                            </div>
                            <h3 class="mb-0 text-break">Candidature rapide</h3>
                        </div>
                        <p class="mb-0 text-break">
                            Postulez en un clic, avec ou sans CV.
                        </p>
                    </div>
                </div>

                <!-- Employeurs fiables -->
                <div class="col-12 col-sm-6 col-lg-3">
                    <div class="feature text-center text-sm-start h-100 p-3 overflow-hidden">
                        <div class="d-flex flex-column flex-sm-row justify-content-center justify-content-sm-start align-items-center mb-3">
                            <div class="icon-circle d-flex justify-content-center align-items-center me-0 me-sm-3 mb-2 mb-sm-0"
                                 style="background-color: var(--indigo); color: white;">
                                <span class="material-symbols-outlined text-white">verified</span>
                            </div>
                            <h3 class="mb-0 text-break">Employeurs fiables</h3>
                        </div>
                        <p class="mb-0 text-break">
                            Des entreprises engagées et vérifiées dans le secteur social.
                        </p>
                    </div>
                </div>

                <!-- Communauté active -->
                <div class="col-12 col-sm-6 col-lg-3">
                    <div class="feature text-center text-sm-start h-100 p-3 overflow-hidden">
                        <div class="d-flex flex-column flex-sm-row justify-content-center justify-content-sm-start align-items-center mb-3">
                            <div class="icon-circle d-flex justify-content-center align-items-center me-0 me-sm-3 mb-2 mb-sm-0"
                                 style="background-color: var(--larch-bolete); color: white;">
                                <span class="material-symbols-outlined text-white">groups</span>
                            </div>
                            <h3 class="mb-0 text-break">Communauté active</h3>
                        </div>
                        <p class="mb-0 text-break">
                            Échangez avec des professionnels du secteur et partagez votre expérience.
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </section>



    <section class="download-app py-5">
        <div class="container">
            <div class="row align-items-center">
                <!-- Image mockup -->
                <div class="col-12 col-lg-6 text-center mb-4 mb-lg-0">
                    <img class="img-fluid app-mockup" src="{{ asset('img/mockup-app.png') }}"
                        alt="Apercu de l'app Discorev">
                </div>

                <!-- Text and buttons -->
                <div class="col-12 col-lg-6 app-infos text-center text-lg-start">
                    <h1 class="mb-3">Votre carrière, toujours à portée de main</h1>
                    <p class="mb-4">Accédez aux meilleures offres d'emploi où que vous soyez et postulez en un clic.</p>
                    <div class="app-buttons d-flex justify-content-center justify-content-lg-start gap-3 flex-wrap">
                        <a href="#" class="cta-button-transparent d-flex align-items-center gap-2">
                            <span class="material-symbols-outlined text-white">android</span> Google Play
                        </a>
                        <a href="#" class="cta-button-transparent d-flex align-items-center gap-2">
                            <i class="fa-brands fa-app-store-ios"></i> App Store
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
