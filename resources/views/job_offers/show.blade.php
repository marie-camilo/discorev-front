@extends('layouts.app')

@section('title', 'Offre d\'emploi | Discorev')

@section('content')
    <div class="min-h-screen bg-gradient-to-br from-blue-50 via-white to-indigo-50 py-8 px-4 sm:px-6 lg:px-8">
        <div class="max-w-5xl mx-auto">
            <!-- En-tête de l'offre -->
            <div class="bg-white rounded-2xl shadow-lg p-6 sm:p-8 mb-6 border border-gray-100">
                <div class="flex flex-col lg:flex-row lg:justify-between lg:items-start gap-4">
                    <div class="flex-1">
                        <div class="inline-block px-3 py-1 bg-blue-100 text-blue-700 text-sm font-medium rounded-full mb-3">
                            {{ $offer->employmentType }}
                        </div>
                        <h1 class="text-3xl sm:text-4xl font-bold text-gray-900 mb-3">{{ $offer->title }}</h1>
                        <div class="flex flex-wrap items-center gap-4 text-gray-600">
                            <span class="flex items-center gap-2">
                                <span class="material-symbols-outlined text-lg">calendar_today</span>
                                <span class="text-sm">Publiée le {{ date('d/m/Y', strtotime($offer->publicationDate)) }}</span>
                            </span>
                            @if ($offer->expirationDate)
                                <span class="flex items-center gap-2">
                                    <span class="material-symbols-outlined text-lg text-red-500">schedule</span>
                                    <span class="text-sm">Expire le {{ date('d/m/Y', strtotime($offer->expirationDate)) }}</span>
                                </span>
                            @endif
                        </div>
                    </div>
                    <div class="lg:text-right">
                        <p class="text-sm text-gray-500 mb-1">Proposée par</p>
                        <h3 class="text-xl font-semibold text-gray-900">
                            {{ $recruiter->companyName ? $recruiter->companyName : 'Recruteur' }}
                        </h3>
                    </div>
                </div>
            </div>

            <!-- Informations principales en grille -->
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4 mb-6">
                <!-- Localisation -->
                <div class="bg-white rounded-xl shadow-md p-5 border border-gray-100 hover:shadow-lg transition-shadow">
                    <div class="flex items-center gap-3 mb-2">
                        <div class="p-2 bg-purple-100 rounded-lg">
                            <span class="material-symbols-outlined text-purple-600">distance</span>
                        </div>
                        <h3 class="font-semibold text-gray-900">Localisation</h3>
                    </div>
                    <p class="text-gray-700 ml-12">{{ $offer->location }}</p>
                </div>

                <!-- Salaire -->
                <div class="bg-white rounded-xl shadow-md p-5 border border-gray-100 hover:shadow-lg transition-shadow">
                    <div class="flex items-center gap-3 mb-2">
                        <div class="p-2 bg-green-100 rounded-lg">
                            <span class="material-symbols-outlined text-green-600">price_change</span>
                        </div>
                        <h3 class="font-semibold text-gray-900">Salaire</h3>
                    </div>
                    @if ($offer->salaryMin && $offer->salaryMax)
                        <p class="text-gray-700 ml-12">{{ number_format($offer->salaryMin, 0, ',', ' ') }} - {{ number_format($offer->salaryMax, 0, ',', ' ') }} €/mois</p>
                    @else
                        <p class="text-gray-500 ml-12 italic">Non défini</p>
                    @endif
                </div>

                <!-- Télétravail -->
                <div class="bg-white rounded-xl shadow-md p-5 border border-gray-100 hover:shadow-lg transition-shadow">
                    <div class="flex items-center gap-3 mb-2">
                        <div class="p-2 bg-amber-100 rounded-lg">
                            <span class="material-symbols-outlined text-amber-600">home_work</span>
                        </div>
                        <h3 class="font-semibold text-gray-900">Télétravail</h3>
                    </div>
                    <p class="ml-12">
                        @if ($offer->remote)
                            <span class="inline-flex items-center gap-1 text-green-600 font-medium">
                                <span class="material-symbols-outlined text-lg">check_circle</span>
                                Oui
                            </span>
                        @else
                            <span class="inline-flex items-center gap-1 text-gray-500">
                                <span class="material-symbols-outlined text-lg">cancel</span>
                                Non
                            </span>
                        @endif
                    </p>
                </div>
            </div>

            <!-- Période de travail (si définie) -->
            @if ($offer->startDate && $offer->endDate)
                <div class="bg-gradient-to-r from-indigo-50 to-blue-50 rounded-xl shadow-md p-5 mb-6 border border-indigo-100">
                    <div class="flex items-center gap-3">
                        <div class="p-2 bg-indigo-100 rounded-lg">
                            <span class="material-symbols-outlined text-indigo-600">date_range</span>
                        </div>
                        <div>
                            <h3 class="font-semibold text-gray-900 mb-1">Période de travail</h3>
                            <p class="text-gray-700">Du {{ $offer->startDate }} au {{ $offer->endDate }}</p>
                        </div>
                    </div>
                </div>
            @endif

            <!-- Description -->
            <div class="bg-white rounded-2xl shadow-lg p-6 sm:p-8 mb-6 border border-gray-100">
                <div class="flex items-center gap-3 mb-4 pb-4 border-b border-gray-200">
                    <div class="p-2 bg-blue-100 rounded-lg">
                        <span class="material-symbols-outlined text-blue-600">article</span>
                    </div>
                    <h2 class="text-2xl font-bold text-gray-900">Description du poste</h2>
                </div>
                <div class="prose prose-gray max-w-none">
                    <p class="text-gray-700 leading-relaxed whitespace-pre-line">{{ $offer->description }}</p>
                </div>
            </div>

            <!-- Exigences -->
            <div class="bg-white rounded-2xl shadow-lg p-6 sm:p-8 mb-6 border border-gray-100">
                <div class="flex items-center gap-3 mb-4 pb-4 border-b border-gray-200">
                    <div class="p-2 bg-cyan-100 rounded-lg">
                        <span class="material-symbols-outlined text-cyan-600">article_person</span>
                    </div>
                    <h2 class="text-2xl font-bold text-gray-900">Exigences et profil recherché</h2>
                </div>
                <div class="prose prose-gray max-w-none">
                    @if ($offer->requirements)
                        <p class="text-gray-700 leading-relaxed whitespace-pre-line">{{ $offer->requirements }}</p>
                    @else
                        <p class="text-gray-500 italic">Pas d'exigences particulières mentionnées</p>
                    @endif
                </div>
            </div>

            <!-- Boutons d'action -->
            <div class="flex flex-col sm:flex-row gap-4">
                <a href="{{ route('job_offers.index') }}"
                   class="inline-flex items-center justify-center gap-2 px-6 py-3 bg-white border-2 border-gray-300 text-gray-700 font-semibold rounded-xl hover:bg-gray-50 hover:border-gray-400 transition-all shadow-sm">
                    <span class="material-symbols-outlined">arrow_back</span>
                    Retour aux offres
                </a>
                <button class="inline-flex items-center justify-center gap-2 px-6 py-3 bg-gradient-to-r from-blue-600 to-indigo-600 text-white font-semibold rounded-xl hover:from-blue-700 hover:to-indigo-700 transition-all shadow-md hover:shadow-lg flex-1 sm:flex-initial">
                    <span class="material-symbols-outlined">send</span>
                    Postuler à cette offre
                </button>
            </div>
        </div>
    </div>
@endsection
