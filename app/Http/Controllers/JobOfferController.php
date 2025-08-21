<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Services\DiscorevApiService;
use App\Services\ApiModelService;
use App\Models\Api\JobOffer;
use App\Models\Api\Recruiter;
use App\Models\Api\Application;
use App\Models\Api\Candidate;
use App\Models\Api\User;
use App\Models\Api\Media;
use Illuminate\View\View;
use Illuminate\Http\JsonResponse;

class JobOfferController extends Controller
{
    private DiscorevApiService $api;
    private ApiModelService $apiModelService;

    public function __construct(DiscorevApiService $api, ApiModelService $apiModelService)
    {
        $this->api = $api;
        $this->apiModelService = $apiModelService;
    }

    /**
     * Liste des offres d'emploi
     */
    public function index(Request $request): View
    {
        $jobOffersData = $this->api->get('job_offers');

        // Convertir en modèles JobOffer
        $jobOffers = collect($jobOffersData)->map(function ($jobData) {
            return JobOffer::fromApiData($jobData);
        });

        // Filtrer par statut si demandé
        if ($request->has('status')) {
            $jobOffers = $jobOffers->filter(function ($job) use ($request) {
                return $job->status === $request->status;
            });
        }

        // Filtrer par type d'emploi si demandé
        if ($request->has('employment_type')) {
            $jobOffers = $jobOffers->filter(function ($job) use ($request) {
                return $job->employmentType === $request->employment_type;
            });
        }

        // Trier par date de publication
        $jobOffers = $jobOffers->sortByDesc('publicationDate');

        return view('job_offers.index', compact('jobOffers'));
    }

    /**
     * Détail d'une offre d'emploi
     */
    public function show($id): View
    {
        $jobOfferData = $this->api->get("job_offers/{$id}");
        $recruiterData = $this->api->get("recruiters/{$jobOfferData['recruiterId']}");
        $applicationData = $this->api->get("applications/job_offer/{$id}");

        $jobOffer = $this->apiModelService->createJobOfferWithRelations(
            $jobOfferData,
            $recruiterData,
            $applicationData ?? null,
        );

        return view('job_offers.show', compact('jobOffer'));
    }

    /**
     * Offres d'emploi d'un recruteur
     */
    public function offersFromRecruiter($recruiterId): View
    {
        $jobOfferData = $this->api->get('job_offers/recruiter/' . $recruiterId);

        if (!$jobOfferData) {
            abort(404, 'Offre d\'emploi introuvable.');
        }

        // Créer le modèle JobOffer
        $jobOffer = JobOffer::fromApiData($jobOfferData);

        // Récupérer le recruteur
        if ($jobOffer->recruiterId) {
            $recruiterData = $this->api->get('recruiters/' . $jobOffer->recruiterId);
            if ($recruiterData) {
                $recruiter = Recruiter::fromApiData($recruiterData);
                $jobOffer->setRelation('recruiter', $recruiter);
            }
        }

        // Récupérer les candidatures si l'utilisateur est connecté et est le recruteur
        $applications = collect();
        if (auth()->check() && auth()->user()->isRecruiter()) {
            $applicationsData = $this->api->get('job_offers/' . $id . '/applications');
            if ($applicationsData) {
                $applications = collect($applicationsData)->map(function ($applicationData) {
                    $application = Application::fromApiData($applicationData);

                    // Récupérer les données du candidat
                    if (isset($applicationData['candidate'])) {
                        $candidate = Candidate::fromApiData($applicationData['candidate']);
                        $application->setRelation('candidate', $candidate);

                        // Récupérer les données de l'utilisateur
                        if (isset($applicationData['candidate']['user'])) {
                            $user = User::fromApiData($applicationData['candidate']['user']);
                            $candidate->setRelation('user', $user);
                        }
                    }

                    return $application;
                });
            }
        }

        return view('job_offers.show', compact('jobOffer', 'applications'));
    }

    /**
     * Créer une nouvelle offre d'emploi
     */
    public function create(): View
    {
        return view('job_offers.create');
    }

    /**
     * Enregistrer une nouvelle offre d'emploi
     */
    public function store(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'requirements' => 'nullable|string',
            'salaryRange' => 'nullable|string|max:50',
            'employmentType' => 'required|in:cdi,cdd,freelance,alternance,stage',
            'location' => 'required|string|max:255',
            'remote' => 'boolean',
            'expirationDate' => 'nullable|date|after:today',
        ]);

        // Ajouter les valeurs par défaut
        $validated['status'] = 'draft';
        $validated['publicationDate'] = now();

        // Envoyer à l'API
        $response = $this->api->post('job_offers', $validated);

        if ($response) {
            return response()->json([
                'success' => true,
                'message' => 'Offre d\'emploi créée avec succès.',
                'jobOffer' => JobOffer::fromApiData($response)
            ]);
        }

        return response()->json([
            'success' => false,
            'message' => 'Erreur lors de la création de l\'offre d\'emploi.'
        ], 500);
    }

    /**
     * Modifier une offre d'emploi
     */
    public function edit($id): View
    {
        $jobOfferData = $this->api->get('job_offers/' . $id);

        if (!$jobOfferData) {
            abort(404, 'Offre d\'emploi introuvable.');
        }

        $jobOffer = JobOffer::fromApiData($jobOfferData);

        return view('job_offers.edit', compact('jobOffer'));
    }

    /**
     * Mettre à jour une offre d'emploi
     */
    public function update(Request $request, $id): JsonResponse
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'requirements' => 'nullable|string',
            'salaryRange' => 'nullable|string|max:50',
            'employmentType' => 'required|in:cdi,cdd,freelance,alternance,stage',
            'location' => 'required|string|max:255',
            'remote' => 'boolean',
            'status' => 'required|in:active,inactive,draft',
            'expirationDate' => 'nullable|date|after:today',
        ]);

        // Envoyer à l'API
        $response = $this->api->put('job_offers/' . $id, $validated);

        if ($response) {
            return response()->json([
                'success' => true,
                'message' => 'Offre d\'emploi mise à jour avec succès.',
                'jobOffer' => JobOffer::fromApiData($response)
            ]);
        }

        return response()->json([
            'success' => false,
            'message' => 'Erreur lors de la mise à jour de l\'offre d\'emploi.'
        ], 500);
    }

    /**
     * Supprimer une offre d'emploi
     */
    public function destroy($id): JsonResponse
    {
        $response = $this->api->delete('job_offers/' . $id);

        if ($response) {
            return response()->json([
                'success' => true,
                'message' => 'Offre d\'emploi supprimée avec succès.'
            ]);
        }

        return response()->json([
            'success' => false,
            'message' => 'Erreur lors de la suppression de l\'offre d\'emploi.'
        ], 500);
    }

    /**
     * Postuler à une offre d'emploi
     */
    public function apply(Request $request, $id): JsonResponse
    {
        $validated = $request->validate([
            'notes' => 'nullable|string',
        ]);

        $applicationData = [
            'jobOfferId' => $id,
            'candidateId' => auth()->user()->candidate->id,
            'status' => 'sent',
            'dateApplied' => now(),
            'notes' => $validated['notes'] ?? null,
        ];

        $response = $this->api->post('applications', $applicationData);

        if ($response) {
            return response()->json([
                'success' => true,
                'message' => 'Candidature envoyée avec succès.',
                'application' => Application::fromApiData($response)
            ]);
        }

        return response()->json([
            'success' => false,
            'message' => 'Erreur lors de l\'envoi de la candidature.'
        ], 500);
    }

    /**
     * API pour récupérer les statistiques d'une offre
     */
    public function stats($id): JsonResponse
    {
        $jobOfferData = $this->api->get('job_offers/' . $id);

        if (!$jobOfferData) {
            return response()->json(['error' => 'Offre introuvable'], 404);
        }

        $jobOffer = JobOffer::fromApiData($jobOfferData);

        // Récupérer les candidatures
        $applicationsData = $this->api->get('job_offers/' . $id . '/applications');
        $applications = collect($applicationsData)->map(function ($applicationData) {
            return Application::fromApiData($applicationData);
        });

        $stats = [
            'totalApplications' => $applications->count(),
            'statusBreakdown' => [
                'sent' => $applications->where('status', 'sent')->count(),
                'viewed' => $applications->where('status', 'viewed')->count(),
                'interview' => $applications->where('status', 'interview')->count(),
                'pending' => $applications->where('status', 'pending')->count(),
                'rejected' => $applications->where('status', 'rejected')->count(),
                'accepted' => $applications->where('status', 'accepted')->count(),
            ],
            'jobOffer' => [
                'title' => $jobOffer->title,
                'status' => $jobOffer->getStatusLabel(),
                'employmentType' => $jobOffer->getEmploymentTypeLabel(),
                'isActive' => $jobOffer->isActive(),
                'isExpired' => $jobOffer->isExpired(),
            ]
        ];

        return response()->json($stats);
    }
}
