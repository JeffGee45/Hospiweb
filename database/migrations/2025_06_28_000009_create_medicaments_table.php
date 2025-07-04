<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('medicaments', function (Blueprint $table) {
            $table->id();
            $table->string('code_interne')->unique()->nullable();
            $table->string('dci')->comment('Dénomination Commune Internationale');
            $table->string('nom_commercial');
            $table->string('forme_pharmaceutique'); // Comprimé, Sirop, Gélule, etc.
            $table->string('dosage');
            $table->string('fabricant')->nullable();
            $table->string('fournisseur')->nullable();
            $table->text('description')->nullable();
            $table->decimal('prix_unitaire', 10, 2);
            $table->integer('quantite_en_stock')->default(0);
            $table->integer('seuil_alerte_stock')->default(10);
            $table->date('date_peremption');
            $table->string('numero_lot')->nullable();
            $table->string('emplacement_stockage')->nullable();
            $table->string('unite_mesure'); // boite, flacon, etc.
            $table->boolean('est_actif')->default(true);
            $table->timestamps();
            $table->softDeletes();
        });
    }

    public function down()
    {
        Schema::dropIfExists('medicaments');
    }
};
