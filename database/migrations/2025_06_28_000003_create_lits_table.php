<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        if (!Schema::hasTable('lits')) {
            Schema::create('lits', function (Blueprint $table) {
                $table->id();
                $table->foreignId('chambre_id')->constrained('chambres')->onDelete('cascade');
                $table->string('numero')->nullable();
                $table->string('code')->unique();
                $table->string('type_lit')->nullable();
                $table->boolean('est_occupe')->default(false);
                $table->boolean('est_en_nettoyage')->default(false);
                $table->boolean('est_hors_service')->default(false);
                $table->timestamp('dernier_nettoyage')->nullable();
                $table->timestamp('prochain_nettoyage')->nullable();
                $table->text('notes')->nullable();
                $table->timestamps();
                $table->softDeletes();
            });
        }
    }

    public function down()
    {
        Schema::dropIfExists('lits');
    }
};
