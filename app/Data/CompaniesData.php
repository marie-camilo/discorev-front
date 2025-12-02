<?php

namespace App\Data;

class CompaniesData
{
    private static function allCompanies(): array
    {
        return [
            // ENTREPRISE 1 : Tech Innov Solutions
            'tech-innov-solutions' => [
                'recruiterData' => (object) [
                    'companyName' => 'Tech Innov Solutions',
                    'slug' => 'tech-innov-solutions', // L'identifiant clé
                    'banner' => '/img/bureau.jpg',
                    'logo' => '/img/azae-logo.png',
                    'sectorName' => 'Développement Logiciel',
                    'location' => 'Paris, France',
                    'teamSize' => '50-100 employés',
                    'contactEmail' => 'contact@techinnov.fr',
                    'contactPhone' => '+33 1 23 45 67 89',
                    'website' => 'https://www.techinnov.fr',
                    'siret' => '555 123 456 00018',
                ],
                'sectionsData' => [
                    [
                        'anchor' => 'presentation',
                        'label' => 'Présentation',
                        'type' => 'text',
                        'data' => 'Tech Innov est un leader dans la création de solutions SaaS innovantes pour les PME. Fondée en 2018, notre mission est de simplifier la gestion d\'entreprise grâce à des technologies de pointe.',
                    ],
                    [
                        'anchor' => 'equipe',
                        'label' => 'Notre Équipe',
                        'type' => 'array',
                        'key' => 'teamMembers',
                        'data' => [
                            ['name' => 'Alice Dupont', 'role' => 'CEO & Fondatrice', 'email' => 'alice@techinnov.fr', 'avatar' => 'img/avatars/alice.jpg'],
                            ['name' => 'Bob Martin', 'role' => 'Directeur Technique', 'email' => 'bob@techinnov.fr', 'avatar' => 'img/avatars/bob.jpg'],
                        ],
                    ],
                    [
                        'anchor' => 'galerie',
                        'label' => 'Galerie',
                        'type' => 'media',
                        'data' => [
                            (object)['filePath' => '/img/media/office1.jpg', 'title' => 'Nos bureaux'],
                            (object)['filePath' => '/img/media/team_event.jpg', 'title' => 'Événement d\'équipe'],
                        ],
                    ],
                ],
            ],
            // ENTREPRISE 2 : Future Corp (Exemple pour le dynamisme)
            'future-corp' => [
                'recruiterData' => (object) [
                    'companyName' => 'Future Corp',
                    'slug' => 'future-corp',
                    'banner' => '/img/banners/futurecorp_banner.jpg',
                    'logo' => '/img/logos/futurecorp_logo.png',
                    'sectorName' => 'Finance & Tech',
                    'location' => 'Lyon, France',
                    'teamSize' => '200+ employés',
                    'contactEmail' => 'hello@futurecorp.com',
                    'contactPhone' => '+33 4 98 76 54 32',
                    'website' => 'https://www.futurecorp.com',
                    'siret' => '888 777 666 00025',
                ],
                'sectionsData' => [
                    [
                        'anchor' => 'presentation',
                        'label' => 'Présentation',
                        'type' => 'text',
                        'data' => 'Future Corp révolutionne le secteur financier avec des outils d\'IA prédictive pour les investisseurs. Notre environnement est axé sur la performance et l\'excellence.',
                    ],
                    [
                        'anchor' => 'equipe',
                        'label' => 'Notre Équipe',
                        'type' => 'array',
                        'key' => 'teamMembers',
                        'data' => [
                            ['name' => 'Carole Dubois', 'role' => 'CFO', 'email' => 'carole@futurecorp.com', 'avatar' => 'img/avatars/carole.jpg'],
                            ['name' => 'David Smith', 'role' => 'Data Scientist', 'email' => 'david@futurecorp.com', 'avatar' => 'img/avatars/david.jpg'],
                        ],
                    ],
                    [
                        'anchor' => 'galerie',
                        'label' => 'Galerie',
                        'type' => 'media',
                        'data' => [
                            (object)['filePath' => '/img/media/lyon_office.jpg', 'title' => 'Vue du bureau'],
                            (object)['filePath' => '/img/media/meeting.jpg', 'title' => 'Réunion'],
                        ],
                    ],
                ],
            ],
        ];
    }

    /**
     * Récupère les données d'une entreprise par son slug.
     * @param string $slug Le slug de l'entreprise.
     * @return array|null Les données de l'entreprise ou null si non trouvée.
     */
    public static function getCompanyBySlug(string $slug): ?array
    {
        return self::allCompanies()[$slug] ?? null;
    }

    /**
     * Récupère une liste simple de toutes les entreprises pour la page d'accueil ou les partenaires.
     * @return array
     */
    public static function getPartnerList(): array
    {
        $list = [];
        foreach (self::allCompanies() as $slug => $company) {
            $list[] = (object) [
                'slug' => $slug,
                'companyName' => $company['recruiterData']->companyName,
                'logo' => $company['recruiterData']->logo,
                'sectorName' => $company['recruiterData']->sectorName,
                'location' => $company['recruiterData']->location,
            ];
        }
        return $list;
    }
}
