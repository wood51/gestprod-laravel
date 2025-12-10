<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class ImportLegacyCatalogueDefautSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $oldDB = DB::connection('mysql_old')
            ->table('qualite_catalogue_defauts')
            ->get();

        Schema::disableForeignKeyConstraints();

        DB::table('catalogue_defauts')->truncate();

        foreach ($oldDB as $r) {
            DB::table('catalogue_defauts')->insert([
                'id'=>$r->id,
                'mot_cle'=>$r->mot_cle,
                'type_sous_ensemble_id'=>$r->fk_type_sous_ensemble,
                'categorie_defaut'=>$r->fk_categorie_defaut===1 ? "Electrique":"Mécanique",
                'gravite_defaut_id'=>$r->fk_gravite,
                'description'=>$r->description
            ]);
        }

        Schema::enableForeignKeyConstraints();
    }
}
