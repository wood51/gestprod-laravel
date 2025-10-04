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
        Schema::create('defaut_produits', function (Blueprint $table) {
            $table->id();
            $table->foreignId('controle_produit_id')->constrained('controle_produits');
            $table->foreignId('type_sous_ensemble_id')->constrained('type_sous_ensembles');
            $table->foreignId('catalogue_defaut_id')->constrained('catalogue_defauts');
            $table->foreignId('user_id')->constrained('users');
            $table->string('commentaire')->nullable();
            $table->dateTime('date');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('defaut_produits');
    }
};
