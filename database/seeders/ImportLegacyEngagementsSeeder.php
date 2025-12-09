<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class ImportLegacyEngagementsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $oldDB = DB::connection('mysql_old')
            ->table('prod_engagement')
            ->get();

        Schema::disableForeignKeyConstraints();

        DB::table('engagements')->truncate();

        foreach ($oldDB as $r) {
            DB::table('engagements')->insert([
                'id'=>$r->id,
                'realisation_id'=>$r->fk_planning,
                'semaine_engagee'=>$r->semaine_engagee,
                'status'=>$r->status,
                'commentaire'=>$r->commentaire
            ]);
        }

        Schema::enableForeignKeyConstraints();
    }
}
