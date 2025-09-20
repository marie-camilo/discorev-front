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

        // ✅ Vérif locale
        if ($token && Session::has('token_exp') && time() < Session::get('token_exp')) {
            view()->share('isAuthenticated', true);
            view()->share('user', Session::get('user'));
            return $next($request);
        }

        // ✅ Token expiré → tente refresh
        if ($token && Session::has('refreshToken')) {
            $refresh = Http::withCookies($request->cookies->all(), parse_url(env('DISCOREV_API_URL'))['host'])
                ->post(env('DISCOREV_API_URL') . '/auth/refresh-token');

            if ($refresh->successful() && isset($refresh['data']['token'])) {
                $newToken = $refresh['data']['token'];
                Session::put('accessToken', $newToken);
                Session::put('token_exp', time() + 3600); // 1h
                return $next($request);
            }
        }

        // ❌ Échec → logout
        Session::forget(['accessToken', 'refreshToken', 'user', 'token_exp']);
        view()->share('isAuthenticated', false);
        view()->share('user', null);
        return redirect()->route('login');
    }
}
