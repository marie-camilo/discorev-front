<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\DiscorevApiService;
use App\Services\ApiModelService;
use Illuminate\Support\Facades\Session;
use App\Services\ApiErrorTranslator;
use Illuminate\Support\Facades\Auth;
use App\Models\Api\User;

class AuthController extends Controller
{
    private DiscorevApiService $api;
    private ApiModelService $modelService;
    private Request $request;

    public function __construct(DiscorevApiService $api, ApiModelService $modelService, Request $request)
    {
        $this->api = $api;
        $this->modelService = $modelService;
        $this->request = $request;
    }

    public function show($tab = 'login')
    {
        return view('auth.show', ['tab' => $tab]);
    }


    // ✅ Traite le formulaire d'inscription
    public function register(ApiErrorTranslator $translator)
    {
        $this->request->merge([
            'newsletter' => $this->request->has('newsletter'),
        ]);

        $this->request->validate([
            'firstName' => 'required|string|max:255',
            'lastName' => 'required|string|max:255',
            'email' => 'required|email',
            'password' => 'required|min:6|confirmed',
            'phoneNumber' => ['required', 'regex:/^[0-9]+$/', 'max:20'],
            'profilePicture' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
            'accountType' => 'required|in:candidate,recruiter',
            'accept-cgu' => 'accepted',
            'accept-confidentiality' => 'accepted',
            'newsletter' => 'nullable|boolean',
        ]);

        $data = [
            'firstName' => $this->request->firstName,
            'lastName' => $this->request->lastName,
            'email' => $this->request->email,
            'password' => $this->request->password,
            'phoneNumber' => $this->request->phoneNumber,
            'accountType' => $this->request->accountType,
            'newsletter' => $this->request->newsletter,
        ];

        // Handle profile picture upload if present
        if ($this->request->hasFile('profilePicture')) {
            $data['profilePicture'] = $this->request->file('profilePicture');
        }

        // Envoi à l'API
        $response = $this->api->post('auth/register', $data);

        if (!$response->successful()) {
            $errorMessage = $response->json('message') ?? 'Une erreur est survenue lors de l’inscription.';
            $translated = $translator->translate($errorMessage);
            return back()->withErrors(['auth.register' => $translated])->withInput();
        }

        // Une fois que l'inscription a réussi, on lance la requête login automatique
        $credentials = $this->request->only('email', 'password');

        $loginResponse = $this->api->post('auth/login', $credentials);

        $loginData = $loginResponse->json();

        if ($loginResponse->successful() && isset($loginData['token'])) {
            Session::put('accessToken', $loginData['token']);
            Session::put('refreshToken', $loginData['refreshToken']);
            Session::put('user', $loginData['data']);

            $user = User::where('email', $loginData['data']['email'])->first();

            if ($user) {
                Auth::login($user);
            }
            return redirect()->route('complete-profile')->with('success', 'Connexion réussie !');
        }

        // Si la connexion automatique échoue, on peut afficher un message d’erreur friendly
        return back()->withErrors(['warning' => 'Inscription réussie, mais la connexion automatique a échoué. Veuillez vous connecter manuellement.']);
    }

    public function login()
    {
        $this->request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);
        // On récupère aussi le champ remember
        $credentials = $this->request->only('email', 'password');
        $remember = $this->request->has('remember'); // true/false

        // On envoie tout au backend (si le backend accepte remember)
        $response = $this->api->post('auth/login', array_merge($credentials, [
            'remember' => $remember,
        ]));

        if ($response && isset($response['token'])) {
            // Rechercher l'utilisateur dans la BDD à partir de son email (ou id)
            // Correct : utiliser la colonne réelle, ici 'email' ou 'id'
            $authUser = \App\Models\User::where('email', $response['user']['email'])->first();
            Auth::login($authUser, null);

            Session::put('accessToken', $response['token']);
            Session::put('refreshToken', $response['refreshToken']);
            Session::put('user', $response['user']);

            return redirect()->route('home')->with('success', 'Connexion réussie !');
        }

        return back()->withErrors(['email' => 'Identifiants incorrects.']);
    }

    public function logout()
    {
        Auth::logout();

        $this->request->session()->invalidate();
        $this->request->session()->regenerateToken();

        return redirect()->route('home')->with('success', 'Vous avez été déconnecté avec succès.');
    }
}
