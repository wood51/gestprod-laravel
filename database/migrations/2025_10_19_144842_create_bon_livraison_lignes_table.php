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
            $table->foreignId('planning_id')->constrained('plannings')->nullable();  
            $table->foreignId('type_sous_ensemble_id')->constrained('type_sous_ensembles')->nullable(); 
            $table->json('numero_meta'); // numero_meta figer pour les collone du bl (je farais l'extraction direct)
            $table->string('article_ref');
            $table->string('article_designation');
            $table->string('no_commande');
            $table->string('poste');
            $table->timestamps();

            $table->index('no_commande');
            $table->index('poste');
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
