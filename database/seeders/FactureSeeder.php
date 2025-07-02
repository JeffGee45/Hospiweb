<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;
class FactureSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        $patients = \App\Models\Patient::take(5)->get();
        $caissier = \App\Models\User::where('role', 'Caissier')->first();

        foreach ($patients as $patient) {
            \App\Models\Facture::create([
                'patient_id' => $patient->id,
                'user_id' => $caissier->id,
                'numero_facture' => 'FACT-' . now()->format('Ymd') . '-' . strtoupper(Str::random(6)),
                'date_emission' => now(),
                'date_echeance' => now()->addDays(30),
                'statut' => collect(['brouillon', 'émise', 'payée'])->random(),
                'montant_ht' => $montant = rand(50, 1000),
                'tva' => 20.00,
                'montant_ttc' => $montant * 1.2,
                'notes' => 'Facture pour consultation et soins'
            ]);
        }
    }
      
}
