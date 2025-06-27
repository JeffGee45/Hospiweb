<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::dropIfExists('resultat_examens');

        Schema::create('resultat_examens', function (Blueprint $table) {
            $table->id();
            $table->foreignId('examen_medical_id')->constrained('examen_medicals')->onDelete('cascade');
            $table->foreignId('parametre_examen_id')->constrained('parametre_examens')->onDelete('cascade');
            $table->foreignId('technicien_id')->nullable()->constrained('users')->onDelete('set null');
            $table->foreignId('medecin_validateur_id')->nullable()->constrained('users')->onDelete('set null');

            $table->string('valeur');
            $table->string('unite_mesure');
            $table->string('statut_valeur'); // Normale, Anormale, Critique
            $table->text('interpretation')->nullable();
            $table->dateTime('date_validation')->nullable();
            $table->text('commentaires')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    public function down()
    {
        Schema::dropIfExists('resultat_examens');
    }
};
