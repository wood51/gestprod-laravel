<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Database\QueryException;

use App\Models\Article;
use App\Models\TypeSousEnsemble;

use Tests\TestCase;

class ArticlesTableTest extends TestCase
{
    use RefreshDatabase;

    public function test_creation(): void
    {
        $type = TypeSousEnsemble::create(['designation' => 'Rotor']);

        Article::create([
            'reference' => 'ART001',
            'type_sous_ensemble_id' => $type->id,
        ]);

        $this->assertDatabaseCount('articles', 1);
        $this->assertDatabaseHas('articles', ['reference' => 'ART001']);
    }

    public function test_reference_unique(): void
    {
        $type = TypeSousEnsemble::create(['designation' => 'Rotor']);

        // 1er insert OK
        Article::create([
            'reference' => 'ART001',
            'type_sous_ensemble_id' => $type->id,
        ]);
        $this->assertDatabaseCount('articles', 1);

        // 2e insert (doublon) doit échouer
        try {
            Article::create([
                'reference' => 'ART001',
                'type_sous_ensemble_id' => $type->id,
            ]);
            $this->fail('Le doublon de référence aurait dû lever une exception.');
        } catch (QueryException $e) {
            // Rien n’a été inséré en plus
            $this->assertDatabaseCount('articles', 1);
        }
    }

    public function test_fk(): void
    {
        // aucun insert initial
        $this->assertDatabaseCount('articles', 0);

        try {
            Article::create([
                'reference' => 'ART002',
                'type_sous_ensemble_id' => 99, // FK inexistante
            ]);
            $this->fail('Une FK invalide aurait dû lever une exception.');
        } catch (QueryException $e) {
            $this->assertDatabaseCount('articles', 0);
        }
    }



}
