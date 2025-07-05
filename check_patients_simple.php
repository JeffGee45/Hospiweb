<?php

require __DIR__.'/vendor/autoload.php';
$app = require_once __DIR__.'/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use Illuminate\Support\Facades\DB;

// Vérifier la structure de la colonne statut
echo "Vérification de la colonne statut...\n";
$column = DB::select("SHOW COLUMNS FROM patients WHERE Field = 'statut'");
print_r($column);

// Afficher quelques exemples
echo "\nExemples de patients :\n";
$patients = DB::select("SELECT id, nom, prenom, statut FROM patients LIMIT 5");
foreach ($patients as $patient) {
    echo "#" . $patient->id . " " . $patient->prenom . " " . $patient->nom . " - Statut: " . $patient->statut . "\n";
}
