<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        if (!Schema::hasTable('chambres')) {
            Schema::create('chambres', function (Blueprint $table) {
                $table->id();
                $table->string('numero');
                $table->string('etage')->nullable();
                $table->string('batiment')->nullable();
                $table->foreignId('service_id')->constrained('services')->onDelete('cascade');
                $table->string('type_chambre');
                $table->string('categorie_tarifaire')->nullable();
                $table->decimal('prix_journalier', 10, 2)->nullable();
                $table->unsignedInteger('nombre_lits')->default(1);
                $table->unsignedInteger('lits_disponibles')->default(1);
                $table->json('equipements')->nullable();
                $table->boolean('est_occupee')->default(false);
                $table->boolean('est_en_nettoyage')->default(false);
                $table->boolean('est_hors_service')->default(false);
                $table->text('description')->nullable();
                $table->timestamps();
                $table->softDeletes();
            });
        }
    }

    public function down()
    {
        Schema::dropIfExists('chambres');
    }
};
