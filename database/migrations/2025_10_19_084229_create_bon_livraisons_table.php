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
        Schema::create('bon_livraisons', function (Blueprint $table) {
            $table->id();
            $table->enum('state',['draft','validated','canceled'])->default('draft');
            $table->timestamp('validated_at')->nullable();
            $table->timestamp('canceled_at')->nullable();
            $table->foreignId('created_by')->constrained('users'); 

            // Création des FK nullable a part car pb Mariadb mode strict
            $table->unsignedBigInteger('validated_by')->nullable(); 
            $table->unsignedBigInteger('canceled_by')->nullable(); 
            $table->foreign('validated_by')->references('id')->on('users');
            $table->foreign('canceled_by')->references('id')->on('users');
            
            $table->timestamps();
            $table->index(['state','created_at']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('bon_livraisons');
    }
};
