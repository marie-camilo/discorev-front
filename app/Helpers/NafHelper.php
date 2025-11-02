<?php

namespace App\Helpers;

class NafHelper
{
    public static function getLabel(string $code): string
    {
        $entries = self::loadNafJson();

        foreach ($entries as $entry) {
            if (isset($entry['code_classe']) && $entry['code_classe'] === $code) {
                return $entry['classe'] ?? $code;
            }
        }
        return $code;
    }

    /**
     * Charge le JSON complet NAF
     */
    public static function loadNafJson(): array
    {
        $path = resource_path('data/naf2008.json');

        if (!file_exists($path)) {
            return [];
        }

        $json = file_get_contents($path);
        $entries = json_decode($json, true);

        return $entries; // tableau de [ ['code_classe'=>..., 'classe'=>...], … ]
    }

    public static function groupBySection(array $entries): array
    {
        $grouped = [];

        foreach ($entries as $entry) {
            // Exemple : "Q — Santé humaine et action sociale"
            $sectionKey = $entry['code_section'] . ' — ' . ($entry['section'] ?? 'Inconnue');

            // On ajoute la classe dans la bonne section
            $grouped[$sectionKey][$entry['code_classe']] = $entry['classe'] ?? 'Non précisé';
        }

        // Tri alphabétique dans chaque section
        foreach ($grouped as &$list) {
            asort($list, SORT_NATURAL | SORT_FLAG_CASE);
        }

        // Tri des sections par clé
        ksort($grouped, SORT_NATURAL | SORT_FLAG_CASE);

        return $grouped;
    }

    public static function groupBySectionSortedByName(array $entries): array
    {
        $grouped = [];

        foreach ($entries as $entry) {
            $sectionName = $entry['section'] ?? 'Inconnue';
            $sectionCode = $entry['code_section'] ?? '?';

            // Ex: "Q — Santé humaine et action sociale"
            $sectionLabel = "{$sectionCode} — {$sectionName}";
            $grouped[$sectionLabel][$entry['code_classe']] = $entry['classe'] ?? 'Non précisé';
        }

        // Tri des sous-secteurs dans chaque groupe
        foreach ($grouped as &$list) {
            asort($list, SORT_NATURAL | SORT_FLAG_CASE);
        }

        // Tri des sections par nom complet (pas par code)
        uksort($grouped, function ($a, $b) {
            return strcasecmp(
                explode(' — ', $a, 2)[1] ?? $a,
                explode(' — ', $b, 2)[1] ?? $b
            );
        });

        return $grouped;
    }
}
