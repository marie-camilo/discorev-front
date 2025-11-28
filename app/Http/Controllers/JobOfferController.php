<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Api\JobOffer;
use App\Models\Api\Recruiter;
use Illuminate\Http\Request;
use App\Services\DiscorevApiService;
use Illuminate\View\View;

class JobOfferController extends Controller
{
    private DiscorevApiService $api;

    public function __construct(DiscorevApiService $api)
    {
        $this->api = $api;
    }

    /**
     * Liste des offres d'emploi
     */
    public function index(): View
    {
        return view('job_offers.index');
    }

    public function api(Request $request)
    {
        $offers = $this->api->get('job_offers', $request->query());

        return response()->json([
            'message' => 'Active job offers',
            'data'    => $offers,
        ]);
    }

    /**
     * Affichage d'une offre avec les infos du recruteur et logo
     */
    public function show($id)
    {
        $offerResponse = $this->api->getOne('job_offers/' . $id);
        $offer = JobOffer::fromApiData($offerResponse);

        if (!$offer) {
            return redirect()->back()->withErrors(['error' => 'Erreur lors de la récupération de l\'offre.']);
        }

        // Par défaut, recruteur vide
        $recruiter = (object) [
            'companyName' => 'Entreprise inconnue',
            'website' => null,
            'logo' => null,
        ];

        if (!empty($offer['recruiterId'])) {
            $recruiterResponse = $this->api->get('recruiters/' . $offer['recruiterId']);
            if ($recruiterResponse) {
                $recruiter = Recruiter::fromApiData($recruiterResponse);

                // Récupère les médias
                $medias = collect($recruiterResponse['medias'] ?? []);
                $logoMedia = $medias->firstWhere('type', 'company_logo');
                $recruiter->logo = $logoMedia['filePath'] ?? null;
            }
        }

        return view('job_offers.show', compact('offer', 'recruiter'));
    }

    /**
     * Offres du recruteur connecté
     */
    public function myOffers()
    {
        $recruiter = $this->api->getOne('recruiters/user/' . session('user.id'));

        if (!$recruiter) {
            return redirect()->back()->withErrors(['error' => 'L\'utilisateur n\'est pas un recruteur']);
        }

        $offers = $this->api->get('recruiters/' . $recruiter['id'] . '/job_offers', [
            'activeOnly' => 'false'
        ]);

        if ($offers) {
            $offers = JobOffer::fromApiCollection($offers);
            return view('account.recruiter.jobs.index', compact('offers'));
        }

        return redirect()->back()->withErrors(['error' => 'Erreur lors de la récupération des offres.']);
    }

    public function create()
    {
        return view('account.recruiter.jobs.create');
    }

    public function store(Request $request)
    {
        $validated = $this->validateJobOffer($request);

        if (session('user.accountType') !== 'recruiter') {
            return redirect()->back()->withErrors(['error' => 'L\'utilisateur n\'est pas un recruteur']);
        }

        $recruiter = $this->api->getOne('recruiters/user/' . session('user.id'));

        $data = array_merge($validated, ['recruiterId' => $recruiter['id']]);
        $response = $this->api->post('job_offers', $data);

        if ($response->successful()) {
            return redirect()->route('recruiter.jobs.index')->with('success', 'Offre créée avec succès.');
        }

        return redirect()->back()->withErrors(['error' => 'Erreur lors de la création de l\'offre.']);
    }

    public function edit($id)
    {
        $offer = $this->api->getOne('job_offers/' . $id);
        if ($offer) {
            return view('account.recruiter.jobs.edit', compact('offer'));
        }

        return redirect()->back()->withErrors(['error' => 'Erreur lors de la récupération de l\'offre.']);
    }

    public function update(Request $request, $id)
    {
        $validated = $this->validateJobOffer($request);

        if (session('user.accountType') !== 'recruiter') {
            return redirect()->back()->withErrors(['error' => 'L\'utilisateur n\'est pas un recruteur']);
        }

        $recruiter = $this->api->get('recruiters/user/' . session('user.id'));
        $data = array_merge($validated, ['recruiterId' => $recruiter['id']]);

        $response = $this->api->put('job_offers/' . $id, $data);

        if ($response->successful()) {
            return redirect()->route('recruiter.jobs.index')->with('success', 'Offre modifiée avec succès.');
        }

        return redirect()->back()->withErrors(['error' => 'Erreur lors de la modification de l\'offre.']);
    }

    public function destroy($id)
    {
        $response = $this->api->delete('job_offers/' . $id);
        if ($response->successful()) {
            return redirect()->route('recruiter.jobs.index')->with('success', 'Offre supprimée avec succès.');
        }

        return redirect()->back()->withErrors(['error' => 'Erreur lors de la suppression de l\'offre.']);
    }

    /**
     * Validation réutilisable pour JobOffer
     */
    private function validateJobOffer(Request $request): array
    {
        return $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'requirements' => 'nullable|string',
            'employmentType' => 'required|string|in:cdi,cdd,freelance,alternance,stage',
            'location' => 'required|string|max:255',
            'salaryMin' => 'nullable|numeric',
            'salaryMax' => 'nullable|numeric',
            'remote' => 'nullable|boolean',
            'startDate' => 'nullable|date',
            'endDate' => 'nullable|date',
            'expirationDate' => 'nullable|date',
            'status' => 'required|string|in:active,inactive,draft',
        ]);
    }
}
