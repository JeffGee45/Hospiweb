<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

class UpdateRoleEnum extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        // Mettre à jour les rôles existants
        DB::table('users')
            ->where('role', 'Medecin')
            ->update(['role' => 'Médecin']);
            
        // Modifier la colonne role pour utiliser le nouvel enum
        DB::statement("ALTER TABLE users MODIFY COLUMN role ENUM('Admin', 'Médecin', 'Infirmier', 'Secrétaire', 'Caissier', 'Pharmacien') NOT NULL DEFAULT 'Secrétaire'");
    }

    /**
     * Reverse the migrations.
     */
    public function down()
    {
        // Revenir à l'ancien enum
        DB::table('users')
            ->where('role', 'Médecin')
            ->update(['role' => 'Medecin']);
            
        DB::statement("ALTER TABLE users MODIFY COLUMN role ENUM('Admin', 'Medecin', 'Infirmier', 'Secretaire', 'Caissier', 'Pharmacien') NOT NULL DEFAULT 'Secretaire'");
    }
};
