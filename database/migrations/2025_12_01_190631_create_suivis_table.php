<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('suivis', function (Blueprint $table) {
            $table->id();

            // modèle : AS250M150V3 → lié à ta table articles
            $table->foreignId('article_id')
                ->constrained('articles')
                ->cascadeOnDelete();

            // n° individuel : 6589
            $table->string('numero_produit');

            // ex : 'bobinage_stator', plus tard 'impregnation', etc.
            $table->string('operation');

            // opérateur : null tant que personne n’a pris le dossier
            $table->foreignId('operator_id')
                ->nullable()
                ->constrained('users')
                ->cascadeOnDelete();

            // 'attente' à la création, puis 'en_cours', puis 'termine'
            $table->string('etat')->default('attente');

            $table->dateTime('started_at')->nullable();
            $table->dateTime('ended_at')->nullable();

            $table->timestamps();

            // un même produit ne peut avoir qu’un suivi par opération
            $table->unique(['article_id', 'numero_produit', 'operation']);

            $table->index(['etat']);
            $table->index(['operation']);
            $table->index(['operator_id']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('suivis');
    }
};
