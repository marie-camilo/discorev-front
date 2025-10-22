@extends('layouts.app')

@section('title', $offer->title . ' | Discorev')

@section('content')
    @php
        use Carbon\Carbon;
        $publicationDate = Carbon::parse($offer->publicationDate);
        $daysAgo = $publicationDate->diffForHumans();
    @endphp

    <div class="container py-5">

        <!-- Bouton retour avant le header -->
        <div class="mb-3">
            <a href="{{ route('job_offers.index') }}" class="btn btn-highlight d-inline-flex align-items-center gap-1">
                <span class="material-symbols-outlined">arrow_back</span>
                Retour aux offres
            </a>
        </div>

        <!-- HEADER -->
        <div class="offer-header shadow-sm rounded-4 p-4 mb-5">
            <div class="d-flex flex-column flex-md-row align-items-md-center justify-content-between gap-4">
                <!-- Logo + Entreprise -->
                <div class="d-flex align-items-center gap-3">
                    @php
                        $logoUrl = !empty($recruiter->logo)
                            ? config('app.api') . '/' . ltrim($recruiter->logo, '/')
                            : asset('img/default-company.png');
                    @endphp

                    <div class="company-logo">
                        <a href="{{ route('companies.show', $recruiter->id ?: $recruiter->companyName) }}" class="d-inline-block">
                            <img src="{{ $logoUrl }}" alt="Logo de {{ $recruiter->companyName }}" class="offer-logo shadow-sm">
                        </a>
                    </div>

                    <div>
                        <h2 class="mb-1 fw-bold">{{ $offer->title }}</h2>
                        <a href="{{ route('companies.show', ['identifier' => $recruiter->id]) }}" class="text-decoration-none company-name-link">
                            {{ $recruiter->companyName }}
                        </a>
                        <p class="text-muted small mb-0">Publiée {{ $daysAgo }}</p>
                    </div>
                </div>

                <!-- Badges -->
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
                        <span class="badge-custom">
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
                <h4 class="section-title mb-3">
                    <span class="material-symbols-outlined me-2">description</span>
                    Description du poste
                </h4>
                <p class="card-text lh-lg">{{ $offer->description }}</p>

                <hr class="my-4">

                <h4 class="section-title mb-3">
                    <span class="material-symbols-outlined me-2">rule</span>
                    Exigences du poste
                </h4>
                <p class="card-text lh-lg">
                    {{ $offer->requirements ?? 'Aucune exigence particulière pour ce poste.' }}
                </p>

                @if ($offer->remote)
                    <div class="mt-4">
                        <span class="badge-custom">🏠 Télétravail possible</span>
                    </div>
                @endif

                @if ($offer->expirationDate)
                    <p class="text-muted mt-3 small">
                        ⏳ Offre valable jusqu’au {{ date('d/m/Y', strtotime($offer->expirationDate)) }}
                    </p>
                @endif
            </div>
        </div>
    </div>

    <style>
        /* HEADER */
        .offer-header {
            background: var(--sand);
            color: var(--text-primary);
            box-shadow: var(--shadow-soft);
        }

        .company-logo {
            width: 70px;
            height: 70px;
            background: var(--white);
            display: flex;
            align-items: center;
            justify-content: center;
            border-radius: 50%;
            flex-shrink: 0;
        }

        .company-logo img {
            width: 100%;
            height: 100%;
            object-fit: contain;
            padding: 8px;
        }

        .company-name-link {
            font-weight: 600;
            color: var(--text-primary);
            transition: 0.2s ease;
        }

        .company-name-link:hover {
            color: var(--aquamarine);
        }

        /* BADGES */
        .badge-custom {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            padding: 8px 14px;
            font-size: 0.9rem;
            border-radius: 10px;
            background: var(--white);
            border: 1px solid rgba(0,0,0,0.08);
            color: var(--text-secondary);
            transition: all 0.2s ease;
        }

        .badge-custom:hover {
            background: var(--wondrous-blue);
            color: var(--indigo);
        }

        .badge-custom.active {
            border-color: var(--aquamarine);
            color: var(--aquamarine);
        }

        .badge-custom.inactive {
            color: var(--text-secondary);
            opacity: 0.6;
        }

        /* TITRES */
        .section-title {
            font-weight: 700;
            color: var(--indigo);
            display: flex;
            align-items: center;
        }

        /* RESPONSIVE */
        @media (max-width: 768px) {
            .offer-header {
                text-align: center;
            }
            .company-logo {
                width: 60px;
                height: 60px;
                margin: 0 auto;
            }
            .offer-meta {
                justify-content: center !important;
            }
            .badge-custom {
                font-size: 0.85rem;
            }
        }
    </style>
@endsection
