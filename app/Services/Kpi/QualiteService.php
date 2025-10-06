<?php

namespace App\Services\Kpi;

use Illuminate\Support\Facades\DB;
use App\Models\VueQualiteDefaut;
use App\Models\GraviteDefaut;
use Carbon\Carbon;
use Carbon\CarbonPeriod;

class QualiteService
{
    /**
     * Calcul de l'indice de qualité pour une semaine donnée (Format 'YYYY-WW')
     * @param string $week
     * @return array{iq: float, majeurs: mixed, mineurs: mixed, nb_controles: mixed, no_defaut: mixed, semaine: string}
     */
    public function buildQualite(string $week)
    {
        return $this->calculIQ($week);
    }

    /**
     * Renvoie le calcul de IQ sur plusieurs semaines 
     * @param string $week
     * @param mixed $nb_week
     * @return array
     */
    public function buildQualiteMois(string $week, ?int $weekNumber = 4)
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

        $period = CarbonPeriod::create($startWeek, "1 week", $endWeek);

        $series = [
            [
                "name" => "Défauts Majeurs",
                "color" => "#Ff0000",
                "data" => []
            ],
            [
                "name" => "Défauts Mineurs",
                "color" => "#FBBF24",
                "data" => []
            ],
            [
                "name" => "Sans défauts",
                "color" => "#34D399",
                "data" => []
            ],
        ];

        foreach ($period as $date) {
            $w = $date->format('o-W');
            $results = $this->calculIQ($w);

             $series[0]["data"][] = [
                    "x" => $w,
                    "y" => $results["majeurs"]
                ];

                $series[1]["data"][] = [
                    "x" => "Sem. $w",
                    "y" => $results["mineurs"]
                ];

                $series[2]["data"][] = [
                    "x" => "Sem. $w",
                    "y" => $results["no_defaut"]
                ];
        }
        return $series;
    }

    /**
     * Calcul de l'indice de qualité pour une semaine donnée (Format 'YYYY-WW')
     * @param string $week
     * @return array{iq: float, majeurs: mixed, mineurs: mixed, nb_controles: mixed, no_defaut: mixed, semaine: string}
     */
    private function calculIQ(string $week)
    {
        [$annee, $semaine] = explode('-', $week);

        $startOfWeek = Carbon::now()->setISODate($annee, $semaine)->startOfWeek(Carbon::MONDAY);
        $endOfWeek = (clone $startOfWeek)->endOfWeek();

        $result = VueQualiteDefaut::whereBetween('date_controle', [$startOfWeek, $endOfWeek])
            ->selectRaw("
                COUNT(date_controle) AS total_controles, 
                SUM(CASE WHEN gravite IS NULL THEN 1 ELSE 0 END) AS no_defaut,
                SUM(CASE WHEN gravite = 'mineur' THEN 1 ELSE 0 END) AS mineurs,
                SUM(CASE WHEN gravite = 'majeur' THEN 1 ELSE 0 END) AS majeurs
            ")
            ->first();

        $total_controles = $result->total_controles ?? 0;
        $no_defaut = $result->no_defaut ?? 0;
        $mineurs  = $result->mineurs ?? 0;
        $majeurs = $result->majeurs ?? 0;

        $poids = GraviteDefaut::pluck('poids', 'libelle')->toArray();

        // Calcul de l'indice de qualité (IQ)
        $iq = ($total_controles > 0)
            ? (1 - (($majeurs * $poids['majeur'] + $mineurs * $poids['mineur']) / $total_controles)) * 100
            : $iq = 100; // Si aucun contrôle, l'indice de qualité est parfait 😁

        $result = [
            "semaine" => $semaine,
            "nb_controles" =>  $total_controles,
            "no_defaut" => $no_defaut,
            "mineurs" => $mineurs,
            "majeurs" => $majeurs,
            "iq" => round($iq, 2)
        ];
        return $result;
    }
}
