<?php

namespace App\Http\Controllers\Kpi;

use App\Http\Controllers\Controller;

use App\Services\Kpi\PerformanceService;
use Illuminate\Http\Request;

class Performance extends Controller
{
        
    public function renderPerformance(string $week) {
        return view('kpi.partials.performance', ['week' => $week]);
    }

    public function jsonPerformance(string $week,PerformanceService $svc)
    {
        return response()->json($svc->build($week));
    }
}
