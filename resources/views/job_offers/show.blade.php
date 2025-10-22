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
                <div class="d-flex align-items-center gap-3">
                    <img src="{{ $recruiter->logo ? asset('storage/' . $recruiter->logo) : asset('img/default-company.png') }}"
                         alt="Logo {{ $recruiter->companyName }}"
                         class="offer-logo rounded-circle shadow-sm">
                    <div>
                        <h2 class="mb-1 fw-bold">{{ $offer->title }}</h2>
                        <a href="{{ route('companies.show', $recruiter->identifier) }}"
                           class="text-decoration-none text-muted fw-semibold">
                            {{ $recruiter->companyName ?? 'Entreprise' }}
                        </a>
                        <p class="text-secondary small mb-0">Publiée {{ $daysAgo }}</p>
                    </div>
                </div>

                <!-- Informations principales -->
                <div class="offer-meta d-flex flex-wrap gap-3 justify-content-md-end">
                <span class="badge bg-primary text-white d-flex align-items-center gap-1">
                    <span class="material-symbols-outlined">work</span>
                    {{ strtoupper($offer->employmentType) }}
                </span>
                    <span class="badge bg-info text-white d-flex align-items-center gap-1">
                    <span class="material-symbols-outlined">location_on</span>
                    {{ $offer->location }}
                </span>
                    @if($offer->startDate && $offer->endDate)
                        <span class="badge bg-success text-white d-flex align-items-center gap-1">
                        <span class="material-symbols-outlined">calendar_month</span>
                        {{ \Carbon\Carbon::parse($offer->startDate)->format('d/m/Y') }} → {{ \Carbon\Carbon::parse($offer->endDate)->format('d/m/Y') }}
                    </span>
                    @endif
                    @if ($offer->status)
                        <span class="badge bg-{{ $offer->status === 'active' ? 'success' : 'secondary' }} text-white d-flex align-items-center gap-1">
                        <span class="material-symbols-outlined">fiber_manual_record</span>
                        {{ ucfirst($offer->status) }}
                    </span>
                    @endif
                    @if ($offer->salaryMin && $offer->salaryMax)
                        <span class="badge bg-warning text-dark d-flex align-items-center gap-1">
                        <span class="material-symbols-outlined">euro</span>
                        {{ $offer->salaryMin }} - {{ $offer->salaryMax }} €/mois
                    </span>
                    @endif
                </div>
            </div>
        </div>

        <!-- CONTENU PRINCIPAL -->
        <div class="card shadow rounded-4 p-4">
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
                    <span class="badge bg-success-subtle text-success-emphasis">
                        🏠 Télétravail possible
                    </span>
                    </div>
                @endif

                @if ($offer->expirationDate)
                    <p class="text-muted mt-3 small">
                        ⏳ Offre valable jusqu’au {{ date('d/m/Y', strtotime($offer->expirationDate)) }}
                    </p>
                @endif

                <a href="{{ route('job_offers.index') }}" class="btn btn-outline-primary mt-4">
                    <span class="material-symbols-outlined me-1">arrow_back</span>
                    Retour à la liste
                </a>
            </div>
        </div>
    </div>

    <style>
        .offer-header {
            background: linear-gradient(135deg, var(--aquamarine, #64ffda) 0%, var(--indigo, #0d4a52) 100%);
            color: white;
        }

        .offer-logo {
            width: 70px;
            height: 70px;
            object-fit: cover;
            background: white;
            padding: 6px;
        }

        .offer-meta .badge {
            font-size: 0.9rem;
            padding: 10px 14px;
            border-radius: 12px;
        }

        .section-title {
            font-weight: 700;
            color: var(--indigo, #0d4a52);
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

            .offer-meta .badge {
                font-size: 0.8rem;
            }

            .section-title {
                font-size: 1.1rem;
            }
        }
    </style>
@endsection
