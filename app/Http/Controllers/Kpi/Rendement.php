<?php

namespace App\Http\Controllers\Kpi;

use App\Http\Controllers\Controller;

use App\Services\Kpi\RendementService;
use Illuminate\Http\Request;

class Rendement extends Controller
{
        
    public function renderRendementMois(string $week) {
        return view('kpi.partials.rendement-mois', ['week' => $week]);
    }

    public function jsonRendementMois(string $week,RendementService $svc)
    {
        return response()->json($svc->build($week));
    }
}
