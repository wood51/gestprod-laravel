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
        Schema::create('articles', function (Blueprint $table) {
            $table->id();

            $table->string('reference')->unique();

            // clé étrangère
            $table->foreignId('type_sous_ensemble_id')
                ->constrained('type_sous_ensembles');

            $table->string('couleur', 7)->default('#90EE90');
            $table->float('coefficient')->default('1');
            $table->string('commentaire')->nullable();


            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('articles');
    }
};
