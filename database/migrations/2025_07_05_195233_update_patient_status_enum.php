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
        // Modifier la colonne statut pour utiliser les nouvelles valeurs
        DB::statement("ALTER TABLE patients MODIFY COLUMN statut ENUM('guéri', 'malade', 'décédé') NOT NULL DEFAULT 'malade'");
        
        // Mettre à jour les valeurs existantes
        DB::table('patients')
            ->where('statut', 'actif')
            ->update(['statut' => 'guéri']);
            
        DB::table('patients')
            ->where('statut', 'inactif')
            ->update(['statut' => 'malade']);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Rétablir les anciennes valeurs si nécessaire
        DB::table('patients')
            ->where('statut', 'guéri')
            ->update(['statut' => 'actif']);
            
        DB::table('patients')
            ->where('statut', 'malade')
            ->update(['statut' => 'inactif']);
            
        // Revenir à l'ancien type ENUM
        DB::statement("ALTER TABLE patients MODIFY COLUMN statut ENUM('actif', 'inactif', 'décédé') NOT NULL DEFAULT 'actif'");
    }
};
