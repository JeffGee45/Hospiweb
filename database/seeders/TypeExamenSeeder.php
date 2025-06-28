<?php

namespace Database\Seeders;

use App\Models\TypeExamen;
use Illuminate\Database\Seeder;

class TypeExamenSeeder extends Seeder
{
    public function run()
    {
        // Désactiver les événements pour améliorer les performances
        TypeExamen::withoutEvents(function () {
            // Créer des types d'examens
            $types = [
                [
                    'code' => 'NFS',
                    'nom' => 'Numération Formule Sanguine',
                    'description' => 'Analyse complète des cellules sanguines',
                    'categorie' => 'biologie',
                    'est_actif' => true,
                    'prix' => 5000,
                    'duree_moyenne' => 30,
                    'preparation_requise' => 'À jeun recommandé',
                ],
                [
                    'code' => 'GLY',
                    'nom' => 'Glycémie',
                    'description' => 'Dosage du glucose sanguin',
                    'categorie' => 'biologie',
                    'est_actif' => true,
                    'prix' => 1500,
                    'duree_moyenne' => 15,
                    'preparation_requise' => 'À jeun obligatoire',
                ],
                [
                    'code' => 'ECBU',
                    'nom' => 'Examen Cyto-Bactériologique des Urines',
                    'description' => 'Analyse des urines',
                    'categorie' => 'biologie',
                    'est_actif' => true,
                    'prix' => 2500,
                    'duree_moyenne' => 20,
                    'preparation_requise' => 'Première urine du matin',
                ],
            ];

            foreach ($types as $type) {
                TypeExamen::create($type);
            }
        });
    }
}
