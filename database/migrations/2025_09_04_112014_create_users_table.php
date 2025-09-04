<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Eloquent\SoftDeletes;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('nom');
            $table->string('prenom');
            $table->string('username')->unique()->index();
            $table->string('password');
            $table->enum('role', ['admin', 'user', 'hse'])->default('user');
            $table->enum('site', [
                '1AB',
                '1C',
                '2',
                '4(5B)',
                '5/6/9',
                '7/8',
                'SAV Atelier',
                'SAV',
                'Usine'
            ])->index();
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('users');
    }
};
