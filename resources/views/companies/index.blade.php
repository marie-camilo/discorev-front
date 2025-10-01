@extends('layouts.app')

@section('title', 'Entreprises | Discorev')

@section('content')
    <div class="container py-4">
        <h1 class="fw-bold mb-4 gradient-text">Entreprises</h1>
        <form id="recruiter-filters" method="GET" action="{{ route('companies.index') }}" class="mb-4">
            <div class="row align-items-end gy-3">
                <div class="col-md-4">
                    <label for="location" class="form-label">Localisation</label>
                    <input type="text" name="location" id="location" class="form-control"
                        value="{{ request('location') }}" placeholder="Ex: Paris">
                </div>

                <div class="col-md-4">
                    <label for="sector" class="form-label">Secteur</label>
                    <select name="sector" id="sector" class="form-select">
                        <option value="">Tous les secteurs</option>
                        <option value="social" @selected(request('sector') === 'social')>Social</option>
                        <option value="éducation" @selected(request('sector') === 'éducation')>Éducation</option>
                        <option value="santé" @selected(request('sector') === 'santé')>Santé</option>
                        <!-- Ajoute plus de secteurs ici -->
                    </select>
                </div>

                <div class="col-md-4">
                    <label for="team_size" class="form-label">Taille de l'équipe</label>
                    <select name="team_size" id="team_size" class="form-select">
                        <option value="">Toutes tailles</option>
                        <option value="1-10" @selected(request('team_size') === '1-10')>1 à 10</option>
                        <option value="11-50" @selected(request('team_size') === '11-50')>11 à 50</option>
                        <option value="51-200" @selected(request('team_size') === '51-200')>51 à 200</option>
                        <option value="200+" @selected(request('team_size') === '200+')>200+</option>
                    </select>
                </div>

                <div class="col-12 text-end mt-3">
                    <button type="submit" class="btn btn-secondary">
                        <i class="fas fa-filter me-2"></i>Filtrer
                    </button>
                </div>
            </div>
        </form>

        <div class="row gy-4 min-vh-100">
            @forelse ($recruiters as $recruiter)
                <div class="col-12 col-md-6 col-lg-4">
                    <a class="text-decoration-none"
                        href="{{ route('companies.show', $recruiter->companyName ? $recruiter->companyName : $recruiter->id) }}"
                        alt="Vers la page entreprise de {{ $recruiter->companyName }}"
                        title="Vers la page entreprise de {{ $recruiter->companyName }}">
                        <div class="card shadow border-0 h-100 recruiter-card d-flex flex-column align-items-center text-center"
                            style="transition: transform 0.3s ease, box-shadow 0.3s ease;">
                            <div class="position-relative mb-3">
                                @if ($recruiter->banner)
                                    <img class="card-img-top" src="{{ env('DISCOREV_API_URL') . '/' . $recruiter->banner }}"
                                        alt="Bannière de {{ $recruiter->companyName }}" />
                                @endif
                                <span
                                    class="rounded-circle p-2 bg-white fs-5 position-absolute top-50 end-0 translate-middle-y">
                                    +{{ $recruiter->offersCount ?? 0 }}
                                </span>
                            </div>

                            @php
                                $logoUrl = $recruiter->logo
                                    ? env('DISCOREV_API_URL') . '/' . $recruiter->logo
                                    : asset('img/default-avatar.png');
                            @endphp

                            <div class="card-body">
                                <div class="row mb-3">
                                    <div class="col-4" style="overflow: hidden;">
                                        <img class="shadow-sm rounded-1" src="{{ $logoUrl }}"
                                            alt="Logo {{ $recruiter->companyName }}"
                                            style="width: 100%; height: 100%; object-fit: cover; object-position: center;" />
                                    </div>

                                    <div class="col-8 text-start text-dark">
                                        <h5 class="fw-bold mb-2">{{ $recruiter->companyName }}
                                        </h5>
                                        <span class="mb-2">{{ $recruiter->sector }}</span><br>
                                        <small>{{ $recruiter->location }}</small>
                                    </div>
                                </div>
                                <div class="d-flex align-items-center justify-content-between mb-4">
                                    <div
                                        class="badge rounded-pill shadow-sm bg-primary d-flex align-items-center justify-content-between me-2">
                                        <span class="material-symbols-outlined text-white">
                                            captive_portal
                                        </span>
                                        <a class="text-decoration-none text-white" href="{{ $recruiter->website }}">Site
                                            web</a>
                                    </div>
                                    <div class="text-start">
                                        <small>E-mail: <a
                                                href="mailto:{{ $recruiter->contactPerson }}">{{ $recruiter->contactPerson }}</a></small>
                                        <small>Téléphone: <a
                                                href="tel:{{ $recruiter->phone }}">{{ $recruiter->phone }}</a></small>
                                    </div>

                                </div>

                                <p class="text-muted small mb-3" style="flex-grow: 1;">
                                    {{ Str::limit($recruiter->companyDescription, 90) }}
                                </p>
                            </div>
                        </div>
                    </a>
                </div>
            @empty
                <div class="col-12 text-center">
                    <p>Aucune entreprise ne correspond à vos filtres.</p>
                </div>
            @endforelse
        </div>

        <style>
            .recruiter-card:hover {
                transform: translateY(-6px);
                box-shadow: 0 8px 20px rgb(0 0 0 / 0.15);
            }
        </style>

    </div>
@endsection
