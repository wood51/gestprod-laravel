<?php

namespace Tests\Feature;

use App\Models\TypeSousEnsemble;
use Illuminate\Database\QueryException;
use Illuminate\Foundation\Testing\RefreshDatabase;

use Tests\TestCase;

class TypeSousEnsemblesTableTest extends TestCase
{
    use RefreshDatabase;

    public function test_creation()
    {
        TypeSousEnsemble::create([
            'designation' => 'Rotor',
        ]);

        $this->assertDatabaseCount('type_sous_ensembles', 1);

    }

    public function test_designation_unique()
    {

        // 1er OK
        TypeSousEnsemble::create([
            'designation' => 'Rotor',
        ]);

        $this->assertDatabaseCount('type_sous_ensembles', 1);
        // 2eme -> Exception
        try {
            TypeSousEnsemble::create([
                'designation' => 'Rotor',
            ]);
            $this->fail('Le doublon de designation aurait dû lever une exception.');
        } catch (QueryException $e) {
            $this->assertDatabaseCount('type_sous_ensembles', 1);
        }


    }
}
