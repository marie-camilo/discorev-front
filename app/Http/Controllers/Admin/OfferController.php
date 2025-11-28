<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Services\DiscorevApiService;
use App\Models\Api\JobOffer;
use App\Models\Api\Recruiter;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class OfferController extends Controller
{
    private DiscorevApiService $api;

    public function __construct(DiscorevApiService $api)
    {
        $this->api = $api;
    }

    public function index()
    {
        $user = Session::get('user');

        // Récupération des recruteurs et indexation par ID
        $recruitersApi = $this->api->get('recruiters');
        $recruitersById = collect($recruitersApi)->keyBy('id');
        $recruiters = Recruiter::fromApiCollection($recruitersById);

        // Récupération des offres
        $offersApi = $this->api->get('job_offers/all');
        $offers = JobOffer::fromApiCollection($offersApi);

        // Liaison : ajoute $offer->recruiter
        $offers->transform(function ($offer) use ($recruiters) {
            $offer->recruiter = $recruiters->firstWhere('id', $offer->recruiterId);
            return $offer;
        });
        return view('admin.offers.index', compact('offers', 'user'));
    }


    public function update(Request $request, $id)
    {
        // récupère l'offre depuis ton système API
        $offer = $this->api->get("job_offers/$id");

        if (!$offer) {
            return back()->with('error', 'Offre introuvable');
        }

        // données mises à jour
        $payload = $request->validate([
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

        try {
            $response = $this->api->put(
                'job_offers/' . $id,
                $payload
            );
            if (!$response->successful()) {
                return redirect()->back()
                    ->withInput()
                    ->with('error', "Erreur lors de la mise à jour de l'offre.");
            }

            return back()->with('success', 'Offre mise à jour ✔️');
        } catch (\Throwable $th) {
            //throw $th;
            return redirect()->back()
                ->with('error', 'Une erreur est survenue lors de la mise à jour.');
        }
    }



    public function delete($id)
    {
        $this->api->delete("job_offers/$id");

        return redirect()->back()->with('success', 'Offre supprimée');
    }
}
