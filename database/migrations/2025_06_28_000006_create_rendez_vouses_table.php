<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::dropIfExists('rendez_vouses');

        Schema::create('rendez_vouses', function (Blueprint $table) {
            $table->id();
            $table->foreignId('patient_id')->constrained('patients')->onDelete('cascade');
            $table->foreignId('medecin_id')->constrained('users')->onDelete('cascade');
            $table->foreignId('secretaire_id')->nullable()->constrained('users')->onDelete('set null');
            $table->dateTime('date_rendez_vous');
            $table->unsignedInteger('duree_estimee')->nullable()->comment('en minutes');
            $table->string('type_rendez_vous')->default('Consultation');
            $table->string('statut')->default('Programmé');
            $table->text('motif')->nullable();
            $table->text('notes')->nullable();
            $table->boolean('rappels_envoyes')->default(false);
            $table->string('source_demande')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    public function down()
    {
        Schema::dropIfExists('rendez_vouses');
    }
};
