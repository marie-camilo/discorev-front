@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 py-8">
    <h1 class="text-3xl font-bold mb-8">Exemples d'utilisation des modèles API</h1>

    <!-- Exemple 1: Affichage d'un recruteur -->
    <div class="bg-white rounded-lg shadow-md p-6 mb-8">
        <h2 class="text-xl font-semibold mb-4">Recruteur avec ses relations</h2>

        @if(isset($recruiter))
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <div>
                <h3 class="font-medium text-gray-700">Informations entreprise</h3>
                <p><strong>Nom:</strong> {{ $recruiter->companyName }}</p>
                <p><strong>Localisation:</strong> {{ $recruiter->location }}</p>
                <p><strong>Taille équipe:</strong> {{ $recruiter->getTeamSizeLabel() }}</p>
                <p><strong>Secteur:</strong>{{ $recruiter->sectorName ?? $recruiter->sector }}</p>

                @if($recruiter->user)
                <div class="mt-4">
                    <h4 class="font-medium text-gray-700">Contact principal</h4>
                    <p><strong>Nom:</strong> {{ $recruiter->user->getFullName() }}</p>
                    <p><strong>Email:</strong> {{ $recruiter->user->email }}</p>
                    <p><strong>Type compte:</strong> {{ $recruiter->user->getAccountTypeLabel() }}</p>
                </div>
                @endif
            </div>

            <div>
                <h3 class="font-medium text-gray-700">Membres de l'équipe</h3>
                @if($recruiter->teamMembers && $recruiter->teamMembers->count() > 0)
                    <div class="space-y-2">
                        @foreach($recruiter->teamMembers as $member)
                        <div class="border-l-4 border-blue-500 pl-3">
                            <p class="font-medium">{{ $member->name }}</p>
                            <p class="text-sm text-gray-600">{{ $member->role }}</p>
                            <p class="text-sm text-gray-500">{{ $member->email }}</p>
                        </div>
                        @endforeach
                    </div>
                @else
                    <p class="text-gray-500">Aucun membre d'équipe</p>
                @endif
            </div>
        </div>
        @endif
    </div>

    <!-- Exemple 2: Affichage d'offres d'emploi -->
    <div class="bg-white rounded-lg shadow-md p-6 mb-8">
        <h2 class="text-xl font-semibold mb-4">Offres d'emploi</h2>

        @if(isset($jobOffers) && $jobOffers->count() > 0)
        <div class="space-y-4">
            @foreach($jobOffers as $job)
            <div class="border rounded-lg p-4 hover:shadow-md transition-shadow">
                <div class="flex justify-between items-start">
                    <div class="flex-1">
                        <h3 class="text-lg font-semibold">{{ $job->title }}</h3>
                        <p class="text-gray-600">{{ Str::limit($job->description, 150) }}</p>

                        <div class="flex flex-wrap gap-2 mt-3">
                            <span class="px-2 py-1 bg-blue-100 text-blue-800 text-xs rounded">
                                {{ $job->getEmploymentTypeLabel() }}
                            </span>
                            <span class="px-2 py-1 bg-green-100 text-green-800 text-xs rounded">
                                {{ $job->getStatusLabel() }}
                            </span>
                            <span class="px-2 py-1 bg-purple-100 text-purple-800 text-xs rounded">
                                {{ $job->getRemoteLabel() }}
                            </span>
                        </div>

                        <div class="mt-3 text-sm text-gray-500">
                            <p><strong>Localisation:</strong> {{ $job->location }}</p>
                            @if($job->salaryRange)
                            <p><strong>Salaire:</strong> {{ $job->salaryRange }}</p>
                            @endif
                            <p><strong>Publié le:</strong> {{ $job->publicationDate->format('d/m/Y') }}</p>
                        </div>
                    </div>

                    <div class="text-right">
                        @if($job->isActive())
                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">
                                Active
                            </span>
                        @elseif($job->isExpired())
                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-red-100 text-red-800">
                                Expirée
                            </span>
                        @else
                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-gray-100 text-gray-800">
                                {{ $job->getStatusLabel() }}
                            </span>
                        @endif
                    </div>
                </div>

                @if($job->recruiter)
                <div class="mt-4 pt-4 border-t">
                    <p class="text-sm text-gray-600">
                        <strong>Entreprise:</strong> {{ $job->recruiter->companyName }}
                    </p>
                </div>
                @endif
            </div>
            @endforeach
        </div>
        @else
        <p class="text-gray-500">Aucune offre d'emploi disponible</p>
        @endif
    </div>

    <!-- Exemple 3: Affichage de candidatures -->
    <div class="bg-white rounded-lg shadow-md p-6 mb-8">
        <h2 class="text-xl font-semibold mb-4">Candidatures</h2>

        @if(isset($applications) && $applications->count() > 0)
        <div class="space-y-4">
            @foreach($applications as $application)
            <div class="border rounded-lg p-4">
                <div class="flex justify-between items-start">
                    <div class="flex-1">
                        @if($application->candidate && $application->candidate->user)
                        <h3 class="font-semibold">
                            {{ $application->candidate->user->getFullName() }}
                        </h3>
                        <p class="text-gray-600">{{ $application->candidate->user->email }}</p>
                        @endif

                        <div class="mt-2">
                            <span class="px-2 py-1 text-xs rounded font-medium
                                @if($application->isSent()) bg-blue-100 text-blue-800
                                @elseif($application->isViewed()) bg-yellow-100 text-yellow-800
                                @elseif($application->isInterview()) bg-orange-100 text-orange-800
                                @elseif($application->isPending()) bg-purple-100 text-purple-800
                                @elseif($application->isRejected()) bg-red-100 text-red-800
                                @elseif($application->isAccepted()) bg-green-100 text-green-800
                                @else bg-gray-100 text-gray-800
                                @endif">
                                {{ $application->getStatusLabel() }}
                            </span>
                        </div>

                        <p class="text-sm text-gray-500 mt-2">
                            <strong>Candidature envoyée le:</strong> {{ $application->dateApplied->format('d/m/Y H:i') }}
                        </p>

                        @if($application->notes)
                        <div class="mt-3 p-3 bg-gray-50 rounded">
                            <p class="text-sm"><strong>Notes:</strong> {{ $application->notes }}</p>
                        </div>
                        @endif
                    </div>

                    @if($application->jobOffer)
                    <div class="text-right text-sm text-gray-500">
                        <p><strong>Pour:</strong> {{ $application->jobOffer->title }}</p>
                    </div>
                    @endif
                </div>
            </div>
            @endforeach
        </div>
        @else
        <p class="text-gray-500">Aucune candidature</p>
        @endif
    </div>

    <!-- Exemple 4: Affichage de médias -->
    <div class="bg-white rounded-lg shadow-md p-6 mb-8">
        <h2 class="text-xl font-semibold mb-4">Médias</h2>

        @if(isset($medias) && $medias->count() > 0)
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
            @foreach($medias as $media)
            <div class="border rounded-lg p-4">
                <div class="mb-3">
                    <h3 class="font-medium">{{ $media->title ?: 'Sans titre' }}</h3>
                    <p class="text-sm text-gray-600">{{ $media->getTypeLabel() }}</p>
                    <p class="text-sm text-gray-500">{{ $media->getContextLabel() }}</p>
                </div>

                <div class="flex flex-wrap gap-2 mb-3">
                    <span class="px-2 py-1 text-xs rounded
                        @if($media->isPublic()) bg-green-100 text-green-800
                        @elseif($media->isPrivate()) bg-red-100 text-red-800
                        @else bg-yellow-100 text-yellow-800
                        @endif">
                        {{ ucfirst($media->visibility) }}
                    </span>
                </div>

                <p class="text-xs text-gray-500">
                    <strong>Uploadé le:</strong> {{ $media->uploadedAt->format('d/m/Y H:i') }}
                </p>

                @if($media->uploader)
                <p class="text-xs text-gray-500">
                    <strong>Par:</strong> {{ $media->uploader->getFullName() }}
                </p>
                @endif
            </div>
            @endforeach
        </div>
        @else
        <p class="text-gray-500">Aucun média</p>
        @endif
    </div>

    <!-- Exemple 5: Affichage de notifications -->
    <div class="bg-white rounded-lg shadow-md p-6">
        <h2 class="text-xl font-semibold mb-4">Notifications</h2>

        @if(isset($notifications) && $notifications->count() > 0)
        <div class="space-y-3">
            @foreach($notifications as $notification)
            <div class="flex items-start space-x-3 p-3 rounded-lg
                @if($notification->isUnread()) bg-blue-50 border-l-4 border-blue-500
                @else bg-gray-50
                @endif">
                <div class="flex-1">
                    <div class="flex items-center justify-between">
                        <h3 class="font-medium">{{ $notification->getTypeLabel() }}</h3>
                        <span class="text-xs text-gray-500">
                            {{ $notification->createdAt->format('d/m/Y H:i') }}
                        </span>
                    </div>
                    <p class="text-sm text-gray-600 mt-1">{{ $notification->message }}</p>
                    <p class="text-xs text-gray-500 mt-1">
                        Type: {{ $notification->getRelatedTypeLabel() }}
                    </p>
                </div>

                @if($notification->isUnread())
                <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium bg-blue-100 text-blue-800">
                    Nouveau
                </span>
                @endif
            </div>
            @endforeach
        </div>
        @else
        <p class="text-gray-500">Aucune notification</p>
        @endif
    </div>
</div>
@endsection
