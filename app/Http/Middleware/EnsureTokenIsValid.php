<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Session;

class EnsureTokenIsValid
{
    public function handle(Request $request, Closure $next)
    {
        $token = Session::get('accessToken');

        // Si on a un token, on tente de le vérifier
        if ($token) {
            $response = Http::withToken($token)->get(env('DISCOREV_API_URL') . '/auth/verify');

            if ($response->ok()) {
                // Token valide
                view()->share('isAuthenticated', true);
                view()->share('user', Session::get('user'));
                return $next($request);
            }

            // Si le token est invalide, on tente de le rafraîchir
            if ($response->status() === 401) {
                $refresh = Http::withCookies($request->cookies->all(), parse_url(env('DISCOREV_API_URL'))['host'])
                    ->post(env('DISCOREV_API_URL') . '/auth/refresh-token');

                if ($refresh->successful() && isset($refresh['accessToken'])) {
                    // On stocke le nouveau token et continue
                    Session::put('accessToken', $refresh['accessToken']);
                    Session::put('user', $refresh['data'] ?? null);

                    view()->share('isAuthenticated', true);
                    view()->share('user', $refresh['data'] ?? null);

                    return $next($request);
                }
            }
        }

        // Si aucune authentification n'est possible, on déconnecte l'utilisateur
        Session::forget('accessToken');
        Session::forget('user');

        view()->share('isAuthenticated', false);
        view()->share('user', null);

        // 🔁 Redirige vers login si ce n'est pas une API ou une page publique
        return redirect()->route('login');
    }
}
