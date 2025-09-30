<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Session;
use Illuminate\Http\Client\Response;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;
use Illuminate\Support\Str;
use Illuminate\Http\UploadedFile;

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
            $response = Http::withToken(Session::get('accessToken'))
                ->get("{$this->baseUrl}/{$endpoint}", $params);

            $data = $response->json();

            // ✅ Ici : forcer à avoir un array
            if (is_string($data)) {
                $data = json_decode($data, true);
            }

            if (!is_array($data)) {
                throw new \Exception('Données API non valides');
            }

            return isset($data['data']) && is_array($data['data']) ? $data['data'] : $data;
        });
    }

    /**
     * Récupère un seul élément (pour les endpoints comme /recruiters/1)
     */
    public function getOne(string $endpoint, array $params = [])
    {
        return $this->withAutoRefresh(function () use ($endpoint, $params) {
            $response = Http::withToken(Session::get('accessToken'))
                ->get("{$this->baseUrl}/{$endpoint}", $params);

            // Retourner les données brutes pour permettre le mapping manuel
            if ($response instanceof \Illuminate\Http\Client\Response) {
                $data = $response->json();

                // Si c'est une chaîne JSON, on la décode
                if (is_string($data)) {
                    $data = json_decode($data, true);
                }

                // S'assurer que c'est un tableau
                if (!is_array($data)) {
                    throw new \Exception('Les données API ne sont pas dans le format attendu');
                }

                // Si la réponse contient une clé "data", on extrait le contenu
                if (isset($data['data']) && is_array($data['data'])) {
                    return $data['data'];
                }

                return $data;
            }

            return $response;
        });
    }

    public function post(string $endpoint, array $data)
    {
        return $this->withAutoRefresh(function () use ($endpoint, $data) {
            $http = Http::withToken(Session::get('accessToken'))
                ->acceptJson();
            $http = $http->asJson();
            $response = $http->post("{$this->baseUrl}/{$endpoint}", $data);
            return $response;
        });
    }

    public function put(string $endpoint, array $data)
    {
        return $this->withAutoRefresh(function () use ($endpoint, $data) {
            $http = Http::withToken(Session::get('accessToken'))
                ->acceptJson();
            $http = $http->asJson();
            $response = $http->put("{$this->baseUrl}/{$endpoint}", $data);

            return $response;
        });
    }

    public function delete(string $endpoint)
    {
        return $this->withAutoRefresh(function () use ($endpoint) {
            return Http::withToken(Session::get('accessToken'))
                ->delete("{$this->baseUrl}/{$endpoint}");
        });
    }

    public function patch(string $endpoint, array $data)
    {
        return $this->withAutoRefresh(function () use ($endpoint, $data) {
            $http = Http::withToken(Session::get('accessToken'))
                ->acceptJson();
            $http = $http->asJson();
            $response = $http->patch("{$this->baseUrl}/{$endpoint}", $data);

            return $response;
        });
    }


    public function uploadMedia(array $data, UploadedFile $file)
    {
        return $this->withAutoRefresh(function () use ($data, $file) {
            $response = Http::withToken(Session::get('accessToken'))
                ->attach('file', file_get_contents($file), $file->getClientOriginalName())
                ->post("{$this->baseUrl}/upload/media", $data);

            return $response;
        });
    }

    // /**
    //  * Devine le modèle et mappe si possible
    //  */
    // protected function mapIfPossible(string $endpoint, $response): array|\Illuminate\Support\Collection
    // {
    //     // Si c'est un objet Response, on récupère le JSON
    //     if ($response instanceof \Illuminate\Http\Client\Response) {
    //         $response = $response->json();
    //     }

    //     // Si la réponse contient une clé "data", on ne garde que ça
    //     if (isset($response['data']) && is_array($response['data'])) {
    //         $response = $response['data'];
    //     }

    //     // On récupère le nom de modèle attendu
    //     $modelClass = $this->guessModelClass($endpoint);

    //     // Si c’est un tableau associatif (un seul élément)
    //     if (class_exists($modelClass) && $this->isAssoc($response)) {
    //         return new $modelClass($response);
    //     }

    //     // Si c’est une liste (plusieurs éléments)
    //     if (class_exists($modelClass)) {
    //         return collect($response)->map(fn($item) => new $modelClass($item));
    //     }

    //     // Sinon on renvoie une collection brute
    //     return collect($response);
    // }

    // /**
    //  * Vérifie si un tableau est associatif (un seul objet)
    //  */
    // protected function isAssoc(array $arr): bool
    // {
    //     return array_keys($arr) !== range(0, count($arr) - 1);
    // }

    // /**
    //  * Devine la classe du modèle à partir de l’endpoint
    //  */
    // protected function guessModelClass(string $endpoint): string
    // {
    //     $baseName = explode('/', $endpoint);
    //     $baseName = end($baseName);

    //     $modelName = \Illuminate\Support\Str::studly(\Illuminate\Support\Str::singular($baseName));

    //     return "App\\Models\\Api\\{$modelName}";
    // }

    // protected function mapToModel(string $modelClass, array $attributes): Model
    // {
    //     $model = new $modelClass;
    //     $model->forceFill($attributes);
    //     return $model;
    // }

    // protected function mapToCollection(string $modelClass, array $items): Collection
    // {
    //     return collect($items)->map(fn($item) => $this->mapToModel($modelClass, $item));
    // }

    protected function withAutoRefresh(callable $requestCallback): Response|Model|Collection|array
    {
        $response = $requestCallback();

        if ($response instanceof Response && $response->status() === 401 && $this->refreshToken()) {
            return $requestCallback();
        }

        return $response;
    }

    protected function refreshToken(): bool
    {
        $refreshToken = Session::get('refreshToken');
        if (!$refreshToken) {
            return false;
        }

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

        Session::forget(['accessToken', 'refreshToken']);
        return false;
    }
}
