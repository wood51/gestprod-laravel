<?php

namespace App\Services\Kpi;

use App\Models\Presence;
use App\Models\VueEngagementSynthese;

use Carbon\Carbon;

class PerformanceService
{
    public function build(string $week)
    {
        return $this->getNbOperateurSemaine();
    }

    private function getNbOperateurSemaine(?string $week = null)
    {
        if ($week) {
            [$semaine, $annee] = explode('-', $week);
        } else {
            $semaine = date('W');
            $annee   = date('o');
        }

        // Déterminer les dates de début et fin de la semaine
        $start = Carbon::now()->startOfWeek(Carbon::MONDAY);
        $end   = Carbon::now()->endOfWeek(Carbon::SUNDAY);

        return [$start,$end];
    }
}
