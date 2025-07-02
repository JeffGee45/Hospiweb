<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // Mettre à jour le rôle 'Medecin' en 'Médecin' dans la table users
        DB::table('users')
            ->where('role', 'Medecin')
            ->update(['role' => 'Médecin']);
            
        // Mettre à jour le type enum de la colonne role
        DB::statement("ALTER TABLE users MODIFY COLUMN role ENUM('Admin', 'Médecin', 'Infirmier', 'Secretaire', 'Caissier', 'Pharmacien') NOT NULL DEFAULT 'Secretaire'");
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Remettre à jour le rôle 'Médecin' en 'Medecin' dans la table users
        DB::table('users')
            ->where('role', 'Médecin')
            ->update(['role' => 'Medecin']);
            
        // Rétablir le type enum d'origine
        DB::statement("ALTER TABLE users MODIFY COLUMN role ENUM('Admin', 'Medecin', 'Infirmier', 'Secretaire', 'Caissier', 'Pharmacien') NOT NULL DEFAULT 'Secretaire'");
    }
};
