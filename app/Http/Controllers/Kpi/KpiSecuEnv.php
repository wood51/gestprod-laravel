<?php

namespace App\Http\Controllers\Kpi;

use App\Http\Controllers\Controller;
use App\Models\Securite;
use Doctrine\DBAL\Schema\View;
use Illuminate\Http\Request;

class KpiSecuEnv extends Controller
{
    public function index() {
        $a  = Securite::all();
       

       // return View('kpi.partials.secu-env');
    }

}
