<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Services\DiscorevApiService;
use App\Models\Api\Recruiter;
use App\Models\Api\JobOffer;
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
        $recruitersData = $this->api->get('recruiters');
        $jobsData = $this->api->get('job_offers');

        $recruiters = collect($recruitersData['data'] ?? [])->map(function ($recruiterData) {
            return Recruiter::fromApiData($recruiterData);
        });

        $jobsByRecruiter = collect($jobsData['data'] ?? [])->groupBy('recruiterId');

        $recruiters->each(function ($recruiter) use ($jobsByRecruiter) {
            $jobsData = $jobsByRecruiter->get($recruiter->id, collect());
            $jobs = $jobsData->map(fn($jobData) => JobOffer::fromApiData($jobData));
            $recruiter->setRelation('jobOffers', $jobs);
            $recruiter->offersCount = $jobs->count();
        });

        return view('companies.index', compact('recruiters'));
    }

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
            'contactPhone' => 'nullable|string|max:20',
            'contactEmail' => 'nullable|email',
        ]);

        $response = $this->api->put("recruiters/$id", $validated);

        if (!empty($response['success']) && $response['success']) {
            return back()->with('success', 'Entreprise mise à jour avec succès.');
        }

        return back()->with('error', "Erreur lors de la mise à jour de l'entreprise.");
    }

    public function show($identifier)
    {
        $recruiterData = is_numeric($identifier)
            ? $this->api->get("recruiters/$identifier")
            : $this->api->get("recruiters/company/$identifier");

        $recruiter = $recruiterData['data'][0] ?? null;
        if (!$recruiter) {
            $fallbackView = 'companies.' . strtolower($identifier);
            return view()->exists($fallbackView)
                ? view($fallbackView)
                : back()->with('error', "Entreprise introuvable.");
        }

        $recruiterId = $recruiter['id'];
        $jobOffers = $this->api->get("job_offers/recruiter/$recruiterId")['data'] ?? [];

        $medias = collect($recruiter['medias'] ?? []);
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
            ->filter(fn($section) => !empty($section['data']))
            ->values()
            ->all();

        $view = 'companies.' . $this->slugify($recruiter['companyName']);
        if (view()->exists($view)) {
            return view($view, compact('recruiter', 'sections', 'jobOffers', 'bannerMedia', 'logo'));
        }

        if (view()->exists('companies.show')) {
            return view('companies.show', compact('recruiter', 'sections', 'jobOffers', 'bannerMedia', 'logo'));
        }

        return back()->with('error', "Aucune vue disponible pour afficher cette entreprise.");
    }

    private function slugify(string $text): string
    {
        $text = iconv('UTF-8', 'ASCII//TRANSLIT', $text);
        $text = strtolower($text);
        $text = preg_replace('/[^a-z0-9]+/', '-', $text);
        return trim($text, '-');
    }
}
