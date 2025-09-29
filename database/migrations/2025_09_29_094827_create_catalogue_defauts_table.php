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
        Schema::create('catalogue_defauts', function (Blueprint $table) {
            $table->id();
            $table->string('mot_cle');
            $table->foreignId('type_sous_ensemble_id')->constrained('type_sous_ensembles');
            $table->enum('categorie_defaut',['Electrique','Mécanique']);
            $table->foreignId('gravite_id')->constrained('gravite_defauts');
            $table->string('description')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('catalogue_defauts');
    }
};
