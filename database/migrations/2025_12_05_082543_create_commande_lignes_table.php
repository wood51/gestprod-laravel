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
        Schema::create('commande_lignes', function (Blueprint $table) {
            $table->id();

            $table->foreignId('commande_id')
                ->constrained('commandes')
                ->cascadeOnUpdate()
                ->cascadeOnDelete();

            $table->foreignId('article_id')
                ->constrained()
                ->cascadeOnUpdate()
                ->restrictOnDelete();

            $table->foreignId('type_sous_ensemble_id')
                ->constrained()
                ->cascadeOnUpdate()
                ->restrictOnDelete();

            // Poste tel que le client l’écrit : "1", "2", "1.1", "1.2", etc.
            $table->string('poste_client', 20);

            // Quantités
            $table->unsignedInteger('qte_commandee')->default(1);
            $table->unsignedInteger('qte_livree')->default(0);

            // Dates par poste
            $table->date('date_client')->nullable();   // "Date demandée"
            $table->date('date_ajustee')->nullable();  // "DATE AJUSTEE" / due

            // Statut de la ligne : avenants, livraisons partielles, etc.
            $table->string('status', 20)->default('open'); // open / partial / closed / cancelled

            $table->timestamps();

            // Pour les recherches courantes
            $table->index(['commande_id', 'status']);
            $table->index('poste_client');

            $table->unique(['commande_id', 'poste_client']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('commande_lignes');
    }
};
