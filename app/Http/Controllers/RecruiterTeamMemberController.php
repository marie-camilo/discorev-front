<?php

namespace App\Http\Controllers;

use App\Services\DiscorevApiService;
use Illuminate\Http\Request;

class RecruiterTeamMemberController extends Controller
{
    private DiscorevApiService $api;

    public function __construct(DiscorevApiService $api)
    {
        $this->api = $api;
    }

    public function syncTeamMembers(Request $request, int $recruiterId)
    {
        /** ----------------------------------------------------------------
         * 1. Préparation des données envoyées depuis le formulaire
         * ----------------------------------------------------------------*/
        $submitted = collect($request->input('teamMembers', []));

        // Sépare les membres existants (avec id) et les nouveaux (sans id)
        $submittedExisting  = $submitted->whereNotNull('id')->keyBy('id');
        $submittedNew       = $submitted->whereNull('id');

        /** ----------------------------------------------------------------
         * 2. Récupération des membres réellement stockés côté API
         * ----------------------------------------------------------------*/
        $existingResponse = $this->api->get("recruiters/{$recruiterId}/team");

        if (empty($existingResponse)) {
            return back()->withErrors('Impossible de récupérer les membres existants.');
        }

        $existing = collect($existingResponse)->keyBy('id');

        /** ----------------------------------------------------------------
         * 3. Calcul des différences
         * ----------------------------------------------------------------*/
        // a) Membres à mettre à jour (présents des deux côtés, mais champs modifiés)
        $toUpdate = $submittedExisting->filter(function ($member, $id) use ($existing) {
            $current = $existing->get($id);

            return $current &&
                ($current['name']  !== $member['name'] ||
                    $current['email'] !== $member['email'] ||
                    $current['role']  !== $member['role']);
        });

        // b) Membres à supprimer (présents côté API mais plus dans le formulaire)
        $toDeleteIds = $existing->keys()->diff($submittedExisting->keys());

        // c) Membres à créer (ceux du formulaire sans id)
        $toCreate = $submittedNew->values();            // on ré-indexe proprement
        $createCount = $toCreate->count();

        //🐞 Debug complet
        dd([
            '🔄 À mettre à jour (modifiés)' => $toUpdate->values(),
            '➕ À créer' => $toCreate,
            '❌ À supprimer (IDs)' => $toDeleteIds->values(),
        ]);

        /** ----------------------------------------------------------------
         * 4. Appels API
         * ----------------------------------------------------------------*/
        try {
            // Mises à jour
            foreach ($toUpdate as $id => $member) {
                $this->api->put("recruiters/{$recruiterId}/team/{$id}", $member);
            }

            // Suppressions
            foreach ($toDeleteIds as $id) {
                $this->api->delete("recruiters/{$recruiterId}/team/{$id}");
            }

            // Créations (bulk ou unitaire selon la quantité)
            if ($createCount) {
                $endpoint = $createCount > 1
                    ? "recruiters/{$recruiterId}/team/bulk"
                    : "recruiters/{$recruiterId}/team";

                $this->api->post($endpoint, $createCount > 1 ? $toCreate : $toCreate->first());
            }
        } catch (\Throwable $e) {
            report($e); // log propre
            return back()->withErrors('Une erreur est survenue lors de la synchronisation.');
        }

        return back()->with('success', 'Équipe synchronisée avec succès.');
    }
}
