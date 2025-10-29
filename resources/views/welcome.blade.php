@extends('layouts.app')

@section('title', 'Discorev – L’emploi humain et engagé')

@section('content')

    {{-- HERO SECTION --}}
    <section class="hero-dynamic text-center text-lg-start">
        <div class="container py-5 position-relative">
            <div class="row align-items-center justify-content-center">
                <div class="col-lg-6 animate__animated animate__fadeInLeft">
                    <div class="section-badge badge-secondary mb-4">
                        <span class="material-symbols-outlined" style="font-size:18px;">favorite</span>
                        L'emploi humain, social et médico-social
                    </div>

                    <h1 class="display-3 fw-bold mb-4">
                        Rejoignez une plateforme <br>
                        <span class="gradient-primary">qui remet l’humain au centre</span>
                    </h1>

                    <p class="fs-5 mb-5" style="color: var(--text-secondary); line-height:1.7;">
                        Que vous soyez <strong>professionnel de santé, accompagnant ou recruteur</strong>,
                        Discorev simplifie vos rencontres professionnelles.
                        Trouvez ou publiez des offres en toute transparence.
                    </p>

                    <div class="d-flex flex-column flex-sm-row gap-4 mt-4">
                        <a href="{{ route('register') }}" class="btn-modern btn-primary-modern w-100 w-sm-auto">
                            <span class="material-symbols-outlined">search</span> Je cherche un emploi
                        </a>
                        <a href="{{ route('register') }}" class="btn-modern btn-outline-modern w-100 w-sm-auto">
                            <span class="material-symbols-outlined">work</span> Je recrute
                        </a>
                    </div>
                </div>

                <div class="col-lg-6 d-none d-lg-block text-center">
                    <div class="hero-illustration-wrapper animate-float">
                        <img src="{{ asset('img/accueil.png') }}" alt="Illustration Discorev"
                            class="img-fluid rounded shadow-lg">
                        <div class="floating-icon floating-1">
                            <span class="material-symbols-outlined text-white">diversity_1</span>
                        </div>
                        <div class="floating-icon floating-2">
                            <span class="material-symbols-outlined text-white">handshake</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    {{-- MISSION SECTION --}}
    <section class="mission-section py-5">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-lg-6 mb-4 mb-lg-0">
                    <img src="{{ asset('img/team.jpg') }}" class="img-fluid rounded shadow" alt="À propos de Discorev">
                </div>
                <div class="col-lg-6">
                    <div class="section-badge badge-primary mb-3">
                        <span class="material-symbols-outlined">lightbulb</span> Notre mission
                    </div>
                    <h2 class="display-5 fw-bold mb-4 gradient-text">Connecter les talents à impact humain</h2>
                    <p class="fs-5 mb-4" style="color: var(--text-secondary); line-height:1.7;">
                        Discorev accompagne les <strong>structures sociales et médicales</strong>
                        à trouver des collaborateurs qui partagent leurs valeurs.
                        Ensemble, faisons évoluer le monde du travail dans le sens du <strong>care, de l’inclusion et de la
                            bienveillance</strong>.
                    </p>
                    <a href="{{ route('register') }}" class="btn-modern btn-primary-modern">
                        Rejoindre la communauté
                    </a>
                </div>
            </div>
        </div>
    </section>

    {{-- HOW IT WORKS SECTION --}}
    <section class="how-section py-5 text-center" style="background: #fafaf7;">
        <div class="container">
            <div class="section-badge badge-secondary mb-3">
                <span class="material-symbols-outlined">map</span> Comment ça marche
            </div>
            <h2 class="display-5 fw-bold mb-5 gradient-text">Trouver ou publier un emploi en 3 étapes</h2>

            <div class="row g-5">
                <div class="col-md-4">
                    <div class="step-card">
                        <div class="step-icon bg-primary">
                            <span class="material-symbols-outlined text-white fs-2">person_add</span>
                        </div>
                        <h4 class="fw-bold mt-4">1. Créez votre compte</h4>
                        <p class="text-muted">Inscrivez-vous en tant que candidat ou recruteur en quelques clics.</p>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="step-card">
                        <div class="step-icon bg-secondary">
                            <span class="material-symbols-outlined text-white fs-2">manage_search</span>
                        </div>
                        <h4 class="fw-bold mt-4">2. Recherchez ou publiez</h4>
                        <p class="text-muted">Trouvez l’offre parfaite ou publiez vos besoins selon votre profil.</p>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="step-card">
                        <div class="step-icon bg-success">
                            <span class="material-symbols-outlined text-white fs-2">emoji_people</span>
                        </div>
                        <h4 class="fw-bold mt-4">3. Connectez-vous</h4>
                        <p class="text-muted">Entrez en contact directement et démarrez une collaboration humaine et
                            durable.</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    {{-- ENGAGEMENT SECTION --}}
    <section class="engagement-section py-5">
        <div class="container text-center">
            <div class="section-badge badge-primary mb-3">
                <span class="material-symbols-outlined">volunteer_activism</span> Nos valeurs
            </div>
            <h2 class="display-5 fw-bold mb-5 gradient-text">Un emploi à impact positif</h2>
            <p class="fs-5 mx-auto mb-5" style="color: var(--text-secondary); max-width: 750px;">
                Discorev s’engage à créer une plateforme éthique et accessible,
                où chaque interaction est fondée sur la <strong>confiance, la transparence et l’humain</strong>.
            </p>

            <div class="row g-4">
                <div class="col-md-4">
                    <div class="benefit-card">
                        <div class="benefit-icon icon-primary">
                            <span class="material-symbols-outlined text-white fs-2">verified_user</span>
                        </div>
                        <h4 class="fw-bold mt-3">Fiabilité</h4>
                        <p class="text-muted">Des comptes vérifiés et un espace sécurisé pour tous les utilisateurs.</p>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="benefit-card">
                        <div class="benefit-icon icon-secondary">
                            <span class="material-symbols-outlined text-white fs-2">psychology</span>
                        </div>
                        <h4 class="fw-bold mt-3">Accompagnement</h4>
                        <p class="text-muted">Un suivi personnalisé pour chaque étape de votre parcours.</p>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="benefit-card">
                        <div class="benefit-icon icon-success">
                            <span class="material-symbols-outlined text-white fs-2">diversity_3</span>
                        </div>
                        <h4 class="fw-bold mt-3">Communauté</h4>
                        <p class="text-muted">Un réseau d’acteurs engagés dans les métiers du social et du soin.</p>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <style>
        .hero-dynamic {
            background: linear-gradient(135deg, #ffffff 0%, #fafaf7 50%, #cadae5 100%);
            padding: 6rem 0;
            position: relative;
            overflow: hidden;
        }

        .gradient-primary {
            background: linear-gradient(135deg, #268770, #FFAF2F);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
        }

        .hero-illustration-wrapper {
            position: relative;
            max-width: 85%;
            margin: 0 auto;
        }

        .floating-icon {
            position: absolute;
            border-radius: 50%;
            background: linear-gradient(135deg, #268770, #FFAF2F);
            display: flex;
            align-items: center;
            justify-content: center;
            width: 4rem;
            height: 4rem;
            animation: float 5s ease-in-out infinite;
            box-shadow: 0 8px 24px rgba(0, 0, 0, 0.15);
        }

        .floating-1 {
            top: -1rem;
            right: -1rem;
            animation-delay: 0s;
        }

        .floating-2 {
            bottom: -1rem;
            left: -1rem;
            animation-delay: 2.5s;
        }

        @keyframes float {

            0%,
            100% {
                transform: translateY(0);
            }

            50% {
                transform: translateY(-10px);
            }
        }

        .vibrant-card:hover {
            transform: translateY(-6px) scale(1.02);
            box-shadow: 0 8px 30px rgba(38, 135, 112, 0.25);
            transition: all 0.3s ease;
        }

        .icon-primary {
            background: linear-gradient(135deg, #268770, #44b091);
        }

        .icon-secondary {
            background: linear-gradient(135deg, #FFAF2F, #f98948);
        }

        .icon-success {
            background: linear-gradient(135deg, #489F43, #72c35a);
        }

        .benefit-card {
            background: white;
            border-radius: 1rem;
            padding: 2rem;
            height: 100%;
            transition: all 0.3s ease;
        }

        .section-badge {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            padding: 8px 18px;
            border-radius: 50px;
            font-size: 0.9rem;
            font-weight: 600;
        }

        .badge-primary {
            background: rgba(38, 135, 112, 0.1);
            color: #268770;
        }

        .badge-secondary {
            background: rgba(255, 175, 47, 0.1);
            color: #FFAF2F;
        }

        .hero-dynamic {
            background: linear-gradient(135deg, #ffffff 0%, #fafaf7 50%, #cadae5 100%);
            padding: 7rem 0;
            overflow: hidden;
        }

        .hero-dynamic h1 {
            line-height: 1.2;
        }

        .d-flex.gap-4 a {
            font-size: 1.1rem;
            border-radius: 1rem;
            padding: 1rem 2rem;
            transition: all 0.3s ease;
        }

        .btn-primary-modern {
            background: linear-gradient(135deg, #268770, #44b091);
            border: none;
            color: #fff;
        }

        .btn-primary-modern:hover {
            background: linear-gradient(135deg, #2b997e, #56c7a2);
            transform: translateY(-4px);
            box-shadow: 0 8px 20px rgba(38, 135, 112, 0.3);
        }

        .btn-outline-modern {
            border: 2px solid #268770;
            color: #268770;
            background: transparent;
        }

        .btn-outline-modern:hover {
            background: #268770;
            color: white;
            transform: translateY(-4px);
            box-shadow: 0 8px 20px rgba(38, 135, 112, 0.3);
        }

        /* Steps */
        .step-card {
            background: white;
            border-radius: 1rem;
            padding: 2rem;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.05);
            transition: all 0.3s ease;
            height: 100%;
        }

        .step-card:hover {
            transform: translateY(-6px);
            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.1);
        }

        .step-icon {
            display: flex;
            align-items: center;
            justify-content: center;
            width: 70px;
            height: 70px;
            border-radius: 20px;
            margin: 0 auto;
        }

        /* Gradient text */
        .gradient-text {
            background: linear-gradient(135deg, #268770, #FFAF2F);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
        }

        /* Benefit icons */
        .icon-primary {
            background: linear-gradient(135deg, #268770, #44b091);
        }

        .icon-secondary {
            background: linear-gradient(135deg, #FFAF2F, #f98948);
        }

        .icon-success {
            background: linear-gradient(135deg, #489F43, #72c35a);
        }

        .benefit-card {
            background: white;
            border-radius: 1rem;
            padding: 2rem;
            box-shadow: var(--shadow-soft);
            transition: transform 0.3s ease, box-shadow 0.3s ease;
        }

        .benefit-card:hover {
            transform: translateY(-6px);
            box-shadow: 0 8px 30px rgba(38, 135, 112, 0.25);
        }

        /* --- UNIFORMISATION DES BOUTONS --- */
        a.btn-modern {
            text-decoration: none !important;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            font-weight: 600;
            border-radius: 1rem;
            transition: all 0.3s ease;
            gap: 0.5rem;
        }

        /* Bouton principal vibrant */
        .btn-primary-modern {
            background: linear-gradient(135deg, #268770, #44b091);
            color: #fff !important;
            border: none;
            padding: 1rem 2rem;
            font-size: 1.05rem;
            box-shadow: 0 4px 12px rgba(38, 135, 112, 0.25);
        }

        .btn-primary-modern:hover {
            background: linear-gradient(135deg, #2b997e, #56c7a2);
            transform: translateY(-4px);
            box-shadow: 0 8px 25px rgba(38, 135, 112, 0.35);
            text-decoration: none !important;
        }

        /* Bouton secondaire (contour) */
        .btn-outline-modern {
            background: transparent;
            border: 2px solid #268770;
            color: #268770 !important;
            padding: 1rem 2rem;
            font-size: 1.05rem;
            text-decoration: none !important;
            box-shadow: none;
        }

        .btn-outline-modern:hover {
            background: #268770;
            color: #fff !important;
            transform: translateY(-4px);
            box-shadow: 0 8px 25px rgba(38, 135, 112, 0.3);
        }

        /* Bouton secondaire avec couleur orangée */
        .btn-outline-modern-secondary {
            background: transparent;
            border: 2px solid #FFAF2F;
            color: #FFAF2F !important;
            padding: 1rem 2rem;
            font-size: 1.05rem;
            text-decoration: none !important;
            box-shadow: none;
        }

        .btn-outline-modern-secondary:hover {
            background: #FFAF2F;
            color: #fff !important;
            transform: translateY(-4px);
            box-shadow: 0 8px 25px rgba(255, 175, 47, 0.35);
        }

        /* --- SPÉCIFIQUE AU BOUTON "REJOINDRE LA COMMUNAUTÉ" --- */
        .mission-section .btn-primary-modern {
            background: linear-gradient(135deg, #FFAF2F, #f98948);
            color: #fff !important;
            border: none;
            padding: 1rem 2.5rem;
            font-size: 1.1rem;
            font-weight: 600;
            text-transform: none;
            border-radius: 1rem;
            box-shadow: 0 4px 15px rgba(249, 137, 72, 0.25);
        }

        .mission-section .btn-primary-modern:hover {
            background: linear-gradient(135deg, #f98948, #ffb357);
            transform: translateY(-4px);
            box-shadow: 0 10px 25px rgba(249, 137, 72, 0.35);
        }

        /* Supprimer toute décoration résiduelle sur les liens */
        a,
        a:focus,
        a:hover,
        a:visited {
            text-decoration: none !important;
            outline: none !important;
        }
    </style>
@endsection
