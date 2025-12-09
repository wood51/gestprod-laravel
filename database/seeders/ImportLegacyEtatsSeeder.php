<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class ImportLegacyEtatsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {

        $oldDB = DB::connection('mysql_old')
            ->table('etats')
            ->get();

        Schema::disableForeignKeyConstraints();

        DB::table('etats')->truncate();

        foreach ($oldDB as $r) {
            DB::table('etats')->insert((array) $r);
        }

        Schema::enableForeignKeyConstraints();
    }
}