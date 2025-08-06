<?php

namespace App\Http\Controllers;

use App\Models\Recruiter;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Services\DiscorevApiService;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Http;
use Carbon\Carbon;

class RecruiterController extends Controller
{
    private DiscorevApiService $api;

    public function __construct(DiscorevApiService $api)
    {
        $this->api = $api;
    }

    public function index()
    {
        $response = $this->api->get('recruiters');
        if ($response->successful()) {
            $recruiters = $response->json()['data'];
            return view('companies.index', compact('recruiters'));
        }

        abort(500, 'Erreur lors de la récupération des entreprises.');
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
            'contactPerson' => 'nullable|string',
        ]);

        // Envoi de la requête PUT à l'API
        $response = $this->api->put('recruiters/' . $id, $validated);

        if ($response->successful()) {
            return redirect()->back()->with('success', 'Entreprise mise à jour avec succès.');
        }

        return redirect()->back()->with('error', "Erreur lors de la mise à jour de l'entreprise.");
    }

    public function show($name)
    {
        $response = $this->api->get('recruiters/company/' . $name);

        if (!$response->successful()) {
            // Fallback custom view même si API échoue (pour des landing pages personnalisées)
            $fallbackView = 'companies.' . strtolower($name);
            if (view()->exists($fallbackView)) {
                return view($fallbackView); // Pas de compact car pas de data
            }

            // Sinon erreur
            abort(404, "Entreprise introuvable.");
        }

        // Récupération des données (après vérif succès)
        $recruiter = $response->json()['data'] ?? null;

        if (!$recruiter) {
            abort(500, "Données entreprise manquantes.");
        }

        // Médias
        $bannerMedia = collect($recruiter['medias'])->firstWhere('type', 'company_banner');
        $logo = collect($recruiter['medias'])->firstWhere('type', 'company_logo');
        $jobsResponse = $this->api->get('job_offers/recruiter/' . $recruiter['id']);
        $jobOffers = collect($jobsResponse->json()['data'])
            ->filter(function ($job) {
                return $job['status'] === 'active';
            })
            ->map(function ($job) {
                $job['publicationDate'] = Carbon::parse($job['publicationDate'])->translatedFormat('d/m/Y');
                return $job;
            }) ?? null;
        // Sections dynamiques
        $sections = [];

        if (!empty($recruiter['companyDescription'])) {
            $sections[] = [
                'key' => 'companyDescription',
                'label' => "L'entreprise",
                'anchor' => 'company',
                'type' => 'text',
            ];
        }

        if (!empty($recruiter['teamMembers']) && is_array($recruiter['teamMembers']) && count($recruiter['teamMembers']) > 0) {
            $sections[] = [
                'key' => 'teamMembers',
                'label' => "L'équipe",
                'anchor' => 'equipe',
                'type' => 'array',
            ];
        }

        if (!empty($recruiter['medias']) && is_array($recruiter['medias'])) {
            $images = collect($recruiter['medias'])->where('type', 'company_image')->where('context', 'company_page');
            if ($images->isNotEmpty()) {
                $sections[] = [
                    'key' => 'medias',
                    'label' => 'Médias',
                    'anchor' => 'medias',
                    'type' => 'media',
                ];
            }

            $videos = collect($recruiter['medias'])->where('type', 'company_video')->where('context', 'company_page');
            if ($videos->isNotEmpty()) {
                $sections[] = [
                    'key' => 'video',
                    'label' => 'Vidéo',
                    'anchor' => 'video',
                    'type' => 'video',
                ];
            }
        }

        // Vue personnalisée ?
        $customView = 'companies.' . str_replace(' ', '-', strtolower(iconv('UTF-8', 'ASCII//TRANSLIT', $recruiter['companyName'])));
        if (view()->exists($customView)) {
            return view($customView, compact('recruiter', 'logo', 'bannerMedia', 'sections', 'jobOffers'));
        }

        // Vue par défaut
        if (view()->exists('companies.show')) {
            return view('companies.show', compact('recruiter', 'logo', 'bannerMedia', 'sections', 'jobOffers'));
        }

        // Fallback ultime
        abort(500, 'Aucune vue disponible pour afficher cette entreprise.');
    }
}
