@extends('layouts.app')

@section('title', $recruiter->companyName ? $recruiter->companyName . ' | Discorev' : 'Entreprise | Discorev')

@section('content')

    <div class="company-banner">
        @if ($recruiter->banner)
            <img src="{{ $recruiter->banner ? config('app.api') . '/' . $recruiter->banner : '' }}" alt="Bandeau entreprise" />
            <div class="overlay"></div>
        @else
            <div></div>
            <div class="overlay" style="background-color: #9f9f9f;"></div>
        @endif

        <div class="company-header">
            <div class="company-logo">
                @if ($recruiter->logo)
                    <img src="{{ $recruiter->logo ? config('app.api') . '/' . $recruiter->logo : asset('img/default-avatar.png') }}" alt="Logo entreprise" />
                @endif
            </div>
            <div class="company-info">
                <h1 style="color: white">{{ $recruiter->companyName }}</h1>
                <div class="details">
                    <p><span class="material-symbols-outlined text-white">business_center</span>{{ $recruiter->sectorName ?? $recruiter->sector }}</p>
                    <p><span class="material-symbols-outlined text-white">location_on</span>{{ $recruiter->location ?? '' }}</p>
                    <p><span class="material-symbols-outlined text-white">groups</span>{{ $recruiter->teamSize ?? '' }}</p>
                </div>
            </div>
        </div>
    </div>

    <div class="container content-wrapper" role="main" aria-label="Présentation de l'entreprise {{ $recruiter->companyName }}">
        <div class="main-content">

            {{-- Navigation locale dynamique --}}
            @if (!empty($sections))
                <nav class="company-nav" aria-label="Navigation section entreprise">
                    <ul>
                        @foreach ($sections as $section)
                            <li>
                                <a class="hover-underline-animation left" href="#{{ $section['anchor'] }}">{{ $section['label'] }}</a>
                            </li>
                        @endforeach
                    </ul>
                </nav>
            @endif

            {{-- Sections dynamiques --}}
            @foreach ($sections as $section)
                <section id="{{ $section['anchor'] }}" tabindex="-1">
                    <h2>{{ $section['label'] }}</h2>

                    @if ($section['type'] === 'text')
                        <p>{{ $section['data'] ?? '' }}</p>

                    @elseif ($section['type'] === 'array' && $section['key'] === 'teamMembers')
                        <p>Découvrez <strong>l'équipe</strong> de la société <strong>{{ $recruiter->companyName }}</strong>.</p>
                        <div class="row">
                            @foreach ($section['data'] as $member)
                                <article class="col-12 col-md-4 team-member" role="listitem">
                                    <img src="{{ asset($member['avatar'] ?? 'img/default-avatar.png') }}" alt="{{ $member['name'] ?? '' }}" />
                                    <h3>{{ $member['name'] ?? '' }}</h3>
                                    <p><strong>{{ $member['role'] ?? '' }}</strong></p>
                                    <p>{{ $member['email'] ?? '' }}</p>
                                </article>
                            @endforeach
                        </div>

                    @elseif ($section['type'] === 'media')
                        <div class="row">
                            @foreach ($section['data'] as $media)
                                <div class="col-6 col-md-4 col-lg-3"> <!-- exemple responsive -->
                                    <img src="{{ config('app.api') . '/' . ($media->filePath ?? '') }}" alt="{{ $media->title ?? '' }}" class="img-fluid">
                                </div>
                            @endforeach
                        </div>

                    @elseif ($section['type'] === 'video')
                        @foreach ($section['data'] as $media)
                            <div class="company-video my-3 ratio ratio-16x9">
                                <iframe src="{{ config('app.api') . '/' . ($media->filePath ?? '') }}" frameborder="0" allowfullscreen></iframe>
                            </div>
                        @endforeach
                    @endif
                </section>
            @endforeach
        </div>

        {{-- Sidebar --}}
        <aside class="sidebar-container" aria-label="Informations complémentaires">
            <section class="sidebar-infos" aria-labelledby="sidebar-infos-title">
                <h3 id="sidebar-infos-title" class="sidebar-title">À propos</h3>
                <ul class="infos-list">
                    @if (!empty($recruiter->contactEmail))
                        <li><span class="material-symbols-outlined">alternate_email</span>
                            <a href="mailto:{{ $recruiter->contactEmail }}">{{ $recruiter->contactEmail }}</a>
                        </li>
                    @endif
                    @if (!empty($recruiter->contactPhone))
                        <li><span class="material-symbols-outlined">call</span>
                            <a href="tel:{{ $recruiter->contactPhone }}">{{ $recruiter->contactPhone }}</a>
                        </li>
                    @endif
                    @if (!empty($recruiter->website))
                        <li><span class="material-symbols-outlined">public</span>
                            <a href="{{ $recruiter->website }}" target="_blank">{{ $recruiter->website }}</a>
                        </li>
                    @endif
                    @if (!empty($recruiter->location))
                        <li><span class="material-symbols-outlined">home</span> {{ $recruiter->location }}</li>
                    @endif
                    @if (!empty($recruiter->siret))
                        <li><span class="material-symbols-outlined">badge</span> SIRET : {{ $recruiter->siret }}</li>
                    @endif
                </ul>
                <a href="#" class="btn-modern btn-primary-modern">Contacter l'entreprise</a>
            </section>

            <section class="sidebar-offers" aria-labelledby="sidebar-offers-title">
                <h3 id="sidebar-offers-title" class="sidebar-title">Dernières offres</h3>
                <ul class="job-list">
                    @foreach ($jobOffers ?? [] as $job)
                        @php
                            // Forcer l'objet en tableau si besoin
                            if(is_object($job)) $job = (array) $job;
                        @endphp
                        <li class="job-card">
                            <h4>{{ $job['title'] ?? '' }}</h4>
                            <p><i class="material-symbols-outlined me-2">location_on</i>{{ $job['location'] ?? '' }}</p>
                            <p class="text-uppercase"><i class="material-symbols-outlined me-2">contract</i>{{ $job['employmentType'] ?? '' }}</p>
                            <p><i class="material-symbols-outlined me-2">calendar_today</i>Publiée le {{ $job['formattedPublicationDate'] ?? '' }}</p>
                            <a href="{{ route('job_offers.show', $job['id'] ?? 0) }}" class="btn btn-highlight">Postuler</a>
                        </li>
                    @endforeach
                </ul>
                <a href="{{ route('job_offers.index') }}" class="btn-modern btn-primary-modern">
                    <span class="material-symbols-outlined">arrow_right</span> Voir toutes les offres
                </a>
            </section>
        </aside>
    </div>
@endsection

<style>
    body {
        background-color: var(--sand);
    }

    section {
        margin-bottom: 3rem;
        padding-bottom: 2rem;
        border-bottom: 1px solid rgba(0, 0, 0, 0.06);
    }

    @media (min-width: 640px) {
        section {
            margin-bottom: 4rem;
            padding-bottom: 2.5rem;
        }
    }

    @media (min-width: 1024px) {
        section {
            margin-bottom: 5rem;
            padding-bottom: 3rem;
        }
    }

    h2 {
        font-size: 1.75rem;
        margin-bottom: 1.5rem;
        margin-top: 2rem;
        color: var(--indigo);
        font-weight: 700;
        position: relative;
        padding-bottom: 0.75rem;
    }

    h2::after {
        content: '';
        position: absolute;
        bottom: 0;
        left: 0;
        width: 60px;
        height: 4px;
        background: var(--gradient-secondary);
        border-radius: 2px;
    }

    @media (min-width: 640px) {
        h2 {
            font-size: 2.25rem;
            margin-bottom: 2rem;
            margin-top: 2.5rem;
        }
    }

    @media (min-width: 1024px) {
        h2 {
            font-size: 2.5rem;
        }
    }

    /* ===== BANNIÈRE ENTREPRISE ===== */
    .company-banner {
        position: relative;
        width: 100%;
        aspect-ratio: 16/9;
        max-height: 400px;
        min-height: 220px;
        overflow: visible;
        border-bottom-left-radius: 20px;
        border-bottom-right-radius: 20px;
        box-shadow: 0 10px 30px rgba(5, 56, 61, 0.15);
        margin-bottom: 80px;
    }

    @media (min-width: 640px) {
        .company-banner {
            height: 350px;
            border-bottom-left-radius: 30px;
            border-bottom-right-radius: 30px;
            margin-bottom: 90px;
        }
    }

    @media (max-width: 767px) {
        .company-banner {
            min-height: 280px;
            height: 280px;
            margin-bottom: 70px;
        }
    }

    @media (max-width: 480px) {
        .company-banner {
            min-height: 260px;
            height: 260px;
        }
    }

    .company-banner img {
        width: 100%;
        height: 100%;
        object-fit: cover;
        border-bottom-left-radius: 20px;
        border-bottom-right-radius: 20px;
    }

    @media (min-width: 640px) {
        .company-banner img {
            border-bottom-left-radius: 30px;
            border-bottom-right-radius: 30px;
        }
    }

    .company-banner .overlay {
        position: absolute;
        inset: 0;
        background: linear-gradient(to bottom, rgba(5, 56, 61, 0.2) 0%, rgba(5, 56, 61, 0.7) 100%);
        border-bottom-left-radius: 20px;
        border-bottom-right-radius: 20px;
    }

    @media (min-width: 640px) {
        .company-banner .overlay {
            border-bottom-left-radius: 30px;
            border-bottom-right-radius: 30px;
        }
    }

    /* ===== LOGO & INFOS ===== */
    .company-header {
        position: absolute;
        bottom: 0;
        left: 0;
        right: 0;
        display: flex;
        flex-direction: row;
        align-items: flex-end;
        gap: 2rem;
        padding: 0 2rem 1.5rem;
        max-width: 1200px;
        margin: 0 auto;
    }

    @media (min-width: 768px) {
        .company-header {
            padding: 0 3rem 2rem;
            gap: 2.5rem;
        }
    }

    /* ===== LOGO ===== */
    .company-logo {
        width: 140px;
        height: 140px;
        border-radius: 20px;
        background: white;
        box-shadow: 0 12px 40px rgba(5, 56, 61, 0.25);
        overflow: hidden;
        flex-shrink: 0;
        border: 5px solid var(--sand);
        transition: transform 0.4s ease, box-shadow 0.4s ease;
        transform: translateY(60px);
    }

    .company-logo:hover {
        transform: translateY(54px) scale(1.02);
        box-shadow: 0 16px 50px rgba(5, 56, 61, 0.35);
    }

    @media (min-width: 768px) {
        .company-logo {
            width: 160px;
            height: 160px;
            transform: translateY(70px);
        }

        .company-logo:hover {
            transform: translateY(64px) scale(1.02);
        }
    }

    .company-logo img {
        width: 100%;
        height: 100%;
        object-fit: cover;
        display: block;
    }

    /* ===== INFO ENTREPRISE ===== */
    .company-info {
        display: flex;
        flex-direction: column;
        gap: 1rem;
        flex: 1;
        padding-bottom: 0.5rem;
    }

    .company-info h1 {
        font-size: clamp(1.75rem, 3vw + 1rem, 2.75rem);
        line-height: 1.2;
        margin: 0;
        color: white;
        font-weight: 700;
        text-shadow: 0 3px 15px rgba(0, 0, 0, 0.6);
    }

    .company-info .details {
        display: flex;
        flex-wrap: wrap;
        gap: 0.75rem;
        font-size: 0.95rem;
        color: var(--sand);
        align-items: center;
    }

    .company-info .details p {
        display: flex;
        align-items: center;
        gap: 0.5rem;
        margin: 0;
        background: rgba(255, 255, 255, 0.18);
        backdrop-filter: blur(12px);
        padding: 0.6rem 1rem;
        border-radius: 12px;
        transition: all 0.3s ease;
        white-space: nowrap;
        border: 1px solid rgba(255, 255, 255, 0.1);
    }

    .company-info .details p:hover {
        background: rgba(255, 255, 255, 0.25);
        transform: translateY(-2px);
    }

    /* ===== RESPONSIVE MOBILE ===== */
    @media (max-width: 767px) {
        .company-header {
            flex-direction: row;
            align-items: center;
            gap: 1rem;
            padding: 1.5rem 1rem 0;
            bottom: auto;
            top: 0;
            transform: none;
        }

        .company-logo {
            width: 90px;
            height: 90px;
            border-radius: 16px;
            transform: translateY(50px);
        }

        .company-logo:hover {
            transform: translateY(46px) scale(1.02);
        }

        .company-info {
            text-align: left;
            width: auto;
            flex: 1;
            padding-bottom: 0;
            gap: 0.75rem;
            transform: none;
        }

        .company-info h1 {
            font-size: 1.25rem;
        }

        .company-info .details {
            flex-direction: column;
            align-items: flex-start;
            gap: 0.4rem;
            width: 100%;
        }

        .company-info .details p {
            justify-content: flex-start;
            font-size: 0.75rem;
            padding: 0.5rem 0.7rem;
            white-space: normal;
            text-align: left;
            width: 100%;
            border-radius: 10px;
        }

        .company-info .details .material-symbols-outlined {
            font-size: 1rem;
            flex-shrink: 0;
        }
    }

    @media (max-width: 480px) {
        .company-logo {
            width: 80px;
            height: 80px;
            transform: translateY(45px);
        }

        .company-logo:hover {
            transform: translateY(41px) scale(1.02);
        }

        .company-info h1 {
            font-size: 1.1rem;
        }

        .company-info .details p {
            font-size: 0.7rem;
            padding: 0.45rem 0.6rem;
        }
    }

    /* ===== CONTENT WRAPPER ===== */
    .content-wrapper {
        display: flex;
        flex-direction: column;
        padding: 2rem 1rem;
        max-width: 1400px;
        margin: auto;
        gap: 2rem;
    }

    @media (min-width: 768px) {
        .content-wrapper {
            flex-direction: row;
            padding: 3rem 2rem;
            gap: 3rem;
        }
    }

    @media (min-width: 1024px) {
        .content-wrapper {
            padding: 4rem 3rem;
            gap: 4rem;
        }
    }

    .main-content {
        width: 100%;
        min-width: 0;
    }

    @media (min-width: 768px) {
        .main-content {
            flex: 1;
        }
    }

    /* ===== NAVIGATION ===== */
    .company-nav {
        padding: 1.5rem 0;
        text-align: left;
        border-bottom: 2px solid rgba(5, 56, 61, 0.1);
        margin-bottom: 2rem;
    }

    .company-nav ul {
        list-style: none;
        padding: 0;
        display: flex;
        flex-wrap: wrap;
        justify-content: flex-start;
        gap: 0.5rem;
    }

    @media (min-width: 640px) {
        .company-nav ul {
            gap: 1rem;
        }
    }

    .company-nav ul li {
        display: inline;
    }

    .company-nav ul li a {
        text-decoration: none;
        font-weight: 600;
        color: var(--indigo);
        padding: 0.5rem 1rem;
        border-radius: 8px;
        font-size: 0.875rem;
        transition: all 0.3s ease;
        display: inline-block;
    }

    .company-nav ul li a:hover {
        background: var(--wondrous-blue);
        color: var(--indigo);
        transform: translateY(-2px);
    }

    @media (min-width: 640px) {
        .company-nav ul li a {
            font-size: 1rem;
            padding: 0.6rem 1.2rem;
        }
    }

    /* ===== SIDEBAR ===== */
    .sidebar-container {
        display: flex;
        flex-direction: column;
        width: 100%;
        max-width: 100%;
        gap: 1.5rem;
    }

    @media (min-width: 768px) {
        .sidebar-container {
            width: 380px;
            flex-shrink: 0;
        }
    }

    .sidebar-offers {
        background: white;
        padding: 1.5rem;
        border-radius: 16px;
        box-shadow: 0 4px 20px rgba(5, 56, 61, 0.08);
        border: 1px solid rgba(5, 56, 61, 0.05);
    }

    @media (min-width: 768px) {
        .sidebar-offers {
            padding: 2rem;
            position: sticky;
            top: 2rem;
        }
    }

    .sidebar-title {
        font-size: 1.25rem;
        color: var(--indigo);
        margin-bottom: 1.5rem;
        display: flex;
        align-items: center;
        gap: 0.75rem;
        font-weight: 700;
    }

    @media (min-width: 640px) {
        .sidebar-title {
            font-size: 1.4rem;
        }
    }

    .job-count {
        background: var(--gradient-secondary);
        color: white;
        padding: 0.25rem 0.75rem;
        font-size: 0.8rem;
        border-radius: 20px;
        font-weight: 600;
        box-shadow: 0 2px 8px rgba(249, 137, 72, 0.3);
    }

    @media (min-width: 640px) {
        .job-count {
            font-size: 0.85rem;
            padding: 0.3rem 0.85rem;
        }
    }

    /* ===== JOB LIST & CARDS ===== */
    .job-list {
        list-style: none;
        padding: 0;
        display: flex;
        flex-direction: column;
        gap: 1rem;
    }

    .job-card {
        background: var(--sand);
        padding: 1.25rem;
        border-radius: 12px;
        box-shadow: 0 3px 12px rgba(5, 56, 61, 0.06);
        transition: all 0.3s ease;
        border: 1px solid rgba(5, 56, 61, 0.05);
        cursor: pointer;
    }

    .job-card:hover {
        transform: translateY(-4px);
        box-shadow: 0 8px 24px rgba(5, 56, 61, 0.12);
        border-color: var(--aquamarine);
    }

    @media (min-width: 640px) {
        .job-card {
            padding: 1.5rem;
        }
    }

    .job-card h4 {
        font-size: 1rem;
        color: var(--indigo);
        margin-bottom: 0.75rem;
        font-weight: 700;
    }

    @media (min-width: 640px) {
        .job-card h4 {
            font-size: 1.125rem;
        }
    }

    .job-card p {
        font-size: 0.875rem;
        color: var(--text-secondary);
        margin: 0.5rem 0;
        display: flex;
        align-items: center;
        gap: 0.5rem;
    }

    @media (min-width: 640px) {
        .job-card p {
            font-size: 0.95rem;
        }
    }

    /* ===== APPLY BUTTON ===== */
    .apply-btn {
        display: block;
        width: 100%;
        padding: 0.85rem;
        background: var(--gradient-secondary);
        color: white;
        text-align: center;
        border-radius: 10px;
        cursor: pointer;
        font-weight: 700;
        font-size: 0.95rem;
        transition: all 0.3s ease;
        border: none;
        box-shadow: 0 4px 12px rgba(249, 137, 72, 0.3);
        margin-top: 1rem;
    }

    .apply-btn:hover {
        transform: translateY(-2px);
        box-shadow: 0 6px 20px rgba(249, 137, 72, 0.4);
    }

    @media (min-width: 640px) {
        .apply-btn {
            padding: 1rem;
            font-size: 1rem;
        }
    }

    /* ===== COLUMNS ===== */
    .two-columns {
        display: grid;
        grid-template-columns: 1fr;
        gap: 1.5rem;
        margin-top: 2rem;
    }

    @media (min-width: 768px) {
        .two-columns {
            grid-template-columns: repeat(2, 1fr);
            gap: 2rem;
        }
    }

    @media (min-width: 1024px) {
        .two-columns {
            gap: 2.5rem;
        }
    }

    .column {
        background: white;
        padding: 2rem;
        border-radius: 16px;
        box-shadow: 0 4px 20px rgba(5, 56, 61, 0.08);
        border: 1px solid rgba(5, 56, 61, 0.05);
        transition: all 0.3s ease;
    }

    .column:hover {
        box-shadow: 0 8px 30px rgba(5, 56, 61, 0.12);
        transform: translateY(-4px);
    }

    @media (min-width: 640px) {
        .column {
            padding: 2.5rem;
        }
    }

    .column h3 {
        color: var(--indigo);
        font-size: 1.25rem;
        margin-bottom: 1rem;
        font-weight: 700;
    }

    .column ul {
        padding-left: 0;
        margin-top: 1rem;
        margin-bottom: 0;
        list-style: none;
    }

    .column li {
        padding: 0.75rem 0;
        border-bottom: 1px solid rgba(5, 56, 61, 0.05);
        color: var(--text-primary);
        display: flex;
        align-items: flex-start;
        gap: 0.75rem;
    }

    .column li:last-child {
        border-bottom: none;
    }

    .column li::before {
        content: "→";
        color: var(--orangish);
        font-weight: bold;
        flex-shrink: 0;
    }

    .key-elements ul {
        padding-left: 0;
        margin-top: 1rem;
        margin-bottom: 0;
        list-style: none;
    }

    /* ===== BENEFITS GRID ===== */
    .benefits-grid {
        display: grid;
        grid-template-columns: 1fr;
        gap: 1.25rem;
        margin-top: 2rem;
    }

    @media (min-width: 640px) {
        .benefits-grid {
            grid-template-columns: repeat(2, 1fr);
            gap: 1.5rem;
        }
    }

    @media (min-width: 1024px) {
        .benefits-grid {
            grid-template-columns: repeat(3, 1fr);
            gap: 2rem;
        }
    }

    .benefit-card {
        background: white;
        padding: 2rem;
        border-radius: 16px;
        text-align: center;
        box-shadow: 0 4px 20px rgba(5, 56, 61, 0.08);
        transition: all 0.4s ease;
        cursor: pointer;
        border: 1px solid rgba(5, 56, 61, 0.05);
    }

    .benefit-card:hover {
        transform: translateY(-8px) scale(1.02);
        box-shadow: 0 12px 40px rgba(5, 56, 61, 0.15);
        border-color: var(--aquamarine);
    }

    @media (min-width: 640px) {
        .benefit-card {
            padding: 2.5rem;
        }
    }

    .benefit-card h3 {
        font-size: 1.125rem;
        color: var(--indigo);
        margin-bottom: 0.75rem;
        font-weight: 700;
    }

    @media (min-width: 640px) {
        .benefit-card h3 {
            font-size: 1.25rem;
            margin-bottom: 1rem;
        }
    }

    .benefit-card p {
        font-size: 0.875rem;
        color: var(--text-secondary);
        line-height: 1.6;
    }

    @media (min-width: 640px) {
        .benefit-card p {
            font-size: 0.95rem;
        }
    }

    /* ===== IMAGE GRIDS ===== */
    .image-grid {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(250px, 1fr));
        grid-auto-rows: 10px;
        gap: 1rem;
    }

    .image-grid img {
        width: 100%;
        display: block;
        border-radius: 12px;
        object-fit: cover;
        aspect-ratio: 4/3;
        grid-row-end: span 10;
    }

    @media (min-width: 640px) {
        .image-grid {
            grid-template-columns: repeat(2, 1fr);
            gap: 1.5rem;
        }
    }

    @media (min-width: 1024px) {
        .image-grid {
            grid-template-columns: repeat(3, 1fr);
            gap: 2rem;
        }
    }

    .image-grid img {
        width: 100%;
        height: 200px;
        border-radius: 12px;
        object-fit: cover;
        box-shadow: 0 4px 16px rgba(5, 56, 61, 0.1);
        transition: all 0.3s ease;
    }

    .image-grid img:hover {
        transform: scale(1.03);
        box-shadow: 0 8px 24px rgba(5, 56, 61, 0.15);
    }

    @media (min-width: 640px) {
        .image-grid img {
            height: 220px;
        }
    }

    @media (min-width: 1024px) {
        .image-grid img {
            height: 250px;
        }
    }

    /* ===== TEAM GRID ===== */
    .team-grid {
        display: grid;
        grid-template-columns: 1fr;
        gap: 1.5rem;
        margin-top: 2rem;
    }

    @media (min-width: 640px) {
        .team-grid {
            grid-template-columns: repeat(2, 1fr);
            gap: 2rem;
        }
    }

    @media (min-width: 1024px) {
        .team-grid {
            grid-template-columns: repeat(3, 1fr);
            gap: 2.5rem;
        }
    }

    .team-member {
        text-align: center;
        background: white;
        padding: 2rem;
        border-radius: 16px;
        box-shadow: 0 4px 20px rgba(5, 56, 61, 0.08);
        transition: all 0.3s ease;
        border: 1px solid rgba(5, 56, 61, 0.05);
    }

    .team-member:hover {
        transform: translateY(-6px);
        box-shadow: 0 8px 30px rgba(5, 56, 61, 0.12);
    }

    @media (min-width: 640px) {
        .team-member {
            padding: 2.5rem;
        }
    }

    .team-member img {
        width: 100px;
        height: 100px;
        object-fit: cover;
        border-radius: 50%;
        margin-bottom: 1rem;
        border: 4px solid var(--wondrous-blue);
        box-shadow: 0 4px 12px rgba(5, 56, 61, 0.1);
    }

    @media (min-width: 640px) {
        .team-member img {
            width: 120px;
            height: 120px;
            margin-bottom: 1.25rem;
        }
    }

    .team-member h3 {
        margin: 0.75rem 0 0.5rem;
        font-size: 1.125rem;
        color: var(--indigo);
        font-weight: 700;
    }

    @media (min-width: 640px) {
        .team-member h3 {
            font-size: 1.25rem;
        }
    }

    .team-member p {
        font-size: 0.875rem;
        color: var(--text-secondary);
    }

    @media (min-width: 640px) {
        .team-member p {
            font-size: 0.95rem;
        }
    }

    /* ===== PHOTO COLLAGE ===== */
    .photo-collage {
        display: grid;
        grid-template-columns: 1fr;
        gap: 1rem;
        margin-top: 2rem;
    }

    @media (min-width: 640px) {
        .photo-collage {
            grid-template-columns: repeat(2, 1fr);
            gap: 1.5rem;
        }
    }

    @media (min-width: 1024px) {
        .photo-collage {
            grid-template-columns: repeat(3, 1fr);
            gap: 2rem;
        }
    }

    .collage-item {
        overflow: hidden;
        border-radius: 12px;
        box-shadow: 0 4px 16px rgba(5, 56, 61, 0.1);
        transition: all 0.3s ease;
    }

    .collage-item:hover {
        transform: scale(1.03);
        box-shadow: 0 8px 24px rgba(5, 56, 61, 0.15);
    }

    .collage-item img {
        width: 100%;
        height: 200px;
        object-fit: cover;
        display: block;
        transition: transform 0.3s ease;
    }

    .collage-item:hover img {
        transform: scale(1.05);
    }

    @media (min-width: 640px) {
        .collage-item img {
            height: 220px;
        }
    }

    @media (min-width: 1024px) {
        .collage-item img {
            height: 250px;
        }
    }

    .collage-item.large {
        grid-column: span 1;
    }

    @media (min-width: 768px) {
        .collage-item.large {
            grid-column: span 2;
            grid-row: span 2;
        }

        .collage-item.large img {
            height: 100%;
            min-height: 400px;
        }
    }

    /* ===== VIDEO ===== */
    .team-video {
        text-align: center;
        margin-top: 2rem;
    }

    @media (min-width: 640px) {
        .team-video {
            margin-top: 3rem;
        }
    }

    .team-video video {
        margin-top: 1.5rem;
        width: 100%;
        max-width: 700px;
        border-radius: 16px;
        box-shadow: 0 8px 30px rgba(5, 56, 61, 0.15);
    }

    @media (min-width: 640px) {
        .team-video video {
            margin-top: 2rem;
            max-width: 900px;
        }
    }

    /* ===== UTILITIES ===== */
    .hover-underline-animation {
        display: inline-block;
        position: relative;
    }

    .hover-underline-animation::after {
        content: '';
        position: absolute;
        width: 100%;
        transform: scaleX(0);
        height: 3px;
        bottom: -2px;
        left: 0;
        background: var(--gradient-secondary);
        border-radius: 2px;
        transition: transform 0.3s ease-out;
    }

    .hover-underline-animation:hover::after {
        transform: scaleX(1);
    }

    .hover-underline-animation.left::after {
        transform-origin: bottom right;
    }

    .hover-underline-animation.left:hover::after {
        transform-origin: bottom left;
    }

    .highlight-blue {
        color: var(--aquamarine);
        font-weight: 600;
    }

    /* ===== INFOS LIST ===== */
    .infos-list {
        list-style: none;
        padding: 0;
    }

    .infos-list li {
        display: flex;
        align-items: center;
        gap: 0.75rem;
        color: var(--text-primary);
        margin-bottom: 1rem;
        font-size: 0.95rem;
        padding: 0.75rem;
        background: rgba(5, 56, 61, 0.03);
        border-radius: 8px;
        transition: all 0.3s ease;
    }

    .infos-list li:hover {
        background: rgba(5, 56, 61, 0.06);
        transform: translateX(4px);
    }

    @media (min-width: 640px) {
        .infos-list li {
            font-size: 1rem;
            padding: 1rem;
        }
    }

    .infos-list .material-symbols-outlined {
        color: var(--orangish);
        font-size: 1.5rem;
    }

    .sidebar-infos {
        background: white;
        padding: 1.5rem;
        border-radius: 16px;
        box-shadow: 0 4px 20px rgba(5, 56, 61, 0.08);
        border: 1px solid rgba(5, 56, 61, 0.05);
    }

    @media (min-width: 640px) {
        .sidebar-infos {
            padding: 2rem;
        }
    }

    .sidebar-infos ul {
        list-style: none;
        padding: 0;
    }

    .sidebar-infos li {
        margin: 0.75rem 0;
    }

    /* ===== RESPONSIVE ADJUSTMENTS ===== */
    @media (max-width: 767px) {
        .content-wrapper {
            padding: 1.5rem 1rem;
        }

        section {
            margin-bottom: 2.5rem;
            padding-bottom: 1.5rem;
        }

        h2 {
            font-size: 1.5rem;
            margin-bottom: 1.25rem;
        }
    }

    /* ===== LOADING STATES (optionnel) ===== */
    @keyframes shimmer {
        0% {
            background-position: -1000px 0;
        }
        100% {
            background-position: 1000px 0;
        }
    }

    .loading {
        animation: shimmer 2s infinite;
        background: linear-gradient(
            to right,
            #f6f7f8 0%,
            #edeef1 20%,
            #f6f7f8 40%,
            #f6f7f8 100%
        );
        background-size: 1000px 100%;
    }

    /* ===== PRINT STYLES ===== */
    @media print {
        .company-nav,
        .sidebar-container,
        .apply-btn,
        .contact-btn {
            display: none;
        }

        .main-content {
            width: 100%;
        }

        .company-banner {
            page-break-inside: avoid;
        }

        section {
            page-break-inside: avoid;
        }
    }

    /* ===== ANIMATIONS SUPPLÉMENTAIRES ===== */
    @keyframes fadeIn {
        from {
            opacity: 0;
            transform: translateY(20px);
        }
        to {
            opacity: 1;
            transform: translateY(0);
        }
    }

    .animate-fade-in {
        animation: fadeIn 0.6s ease-out forwards;
    }

    /* ===== ACCESSIBILITÉ ===== */
    @media (prefers-reduced-motion: reduce) {
        *,
        *::before,
        *::after {
            animation-duration: 0.01ms !important;
            animation-iteration-count: 1 !important;
            transition-duration: 0.01ms !important;
        }
    }

    /* ===== EXTRA SMALL DEVICES ===== */
    @media (max-width: 360px) {
        .company-logo {
            width: 70px;
            height: 70px;
            transform: translateY(40px);
        }

        .company-logo:hover {
            transform: translateY(36px) scale(1.02);
        }

        .company-info h1 {
            font-size: 1rem;
        }

        .company-info .details p {
            font-size: 0.65rem;
            padding: 0.4rem 0.5rem;
        }

        h2 {
            font-size: 1.35rem;
        }

        .sidebar-title {
            font-size: 1.1rem;
        }
    }

    /* ===== TABLET LANDSCAPE ===== */
    @media (min-width: 768px) and (max-width: 1023px) {
        .content-wrapper {
            gap: 2.5rem;
        }

        .sidebar-container {
            width: 320px;
        }

        .benefits-grid {
            grid-template-columns: repeat(2, 1fr);
        }

        .team-grid {
            grid-template-columns: repeat(2, 1fr);
        }
    }

    /* ===== LARGE SCREENS ===== */
    @media (min-width: 1400px) {
        .content-wrapper {
            max-width: 1600px;
            padding: 5rem 4rem;
        }

        .company-banner {
            max-height: 500px;
        }

        h2 {
            font-size: 2.75rem;
        }

        .sidebar-container {
            width: 420px;
        }
    }

    /* ===== TOOLTIPS (si nécessaire) ===== */
    [data-tooltip] {
        position: relative;
        cursor: help;
    }

    [data-tooltip]::after {
        content: attr(data-tooltip);
        position: absolute;
        bottom: 100%;
        left: 50%;
        transform: translateX(-50%);
        padding: 0.5rem 0.75rem;
        background: var(--indigo);
        color: white;
        border-radius: 8px;
        font-size: 0.85rem;
        white-space: nowrap;
        opacity: 0;
        pointer-events: none;
        transition: opacity 0.3s ease;
        margin-bottom: 0.5rem;
    }

    [data-tooltip]:hover::after {
        opacity: 1;
    }

    /* ===== BADGES & TAGS ===== */
    .badge {
        display: inline-block;
        padding: 0.35rem 0.75rem;
        border-radius: 20px;
        font-size: 0.8rem;
        font-weight: 600;
        background: var(--wondrous-blue);
        color: var(--indigo);
    }

    .badge.primary {
        background: var(--gradient-primary);
        color: white;
    }

    .badge.secondary {
        background: var(--gradient-secondary);
        color: white;
    }

    /* ===== DIVIDERS ===== */
    .divider {
        height: 1px;
        background: linear-gradient(
            to right,
            transparent,
            rgba(5, 56, 61, 0.1),
            transparent
        );
        margin: 2rem 0;
    }

    @media (min-width: 640px) {
        .divider {
            margin: 3rem 0;
        }
    }

    /* ===== STATS CARDS (si vous en avez) ===== */
    .stats-grid {
        display: grid;
        grid-template-columns: 1fr;
        gap: 1rem;
        margin: 2rem 0;
    }

    @media (min-width: 640px) {
        .stats-grid {
            grid-template-columns: repeat(2, 1fr);
            gap: 1.5rem;
        }
    }

    @media (min-width: 1024px) {
        .stats-grid {
            grid-template-columns: repeat(4, 1fr);
            gap: 2rem;
        }
    }

    .stat-card {
        background: white;
        padding: 2rem;
        border-radius: 16px;
        text-align: center;
        box-shadow: 0 4px 20px rgba(5, 56, 61, 0.08);
        border: 1px solid rgba(5, 56, 61, 0.05);
        transition: all 0.3s ease;
    }

    .stat-card:hover {
        transform: translateY(-4px);
        box-shadow: 0 8px 30px rgba(5, 56, 61, 0.12);
    }

    .stat-card .stat-number {
        font-size: 2.5rem;
        font-weight: 700;
        color: var(--indigo);
        margin-bottom: 0.5rem;
        background: var(--gradient-primary);
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
        background-clip: text;
    }

    .stat-card .stat-label {
        font-size: 0.95rem;
        color: var(--text-secondary);
        text-transform: uppercase;
        letter-spacing: 0.5px;
    }

    /* ===== ALERT / NOTIFICATION STYLES ===== */
    .alert {
        padding: 1rem 1.5rem;
        border-radius: 12px;
        margin: 1rem 0;
        display: flex;
        align-items: center;
        gap: 0.75rem;
        border-left: 4px solid;
    }

    .alert.info {
        background: rgba(56, 118, 124, 0.1);
        border-color: var(--aquamarine);
        color: var(--indigo);
    }

    .alert.success {
        background: rgba(34, 197, 94, 0.1);
        border-color: #22c55e;
        color: #166534;
    }

    .alert.warning {
        background: rgba(249, 137, 72, 0.1);
        border-color: var(--orangish);
        color: #9a3412;
    }

    .alert.error {
        background: rgba(239, 68, 68, 0.1);
        border-color: #ef4444;
        color: #991b1b;
    }

    /* ===== SKELETON LOADERS ===== */
    .skeleton {
        background: linear-gradient(
            90deg,
            #f0f0f0 25%,
            #e0e0e0 50%,
            #f0f0f0 75%
        );
        background-size: 200% 100%;
        animation: loading 1.5s infinite;
        border-radius: 8px;
    }

    @keyframes loading {
        0% {
            background-position: 200% 0;
        }
        100% {
            background-position: -200% 0;
        }
    }

    .skeleton-text {
        height: 1rem;
        margin-bottom: 0.5rem;
    }

    .skeleton-title {
        height: 2rem;
        width: 60%;
        margin-bottom: 1rem;
    }

    .skeleton-card {
        height: 200px;
    }

    /* ===== EMPTY STATES ===== */
    .empty-state {
        text-align: center;
        padding: 4rem 2rem;
        color: var(--text-secondary);
    }

    .empty-state-icon {
        font-size: 4rem;
        color: var(--wondrous-blue);
        margin-bottom: 1rem;
    }

    .empty-state h3 {
        font-size: 1.5rem;
        color: var(--indigo);
        margin-bottom: 0.5rem;
    }

    .empty-state p {
        font-size: 1rem;
        max-width: 400px;
        margin: 0 auto;
    }

    /* ===== SCROLL TO TOP BUTTON (optionnel) ===== */
    .scroll-to-top {
        position: fixed;
        bottom: 2rem;
        right: 2rem;
        width: 50px;
        height: 50px;
        background: var(--gradient-secondary);
        color: white;
        border: none;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        cursor: pointer;
        opacity: 0;
        visibility: hidden;
        transition: all 0.3s ease;
        box-shadow: 0 4px 12px rgba(249, 137, 72, 0.3);
        z-index: 1000;
    }

    .scroll-to-top.visible {
        opacity: 1;
        visibility: visible;
    }

    .scroll-to-top:hover {
        transform: translateY(-4px);
        box-shadow: 0 6px 20px rgba(249, 137, 72, 0.4);
    }

    /* ===== AMÉLIORATION DES PERFORMANCES ===== */
    .gpu-accelerated {
        transform: translateZ(0);
        will-change: transform;
    }

    /* ===== CORRECTIONS FINALES ===== */
    * {
        box-sizing: border-box;
    }

    img {
        max-width: 100%;
        height: auto;
    }

    button {
        cursor: pointer;
        font-family: inherit;
    }

    a {
        color: inherit;
        text-decoration: none;
    }

    /* ===== CONTAINER UTILITIES ===== */
    .container {
        width: 100%;
        max-width: 1400px;
        margin: 0 auto;
        padding: 0 1rem;
    }

    @media (min-width: 640px) {
        .container {
            padding: 0 2rem;
        }
    }

    @media (min-width: 1024px) {
        .container {
            padding: 0 3rem;
        }
    }

</style>
