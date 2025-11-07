<?php

namespace App\Http\Controllers;

use App\Services\DiscorevApiService;

class HomeController extends Controller
{
    public function __construct(DiscorevApiService $api)
    {
        parent::__construct($api);
    }

    public function index()
    {
        $companies = [
            [
                'name' => 'Le Petit Jean',
                'description' => 'Une équipe engagée pour un impact social fort.',
                'link' => 'https://lepetitjean-grenoble.com/',
                'image' => 'img/petit-jean.jpg',
            ],
            [
                'name' => 'Altidom',
                'description' => 'Des services à domicile avec l’exigence du monde professionnel.',
                'link' => 'https://altidom.com/',
                'image' => 'img/altidom/altidom.webp',
            ],
            [
                'name' => 'Kiddobee',
                'description' => 'Découvrez leurs opportunités et valeurs.',
                'link' => 'https://www.kiddobee.com/fr',
                'image' => 'img/kiddobee/kiddobee.jpg',
            ],
        ];

        return view('welcome', compact('companies'));
    }
}
