<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class UserIsAdmin
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next)
    {
        // On suppose que tu stockes les infos user en session après login
        $user = session('user');

        if (!$user) {
            return redirect()->route('login')->with('error', 'Vous devez être connecté.');
        }

        // Vérifie si c'est bien un recruteur (en fonction de ton API : type = recruiter)
        if (!isset($user['accountType']) || $user['accountType'] !== 'admin') {
            abort(403, 'Accès interdit : vous devez être administrateur.');
        }

        return $next($request);
    }
}
