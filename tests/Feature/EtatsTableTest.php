<?php

namespace Tests\Feature;

use App\Models\Etat;
use Illuminate\Database\QueryException;
use Illuminate\Foundation\Testing\RefreshDatabase;

use Tests\TestCase;


class EtatsTableTest extends TestCase
{
    use RefreshDatabase;

    public function test_creation()
    {
        Etat::create([
            'libelle' => 'En Attente',
        ]);
        $this->assertDatabaseCount('etats', 1);
    }

    public function test_libelle_unique()
    {
        Etat::create([
            'libelle' => 'En Attente',
        ]);
        $this->assertDatabaseCount('etats', 1);
        try {
            Etat::create([
                'libelle' => 'En Attente',
            ]);
            $this->fail('le doublon de libelle aurait dû lever une exception.');
        } catch (QueryException $e) {
            $this->assertDatabaseCount('etats', 1);
        }

    }
}
