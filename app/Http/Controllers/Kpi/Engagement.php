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
        return response()->json($svc->build($week));
    }
}
