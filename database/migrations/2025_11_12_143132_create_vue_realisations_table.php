<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
        public function up(): void
    {
        DB::statement("
        CREATE OR REPLACE VIEW vue_realisations AS
        SELECT
            pp.id,
            pa.reference,
            pa.couleur AS reference_couleur,
            ptse.designation  AS type,
            pp.numero,
            pp.semaine,
            pp.no_commande,
            pp.no_poste,
            pe.semaine_engagee AS semaine_engagement,
            pp.prete,
            CASE pe.status
                WHEN 'fait'         THEN 'Fait'
                WHEN 'en cours'     THEN 'En cours'
                WHEN 'annulé'       THEN 'Annulé'
                WHEN 'reporté'      THEN 'Reporté'
                WHEN 'engagé'       THEN 'Engagé'
                WHEN 'prévisionnel' THEN 'Prévisionnel'
                ELSE 'Prévisionnel'
            END AS status,
            pe.updated_at
            FROM realisations pp
            JOIN articles pa ON pa.id  = pp.article_id
            JOIN type_sous_ensembles ptse ON ptse.id = pp.type_sous_ensemble_id
            LEFT JOIN (
                SELECT e1.*
                FROM engagements e1
             JOIN (
                SELECT realisation_id, MAX(updated_at) AS max_updated
                FROM engagements
                GROUP BY realisation_id
                ) last ON last.realisation_id = e1.realisation_id
                AND last.max_updated = e1.updated_at
            ) pe ON pe.realisation_id = pp.id;
        ");
    }

    public function down(): void
    {
        DB::unprepared('DROP VIEW IF EXISTS vue_realisations;');
    }
};
