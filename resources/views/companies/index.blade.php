@extends('layouts.app')

@section('title', 'Entreprises | Discorev')

@section('content')
    <div class="container py-4">
        <h1 class="fw-bold mb-4 mt-5 gradient-text">Entreprises</h1>


        {{-- Formulaire de filtres --}}
        <form id="recruiter-filters" method="GET" action="{{ route('companies.index') }}" class="filter-form">
            <div class="filter-container">
                <div class="filter-group">
                    <label for="location" class="filter-label">
                        <span class="material-symbols-outlined">location_on</span>
                        Localisation
                    </label>
                    <input type="text" name="location" id="location" class="filter-input"
                           value="{{ request('location') }}" placeholder="Ex: Paris">
                </div>

                <div class="filter-group">
                    <label for="sector" class="filter-label">
                        <span class="material-symbols-outlined">business_center</span>
                        Secteur
                    </label>
                    <select name="sector" id="sector" class="filter-select">
                        <option value="">Tous les secteurs</option>
                        <option value="social" @selected(request('sector') === 'social')>Social</option>
                        <option value="éducation" @selected(request('sector') === 'éducation')>Éducation</option>
                        <option value="santé" @selected(request('sector') === 'santé')>Santé</option>
                    </select>
                </div>

                <div class="filter-group">
                    <label for="team_size" class="filter-label">
                        <span class="material-symbols-outlined">group</span>
                        Taille de l'équipe
                    </label>
                    <select name="team_size" id="team_size" class="filter-select">
                        <option value="">Toutes tailles</option>
                        <option value="1-10" @selected(request('team_size') === '1-10')>1 à 10</option>
                        <option value="11-50" @selected(request('team_size') === '11-50')>11 à 50</option>
                        <option value="51-200" @selected(request('team_size') === '51-200')>51 à 200</option>
                        <option value="200+" @selected(request('team_size') === '200+')>200+</option>
                    </select>
                </div>

                <button type="submit" class="filter-btn">
                    <span class="material-symbols-outlined">tune</span>
                    Filtrer
                </button>
            </div>
        </form>

        <style>
            .filter-form {
                margin-bottom: 2rem;
            }

            .filter-container {
                display: grid;
                grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
                gap: 1.5rem;
                align-items: flex-end;
                background: linear-gradient(135deg, #ffffff 0%, #f8f9fa 100%);
                padding: 2rem;
                border-radius: 16px;
                box-shadow: 0 4px 20px rgba(0, 0, 0, 0.08);
            }

            .filter-group {
                display: flex;
                flex-direction: column;
                gap: 0.75rem;
            }

            .filter-label {
                font-size: 0.95rem;
                font-weight: 600;
                color: #1a202c;
                display: flex;
                align-items: center;
                gap: 0.5rem;
                cursor: pointer;
                margin: 0;
            }

            .filter-label .material-symbols-outlined {
                font-size: 20px;
                color: var(--indigo);
            }

            .filter-input,
            .filter-select {
                padding: 0.75rem 1rem;
                border: 2px solid #e2e8f0;
                border-radius: 10px;
                font-size: 0.95rem;
                color: #1a202c;
                background: #ffffff;
                transition: all 0.3s ease;
                font-family: inherit;
            }

            .filter-input::placeholder {
                color: #a0aec0;
            }

            .filter-input:focus,
            .filter-select:focus {
                outline: none;
                border-color: var(--indigo);
                box-shadow: 0 0 0 3px rgba(102, 126, 234, 0.1);
            }

            .filter-input:hover,
            .filter-select:hover {
                border-color: var(--indigo);
            }

            .filter-select {
                cursor: pointer;
                appearance: none;
                background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='12' height='12' viewBox='0 0 12 12'%3E%3Cpath fill='%23083838' d='M6 9L1 4h10z'/%3E%3C/svg%3E");
                background-repeat: no-repeat;
                background-position: right 1rem center;
                padding-right: 2.5rem;
            }

            .filter-btn {
                display: flex;
                align-items: center;
                justify-content: center;
                gap: 0.5rem;
                padding: 0.75rem 1.5rem;
                background: linear-gradient(135deg, var(--indigo), var(--aquamarine));
                color: var(--sand);
                border: none;
                border-radius: 10px;
                font-size: 0.95rem;
                font-weight: 600;
                cursor: pointer;
                transition: all 0.3s ease;
                width: 100%;
            }

            .filter-btn:hover {
                transform: translateY(-2px);
                box-shadow: 0 10px 15px -3px rgba(8, 56, 61, 0.3);
                color: var(--sand);
            }

            .filter-btn .material-symbols-outlined {
                font-size: 20px;
            }

            @media (max-width: 768px) {
                .filter-container {
                    grid-template-columns: 1fr;
                    padding: 1.5rem;
                    gap: 1rem;
                }

                .filter-btn {
                    width: 100%;
                }
            }
        </style>

        {{-- Liste des entreprises --}}
        <div class="row gy-4">
            @forelse ($recruiters as $recruiter)
                <div class="col-12 col-md-6 col-lg-4">
                    <a href="{{ route('companies.show', $recruiter->id ?: $recruiter->companyName) }}"
                       class="text-decoration-none recruiter-link">
                        <div class="card border-0 recruiter-card">
                            <!-- Bannière -->
                            @if($recruiter->banner)
                                <div class="recruiter-banner">
                                    <img src="{{ config('app.api') . '/' . $recruiter->banner }}"
                                         alt="Bannière {{ $recruiter->companyName }}"
                                         class="w-100 h-100"
                                         style="object-fit: cover;">
                                </div>
                            @else
                                <div class="recruiter-banner-empty"></div>
                            @endif

                            <!-- Logo centré -->
                            @php
                                $logoUrl = $recruiter->logo ? config('app.api') . '/' . $recruiter->logo : asset('img/default-avatar.png');
                            @endphp
                            <div class="recruiter-logo-container">
                                <img src="{{ $logoUrl }}"
                                     alt="Logo {{ $recruiter->companyName }}"
                                     class="recruiter-logo">
                            </div>

                            <!-- Corps de la carte -->
                            <div class="card-body text-center py-3 px-4 flex-grow-1 d-flex flex-column">
                                <h5 class="recruiter-title">{{ $recruiter->companyName }}</h5>
                                <p class="recruiter-sector">{{ $recruiter->sectorName ?? $recruiter->sector }}</p>
                                <p class="recruiter-location">
                                    <span class="material-symbols-outlined">location_on</span>
                                    {{ $recruiter->location }}
                                </p>

                                <!-- Description -->
                                @if($recruiter->companyDescription)
                                    <p class="recruiter-description">{{ $recruiter->companyDescription }}</p>
                                @endif

                                <!-- Badges -->
                                <div class="recruiter-badges">
                                    @if($recruiter->website)
                                        <a href="{{ $recruiter->website }}"
                                           class="recruiter-btn btn-primary-gradient"
                                           onclick="event.stopPropagation();">
                                            <span class="material-symbols-outlined">public</span>
                                            Site web
                                        </a>
                                    @endif
                                    <div class="recruiter-btn btn-highlight">
                                        <span class="material-symbols-outlined">work</span>
                                        {{ $recruiter->offersCount ?? 0 }} offres
                                    </div>
                                </div>

                                <!-- Contact -->
                                <div class="recruiter-contact">
                                    @if($recruiter->contactPerson)
                                        <div>
                                            <a href="mailto:{{ $recruiter->contactPerson }}">{{ $recruiter->contactPerson }}</a>
                                        </div>
                                    @endif
                                    @if($recruiter->phone)
                                        <div>
                                            <a href="tel:{{ $recruiter->phone }}">{{ $recruiter->phone }}</a>
                                        </div>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </a>
                </div>
            @empty
                <div class="col-12 text-center py-5">
                    <div class="recruiter-empty">
                        <span class="material-symbols-outlined">search_off</span>
                        <p>Aucune entreprise ne correspond à vos filtres.</p>
                    </div>
                </div>
            @endforelse
        </div>
    </div>

    <style>
        .recruiter-card {
            background: linear-gradient(135deg, #ffffff 0%, #f8f9fa 100%);
            border-radius: 16px;
            overflow: hidden;
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.08);
            position: relative;
            height: 100%;
            display: flex;
            flex-direction: column;
        }

        .recruiter-banner {
            height: 120px;
            overflow: hidden;
        }

        .recruiter-banner-empty {
            height: 120px;
            background: #d4d4d8;
        }

        .recruiter-logo-container {
            display: flex;
            justify-content: center;
            margin-top: -35px;
            position: relative;
            z-index: 10;
        }

        .recruiter-logo {
            width: 80px;
            height: 80px;
            object-fit: cover;
            border: 4px solid #fff;
            border-radius: 50%;
            box-shadow: 0 8px 24px rgba(46, 47, 51, 0.25);
            transition: transform 0.3s ease;
        }

        .recruiter-title {
            font-size: 1.25rem;
            color: #1a202c;
            letter-spacing: -0.5px;
            margin-bottom: 0.5rem;
            font-weight: 700;
        }

        .recruiter-sector {
            color: var(--indigo);
            font-weight: 600;
            font-size: 0.95rem;
            margin-bottom: 0.5rem;
        }

        .recruiter-location {
            color: #718096;
            font-size: 0.9rem;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 4px;
            margin-bottom: 1rem;
        }

        .recruiter-location .material-symbols-outlined {
            font-size: 18px;
        }

        .recruiter-description {
            color: #4a5568;
            font-size: 0.9rem;
            line-height: 1.5;
            margin-bottom: 1rem;
            display: -webkit-box;
            -webkit-line-clamp: 2;
            -webkit-box-orient: vertical;
            overflow: hidden;
            flex-grow: 1;
        }

        .recruiter-badges {
            display: flex;
            justify-content: center;
            gap: 0.5rem;
            margin-bottom: 1rem;
            flex-wrap: wrap;
        }

        .recruiter-btn {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            padding: 6px 12px;
            border-radius: 20px;
            font-size: 0.85rem;
            font-weight: 600;
            text-decoration: none;
            border: none;
            cursor: pointer;
            transition: all 0.3s ease;
        }

        .recruiter-btn .material-symbols-outlined {
            font-size: 16px;
        }

        .btn-primary-gradient {
            background: linear-gradient(135deg, var(--indigo), var(--aquamarine));
            color: var(--sand);
        }

        .btn-primary-gradient:hover {
            transform: translateY(-2px);
            box-shadow: 0 10px 15px -3px rgba(8, 56, 61, 0.3);
            color: var(--sand);
        }

        .btn-highlight {
            background: linear-gradient(135deg, var(--orangish), var(--larch-bolete));
            color: var(--sand);
        }

        .btn-highlight:hover {
            transform: translateY(-2px);
            box-shadow: 0 10px 15px -3px rgba(249, 137, 72, 0.3);
            color: var(--sand);
        }

        .recruiter-contact {
            border-top: 1px solid #e2e8f0;
            padding-top: 12px;
            color: #718096;
            font-size: 0.85rem;
        }

        .recruiter-contact a {
            color: var(--indigo);
            text-decoration: none;
            transition: color 0.3s ease;
        }

        .recruiter-contact a:hover {
            color: #1a202c;
        }

        .recruiter-empty {
            padding: 40px 20px;
            background: linear-gradient(135deg, #f7fafc 0%, #edf2f7 100%);
            border-radius: 12px;
            color: #4a5568;
        }

        .recruiter-empty .material-symbols-outlined {
            font-size: 48px;
            display: block;
            margin-bottom: 12px;
            color: #cbd5e0;
        }

        .recruiter-empty p {
            font-size: 1.1rem;
            font-weight: 600;
            margin: 0;
        }

        .recruiter-card:hover {
            transform: translateY(-6px);
            box-shadow: 0 8px 20px rgba(0, 0, 0, 0.12);
        }

        .recruiter-card:hover .recruiter-logo {
            transform: scale(1.05);
        }

        .recruiter-link:hover {
            color: inherit;
        }
    </style>
@endsection
