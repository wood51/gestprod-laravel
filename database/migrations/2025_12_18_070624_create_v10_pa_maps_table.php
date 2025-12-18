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
        Schema::create('v10_pa_maps', function (Blueprint $table) {
            $table->id();
            $table->foreignId('realisation_id')->constrained('realisations');
            $table->string('pa_4031')->nullable();
            $table->string('poste_4031')->nullable();
            $table->string('pa_403')->nullable();
            $table->string('poste_403')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('v10_pa_maps');
    }
};
