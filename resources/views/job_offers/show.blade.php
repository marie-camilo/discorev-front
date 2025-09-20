@extends('layouts.app')

@section('title', 'Offre d\'emploi | Discorev')

@section('content')
    <div class="container min-vh-100 py-5">
        <div class="d-flex justify-content-between align-items-center">
            <div class="mb-4">
                <h1>{{ $offer['title'] }}</h1>
                <span>publiée
                    {{ date('d/m/Y', strtotime($offer['publicationDate'])) }}</span>
            </div>
            <span>
                créee par
                <h5 class="card-title">{{ $recruiter['companyName'] ? $recruiter['companyName'] : 'Recruteur' }}</h5>
            </span>
        </div>

        <div class="card shadow rounded-4 p-4">
            <div class="card-body">
                <h5 class="card-title">Description</h5>
                <p class="card-text">{{ $offer['description'] }}</p>

                <h5 class="card-title">Exigences</h5>
                <p class="card-text">{{ $offer['requirements'] }}</p>

                <h5 class="card-title">Fourchette salariale</h5>
                <p class="card-text">Entre {{ $offer['salaryMin'] }} et {{ $offer['salaryMax'] }}</p>

                <h5 class="card-title">Type de contrat</h5>
                <p class="card-text text-uppercase">{{ $offer['employmentType'] }}</p>

                <h5 class="card-title">Localisation</h5>
                <p class="card-text">{{ $offer['location'] }}</p>

                <h5 class="card-title">Télétravail</h5>
                <p class="card-text">
                    @if ($offer['remote'])
                        ✅ Oui
                    @else
                        ❌ Non
                    @endif
                </p>

                @if ($offer['expirationDate'])
                    <h5 class="card-title">Expire le</h5>
                    <p class="card-text">
                        {{ $offer['expirationDate'] ? \Carbon\Carbon::parse($offer['expirationDate']->format('d/m/Y')) : 'Non définie' }}
                    </p>
                @endif
                <a href="{{ route('job_offers.index') }}" class="btn btn-primary mt-3">Retour à la liste</a>
            </div>
        </div>
    </div>
@endsection
