@extends('layouts.app')

@section('title', $offer->title . ' | Discorev')

@section('content')
    @php
        use Carbon\Carbon;
        $publicationDate = Carbon::parse($offer->publicationDate);
        $daysAgo = $publicationDate->diffForHumans(); // ex: "il y a 5 jours"
    @endphp

    <div class="container py-5">
        <!-- HEADER DE L'OFFRE -->
        <div class="offer-header shadow-sm rounded-4 p-4 mb-5">
            <div class="d-flex flex-column flex-md-row align-items-md-center justify-content-between gap-4">

                <!-- Logo + Nom entreprise -->
                <div class="d-flex align-items-center gap-3 flex-wrap">
                    <div class="company-logo">
                        @if (!empty($recruiter->website))
                            <a href="{{ $recruiter->website }}" target="_blank" rel="noopener noreferrer">
                                <img src="{{ $recruiter->logo ? config('app.api') . '/' . $recruiter->logo : asset('img/default-company.png') }}"
                                     alt="Logo {{ $recruiter->companyName }}"
                                     class="offer-logo rounded-circle shadow-sm">
                            </a>
                        @else
                            <img src="{{ $recruiter->logo ? config('app.api') . '/' . $recruiter->logo : asset('img/default-company.png') }}"
                                 alt="Logo {{ $recruiter->companyName }}"
                                 class="offer-logo rounded-circle shadow-sm">
                        @endif
                    </div>

                    <div>
                        <h2 class="mb-1 fw-bold gradient-text">{{ $offer->title }}</h2>
                        <a href="{{ route('companies.show', ['identifier' => $recruiter->id]) }}"
                           class="company-link fw-semibold">
                            {{ $recruiter->companyName }}
                        </a>
                        <p class="text-muted small mb-0">Publiée {{ $daysAgo }}</p>
                    </div>
                </div>

                <!-- Informations principales -->
                <div class="offer-meta d-flex flex-wrap gap-2 justify-content-md-end">
                <span class="badge-custom">
                    <span class="material-symbols-outlined">work</span>
                    {{ strtoupper($offer->employmentType) }}
                </span>

                    <span class="badge-custom">
                    <span class="material-symbols-outlined">location_on</span>
                    {{ $offer->location }}
                </span>

                    @if($offer->startDate && $offer->endDate)
                        <span class="badge-custom">
                        <span class="material-symbols-outlined">calendar_month</span>
                        {{ \Carbon\Carbon::parse($offer->startDate)->format('d/m/Y') }} → {{ \Carbon\Carbon::parse($offer->endDate)->format('d/m/Y') }}
                    </span>
                    @endif

                    @if ($offer->status)
                        <span class="badge-custom {{ $offer->status === 'active' ? 'active' : 'inactive' }}">
                        <span class="material-symbols-outlined">fiber_manual_record</span>
                        {{ ucfirst($offer->status) }}
                    </span>
                    @endif

                    @if ($offer->salaryMin && $offer->salaryMax)
                        <span class="badge-custom salary">
                        <span class="material-symbols-outlined">euro</span>
                        {{ $offer->salaryMin }} - {{ $offer->salaryMax }} €/mois
                    </span>
                    @endif
                </div>
            </div>
        </div>

        <!-- CONTENU PRINCIPAL -->
        <div class="card shadow-sm rounded-4 p-4">
            <div class="card-body">
                <h4 class="section-title d-flex align-items-center mb-3">
                    <span class="material-symbols-outlined me-2 text-primary">description</span>
                    Description du poste
                </h4>
                <p class="card-text lh-lg">{{ $offer->description }}</p>

                <hr class="my-4">

                <h4 class="section-title d-flex align-items-center mb-3">
                    <span class="material-symbols-outlined me-2 text-info">rule</span>
                    Exigences du poste
                </h4>
                <p class="card-text lh-lg">
                    {{ $offer->requirements ?? 'Aucune exigence particulière pour ce poste.' }}
                </p>

                @if ($offer->remote)
                    <div class="mt-4">
                    <span class="badge-custom remote">
                        🏠 Télétravail possible
                    </span>
                    </div>
                @endif

                @if ($offer->expirationDate)
                    <p class="text-muted mt-3 small">
                        ⏳ Offre valable jusqu’au {{ date('d/m/Y', strtotime($offer->expirationDate)) }}
                    </p>
                @endif

                <a href="{{ route('job_offers.index') }}" class="btn btn-highlight mt-4">
                    <span class="material-symbols-outlined me-1">arrow_back</span>
                    Retour à la liste
                </a>
            </div>
        </div>
    </div>

    <style>
        .offer-header {
            background: var(--sand);
            color: var(--text-primary);
            border: 1px solid #eee;
        }

        .company-link {
            color: var(--aquamarine);
            text-decoration: none;
            transition: opacity 0.2s;
        }
        .company-link:hover {
            opacity: 0.7;
        }

        .offer-logo {
            width: 70px;
            height: 70px;
            object-fit: cover;
            background: var(--white);
            padding: 6px;
            border: 1px solid #ddd;
        }

        .badge-custom {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            font-size: 0.85rem;
            padding: 8px 12px;
            border-radius: 50px;
            border: 1px solid #ddd;
            background: var(--white);
            color: var(--text-primary);
            font-weight: 500;
            box-shadow: var(--shadow-soft);
        }

        .badge-custom.active {
            border-color: var(--aquamarine);
            background: rgba(56,118,124,0.08);
        }

        .badge-custom.inactive {
            opacity: 0.6;
        }

        .badge-custom.salary {
            border-color: var(--orangish);
            background: rgba(249,137,72,0.08);
        }

        .badge-custom.remote {
            border-color: var(--aquamarine);
            background: rgba(56,118,124,0.08);
            font-weight: 600;
        }

        .section-title {
            font-weight: 700;
            color: var(--indigo);
        }

        @media (max-width: 768px) {
            .offer-header {
                text-align: center;
            }

            .offer-logo {
                width: 60px;
                height: 60px;
            }

            .offer-meta {
                justify-content: center !important;
            }

            .badge-custom {
                font-size: 0.8rem;
                padding: 6px 10px;
            }

            .section-title {
                font-size: 1.1rem;
            }
        }
    </style>
@endsection
