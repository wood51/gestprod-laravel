<?php

namespace App\Services\Kpi;

use App\Models\Presence;
use App\Models\VueEngagementSynthese;
use Illuminate\Support\Facades\DB;

use Carbon\Carbon;

class RendementService
{
    public function build(string $week)
    {
        $capaciteHomme = $this->capaciteHomme($week);
        $AlternateurEquivament = $this->getAlternateurEquivalent($capaciteHomme);
        $realise = $this->getRealise($week);

        return [
            'capacitée homme (en h)' => $capaciteHomme,
            'alternateur equivalents' => $AlternateurEquivament,
            'realise' => $realise,
            'rendement' => ($realise / $AlternateurEquivament) * 100
        ];
    }

    private function capaciteHomme(?string $week = null)
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

        return $totalHeuresNormales + $totalHeuresSupp;
    }

    private function getAlternateurEquivalent(float $capaciteHomme)
    {
        return $capaciteHomme / 35;
    }

    private function getRealise(string $week)
    {
        $realise = VueEngagementSynthese::where('semaine_engagee', '=', $week)
            ->sum(DB::raw('coefficient * produit'));
        return $realise;
    }
}
