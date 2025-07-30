@extends('layouts.app')

@section('title', $recruiter['companyName'])

@section('content')

    <!-- Bandeau Entreprise -->
    <div class="company-banner">
        <img src="{{ asset('img/lpj-banner.jpg') }}" alt="Bandeau entreprise" />
        <div class="overlay"></div>

        <div class="company-header">
            <div class="company-logo">
                @if (!empty($recruiter['website']))
                    <a href="{{ $recruiter['website'] }}" target="_blank" rel="noopener noreferrer">
                        <img src="{{ asset($recruiter['companyLogo']) }}" alt="Logo de l'entreprise" />
                    </a>
                @else
                    <img src="{{ asset($recruiter['companyLogo']) }}" alt="Logo de l'entreprise" />
                @endif
            </div>
            <div class="company-info">
                <h1>{{ $recruiter['companyName'] }}</h1>
                <p><i class="fa-solid fa-briefcase"></i> Secteur : {{ $recruiter['sector'] }}</p>
                <p><i class="fa-solid fa-map-pin"></i> Localisation : {{ $recruiter['location'] }}</p>
                <p><i class="fa-solid fa-users"></i> Taille de l'équipe : {{ $recruiter['teamSize'] }}</p>
            </div>
        </div>
    </div>

    <!-- Conteneur principal -->
    <div class="container content-wrapper" role="main"
        aria-label="Présentation de l'entreprise {{ $recruiter['companyName'] }}">
        <div class="main-content">

            {{-- Navigation locale --}}
            <nav class="company-nav" aria-label="Navigation section entreprise">
                <ul>
                    <li><a class="hover-underline-animation left" href="#company">L'entreprise</a></li>
                    <li><a class="hover-underline-animation left" href="#equipe">L'équipe</a></li>
                    <li><a class="hover-underline-animation left" href="#medias">Médias</a></li>
                    <li><a class="hover-underline-animation left" href="#rejoindre">Pourquoi nous rejoindre ?</a></li>
                </ul>
            </nav>

            {{-- Section entreprise --}}
            <section id="company" tabindex="-1">
                <h2>L'entreprise</h2>
                <p>{{ $recruiter['companyDescription'] }}</p>
            </section>

            {{-- Équipe --}}
            <section id="equipe" tabindex="-1">
                <h2>L'équipe</h2>
                <p>{{ $recruiter['contactPerson'] }}</p>
            </section>

            {{-- Pourquoi nous rejoindre --}}
            <section id="rejoindre" tabindex="-1">
                <h2>Pourquoi nous rejoindre ?</h2>
                {{-- Ajoutez ici des avantages dynamiques si disponibles dans la table --}}
            </section>

            {{-- Médias --}}
            <section id="medias" tabindex="-1">
                <h2>Médias</h2>
                {{-- Ajoutez ici une galerie dynamique si vous stockez des médias --}}
            </section>

        </div>

        {{-- Sidebar --}}
        <aside class="sidebar-container" aria-label="Informations complémentaires">

            <!-- Section Infos Entreprise -->
            <section class="sidebar-infos" aria-labelledby="sidebar-infos-title">
                <h3 id="sidebar-infos-title" class="sidebar-title">À propos</h3>
                <ul class="infos-list">
                    @if (!empty($recruiter['website']))
                        <li><span class="material-symbols-outlined">public</span> <span>{{ $recruiter['website'] }}</span>
                        </li>
                    @endif
                    <li><span class="material-symbols-outlined">home</span> <span>{{ $recruiter['location'] }}</span></li>
                    @if (!empty($recruiter['siret']))
                        <li><span class="material-symbols-outlined">badge</span> <span>SIRET :
                                {{ $recruiter['siret'] }}</span></li>
                    @endif
                </ul>
                <a href="#" class="contact-btn">Contacter l'entreprise</a>
            </section>

            <!-- Section Offres -->
            {{-- À adapter si vous avez des offres liées au recruiter --}}
        </aside>

    </div>

@endsection
