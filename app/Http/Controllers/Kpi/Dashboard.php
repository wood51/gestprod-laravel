<?php

namespace App\Http\Controllers\Kpi;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class Dashboard extends Controller
{
    public function showDashboard()
    {
        $week = "2025-35";
        return view('kpi.dashboard', ['week' => $week]);
    }
}
