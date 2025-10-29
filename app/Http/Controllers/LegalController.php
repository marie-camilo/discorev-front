<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class LegalController extends Controller
{
    /**
     * Affiche dynamiquement une page légale
     */
    public function show($slug)
    {
        // Tableau des pages disponibles avec leurs titres
        $pages = [
            'mentions-legales' => 'Mentions légales',
            'cgu' => 'Conditions générales d’utilisation',
            'cgv' => 'Conditions générales de vente',
            'politique-confidentialite' => 'Politique de confidentialité',
            'cookies' => 'Politique de gestion des cookies',

        ];

        // Si la page demandée n'existe pas, erreur 404
        if (!array_key_exists($slug, $pages)) {
            abort(404);
        }

        // Vue partielle correspondante
        $viewName = 'legal.' . $slug;

        // Rendu de la vue principale
        return view('legal.template', [
            'title' => $pages[$slug],
            'viewName' => $viewName,
        ]);
    }
}
