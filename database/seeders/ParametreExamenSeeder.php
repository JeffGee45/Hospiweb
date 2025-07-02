<?php

namespace Database\Seeders;

use App\Models\ParametreExamen;
use App\Models\TypeExamen;
use Illuminate\Database\Seeder;

class ParametreExamenSeeder extends Seeder
{
    public function run()
    {
        // Désactiver les événements pour améliorer les performances
        ParametreExamen::withoutEvents(function () {
            // Récupérer les types d'examens
            $nfs = TypeExamen::where('code', 'NFS')->first();
            $gly = TypeExamen::where('code', 'GLY')->first();
            $ecbu = TypeExamen::where('code', 'ECBU')->first();

            // Paramètres pour la NFS
            if ($nfs) {
                $parametresNFS = [
                    [
                        'code' => 'GB',
                        'nom' => 'Globules Blancs',
                        'unite_mesure' => 'G/L',
                        'valeur_normale_min' => 4,
                        'valeur_normale_max' => 10,
                        'est_actif' => true,
                    ],
                    [
                        'code' => 'GR',
                        'nom' => 'Globules Rouges',
                        'unite_mesure' => 'T/L',
                        'valeur_normale_min' => 4.2,
                        'valeur_normale_max' => 5.7,
                        'est_actif' => true,
                    ],
                    [
                        'code' => 'HB',
                        'nom' => 'Hémoglobine',
                        'unite_mesure' => 'g/dL',
                        'valeur_normale_min' => 12,
                        'valeur_normale_max' => 16,
                        'est_actif' => true,
                    ],
                ];

                foreach ($parametresNFS as $param) {
                    $nfs->parametres()->create($param);
                }
            }

            // Paramètre pour la Glycémie
            if ($gly) {
                $gly->parametres()->create([
                    'code' => 'GLY',
                    'nom' => 'Glycémie à jeun',
                    'unite_mesure' => 'g/L',
                    'valeur_normale_min' => 0.7,
                    'valeur_normale_max' => 1.1,
                    'est_actif' => true,
                ]);
            }

            // Paramètres pour l'ECBU
            if ($ecbu) {
                $parametresECBU = [
                    [
                        'code' => 'LEU',
                        'nom' => 'Leucocytes',
                        'unite_mesure' => 'éléments/μL',
                        'valeur_normale_min' => 0,
                        'valeur_normale_max' => 10,
                        'est_actif' => true,
                    ],
                    [
                        'code' => 'NIT',
                        'nom' => 'Nitrites',
                        'unite_mesure' => null,
                        'valeur_normale_min' => null,
                        'valeur_normale_max' => null,
                        'est_actif' => true,
                    ],
                ];

                foreach ($parametresECBU as $param) {
                    $ecbu->parametres()->create($param);
                }
            }
        });
    }
}
