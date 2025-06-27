<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::dropIfExists('consultations');

        Schema::create('consultations', function (Blueprint $table) {
            $table->id();
            $table->foreignId('patient_id')->constrained('patients')->onDelete('cascade');
            $table->foreignId('medecin_id')->constrained('users')->onDelete('cascade');
            $table->foreignId('rendez_vous_id')->nullable()->constrained('rendez_vouses')->onDelete('set null');
            $table->dateTime('date_consultation');
            $table->string('type_consultation')->default('Standard');
            $table->text('motif')->nullable();
            $table->decimal('poids', 5, 2)->nullable();
            $table->decimal('taille', 5, 2)->nullable(); 
            $table->decimal('temperature', 4, 1)->nullable();
            $table->string('tension_arterielle')->nullable();
            $table->unsignedInteger('frequence_cardiaque')->nullable();
            $table->unsignedInteger('frequence_respiratoire')->nullable();
            $table->unsignedInteger('saturation_oxygene')->nullable();
            $table->text('examen_clinique')->nullable();
            $table->text('diagnostic')->nullable();
            $table->text('traitement_propose')->nullable();
            $table->text('notes_medecin')->nullable();
            $table->string('statut')->default('Planifiée');
            $table->timestamps();
            $table->softDeletes();
        });
    }

    public function down()
    {
        Schema::dropIfExists('consultations');
    }
};
