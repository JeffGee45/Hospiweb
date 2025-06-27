<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        if (!Schema::hasTable('assureurs')) {
            Schema::create('assureurs', function (Blueprint $table) {
                $table->id();
                $table->string('nom_compagnie');
                $table->string('code_assureur')->unique()->nullable();
                $table->string('adresse')->nullable();
                $table->string('telephone')->nullable();
                $table->string('email')->nullable();
                $table->string('contact_principal')->nullable();
                $table->decimal('taux_couverture_par_defaut', 5, 2)->default(0.00);
                $table->decimal('plafond_remboursement', 15, 2)->nullable();
                $table->text('notes')->nullable();
                $table->boolean('est_actif')->default(true);
                $table->timestamps();
                $table->softDeletes();
            });
        }
    }

    public function down()
    {
        Schema::dropIfExists('assureurs');
    }
};
