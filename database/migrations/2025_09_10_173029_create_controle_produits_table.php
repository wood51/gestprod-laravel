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
        Schema::create('controle_produits', function (Blueprint $table) {
            $table->id();
            $table->foreignId('realisation_id')->constrained('realisations');
            $table->foreignId('etat_id')->constrained('etats');
            $table->boolean('hasDefaut')->default(0);
            $table->string('commentaire')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('controle_produits');
    }
};
