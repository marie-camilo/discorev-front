@extends('layouts.app')

@section('title', $offer->title . ' | Discorev')

@section('content')
    @php
        use Carbon\Carbon;
        $publicationDate = Carbon::parse($offer->publicationDate);
        $daysAgo = $publicationDate->diffForHumans();
    @endphp

    <div class="container py-5">
        <!-- HEADER DE L'OFFRE -->
        <div class="offer-header shadow-sm rounded-4 p-4 mb-5 position-relative">

            <!-- Bouton retour -->
            <a href="{{ route('job_offers.index') }}" class="back-arrow position-absolute">
                <span class="material-symbols-outlined">arrow_back</span>
            </a>

            <div class="d-flex flex-column flex-md-row align-items-md-center justify-content-between gap-4 mt-3">

                <!-- Logo + Nom entreprise -->
                <div class="d-flex align-items-center gap-3">
                    <div class="company-logo">
                        @if (!empty($recruiter->website))
                            <a href="{{ $recruiter->website }}" target="_blank" rel="noopener noreferrer">
                                <img src="{{ $recruiter->logo ? config('app.api') . '/' . $recruiter->logo : asset('img/default-company.png') }}"
                                     alt="Logo {{ $recruiter->companyName }}"
                                     class="offer-logo shadow-sm" />
                            </a>
                        @else
                            <img src="{{ $recruiter->logo ? config('app.api') . '/' . $recruiter->logo : asset('img/default-company.png') }}"
                                 alt="Logo {{ $recruiter->companyName }}"
                                 class="offer-logo shadow-sm" />
                        @endif
                    </div>

                    <div>
                        <h2 class="mb-1 fw-bold">{{ $offer->title }}</h2>
                        <a href="{{ route('companies.show', ['identifier' => $recruiter->id]) }}" class="text-decoration-none fw-semibold text-primary">
                            {{ $recruiter->companyName }}
                        </a>
                        <p class="text-secondary small mb-0">Publiée {{ $daysAgo }}</p>
                    </div>
                </div>

                <!-- Informations principales -->
                <div class="offer-meta d-flex flex-wrap gap-3 justify-content-md-end">
                    <span class="badge badge-modern">
                        <span class="material-symbols-outlined">work</span>
                        {{ strtoupper($offer->employmentType) }}
                    </span>
                    <span class="badge badge-modern">
                        <span class="material-symbols-outlined">location_on</span>
                        {{ $offer->location }}
                    </span>
                    @if($offer->startDate && $offer->endDate)
                        <span class="badge badge-modern">
                            <span class="material-symbols-outlined">calendar_month</span>
                            {{ \Carbon\Carbon::parse($offer->startDate)->format('d/m/Y') }} → {{ \Carbon\Carbon::parse($offer->endDate)->format('d/m/Y') }}
                        </span>
                    @endif
                    @if ($offer->status)
                        <span class="badge badge-modern">
                            <span class="material-symbols-outlined">fiber_manual_record</span>
                            {{ ucfirst($offer->status) }}
                        </span>
                    @endif
                    @if ($offer->salaryMin && $offer->salaryMax)
                        <span class="badge badge-modern">
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
                        <span class="badge badge-modern">🏠 Télétravail possible</span>
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
        .offer-header {
            background: var(--sand);
            color: var(--text-primary);
            position: relative;
        }

        .back-arrow {
            top: 20px;
            left: 20px;
            color: var(--indigo);
            display: inline-flex;
            align-items: center;
            justify-content: center;
            background: var(--white);
            border-radius: 12px;
            width: 40px;
            height: 40px;
            box-shadow: var(--shadow-soft);
            transition: all 0.2s ease;
        }

        .back-arrow:hover {
            box-shadow: var(--shadow-hover);
            transform: translateY(-2px);
        }

        .offer-logo {
            width: 60px;
            height: 60px;
            object-fit: contain;
            border-radius: 10px;
            background: var(--white);
            padding: 6px;
        }

        .badge-modern {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            font-size: 0.9rem;
            font-weight: 500;
            padding: 8px 14px;
            border-radius: 10px;
            background: var(--white);
            color: var(--text-primary);
            box-shadow: var(--shadow-soft);
        }

        .badge-modern .material-symbols-outlined {
            font-size: 18px;
            opacity: 0.7;
        }

        .section-title {
            font-weight: 700;
            color: var(--indigo);
        }

        @media (max-width: 768px) {
            .offer-header {
                text-align: center;
                padding-top: 3rem;
            }

            .offer-meta {
                justify-content: center !important;
            }

            .offer-logo {
                width: 50px;
                height: 50px;
            }

            .back-arrow {
                top: 10px;
                left: 10px;
                width: 35px;
                height: 35px;
            }
        }
    </style>
@endsection
