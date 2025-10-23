@extends('layouts.app')

@section('title', 'Discorev')

@section('content')

    <section class="hero-modern">
        <div class="container">
            <div class="row align-items-center justify-content-center">
                <div class="col-12 col-lg-6 mb-5 mb-lg-0">
                    <div class="section-badge badge-teal mb-3">
                        <span class="material-symbols-outlined" style="font-size: 16px;">trending_up</span>
                        L'emploi sanitaire, social et médico-social réinventé
                    </div>

                    <h1 class="display-3 fw-bold mb-4">
                        L'emploi<br>
                        <span class="gradient-text">à portée de main.</span>
                    </h1>

                    <p class="fs-5 mb-4" style="color: var(--text-secondary); line-height: 1.6;">
                        Construisez votre carrière dans le <span class="fw-bold" style="color: var(--aquamarine);">sanitaire, social et médico-social</span>
                        et accédez à des offres d'emploi <span class="fw-bold" style="color: var(--orangish);">proches</span>
                        de chez vous avec ou sans expérience.
                    </p>

                    <div class="search-bar-modern mb-4">
                        <form class="search-form-modern" role="search">
                            <input type="text" class="form-control search-input-modern" placeholder="Job, secteur, mots-clés ...">
                            <input type="text" class="form-control search-input-modern" placeholder="Lieu">
                            <button type="submit" class="btn-modern btn-primary-modern">
                                Rechercher
                            </button>
                        </form>
                    </div>

                    <div class="d-flex flex-column flex-sm-row gap-3">
                        <a href="{{ route('login') }}" class="btn-modern btn-outline-modern">
                            <span class="material-symbols-outlined">work</span> Je recrute
                        </a>
                        <a href="{{ route('login') }}" class="btn-modern btn-outline-modern-secondary">
                            <span class="material-symbols-outlined">search</span> Je cherche un emploi
                        </a>
                    </div>
                </div>

                <div class="col-12 col-lg-6 d-none d-lg-block">
                    <div class="hero-image-container">
                        <div class="hero-image-bg"></div>
                        <div class="hero-image-wrapper">
                            <img src="{{ asset('img/accueil.png') }}" alt="Illustration Discorev" class="img-fluid rounded">
                        </div>
                        <div class="floating-element floating-element-1">
                            <span class="material-symbols-outlined text-white fs-5">work</span>
                        </div>
                        <div class="floating-element floating-element-2">
                            <span class="material-symbols-outlined text-white fs-5">trending_up</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section class="py-5">
        <div class="container">
            <div class="text-center mb-5">
                <div class="section-badge badge-orange">
                    Entreprises partenaires
                </div>
                <h2 class="display-4 fw-bold mb-3">Explorer les entreprises</h2>
                <p class="fs-5" style="color: var(--text-secondary);">
                    Découvrez des entreprises qui recrutent activement dans le secteur santé, social et médico-social.
                </p>
            </div>

            <div class="row g-4 mb-5">
                <div class="col-sm-6 col-lg-3">
                    <div class="company-card-modern">
                        <img src="{{ asset('img/petit-jean.jpg') }}" alt="Le Petit Jean" class="company-card-image">
                        <div class="company-card-body">
                            <h3 class="company-card-title">Le Petit Jean</h3>
                            <p class="company-card-desc">Une équipe engagée pour un impact social fort.</p>
                            <p class="company-card-offers">+54 offres</p>
                        </div>
                        <div class="company-card-arrow">
                            <span class="material-symbols-outlined text-white">arrow_forward</span>
                        </div>
                    </div>
                </div>

                <div class="col-sm-6 col-lg-3">
                    <div class="company-card-modern">
                        <img src="{{ asset('img/altidom/altidom.webp') }}" alt="Altidom" class="company-card-image">
                        <div class="company-card-body">
                            <h3 class="company-card-title">Altidom</h3>
                            <p class="company-card-desc">Des services à domicile avec l'exigence du monde professionnel.</p>
                            <p class="company-card-offers">+10 offres</p>
                        </div>
                        <div class="company-card-arrow">
                            <span class="material-symbols-outlined text-white">arrow_forward</span>
                        </div>
                    </div>
                </div>

                <div class="col-sm-6 col-lg-3">
                    <div class="company-card-modern">
                        <img src="{{ asset('img/azae.jpg') }}" alt="Azaé" class="company-card-image">
                        <div class="company-card-body">
                            <h3 class="company-card-title">Azaé</h3>
                            <p class="company-card-desc">Découvrez leurs opportunités et valeurs.</p>
                            <p class="company-card-offers">+54 offres</p>
                        </div>
                        <div class="company-card-arrow">
                            <span class="material-symbols-outlined text-white">arrow_forward</span>
                        </div>
                    </div>
                </div>

                <div class="col-sm-6 col-lg-3">
                    <div class="company-card-modern">
                        <img src="{{ asset('img/peit-fils.jpg') }}" alt="Petit Fils" class="company-card-image">
                        <div class="company-card-body">
                            <h3 class="company-card-title">Petit Fils</h3>
                            <p class="company-card-desc">Rejoignez une entreprise qui partage vos valeurs.</p>
                            <p class="company-card-offers">+54 offres</p>
                        </div>
                        <div class="company-card-arrow">
                            <span class="material-symbols-outlined text-white">arrow_forward</span>
                        </div>
                    </div>
                </div>
            </div>

            <div class="text-center">
                <a href="{{ route('companies.index') }}" class="btn-modern btn-primary-modern">
                    Voir plus d'entreprises
                </a>
            </div>
        </div>
    </section>

    <section class="feature-section">
        <div class="container">
            <div class="text-center mb-5">
                <h2 class="display-4 fw-bold mb-3">Trouvez votre job en toute simplicité</h2>
                <p class="fs-5" style="color: var(--text-secondary);">Avec Discorev, tout devient plus clair.</p>
            </div>

            <div class="feature-block">
                <div class="row align-items-center">
                    <div class="col-lg-6 mb-4 mb-lg-0">
                        <div class="feature-image-container">
                            <div class="feature-image-bg blue"></div>
                            <img src="{{ asset('img/following.jpg') }}" alt="Suivi des candidatures" class="feature-image">
                        </div>
                    </div>
                    <div class="col-lg-6">
                        <div class="section-badge badge-blue">
                            Transparence totale
                        </div>
                        <h3 class="display-6 fw-bold mb-4">Suivez votre candidature en temps réel</h3>
                        <p class="fs-5 mb-4" style="color: var(--text-secondary); line-height: 1.6;">
                            Ne restez plus dans le flou ! Postulez et suivez l'avancée de vos candidatures à chaque étape.
                            Vous êtes informé dès qu'il y a du nouveau.
                        </p>
                        <a href="{{ route('job_offers.index') }}" class="btn-modern btn-primary-modern">
                            Explorer les offres
                        </a>
                    </div>
                </div>
            </div>

            <div class="feature-block">
                <div class="row align-items-center flex-lg-row-reverse">
                    <div class="col-lg-6 mb-4 mb-lg-0">
                        <div class="feature-image-container">
                            <div class="feature-image-bg orange"></div>
                            <img src="{{ asset('img/paperwork.jpg') }}" alt="Offres transparentes" class="feature-image">
                        </div>
                    </div>
                    <div class="col-lg-6">
                        <div class="section-badge badge-orange">
                            Informations complètes
                        </div>
                        <h3 class="display-6 fw-bold mb-4">Des offres d'emploi sans surprise</h3>
                        <p class="fs-5 mb-4" style="color: var(--text-secondary); line-height: 1.6;">
                            Fini les annonces vagues ! Salaire, conditions de travail, avantages…
                            Vous avez toutes les infos pour choisir en toute confiance.
                        </p>
                        <a href="{{ route('job_offers.index') }}" class="btn-modern btn-secondary-modern">
                            Chercher un job
                        </a>
                    </div>
                </div>
            </div>

            <div class="feature-block">
                <div class="row align-items-center">
                    <div class="col-lg-6 mb-4 mb-lg-0">
                        <div class="feature-image-container">
                            <div class="feature-image-bg teal"></div>
                            <img src="{{ asset('img/team.jpg') }}" alt="Recruteurs transparents" class="feature-image">
                        </div>
                    </div>
                    <div class="col-lg-6">
                        <div class="section-badge badge-teal">
                            Accompagnement humain
                        </div>
                        <h3 class="display-6 fw-bold mb-4">Des recruteurs à votre écoute</h3>
                        <p class="fs-5 mb-4" style="color: var(--text-secondary); line-height: 1.6;">
                            Découvrez des entreprises qui recrutent activement et qui partagent leurs valeurs,
                            leurs processus et leurs opportunités en toute transparence.
                        </p>
                        <a href="{{ route('companies.index') }}" class="btn-modern btn-primary-modern">
                            Découvrir les entreprises
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section class="py-5">
        <div class="container">
            <div class="text-center mb-5">
                <h2 class="display-4 fw-bold mb-4">Trouver un job facilement avec Discorev</h2>
                <p class="fs-5" style="color: var(--text-secondary);">
                    Notre plateforme vous aide à décrocher l'emploi qui correspond à votre profil,
                    avec des outils et un accompagnement dédié.
                </p>
            </div>

            <div class="row g-4">
                <div class="col-sm-6 col-lg-3">
                    <div class="benefit-card">
                        <div class="benefit-icon icon-orange">
                            <span class="material-symbols-outlined text-white fs-2">search</span>
                        </div>
                        <h3 class="fs-4 fw-bold mb-3">Offres ciblées</h3>
                        <p style="color: var(--text-secondary);">Des opportunités adaptées à votre expérience et votre localisation.</p>
                    </div>
                </div>

                <div class="col-sm-6 col-lg-3">
                    <div class="benefit-card">
                        <div class="benefit-icon icon-teal">
                            <span class="material-symbols-outlined text-white fs-2">bolt</span>
                        </div>
                        <h3 class="fs-4 fw-bold mb-3">Candidature rapide</h3>
                        <p style="color: var(--text-secondary);">Postulez en un clic, avec ou sans CV.</p>
                    </div>
                </div>

                <div class="col-sm-6 col-lg-3">
                    <div class="benefit-card">
                        <div class="benefit-icon icon-blue">
                            <span class="material-symbols-outlined text-white fs-2">verified</span>
                        </div>
                        <h3 class="fs-4 fw-bold mb-3">Employeurs fiables</h3>
                        <p style="color: var(--text-secondary);">Des entreprises engagées et vérifiées dans le secteur social.</p>
                    </div>
                </div>

                <div class="col-sm-6 col-lg-3">
                    <div class="benefit-card">
                        <div class="benefit-icon icon-amber">
                            <span class="material-symbols-outlined text-white fs-2">groups</span>
                        </div>
                        <h3 class="fs-4 fw-bold mb-3">Communauté active</h3>
                        <p style="color: var(--text-secondary);">Échangez avec des professionnels du secteur et partagez votre expérience.</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

{{--    <section class="app-section">--}}
{{--        <div class="container">--}}
{{--            <div class="row align-items-center">--}}
{{--                <!-- Mockup -->--}}
{{--                <div class="col-12 col-lg-6 mb-5 mb-lg-0">--}}
{{--                    <div class="app-mockup-container text-center">--}}
{{--                        <img src="{{ asset('img/mockup-app.png') }}" alt="Aperçu de l'app Discorev" class="app-mockup img-fluid rounded">--}}
{{--                    </div>--}}
{{--                </div>--}}

{{--                <div class="col-12 col-lg-6 text-center text-lg-start">--}}
{{--                    <div class="section-badge badge-teal mb-3">--}}
{{--                        <span class="material-symbols-outlined" style="font-size: 16px;">smartphone</span>--}}
{{--                        Application mobile - En cours de développement !--}}
{{--                    </div>--}}
{{--                    <h2 class="display-4 fw-bold mb-4">Votre carrière, toujours à portée de main</h2>--}}
{{--                    <p class="fs-5 mb-5" style="line-height: 1.6; color: var(--text-secondary);">--}}
{{--                        Accédez aux meilleures offres d'emploi où que vous soyez--}}
{{--                        et postulez en un clic.--}}
{{--                    </p>--}}
{{--                </div>--}}
{{--            </div>--}}
{{--        </div>--}}
{{--    </section>--}}
@endsection

<style>
    .hero-modern {
        background: linear-gradient(135deg, #F9FAFB 0%, #FFFFFF 50%, #EFF6FF 100%);
        position: relative;
        overflow: hidden;
        padding: 5rem 0;
    }

    .hero-image-container {
        position: relative;
        max-width: 80%;
        margin: 0 auto;
    }

    .hero-image-bg {
        position: absolute;
        inset: 0;
        background: var(--gradient-primary);
        border-radius: 1.5rem;
        transform: rotate(4deg);
        z-index: 1;
    }

    .hero-image-wrapper {
        position: relative;
        background: white;
        border-radius: 1.5rem;
        padding: 10px;
        box-shadow: var(--shadow-hover);
        z-index: 2;
    }

    .floating-element {
        position: absolute;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        box-shadow: var(--shadow-soft);
        z-index: 3;
    }

    .floating-element-1 {
        top: -1.25rem;
        right: -1.25rem;
        width: 5.5rem;
        height: 5.5rem;
        background: var(--gradient-tertiary);
    }

    .floating-element-2 {
        bottom: -1.25rem;
        left: -1.25rem;
        width: 4.5rem;
        height: 4.5rem;
        background: var(--gradient-secondary);
    }

    .search-form-modern {
        display: flex;
        flex-wrap: wrap;
        gap: 0.75rem;
    }

    .search-input-modern,
    .btn-primary-modern {
        height: 54px;
        border-radius: 0.75rem;
        font-size: 1rem;
    }

    .search-input-modern:focus {
        background: white;
        box-shadow: 0 0 0 3px rgba(59, 130, 246, 0.15);
        outline: none;
    }

    .section-badge {
        display: inline-flex;
        align-items: center;
        gap: 8px;
        padding: 8px 18px;
        border-radius: 50px;
        font-size: 0.9rem;
        font-weight: 600;
        margin-bottom: 1.25rem;
        backdrop-filter: blur(4px);
    }

    .badge-orange {
        background: rgba(249, 115, 22, 0.15);
        color: var(--orangish);
        border: 1px solid rgba(249, 115, 22, 0.25);
    }

    .badge-blue {
        background: rgba(59, 130, 246, 0.15);
        color: #2563EB;
        border: 1px solid rgba(59, 130, 246, 0.25);
    }

    .badge-teal {
        background: rgba(6, 182, 212, 0.15);
        color: var(--aquamarine);
        border: 1px solid rgba(6, 182, 212, 0.25);
    }

    .company-card-modern {
        background: white;
        border-radius: 1rem;
        overflow: hidden;
        box-shadow: var(--shadow-soft);
        transition: all 0.3s ease;
        height: 100%;
        position: relative;
        text-decoration: none;
        display: block;
    }

    .company-card-modern:hover {
        transform: translateY(-6px);
        box-shadow: var(--shadow-hover);
    }

    .company-card-image {
        width: 100%;
        height: 200px;
        object-fit: cover;
    }

    .company-card-body {
        padding: 1.5rem;
        display: flex;
        flex-direction: column;
        flex-grow: 1;
    }

    .company-card-title {
        font-size: 1.3rem;
        font-weight: 700;
        color: var(--indigo);
        margin-bottom: 0.75rem;
    }

    .company-card-desc {
        color: var(--text-secondary);
        margin-bottom: 1rem;
        flex-grow: 1;
        font-size: 0.95rem;
    }

    .company-card-offers {
        color: var(--orangish);
        font-weight: 600;
        margin-bottom: 0;
        font-size: 0.95rem;
    }

    .company-card-arrow {
        position: absolute;
        bottom: 1rem;
        right: 1rem;
        width: 2.5rem;
        height: 2.5rem;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        background: var(--aquamarine);
        transition: transform 0.3s ease;
    }

    .company-card-modern:hover .company-card-arrow {
        transform: translateX(6px);
    }

    .feature-section {
        background: #F9FAFB;
        padding: 5rem 0;
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

    .benefit-card {
        background: white;
        border-radius: 1rem;
        padding: 2rem;
        box-shadow: var(--shadow-soft);
        transition: all 0.3s ease;
        height: 100%;
        text-align: center;
    }

    .benefit-card:hover {
        transform: translateY(-6px);
        box-shadow: var(--shadow-hover);
    }

    .benefit-icon {
        width: 4.5rem;
        height: 4.5rem;
        border-radius: 1rem;
        display: flex;
        align-items: center;
        justify-content: center;
        margin: 0 auto 1.5rem;
        transition: transform 0.3s ease;
    }

    .benefit-card:hover .benefit-icon {
        transform: scale(1.15);
    }

    .icon-orange { background: var(--gradient-secondary); }
    .icon-teal { background: var(--gradient-tertiary); }
    .icon-blue { background: var(--gradient-primary); }
    .icon-amber { background: linear-gradient(135deg, #F59E0B, #EA580C); }

    .app-section {
        background: linear-gradient(135deg, #F9FAFB 0%, #FFFFFF 50%, #E0F2FE 100%) !important;
        color: var(--text-primary);
        position: relative;
        overflow: hidden;
        margin-bottom: 0;
        margin-top: 0;
    }

    .app-section h2,
    .app-section p,
    .app-section .section-badge {
        color: var(--text-primary);
    }

    .app-mockup-container {
        position: relative;
        max-width: 520px;
        margin: 0 auto;
    }

    .app-mockup {
        position: relative;
        width: 100%;
        z-index: 2;
    }

    @media (max-width: 768px) {
        .hero-modern {
            padding: 3.5rem 0;
        }

        .hero-image-container {
            max-width: 90%;
        }

        .floating-element-1 {
            width: 4rem;
            height: 4rem;
        }

        .floating-element-2 {
            width: 3rem;
            height: 3rem;
        }

        .search-bar-modern {
            padding: 10px;
        }

        .search-input-modern {
            padding: 0.8rem 0.8rem 0.8rem 2.5rem;
            font-size: 0.95rem;
        }

        .btn-modern {
            padding: 0.7rem 1.3rem;
            font-size: 0.95rem;
        }

        .feature-section {
            padding: 3.5rem 0;
        }

        .feature-block {
            margin-bottom: 3.5rem;
        }

        .app-section {
            padding: 4rem 0;
        }

        .app-mockup-container {
            max-width: 280px;
        }
    }

    @media (max-width: 576px) {
        .app-section {
            flex-direction: column;
            align-items: center;
        }
    }
</style>
