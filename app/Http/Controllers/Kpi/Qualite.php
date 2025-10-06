<?php

namespace App\Http\Controllers\Kpi;

use App\Services\Kpi\QualiteService;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class Qualite extends Controller
{

    public function renderQualite() {}

    public function jsonQualite(string $week, QualiteService $svc)
    {
        return response()->json($svc->buildQualite($week));
    }

    public function renderQualiteMois() {
        return view('kpi.partials.qualite-mois');
    }

    public function jsonQualiteMois(string $week,?int $weekNumber=5, QualiteService $svc)
    {
        return response()->json($svc->buildQualiteMois($week));
    }
}
