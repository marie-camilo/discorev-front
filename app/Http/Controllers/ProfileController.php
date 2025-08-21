<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\DiscorevApiService;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;
use App\Models\Api\Admin;
use App\Models\Api\Recruiter;
use App\Models\Api\Candidate;

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
        $user = Auth::user();
        $type = $user->accountType;

        // Tabs selon le type
        $tabs =
            $type === 'recruiter'
            ? [
                'company' => ['label' => 'Mon entreprise', 'icon' => 'corporate_fare'],
                'account-recruiter' => ['label' => 'Mon compte', 'icon' => 'account_circle'],
                'page' => ['label' => 'Ma page', 'icon' => 'monitor'],
                'help' => ['label' => 'Aide et support', 'icon' => 'help'],
            ]
            : ($type === 'candidate'
                ? [
                    'profile' => ['label' => 'Mon profil', 'icon' => 'face'],
                    'account-candidate' => ['label' => 'Mon compte', 'icon' => 'account_circle'],
                    'cv' => ['label' => 'Mon CV', 'icon' => 'contact_page'],
                    'help' => ['label' => 'Aide et support', 'icon' => 'help'],
                ]
                : [ // cas admin
                    'dashboard' => ['label' => 'Tableau de bord', 'icon' => 'dashboard'],
                    'users' => ['label' => 'Gestion des utilisateurs', 'icon' => 'group'],
                    'settings' => ['label' => 'Paramètres', 'icon' => 'settings'],
                    'help' => ['label' => 'Aide et support', 'icon' => 'help'],
                ]);

        // Détermination de l’endpoint API
        $endpoint = match ($type) {
            'recruiter' => 'recruiters/user/',
            'candidate' => 'candidates/user/',
            'admin' => 'admins/user/',
            default => null
        };

        if (!$endpoint) {
            return back()->with('error', 'Type de compte non reconnu.');
        }

        $response = $this->api->get($endpoint . $user->id);

        if (!$response->successful()) {
            $errorMsg = match ($type) {
                'recruiter' => 'Impossible de récupérer les données du recruteur.',
                'candidate' => 'Impossible de récupérer les données du candidat.',
                'admin' => 'Impossible de récupérer les données de l’administrateur.',
                default => 'Erreur inconnue.'
            };
            return back()->with('error', $errorMsg);
        } else {
            $data = match ($type) {
                'recruiter' => Recruiter::fromApiData($response),
                'candidate' => Candidate::fromApiData($response),
                'admin' => Admin::fromApiData($response)
            };
        };

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
        $section = $request->input('section');

        switch ($section) {
            case 'general':

                $validated = $request->validate([
                    'firstName' => 'nullable|string',
                    'lastName' => 'nullable|string',
                    'email' => 'required|email',
                    'phoneNumber' => 'nullable|string',
                ]);

                $response = $this->api->put('/users/' . $id, $validated);

                return back()->with('success_general', 'Informations mises à jour.');

            case 'avatar':
                $request->validate([
                    'profilePicture' => 'required|image|max:2048',
                ]);

                $path = $request->file('profilePicture')->store('avatars', 'public');
                //auth()->user()->update(['profilePicture' => $path]);

                return back()->with('success_avatar', 'Photo mise à jour.');
        }

        return back()->with('error', 'Section inconnue.');
    }
}
