<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use App\Http\Controllers\Controller;
use App\Services\DiscorevApiService;

class MediaController extends Controller
{
    public function upload(Request $request, DiscorevApiService $api)
    {
        $request->validate([
            'file' => 'required|file|mimes:jpeg,png,jpg,gif,webp,mp4|max:20480',
            'uploadType' => 'required|string',
            'type' => 'required|string',
            'context' => 'nullable|string',
            'targetType' => 'required|string',
            'title' => 'nullable|string',
            'targetId' => 'required|integer',
        ]);

        $file = $request->file('file');

        $data = [
            'uploadType' => $request->uploadType,
            'type' => $request->type,
            'context' => $request->context,
            'targetType' => $request->targetType,
            'title' => $request->title,
            'targetId' => $request->targetId,
        ];

        $response = $api->uploadMedia($data, $file);

        if ($response->successful()) {
            return redirect()->back()->with('success', 'Fichier envoyé avec succès.');
        }

        return redirect()->back()->with('error', 'Erreur lors de l’envoi du fichier.');
    }
}
