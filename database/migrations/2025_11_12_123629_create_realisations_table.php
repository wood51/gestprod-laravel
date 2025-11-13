<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Eloquent\SoftDeletes;

return new class extends Migration
{
    use SoftDeletes;
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('realisations', function (Blueprint $table) {
            $table->id();
            $table->foreignId('article_id')->constrained('articles');
            $table->foreignId('type_sous_ensemble_id')->constrained('type_sous_ensembles');
            $table->unsignedInteger('numero')->nullable();
            $table->string('semaine',7);
            $table->string('engagement',7);
            $table->string('no_commande')->nullable();
            $table->string('no_poste')->nullable();
            $table->string('commentaire')->nullable();
            $table->boolean('prete')->default(0);
            $table->timestamps();
            $table->softDeletes();

              $table->unique(['article_id', 'numero']);
        });

        Schema::table('realisations', function (Blueprint $table) {
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
        Schema::dropIfExists('realisation');
    }
};
