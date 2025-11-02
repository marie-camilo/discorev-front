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

    /**
     * Filtre les secteurs sociaux, médico-sociaux et sanitaires
     * et trie par ordre alphabétique
     */
    public static function filterSectors(array $entries): array
    {
        // Mots-clés pour couvrir tous les secteurs pertinents
        $keywords = [
            'santé',
            'medical',
            'médicaux',
            'médico',
            'social',
            'sociaux',
            'aide',
            'domicile',
            'personne',
            'personnes',
            'handicap',
            'handicapés',
            'handicapées',
            'soin',
            'soins',
            'infirmier',
            'infirmière',
            'médecin',
            'hôpital',
            'hospitalier',
            'enfant',
            'enfants',
            'crèche',
            'garde',
            'accueil',
            'accompagnement',
            'rééducation',
            'orthophonie',
            'kiné',
            'dent',
            'dentaire',
            'sage-femme',
            'ambulance',
            'laboratoire',
            'analyses',
            'pharmacie',
            'ehpad',
            'résidence',
            'hébergement',
            'personnes âgées',
            'aînés',
            'sociale',
            'sociales',
            'soignant',
            'soignants',
            'assistance',
            'formation',
            'soutien',
            'numérique'
        ];

        $filtered = array_filter($entries, function ($entry) use ($keywords) {
            $lib = mb_strtolower($entry['classe']);

            foreach ($keywords as $word) {
                if (preg_match('/\b' . preg_quote($word, '/') . 's?\b/i', $lib)) {
                    return true;
                }
            }

            return false;
        });

        // Réindexe par code_classe
        $result = [];
        foreach ($filtered as $e) {
            $result[$e['code_classe']] = $e['classe'];
        }

        // Tri alphabétique par libellé
        asort($result, SORT_NATURAL | SORT_FLAG_CASE);

        return $result;
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

    public static function groupByLetter(array $entries): array
    {
        $grouped = [];

        foreach ($entries as $entry) {
            $letter = $entry['code_section'] ?? '?';
            $grouped[$letter][$entry['code_classe']] = $entry['classe'] ?? 'Non précisé';
        }

        // Tri des sous-secteurs dans chaque groupe
        foreach ($grouped as &$list) {
            asort($list, SORT_NATURAL | SORT_FLAG_CASE);
        }

        // Tri alphabétique des lettres
        ksort($grouped, SORT_NATURAL | SORT_FLAG_CASE);

        return $grouped;
    }
}
