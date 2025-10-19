<?php

namespace App\Helpers;

class NafHelper
{
    public static function getLabel(string $code): ?string
    {
        $entries = self::loadNafJson(); // Charge le JSON complet
        return $entries[$code]['classe'] ?? $entries[$code] ?? $code;
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
            'social',
            'médico',
            'hospital',
            'aide à la personne',
            'aide à domicile',
            'services à la personne',
            'soins',
            'infirmier',
            'médecin',
            'médical',
            'rééducation',
            'handicap',
            'personnes âgées',
            'enfants',
            'adultes',
            'toxicomanes',
            'accueil',
            'accompagnement',
            'ambulances',
            'laboratoire',
            'dentaire',
            'sages-femmes',
            'rééducation',
            'appareillage',
            'assistance sociale'
        ];

        $filtered = array_filter($entries, function ($entry) use ($keywords) {
            $lib = mb_strtolower($entry['classe']);

            foreach ($keywords as $word) {
                if (str_contains($lib, mb_strtolower($word))) {
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
}
