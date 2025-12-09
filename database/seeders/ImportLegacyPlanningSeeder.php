<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class ImportLegacyPlanningSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $old_planning = DB::connection('mysql_old')
        ->table('prod_planning')
        ->get();

        Schema::disableForeignKeyConstraints();
        
        DB::table('realisations')->truncate();

        foreach($old_planning as $r) {
            DB::table('realisations')->insert([
                'id' => $r->id,
                'article_id' => $r->fk_article,
                'type_sous_ensemble_id' => $r->fk_article,
                'numero' => $r->numero,
                'numero_meta' => null,
                'no_commande' => null,
                'no_poste' => null,
                'semaine' => $r->semaine,
                'engagement' => $r->engagement,
                'commentaire' =>$r->commentaire,
                'prete' =>$r->prete,
            ]);
        }
        Schema::enableForeignKeyConstraints();
    }
}
