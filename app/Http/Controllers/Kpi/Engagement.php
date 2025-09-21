<?php

namespace App\Http\Controllers\Kpi;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Services\Kpi\EngagementService;


class Engagement extends Controller
{
    public function renderEngagement(string $week)
    {
        return view('kpi.partials.engagement',['week' => $week]);
    }

    public function jsonEngagement(string $week, EngagementService $svc)
    {
        return response()->json($svc->buildByRef($week));
    }

    public function renderEngagementType(string $week) {
        return view('kpi.partials.engagement-type', ['week' => $week]);
    }

    public function jsonEngagementType(string $week,EngagementService $svc)
    {
        return response()->json($svc->buildByType($week));
    }

    public function renderRespectEngagement(string $week) {
        return view('kpi.partials.respect-engagement', ['week' => $week]);
    }

    public function jsonRespectEngagement(string $week,EngagementService $svc) {
    return response()->json($svc->buildRespectEngagement($week));
    }
}
