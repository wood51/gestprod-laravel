<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('presences', function (Blueprint $table) {
            $table->id();
            $table->integer('nb_operateurs');
            $table->float('nb_heures_normales')->default(8.75);
            $table->float('nb_heures_supp')->default(0);
            $table->dateTime('date_jour')->default(DB::raw('CURRENT_TIMESTAMP'));
            $table->boolean('heures_supp')->default(0);
            $table->string('commentaire')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('presences');
    }
};
