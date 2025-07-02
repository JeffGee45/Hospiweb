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
        Schema::create('parametre_examens', function (Blueprint $table) {
            $table->id();
            $table->string('code', 20);
            $table->string('nom');
            $table->string('unite_mesure', 20)->nullable();
            $table->decimal('valeur_normale_min', 10, 2)->nullable();
            $table->decimal('valeur_normale_max', 10, 2)->nullable();
            $table->text('description')->nullable();
            $table->boolean('est_actif')->default(true);
            $table->foreignId('type_examen_id')->constrained('type_examens')->onDelete('cascade');
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('parametre_examens');
    }
};
