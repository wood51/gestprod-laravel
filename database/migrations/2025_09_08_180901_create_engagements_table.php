<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('engagements', function (Blueprint $table) {
            $table->id();
            $table->foreignId('planning_id')->constrained('plannings');
            $table->string('semaine_engagee', 7)->nullable();
            $table->enum('status', ['prévisionnel', 'engagé', 'reporté', 'annulé', 'en cours', 'fait', 'retour client'])->default('prévisionnel');
            $table->string('commentaire')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('engagements');
    }
};
