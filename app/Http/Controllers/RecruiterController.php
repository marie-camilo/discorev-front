<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Services\DiscorevApiService;
use App\Services\ApiModelService;
use App\Models\Api\Recruiter;
use App\Models\Api\RecruiterTeamMember;
use App\Models\Api\JobOffer;
use App\Models\Api\Media;
use Carbon\Carbon;
use Illuminate\View\View;

class RecruiterController extends Controller
{
    private DiscorevApiService $api;
    private ApiModelService $apiModelService;

    public function __construct(DiscorevApiService $api, ApiModelService $apiModelService)
    {
        $this->api = $api;
        $this->apiModelService = $apiModelService;
    }

    function slugify(string $text): string
    {
        // 1. Convertit en ASCII
        $text = iconv('UTF-8', 'ASCII//TRANSLIT', $text);

        // 2. Met en minuscules
        $text = strtolower($text);

        // 3. Remplace tous les caractères non alphanumériques par des tirets
        $text = preg_replace('/[^a-z0-9]+/', '-', $text);

        // 4. Supprime les tirets au début et à la fin
        $text = trim($text, '-');

        return $text;
    }


    public function index(): View
    {
        $recruitersData = $this->api->get('recruiters');
        $jobsData = $this->api->get('job_offers');

        // Convertir les données API en modèles Eloquent avec leurs relations
        $recruiters = collect($recruitersData)->map(function ($recruiterData) {
            $recruiter = Recruiter::fromApiData($recruiterData);
            return $recruiter;
        });

        // Grouper les offres par recruiter_id
        $jobsByRecruiter = collect($jobsData)->groupBy('recruiterId');

        // Injecter les jobs dans chaque recruiter
        $recruiters->each(function ($recruiter) use ($jobsByRecruiter) {
            $jobsData = $jobsByRecruiter->get($recruiter->id, collect());

            // Convertir les jobs en modèles JobOffer
            $jobs = $jobsData->map(function ($jobData) {
                return JobOffer::fromApiData($jobData);
            });

            $recruiter->setRelation('jobOffers', $jobs);
            $recruiter->offersCount = $jobs->count();
        });

        return view('companies.index', compact('recruiters'));
    }

    /**
     * Met à jour les informations du recruiter via l'API.
     */
    public function update(Request $request, $id)
    {
        $validated = $request->validate([
            'companyName' => 'required|string|max:255',
            'siret' => 'nullable|string|max:20',
            'companyDescription' => 'nullable|string',
            'location' => 'nullable|string|max:255',
            'website' => 'nullable|string|max:255',
            'sector' => 'nullable|string|max:100',
            'teamSize' => 'nullable|string|max:50',
            'contactPhone' => 'nullable|string|min:20',
            'contactEmail' => 'nullable|string',
        ]);

        // Envoi de la requête PUT à l'API
        $response = $this->api->put('recruiters/' . $id, $validated);
        if ($response->successful()) {
            return redirect()->back()->with('success', 'Entreprise mise à jour avec succès.');
        }

        return redirect()->back()->with('error', "Erreur lors de la mise à jour de l'entreprise.");
    }

    public function show($identifier)
    {
        // Récupère les données du recruiter depuis l'API
        $recruiterData = is_numeric($identifier)
            ? $this->api->get("recruiters/$identifier")
            : $this->api->get("recruiters/company/$identifier");

        $json = $recruiterData->json();
        $recruiter = $json['data'][0];

        if (!$recruiter) {
            $fallbackView = 'companies.' . strtolower($identifier);
            if (view()->exists($fallbackView)) return view($fallbackView);
            return redirect()->back()->with('error', "Entreprise introuvable.");
        }
        $recruiterId = $recruiter['id'];

        // Job offers
        $jobOffers = $this->api->get("job_offers/recruiter/$recruiterId")->json()['data'];
        $medias = collect($recruiter['medias'] ?? []);
        // Variables spécifiques pour la bannière et le logo
        $bannerMedia = $medias->firstWhere('type', 'company_banner');
        $logo = $medias->firstWhere('type', 'company_logo');

        $sectionsConfig = [
            [
                'key' => 'companyDescription',
                'label' => "L'entreprise",
                'anchor' => 'company',
                'type' => 'text',
                'data' => $recruiter['companyDescription'] ?? null
            ],
            [
                'key' => 'teamMembers',
                'label' => "L'équipe",
                'anchor' => 'equipe',
                'type' => 'array',
                'data' => $recruiter['teamMembers'] ?? []
            ],
            [
                'key' => 'video',
                'label' => 'Vidéo',
                'anchor' => 'video',
                'type' => 'video',
                'data' => $medias->where('type', 'company_video')->where('context', 'company_page')
            ],
            [
                'key' => 'medias',
                'label' => 'Médias',
                'anchor' => 'medias',
                'type' => 'media',
                'data' => $medias->where('type', 'company_image')->where('context', 'company_page')
            ]
        ];

        $sections = collect($sectionsConfig)
            ->filter(function ($section) {
                $data = $section['data'];
                if ($data instanceof \Illuminate\Support\Collection) {
                    return $data->isNotEmpty();
                }
                if (is_array($data)) {
                    return !empty($data);
                }
                return !empty($data);
            })
            ->values()
            ->all();
        // Choix de la vue
        $view = 'companies.' . $this->slugify($recruiter['companyName']);
        if (view()->exists($view)) return view($view, compact('recruiter', 'sections', 'jobOffers', 'bannerMedia', 'logo'));
        if (view()->exists('companies.show')) return view('companies.show', compact('recruiter', 'sections', 'jobOffers', 'bannerMedia', 'logo'));

        return redirect()->back()->with('error', "Aucune vue disponible pour afficher cette entreprise.");
    }

    function slugify(string $text): string
    {
        // 1. Convertit en ASCII
        $text = iconv('UTF-8', 'ASCII//TRANSLIT', $text);

        // 2. Met en minuscules
        $text = strtolower($text);

        // 3. Remplace tous les caractères non alphanumériques par des tirets
        $text = preg_replace('/[^a-z0-9]+/', '-', $text);

        // 4. Supprime les tirets au début et à la fin
        $text = trim($text, '-');

        return $text;
    }
}
