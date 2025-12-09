<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class ImportLegacyAtelierFermetureSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {

        $oldDB = DB::connection('mysql_old')
            ->table('atelier_fermetures')
            ->get();

        Schema::disableForeignKeyConstraints();

        DB::table('fermeture_ateliers')->truncate();

        foreach ($oldDB as $r) {
            DB::table('fermeture_ateliers')->insert((array) $r);
        }

        Schema::enableForeignKeyConstraints();
    }
}
