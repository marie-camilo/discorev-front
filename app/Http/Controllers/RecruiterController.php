<?php

namespace App\Http\Controllers;

use App\Models\Recruiter;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Services\DiscorevApiService;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Http;

class RecruiterController extends Controller
{

    public function index(DiscorevApiService $api)
    {
        $response = $api->get('recruiters');
        if ($response->successful()) {
            $recruiters = $response->json()['data'];
            return view('companies.index', compact('recruiters'));
        }

        abort(500, 'Erreur lors de la récupération des entreprises.');
    }

    /**
     * Met à jour les informations du recruiter via l'API.
     */
    public function update(Request $request, DiscorevApiService $api, $id)
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
        $response = $api->put('recruiters/' . $id, $validated);

        if ($response->successful()) {
            return redirect()->back()->with('success', 'Entreprise mise à jour avec succès.');
        }

        return redirect()->back()->with('error', "Erreur lors de la mise à jour de l'entreprise.");
    }

    public function show(DiscorevApiService $api, $name)
    {
        $response = $api->get('recruiters/company/' . $name);

        if ($response->successful()) {
            $recruiter = $response->json()['data'];
            $customView = 'companies.' . strtolower($recruiter['companyName']);
            if (view()->exists($customView)) {
                return view($customView);
            }
            if (view()->exists('companies.show')) {
                return view('companies.show', compact('recruiter'));
            }
        } else {
            $customView = 'companies.' . strtolower($name);
            if (view()->exists($customView)) {
                return view($customView);
            }
        }

        abort(500, 'Erreur lors de la récupération de l\'entreprise.');
    }
}
