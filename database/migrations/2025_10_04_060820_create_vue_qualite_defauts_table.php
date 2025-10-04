<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        DB::statement("
        select
	        `cp`.`id` AS `controle_id`,
	        `cp`.`created_at` AS `date_controle`,
	        (
	        select
		        `gd`.`libelle`
	        from
		        `defaut_produits` `qd`
	        join `catalogue_defauts` `cd` on
		        `qd`.`catalogue_defaut_id` = `cd`.`id`
	        join `gravite_defauts` `gd` on
		        `cd`.`gravite_id` = `gd`.`id`
	        where
		        `qd`.`controle_produit_id` = `cp`.`id`
	        order by
		        `gd`.`poids` desc
	        limit 1
            ) AS `gravite`
        from
	        `controle_produits` `cp`
        order by
	        `cp`.`id`
    ");
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        DB::statement("DROP VIEW IF EXISTS vue_qualite_defauts");
    }
};
