<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

class NormalizeRoles extends Migration
{
    /**
     * Exécute les migrations.
     */
    public function up()
    {
        // Remplacer 'Medecin' par 'Médecin' dans la table users
        DB::table('users')
            ->where('role', 'Medecin')
            ->update(['role' => 'Médecin']);
            
        // Mettre à jour les rôles dans la table users pour qu'ils correspondent aux valeurs autorisées
        $rolesValides = ['Admin', 'Médecin', 'Infirmier', 'Secrétaire', 'Pharmacien', 'Caissier'];
        DB::table('users')
            ->whereNotIn('role', $rolesValides)
            ->update(['role' => 'Secrétaire']); // Valeur par défaut pour les rôles non valides
    }

    /**
     * Annule les migrations.
     */
    public function down()
    {
        // Pas de rollback nécessaire car on ne peut pas déterminer avec certitude
        // quelle était la valeur d'origine
    }
}
