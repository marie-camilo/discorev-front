<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Api\JobOffer;
use App\Models\Api\Recruiter;
use Illuminate\Http\Request;
use App\Services\DiscorevApiService;
use Illuminate\Auth\Recaller;
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

        // comme $offers est déjà un array/collection → on le retourne tel quel
        return response()->json([
            'message' => 'Active job offers',
            'data'    => $offers,
        ]);
    }


    public function show($id)
    {
        $offerResponse = $this->api->getOne('job_offers/' . $id);
        $offer = JobOffer::fromApiData($offerResponse);

        if ($offer) {
            $recruiterId =  $offer['recruiterId'];
            $recruiterResponse = $this->api->get('recruiters/' . $recruiterId);
            $recruiter = Recruiter::fromApiData($recruiterResponse);
            return view('job_offers.show', compact('offer', 'recruiter'));
        }

        redirect()->back()->withErrors(['error' => 'Erreur lors de la récupération des offres.']);
    }

    public function myOffers()
    {
        $recruiter = $this->api->getOne('recruiters/user/' . session('user.id'));

        if (!$recruiter) {
            return redirect()->back()->withErrors(['error' => 'L\'utilisateur n\'est pas un recruteur']);
        }

        $offers = $this->api->get('recruiters/' . $recruiter['id'] . '/job_offers', [
            'activeOnly' => 'false' // ✅ récupère tout
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

    /**
     * Enregistrer une nouvelle offre d'emploi
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'requirements' => 'nullable|string',
            'salaryRange' => 'nullable|string|max:50',
            'employmentType' => 'required|in:cdi,cdd,freelance,alternance,stage',
            'location' => 'required|string|max:255',
            'salaryMin' => 'nullable|numeric',
            'salaryMax' => 'nullable|numeric',
            'requirements' => 'nullable|string',
            'employmentType' => 'required|string|in:cdi,cdd,freelance,alternance,stage',
            'remote' => 'nullable|boolean',
            'startDate' => 'nullable|date',
            'endDate' => 'nullable|date',
            'expirationDate' => 'nullable|date',
            'status' => 'required|string|in:active,inactive,draft',
        ]);


        if (session('user.accountType') !== 'recruiter') {
            return redirect()->back()->withErrors(['error' => 'L\'utilisateur n\'est pas un recruteur']);
        }

        $recruiter = $this->api->getOne('recruiters/user/' . session('user.id'));

        $data = array_merge($validated, [
            'recruiterId' => $recruiter['id'],
        ]);

        $response = $this->api->post('job_offers', $data);

        if ($response->successful()) {
            return redirect()->route('recruiter.jobs.index')->with('success', 'Offre créée avec succès.');
        }
        return redirect()->back()->withErrors(['error' => 'Erreur lors de la création de l\'offre.']);
    }

    /**
     * Modifier une offre d'emploi
     */
    public function edit($id)
    {
        $offer = $this->api->getOne('job_offers/' . $id);
        if ($offer) {
            return view('account.recruiter.jobs.edit', compact('offer'));
        }

        redirect()->back()->withErrors(['error' => 'Erreur lors de la récupération de l\'offre.']);
    }

    public function update(Request $request, $id)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'requirements' => 'nullable|string',
            'salaryRange' => 'nullable|string|max:50',
            'employmentType' => 'required|in:cdi,cdd,freelance,alternance,stage',
            'location' => 'required|string|max:255',
            'salaryMin' => 'nullable|numeric',
            'salaryMax' => 'nullable|numeric',
            'requirements' => 'nullable|string',
            'employmentType' => 'required|string|in:cdi,cdd,freelance,alternance,stage',
            'remote' => 'nullable|boolean',
            'startDate' => 'nullable|date',
            'endDate' => 'nullable|date',
            'expirationDate' => 'nullable|date',
            'status' => 'required|string|in:active,inactive,draft',
        ]);


        if (session('user.accountType') !== 'recruiter') {
            return redirect()->back()->withErrors(['error' => 'L\'utilisateur n\'est pas un recruteur']);
        }

        $recruiter = $this->api->get('recruiters/user/' . session('user.id'));

        $data = array_merge($validated, [
            'recruiterId' => $recruiter['id'],
        ]);

        $response = $this->api->put('job_offers/' . $id, $data);

        if ($response->successful()) {
            return redirect()->route('recruiter.jobs.index')->with('success', 'Offre modifiée avec succès.');
        }

        return redirect()->back()->withErrors(['error' => 'Erreur lors de la modification de l\'offre.']);
    }

    /**
     * Supprimer une offre d'emploi
     */
    public function destroy($id)
    {
        $response = $this->api->delete('job_offers/' . $id);
        if ($response->successful()) {
            return redirect()->route('recruiter.jobs.index')->with('success', 'Offre supprimée avec succès.');
        }

        return redirect()->back()->withErrors(['error' => 'Erreur lors de la suppression de l\'offre.']);
    }
}
