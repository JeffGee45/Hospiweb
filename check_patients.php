<?php

require __DIR__.'/vendor/autoload.php';

$app = require_once __DIR__.'/bootstrap/app.php';

$kernel = $app->make(Illware_Console_Kernel::class);

$app->boot();

use Illuminate\Support\Facades\DB;

try {
    // Vérifier la structure de la colonne statut
    echo "Vérification de la colonne statut...\n";
    $column = DB::select("SHOW COLUMNS FROM patients WHERE Field = 'statut'");
    echo "Type de colonne : " . $column[0]->Type . "\n";
    
    // Compter les patients par statut
    echo "\nNombre de patients par statut :\n";
    $stats = DB::select("SELECT statut, COUNT(*) as count FROM patients GROUP BY statut");
    foreach ($stats as $stat) {
        echo "- " . $stat->statut . ": " . $stat->count . " patients\n";
    }
    
    // Afficher quelques exemples
    echo "\nExemples de patients :\n";
    $patients = DB::select("SELECT id, nom, prenom, statut FROM patients LIMIT 5");
    foreach ($patients as $patient) {
        echo "#" . $patient->id . " " . $patient->prenom . " " . $patient->nom . " - Statut: " . $patient->statut . "\n";
    }
    
} catch (Exception $e) {
    echo "Erreur : " . $e->getMessage() . "\n";
}
