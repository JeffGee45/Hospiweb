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
        Schema::create('medicament_ordonnances', function (Blueprint $table) {
            $table->id();
            $table->foreignId('ordonnance_id')->constrained()->onDelete('cascade');
            $table->string('nom');
            $table->string('posologie');
            $table->string('duree');
            $table->text('instructions')->nullable();
            $table->timestamps();

            // Index pour améliorer les performances des requêtes
            $table->index('ordonnance_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('medicament_ordonnances');
    }
};
