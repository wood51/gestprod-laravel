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
            // 1) drop FK (la forme la plus sûre)
            $table->dropForeign(['article_id']);
        });

        Schema::table('commande_lignes', function (Blueprint $table) {
            // 2) rendre nullable si tu veux (nécessite doctrine/dbal)
            // $table->unsignedBigInteger('article_id')->nullable()->change();

            // 3) nouvelle colonne
            $table->string('code_article')->nullable()->after('article_id');
        });

        // 4) si tu veux remettre une FK nullable ensuite (optionnel)
        Schema::table('commande_lignes', function (Blueprint $table) {
            $table->foreign('article_id')->references('id')->on('articles');
        });
    }


    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('commande_lignes', function (Blueprint $table) {
            $table->dropColumn([
                'code_article'
            ]);
        });
    }
};
