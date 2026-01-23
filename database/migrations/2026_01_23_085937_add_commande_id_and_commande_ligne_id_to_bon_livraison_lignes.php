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
        Schema::table('bon_livraison_lignes', function (Blueprint $table) {
            $table->integer('poste_main')->nullable()->after('no_poste');
            $table->integer('poste_sub')->nullable()->after('poste_main');


            $table->foreignId('commande_id')->nullable()->after('poste_sub')
                ->constrained('commandes')->nullOnDelete();
            $table->unsignedBigInteger('commande_ligne_id')->nullable()->after('commande_id');
            $table->foreign('commande_ligne_id')->references('id')->on('commande_lignes')->nullOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('bon_livraison_lignes', function (Blueprint $table) {

            $table->dropForeign(['commande_id']);
            $table->dropForeign(['commande_ligne_id']);
            $table->dropColumn(['commande_id', 'commande_ligne_id', 'poste_main', 'poste_sub']);
        });
    }
};
