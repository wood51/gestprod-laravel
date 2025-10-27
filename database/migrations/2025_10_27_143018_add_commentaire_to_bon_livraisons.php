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
            $table->string('commentaire_interne')->nullable()->default(null);
            $table->string('commentaire_bl')->nullable()->default(null);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('bon_livraisons', function (Blueprint $table) {
            $table->dropColumn('commentaire_interne');
            $table->dropColumn('commentaire_bl');
        });
    }
};
