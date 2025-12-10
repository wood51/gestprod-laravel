<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class ImportLegacyControleProduitSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $old_planning = DB::connection('mysql_old')
        ->table('qualite_controles')
        ->get();

        Schema::disableForeignKeyConstraints();
        
        DB::table('controle_produits')->truncate();

        foreach($old_planning as $r) {
            DB::table('controle_produits')->insert([
                'id' => $r->id,
                'realisation_id' => $r->fk_planning,
                'etat_id' => $r->fk_etat,
                'hasDefaut' =>$r->hasDefaut,
                'commentaire' =>$r->commentaire,
                'created_at' =>$r->date_controle,
                'updated_at' =>$r->date_controle,
            ]);
        }
        Schema::enableForeignKeyConstraints();
    }
}