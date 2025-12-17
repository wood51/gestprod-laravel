<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class ImportLegacyGraviteDefautSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {

        $oldDB = DB::connection('mysql_old')
            ->table('qualite_gravite_defaut')
            ->get();

        Schema::disableForeignKeyConstraints();

        DB::table('gravite_defauts')->truncate();

        foreach ($oldDB as $r) {
            DB::table('gravite_defauts')->insert((array) $r);
        }

        Schema::enableForeignKeyConstraints();
    }
}