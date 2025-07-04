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
        Schema::create('observations', function (Blueprint $table) {
            $table->id();
            $table->foreignId('patient_id')->constrained()->onDelete('cascade');
            $table->foreignId('infirmier_id')->constrained('users')->onDelete('cascade');
            $table->date('date_observation');
            $table->time('heure_observation');
            $table->string('type_observation');
            $table->string('valeur');
            $table->string('unite')->nullable();
            $table->text('commentaire')->nullable();
            $table->boolean('est_urgent')->default(false);
            $table->timestamps();
            
            // Index pour les recherches fréquentes
            $table->index(['patient_id', 'date_observation']);
            $table->index('type_observation');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('observations');
    }
};
