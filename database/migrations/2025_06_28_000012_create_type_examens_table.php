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
        Schema::create('type_examens', function (Blueprint $table) {
            $table->id();
            $table->string('code', 20)->unique();
            $table->string('nom');
            $table->text('description')->nullable();
            $table->string('categorie')->default('biologie');
            $table->boolean('est_actif')->default(true);
            $table->decimal('prix', 10, 2)->default(0);
            $table->integer('duree_moyenne')->default(30)->comment('Durée en minutes');
            $table->text('preparation_requise')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('type_examens');
    }
};
