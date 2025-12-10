<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class ImportLegacyTypeSousEnsembleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {

        $oldDB = DB::connection('mysql_old')
            ->table('prod_type_sous_ensemble')
            ->get();

        Schema::disableForeignKeyConstraints();

        DB::table('type_sous_ensembles')->truncate();

        foreach ($oldDB as $r) {
            DB::table('type_sous_ensembles')->insert((array) $r);
        }

        Schema::enableForeignKeyConstraints();
    }
}