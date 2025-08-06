<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use App\Services\DiscorevApiService;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;

class JobOfferController extends Controller
{
    private DiscorevApiService $api;

    public function __construct(DiscorevApiService $api)
    {
        $this->api = $api;
    }

    public function index()
    {
        $response = $this->api->get('job_offers');

        if ($response->successful()) {
            $offers = $response->json()['data'];
            return view('job_offers.index', compact('offers'));
        }

        abort(500, 'Erreur lors de la récupération des offres.');
    }

    public function show($id)
    {
        $response = $this->api->get('job_offers/' . $id);

        if ($response->successful()) {
            $offer = $response->json()['data']['jobOffer'];
            $recruiter = $response->json()['data']['recruiter'];
            return view('job_offers.show', compact('offer', 'recruiter'));
        }

        abort(500, 'Erreur lors de la récupération des offres.');
    }

    public function myOffers()
    {
        $recruiter = auth()->user()->recruiter;

        if ($recruiter) {
            $recruiterId = $recruiter->id;
        } else {
            Redirect::back()->withErrors(['error' => 'L\'utilisateur n\'est pas un recruteur']);
        }

        $response = $this->api->get('job_offers/recruiter/' . $recruiterId);
        if ($response->successful()) {
            $offers = $response->json()['data'];
            return view('account.recruiter.jobs.index', compact('offers'));
        }

        abort(500, 'Erreur lors de la récupération des offres.');
    }

    public function create()
    {
        return view('account.recruiter.jobs.create');
    }

    public function store(Request $request,)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'location' => 'required|string|max:255',
            'salary' => 'nullable|numeric',
            'requirements' => 'nullable|string',
            'salaryRange' => 'nullable|string|max:255',
            'employmentType' => 'required|string|in:cdi,cdd,freelance,alternance,stage',
            'remote' => 'nullable|boolean',
            'expirationDate' => 'nullable|date',
            'status' => 'required|string|in:active,inactive,draft',
        ]);

        $recruiter = auth()->user()->recruiter;
        if (!$recruiter) {
            return Redirect::back()->withErrors(['error' => 'L\'utilisateur n\'est pas un recruteur']);
        }

        $data = array_merge($validated, [
            'recruiterId' => $recruiter->id,
        ]);
        $response = $this->api->post('job_offers', $data);

        if ($response->successful()) {
            return redirect()->route('recruiter.jobs.index')->with('success', 'Offre créée avec succès.');
        }
        return Redirect::back()->withErrors(['error' => 'Erreur lors de la création de l\'offre.']);
    }

    public function edit($id)
    {
        $response = $this->api->get('job_offers/' . $id);

        if ($response->successful()) {
            $offer = $response->json()['data']['jobOffer'];
            return view('account.recruiter.jobs.edit', compact('offer'));
        }

        abort(500, 'Erreur lors de la récupération de l\'offre.');
    }

    public function update(Request $request, $id)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'location' => 'required|string|max:255',
            'salary' => 'nullable|numeric',
            'requirements' => 'nullable|string',
            'salaryRange' => 'nullable|string|max:255',
            'employmentType' => 'required|string|in:cdi,cdd,freelance,alternance,stage',
            'remote' => 'nullable|boolean',
            'expirationDate' => 'nullable|date',
            'status' => 'required|string|in:active,inactive,draft',
        ]);

        $recruiter = auth()->user()->recruiter;
        if (!$recruiter) {
            return Redirect::back()->withErrors(['error' => 'L\'utilisateur n\'est pas un recruteur']);
        }

        $data = array_merge($validated, [
            'recruiterId' => $recruiter->id,
        ]);

        $response = $this->api->put('job_offers/' . $id, $data);

        if ($response->successful()) {
            return redirect()->route('recruiter.jobs.index')->with('success', 'Offre modifiée avec succès.');
        }

        return Redirect::back()->withErrors(['error' => 'Erreur lors de la modification de l\'offre.']);
    }

    public function destroy($id)
    {
        $response = $this->api->delete('job_offers/' . $id);

        if ($response->successful()) {
            return redirect()->route('recruiter.jobs.index')->with('success', 'Offre supprimée avec succès.');
        }

        return Redirect::back()->withErrors(['error' => 'Erreur lors de la suppression de l\'offre.']);
    }
}
