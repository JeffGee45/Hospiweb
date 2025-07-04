<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        // Drop old tables if they exist to ensure a clean slate
        Schema::dropIfExists('patients');

        Schema::create('patients', function (Blueprint $table) {
            $table->id();
            $table->string('nom');
            $table->string('prenom');
            $table->string('email')->unique()->nullable();
            $table->string('numero_dossier')->unique();
            $table->date('date_naissance');
            $table->string('lieu_naissance')->nullable();
            $table->string('sexe');
            $table->text('adresse')->nullable();
            $table->string('telephone')->nullable();
            $table->string('profession')->nullable();
            $table->string('groupe_sanguin', 5)->nullable();
            $table->json('allergies')->nullable();
            $table->json('antecedents_medicaux')->nullable();
            $table->json('traitements_en_cours')->nullable();
            $table->string('nom_contact_urgence')->nullable();
            $table->string('telephone_contact_urgence')->nullable();
            $table->string('lien_contact_urgence')->nullable();
            $table->text('notes')->nullable();
            $table->enum('statut', ['actif', 'inactif', 'décédé'])->default('actif');
            $table->timestamps();
            $table->softDeletes();
        });
    }

    public function down()
    {
        Schema::dropIfExists('patients');
    }
};
