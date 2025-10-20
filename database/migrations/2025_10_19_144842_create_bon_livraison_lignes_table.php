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
        Schema::create('bon_livraison_lignes', function (Blueprint $table) {
            $table->id(); // -> num de BL
            /*
            planning_id
            type -> pour switcher style de bl 
            numero_meta -> snaspot nuuméro
            article_ref
            article designation
            pa
            poste
            

            */
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('bon_livraison_lignes');
    }
};
