<?php

namespace App\Services\Kpi;

use App\Models\Presence;
use App\Models\VueEngagementSynthese;
use Illuminate\Support\Facades\DB;

use Carbon\Carbon;
use Carbon\CarbonInterface;
use Carbon\CarbonPeriod;
use Carbon\CarbonInterval;

class RendementService
{
    public function build(?string $week = null, ?int $weekNumber = 4)
    {
        if ($week) {
            [$annee, $semaine] = explode('-', $week);
        } else {
            $semaine = date('W');
            $annee   = date('o');
        }

        $endWeek = Carbon::now()->setISODate($annee, $semaine)
            ->startOfWeek(Carbon::MONDAY)
            ->startOfDay();

        $startWeek = $endWeek->copy()->subWeeks($weekNumber - 1);

        $period = new CarbonPeriod($startWeek, "1 week", $endWeek);

        $serie = [
            "name" => "Performance",
            "color" => "#4338ca",
            "data" => []
        ]; 


        foreach ($period as $date) {
            $w =  $date->format("o-W");
            $capaciteHomme = $this->getRessourceHomme($w);
            $capaciteProduit = $this->getCapaciteProduit($capaciteHomme);
            $produitRealise = $this->getProduitRealise($w);

            $serie['data'][] = [
                "x" => $w,
                "y" => $capaciteProduit ? ($produitRealise / $capaciteProduit) : 0
            ];
        }

        return $serie;
    }

    private function getRessourceHomme(?string $week = null)
    {

        if ($week) {
            [$annee, $semaine] = explode('-', $week);
        } else {
            $semaine = date('W');
            $annee   = date('o');
        }

        // Déterminer les dates de début et fin de la semaine
        $isoWeekStart = Carbon::now()
            ->setISODate($annee, $semaine)
            ->startOfWeek(Carbon::MONDAY)
            ->startOfDay();

        $isoWeekEnd   = Carbon::now()
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

    private function getCapaciteProduit(float $capaciteHomme)
    {
        // INFO : division pas 35 car coeff basés sur 35H 
        // TODO ?: Passer par des heure réelle de fab plutôt que des coeff
        return $capaciteHomme / 35;
    }

    private function getProduitRealise(string $week)
    {
        $realise = VueEngagementSynthese::where('semaine_engagee', '=', $week)
            ->sum(DB::raw('coefficient * produit'));
        return $realise;
    }
}
