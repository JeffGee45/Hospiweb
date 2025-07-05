<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // Mettre à jour les rôles existants
        DB::table('users')
            ->where('role', 'Medecin')
            ->update(['role' => 'Médecin']);
            
        DB::table('users')
            ->where('role', 'Secretaire')
            ->update(['role' => 'Secrétaire']);
            
        // Modifier la colonne role pour utiliser les nouveaux noms
        DB::statement("ALTER TABLE users MODIFY COLUMN role ENUM('Admin', 'Médecin', 'Infirmier', 'Secrétaire', 'Caissier', 'Patient') NOT NULL DEFAULT 'Patient'");
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Rétablir les anciens noms de rôles
        DB::table('users')
            ->where('role', 'Médecin')
            ->update(['role' => 'Medecin']);
            
        DB::table('users')
            ->where('role', 'Secrétaire')
            ->update(['role' => 'Secretaire']);
            
        // Rétablir la colonne role avec les anciens noms
        DB::statement("ALTER TABLE users MODIFY COLUMN role ENUM('Admin', 'Medecin', 'Infirmier', 'Secretaire', 'Caissier', 'Patient') NOT NULL DEFAULT 'Patient'");
    }
};
