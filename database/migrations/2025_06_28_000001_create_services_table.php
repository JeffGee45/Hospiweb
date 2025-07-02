<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        if (!Schema::hasTable('services')) {
            Schema::create('services', function (Blueprint $table) {
                $table->id();
                $table->string('code')->unique()->nullable();
                $table->string('nom');
                $table->text('description')->nullable();
                $table->foreignId('chef_service_id')->nullable()->constrained('users')->onDelete('set null');
                $table->string('batiment')->nullable();
                $table->string('etage')->nullable();
                $table->boolean('est_actif')->default(true);
                $table->timestamps();
                $table->softDeletes();
            });
        }
    }

    public function down()
    {
        Schema::dropIfExists('services');
    }
};
