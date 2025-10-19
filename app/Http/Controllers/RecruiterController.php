<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Services\DiscorevApiService;
use App\Models\Api\Recruiter;
use App\Models\Api\JobOffer;
use App\Helpers\NafHelper;
use App\Models\Api\RecruiterTeamMember;
use Illuminate\View\View;

class RecruiterController extends Controller
{
    private DiscorevApiService $api;

    public function __construct(DiscorevApiService $api)
    {
        $this->api = $api;
    }

    public function index(): View
    {
        // Récupérer les données depuis l'API
        $recruitersData = $this->api->get('recruiters') ?: [];
        $jobsData = $this->api->get('job_offers') ?: [];

        // Convertir les données API en modèles Recruiter
        $recruitersFromApi = collect($recruitersData)
            ->filter(fn($r) => is_array($r))
            ->map(fn($r) => Recruiter::fromApiData($r));

        // Créer un recruteur fictif pour tester le front
        $dummyRecruiter = new Recruiter();
        $dummyRecruiter->id = 999;
        $dummyRecruiter->companyName = "Entreprise Test";
        $dummyRecruiter->teamSize = "11-50";
        $dummyRecruiter->sector = "Aide à la personne";
        $dummyRecruiter->location = "Paris";
        $dummyRecruiter->website = "https://discorev.fr";
        $dummyRecruiter->contactPerson = "contact@exemple.com";
        $dummyRecruiter->phone = "0123456789";
        $dummyRecruiter->companyDescription = "Description de test pour la mise en page.";
        $dummyRecruiter->banner = null;
        $dummyRecruiter->logo = null;
        $dummyRecruiter->offersCount = 3;
        $dummyRecruiter->completionScore = 9;

        // Fusionner dummy + API
        $recruiters = collect([$dummyRecruiter])->merge($recruitersFromApi);

        // Grouper les offres par recruiter_id
        $jobsByRecruiter = collect($jobsData)
            ->filter(fn($j) => is_array($j))
            ->groupBy('recruiterId');

        // Attacher les offres et médias à chaque recruteur, calculer sectorName
        $recruiters = $recruiters->map(function ($recruiter) use ($jobsByRecruiter) {
            $jobsData = $jobsByRecruiter->get($recruiter->id, collect());
            $jobs = $jobsData->map(fn($jobData) => JobOffer::fromApiData($jobData));

            $medias = collect($recruiter->medias ?? []);
            $bannerMedia = $medias->firstWhere('type', 'company_banner');
            $logoMedia = $medias->firstWhere('type', 'company_logo');

            $recruiter->setRelation('jobOffers', $jobs);
            $recruiter->offersCount = $jobs->count();
            $recruiter->banner = $bannerMedia['filePath'] ?? null;
            $recruiter->logo = $logoMedia['filePath'] ?? null;

            // Calculer le score de complétion
            $fields = [
                $recruiter->companyName,
                $recruiter->siret ?? null,
                $recruiter->companyDescription ?? null,
                $recruiter->location ?? null,
                $recruiter->website ?? null,
                $recruiter->sector ?? null,
                $recruiter->teamSize ?? null,
                $recruiter->contactEmail ?? null,
                $recruiter->contactPhone ?? null,
            ];
            $recruiter->completionScore = collect($fields)->filter(fn($field) => !empty($field))->count();

            // Traduire le code NAF en libellé lisible
            $recruiter->sectorName = isset($recruiter->sector)
                ? NafHelper::getLabel($recruiter->sector)
                : null;

            return $recruiter;
        });

        // Récupérer les filtres depuis la requête
        $locationFilter = request('location');
        $sectorFilter = request('sector');
        $teamSizeFilter = request('team_size');

        // Appliquer les filtres
        $recruiters = $recruiters->filter(function ($recruiter) use ($locationFilter, $sectorFilter, $teamSizeFilter) {
            $matches = true;

            if ($locationFilter) {
                $matches = $matches && stripos($recruiter->location, $locationFilter) !== false;
            }
            if ($sectorFilter) {
                $matches = $matches && $recruiter->sectorName === $sectorFilter;
            }
            if ($teamSizeFilter) {
                $matches = $matches && $recruiter->teamSize === $teamSizeFilter;
            }

            return $matches;
        });

        // Trier par score de complétion descendant et éliminer les vides
        $recruiters = $recruiters
            ->filter(fn($r) => $r->completionScore > 0)
            ->sortByDesc('completionScore')
            ->values();

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

        if (!$recruiterData) {
            $fallbackView = 'companies.' . strtolower($identifier);
            if (view()->exists($fallbackView)) return view($fallbackView);
            return redirect()->back()->with('error', "Entreprise introuvable.");
        }

        $recruiter = Recruiter::fromApiData($recruiterData);
        $recruiter->sectorName = isset($recruiter->sector)
            ? NafHelper::getLabel($recruiter->sector)
            : null;
        $recruiterId = $recruiter['id'];

        // Job offers
        $jobOffers = $this->api->get("job_offers/recruiter/$recruiterId");
        $medias = collect($recruiter['medias'] ?? []);
        // Variables spécifiques pour la bannière et le logo
        $banner = $medias->firstWhere('type', 'company_banner');
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

        // Détermination de la vue en toute sécurité
        $view = null;

        if (!empty($recruiter['companyName'])) {
            $slugView = 'companies.' . $this->slugify($recruiter['companyName']);
            if (view()->exists($slugView)) {
                $view = $slugView;
            }
        }

        // Fallback vers la vue générique si aucune vue spécifique n'existe
        if (!$view) {
            $view = view()->exists('companies.show') ? 'companies.show' : null;
        }

        if ($view) {
            return view($view, compact('recruiter', 'sections', 'jobOffers', 'banner', 'logo'));
        }

        // Aucun fallback disponible
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
