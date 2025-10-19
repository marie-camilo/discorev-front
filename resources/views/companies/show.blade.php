@extends('layouts.app')

@section('title', $recruiter->companyName ? $recruiter->companyName : 'Entreprise' . ' | Discorev')

@section('content')

    <div class="company-banner">
        @if ($recruiter->banner)
            <img src="{{ config('app.api') . '/' . $recruiter->banner }}" alt="Bandeau entreprise" />
            <div class="overlay"></div>
        @else
            <div></div>
            <div class="overlay" style="background-color: #9f9f9f;"></div>
        @endif

        <div class="company-header">
            <div class="company-logo">
                @if (!empty($recruiter->website))
                    <a href="{{ $recruiter->website }}" target="_blank" rel="noopener noreferrer">
                        <img src="{{ $recruiter->logo ? config('app.api') . '/' . $recruiter->logo : '' }}" alt="Logo de l'entreprise" />
                    </a>
                @else
                    <img src="{{ $recruiter->logo ? config('app.api') . '/' . $recruiter->logo : '' }}" alt="Logo de l'entreprise" />
                @endif
            </div>
            <div class="company-info">
                <div class="d-flex align-items-center">
                    <h1 style="color: white">{{ $recruiter->companyName }}</h1>
                </div>
                <p><span class="material-symbols-outlined text-white">business_center</span> Secteur :
                    {{ $recruiter->sectorName ?? $recruiter->sector }}</p>
                <p><span class="material-symbols-outlined text-white">location_on</span> Localisation :
                    {{ $recruiter->location }}</p>
                <p><span class="material-symbols-outlined text-white">groups</span> Taille de l'équipe :
                    {{ $recruiter->teamSize }}</p>
            </div>
        </div>
    </div>

    <div class="container content-wrapper" role="main"
        aria-label="Présentation de l'entreprise {{ $recruiter->companyName }}">
        <div class="main-content">

            {{-- Navigation locale dynamique --}}
            @if (count($sections) > 0)
                <nav class="company-nav" aria-label="Navigation section entreprise">
                    <ul>
                        @foreach ($sections as $section)
                            <li>
                                <a class="hover-underline-animation left"
                                    href="#{{ $section['anchor'] }}">{{ $section['label'] }}</a>
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
                        <p>{{ $recruiter->{$section['key']} }}</p>
                    @elseif ($section['type'] === 'array' && $section['key'] === 'teamMembers')
                        <p>Découvrez <strong>l'équipe</strong> de la société
                            <strong>{{ $recruiter->companyName }}</strong>.
                        </p>
                        <div class="row">
                            @foreach ($recruiter->teamMembers as $member)
                                <article class="col-12 col-md-4 team-member" role="listitem">
                                    <img src="{{ asset('img/default-avatar.png') }}" alt="{{ $member->name }}" />
                                    <h3>{{ $member->name }}</h3>
                                    <p><strong>{{ $member->role }}</strong></p>
                                    <p>{{ $member->email }}</p>
                                </article>
                            @endforeach
                        </div>
                    @elseif ($section['type'] === 'media')
                        <div class="row">
                            @foreach ($recruiter->medias as $media)
                                @if ($media->type === 'company_image' && $media->context === 'company_page')
                                    <div class="col">
                                        <img class="rounded" src="{{ config('app.api') . '/' . $media->filePath }}"
                                            alt="{{ $media->title }}">
                                    </div>
                                @endif
                            @endforeach
                        </div>
                    @endif
                </section>
            @endforeach
        </div>

        {{-- Sidebar --}}
        <aside class="sidebar-container" aria-label="Informations complémentaires">
            <section class="sidebar-infos" aria-labelledby="sidebar-infos-title">
                <h3 id="sidebar-infos-title" class="sidebar-title">À propos</h3>
                <ul class="infos-list">
                    @if (!empty($recruiter['contactEmail']))
                        <li><span class="material-symbols-outlined">alternate_email
                            </span><a class="text-decoration-none text-dark" href="mailto:{{ $recruiter['contactEmail'] }}"
                                target="_blank"><span>
                                    {{ $recruiter['contactEmail'] }}</span></a>
                        </li>
                    @endif
                    @if (!empty($recruiter['contactPhone']))
                        <li><span class="material-symbols-outlined">call
                            </span><a class="text-decoration-none text-dark" href="tel:{{ $recruiter['contactPhone'] }}"
                                target="_blank"><span>
                                    {{ $recruiter['contactPhone'] }}</span></a>
                        </li>
                    @endif
                    @if (!empty($recruiter->website))
                        <li><span class="material-symbols-outlined">public</span><a class="text-decoration-none text-dark"
                                href="{{ $recruiter->website }}" target="_blank"><span>
                                    {{ $recruiter->website }}</span></a>
                        </li>
                    @endif
                    @if (!empty($recruiter->location))
                        <li><span class="material-symbols-outlined">home</span> <span>{{ $recruiter->location }}</span>
                        </li>
                    @endif
                    @if (!empty($recruiter->siret))
                        <li><span class="material-symbols-outlined">badge</span> <span>SIRET :
                                {{ $recruiter->siret }}</span></li>
                    @endif
                </ul>
                <a href="#" class="contact-btn">Contacter l'entreprise</a>
            </section>

            <section class="sidebar-offers" aria-labelledby="sidebar-offers-title">
                <h3 id="sidebar-offers-title" class="sidebar-title">Dernières offres</h3>
                <ul class="job-list">
                    @foreach ($recruiter->jobOffers as $jobs)
                        <li class="job-card">
                            <h4>{{ $jobs->title }}</h4>
                            <p><i class="material-symbols-outlined me-2">location_on</i>{{ $jobs->location }}</p>
                            <p class="text-uppercase"><i
                                    class="material-symbols-outlined me-2">contract</i>{{ $jobs->employmentType }}</p>
                            <p><i class="material-symbols-outlined me-2">calendar_today</i>Publiée le
                                {{ $jobs->formattedPublicationDate }}
                            </p>
                            <a href="{{ route('job_offers.show', $jobs->id) }}" class="apply-btn">Postuler</a>
                        </li>
                    @endforeach
                </ul>
                <a href="{{ route('job_offers.index') }}" class="cta-button-transparent"><span
                        class="material-symbols-outlined">arrow_right</span> Voir toutes les
                    offres</a>
            </section>
        </aside>
    </div>

@endsection
