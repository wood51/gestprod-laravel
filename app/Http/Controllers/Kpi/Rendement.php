<?php

namespace App\Http\Controllers\Kpi;

use App\Http\Controllers\Controller;

use App\Services\Kpi\RendementService;
use Illuminate\Http\Request;

class Rendement extends Controller
{
        
    public function renderRendementMois(string $week,int $nb_week) {
        return view('kpi.partials.rendement-mois', ['week' => $week,'nb_week'=>$nb_week]);
    }

    public function jsonRendementMois(string $week,int $nb_week,RendementService $svc)
    {
        return response()->json($svc->build($week,$nb_week));
    }
}
