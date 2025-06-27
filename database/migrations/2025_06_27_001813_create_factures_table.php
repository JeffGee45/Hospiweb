<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::create('factures', function (Blueprint $table) {
            $table->id();
            $table->foreignId('patient_id')->constrained();
            $table->foreignId('user_id')->constrained(); // Caissier qui a créé la facture
            $table->string('numero_facture')->unique();
            $table->date('date_emission');
            $table->date('date_echeance')->nullable();
            $table->enum('statut', ['brouillon', 'émise', 'payée', 'en_retard', 'annulée'])->default('brouillon');
            $table->decimal('montant_ht', 10, 2);
            $table->decimal('tva', 5, 2)->default(20.00);
            $table->decimal('montant_ttc', 10, 2);
            $table->text('notes')->nullable();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('factures');
    }


};
