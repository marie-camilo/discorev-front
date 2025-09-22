<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\DiscorevApiService;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Session;

class ProfileController extends Controller
{

    private DiscorevApiService $api;

    public function __construct(DiscorevApiService $api)
    {
        $this->api = $api;
    }

    public function index()
    {
        return view('account.profile.index');
    }

    public function edit()
    {
        $userAuth = Auth::user();
        $user = $this->api->get('users/' . $userAuth->id);
        $type = $userAuth->accountType;

        // Définition des onglets par type de compte
        $tabs = match ($type) {
            'recruiter' => [
                'company' => ['label' => 'Mon entreprise', 'icon' => 'corporate_fare'],
                'account-recruiter' => ['label' => 'Mon compte', 'icon' => 'account_circle'],
                'page' => ['label' => 'Ma page', 'icon' => 'monitor'],
                'help' => ['label' => 'Aide et support', 'icon' => 'help'],
            ],
            'candidate' => [
                'profile' => ['label' => 'Mon profil', 'icon' => 'face'],
                'account-candidate' => ['label' => 'Mon compte', 'icon' => 'account_circle'],
                'cv' => ['label' => 'Mon CV', 'icon' => 'contact_page'],
                'help' => ['label' => 'Aide et support', 'icon' => 'help'],
            ],
            'admin' => [
                'dashboard' => ['label' => 'Tableau de bord', 'icon' => 'dashboard'],
                'users' => ['label' => 'Utilisateurs', 'icon' => 'group'],
                'settings' => ['label' => 'Paramètres', 'icon' => 'settings'],
                'help' => ['label' => 'Aide et support', 'icon' => 'help'],
            ],
            default => []
        };

        // Définition de l'endpoint par type de compte
        $endpoint = match ($type) {
            'recruiter' => 'recruiters/user/',
            'candidate' => 'candidates/user/',
            'admin' => 'admins/user/',
            default => null
        };

        if (!$endpoint) {
            return back()->with('error', 'Type de compte invalide.');
        }

        // Appel API pour récupérer les données
        $response = $this->api->get($endpoint . $userAuth->id);
        $json = $response->json();
        $data = $json['data'];
        if (!$response->successful() || !isset($data)) {
            $errorMsg = match ($type) {
                'recruiter' => 'Impossible de récupérer les données du recruteur.',
                'candidate' => 'Impossible de récupérer les données du candidat.',
                'admin' => 'Impossible de récupérer les données de l’administrateur.',
                default => 'Erreur lors de la récupération des données.'
            };
            return back()->with('error', $errorMsg);
        }

        return view('account.profile.edit', [
            'recruiter' => $type === 'recruiter' ? $data : null,
            'candidate' => $type === 'candidate' ? $data : null,
            'admin' => $type === 'admin' ? $data : null,
            'tabs' => $tabs,
            'type' => $type,
            'user' => $user,
        ]);
    }


    public function showCompletionForm()
    {
        return view('account.profile.complete');
    }

    public function update(Request $request, $id)
    {
        // Validation des champs
        $validated = $request->validate([
            'firstName'   => 'nullable|string',
            'lastName'    => 'nullable|string',
            'email'       => 'required|email',
            'phoneNumber' => 'nullable|string',
        ]);

        // Envoyer la mise à jour à l'API
        $response = $this->api->put('users/' . $id, $validated);

        if ($response->successful()) {
            $userData = $response->json()['data'] ?? null;
            if (!$userData) {
                // Cas où l'API ne renvoie pas la data correctement
                return back()->with('warning', 'La mise à jour a été effectuée mais les données n’ont pas été récupérées.');
            }
            Session::put('user', $userData);

            return back()->with('success', 'Informations mises à jour avec succès.');
        }

        // Gestion des erreurs
        $errorMessage = $response->json()['message'] ?? 'Une erreur est survenue. Veuillez réessayer plus tard.';
        return back()->with('error', $errorMessage);
    }
}
