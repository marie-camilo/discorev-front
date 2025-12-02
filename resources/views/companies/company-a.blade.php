@extends('layouts.app')

@section('title', $recruiter->companyName . ' | Discorev')

@section('content')

    <header class="company-hero-v5">
        @if ($recruiter->banner)
            <img class="hero-banner-v5" src="{{ asset($recruiter->banner) }}" alt="Bandeau entreprise" />
        @endif

        <div class="hero-content-v5 container-v5">
            <div class="hero-main-info-v5">
                <div class="company-logo-v5">
                    @if ($recruiter->logo)
                        <img src="{{ asset($recruiter->logo) }}" alt="Logo entreprise" />
                    @endif
                </div>

                <div class="company-details-v5">
                    <h1 class="company-name-v5">{{ $recruiter->companyName }}</h1>
                    <div class="metadata-v5">
                        <span class="meta-item-v5"><span class="material-symbols-outlined icon-v5">business_center</span>{{ $recruiter->sectorName }}</span>
                        <span class="meta-item-v5"><span class="material-symbols-outlined icon-v5">location_on</span>{{ $recruiter->location }}</span>
                        <span class="meta-item-v5"><span class="material-symbols-outlined icon-v5">groups</span>{{ $recruiter->teamSize }}</span>
                    </div>
                </div>
            </div>

            <div class="header-actions-integrated">
                <a href="{{ $recruiter->website }}" target="_blank" class="btn-modern btn-secondary-modern">
                    Postuler
                </a>
            </div>
        </div>
    </header>

    <nav class="company-nav-v5" aria-label="Navigation section entreprise">
        <div class="container-v5">
            <ul>
                @foreach ($sections as $section)
                    <li><a href="#{{ $section['anchor'] }}" class="nav-link-v5">{{ $section['label'] }}</a></li>
                @endforeach
                <li><a href="#offres-emplois" class="nav-link-v5">Offres d'Emplois</a></li>
                <li><a href="{{ $recruiter->website }}" target="_blank" class="nav-link-cta-v5">Postuler</a></li>
            </ul>
        </div>
    </nav>

    {{-- CONTENU PRINCIPAL --}}
    <div class="container-v5 content-wrapper-v5" role="main" aria-label="Présentation de l'entreprise {{ $recruiter->companyName }}">

        {{-- LIGNE 1 : PRÉSENTATION & CONTACT (Grille 2/3 - 1/3) --}}
        <section id="presentation" class="section-v5 grid-2-col-template-v5">
            <div class="col-main-v5">
                <h2 class="section-title-v5">Présentation</h2>
                @php
                    $presentation = collect($sections)->firstWhere('anchor', 'presentation');
                @endphp
                <p class="text-lead-v5">{{ $presentation['data'] ?? 'Aucune description fournie pour le moment.' }}</p>
            </div>

            <div class="col-sidebar-v5">
                <div class="card-v5 sidebar-card-v5">
                    <h3 class="sidebar-title-v5">Contact & Réseaux</h3>
                    <ul class="info-list-v5">
                        @if (!empty($recruiter->contactEmail))
                            <li><span class="material-symbols-outlined icon-v5">mail</span><a href="mailto:{{ $recruiter->contactEmail }}">{{ $recruiter->contactEmail }}</a></li>
                        @endif
                        @if (!empty($recruiter->contactPhone))
                            <li><span class="material-symbols-outlined icon-v5">call</span><a href="tel:{{ $recruiter->contactPhone }}">{{ $recruiter->contactPhone }}</a></li>
                        @endif
                        @if (!empty($recruiter->location))
                            <li><span class="material-symbols-outlined icon-v5">location_on</span> {{ $recruiter->location }}</li>
                        @endif
                        @if (!empty($recruiter->website))
                            <li><span class="material-symbols-outlined icon-v5">public</span><a href="{{ $recruiter->website }}" target="_blank">{{ parse_url($recruiter->website, PHP_URL_HOST) }}</a></li>
                        @endif
                    </ul>
                </div>
            </div>
        </section>

        {{-- LIGNE 2 : GALERIE D'IMAGES & FICHE D'IDENTITÉ --}}
        <section id="galerie" class="section-v5 grid-2-col-template-v5 reverse-on-mobile">
            <div class="col-main-v5">
                <h2 class="section-title-v5">Nos Locaux en Images</h2>
                @php
                    $galerieSection = collect($sections)->firstWhere('anchor', 'galerie');
                @endphp
                @if ($galerieSection && !empty($galerieSection['data']))
                    <div class="masonry-grid-v5">
                        @foreach ($galerieSection['data'] as $media)
                            <div class="masonry-item-v5">
                                <img src="{{ asset($media->filePath ?? '') }}" alt="{{ $media->title ?? 'Image' }}">
                            </div>
                        @endforeach
                    </div>
                @else
                    <div class="placeholder-v5"><p>Pas de photos disponibles pour l'instant.</p></div>
                @endif
            </div>

            <div class="col-sidebar-v5">
                <div class="card-v5 identity-card-v5">
                    <h2 class="sidebar-title-v5">Fiche d'Identité</h2>
                    <ul class="info-list-v5 identity-list-v5">
                        <li><strong>SIRET:</strong> <span>{{ $recruiter->siret ?? 'N/A' }}</span></li>
                        <li><strong>Taille d'équipe:</strong> <span>{{ $recruiter->teamSize ?? 'N/A' }}</span></li>
                        <li><strong>Secteur:</strong> <span>{{ $recruiter->sectorName ?? 'N/A' }}</span></li>
                        <li><strong>Fondation:</strong> <span>N/A (À ajouter dans CompaniesData)</span></li>
                    </ul>
                </div>
            </div>
        </section>

        {{-- LIGNE 3 : VALEURS & OFFRES (Grille 1/2 - 1/2) --}}
        <section class="section-v5 grid-2-col-template-v5 grid-2-equal-v5">
            <div id="valeurs-culture" class="col-1-2-v5">
                <h2 class="section-title-v5">Valeurs & Culture</h2>
                <p class="text-muted-v5">La culture de {{ $recruiter->companyName }} repose sur trois piliers : **Innovation**, **Collaboration** et **Impact**.</p>
                <div class="values-grid-v5">
                    <div class="value-card-v5"><span class="material-symbols-outlined icon-large-v5">lightbulb</span> Innovation</div>
                    <div class="value-card-v5"><span class="material-symbols-outlined icon-large-v5">group</span> Collaboration</div>
                    <div class="value-card-v5"><span class="material-symbols-outlined icon-large-v5">rocket_launch</span> Impact</div>
                </div>
            </div>

            <div id="offres" class="col-1-2-v5">
                <h2 class="section-title-v5">Offres d'Emploi Récentes</h2>
                @php
                    // Assumant que $jobOffers est une variable disponible passée par le contrôleur
                    $recentJobs = $jobOffers ?? [];
                    $previewJobs = array_slice($recentJobs, 0, 2);
                @endphp

                @if (!empty($previewJobs))
                    @foreach ($previewJobs as $job)
                        <div class="job-preview-v5">
                            <h4>{{ $job['title'] }}</h4>
                            <p class="job-meta-v5">{{ $job['contract'] }} · {{ $job['location'] }} · {{ $job['salary'] }}</p>
                            <a href="{{ $job['link'] ?? route('job_offers.index') }}" class="link-text-v5">
                                Voir l'offre <span class="material-symbols-outlined">arrow_forward</span>
                            </a>
                        </div>
                    @endforeach
                @else
                    <div class="job-preview-v5">
                        <p class="text-muted-v5" style="margin: 0;">Aucune offre d'emploi récente disponible.</p>
                    </div>
                @endif

                <a href="#offres-emplois" class="btn-modern btn-primary-gradient mt-3">
                    Voir toutes les offres
                    <span class="material-symbols-outlined">arrow_downward</span>
                </a>
            </div>
        </section>

        {{-- LIGNE 4 : ÉQUIPE (Vidéo 1/3, Membres 2/3) --}}
        <section id="equipe" class="section-v5 grid-2-col-template-v5 reverse-on-mobile">
            <div class="col-sidebar-v5">
                <h2 class="section-title-v5">L'équipe en Vidéo</h2>
                @if (!empty($recruiter->teamVideoUrl))
                    {{-- Vidéo en 1/3 (col-sidebar) sur grand écran --}}
                    <div class="video-container-v5">
                        <iframe
                            src="{{ $recruiter->teamVideoUrl }}"
                            frameborder="0"
                            allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture"
                            allowfullscreen>
                        </iframe>
                    </div>
                @else
                    <div class="placeholder-v5"><p>Vidéo d'équipe bientôt disponible.</p></div>
                @endif
            </div>

            <div class="col-main-v5">
                <h2 class="section-title-v5">Nos Leaders</h2>
                @php
                    $teamSection = collect($sections)->firstWhere('anchor', 'equipe');
                @endphp

                @if ($teamSection && !empty($teamSection['data']))
                    <p class="text-lead-v5">Découvrez nos leaders et l'ambiance chez {{ $recruiter->companyName }}.</p>
                    {{-- Liste des Membres de l'Équipe --}}
                    <div class="team-grid-v5">
                        @foreach ($teamSection['data'] as $member)
                            <article class="card-v5 team-member-card-v5" role="listitem">
                                <img src="{{ asset($member['avatar'] ?? 'img/default-avatar.png') }}" alt="{{ $member['name'] ?? '' }}" />
                                <div class="member-info-v5">
                                    <h3>{{ $member['name'] ?? '' }}</h3>
                                    <p class="role-v5">{{ $member['role'] ?? '' }}</p>
                                    <a href="#" class="linkedin-link-modern" aria-label="Profil LinkedIn de {{ $member['name'] ?? '' }}"><span class="material-symbols-outlined">link</span> LinkedIn</a>
                                </div>
                            </article>
                        @endforeach
                    </div>
                @else
                    <div class="placeholder-v5"><p>Informations sur l'équipe non disponibles.</p></div>
                @endif
            </div>
        </section>

        {{-- LIGNE 5 : TÉMOIGNAGES (Pleine Largeur) --}}
        <section id="temoignages" class="section-v5 section-full-v5">
            <h2 class="section-title-v5">Ce que disent nos employés</h2>
            @php
                $testimonials = collect($sections)->firstWhere('anchor', 'temoignages')['data'] ?? [];
            @endphp

            @if (!empty($testimonials))
                <div class="testimonials-slider-v5">
                    @foreach ($testimonials as $testimonial)
                        <div class="testimonial-card-v5">
                            <span class="material-symbols-outlined quote-icon-v5">format_quote</span>
                            <p class="quote-text-v5">"{{ $testimonial['quote'] ?? 'Témoignage non spécifié.' }}"</p>
                            <div class="author-info-v5">
                                <p class="author-name-v5">**{{ $testimonial['author'] ?? 'Anonyme' }}**</p>
                                <p class="author-role-v5">{{ $testimonial['role'] ?? 'Employé' }}</p>
                            </div>
                        </div>
                    @endforeach
                </div>
            @else
                <div class="placeholder-v5"><p>Aucun témoignage disponible pour le moment.</p></div>
            @endif
        </section>

        {{-- LIGNE 6 : ESPACE MÉDIAS --}}
        <section id="medias" class="section-v5 section-full-v5">
            <h2 class="section-title-v5">Espace Médias et Presse</h2>
            @php
                $mediaPressSection = collect($sections)->firstWhere('anchor', 'medias');
            @endphp
            @if ($mediaPressSection && !empty($mediaPressSection['data']))
                <div class="masonry-grid-v5 masonry-grid-large-v5">
                    @foreach ($mediaPressSection['data'] as $media)
                        <div class="masonry-item-v5">
                            <img src="{{ asset($media->filePath ?? '') }}" alt="{{ $media->title ?? 'Média' }}">
                        </div>
                    @endforeach
                </div>
            @else
                <div class="placeholder-v5"><p>Contenu médias bientôt disponible.</p></div>
            @endif
        </section>

        {{-- LIGNE 7 : OFFRES D'EMPLOI COMPLÈTES (Pleine Largeur) --}}
        <section id="offres-emplois" class="section-v5 section-full-v5">
            <h2 class="section-title-v5">Toutes nos Opportunités</h2>
            <p class="text-lead-v5">Liste complète de toutes les opportunités actuellement ouvertes chez {{ $recruiter->companyName }}.</p>

            @php
                $allJobs = $jobOffers ?? []; // Utiliser $jobOffers passé par le contrôleur
            @endphp

            <div class="job-offers-full-list-v5">
                @if (!empty($allJobs))
                    @foreach ($allJobs as $job)
                        <div class="job-preview-v5 card-v5 job-full-item">
                            <div class="job-info-col">
                                <h4>{{ $job['title'] }}</h4>
                                <p class="job-meta-v5">
                                    <span class="material-symbols-outlined icon-v5">work</span> {{ $job['contract'] }}
                                    · <span class="material-symbols-outlined icon-v5">location_on</span> {{ $job['location'] }}
                                    @if (!empty($job['salary'])) · <span class="material-symbols-outlined icon-v5">payments</span> {{ $job['salary'] }} @endif
                                </p>
                            </div>
                            <div class="job-action-col">
                                <a href="{{ $job['link'] ?? route('job_offers.index') }}" class="btn-modern btn-primary-modern">
                                    Postuler
                                </a>
                            </div>
                        </div>
                    @endforeach
                @else
                    <div class="alert alert-info card-v5">
                        <p>Il n'y a actuellement aucune offre d'emploi ouverte chez {{ $recruiter->companyName }}.</p>
                    </div>
                @endif
            </div>

            <a href="{{ route('job_offers.index') }}" class="btn-modern btn-primary-gradient mt-3">Accéder au Jobboard</a>
        </section>

    </div>
@endsection

@push('styles')
    <style>
        :root {
            --color-primary: #05383d;
            --color-accent-light: #546e7a;
            --color-accent-warm: #f98948;
            --color-background: #F9F9F9;
            --color-card-background: #FFFFFF;
            --color-text-dark: var(--color-primary);
            --color-text-muted: #616161;
            --color-border: rgba(5, 56, 61, 0.1);
            --color-shadow: rgba(5, 56, 61, 0.08);

            --color-testimonial-bg: #efefef;

            --border-radius-large: 16px;
            --border-radius-base: 10px;
            --shadow-subtle: 0 6px 15px var(--color-shadow);
            --transition-base: all 0.3s ease;
            --gradient-title: linear-gradient(90deg, var(--color-accent-warm), #d55d17);
        }

        body {
            background-color: var(--color-background);
            font-family: 'Inter', sans-serif;
            color: var(--color-text-dark);
            line-height: 1.6;
        }

        .container-v5 {
            max-width: 1300px;
            margin-left: auto;
            margin-right: auto;
            padding-left: 1.5rem;
            padding-right: 1.5rem;
        }

        /* Styles de section et titre conservés mais renommés en -v5 */
        .content-wrapper-v5 > section {
            margin-top: 5rem;
            margin-bottom: 5rem;
            padding-bottom: 3rem;
            border-bottom: 1px solid var(--color-border);
        }

        .section-title-v5 {
            font-size: 2.5rem;
            margin-bottom: 1.5rem;
            color: var(--color-primary);
            font-weight: 800;
            position: relative;
            padding-bottom: 0.75rem;
        }

        .section-title-v5::after {
            content: '';
            position: absolute;
            bottom: 0;
            left: 0;
            width: 70px;
            height: 4px;
            background: var(--gradient-title);
            border-radius: 2px;
        }

        .text-lead-v5 {
            font-size: 1.25rem;
            line-height: 1.6;
            color: var(--color-text-dark);
            margin-bottom: 2rem;
        }
        .text-muted-v5 {
            color: var(--color-text-muted);
            font-size: 1.1rem;
            margin-bottom: 2rem;
        }

        /* Icones */
        .icon-v5 { font-size: 1.25rem !important; }
        .icon-large-v5 { font-size: 1.8rem !important; }
        .icon-tiny-v5 { font-size: 0.8rem !important; }


        /* ========================================================== */
        /* ===== 1. HEADER (HERO V5) ===== */
        /* ========================================================== */
        .company-hero-v5 {
            position: relative;
            width: 100%;
            min-height: 350px;
            display: flex;
            align-items: flex-end;
            padding-bottom: 2rem;
            overflow: hidden;
        }
        .hero-banner-v5 {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            object-fit: cover;
        }
        .hero-content-v5 {
            position: relative;
            z-index: 10;
            display: flex;
            justify-content: space-between;
            align-items: flex-end;
            width: 100%;
            padding-top: 2rem;
        }
        .hero-main-info-v5 {
            display: flex;
            align-items: center;
            gap: 1.5rem;
        }
        .company-logo-v5 {
            width: 120px;
            height: 120px;
            background: white;
            border-radius: 10px;
            box-shadow: 0 8px 20px rgba(0, 0, 0, 0.5);
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 0;
            flex-shrink: 0;
            overflow: hidden;
        }
        .company-logo-v5 img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            display: block;
        }
        .company-details-v5 { color: white; line-height: 1.1; }
        .company-name-v5 { font-size: 2.5rem; margin-bottom: 0.5rem; font-weight: 900; }
        .metadata-v5 { display: flex; flex-wrap: wrap; gap: 0.5rem 1.5rem; font-size: 0.95rem; font-weight: 500; }
        .meta-item-v5 { display: inline-flex; align-items: center; gap: 0.4rem; }

        @media (max-width: 992px) {
            .company-hero-v5 { min-height: 250px; padding-bottom: 1.5rem; }
            .hero-content-v5 { flex-direction: column; align-items: flex-start; gap: 1rem; }
            .company-logo-v5 { width: 90px; height: 90px; }
            .company-name-v5 { font-size: 2rem; }
            .metadata-v5 { font-size: 0.85rem; }
        }

        /* ========================================================== */
        /* ===== 2. NAVIGATION STICKY (NAV V5) - Amélioration Responsive ===== */
        /* ========================================================== */
        .company-nav-v5 {
            background: white;
            border-bottom: 1px solid var(--color-border);
            position: sticky;
            top: 0;
            z-index: 50;
            box-shadow: 0 1px 5px rgba(0, 0, 0, 0.05);
        }

        .company-nav-v5 ul {
            list-style: none;
            padding: 0;
            margin: 0;
            display: flex;
            justify-content: flex-start;
            gap: 0 2.5rem;
            overflow-x: auto;
            -webkit-overflow-scrolling: touch;
            white-space: nowrap;
        }
        .company-nav-v5 ul::-webkit-scrollbar {
            height: 4px;
        }
        .company-nav-v5 ul::-webkit-scrollbar-thumb {
            background: var(--color-border);
            border-radius: 2px;
        }

        .company-nav-v5 ul li a {
            text-decoration: none;
            font-weight: 600;
            color: var(--color-text-dark);
            padding: 1rem 0;
            font-size: 0.95rem;
            transition: var(--transition-base);
            display: block;
            border-bottom: 3px solid transparent;
        }

        .company-nav-v5 ul li a:hover,
        .company-nav-v5 ul li a.active {
            color: var(--color-accent-warm);
            border-bottom-color: var(--color-accent-warm);
        }

        .nav-link-cta-v5 {
            color: var(--color-accent-warm) !important;
            border-bottom: 3px solid var(--color-accent-warm) !important;
        }

        @media (max-width: 768px) {
            .nav-link-cta-v5 { display: none; }

            .company-nav-v5 .container-v5 {
                padding-left: 1rem;
                padding-right: 1rem;
            }

            .company-nav-v5 ul {
                gap: 0 1.5rem;
            }

            .company-nav-v5 ul li a {
                font-size: 0.9rem;
                padding: 0.8rem 0;
            }
        }

        /* ========================================================== */
        /* ===== 3. GRILLES (Grid Layout V5) ===== */
        /* ========================================================== */
        .grid-2-col-template-v5 {
            display: grid;
            grid-template-columns: 2fr 1fr;
            gap: 4rem;
            align-items: flex-start;
        }
        .grid-2-col-template-v5.grid-2-equal-v5 {
            grid-template-columns: 1fr 1fr;
        }
        .col-main-v5 { grid-column: span 1; }
        .col-sidebar-v5 { grid-column: span 1; }
        .col-1-2-v5 { grid-column: span 1; }

        @media (max-width: 1023px) {
            .grid-2-col-template-v5,
            .grid-2-col-template-v5.grid-2-equal-v5 {
                grid-template-columns: 1fr;
                gap: 3rem;
            }
            .grid-2-col-template-v5.reverse-on-mobile {
                display: flex;
                flex-direction: column-reverse;
            }
        }

        /* ========================================================== */
        /* ===== 4. COMPOSANTS (CARTES & BLOCS V5) ===== */
        /* ========================================================== */

        .card-v5 {
            background: var(--color-card-background);
            padding: 2.5rem;
            border-radius: var(--border-radius-large);
            box-shadow: var(--shadow-subtle);
            border: 1px solid var(--color-border);
            transition: var(--transition-base);
        }
        .sidebar-title-v5 {
            font-size: 1.5rem;
            color: var(--color-primary);
            margin-bottom: 1.5rem;
            font-weight: 700;
            border-bottom: 2px solid var(--color-accent-warm);
            padding-bottom: 0.75rem;
        }
        .info-list-v5 { list-style: none; padding: 0; margin: 0; }
        .info-list-v5 li { display: flex; align-items: center; gap: 0.75rem; padding: 0.75rem 0; border-bottom: 1px solid var(--color-border); }
        .info-list-v5 li:last-child { border-bottom: none; }

        .info-list-v5 li a, .info-list-v5 li span { color: var(--color-text-dark); text-decoration: none; font-weight: 500; }
        .info-list-v5 li a:hover { color: var(--color-accent-warm); }
        .identity-list-v5 li strong { font-weight: 700; color: var(--color-text-dark); }
        .identity-list-v5 li span { color: var(--color-text-muted); }

        /* Valeurs (NOUVELLE COULEUR D'ACCENTUATION) */
        .values-grid-v5 {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(150px, 1fr));
            gap: 1.5rem;
        }
        .value-card-v5 {
            background: var(--color-card-background);
            padding: 2rem;
            border-radius: var(--border-radius-base);
            font-weight: 600;
            text-align: center;
            display: flex;
            flex-direction: column;
            align-items: center;
            gap: 1rem;
            border: 1px solid var(--color-border);
            border-left: 5px solid var(--color-accent-light); /* Bleu-Gris Ardoise */
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.03);
        }
        .value-card-v5 .icon-large-v5 {
            color: white;
            background: var(--color-accent-light); /* Bleu-Gris Ardoise */
            padding: 0.75rem;
            border-radius: 50%;
            font-size: 2rem !important;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
        }

        /* Offres récentes */
        .job-preview-v5 {
            background: var(--color-card-background);
            padding: 1.5rem;
            border-radius: var(--border-radius-base);
            border-left: 5px solid var(--color-accent-warm);
            margin-bottom: 1rem;
            box-shadow: 0 2px 4px var(--color-shadow);
        }
        .job-preview-v5 h4 { font-size: 1.3rem; font-weight: 700; margin-bottom: 0.25rem; }
        .job-meta-v5 { font-size: 0.9rem; color: var(--color-text-muted); margin-bottom: 0.75rem; }
        .link-text-v5 { color: var(--color-accent-warm); text-decoration: none; font-weight: 600; font-size: 0.95rem; display: inline-flex; align-items: center; gap: 0.25rem; transition: var(--transition-base); }
        .link-text-v5:hover { color: var(--color-primary); }

        .job-offers-full-list-v5 {
            margin-top: 2rem;
        }

        .job-full-item {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 1.5rem 2.5rem;
            margin-bottom: 1.25rem;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.05);
        }
        .job-full-item h4 {
            margin-bottom: 0.5rem;
        }
        .job-info-col {
            flex-grow: 1;
            margin-right: 2rem;
        }
        .job-action-col .btn-modern {
            padding: 0.75rem 1.5rem;
            white-space: nowrap;
        }
        .job-full-item .job-meta-v5 .icon-v5 {
            font-size: 1rem !important;
            position: relative;
            top: 2px;
        }

        @media (max-width: 768px) {
            .job-full-item {
                flex-direction: column;
                align-items: flex-start;
                padding: 1.5rem;
            }
            .job-info-col {
                margin-right: 0;
                margin-bottom: 1rem;
            }
            .job-action-col {
                width: 100%;
            }
            .job-action-col .btn-modern {
                width: 100%;
            }
        }

        /* Équipe (Vidéo + Membres) */
        .team-grid-v5 {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(250px, 1fr)); /* Optimisé pour 2-3 colonnes */
            gap: 1.5rem;
            margin-top: 2rem;
        }
        .team-member-card-v5 {
            display: flex;
            align-items: center;
            gap: 1.5rem;
            padding: 1.25rem;
        }
        .team-member-card-v5 img {
            width: 70px;
            height: 70px;
            object-fit: cover;
            border-radius: 50%;
            flex-shrink: 0;
            border: 3px solid var(--color-background);
        }
        .member-info-v5 h3 { font-size: 1.15rem; font-weight: 700; margin-bottom: 0.25rem; }
        .role-v5 { font-size: 0.95rem; color: var(--color-text-muted); margin-bottom: 0.5rem; }
        .linkedin-link-modern {
            text-decoration: none;
            color: var(--wondrous-blue);
            font-size: 0.9rem;
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
            font-weight: 600;
        }

        .video-container-v5 {
            position: relative;
            width: 100%;
            padding-bottom: 75%;
            height: 0;
            overflow: hidden;
            border-radius: var(--border-radius-large);
            box-shadow: var(--shadow-subtle);
            margin-top: 1.5rem;
        }
        .video-container-v5 iframe {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            border: none;
        }
        @media (max-width: 1023px) {
            .video-container-v5 {
                padding-bottom: 56.25%;
            }
        }

        .testimonials-slider-v5 {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(320px, 1fr));
            gap: 2.5rem;
            margin-top: 2rem;
        }
        .testimonial-card-v5 {
            background: var(--color-testimonial-bg);
            color: white;
            padding: 2.5rem;
            border-radius: var(--border-radius-large);
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.2);
            position: relative;
            border-top: 6px solid var(--color-accent-warm);
            display: flex;
            flex-direction: column;
            justify-content: space-between;
        }
        .quote-icon-v5 {
            position: absolute;
            top: 1rem;
            right: 1.5rem;
            font-size: 4rem !important;
            color: #607D8B;
            opacity: 0.4;
            z-index: 1;
        }
        .quote-text-v5 {
            font-style: italic;
            font-size: 1.15rem;
            line-height: 1.8;
            margin-bottom: 1.5rem;
            z-index: 2;
            color: var(--indigo);
        }
        .author-name-v5 {
            font-weight: 700;
            color: var(--indigo);
        }
        .author-role-v5 {
            font-size: 0.9rem;
            color: #B0BEC5; /* Gris clair */
        }

        /* Grilles Masonry */
        .masonry-grid-v5 { column-count: 2; column-gap: 1.5rem; margin-top: 2rem; }
        .masonry-grid-large-v5 { column-count: 3; }
        .masonry-item-v5 { break-inside: avoid; padding-bottom: 1.5rem; }
        .masonry-item-v5 img {
            width: 100%;
            height: auto;
            border-radius: var(--border-radius-base);
            object-fit: cover;
            box-shadow: var(--shadow-subtle);
            transition: var(--transition-base);
            display: block;
        }
        @media (max-width: 767px) {
            .masonry-grid-v5,
            .masonry-grid-large-v5 { column-count: 1; }
        }
        @media (min-width: 768px) and (max-width: 1023px) {
            .masonry-grid-large-v5 { column-count: 2; }
        }

        .placeholder-v5 {
            background: var(--color-card-background);
            border: 2px dashed var(--color-border);
            padding: 3rem;
            border-radius: var(--border-radius-base);
            text-align: center;
            color: var(--color-text-muted);
            margin-top: 2rem;
        }
        .btn-modern {
            padding: 0.85rem 1.8rem;
            border-radius: 8px;
            text-decoration: none;
            font-weight: 600;
            font-size: 1rem;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            transition: var(--transition-base);
            border: none;
            cursor: pointer;
        }
        .btn-primary-modern {
            background: var(--color-accent-warm);
            color: white;
            box-shadow: 0 4px 12px rgba(249, 137, 72, 0.4);
        }
        .btn-primary-modern:hover {
            transform: translateY(-2px);
            box-shadow: 0 6px 20px rgba(249, 137, 72, 0.6);
        }
        .btn-secondary-modern {
            background: white;
            color: var(--color-primary);
            border: 1px solid var(--color-primary);
        }
        .btn-secondary-modern:hover {
            background: var(--color-primary);
            color: white;
        }
        .mt-3 { margin-top: 1.5rem; }
        .alert-info {
            background-color: var(--color-background);
            color: var(--color-primary);
            border: 1px solid var(--color-accent-light);
        }

    </style>
@endpush
