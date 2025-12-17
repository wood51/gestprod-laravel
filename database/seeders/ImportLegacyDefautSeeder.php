<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class ImportLegacyDefautSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $old_planning = DB::connection('mysql_old')
        ->table('qualite_defauts')
        ->get();

        Schema::disableForeignKeyConstraints();
        
        DB::table('defaut_produits')->truncate();

        foreach($old_planning as $r) {
            DB::table('defaut_produits')->insert([
                'id' => $r->id,
                'controle_produit_id' => $r->fk_controle,
                'type_sous_ensemble_id' => $r->fk_type_sous_ensemble,
                'catalogue_defaut_id' => $r->fk_catalogue_defaut,
                'user_id' => $r->fk_user,
                'commentaire' => $r->commentaire,
                'date' => $r->date
            ]);
        }
        Schema::enableForeignKeyConstraints();
    }
}
