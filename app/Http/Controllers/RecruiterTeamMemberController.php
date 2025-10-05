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
        $recruiter = $this->api->get('recruiters/' . $recruiterId);
        if (! $recruiter) {
            return back()->withErrors('Recruteur inexistant en base de données.');
        }

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

        // Si l'appel retourne null ou autre chose qu'un array, c'est une vraie erreur
        if (!is_array($existingResponse)) {
            return back()->withErrors('Impossible de récupérer les membres existants.');
        }

        // Si c'est un tableau vide, on continue normalement
        $existing = collect($existingResponse)
            ->filter(fn($m) => !empty($m['id']))
            ->keyBy('id');
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
        $toDeleteIds = collect(explode(',', $request->input('deletedIds', '')))
            ->filter()
            ->unique()
            ->values();

        // c) Membres à créer (ceux du formulaire sans id)
        $toCreate = $submittedNew->values();            // on ré-indexe proprement
        $createCount = $toCreate->count();

        //🐞 Debug complet
        // dd([
        //     '🔄 À mettre à jour (modifiés)' => $toUpdate->values(),
        //     '➕ À créer' => $toCreate,
        //     '❌ À supprimer (IDs)' => $toDeleteIds->values(),
        // ]);

        /** ----------------------------------------------------------------
         * 4. Appels API
         * ----------------------------------------------------------------*/
        try {
            // Mises à jour
            foreach ($toUpdate as $id => $member) {
                $updateResponse = $this->api->put("recruiters/{$recruiterId}/team/{$id}", $member);
                if (!$updateResponse->successful()) {
                    return back()->withErrors('Erreur lors de la modification des membres');
                }
            }

            // Suppressions
            foreach ($toDeleteIds as $id) {
                $deleteResponse = $this->api->delete("recruiters/{$recruiterId}/team/{$id}");

                if (!$deleteResponse->successful()) {
                    return back()->withErrors('Erreur lors de la suppression des membres');
                }
            }

            // Créations (bulk ou unitaire selon la quantité)
            if ($createCount) {
                if ($createCount > 1) {
                    // ✅ Cas BULK
                    $endpoint = "recruiters/{$recruiterId}/team/bulk";

                    $payload = [
                        'members' => $toCreate->map(function ($m) use ($recruiterId) {
                            return array_merge($m, ['recruiter_id' => $recruiterId]);
                        })->toArray()
                    ];
                } else {
                    // ✅ Cas UNITAIRE
                    $endpoint = "recruiters/{$recruiterId}/team";

                    $payload = array_merge($toCreate->first(), [
                        'recruiter_id' => $recruiterId
                    ]);
                }

                $response = $this->api->post($endpoint, $payload);

                if (!$response->successful()) {
                    return back()->withErrors('Impossible de créer le(s) nouveau(x) membre(s)');
                }
            }
        } catch (\Throwable $e) {
            report($e); // log propre
            return back()->withErrors('Une erreur est survenue lors de la synchronisation.');
        }

        return back()->with('success', 'Équipe synchronisée avec succès.');
    }
}
