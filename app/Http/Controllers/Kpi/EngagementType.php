<?php

namespace App\Http\Controllers\Kpi;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Services\Kpi\EngagementTypeService;

class EngagementType extends Controller
{
    
    public function renderEngagementType(string $week) {
        return view('kpi.partials.engagement-type', ['week' => $week]);
    }

    public function jsonEngagementType(string $week,EngagementTypeService $svc)
    {
        return response()->json($svc->build($week));
    }
}
