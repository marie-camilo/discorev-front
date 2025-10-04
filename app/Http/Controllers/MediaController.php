<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Services\DiscorevApiService;
use Illuminate\Support\Facades\Session;

class MediaController extends Controller
{
    private DiscorevApiService $api;

    public function __construct(DiscorevApiService $api)
    {
        $this->api = $api;
    }

    public function upload(Request $request)
    {
        $request->validate([
            'file' => 'required',
            'uploadType' => 'required|string',
            'type' => 'required|string',
            'context' => 'nullable|string',
            'targetType' => 'required|string',
            'title' => 'nullable|string',
            'targetId' => 'required|integer',
        ]);

        $data = [
            'uploadType' => $request->uploadType,
            'type' => $request->type,
            'context' => $request->context,
            'targetType' => $request->targetType,
            'title' => $request->title,
            'targetId' => $request->targetId,
        ];

        $files = $request->file('file');

        // S’il y a plusieurs fichiers
        if (is_array($files)) {
            $errors = [];
            foreach ($files as $file) {
                // Validation individuelle
                if (!$file->isValid() || !in_array($file->extension(), ['jpeg', 'png', 'jpg', 'gif', 'webp', 'mp4']) || $file->getSize() > 20480 * 1024) {
                    $errors[] = $file->getClientOriginalName();
                    continue;
                }

                $response = $this->api->uploadMedia($data, $file);

                if (!$response->successful()) {
                    $errors[] = $file->getClientOriginalName();
                }
            }

            if (count($errors)) {
                return redirect()->back()->with('error', 'Certains fichiers ont échoué : ' . implode(', ', $errors));
            }

            return redirect()->back()->with('success', 'Tous les fichiers ont été envoyés avec succès.');
        }

        // Cas d’un seul fichier
        if ($files instanceof \Illuminate\Http\UploadedFile) {
            if (!$files->isValid()) {
                return redirect()->back()->with('error', 'Fichier invalide.');
            }

            $response = $this->api->uploadMedia($data, $files);

            if ($response->successful()) {
                $user = $this->api->get('users/' . $data['targetId']);
                Session::put('user', $user);
                return redirect()->back()->with('success', 'Fichier envoyé avec succès.');
            }

            return redirect()->back()->with('error', 'Erreur lors de l’envoi du fichier.');
        }

        return redirect()->back()->with('error', 'Aucun fichier envoyé.');
    }

    public function delete($id)
    {
        try {
            $response = $this->api->delete('medias/' . $id);
            if ($response->successful()) {
                return response()->json(['success' => true]);
            }

            return response()->json([
                'error' => 'Échec de la suppression',
                'details' => $response->body()
            ], 500);
        } catch (\Throwable $e) {
            return response()->json([
                'error' => 'Exception attrapée',
                'message' => $e->getMessage(),
            ], 500);
        }
    }
}
