<?php

namespace App\Http\Controllers;

use App\Services\DiscorevApiService;

abstract class Controller
{
    private DiscorevApiService $api;

    public function __construct(DiscorevApiService $api)
    {
        $this->api = $api;
    }
}
