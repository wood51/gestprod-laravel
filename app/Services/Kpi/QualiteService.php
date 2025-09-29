<?php

namespace App\Services\Kpi;

class QualiteService
{
    public function buildQualite(string $week)
    {

        // $f3 = Base::instance();
        // $db = $f3->DB;
        // $gravite = new DB\SQL\Mapper($db, 'qualite_gravite_defaut');
        // try {
        //     [$annee_number, $semaine_number] = explode("-", $semaine);

        //     $sql = "SELECT 
        //                 COUNT(*) AS total_controles, 
        //                 SUM(CASE WHEN gravite IS NULL THEN 1 ELSE 0 END) AS no_defaut,
        //                 SUM(CASE WHEN gravite = 'mineur' THEN 1 ELSE 0 END) AS mineurs,
        //                 SUM(CASE WHEN gravite = 'majeur' THEN 1 ELSE 0 END) AS majeurs
        //             FROM vue_qualite_defauts
        //             WHERE WEEKOFYEAR(date_controle) = ? AND YEAR(date_controle) = ?";

        //     $result = $db->exec($sql, [$semaine_number, $annee_number]);
        //     $data = $result[0];

        //     $total_controles = $data['total_controles'];
        //     $mineurs = $data['mineurs'];
        //     $majeurs = $data['majeurs'];

        //     // Extraction des poids des défauts
        //     $poids = array_combine(
        //         array_column($gravite->find(), 'libelle'),
        //         array_column($gravite->find(), 'poids')
        //     );

        //     // Calcul de l'indice de qualité (IQ)
        //     if ($total_controles > 0) {
        //         $iq = (1 - (($majeurs * $poids['majeur'] + $mineurs * $poids['mineur']) / $total_controles)) * 100;
        //     } else {
        //         $iq = 100; // Si aucun contrôle, l'indice de qualité est parfait
        //     }

        //     $result = [
        //         "semaine" => $semaine_number,
        //         "nb_controles" =>  $total_controles,
        //         "no_defaut" => $data['no_defaut'],
        //         "mineurs" => $mineurs,
        //         "majeurs" => $majeurs,
        //         "iq" => $iq
        //     ];

        //     return $result;
        // } catch (\Exception $e) {
        //     throw new \Exception("Erreur lors du calcul des défauts: " . $e->getMessage());
        // }
        return [];
  
    }

    public function buildQualiteMois(string $week)
    {
        return [];
    }
}
