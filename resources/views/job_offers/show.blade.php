@extends('layouts.app')

@section('title', 'Offre d\'emploi')

@section('content')
    <div class="container my-5 animate__animated animate__fadeIn">
        {{-- Header de l'offre --}}
        <div class="row align-items-center mb-5">
            <div class="col-md-8">
                <h1 class="mb-2 fw-bold">{{ $jobOffer->title }}</h1>
                <p class="text-muted fs-5">
                    <span class="material-symbols-outlined text-primary me-1">business_center</span>
                    <a class="text-decoration-none" href="{{ route('companies.show', $jobOffer->recruiterId) }}">
                        <strong>{{ $jobOffer->recruiter->companyName ?? 'Recruteur' }}</strong>
                    </a>
                </p>
            </div>
            <div class="col-md-4 text-md-end text-center">
                @if (!empty($jobOffer->recruiter->logo->filePath))
                    <img src="{{ env('DISCOREV_API_URL') . '/' . $jobOffer->recruiter->logo->filePath }}"
                        alt="Logo entreprise" class="img-fluid rounded-circle border shadow-sm transition"
                        style="max-width: 100px; transition: transform 0.3s;"
                        onmouseover="this.style.transform='scale(1.1)'" onmouseout="this.style.transform='scale(1)'">
                @endif
            </div>
        </div>

        {{-- Carte de l'offre --}}
        <div class="card shadow-lg border-0">
            <div class="card-body">
                {{-- Description --}}
                <section class="mb-5">
                    <h5 class="card-title fs-4">
                        <span class="material-symbols-outlined me-1 text-secondary">description</span>
                        Description
                    </h5>
                    <p class="card-text fs-6">{{ $jobOffer->description }}</p>
                </section>

                {{-- Exigences --}}
                <section class="mb-5">
                    <h5 class="card-title fs-4">
                        <span class="material-symbols-outlined me-1 text-secondary">checklist</span>
                        Exigences
                    </h5>
                    <p class="card-text fs-6">{{ $jobOffer->requirements }}</p>
                </section>

                {{-- Informations clés --}}
                <section>
                    <h5 class="card-title fs-4 mb-4">
                        <span class="material-symbols-outlined me-1 text-secondary">info</span>
                        Informations clés
                    </h5>
                    <div class="row g-4">
                        <x-info-card icon="euro" label="Salaire" value="{{ $jobOffer->salaryRange }}" />
                        <x-info-card icon="contract" label="Contrat" value="{{ strtoupper($jobOffer->employmentType) }}" />
                        <x-info-card icon="location_on" label="Localisation" value="{{ $jobOffer->location }}" />
                        <x-info-card icon="home_work" label="Télétravail" value="{!! $jobOffer->remote
                            ? '<span class=\'badge bg-success\'>Oui</span>'
                            : '<span class=\'badge bg-danger\'>Non</span>' !!}" />
                        <x-info-card icon="event" label="Expiration"
                            value="{{ $jobOffer->expirationDate ? \Carbon\Carbon::parse($jobOffer->expirationDate)->format('d/m/Y') : 'Non définie' }}" />
                    </div>
                </section>

                {{-- Bouton de retour --}}
                <div class="mt-5 text-center">
                    <a href="{{ route('job_offers.index') }}" class="btn btn-outline-primary btn-lg">
                        ← Retour à la liste
                    </a>
                </div>
            </div>
        </div>
    </div>
@endsection
