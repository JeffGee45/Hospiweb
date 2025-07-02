<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::dropIfExists('soin_infirmiers');

        Schema::create('soin_infirmiers', function (Blueprint $table) {
            $table->id();
            $table->foreignId('hospitalisation_id')->constrained('hospitalisations')->onDelete('cascade');
            $table->foreignId('patient_id')->constrained('patients')->onDelete('cascade');
            $table->foreignId('infirmier_id')->constrained('users')->onDelete('cascade');
            $table->foreignId('type_soin_id')->constrained('type_soins')->onDelete('cascade');

            $table->date('date_soin');
            $table->time('heure_soin');
            $table->text('observations')->nullable();
            $table->text('resultat')->nullable();
            $table->string('statut'); // planifié, effectué, annulé, reporté
            $table->json('medicaments_administres')->nullable();
            $table->json('materiel_utilise')->nullable();
            $table->integer('duree_soin')->nullable()->comment('en minutes');
            $table->text('signature_infirmier')->nullable();

            $table->timestamps();
            $table->softDeletes();
        });
    }

    public function down()
    {
        Schema::dropIfExists('soin_infirmiers');
    }
};
