<?php

namespace App\Services\Kpi;

use App\Models\Presence;
use App\Models\VueEngagementSynthese;

use Carbon\Carbon;

class PerformanceService
{
    public function build(string $week)
    {
        return $this->getNbOperateurSemaine($week);
    }

    private function getNbOperateurSemaine(?string $week = null)
    {

        if ($week) {
            [$annee, $semaine] = explode('-', $week);
        } else {
            $semaine = date('W');
            $annee   = date('o');
        }

        // Déterminer les dates de début et fin de la semaine
        $isoWeekStart = new Carbon()
            ->setISODate($annee, $semaine)
            ->startOfWeek(Carbon::MONDAY)
            ->startOfDay();

        $isoWeekEnd   = new Carbon()
            ->setISODate($annee, $semaine)
            ->endOfWeek(Carbon::SUNDAY)
            ->endOfDay();

        $rows = Presence::whereBetween('date_jour', [$isoWeekStart, $isoWeekEnd])->get();

        $totalHeuresNormales = 0;
        $totalHeuresSupp = 0;

        foreach ($rows as $presence) {
            $totalHeuresNormales += $presence->nb_operateurs * $presence->nb_heures_normales;
            $totalHeuresSupp += $presence->nb_operateurs * $presence->nb_heures_supp;
        }

        return $totalHeuresNormales;
    }
}
