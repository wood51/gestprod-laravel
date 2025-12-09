<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class ImportLegacyTypeEnsembleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $old_planning = DB::connection('mysql_old')
        ->table('prod_type_ensemble')
        ->get();

        Schema::disableForeignKeyConstraints();
        
        DB::table('type_ensembles')->truncate();

        foreach($old_planning as $r) {
            DB::table('type_ensembles')->insert([
                'id' => $r->id,
                'type_sous_ensemble_id' => $r->fk_type_sous_ensemble,
                'libelle' => $r->libelle,
                'ordre_affichage' =>$r->ordre_affichage,
            ]);
        }
        Schema::enableForeignKeyConstraints();
    }
}
