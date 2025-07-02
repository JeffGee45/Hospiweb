<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::dropIfExists('hospitalisations');

        Schema::create('hospitalisations', function (Blueprint $table) {
            $table->id();
            $table->string('numero_dossier')->unique();
            $table->foreignId('patient_id')->constrained('patients')->onDelete('cascade');
            $table->foreignId('medecin_id')->constrained('users')->onDelete('cascade');
            $table->foreignId('chambre_id')->nullable()->constrained('chambres')->onDelete('set null');
            $table->foreignId('lit_id')->nullable()->constrained('lits')->onDelete('set null');
            $table->foreignId('assureur_id')->nullable()->constrained('assureurs')->onDelete('set null');

            $table->dateTime('date_admission');
            $table->dateTime('date_sortie_prevue')->nullable();
            $table->dateTime('date_sortie_reelle')->nullable();
            $table->string('mode_entree'); // Urgences, Consultation, Transfert
            $table->string('mode_sortie')->nullable(); // Domicile, Transfert, Décès
            $table->text('motif_admission');
            $table->text('diagnostic_entree');
            $table->text('diagnostic_sortie')->nullable();
            $table->string('statut'); // En cours, Sorti, Annulée
            $table->boolean('est_urgence')->default(false);
            $table->boolean('prise_en_charge_assurance')->default(false);
            $table->string('nom_accompagnant')->nullable();
            $table->string('telephone_accompagnant')->nullable();

            $table->decimal('montant_total_estime', 15, 2)->nullable();
            $table->decimal('montant_avance', 15, 2)->default(0.00);
            $table->decimal('montant_restant_a_payer', 15, 2)->nullable();

            $table->text('notes')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    public function down()
    {
        Schema::dropIfExists('hospitalisations');
    }
};
