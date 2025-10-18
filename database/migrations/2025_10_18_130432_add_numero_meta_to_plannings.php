<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('plannings', function (Blueprint $table) {
            $table->json('numero_meta')->nullable()->after('numero');

            $table->string('num_machine')->virtualAs("json_unquote(json_extract(`numero_meta`, '$.machine'))")->nullable();
            $table->string('num_rotor')->virtualAs("json_unquote(json_extract(`numero_meta`, '$.rotor'))")->nullable();
            $table->string('num_stator')->virtualAs("json_unquote(json_extract(`numero_meta`, '$.stator'))")->nullable();
            $table->string('num_palier')->virtualAs("json_unquote(json_extract(`numero_meta`, '$.palier'))")->nullable();
            $table->string('num_comp_haut')->virtualAs("json_unquote(json_extract(`numero_meta`, '$.compresseur.haut'))")->nullable();
            $table->string('num_comp_bas')->virtualAs("json_unquote(json_extract(`numero_meta`, '$.compresseur.bas'))")->nullable();
            $table->string('num_redresseur')->virtualAs("json_unquote(json_extract(`numero_meta`, '$.redresseur.serie'))")->nullable();

            // Index pratique pour recherche
            $table->index('num_machine');
            $table->index('num_comp_haut');
            $table->index('num_comp_bas');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('plannings', function (Blueprint $table) {
             $table->dropColumn([
                'numero_meta',
                'num_machine',
                'num_rotor',
                'num_stator',
                'num_palier',
                'num_comp_haut',
                'num_comp_bas',
                'num_redresseur',
            ]);
        });
    }
};
