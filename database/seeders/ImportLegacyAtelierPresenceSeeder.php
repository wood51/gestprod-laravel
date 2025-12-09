<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class ImportLegacyAtelierPresenceSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {

        $oldDB = DB::connection('mysql_old')
            ->table('atelier_presence')
            ->get();

        Schema::disableForeignKeyConstraints();

        DB::table('presences')->truncate();

        foreach ($oldDB as $r) {
            DB::table('presences')->insert((array) $r);
        }

        Schema::enableForeignKeyConstraints();
    }
}
