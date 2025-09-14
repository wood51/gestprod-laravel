<?php

namespace App\Http\Controllers\Kpi;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Services\Kpi\EngagementTypeService;

class EngagementType extends Controller
{
    

    public function engagementType(string $week,EngagementTypeService $svc)
    {
        return response()->json($svc->build($week));
    }
}
