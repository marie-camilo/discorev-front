@extends('layouts.app')

@section('title', 'Offre d\'emploi | Discorev')

@section('content')
    <div class="container min-vh-100 py-5">
        <div class="d-flex justify-content-between align-items-center">
            <div class="mb-4">
                <h1>{{ $offer->title }}</h1>
                <span>publiée le
                    {{ date('d/m/Y', strtotime($offer->publicationDate)) }}</span>
            </div>
            <span>
                créee par
                <h5 class="card-title">{{ $recruiter->companyName ? $recruiter->companyName : 'Recruteur' }}</h5>
            </span>
        </div>

        <div class="card shadow rounded-4 p-4">
            <div class="card-body">
                <h5 class="card-title d-flex align-items-center"><span class="material-symbols-outlined me-2 text-primary">
                        article
                    </span> Description</h5>
                <p class="card-text">{{ $offer->description }}</p>

                <h5 class="card-title d-flex align-items-center"><span class="material-symbols-outlined me-2 text-info">
                        article_person
                    </span> Exigences</h5>
                @if ($offer->requirements)
                    <p class="card-text">{{ $offer->requirements }}</p>
                @else
                    <p class="card-text">Pas d'exigences particulières</p>
                @endif

                <h5 class="card-title d-flex align-items-center"><span class="material-symbols-outlined me-2 text-success">
                        price_change
                    </span> Fourchette salariale</h5>
                @if ($offer->salaryMin && $offer->salaryMax)
                    <p class="card-text">Entre {{ $offer->salaryMin }} et {{ $offer->salaryMax }} €/mois</p>
                @else
                    <p class="card-text">Non défini</p>
                @endif

                <h5 class="card-title d-flex align-items-center"><span class="material-symbols-outlined me-2 text-tertiary">
                        edit_document
                    </span> Type de contrat</h5>
                <p class="card-text text-uppercase">{{ $offer->employmentType }}</p>

                <h5 class="card-title d-flex align-items-center"><span
                        class="material-symbols-outlined me-2 text-secondary">
                        distance
                    </span> Localisation</h5>
                <p class="card-text">{{ $offer->location }}</p>

                <h5 class="card-title d-flex align-items-center"><span class="material-symbols-outlined me-2 text-warning">
                        home_work
                    </span> Télétravail</h5>
                <p class="card-text">
                    @if ($offer->remote)
                        ✅ Oui
                    @else
                        ❌ Non
                    @endif
                </p>

                @if ($offer->startDate && $offer->endDate)
                    <h5 class="card-title d-flex align-items-center"><span
                            class="material-symbols-outlined me-2 text-warning-emphasis">date_range
                        </span> Période de travail</h5>
                    <p class="card-text">Du {{ $offer->startDate }} au {{ $offer->endDate }}</p>
                @endif

                @if ($offer->expirationDate)
                    <h5 class="card-title d-flex align-items-center"><span
                            class="material-symbols-outlined me-2 text-danger">
                            timer
                        </span> Expire le</h5>
                    <p class="card-text">
                        {{ $offer->expirationDate ? date('d/m/Y', strtotime($offer->expirationDate)) : 'Non définie' }}
                    </p>
                @endif
                <a href="{{ route('job_offers.index') }}" class="btn btn-primary mt-3">Retour à la liste</a>
            </div>
        </div>
    </div>
@endsection
