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
        Schema::table('bon_livraisons', function (Blueprint $table) {
            $table->unsignedBigInteger('type_sous_ensemble_id')->nullable()->default(null)->after('id');
            $table->foreign('type_sous_ensemble_id')->references('id')->on('type_sous_ensembles');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('bon_livraisons', function (Blueprint $table) {
            $table->dropColumn('type_sous_ensemble_id');
        });
    }
};
