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
        Schema::create('type_ensembles', function (Blueprint $table) {
            $table->id();
            $table->foreignId('type_sous_ensemble_id')->constrained('type_sous_ensembles');
            $table->string('libelle');
            $table->integer('ordre_affichage');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('type_ensembles');
    }
};
