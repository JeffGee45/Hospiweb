<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        // Créer une nouvelle colonne temporaire
        Schema::table('users', function (Blueprint $table) {
            $table->enum('role_temp', 
                ['Admin', 'Médecin', 'Infirmier', 'Secrétaire', 'Pharmacien', 'Caissier', 'Patient']
            )->default('Patient');
        });

        // Copier les données
        DB::table('users')->update([
            'role_temp' => DB::raw('CASE 
                WHEN role = "Medecin" THEN "Médecin"
                WHEN role = "Secretaire" THEN "Secrétaire"
                ELSE role 
            END')
        ]);

        // Supprimer l'ancienne colonne
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn('role');
        });

        // Renommer la nouvelle colonne
        Schema::table('users', function (Blueprint $table) {
            $table->renameColumn('role_temp', 'role');
        });
    }

    public function down()
    {
        // Créer une nouvelle colonne temporaire
        Schema::table('users', function (Blueprint $table) {
            $table->enum('role_temp', 
                ['Admin', 'Medecin', 'Infirmier', 'Secretaire', 'Pharmacien', 'Caissier', 'Patient']
            )->default('Patient');
        });

        // Copier les données
        DB::table('users')->update([
            'role_temp' => DB::raw('CASE 
                WHEN role = "Médecin" THEN "Medecin"
                WHEN role = "Secrétaire" THEN "Secretaire"
                ELSE role 
            END')
        ]);

        // Supprimer l'ancienne colonne
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn('role');
        });

        // Renommer la nouvelle colonne
        Schema::table('users', function (Blueprint $table) {
            $table->renameColumn('role_temp', 'role');
        });
    }
};
