<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;


class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call([
            UserSeeder::class,
            ImportLegacyArticleSeeder::class,
            ImportLegacyAtelierFermetureSeeder::class,
            ImportLegacyAtelierPresenceSeeder::class,
            ImportLegacyEngagementsSeeder::class,
            ImportLegacyEtatsSeeder::class,
            ImportLegacyPlanningSeeder::class,
            ImportLegacyTypeEnsembleSeeder::class,
            ImportLegacyTypeSousEnsembleSeeder::class,
            ImportLegacyCatalogueDefautSeeder::class,
            ImportLegacyControleProduitSeeder::class,
            ImportLegacyGraviteDefautSeeder::class,
            ImportLegacyDefautSeeder::class
        ]);
    }
}
