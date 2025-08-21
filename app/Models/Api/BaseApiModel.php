<?php

namespace App\Models\Api;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection as EloquentCollection;

abstract class BaseApiModel extends Model
{
    public $timestamps = false;  // Pas de created_at / updated_at
    protected $guarded = [];     // Tous les champs sont assignables
    public ?int $id;

    /**
     * Empêche les requêtes SQL directes mais permet les relations
     */
    public function getConnectionName()
    {
        return 'api'; // Utilise une connexion dédiée pour l'API
    }

    /**
     * Empêche les requêtes SQL directes sur ce modèle
     */
    protected static function booted()
    {
        static::addGlobalScope('api_scope', function (Builder $builder) {
            // Empêche les requêtes SQL directes
            $builder->whereRaw('1 = 0');
        });
    }

    /**
     * Surcharge des méthodes de requête pour empêcher les opérations DB
     */
    public static function query()
    {
        throw new \Exception('Les requêtes SQL directes ne sont pas autorisées sur les modèles API. Utilisez le service API.');
    }

    public static function all($columns = ['*'])
    {
        throw new \Exception('Les requêtes SQL directes ne sont pas autorisées sur les modèles API. Utilisez le service API.');
    }

    public static function find($id, $columns = ['*'])
    {
        throw new \Exception('Les requêtes SQL directes ne sont pas autorisées sur les modèles API. Utilisez le service API.');
    }

    public static function where($column, $operator = null, $value = null)
    {
        throw new \Exception('Les requêtes SQL directes ne sont pas autorisées sur les modèles API. Utilisez le service API.');
    }

    /**
     * Permet les opérations sur les attributs sans DB
     */
    public function save(array $options = [])
    {
        // Empêche la sauvegarde en DB mais permet la manipulation des attributs
        throw new \Exception('La sauvegarde en base de données n\'est pas autorisée sur les modèles API. Utilisez le service API.');
    }

    public function update(array $attributes = [], array $options = [])
    {
        // Permet la mise à jour des attributs en mémoire
        $this->fill($attributes);
        return true;
    }

    public function delete()
    {
        throw new \Exception('La suppression en base de données n\'est pas autorisée sur les modèles API. Utilisez le service API.');
    }

    /**
     * Permet les relations Eloquent
     */
    public function newQuery()
    {
        // Retourne un builder vide pour permettre les relations
        return new Builder($this->getConnection());
    }

    /**
     * Méthode pour créer un modèle à partir de données API
     */
    public static function fromApiData(array $data): static
    {
        $model = new static();
        $model->fill($data);
        $model->id = $data['id'] ?? null;
        $model->exists = true; // Indique que le modèle "existe" (vient de l'API)

        return $model;
    }

    /**
     * Méthode pour créer une collection à partir de données API
     */

    public static function fromApiCollection($data): EloquentCollection
    {
        // Si $data est une Collection, on la transforme en array
        $arrayData = $data instanceof \Illuminate\Support\Collection ? $data->all() : (array)$data;

        // On transforme chaque élément en objet via fromApiData
        $items = array_map(fn($item) => $item instanceof static ? $item : static::fromApiData((array)$item), $arrayData);

        return new EloquentCollection($items);
    }
    /**
     * Convertir automatiquement les tableaux en Eloquent\Collection
     */
    public function getAttribute($key)
    {
        $value = parent::getAttribute($key);

        // Si c'est déjà une Eloquent\Collection → on touche pas
        if ($value instanceof EloquentCollection) {
            return $value;
        }

        // Si c'est un array → on convertit en Eloquent\Collection
        if (is_array($value)) {
            return new EloquentCollection($value);
        }

        return $value;
    }
}
