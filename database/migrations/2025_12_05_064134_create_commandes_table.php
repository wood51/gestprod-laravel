<?php

// database/migrations/2025_12_04_000000_create_commandes_table.php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('commandes', function (Blueprint $table) {
            $table->id();

            $table->string('client')->nullable();      
            $table->string('pa');                    

            $table->date('date_commande')->nullable(); // date du mail ou du PDF
            $table->string('status', 20)->default('open'); // open / closed / cancelled

            $table->timestamps();

            $table->unique('pa');                   
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('commandes');
    }
};
