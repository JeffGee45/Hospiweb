<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::dropIfExists('affectation_lits');

        Schema::create('affectation_lits', function (Blueprint $table) {
            $table->id();
            $table->foreignId('lit_id')->constrained('lits')->onDelete('cascade');
            $table->foreignId('patient_id')->constrained('patients')->onDelete('cascade');
            $table->foreignId('hospitalisation_id')->constrained('hospitalisations')->onDelete('cascade');
            $table->foreignId('user_id')->comment('Utilisateur qui a effectué l\'affectation')->constrained('users')->onDelete('cascade');

            $table->dateTime('date_debut');
            $table->dateTime('date_fin')->nullable();
            $table->string('motif_affectation')->nullable();
            $table->string('motif_liberation')->nullable();
            $table->string('statut'); // actif, termine, annule
            $table->text('notes')->nullable();

            $table->timestamps();
            $table->softDeletes();
        });
    }

    public function down()
    {
        Schema::dropIfExists('affectation_lits');
    }
};
