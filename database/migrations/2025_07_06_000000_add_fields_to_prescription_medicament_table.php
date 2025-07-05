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
        Schema::table('prescription_medicament', function (Blueprint $table) {
            $table->string('nom_medicament')->after('medicament_id')->nullable();
            $table->string('dosage')->after('nom_medicament');
            $table->string('duree')->after('dosage');
            $table->string('frequence')->after('duree_traitement');
            $table->text('instructions')->after('quantite')->nullable();
            
            // Renommer les champs existants pour correspondre au modèle
            $table->renameColumn('posologie', 'posologie_details');
            $table->renameColumn('duree_traitement', 'duree_jours');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('prescription_medicament', function (Blueprint $table) {
            $table->dropColumn(['nom_medicament', 'dosage', 'duree', 'frequence', 'instructions']);
            $table->renameColumn('posologie_details', 'posologie');
            $table->renameColumn('duree_jours', 'duree_traitement');
        });
    }
};
