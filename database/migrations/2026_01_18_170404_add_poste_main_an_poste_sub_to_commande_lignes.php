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
        Schema::table('commande_lignes', function (Blueprint $table) {
            $table->unsignedInteger('poste_main')->nullable();
            $table->unsignedInteger('poste_sub')->nullable()->default(0);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('commande_lignes', function (Blueprint $table) {
            $table->dropColumn('poste_main','poste_sub');
        });
    }
};
