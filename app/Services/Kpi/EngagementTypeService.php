<?php

namespace App\Services\Kpi;

use Illuminate\Support\Facades\DB;

use function Laravel\Prompts\clear;

class EngagementTypeService
{
    public function build(string $week): array
    {
        // Agréger par type_ensemble (une barre par type)
        $rows = DB::table('vue_engagement_syntheses')
            ->selectRaw('
                type_ensemble,
                SUM(produit)    AS produit,
                SUM(engagement) AS objectif,
                MAX(ordre_affichage) AS ordre_affichage
            ')
            ->where('semaine_engagee', $week)
            ->groupBy('type_ensemble')
            ->orderBy('ordre_affichage')
            ->get();

        //  Mise en forme ApexCharts
        $data = [];
        $points = [];
        $totProd = 0;
        $totObj = 0;

        foreach ($rows as $r) {
            $prod = (int) $r->produit;
            $obj = (int) $r->objectif;

            

            $data[] = [
                'x' => $r->type_ensemble,
                'y' => $prod,
                'fillColor' => $this->fillColor($prod, $obj),
                'goals' => [
                    [
                        'name' => 'Objectif',
                        'value' => $obj,
                        'strokeHeight' => 5,
                        'strokeColor' => '#a78bfa',
                    ]
                ],
            ];

            $points[] = [
                'x' => $r->type_ensemble,
                'y' => $obj,
                'marker' => ['size' => 0],
                'label' => [
                    'text' => $obj,
                    'style' => [
                        'color' => '#a78bfa',
                        'background' => '#fff',
                        'fontSize' => '20px',
                        'fontWeight' => 'bold',
                    ],
                ],
            ];

            $totProd += $prod;
            $totObj += $obj;
        }

        // 3) Barre "Total"
        $data[] = [
            'x' => 'Total',
            'y' => $totProd,
            'fillColor' => $this->fillColor($totProd, $totObj, true),
            'goals' => [
                [
                    'name' => 'Objectif',
                    'value' => $totObj,
                    'strokeHeight' => 5,
                    'strokeColor' => '#a78bfa',
                ]
            ],
        ];
        $points[] = [
            'x' => 'Total',
            'y' => $totObj,
            'marker' => ['size' => 0],
            'label' => [
                'text' => $totObj,
                'style' => [
                    'color' => '#a78bfa',
                    'background' => '#fff',
                    'fontSize' => '20px',
                    'fontWeight' => 'bold',
                ],
            ],
        ];

        // 4) Config finale (comme ton JSON actuel)
        return [
            'title' => [
                'text' => "Engagement Semaine {$week} - {$totObj} Produits",
                'align' => 'center',
                'style' => [
                    'fontSize' => '22px',
                    'color' => '#4B4B4B',
                    'fontWeight' => 'bold',
                ],
            ],
            'series' => [['data' => $data]],
            'annotations' => ['points' => $points],
        ];
    }

    private function fillColor(int $produit, int $objectif, bool $isTotal = false): string
    {
        // Règle simple : vert si >=100%, orange si 60-99%, rouge sinon.
        $ratio = $produit / max($objectif, 1);
        if ($ratio >= 1.0) return '#65a30d '; // vert
        if ($ratio >= 0.6) return '#f59e0b'; // orange
        return '#dc2626'; // rouge
    }
}
