<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class LegalController extends Controller
{
    public function mentionsLegales()
    {
        return view('legal.mentions-legales');
    }

    public function politiqueConfidentialite()
    {
        return view('legal.politique-confidentialite');
    }

    public function cgv()
    {
        return view('legal.cgv');
    }

    public function cgu()
    {
        return view('legal.cgu');
    }
}
