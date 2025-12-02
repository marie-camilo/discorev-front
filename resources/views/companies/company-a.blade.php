@extends('layouts.app')

@section('title', $recruiter->companyName . ' | Discorev')

@section('content')

    <div class="company-banner">
        @if ($recruiter->banner)
            <img src="{{ asset($recruiter->banner) }}" alt="Bandeau entreprise" />
            <div class="overlay"></div>
        @else
            <div class="overlay" style="background-color: #9f9f9f;"></div>
        @endif

        <div class="company-header container-company">
            <div class="company-logo">
                @if ($recruiter->logo)
                    <img src="{{ asset($recruiter->logo) }}" alt="Logo entreprise" />
                @endif
            </div>
            <div class="company-info">
                <h1 style="color: white">{{ $recruiter->companyName }}</h1>
                <div class="details">
                    <p><span class="material-symbols-outlined text-white">business_center</span>{{ $recruiter->sectorName }}</p>
                    <p><span class="material-symbols-outlined text-white">location_on</span>{{ $recruiter->location }}</p>
                    <p><span class="material-symbols-outlined text-white">groups</span>{{ $recruiter->teamSize }}</p>
                </div>
            </div>
        </div>
    </div>

    <nav class="company-full-nav" aria-label="Navigation section entreprise">
        <div class="container-company">
            <ul>
                @foreach ($sections as $section)
                    <li><a href="#{{ $section['anchor'] }}">{{ $section['label'] }}</a></li>
                @endforeach
                {{-- Ajoutez ici les liens fixes si vous le souhaitez (ex: Offres d'Emplois) --}}
                <li><a href="#offres-emplois">Offres d'Emplois</a></li>
            </ul>
        </div>
    </nav>

    {{-- CONTENU PRINCIPAL --}}
    <div class="container-company content-wrapper" role="main" aria-label="Présentation de l'entreprise {{ $recruiter->companyName }}">

        {{-- LIGNE 1 : PRÉSENTATION & CONTACTS (Grille 2 Colonnes) --}}
        <section id="presentation" class="grid-section">
            <div class="grid-col-2-3">
                <h2 class="section-title">Présentation de {{ $recruiter->companyName }}</h2>
                @php
                    $presentation = collect($sections)->firstWhere('anchor', 'presentation');
                @endphp
                {{-- Contenu de la présentation basé sur la donnée dynamique --}}
                <p>{{ $presentation['data'] ?? 'Aucune description fournie pour le moment.' }}</p>
            </div>

            {{-- Colonne Droite (Liens & Contact) (Utilise déjà $recruiter - OK) --}}
            <div class="grid-col-1-3">
                <div class="contact-card">
                    {{-- ... (Actions Contacter/Rejoindre) ... --}}
                    {{-- Contact Rapide (Utilise déjà $recruiter - OK) --}}
                    <ul class="infos-list">
                        <h3 class="sidebar-title">Contact Rapide</h3>
                        @if (!empty($recruiter->contactEmail))
                            <li><span class="material-symbols-outlined">alternate_email</span><a href="mailto:{{ $recruiter->contactEmail }}">{{ $recruiter->contactEmail }}</a></li>
                        @endif
                        @if (!empty($recruiter->contactPhone))
                            <li><span class="material-symbols-outlined">call</span><a href="tel:{{ $recruiter->contactPhone }}">{{ $recruiter->contactPhone }}</a></li>
                        @endif
                        @if (!empty($recruiter->location))
                            <li><span class="material-symbols-outlined">location_on</span> {{ $recruiter->location }}</li>
                        @endif
                        @if (!empty($recruiter->website))
                            <li><span class="material-symbols-outlined">public</span><a href="{{ $recruiter->website }}" target="_blank">{{ $recruiter->website }}</a></li>
                        @endif
                    </ul>
                </div>
            </div>
        </section>

        {{-- LIGNE 2 : GRILLE D'IMAGES & FICHE D'IDENTITÉ --}}
        <section id="galerie" class="grid-section reverse-on-mobile">
            <div class="grid-col-2-3">
                <h2 class="section-title">Nos Locaux en Images</h2>
                @php
                    $mediaSection = collect($sections)->firstWhere('anchor', 'galerie');
                @endphp
                @if ($mediaSection && !empty($mediaSection['data']))
                    <div class="image-grid">
                        @foreach ($mediaSection['data'] as $media)
                            <img src="{{ asset($media->filePath ?? '') }}" alt="{{ $media->title ?? 'Image' }}">
                        @endforeach
                    </div>
                @else
                    <div class="image-grid-placeholder"><p>Pas de photos disponibles pour l'instant.</p></div>
                @endif
            </div>

            {{-- Colonne Droite (Fiche Identité - utilise déjà $recruiter - OK) --}}
            <div class="grid-col-1-3">
                <div class="identity-card">
                    <h2 class="section-title">Fiche d'Identité</h2>
                    <ul class="identity-list">
                        <li><strong>SIRET:</strong> {{ $recruiter->siret ?? 'N/A' }}</li>
                        <li><strong>Taille d'équipe:</strong> {{ $recruiter->teamSize ?? 'N/A' }}</li>
                        <li><strong>Secteur:</strong> {{ $recruiter->sectorName ?? 'N/A' }}</li>
                        <li><strong>Fondation:</strong> N/A (À ajouter dans CompaniesData)</li>
                    </ul>
                </div>
            </div>
        </section>

        {{-- LIGNE 3 : VALEURS & OFFRES (Doit être rendu dynamique si vous ajoutez une section 'valeurs-culture' dans CompaniesData) --}}
        <section class="grid-section">
            <div id="valeurs-culture" class="grid-col-1-2">
                <h2 class="section-title">Valeurs & Culture</h2>
                {{-- Ceci est statique. À remplacer par une boucle si vous ajoutez une section 'valeurs-culture' dans CompaniesData --}}
                <p>La culture de {{ $recruiter->companyName }} repose sur trois piliers : **Innovation**, **Collaboration** et **Impact**.</p>
                <div class="values-grid">
                    <div class="value-card"><span class="material-symbols-outlined">lightbulb</span> Innovation</div>
                    <div class="value-card"><span class="material-symbols-outlined">group</span> Collaboration</div>
                    <div class="value-card"><span class="material-symbols-outlined">rocket_launch</span> Impact</div>
                </div>
            </div>

            <div id="offres" class="grid-col-1-2">
                <h2 class="section-title">Offres d'Emploi</h2>
                {{-- Ces offres sont statiques et devront être remplacées par une boucle sur les offres réelles --}}
                <div class="job-card-simple">
                    <h4>Développeur Fullstack Junior</h4>
                    <a href="{{ route('job_offers.index') }}" class="btn-text">Voir l'offre →</a>
                </div>
                <a href="#offres-emplois" class="btn-modern btn-tertiary-modern mt-3">Voir toutes les offres</a>
            </div>
        </section>

        {{-- LIGNE 4 : ÉQUIPE & TÉMOIGNAGE (Grille 2 Colonnes) --}}
        <section id="equipe" class="grid-section">
            <div class="grid-col-2-3">
                <h2 class="section-title">Notre Équipe</h2>
                @php
                    $teamSection = collect($sections)->firstWhere('anchor', 'equipe');
                @endphp

                @if ($teamSection && !empty($teamSection['data']))
                    <p>Découvrez nos leaders et l'ambiance chez {{ $recruiter->companyName }}.</p>
                    <div class="team-grid">
                        @foreach ($teamSection['data'] as $member)
                            <article class="team-member-card" role="listitem">
                                <img src="{{ asset($member['avatar'] ?? 'img/default-avatar.png') }}" alt="{{ $member['name'] ?? '' }}" />
                                <h3>{{ $member['name'] ?? '' }}</h3>
                                <p class="role"><strong>{{ $member['role'] ?? '' }}</strong></p>
                                <a href="#" class="linkedin-link"><img src="{{ asset('img/icons/linkedin.png') }}" alt="LinkedIn" /></a>
                            </article>
                        @endforeach
                    </div>
                @else
                    <div class="video-placeholder"><p>Informations sur l'équipe non disponibles.</p></div>
                @endif
            </div>

            {{-- Colonne Droite (Témoignage - Statique pour l'instant) --}}
            <div id="temoignages" class="grid-col-1-3">
                <h2 class="section-title">Témoignage du Mois</h2>
                <div class="testimonial-card">
                    <p class="quote">"Travailler chez {{ $recruiter->companyName }}, c'est l'assurance de relever des défis passionnants avec une équipe soudée et innovante."</p>
                    <div class="author"><p>— **(À remplacer)**, (Rôle)</p></div>
                </div>
            </div>
        </section>

        {{-- LIGNE 5 : GRILLE DE MÉDIAS (Pleine Largeur) --}}
        <section id="medias">
            <h2 class="section-title">Espace Médias et Presse</h2>
            @if ($mediaSection && !empty($mediaSection['data']))
                <div class="image-grid-large">
                    @foreach ($mediaSection['data'] as $media)
                        <img src="{{ asset($media->filePath ?? '') }}" alt="{{ $media->title ?? 'Média' }}">
                    @endforeach
                </div>
            @else
                <div class="image-grid-placeholder"><p>Contenu médias bientôt disponible.</p></div>
            @endif
        </section>

        {{-- LIGNE 6 : OFFRES D'EMPLOI COMPLÈTES (Pleine Largeur) --}}
        <section id="offres-emplois">
            <h2 class="section-title">Toutes nos Offres d'Emploi</h2>
            <p>Liste complète de toutes les opportunités actuellement ouvertes chez {{ $recruiter->companyName }}.</p>
            <div class="job-offers-full-list">
                <div class="alert alert-info">Chargement dynamique des offres...</div>
            </div>
            <a href="{{ route('job_offers.index') }}" class="btn-modern btn-primary-modern mt-3">Accéder au Jobboard</a>
        </section>

    </div>
@endsection

@push('styles')
    <style>
        :root {
            /* Veuillez définir vos variables si elles ne le sont pas globalement */
            --sand: #f8f8f4; /* Exemple */
            --indigo: #05383d; /* Exemple */
            --aquamarine: #7fffd4; /* Exemple */
            --orangish: #f98948; /* Exemple */
            --wondrous-blue: #007bff; /* Exemple */
            --text-secondary: #5a5a5a; /* Exemple */
            --gradient-secondary: linear-gradient(90deg, #f98948, #ff6b6b); /* Exemple */
        }

        body {
            background-color: var(--sand);
        }

        .container-company {
            max-width: 1300px;
            margin-left: auto;
            margin-right: auto;
            padding-left: 1rem;
            padding-right: 1rem;
        }

        /* ===== GLOBAL SECTIONS & TITLES ===== */
        .content-wrapper > section {
            margin-top: 3rem;
            margin-bottom: 3rem;
            padding-bottom: 1rem;
            border-bottom: 1px solid rgba(0, 0, 0, 0.08);
        }

        .section-title {
            font-size: 1.75rem;
            margin-bottom: 1.5rem;
            color: var(--indigo);
            font-weight: 700;
            position: relative;
            padding-bottom: 0.75rem;
        }

        .section-title::after {
            content: '';
            position: absolute;
            bottom: 0;
            left: 0;
            width: 50px;
            height: 3px;
            background: var(--gradient-secondary);
            border-radius: 2px;
        }

        /* ========================================================== */
        /* ===== 1. BANNER ET HEADER (RÉSOLUTIONS DE STYLE) ===== */
        /* ========================================================== */
        .company-banner {
            position: relative;
            width: 100%;
            aspect-ratio: 16/9;
            max-height: 400px;
            min-height: 220px;
            overflow: visible;
            box-shadow: 0 10px 30px rgba(5, 56, 61, 0.15);
            margin-bottom: 0;
        }

        .company-banner img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            position: absolute;
            top: 0;
            left: 0;
            z-index: 1;
        }

        /* Correction de l'Overlay pour la lisibilité du texte */
        .company-banner .overlay {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            z-index: 2;
            background: rgba(5, 56, 61, 0.5); /* Semi-transparent foncé */
        }

        /* Positionnement du Header */
        .company-header {
            position: absolute;
            bottom: 0;
            left: 0;
            right: 0;
            z-index: 3;
            display: flex;
            flex-direction: row;
            align-items: flex-end;
            gap: 2rem;
            padding: 0 1rem 1.5rem;
            margin: 0 auto;
        }

        /* Correction du Logo (Dimensionnement et positionnement) */
        .company-logo {
            width: 120px;
            height: 120px;
            background: white;
            border-radius: 16px;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.2);
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 0.5rem;
            transform: translateY(-60px); /* Décalage vers le haut (moitié de la hauteur) */
            flex-shrink: 0;
        }

        .company-logo img {
            width: 100%;
            height: 100%;
            object-fit: contain; /* S'assurer que le logo entier est visible */
            position: relative; /* Annuler l'absolu du parent pour cette image */
            z-index: 0;
            border-radius: 0;
        }

        /* Style des Infos du Header */
        .company-info {
            padding-bottom: 1.5rem;
        }

        .company-info h1 {
            font-size: 2.5rem;
            margin-bottom: 0.5rem;
            font-weight: 800;
            line-height: 1.1;
            text-shadow: 1px 1px 3px rgba(0, 0, 0, 0.4);
        }

        .company-info .details p {
            font-size: 1rem;
            font-weight: 500;
            color: #eee;
            margin-bottom: 0.25rem;
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
            margin-right: 1.5rem;
        }

        .company-info .details .material-symbols-outlined {
            font-size: 1.2rem;
        }

        /* Styles Mobile pour le Header */
        @media (max-width: 767px) {
            .company-header {
                flex-direction: column;
                align-items: flex-start;
                padding-bottom: 0.5rem;
            }
            .company-logo {
                width: 100px;
                height: 100px;
                transform: translateY(-50px);
            }
            .company-info {
                padding-bottom: 1rem;
                margin-top: -30px;
            }
            .company-info h1 {
                font-size: 2rem;
            }
        }

        .company-full-nav {
            width: 100%;
            background: white;
            border-bottom: 1px solid rgba(5, 56, 61, 0.1);
            position: sticky;
            top: 0;
            z-index: 50;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.05);
            padding: 5px;
        }

        .company-full-nav ul {
            list-style: none;
            padding: 0;
            margin: 0;
            display: flex;
            flex-wrap: wrap;
            justify-content: flex-start;
            gap: 0.25rem 1rem;
            overflow-x: auto;
            -webkit-overflow-scrolling: touch;
        }

        .company-full-nav ul li {
            flex-shrink: 0;
        }

        .company-full-nav ul li a {
            text-decoration: none;
            font-weight: 600;
            color: var(--indigo);
            padding: 0.8rem 1rem;
            border-radius: 0;
            font-size: 0.95rem;
            transition: all 0.3s ease;
            display: block;
            border-bottom: 3px solid transparent;
        }

        .company-full-nav ul li a:hover {
            background: var(--sand);
            border-bottom-color: var(--aquamarine);
        }

        @media (max-width: 767px) {
            .company-full-nav ul {
                flex-wrap: nowrap;
            }
        }


        /* ========================================================== */
        /* ===== 3. GRILLE DE MISE EN PAGE (Grid Layout) ===== */
        /* ========================================================== */
        .grid-section {
            display: grid;
            grid-template-columns: 1fr;
            gap: 3rem;
            align-items: flex-start;
        }

        @media (min-width: 1024px) {
            .grid-section {
                grid-template-columns: repeat(3, 1fr);
                gap: 4rem;
            }
            .grid-section.reverse-on-mobile {
                display: grid;
            }
        }

        /* Colonnes */
        .grid-col-2-3 {
            grid-column: span 2;
        }
        .grid-col-1-3 {
            grid-column: span 1;
        }
        .grid-col-1-2 {
            grid-column: span 1;
        }

        @media (min-width: 1024px) {
            .grid-section:nth-child(3) { /* Pour la ligne Valeurs/Offres */
                grid-template-columns: repeat(2, 1fr);
                gap: 3rem;
            }
        }

        @media (max-width: 1023px) {
            .grid-col-2-3, .grid-col-1-3, .grid-col-1-2 {
                grid-column: span 1;
            }
            .grid-section.reverse-on-mobile {
                display: flex;
                flex-direction: column-reverse;
            }
        }

        /* ========================================================== */
        /* ===== 4. COMPOSANTS (CARTES) ===== */
        /* ========================================================== */

        /* Carte Contact (colonne droite) */
        .contact-card {
            background: white;
            padding: 2rem;
            border-radius: 16px;
            box-shadow: 0 4px 20px rgba(5, 56, 61, 0.08);
            border: 1px solid rgba(5, 56, 61, 0.05);
            margin-top: 3.25rem;
        }

        .infos-list {
            list-style: none;
            padding: 0;
            margin: 0;
        }

        .infos-list li {
            display: flex;
            align-items: center;
            gap: 0.75rem;
            padding: 0.6rem 0;
            border-bottom: 1px dashed rgba(5, 56, 61, 0.1);
        }

        .infos-list li:last-child {
            border-bottom: none;
        }

        .infos-list a {
            color: var(--indigo);
            text-decoration: none;
            font-weight: 500;
        }

        .sidebar-title {
            font-size: 1.15rem;
            color: var(--indigo);
            margin-bottom: 1rem;
            font-weight: 700;
        }

        /* Fiche Identité */
        .identity-card {
            background: white;
            padding: 2rem;
            border-radius: 16px;
            box-shadow: 0 4px 20px rgba(5, 56, 61, 0.08);
            border: 1px solid rgba(5, 56, 61, 0.05);
        }

        .identity-list {
            list-style: none;
            padding: 0;
            margin: 0;
        }

        .identity-list li {
            padding: 0.6rem 0;
            border-bottom: 1px solid rgba(5, 56, 61, 0.1);
        }

        .identity-list li:last-child {
            border-bottom: none;
        }

        /* Carte Valeurs */
        .values-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(180px, 1fr));
            gap: 1rem;
            margin-top: 1.5rem;
        }

        .value-card {
            background: white;
            padding: 1rem 1.25rem;
            border-radius: 12px;
            font-weight: 600;
            color: var(--indigo);
            display: flex;
            align-items: center;
            gap: 0.75rem;
            border: 2px solid var(--aquamarine);
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.05);
        }

        /* Carte Offre Simple */
        .job-card-simple {
            background: white;
            padding: 1.2rem;
            border-radius: 12px;
            margin-bottom: 1rem;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.04);
            transition: transform 0.3s ease;
        }

        .job-card-simple:hover {
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.08);
        }

        .job-card-simple h4 {
            font-size: 1.15rem;
            font-weight: 700;
            margin-bottom: 0.5rem;
        }

        .btn-text {
            color: var(--orangish);
            text-decoration: none;
            font-weight: 600;
            font-size: 0.9rem;
            display: inline-block;
            margin-top: 0.5rem;
        }

        /* Carte Membre Équipe */
        .team-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(200px, 1fr));
            gap: 1.5rem;
            margin-top: 1.5rem;
        }

        .team-member-card {
            text-align: center;
            background: white;
            padding: 1.5rem;
            border-radius: 16px;
            box-shadow: 0 4px 20px rgba(5, 56, 61, 0.08);
            transition: all 0.3s ease;
            border: 1px solid rgba(5, 56, 61, 0.05);
        }

        .team-member-card:hover {
            transform: translateY(-4px);
            box-shadow: 0 8px 30px rgba(5, 56, 61, 0.12);
        }

        .team-member-card img {
            width: 100px;
            height: 100px;
            object-fit: cover;
            border-radius: 50%;
            margin-bottom: 0.75rem;
            border: 4px solid var(--wondrous-blue);
            box-shadow: 0 2px 8px rgba(5, 56, 61, 0.1);
        }

        .team-member-card .role {
            font-size: 0.9rem;
            color: var(--aquamarine);
            margin-bottom: 0.75rem;
        }

        .linkedin-link img {
            width: 20px;
            height: 20px;
            margin-top: 0.5rem;
        }

        /* Carte Témoignage */
        .testimonial-card {
            background: var(--indigo);
            color: white;
            padding: 2rem;
            border-radius: 16px;
            box-shadow: 0 4px 20px rgba(5, 56, 61, 0.15);
            margin-top: 3.25rem;
        }

        .testimonial-card .quote {
            font-style: italic;
            font-size: 1.1rem;
            line-height: 1.6;
            margin-bottom: 1.5rem;
        }

        .testimonial-card .author {
            text-align: right;
            font-weight: 600;
        }

        /* Grille d'images */
        .image-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(150px, 1fr));
            gap: 1rem;
            margin-top: 1.5rem;
        }

        .image-grid-large {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(220px, 1fr));
            gap: 1.5rem;
            margin-top: 2rem;
        }

        .image-grid img, .image-grid-large img {
            width: 100%;
            height: 200px;
            border-radius: 12px;
            object-fit: cover;
            box-shadow: 0 4px 16px rgba(5, 56, 61, 0.1);
            transition: all 0.3s ease;
        }

        .image-grid-placeholder, .video-placeholder {
            background: rgba(255,255,255,0.7);
            border: 1px dashed var(--indigo);
            padding: 2rem;
            border-radius: 12px;
            text-align: center;
            color: var(--text-secondary);
        }

        /* ========================================================== */
        /* ===== 5. BOUTONS MODERNES (Styles standards) ===== */
        /* ========================================================== */
        .btn-modern {
            padding: 0.75rem 1.5rem;
            border-radius: 10px;
            text-decoration: none;
            font-weight: 600;
            font-size: 0.95rem;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            transition: all 0.3s ease;
            border: none;
            cursor: pointer;
        }

        .btn-primary-modern {
            background: var(--gradient-secondary);
            color: white;
            box-shadow: 0 4px 12px rgba(249, 137, 72, 0.4);
        }

        .btn-primary-modern:hover {
            transform: translateY(-2px);
            box-shadow: 0 6px 20px rgba(249, 137, 72, 0.6);
        }

        .btn-secondary-modern {
            background: var(--aquamarine);
            color: var(--indigo);
        }

        .btn-secondary-modern:hover {
            background: var(--indigo);
            color: var(--aquamarine);
        }

        .btn-tertiary-modern {
            background: transparent;
            color: var(--indigo);
            border: 2px solid var(--aquamarine);
        }

        .btn-tertiary-modern:hover {
            background: var(--aquamarine);
        }

        /* ===== Utilitaires et Animations ===== */
        .hover-underline-animation {
            position: relative;
        }

        .hover-underline-animation::after {
            content: '';
            position: absolute;
            width: 0;
            height: 2px;
            display: block;
            margin-top: 5px;
            background: var(--aquamarine);
            transition: width .3s;
        }

        .hover-underline-animation:hover::after {
            width: 100%;
        }

        .text-white { color: white !important; }

    </style>
@endpush
