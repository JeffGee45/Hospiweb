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
        Schema::create('ordonnances', function (Blueprint $table) {
            $table->id();
            $table->string('code')->unique();
            $table->foreignId('patient_id')->constrained('patients')->onDelete('cascade');
            $table->foreignId('medecin_id')->constrained('users')->onDelete('cascade');
            $table->foreignId('consultation_id')->nullable()->constrained('consultations')->onDelete('set null');
            $table->foreignId('hospitalisation_id')->nullable()->constrained('hospitalisations')->onDelete('set null');
            $table->date('date_prescription');
            $table->string('type_ordonnance'); // Traitement, Examen, etc.
            $table->string('statut'); // Délivrée, Partiellement délivrée, Non délivrée
            $table->text('instructions_generales')->nullable();
            $table->date('date_debut_traitement')->nullable();
            $table->date('date_fin_traitement')->nullable();
            $table->boolean('renouvelable')->default(false);
            $table->integer('nombre_renouvellements')->default(0);
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('ordonnances');
    }
};
