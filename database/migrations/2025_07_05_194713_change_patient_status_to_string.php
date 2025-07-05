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
        // Changer le type de colonne en chaîne de caractères
        DB::statement("ALTER TABLE patients MODIFY COLUMN statut VARCHAR(20) NOT NULL");
        
        // Mettre à jour les valeurs
        DB::table('patients')
            ->where('statut', 'actif')
            ->update(['statut' => 'guéri']);
            
        DB::table('patients')
            ->where('statut', 'inactif')
            ->update(['statut' => 'malade']);
            
        // Convertir à nouveau en ENUM avec les nouvelles valeurs
        DB::statement("ALTER TABLE patients MODIFY COLUMN statut ENUM('guéri', 'malade', 'décédé') NOT NULL DEFAULT 'malade'");
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Changer le type de colonne en chaîne de caractères
        DB::statement("ALTER TABLE patients MODIFY COLUMN statut VARCHAR(20) NOT NULL");
        
        // Rétablir les anciennes valeurs
        DB::table('patients')
            ->where('statut', 'guéri')
            ->update(['statut' => 'actif']);
            
        DB::table('patients')
            ->where('statut', 'malade')
            ->update(['statut' => 'inactif']);
            
        // Revenir à l'ancien type ENUM
        DB::statement("ALTER TABLE patients MODIFY COLUMN statut ENUM('actif', 'inactif', 'décédé') NOT NULL DEFAULT 'inactif'");
    }
};
