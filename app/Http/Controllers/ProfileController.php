<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\DiscorevApiService;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;

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
        $tabs =
            $type === 'recruiter'
            ? [
                'company' => ['label' => 'Mon entreprise', 'icon' => 'corporate_fare'],
                'account-recruiter' => ['label' => 'Mon compte', 'icon' => 'account_circle'],
                'page' => ['label' => 'Ma page', 'icon' => 'monitor'],
                'help' => ['label' => 'Aide et support', 'icon' => 'help'],
            ]
            : [
                'profile' => ['label' => 'Mon profil', 'icon' => 'face'],
                'account-candidate' => ['label' => 'Mon compte', 'icon' => 'account_circle'],
                'cv' => ['label' => 'Mon CV', 'icon' => 'contact_page'],
                'help' => ['label' => 'Aide et support', 'icon' => 'help'],
            ];
        // Appel API pour récupérer les données selon le type de compte
        $endpoint = $user->accountType === 'recruiter' ? 'recruiters/' : 'candidates/';
        $response = $this->api->get($endpoint . $user->id);
        $json = $response->json();

        if (!$response->successful() || !isset($json['data'])) {
            $errorMsg = $user->accountType === 'recruiter'
                ? 'Impossible de récupérer les données du recruteur.'
                : 'Impossible de récupérer les données du candidat.';
            return back()->with('error', $errorMsg);
        }

        $data = $json['data'];
        return view('account.profile.edit', [
            'recruiter' => $type === 'recruiter' ? $data : null,
            'candidate' => $type === 'candidate' ? $data : null,
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
