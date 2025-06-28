<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::dropIfExists('paiements');

        Schema::create('paiements', function (Blueprint $table) {
            $table->id();
            $table->string('code_paiement')->unique();
            $table->foreignId('facture_id')->constrained('factures')->onDelete('cascade');
            $table->foreignId('patient_id')->constrained('patients')->onDelete('cascade');
            $table->foreignId('caissier_id')->nullable()->constrained('users')->onDelete('set null');

            $table->dateTime('date_paiement');
            $table->decimal('montant', 15, 2);
            $table->string('methode_paiement'); // 'Espèces', 'Carte de crédit', 'Virement', 'Assurance'
            $table->string('statut'); // 'Validé', 'En attente', 'Annulé'
            $table->string('reference_externe')->nullable();
            $table->text('notes')->nullable();

            $table->timestamps();
            $table->softDeletes();
        });
    }

    public function down()
    {
        Schema::dropIfExists('paiements');
    }
};
