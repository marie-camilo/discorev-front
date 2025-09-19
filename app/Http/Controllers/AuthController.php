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

    public function __construct(DiscorevApiService $api)
    {
        $this->api = $api;
    }

    public function show($tab = 'login')
    {
        return view('auth.show', ['tab' => $tab]);
    }


    // ✅ Traite le formulaire d'inscription
    public function register(Request $request, ApiErrorTranslator $translator)
    {
        $request->merge([
            'newsletter' => $request->has('newsletter'),
        ]);

        $request->validate([
            'firstName' => 'required|string|max:255',
            'lastName' => 'required|string|max:255',
            'registerEmail' => 'required|email',
            'registerPassword' => 'required|min:8|confirmed',
            'phoneNumber' => ['required', 'regex:/^[0-9]+$/', 'max:20'],
            'accountType' => 'required|in:candidate,recruiter',
            'accept-cgu' => 'accepted',
            'accept-confidentiality' => 'accepted',
            'newsletter' => 'nullable|boolean',
        ]);

        $data = [
            'firstName' => $request->firstName,
            'lastName' => $request->lastName,
            'email' => $request->registerEmail,
            'password' => $request->registerPassword,
            'phoneNumber' => $request->phoneNumber,
            'accountType' => $request->accountType,
            'newsletter' => $request->newsletter,
        ];

        // Envoi à l'API
        $response = $this->api->post('auth/register', $data);

        if (!$response->successful()) {
            $errorMessage = $response->json('message') ?? 'Une erreur est survenue lors de l’inscription.';
            $translated = $translator->translate($errorMessage);
            return back()->withErrors(['auth.register' => $translated])->withInput();
        }

        // Une fois que l'inscription a réussi, on lance la requête login automatique
        $loginData = [
            'email' => $request->registerEmail,
            'password' => $request->registerPassword,
        ];

        $loginResponse = $this->api->post('auth/login', $loginData);

        if ($loginResponse->successful()) {
            $data = $loginResponse->json()['data'];
            // Stocker tokens en session
            Session::put('accessToken', $data['token']);
            Session::put('user', $data['user']);
            Session::put('token_exp', time() + 3600); // token 1h
            return redirect()->route('home')->with('success', 'Création réussie. Bienvenue chez Discorev !');
        }

        // Si la connexion automatique échoue, on peut afficher un message d’erreur friendly
        return back()->withErrors(['warning' => 'Inscription réussie, mais la connexion automatique a échoué. Veuillez vous connecter manuellement.']);
    }

    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required'
        ]);

        $response = $this->api->post('auth/login', [
            'email' => $request->email,
            'password' => $request->password,
            'remember' => $request->boolean('remember')
        ]);

        if ($response->successful()) {
            $data = $response->json()['data'];

            // Stocker tokens en session
            Session::put('accessToken', $data['token']);
            Session::put('user', $data['user']);
            Session::put('token_exp', time() + 3600); // token 1h

            // ✅ refreshToken : inutile si cookie httpOnly est déjà envoyé
            if (!empty($data['refreshToken'])) {
                Session::put('refreshToken', $data['refreshToken']);
            }

            return redirect()->route('home')->with('success', 'Connexion réussie !');
        }

        return back()->withErrors(['email' => 'Identifiants incorrects.']);
    }


    public function logout(Request $request)
    {
        // Appel API pour invalider le refresh token (optionnel mais sécurisé)
        if (Session::has('refreshToken')) {
            try {
                $this->api->post('/auth/logout', [
                    'refreshToken' => Session::get('refreshToken')
                ]);
            } catch (\Exception $e) {
            }
        }

        // Supprime les infos API en session
        Session::forget(['accessToken', 'refreshToken', 'user', 'token_exp']);

        // Déconnecte Laravel (si Auth utilisé en parallèle)
        Auth::logout();

        // Invalide la session et régénère le CSRF token
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('home')->with('success', 'Vous avez été déconnecté avec succès.');
    }
}
