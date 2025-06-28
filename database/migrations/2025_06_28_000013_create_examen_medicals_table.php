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
        Schema::create('examen_medicals', function (Blueprint $table) {
            $table->id();
            $table->foreignId('patient_id')->constrained()->onDelete('cascade');
            $table->foreignId('medecin_id')->constrained('users')->onDelete('cascade');
            $table->foreignId('consultation_id')->nullable()->constrained()->onDelete('set null');
            $table->foreignId('type_examen_id')->constrained('type_examens')->onDelete('cascade');
            $table->date('date_demande');
            $table->date('date_realisation')->nullable();
            $table->string('statut')->default('demandé'); // demandé, réalisé, annulé
            $table->text('resultats')->nullable();
            $table->text('conclusion')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('examen_medicals');
    }
};
