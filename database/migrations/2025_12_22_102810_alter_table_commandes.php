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
        Schema::table('commandes', function (Blueprint $table) {
            $table->string('acheteur')->after('id');
            $table->string('source_file')->after('client');
            $table->string('file_hash')->nullable()->after('source_file');
            $table->boolean('is_avenant')->nullable()->after('file_hash');
        });

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('commandes', function (Blueprint $table) {
            $table->dropColumns([
                'acheteur',
                'source_file',
                'file_hash',
                'is_avenant'
            ]);
        });
    }
};
