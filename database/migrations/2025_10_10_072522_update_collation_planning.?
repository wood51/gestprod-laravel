<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        $db = config('database.connections.mysql.database');

        // Sécu: aligne la session pendant la migration
        DB::statement("SET NAMES 'utf8mb4' COLLATE 'utf8mb4_unicode_ci'");
        DB::statement("SET collation_connection = 'utf8mb4_unicode_ci'");

        // Renommer la vue principale en base si besoin
        $existsMain = (int) DB::selectOne("
            SELECT COUNT(*) AS c FROM information_schema.VIEWS
            WHERE TABLE_SCHEMA = ? AND TABLE_NAME = 'vue_plannings'
        ", [$db])->c;

        $existsBase = (int) DB::selectOne("
            SELECT COUNT(*) AS c FROM information_schema.VIEWS
            WHERE TABLE_SCHEMA = ? AND TABLE_NAME = 'vue_plannings_base'
        ", [$db])->c;

        if ($existsMain && !$existsBase) {
            // RENAME TABLE marche aussi pour les vues
            DB::statement("RENAME TABLE `vue_plannings` TO `vue_plannings_base`");
        }

        // Récupère les colonnes de la vue de base
        $cols = DB::select("
            SELECT COLUMN_NAME, DATA_TYPE, COLLATION_NAME
            FROM information_schema.COLUMNS
            WHERE TABLE_SCHEMA = ? AND TABLE_NAME = 'vue_plannings_base'
            ORDER BY ORDINAL_POSITION
        ", [$db]);

        if (empty($cols)) {
            throw new RuntimeException("vue_plannings_base introuvable ou sans colonnes.");
        }

        // Construit la liste de sélection en forçant la collation sur les colonnes texte
        $select = [];
        foreach ($cols as $c) {
            $name = $c->COLUMN_NAME;
            $type = strtolower($c->DATA_TYPE);
            $isText =
                in_array($type, ['char','varchar','text','tinytext','mediumtext','longtext','enum','set']);

            if ($isText) {
                $select[] = "CONVERT(vp.`{$name}` USING utf8mb4) COLLATE utf8mb4_unicode_ci AS `{$name}`";
            } else {
                $select[] = "vp.`{$name}`";
            }
        }
        $selectList = implode(",\n       ", $select);

        // Recrée la vue principale en wrapper collaté
        DB::unprepared("
            CREATE OR REPLACE VIEW `vue_plannings` AS
            SELECT
               {$selectList}
            FROM `vue_plannings_base` vp
        ");
    }

    public function down(): void
    {
        $db = config('database.connections.mysql.database');

        // Supprime la vue wrapper
        DB::statement("DROP VIEW IF EXISTS `vue_plannings`");

        // Si la base existe, on la remet au nom d'origine
        $existsBase = (int) DB::selectOne("
            SELECT COUNT(*) AS c FROM information_schema.VIEWS
            WHERE TABLE_SCHEMA = ? AND TABLE_NAME = 'vue_plannings_base'
        ", [$db])->c;

        if ($existsBase) {
            DB::statement("RENAME TABLE `vue_plannings_base` TO `vue_plannings`");
        }
    }
};
