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
        Schema::create('bon_livraison_lignes', function (Blueprint $table) {
            $table->id();
            $table->foreignId('bon_livraison_id')->constrained('bon_livraisons');

            // Création des FK nullable a part car pb Mariadb mode strict
            $table->unsignedBigInteger('realisation_id')->nullable();
            $table->foreign('realisation_id')->references('id')->on('realisations');

            $table->json('numero_meta')->nullable(); // numero_meta figer pour les collone du bl (je farais l'extraction direct)
            $table->string('article_ref')->nullable();
            $table->string('article_designation')->nullable();
            $table->integer('quantite')->nullable();
            $table->string('no_commande')->nullable();
            $table->string('no_poste')->nullable();
            $table->timestamps();

            $table->index('no_commande');
            $table->index('no_poste');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('bon_livraison_lignes');
    }
};
