<?php

namespace App\Http\Controllers\Kpi;

use App\Http\Controllers\Controller;
use Doctrine\DBAL\Schema\View;
use Illuminate\Http\Request;

class KpiSecuEnv extends Controller
{
    public function index() {
        return View('kpi.partials.secu-env');
    }
}
