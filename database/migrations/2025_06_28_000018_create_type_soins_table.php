<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::dropIfExists('type_soins');

        Schema::create('type_soins', function (Blueprint $table) {
            $table->id();
            $table->string('code')->unique()->nullable();
            $table->string('nom');
            $table->text('description')->nullable();
            $table->string('categorie');
            $table->integer('duree_moyenne')->nullable()->comment('en minutes');
            $table->decimal('prix', 10, 2)->nullable();
            $table->json('materiel_necessaire')->nullable();
            $table->json('competences_requises')->nullable();
            $table->boolean('est_actif')->default(true);
            $table->timestamps();
            $table->softDeletes();
        });
    }

    public function down()
    {
        Schema::dropIfExists('type_soins');
    }
};
