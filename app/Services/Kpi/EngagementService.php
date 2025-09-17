<?php

namespace App\Services\Kpi;

use App\Models\VueEngagementSynthese;

class EngagementService
{
   public function build(string $week)
   {
      $results= VueEngagementSynthese::query()->where('semaine_engagee', '=', $week)->get();
      $total_engagee = 0;
        $total_ponderee = 0;
        $annotations = [];
        $data = [
            [
                'name' => 'Réalisés',
                'data' => []
            ],
        ];
        if ($results) {
            foreach ($results as $result) {
                $total_engagee += $result->engagement;
                $total_ponderee += $result->engagement * $result->coefficient;
                $produit = floatval($result->produit ?? 0);
                $prete = $produit > 0 ? $produit : 0.05;

                $data[0]['data'][] = [
                    'x' => $result->reference,
                    'y' => $prete,
                    'fillColor' => $result->couleur,
                    'goals' => [[

                        'name' => 'Objectif',
                        'value' => $result->engagement,
                        'strokeHeight' => 3,
                        'strokeDashArray' => 5,
                        'strokeColor' => '#775DD0'

                    ]]
                ];


                if ($prete < $result->engagement) {
                    $annotations[] = [
                        'x' => $result->reference, // Position sur l'axe x (le label de la barre)
                        'y' => $result->engagement, // Position sur l'axe y (valeur de l'objectif)
                        'marker' => [
                            'size' => 0,
                            'fillColor' => '#775DD0',
                        ],
                        'label' => [
                            'text' => "$result->engagement",
                            'style' => [
                                'color' => '#775DD0',
                                'background' => '#fff', // Fond blanc pour être bien visible
                                'fontSize' => '20px',
                                'fontWeight' => 'bold'
                            ],
                            'offsetY' => 0 // Ajuster pour ne pas chevaucher la barre
                        ]
                    ];
                }
            }
        }

        $options = [
            "series" => $data,
            "title" => [
                "text" => $results 
                    ? "Engagement semaine $week - $total_engagee produits"
                    : "Aucun engagement trouvé pour la semaine $week"
            ],
            "annotations" => [
                "points" => $annotations
            ]
        ];

        if ($results) {
            $options["barWidth"] = intVal(100 / count($results)) . "%";
        }

        return $options ;

    }
   }

