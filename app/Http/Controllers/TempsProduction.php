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

        $vendredi = 1;

        $debut = Carbon::createFromFormat('d/m/Y H:i', '04/09/2025 08:30');
        $fin = Carbon::createFromFormat('d/m/Y H:i', '10/09/2025 13:48');
        echo $debut . "<br>";
        echo $fin . "<br>";

        // Jours trvaillé 0-3 , 4 en HS 
        // $period = CarbonPeriod::create($debut->next(Carbon::FRIDAY), '1 week', $fin);
        // $vendredi_period = iterator_count($period);

        $period=CarbonPeriod::create($debut, '1 minute', $fin);
        foreach($period as $date) {
            if ($date->day===5 && $vendredi === 0) {
                continue;
            } 
            $vendredi--;
            echo $date->format('Y-m-d') .'<br>';
        }


        return; //response()->json([

        //]);
    }
}
