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
        Schema::table('users', function (Blueprint $table) {
            $table->enum('role', ['Admin', 'Medecin', 'Infirmier', 'Secretaire', 'Caissier', 'Pharmacien'])->default('Secretaire')->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->enum('role', ['Admin', 'Medecin', 'Infirmier', 'Secretaire', 'Caissier', 'Patient'])->default('Patient')->change();
        });
    }
};
