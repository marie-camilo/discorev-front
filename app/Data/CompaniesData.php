<?php

namespace App\Data;

use Illuminate\Support\Facades\Route;

/**
 * Cette classe simule une source de données pour toutes les entreprises partenaires.
 * En production, ces données proviendraient généralement d'une base de données.
 */
class CompaniesData
{
    private static function allCompanies(): array
    {
        // Fonction utilitaire pour générer des liens de démo si la fonction route n'est pas disponible (contexte de test pur)
        // Ceci évite des erreurs si la classe est chargée en dehors du contexte HTTP de Laravel.
        $route = function (string $name, array $parameters) {
            if (function_exists('route')) {
                return route($name, $parameters);
            }
            // Fallback générique pour les ID d'offres d'emploi
            $id = $parameters['id'] ?? 'default-job';
            return "/offres-emploi/{$id}";
        };


        return [
            // ENTREPRISE 1 : Tech Innov Solutions
            'tech-innov-solutions' => [
                'recruiterData' => (object) [
                    'companyName' => 'Tech Innov Solutions',
                    'slug' => 'tech-innov-solutions',
                    'banner' => '/img/bureau.jpg', // Placeholder
                    'logo' => '/img/azae-logo.png', // Placeholder
                    'sectorName' => 'Développement Logiciel',
                    'location' => 'Paris, France',
                    'teamSize' => '50-100 employés',
                    'contactEmail' => 'contact@techinnov.fr',
                    'contactPhone' => '+33 1 23 45 67 89',
                    'website' => 'https://www.techinnov.fr',
                    'siret' => '555 123 456 00018',
                    'teamVideoUrl' => 'https://www.youtube.com/embed/dQw4w9WgXcQ?controls=0',
                    'cta_label' => 'Découvrir nos offres', // Ajout du CTA pour l'exemple
                    'cta_link' => 'https://www.techinnov.fr/carrieres',
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
                            ['name' => 'Alice Dupont', 'role' => 'CEO & Fondatrice', 'email' => 'alice@techinnov.fr', 'avatar' => 'img/emilie-dupont.jpg'],
                            ['name' => 'Bob Martin', 'role' => 'Directeur Technique', 'email' => 'bob@techinnov.fr', 'avatar' => 'img/man-449406_640.jpg'],
                            ['name' => 'Carla Rossi', 'role' => 'Responsable Produit', 'email' => 'carla@techinnov.fr', 'avatar' => 'img/carla-rossi.jpg'],
                        ],
                    ],
                    [
                        'anchor' => 'galerie',
                        'label' => 'Galerie',
                        'type' => 'media',
                        'data' => [
                            (object)['filePath' => '/img/office/office_1.jpg', 'title' => 'Espace Détente'],
                            (object)['filePath' => '/img/office/office_2.jpg', 'title' => 'Postes de Travail'],
                            (object)['filePath' => '/img/office/office_3.jpg', 'title' => 'Salle de Réunion'],
                        ],
                    ],
                    [
                        'anchor' => 'medias',
                        'label' => 'Médias',
                        'type' => 'media',
                        'data' => [
                            (object)['filePath' => '/img/press/press_article_1.jpg', 'title' => 'Article Le Monde'],
                            (object)['filePath' => '/img/press/press_event_2.jpg', 'title' => 'Conférence Tech'],
                        ],
                    ],
                    [
                        'anchor' => 'temoignages',
                        'label' => 'Témoignages',
                        'type' => 'array',
                        'data' => [
                            [
                                'quote' => 'Travailler chez Tech Innov, c\'est l\'assurance de relever des défis passionnants avec une équipe soudée et innovante.',
                                'author' => 'Sophie Leclerc',
                                'role' => 'Lead Developer',
                            ],
                        ],
                    ],
                ],
                'jobOffers' => [
                    [
                        'title' => 'Développeur Fullstack Junior',
                        'contract' => 'CDI',
                        'location' => 'Paris',
                        'salary' => 'Selon profil',
                        'link' => $route('job_offers.show', ['id' => 'dev-junior']),
                    ],
                ],
            ],

            'victorine-immobilier' => [
                'recruiterData' => (object) [
                    'companyName' => 'VICTORINE IMMOBILIER',
                    'slug' => 'victorine-immobilier',
                    'banner' => '/victorine-immo/victorine-banner.jpg',
                    'logo' => '/victorine-immo/logo-victorine-immobilier.png',
                    'sectorName' => 'Immobilier, Transaction, Location & Viager',
                    'location' => 'Paris & Lyon',
                    'teamSize' => '2 gérantes + Partenaires',
                    'contactEmail' => 'contact@victorine-immobilier.com',
                    'contactPhone' => '06 50 50 03 06',
                    'website' => 'https://victorine-immobilier.com',
                    'siret' => '838 606 945 00015',
                    'teamVideoUrl' => null,
                    'cta_label' => 'Confiez-nous votre projet clé en main',
                    'cta_link' => 'https://victorine-immobilier.com',
                    'key_figures' => [
                        'Existence' => 'Depuis 8 ans.',
                        'Dossiers traités' => 'Près de 300 dossiers.',
                    ]
                ],
                'sectionsData' => [
                    [
                        'anchor' => 'presentation',
                        'label' => 'Présentation & Expertise',
                        'type' => 'text',
                        'data' => "Victorine Immobilier est une agence née d’une conviction simple : chaque projet mérite un accompagnement sur mesure, humain et attentif. Nous avançons aux côtés de nos clients comme on le ferait d’un proche, en prenant le temps d’écouter leur histoire, leurs attentes et leurs contraintes. Notre approche s’inscrit dans la tradition du conseil immobilier sérieux, où la confiance et la transparence restent les fondements de toute relation réussie. Nous intervenons en transaction classique, en location, mais aussi dans des domaines plus spécifiques qui exigent expertise et délicatesse : le viager et la nue-propriété. Ces solutions patrimoniales offrent de véritables opportunités, tant pour les seniors qui souhaitent améliorer leur confort de vie que pour les acquéreurs en recherche d’un investissement pérenne. Chez Victorine Immobilier, nous maîtrisons les mécanismes, la fiscalité et les enjeux humains liés au viager, et nous savons guider chaque partie vers une décision sereine, équilibrée et sécurisée. De la première rencontre à la remise des clés, nous assurons un suivi complet : estimation, stratégie, mise en valeur, diagnostics, coordination notariale, mise en gestion… Notre mission est d’apporter une réponse claire à chaque étape, avec rigueur et bienveillance. Victorine Immobilier, c’est l’engagement d’un accompagnement personnalisé, fidèle à des valeurs de sérieux, de respect et de service.",
                    ],
                    [
                        'anchor' => 'valeurs',
                        'label' => 'Culture & Valeurs d\'Entreprise',
                        'type' => 'text',
                        'data' => "Victorine Immobilier défend des valeurs fondées sur l’écoute, la confiance et l’accompagnement sur-mesure. L’agence privilégie une approche humaine, attentive à chaque parcours de vie, et met son expertise — notamment en viager — au service de décisions sereines, éclairées et respectueuses des traditions immobilières.",
                    ],
                    [
                        'anchor' => 'equipe',
                        'label' => 'Notre Équipe & Collaborateurs',
                        'type' => 'array',
                        'key' => 'teamMembers',
                        'data' => [
                            [
                                'name' => 'Amandine FAYET',
                                'role' => 'Présidente & Fondatrice',
                                'linkedin' => 'https://www.linkedin.com/in/amandinefayet/',
                                'description' => "Amandine Fayet est la fondatrice et responsable de l’agence Victorine Immobilier, où elle exerce comme agente immobilière en charge de la transaction, de la location et de la chasse immobilière, notamment sur Paris et Lyon. Elle est gérante / responsable d’agence et reste l’interlocutrice principale pour les projets. Elle met en avant une expertise en transaction, location et accompagnement sur mesure, avec une approche « à taille humaine » centrée sur le conseil et la proximité avec les clients.",
                                'avatar' => '/victorine-immo/amandine-fayet.jpeg'
                            ],
                            [
                                'name' => 'Florence Giraud',
                                'role' => 'Conseillère / Agente Immobilière',
                                'linkedin' => 'https://fr.linkedin.com/in/florencegiraud',
                                'description' => "Florence Giraud est conseillère / agente immobilière au sein de l’agence Victorine Immobilier, active sur Paris et Lyon. Juriste de formation en droit des affaires, avec plus de dix ans d’expérience dans la transaction immobilière à Paris et en Île-de-France, elle accompagne ses clients sur les aspects juridiques et contractuels. Elle a rejoint Amandine Fayet et met en avant un accompagnement personnalisé des vendeurs et acquéreurs.",
                                'avatar' => '/victorine-immo/florence-giraud.jpg'
                            ],
                        ],
                    ],
                    [
                        'anchor' => 'organisation',
                        'label' => 'Organisation du Travail',
                        'type' => 'text',
                        'data' => "Notre organisation est centrée sur l'agilité et l'expertise spécialisée. Nous travaillons avec des outils modernes de gestion immobilière (CRM) et assurons un suivi complet de la stratégie d'estimation jusqu'à la coordination notariale. La sélection de nos partenaires et collaborateurs (notaires, huissiers, experts) se fait sur des critères de rigueur, de transparence et de complémentarité d'expertise, notamment pour la gestion de biens et les montages viagers.",
                    ],
                    [
                        'anchor' => 'temoignages',
                        'label' => 'Avis & Recommandations',
                        'type' => 'array',
                        'data' => [
                            [
                                'quote' => 'Un accompagnement exceptionnel, humain et très professionnel. L\'expertise sur le viager est rassurante et précieuse.',
                                'author' => 'Client (source RealAdvisor)',
                                'role' => 'Vendeur',
                                'link' => 'https://realadvisor.fr/fr/agents-immobiliers/agent-amandine-florence-victorine#agent-reviews'
                            ],
                            [
                                'quote' => 'Rareté dans l’immobilier : une écoute réelle de nos besoins et des conseils toujours orientés vers notre intérêt. Je recommande Victorine Immobilier sans hésiter.',
                                'author' => 'Client (source Google)',
                                'role' => 'Acheteur',
                                'link' => 'https://share.google/w5PT4YOQnrr7Rt7HZ'
                            ],
                        ],
                    ],
                    [
                        'anchor' => 'medias',
                        'label' => 'Nos Actions & Médias',
                        'type' => 'media',
                        'data' => [
                            (object)['filePath' => '/img/victorine/visite_virtuelle.jpg', 'title' => 'Visite virtuelle de biens'], // Placeholder
                            (object)['filePath' => '/img/victorine/notaire_partenaire.jpg', 'title' => 'Coordination notariale'], // Placeholder
                        ],
                    ],
                ],
                'jobOffers' => [
                    [
                        'title' => 'Rejoindre notre réseau de partenaires',
                        'contract' => 'Collaboration',
                        'location' => 'France',
                        'salary' => 'Selon collaboration',
                        'link' => 'mailto:contact@victorine-immobilier.com',
                    ],
                ],
            ],

            // ENTREPRISE 3 : Depan.PRO
            'depan-pro' => [
                'recruiterData' => (object) [
                    'companyName' => 'Depan.PRO – SAS',
                    'slug' => 'depan-pro',
                    'banner' => '/img/depanpro/banner_depannage.jpg',
                    'logo' => '/img/depanpro/logo_depanpro.png',
                    'sectorName' => 'Services d\'Urgence & Artisanat',
                    'location' => 'France',
                    'teamSize' => '+40 Techniciens Partenaires',
                    'contactEmail' => 'contact@depan-pro.com',
                    'contactPhone' => '07 61 30 62 60',
                    'website' => 'https://www.depan-pro.com/',
                    'siret' => '992 525 576',
                    'teamVideoUrl' => null,
                    'cta_label' => 'Réserver un dépannage en urgence',
                    'cta_link' => 'https://www.depan-pro.com/',
                    'creation_year' => '2024',
                    'key_figures' => [
                        'Réseau d’artisans partenaires' => '+40 techniciens certifiés',
                        'Clients accompagnés' => '+1 200 interventions réalisées',
                        'Taux de satisfaction client' => '4,8/5',
                        'Temps moyen de prise en charge' => '15 minutes',
                        'Taux de réparation avant remplacement' => '63 %',
                        'Zones couvertes' => 'Île-de-France + expansion nationale',
                    ]
                ],
                'sectionsData' => [
                    [
                        'anchor' => 'presentation',
                        'label' => 'Présentation & Mission',
                        'type' => 'text',
                        'data' => "Rétablir la confiance dans l'urgence. Depan.PRO est une start-up innovante spécialisée dans le dépannage d’urgence (serrurerie, plomberie, électricité, dégorgement). Fondée en 2024, notre entreprise est née d'une volonté claire : mettre fin à l'opacité du secteur en offrant rapidité, transparence et fiabilité. Notre mission est d'apporter un service d’urgence de qualité supérieure, avec des prix connus à l’avance et un réseau d'artisans certifiés et rigoureusement sélectionnés. Grâce à notre plateforme, nous connectons immédiatement nos clients avec le dépanneur le plus adapté et le plus proche, tout en favorisant une approche éco-responsable axée sur la réparation avant le remplacement. Depan.PRO s'impose comme la nouvelle référence du dépannage, centrée sur la confiance et l'excellence.",
                    ],
                    [
                        'anchor' => 'valeurs',
                        'label' => 'Culture et Valeurs',
                        'type' => 'text',
                        'data' => "Chez Depan.PRO, nous façonnons l'avenir du dépannage autour de valeurs fortes qui garantissent un service plus humain et responsable : \n\n* **Transparence totale** : Devis clair, prix affichés à l’avance, zéro surprise ni abus. \n* **Éco-responsabilité** : Notre priorité est de réparer avant de remplacer, réduisant ainsi l'impact environnemental. \n* **Excellence technique** : Nous sélectionnons, certifions et accompagnons nos artisans pour une qualité d'intervention irréprochable. \n* **Valorisation des Artisans** : Nous assurons une rémunération juste et des conditions de travail équitables à nos partenaires, reconnaissant leur expertise. \n* **Respect du Client** : Écoute, pédagogie et suivi post-intervention sont au cœur de notre relation client.",
                    ],
                    [
                        'anchor' => 'reseau-description',
                        'label' => 'Notre Réseau d\'Artisans',
                        'type' => 'text',
                        'data' => "Notre force réside dans notre réseau de dépanneurs partenaires, certifiés et triés sur le volet. Chaque artisan est évalué selon trois critères fondamentaux : **expertise technique**, **sens du service** et **respect de notre charte éthique** (prix fixes, transparence, engagement écologique). Cette sélection rigoureuse garantit que chaque intervention est non seulement rapide et efficace, mais aussi honnête et professionnelle.",
                    ],

                    [
                        'anchor' => 'equipe', // Ancre standard pour la liste des membres/partenaires
                        'label' => 'Partenaire Clé',
                        'type' => 'array',
                        'key' => 'teamMembers',
                        'data' => [
                            [
                                'name' => 'Steven Malonga',
                                'role' => 'Partenaire artisan – Serrurier, plombier, électricien certifié',
                                'email' => 'contact@depan-pro.com',
                                'phone' => '07 61 30 62 60',
                                'avatar' => '/img/avatars/steven-malonga.jpg', // Placeholder
                                'linkedin' => 'http://linkedin.com/in/steven-malonga-2b454b172'
                            ],
                        ],
                    ],
                    [
                        'anchor' => 'fonctionnement',
                        'label' => 'Organisation du Travail',
                        'type' => 'text',
                        'data' => "L'efficacité de Depan.PRO repose sur une organisation optimisée et axée sur l'urgence :\n\n* **Dispatch Intelligent** : Notre système interne identifie et envoie instantanément le technicien le plus proche et le mieux qualifié pour le type de panne.\n* **Process d'Urgence Standardisé** : Qualification du besoin → Devis clair et immédiat → Intervention rapide → Suivi client.\n* **Sélection des Partenaires** : Nous exigeons vérification des diplômes, casier B2 vierge, assurance à jour et validation par un test terrain.\n* **Outils** : Utilisation du CRM Depan.PRO pour le suivi, WhatsApp Business pour la communication client/artisan, et la signature électronique pour la rapidité administrative.",
                    ],
                    [
                        'anchor' => 'temoignages',
                        'label' => 'Avis & Témoignages',
                        'type' => 'array',
                        'data' => [
                            [
                                'quote' => 'Service impeccable : devis clair, intervention rapide, aucune mauvaise surprise.',
                                'author' => 'Laura M.',
                                'role' => 'Client Particulier',
                            ],
                            [
                                'quote' => 'Enfin un dépanneur fiable. Le technicien a réparé ma serrure sans pousser au remplacement.',
                                'author' => 'Karim D.',
                                'role' => 'Client Particulier',
                            ],
                            [
                                'quote' => 'Partenaire depuis 2025 : Depan.PRO valorise réellement le travail des artisans et garantit une rémunération juste.',
                                'author' => 'Julien R.',
                                'role' => 'Plombier Certifié (Partenaire)',
                            ],
                        ],
                    ],
                    [
                        'anchor' => 'galerie',
                        'label' => 'Galerie d\'Interventions',
                        'type' => 'media',
                        'data' => [
                            (object)['filePath' => '/img/depanpro/intervention_plombier.jpg', 'title' => 'Plombier en action'],
                            (object)['filePath' => '/img/depanpro/intervention_serrurier.jpg', 'title' => 'Serrurier : réparation de porte'],
                        ],
                    ],
                ],
                'jobOffers' => [
                    [
                        'title' => 'Devenez Artisan Partenaire Certifié',
                        'contract' => 'Collaboration Indépendante',
                        'location' => 'France entière',
                        'salary' => 'Rémunération équitable et juste',
                        'link' => $route('job_offers.show', ['id' => 'artisan-partenaire']),
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

    /**
     * Récupère les données de l'entreprise à mettre en avant (la première par défaut).
     * @return object|null Les données 'recruiterData' de l'entreprise ou null.
     */
    public static function getFeaturedCompanyData(): ?object
    {
        $all = self::allCompanies();
        // Récupère la première entrée dans le tableau
        $firstCompany = reset($all);

        return $firstCompany['recruiterData'] ?? null;
    }
}
