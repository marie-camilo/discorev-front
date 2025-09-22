<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Services\DiscorevApiService;
use App\Services\ApiModelService;
use Illuminate\View\View;
use Illuminate\Http\JsonResponse;

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
        $response = $this->api->get('job_offers', $request->query());
        return response()->json($response->json());
    }


    public function show($id)
    {
        $response = $this->api->get('job_offers/' . $id);

        if ($response->successful()) {
            $offer = $response->json()['data'];
            $recruiterId =  $response->json()['data']['recruiterId'];
            $recruiter = $this->api->get('recruiters/' . $recruiterId)->json()['data'];
            return view('job_offers.show', compact('offer', 'recruiter'));
        }

        redirect()->back()->withErrors(['error' => 'Erreur lors de la récupération des offres.']);
    }

    public function myOffers()
    {
        $recruiter = $this->api->get('recruiters/user/' . session('user.id'))->json()['data'];

        if (!$recruiter) {
            return redirect()->back()->withErrors(['error' => 'L\'utilisateur n\'est pas un recruteur']);
        }

        $response = $this->api->get('recruiters/' . $recruiter['id'] . '/job_offers', [
            'activeOnly' => 'false' // ✅ récupère tout
        ]);

        if ($response->successful()) {
            $offers = $response->json()['data'];
            return view('account.recruiter.jobs.index', compact('offers'));
        }

        return redirect()->back()->withErrors(['error' => 'Erreur lors de la récupération des offres.']);
    }


    public function create()
    {
        return view('job_offers.create');
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

        $recruiterId = $this->api->get('recruiters/user/' . session('user.id'))->json()['data']['id'];

        $data = array_merge($validated, [
            'recruiterId' => $recruiterId,
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
        $response = $this->api->get('job_offers/' . $id);
        if ($response->successful()) {
            $offer = $response->json()['data'];
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

        $recruiterId = $this->api->get('recruiters/user/' . session('user.id'))->json()['data']['id'];

        $data = array_merge($validated, [
            'recruiterId' => $recruiterId,
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
