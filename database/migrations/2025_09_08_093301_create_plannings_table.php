<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Eloquent\SoftDeletes;

return new class extends Migration
{
    use SoftDeletes;
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('plannings', function (Blueprint $table) {
            $table->id();
            $table->foreignId('article_id')->constrained('articles');
            $table->foreignId('type_sous_ensemble_id')->constrained('type_sous_ensembles');
            $table->unsignedInteger('numero')->nullable();
            $table->string('semaine',7);
            $table->string('engagement',7);
            $table->string('commentaire')->nullable();
            $table->boolean('prete')->default(0);
            $table->timestamps();
            $table->softDeletes();

              $table->unique(['article_id', 'numero']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('plannings');
    }
};
