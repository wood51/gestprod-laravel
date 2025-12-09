<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class ImportLegacyArticleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $oldDB = DB::connection('mysql_old')
            ->table('prod_articles')
            ->get();

        Schema::disableForeignKeyConstraints();

        DB::table('articles')->truncate();

        foreach ($oldDB as $r) {
            DB::table('articles')->insert([
                'id' => $r->id,
                'reference' => $r->reference,
                'type_sous_ensemble_id' => $r->fk_type_sous_ensemble,
                'couleur' => $r->couleur,
                'coefficient' => $r->coefficient,
                'commentaire' => $r->commentaire,
            ]);
        }
        Schema::enableForeignKeyConstraints();
    }
}
