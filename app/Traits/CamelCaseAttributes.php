<?php

namespace App\Traits;

use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

trait CamelCaseAttributes
{
    public function __get($key)
    {
        $snakeKey = Str::snake($key);

        // Accès direct aux attributs
        if (array_key_exists($snakeKey, $this->attributes ?? [])) {
            return $this->getAttribute($snakeKey);
        }

        // Accès aux relations camelCase
        if ($this->relationLoaded($snakeKey)) {
            return $this->relations[$snakeKey];
        }

        // Si la relation existe en snake_case
        if (method_exists($this, $snakeKey)) {
            return $this->getRelationshipFromMethod($snakeKey);
        }

        return parent::__get($key);
    }

    public function toArray()
    {
        $array = parent::toArray();

        return $this->convertToCamelCaseRecursive($array);
    }

    public function jsonSerialize(): mixed
    {
        return $this->toArray();
    }

    private function convertToCamelCaseRecursive(array $array): array
    {
        $result = [];

        foreach ($array as $key => $value) {
            $camelKey = Str::camel($key);

            if (is_array($value)) {
                $result[$camelKey] = $this->convertToCamelCaseRecursive($value);
            } elseif ($value instanceof Model) {
                $result[$camelKey] = $value->toArray();
            } elseif ($value instanceof Collection) {
                $result[$camelKey] = $value->map(function ($item) {
                    return $item instanceof Model ? $item->toArray() : $item;
                })->all();
            } else {
                $result[$camelKey] = $value;
            }
        }

        return $result;
    }
}
