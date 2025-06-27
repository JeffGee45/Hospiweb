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
        if (!Schema::hasTable('rendez_vouses')) {
            Schema::create('rendez_vouses', function (Blueprint $table) {
                $table->id();
                $table->foreignId('patient_id')->constrained();
                $table->foreignId('medecin_id')->constrained('users');
                $table->dateTime('date_heure');
                $table->text('motif')->nullable();
                $table->string('statut')->default('planifie');
                $table->timestamps();
            });
        } else {
            Schema::table('rendez_vouses', function (Blueprint $table) {
                $columns = [
                    'patient_id' => fn() => $table->foreignId('patient_id')->constrained(),
                    'medecin_id' => fn() => $table->foreignId('medecin_id')->constrained('users'),
                    'date_heure' => fn() => $table->dateTime('date_heure'),
                    'motif' => fn() => $table->text('motif')->nullable(),
                    'statut' => fn() => $table->string('statut')->default('planifie')
                ];

                foreach ($columns as $column => $callback) {
                    if (!Schema::hasColumn('rendez_vouses', $column)) {
                        $callback();
                    }
                }
            });
        }
    }

    public function down()
    {
        Schema::dropIfExists('rendez_vouses');
    }

    };
