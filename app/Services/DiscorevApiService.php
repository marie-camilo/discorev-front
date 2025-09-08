<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Session;
use Illuminate\Http\Client\Response;
use \Illuminate\Http\UploadedFile;

class DiscorevApiService
{
    protected string $baseUrl;

    public function __construct()
    {
        $this->baseUrl = env('DISCOREV_API_URL', 'http://localhost:3000');
    }
    public function get(string $endpoint, array $params = [])
    {
        return $this->withAutoRefresh(function () use ($endpoint, $params) {
            return Http::withToken(Session::get('accessToken'))
                ->get("{$this->baseUrl}/{$endpoint}", $params);
        });
    }

    public function post(string $endpoint, array $data)
    {
        return $this->withAutoRefresh(function () use ($endpoint, $data) {
            return Http::withToken(Session::get('accessToken'))
                ->post("{$this->baseUrl}/{$endpoint}", $data);
        });
    }

    public function put(string $endpoint, array $data)
    {
        return $this->withAutoRefresh(function () use ($endpoint, $data) {
            return Http::withToken(Session::get('accessToken'))
                ->put("{$this->baseUrl}/{$endpoint}", $data);
        });
    }

    public function delete(string $endpoint)
    {
        return $this->withAutoRefresh(function () use ($endpoint) {
            return Http::withToken(Session::get('accessToken'))
                ->delete("{$this->baseUrl}/{$endpoint}");
        });
    }

    public function patch(string $endpoint)
    {
        return $this->withAutoRefresh(function () use ($endpoint) {
            return Http::withToken(Session::get('accessToken'))
                ->patch("{$this->baseUrl}/{$endpoint}");
        });
    }


    public function uploadMedia(array $data, UploadedFile $file)
    {
        return $this->withAutoRefresh(function () use ($data, $file) {
            return Http::withToken(Session::get('accessToken'))
                ->attach(
                    'file',                       // <-- Doit correspondre au nom attendu dans le backend Node.js
                    file_get_contents($file),
                    $file->getClientOriginalName()
                )
                ->post("{$this->baseUrl}/upload/media", $data);
        });
    }


    /**
     * Rafraîche automatiquement le token si expiré.
     */
    protected function withAutoRefresh(callable $requestCallback): Response
    {
        $response = $requestCallback();

        if ($response->status() === 401 && $this->refreshToken()) {
            // Réessaie la requête après refresh
            return $requestCallback();
        }

        return $response;
    }

    /**
     * Appelle /refresh-token pour obtenir un nouveau accessToken
     */
    protected function refreshToken(): bool
    {
        $refresh = Http::withOptions([
            'base_uri' => $this->baseUrl,
            'cookies' => true, // <-- Permet d’envoyer les cookies existants (dont HttpOnly)
            'withCredentials' => true
        ])->post('/auth/refresh-token');

        if ($refresh->successful()) {
            $newToken = $refresh->json('data');
            if ($newToken) {
                Session::put('accessToken', $newToken);
                return true;
            }
        }

        Session::forget('accessToken');
        return false;
    }
}
