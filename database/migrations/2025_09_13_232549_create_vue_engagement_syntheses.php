<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
              DB::statement("
            CREATE OR REPLACE
            ALGORITHM = UNDEFINED VIEW `vue_engagement_syntheses` AS
            SELECT
                pe.semaine_engagee AS semaine_engagee,
                DATE_FORMAT(
                    STR_TO_DATE(CONCAT(pe.semaine_engagee, ' Monday'), '%x-%v %W'),
                    '%Y-%m'
                ) AS mois_key,
                pa.reference AS reference,
                ptse.designation AS type_sous_ensemble,
                pte.libelle AS type_ensemble,
                pa.coefficient AS coefficient,
                pa.couleur AS couleur,
                pte.ordre_affichage AS ordre_affichage,
                COUNT(pe.id) AS engagement,
                SUM(CASE WHEN pe.status = 'fait' THEN 1 ELSE 0 END) AS produit,
                SUM(CASE WHEN pe.status = 'reporte' THEN 1 ELSE 0 END) AS reporte
            FROM engagements pe
            JOIN realisations pp ON pe.realisation_id = pp.id
            JOIN articles pa ON pp.article_id = pa.id
            JOIN type_sous_ensembles ptse ON pa.type_sous_ensemble_id = ptse.id
            JOIN type_ensembles pte ON pa.type_sous_ensemble_id = pte.type_sous_ensemble_id
            GROUP BY
                pa.reference,
                pe.semaine_engagee,
                ptse.designation,
                pte.libelle,
                pa.coefficient,
                pa.couleur,
                pte.ordre_affichage
        ");
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        DB::statement("DROP VIEW IF EXISTS vue_engagement_syntheses");
    }
};
