<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Services\DiscorevApiService;
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
     * Vue liste des offres
     */
    public function index(): View
    {
        return view('job_offers.index');
    }

    /**
     * API liste des offres
     */
    public function api(Request $request): JsonResponse
    {
        $offers = $this->api->get('job_offers', $request->query());

        return response()->json([
            'message' => 'Active job offers',
            'data'    => $offers,
        ]);
    }

    /**
     * Détails d’une offre
     */
    public function show($id)
    {
        $offer = $this->api->get("job_offers/{$id}");

        if (!$offer) {
            return redirect()->back()->withErrors(['error' => 'Offre introuvable.']);
        }

        $recruiter = null;
        if (isset($offer['recruiterId'])) {
            $recruiter = $this->api->get("recruiters/{$offer['recruiterId']}");
        }

        return view('job_offers.show', compact('offer', 'recruiter'));
    }

    /**
     * Mes offres (recruteur)
     */
    public function myOffers()
    {
        $recruiter = $this->api->get("recruiters/user/" . session('user.id'));

        if (!$recruiter || !isset($recruiter['id'])) {
            return redirect()->back()->withErrors(['error' => 'L\'utilisateur n\'est pas un recruteur']);
        }

        $offers = $this->api->get("recruiters/{$recruiter['id']}/job_offers", [
            'activeOnly' => 'false',
        ]);

        return view('account.recruiter.jobs.index', compact('offers'));
    }

    /**
     * Formulaire de création
     */
    public function create(): View
    {
        return view('job_offers.create');
    }

    /**
     * Créer une nouvelle offre
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'title'          => 'required|string|max:255',
            'description'    => 'required|string',
            'requirements'   => 'nullable|string',
            'salaryRange'    => 'nullable|string|max:50',
            'employmentType' => 'required|in:cdi,cdd,freelance,alternance,stage',
            'location'       => 'required|string|max:255',
            'salaryMin'      => 'nullable|numeric',
            'salaryMax'      => 'nullable|numeric',
            'remote'         => 'nullable|boolean',
            'startDate'      => 'nullable|date',
            'endDate'        => 'nullable|date',
            'expirationDate' => 'nullable|date',
            'status'         => 'required|string|in:active,inactive,draft',
        ]);

        if (session('user.accountType') !== 'recruiter') {
            return redirect()->back()->withErrors(['error' => 'L\'utilisateur n\'est pas un recruteur']);
        }

        $recruiter = $this->api->get("recruiters/user/" . session('user.id'));
        if (!$recruiter || !isset($recruiter['id'])) {
            return redirect()->back()->withErrors(['error' => 'Impossible de récupérer le recruteur']);
        }

        $data = array_merge($validated, ['recruiterId' => $recruiter['id']]);

        $offer = $this->api->post('job_offers', $data);

        if ($offer) {
            return redirect()->route('recruiter.jobs.index')->with('success', 'Offre créée avec succès.');
        }

        return redirect()->back()->withErrors(['error' => 'Erreur lors de la création de l\'offre.']);
    }

    /**
     * Éditer une offre
     */
    public function edit($id)
    {
        $offer = $this->api->get("job_offers/{$id}");

        if (!$offer) {
            return redirect()->back()->withErrors(['error' => 'Offre introuvable.']);
        }

        return view('account.recruiter.jobs.edit', compact('offer'));
    }

    /**
     * Mettre à jour une offre
     */
    public function update(Request $request, $id)
    {
        $validated = $request->validate([
            'title'          => 'required|string|max:255',
            'description'    => 'required|string',
            'requirements'   => 'nullable|string',
            'salaryRange'    => 'nullable|string|max:50',
            'employmentType' => 'required|in:cdi,cdd,freelance,alternance,stage',
            'location'       => 'required|string|max:255',
            'salaryMin'      => 'nullable|numeric',
            'salaryMax'      => 'nullable|numeric',
            'remote'         => 'nullable|boolean',
            'startDate'      => 'nullable|date',
            'endDate'        => 'nullable|date',
            'expirationDate' => 'nullable|date',
            'status'         => 'required|string|in:active,inactive,draft',
        ]);

        if (session('user.accountType') !== 'recruiter') {
            return redirect()->back()->withErrors(['error' => 'L\'utilisateur n\'est pas un recruteur']);
        }

        $recruiter = $this->api->get("recruiters/user/" . session('user.id'));
        if (!$recruiter || !isset($recruiter['id'])) {
            return redirect()->back()->withErrors(['error' => 'Impossible de récupérer le recruteur']);
        }

        $data = array_merge($validated, ['recruiterId' => $recruiter['id']]);

        $offer = $this->api->put("job_offers/{$id}", $data);

        if ($offer) {
            return redirect()->route('recruiter.jobs.index')->with('success', 'Offre modifiée avec succès.');
        }

        return redirect()->back()->withErrors(['error' => 'Erreur lors de la modification de l\'offre.']);
    }

    /**
     * Supprimer une offre
     */
    public function destroy($id)
    {
        $deleted = $this->api->delete("job_offers/{$id}");

        if ($deleted) {
            return redirect()->route('recruiter.jobs.index')->with('success', 'Offre supprimée avec succès.');
        }

        return redirect()->back()->withErrors(['error' => 'Erreur lors de la suppression de l\'offre.']);
    }
}
