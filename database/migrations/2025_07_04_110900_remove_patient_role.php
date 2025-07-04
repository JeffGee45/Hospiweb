<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        // Mettre à jour les utilisateurs avec le rôle Patient vers Secrétaire (ou un autre rôle par défaut)
        DB::table('users')
            ->where('role', 'Patient')
            ->update(['role' => 'Secrétaire']);

        // Créer une nouvelle colonne temporaire
        Schema::table('users', function (Blueprint $table) {
            $table->enum('role_temp', 
                ['Admin', 'Médecin', 'Infirmier', 'Secrétaire', 'Pharmacien', 'Caissier']
            )->default('Secrétaire');
        });

        // Copier les données
        DB::table('users')->update([
            'role_temp' => DB::raw('role')
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
        // Recréer l'ancienne colonne avec le rôle Patient
        Schema::table('users', function (Blueprint $table) {
            $table->enum('role_temp', 
                ['Admin', 'Médecin', 'Infirmier', 'Secrétaire', 'Pharmacien', 'Caissier', 'Patient']
            )->default('Secrétaire');
        });

        // Copier les données
        DB::table('users')->update([
            'role_temp' => DB::raw('role')
        ]);

        // Supprimer la colonne actuelle
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn('role');
        });

        // Renommer la colonne
        Schema::table('users', function (Blueprint $table) {
            $table->renameColumn('role_temp', 'role');
        });
    }
};
