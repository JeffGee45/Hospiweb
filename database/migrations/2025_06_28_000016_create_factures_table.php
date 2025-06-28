<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::dropIfExists('factures');

        Schema::create('factures', function (Blueprint $table) {
            $table->id();
            $table->string('numero_facture')->unique();
            $table->foreignId('patient_id')->constrained('patients')->onDelete('cascade');
            $table->foreignId('consultation_id')->nullable()->constrained('consultations')->onDelete('set null');
            $table->foreignId('hospitalisation_id')->nullable()->constrained('hospitalisations')->onDelete('set null');
            $table->foreignId('caissier_id')->nullable()->constrained('users')->onDelete('set null');

            $table->date('date_facturation');
            $table->date('date_echeance')->nullable();
            $table->decimal('montant_total', 15, 2);
            $table->decimal('montant_paye', 15, 2)->default(0.00);
            $table->decimal('montant_restant', 15, 2);
            $table->string('statut'); // 'Brouillon', 'Envoyée', 'Payée', 'Partiellement payée', 'Annulée'
            $table->string('type_facture'); // 'Consultation', 'Hospitalisation', 'Examens', 'Autres'
            $table->text('notes')->nullable();
            $table->json('lignes_facture')->nullable();

            $table->timestamps();
            $table->softDeletes();
        });
    }

    public function down()
    {
        Schema::dropIfExists('factures');
    }
};
