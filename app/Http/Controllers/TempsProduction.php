<?php

namespace App\Http\Controllers;

use Cmixin\BusinessDay;
use Carbon\Carbon;
use Carbon\CarbonPeriod;
use Illuminate\Http\Request;

class TempsProduction extends Controller
{
    public function tempsProduction()
    {

        $debut = Carbon::createFromFormat('d/m/Y H:i', '04/09/2025 08:30');
        $fin = Carbon::createFromFormat('d/m/Y H:i', '10/09/2025 13:48');
        echo $debut."<br>";
        echo $fin."<br>";
        
        // Jours trvaillé 0-3 , 4 en HS 
        $period = CarbonPeriod::create($debut->next(Carbon::FRIDAY), '1 week', $fin);
        dd(iterator_count($period));

        return ;//response()->json([

        //]);
    }
}
