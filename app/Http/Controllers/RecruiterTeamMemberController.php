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
        if (!$recruiter) {
            return back()->withErrors('Recruteur inexistant en base de données.');
        }

        $submitted = collect($request->input('teamMembers', []));
        $submittedExisting = $submitted->whereNotNull('id')->keyBy('id');
        $submittedNew = $submitted->whereNull('id');

        $existingResponse = $this->api->get("recruiters/{$recruiterId}/team");

        if (!is_array($existingResponse)) {
            return back()->withErrors('Impossible de récupérer les membres existants.');
        }

        $existing = collect($existingResponse)->filter(fn($m) => !empty($m['id']))->keyBy('id');

        // Déterminer les changements
        $toUpdate = $submittedExisting->filter(function ($member, $id) use ($existing) {
            $current = $existing->get($id);
            return $current && (
                    $current['name'] !== $member['name'] ||
                    $current['email'] !== $member['email'] ||
                    $current['role'] !== $member['role']
                );
        });

        $toDeleteIds = collect(explode(',', $request->input('deletedIds', '')))
            ->filter()
            ->unique()
            ->values();

        $toCreate = $submittedNew->values();

        try {
            // ✅ Mises à jour
            foreach ($toUpdate as $id => $member) {
                $payload = [
                    'action' => 'update',
                    'type' => 'team',
                    'id' => $id,
                    'recruiter_id' => $recruiterId,
                    'name' => $member['name'],
                    'email' => $member['email'],
                    'role' => $member['role'],
                ];

                $updateResponse = $this->api->post('index.php', $payload);

                if (!$updateResponse->successful()) {
                    return back()->withErrors('Erreur lors de la modification des membres.');
                }
            }

            // ✅ Suppressions
            foreach ($toDeleteIds as $id) {
                $payload = [
                    'action' => 'delete',
                    'type' => 'team',
                    'id' => $id,
                ];

                $deleteResponse = $this->api->post('index.php', $payload);

                if (!$deleteResponse->successful()) {
                    return back()->withErrors('Erreur lors de la suppression des membres.');
                }
            }

            // ✅ Créations
            foreach ($toCreate as $member) {
                $payload = [
                    'action' => 'create',
                    'type' => 'team',
                    'recruiter_id' => $recruiterId,
                    'name' => $member['name'],
                    'email' => $member['email'],
                    'role' => $member['role'],
                ];

                $response = $this->api->post('index.php', $payload);

                if (!$response->successful()) {
                    return back()->withErrors('Erreur lors de la création d’un membre.');
                }
            }

        } catch (\Throwable $e) {
            report($e);
            return back()->withErrors('Une erreur est survenue lors de la synchronisation.');
        }

        return back()->with('success', 'Équipe synchronisée avec succès.');
    }
}
